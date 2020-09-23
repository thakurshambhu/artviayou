<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
/** All Paypal Details class **/
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use Illuminate\Support\Facades\Auth;
use PayPal\Rest\ApiContext;
use Redirect;
use Session;
use URL;
use Exception;
use App\Repository\ArtworkRepository;
use App\Repository\UserRepository;
use App\Repository\SiteSettingRepository;
use App\Repository\OrderRepository;
use App\Repository\ShippingAddressRepository;
use App\Repository\SavedArtworkRepository;
use App\Repository\VariantRepository;
use Mail;
use App\Mail\AdminSaleNotification;
use App\Mail\SaleNotification;
use App\Mail\SellerNotification;
use App\Mail\ShippingNotification;
use PHPUnit\TextUI\ResultPrinter;

class PaymentController extends Controller
{
    private $_api_context;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ArtworkRepository $artworkRepository, SiteSettingRepository $siteSettingRepository, UserRepository $userRepository, OrderRepository $orderRepository, ShippingAddressRepository $shippingAddressRepository, SavedArtworkRepository $savedArtworkRepository, VariantRepository $variantRepository)
    {
        /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
        $this->artworkRepository = $artworkRepository;
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->siteSettingRepository = $siteSettingRepository;
        $this->shippingAddressRepository = $shippingAddressRepository;
        $this->savedArtworkRepository = $savedArtworkRepository;
        $this->variantRepository = $variantRepository;
    }
    public function index()
    {
        return view('paywithpaypal');
    }
    public function payWithpaypal(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all()); die;
        Session::put('artwork_id', $request->artwork_arr);
        $artwork_name = "";
        $price = 0;
        if(count($request->artwork_arr) > 0){
            foreach($request->artwork_arr as $key => $artwork_id){
                $artwork = $this->artworkRepository->getData(['id'=> $artwork_id],'first',['variants'],0);
                if($key == 0){
                    $artwork_name .= Auth::user()->id.'_'.$artwork->title;
                }else{
                    $artwork_name .= ','.$artwork->title;
                }
                $price = $price + $artwork->variants[0]->price + $artwork->variants[0]->worldwide_shipping_charge;
            }
        }
        $description = time().'_'.$artwork_name;
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $item_1 = new Item();
        $item_1->setName($artwork_name) /** item name **/
            ->setCurrency('GBP')
            ->setQuantity(1)
            ->setPrice($price); /** unit price **/
        $item_list = new ItemList();
        $item_list->setItems(array($item_1));
        $amount = new Amount();
        $amount->setCurrency('GBP')
            ->setTotal($price);
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription($description);
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::to('status')) /** Specify return URL **/
            ->setCancelUrl(URL::to('status'));
        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        /** dd($payment->create($this->_api_context));exit; **/
        try {

            $address['first_name'] = $request->first_name;
            $address['last_name'] = $request->last_name;
            $address['address'] = $request->address;
            $address['country'] = $request->country;
            $address['state'] = $request->state;
            $address['postal_code'] = $request->postal_code;
            $shipping_address = $this->shippingAddressRepository->createUpdateData(['id'=> 0],$address);
            Session::put('address_id', $shipping_address->id);

            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                \Session::put('error', 'Connection timeout');
                return Redirect::to('cart');
            } else {
                \Session::put('error', 'Some error occur, sorry for inconvenient');
                return Redirect::to('cart');
            }
        }
        
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        /** add payment ID to session **/
        Session::put('paypal_payment_id', $payment->getId());
        if (isset($redirect_url)) {
            /** redirect to paypal **/


            return Redirect::away($redirect_url);
        }
        \Session::put('error', 'Unknown error occurred');
        return Redirect::to('cart');
    }
    public function getPaymentStatus()
    {
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');
        // dd($payment_id);
        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            \Session::put('error', 'Payment failed');
            return Redirect::to('cart');
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        // echo "<pre>";
        // print_r($payment); die("BKL");
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));
        /**Execute the payment **/
        $order_info = [];
        $result = $payment->execute($execution, $this->_api_context);
        if ($result->getState() == 'approved') {
            $artwork_id = Session::get('artwork_id');
            $artwork_info = "";
            $buyer_info = $this->userRepository->getData(['id'=> Auth::user()->id],'first',[],0);
            $artwork_name = "";
            if(count($artwork_id) > 0){
                foreach ($artwork_id as $key => $artwork) {
                    $order = [];
                    $artwork_result = $this->artworkRepository->getData(['id'=> $artwork],'first',['artwork_images', 'variants', 'artist', 'category_detail', 'sub_category_detail','style_detail', 'subject_detail'],0);
                    $url = url('artwork_details').'/'.$artwork_result->id;
                    if($artwork_name == ""){
                        $artwork_name .= '<a href="'.$url.'">'.$artwork_result->title.'</a>';
                    }else{
                        $artwork_name .= ', <a href="'.$url.'">'.$artwork_result->title.'</a>';
                    }

                    $site_setting = $this->siteSettingRepository->getData([],'first',[],0);
                    $artist_payment = $artwork_result->variants[0]->price;
                    $admin_commission = ($site_setting->commission_persentage / 100) * $artist_payment;
                    if(!empty($site_setting->commission_persentage)){
                        $artist_payment = $artist_payment * ((100-$site_setting->commission_persentage) / 100);
                    }


                    $order['artwork_info'] = json_encode($artwork_result);
                    $order['user_id'] = Auth::user()->id;
                    $order['artist_payment'] = $artist_payment;
                    $order['admin_commission'] = $admin_commission;
                    $order['artwork_id'] = $artwork;
                    $order['artist_id'] = $artwork_result->user_id;
                    $order['payment_id'] = $result->getId();
                    $order['status'] = $result->getState();
                    $order['paypal_response'] = $result;
                    $user_info = $this->userRepository->getData(['id'=> Auth::user()->id],'first',[],0);
                    $order['delivery_address'] = $user_info->address.', '.$user_info->city.', '.$user_info->state.', '.$user_info->country.', '.$user_info->postal_code;
                    $order_info = $this->orderRepository->createUpdateData(['id'=> 0],$order);

                    $address['order_id'] = $order_info->id;
                    $shipping_address = $this->shippingAddressRepository->createUpdateData(['id'=> Session::get('address_id')],$address);
                    Session::forget('address_id');
                    $seller_mail = [];
                    $seller_mail['user_name'] = $buyer_info->first_name.' '.$buyer_info->last_name;
                    $seller_mail['patment_id'] = $result->getId();
                    $seller_mail['artwork_name'] = '<a href="'.$url.'">'.$artwork_result->title.'</a>';
                    // Mail to seller
                    $seller_email = $this->userRepository->getData(['id'=>$artwork_result->user_id],'first',[],0);
                    if($seller_email){
                        Mail::to($seller_email)->send(new SellerNotification($seller_mail));
                    }

                    // Remove from Cart
                    $remove_from_cart = $this->savedArtworkRepository->getData(['user_id'=> Auth::user()->id, 'artwork_id' => $artwork, 'status' => 'cart'],'delete',[],0);
                    $variant_id = $artwork_result->variants[0]->id;
                    $artwork_delete['is_deleted'] = 'yes';
                    if($artwork_result->variants[0]->variant_type == "original"){
                        // $remove_variant = $this->artworkRepository->createUpdateData(['id'=> $artwork],$artwork_delete);
                        $remove_variant = $this->variantRepository->getData(['id'=> $variant_id],'delete',[],0);
                    }else{
                        if(!empty($artwork_result->variants[0]->editions_count) && ($artwork_result->variants[0]->editions_count > 0)){
                            $new_editions_count = $artwork_result->variants[0]->editions_count -1;
                            if($new_editions_count == 0){
                                $remove_variant = $this->variantRepository->getData(['id'=> $variant_id],'delete',[],0);
                                // $remove_variant = $this->artworkRepository->createUpdateData(['id'=> $artwork],$artwork_delete);
                            }else{
                                $vatiant['editions_count'] = $new_editions_count;
                                $update_variant = $this->variantRepository->createUpdateData(['id'=> $variant_id],$vatiant);
                            }
                                
                        }else{
                             $remove_variant = $this->variantRepository->getData(['id'=> $variant_id],'delete',[],0);
                        }
                        
                    }
                }


                $admin_mail = [];
                $admin_mail['user_name'] = $buyer_info->first_name.' '.$buyer_info->last_name;
                $admin_mail['patment_id'] = $result->getId();
                // Mail to admin
                $toEmail = $this->siteSettingRepository->getData([],'first',[],0);
                if($toEmail){
                    Mail::to($toEmail->email)->send(new AdminSaleNotification($admin_mail));
                }else{
                    $toEmail = $this->userRepository->getData(['role'=> 'admin'],'first',[],0);
                    if($toEmail){
                        Mail::to($toEmail)->send(new AdminSaleNotification($admin_mail));
                    }
                }

                // Mail to buyer
                $buyer_mail = [];
                $buyer_mail['patment_id'] = $result->getId();
                $buyer_mail['artwork_detail'] = $artwork_name;
                $buyer_email = $this->userRepository->getData(['id'=>Auth::user()->id],'first',[],0);
                if($buyer_email){
                    Mail::to($buyer_email)->send(new SaleNotification($buyer_mail));
                }
            }

            /* Save order in database */
            \Session::flash('success_message', 'Thank you for your order.'); 
            $url = Auth::user()->role.'/order_list';
            return Redirect::to($url);
        }
        \Session::flash('error_message', 'Payment failed');
        return Redirect::to('cart');
    }

    public function payout($id){
        // dd(time());

        $site_setting = $this->siteSettingRepository->getData([],'first',[],0);
        $product_info = $this->orderRepository->getData(['id'=>$id],'first',['artist'],0);
        $json_info = json_decode($product_info->artwork_info);
        $newprice = $json_info->variants[0]->price;
        $payer_email = $json_info->artist->paypal_email;
        
        if(!empty($site_setting->commission_persentage)){
            $newprice = $newprice * ((100-$site_setting->commission_persentage) / 100);
        }

        $payouts = new \PayPal\Api\Payout();
        $senderBatchHeader = new \PayPal\Api\PayoutSenderBatchHeader();
        $senderBatchHeader->setSenderBatchId(uniqid())
        ->setEmailSubject("You have a Payout!");
        $senderItem = new \PayPal\Api\PayoutItem();
        // dd($senderItem);
        $senderItem->setRecipientType('Email')
        ->setNote('Payment for Artwork '.$json_info->title.'!')
        // ->setReceiver('sb-fc6ye618472@personal.example.com')
        ->setReceiver($payer_email)
        ->setSenderItemId(time())
        ->setAmount(new \PayPal\Api\Currency('{
                            "value":"'.$newprice.'",
                            "currency":"GBP"
                        }'));
        $payouts->setSenderBatchHeader($senderBatchHeader)
        ->addItem($senderItem);
        $request = clone $payouts;

        // $paypal_conf = \Config::get('paypal');
        // $apiContext = new \PayPal\Rest\ApiContext(
        //     new \PayPal\Auth\OAuthTokenCredential(
        //         $paypal_conf['client_id'],
        //         $paypal_conf['secret']
        //     )
        // );

        // dd($request);
        try {
            // echo "<pre>";
            // print_r($this->_api_context); die;
            $output = $payouts->createSynchronous($this->_api_context);
            // $output = $payouts->create(array('sync_mode' => 'false'), $this->_api_context);
            // echo "<pre>";
            // print_r($output); die;
            // $output = $payouts->create(null, $apiContext);
            // $output = $payouts->createSynchronous($this->_api_context);
            // dd($output);

            $product_info = $this->orderRepository->getData(['id'=>$id],'first',['artist'],0);
            $product_details = [];
            $artwork_result = json_decode($product_info->artwork_info);
            $url = url('artwork_details').'/'.$artwork_result->id;
            $artwork_name = '<a href="'.$url.'">'.$artwork_result->title.'</a>';
            $product_details['artwork_name'] = $artwork_name;
            $product_details['tracking_number'] = $product_info->tracking_number;
            $product_details['carrier'] = $product_info->carrier;
            $user_info = $this->userRepository->getData(['id'=> $product_info->user_id],'first',[],0);
            if($user_info){
                Mail::to($user_info)->send(new ShippingNotification($product_details));
            }
        } catch (Exception $ex) {
            // return $ex;
            // echo "<pre>";
            // print_r($ex->getMessage()); die;
            \Session::flash('error_message', 'Something went wrong with amount transfer. Please contact administrator and try marking item as shipped again');
            return redirect('artist/order_list');
            // dd($ex);
            // ResultPrinter::printError("Created Single Synchronous Payout", "Payout", null, $request, $ex);
            // exit(1);
        }
        $order['shipping_status'] = "Shipped";
        $order['artist_payment_status'] = "Transferred";
        $order_info = $this->orderRepository->createUpdateData(['id'=> $id],$order);
        // dd($output->getBatchHeader()->getPayoutBatchId());
        // ResultPrinter::printResult("Created Single Synchronous Payout", "Payout", $output->getBatchHeader()->getPayoutBatchId(), $request, $output);
        \Session::flash('success_message', 'Order Marked as Shipped & amount transferred to your paypal account.'); 
        return redirect('artist/order_list');

        return $output;
    }

}