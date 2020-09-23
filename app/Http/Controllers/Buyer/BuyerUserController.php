<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\CategoryRepository;
use App\Repository\VariantRepository;
use App\Repository\UserRepository;
use App\Repository\OrderRepository;
use Exeception;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Auth;
use App\Style;
use App\Subject;
use Exception;
use Session;
use Mail;
use DB;
use Hash;
use Cookie;
use Segment;
use Validator;
use DateTime;

class BuyerUserController extends Controller
{
    private $users_files;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository,Request $request,CategoryRepository $categoryRepository,VariantRepository $variantRepository,OrderRepository $orderRepository)
    {
        $this->middleware('auth');

        $this->request = $request;

        $this->users_files = '/images/users_files/';

        $this->categoryRepository = $categoryRepository;

        $this->variantRepository = $variantRepository;

        $this->userRepository = $userRepository;
        $this->orderRepository = $orderRepository;
    }

    public function index(){
        $categories = $this->categoryRepository->getData(['is_active'=>'yes'],'get',['artwork'],0);

        $styles= Style::where('is_active','yes')->get();

        $subjects= Subject::where('is_active','yes')->get();
    
    	return view('buyer.buyer_dashboard',compact('categories','styles','subjects'));
    }

    public function getSubCategories(){
        
        $categories = $this->categoryRepository->getData(['id'=>$this->request->id,'is_active'=>'yes'],'first',['artwork','subcategories','artwork.artist','artwork.variants'],0);
      
        if($this->request->price){
           
        }

        if($this->request->height){
            
        }

        if($this->request->width){
            
        }
        
        $returnHTML = view('buyer.sub_categories',compact('categories'))->render();// or method that you prefere to return data + RENDER is the key here
                      return response()->json(array('status' => '200', 'html'=>$returnHTML));
    }

    public function profile($id){
        $categories = $this->categoryRepository->getData(['is_active'=>'yes'],'get',['artwork'],0);

        $styles= Style::where('is_active','yes')->get();

        $subjects= Subject::where('is_active','yes')->get();
    
        $buyer = $this->userRepository->getData(['id'=>$id],'first',[],0);
        
        return view('buyer.profile', compact('buyer','categories','styles','subjects'));
    }

    public function update_buyer()
    {
        $validation = Validator::make($this->request->all(), [
            // $validate = $this->validate($this->request, [
                'email'         => trim('required|string|email|max:255|unique:users,email,'.$this->request->id),
                'user_name'         => trim('required|string|max:255|unique:users,user_name,'.$this->request->id),
                'first_name'         => trim('required|string'),
                'last_name'         => trim('required|string'),
                'address'         => trim('required|string'),
                'postal_code'         => trim('required|string'),
                'city'         => trim('required|string'),
                'country'         => trim('required|string'),
            ]);
    
            // $validator = Validator::make($this->request->all() , $rules);
    
           if ($validation->fails()) {
                    throw new ValidationException($validation);
            }
        $buyer_array = [];
        $buyer_array['first_name'] = $this->request->first_name;
        $buyer_array['last_name'] = $this->request->last_name;
        $buyer_array['email'] = $this->request->email;
        $buyer_array['address'] = $this->request->address;
        $buyer_array['postal_code'] = $this->request->postal_code;
        $buyer_array['city'] = $this->request->city;
        $buyer_array['user_name'] = $this->request->user_name;
        $buyer_array['country'] = $this->request->country;
        $buyer_array['biography']=$this->request->biography;
        if($this->request->hasFile('media_url')){
            $media_url = $this->request->file('media_url');
            $parts = pathinfo($media_url->getClientOriginalName());
            $extension = strtolower($parts['extension']);
            $imageName = uniqid() . mt_rand(999, 9999) . '.' . $extension;
            $imageName = uniqid() . mt_rand(999, 9999) . '.' . $extension;
            $media_url->move(public_path() . $this->users_files, $imageName);  
            $image_name = url($this->users_files . $imageName);
            $buyer_array['media_url'] = $image_name;

        }
      
        $buyer = $this->userRepository->createUpdateData(['id'=> $this->request->id],$buyer_array);
        if($buyer){
            \Session::flash('success_message', 'Buyer Details Updated Succssfully.'); 
            return redirect('/buyer/profile/'.$buyer->id);
        }else{
            \Session::flash('error_message', 'Something went wrong.');
            return back()->withInput();
        }
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->withPasswordStatus(__('Password successfully updated.'));
    }

    public function getChat(){
       $html = view('chat.chat')->render();
        return response()->json(array(
            'result' => $html,
            'status' => 200,
        ), 200);
    } 

    public function order_list(){
        $user_type = "buyer";
        $orders = $this->orderRepository->getData(['user_id'=>Auth::user()->id],'get',[],0);        
        return view('frontend/order_list', compact('orders', 'user_type'));
    }


}
