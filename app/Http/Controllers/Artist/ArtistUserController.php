<?php
namespace App\Http\Controllers\Artist;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\ArtworkRepository;
use App\Repository\ArtworkImageRepository;
use App\Repository\VariantRepository;
use App\Repository\CategoryRepository;
use App\Repository\SubCategoryRepository;
use App\Repository\SubjectRepository;
use App\Repository\StyleRepository;
use App\Repository\UserRepository;
use App\Repository\SavedArtworkRepository;
use App\Repository\SavedArtistRepository;
use App\Repository\RequestComissionRepository;
use App\Repository\OrderRepository;
use App\Repository\SiteSettingRepository;
use App\Mail\AdminRequestCommNotification;
use App\Mail\UserRequestCommNotification;
use App\Mail\AdminRequestCommDeclineNotification;
use App\Mail\UserRequestCommDeclineNotification;
use Exeception;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use Image;
use Illuminate\Support\Facades\Auth;
use Validator;
use Exception;
use Session;
use Mail;
use DB;
use Hash;
use Cookie;
use Segment;
use DateTime;
use App\ArtworkImage;
use App\SavedArtwork;
use App\SavedArtist;

class ArtistUserController extends Controller
{
    private $artwork_files;
    private $users_files;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request, SavedArtistRepository $savedArtistRepository,SavedArtworkRepository $savedArtworkRepository,ArtworkRepository $artworkRepository, ArtworkImageRepository $artworkImageRepository, VariantRepository $variantRepository,CategoryRepository $categoryRepository,SubCategoryRepository $SubCategoryRepository,SubjectRepository $subjectRepository,StyleRepository $styleRepository,UserRepository $userRepository,OrderRepository $orderRepository,RequestComissionRepository $requestComissionRepository, SiteSettingRepository $siteSettingRepository)
    {
        $this->middleware('auth');
        $this->request = $request;
        $this->artworkRepository = $artworkRepository;
        $this->artworkImageRepository = $artworkImageRepository;
        $this->variantRepository = $variantRepository;
        $this->categoryRepository = $categoryRepository;
        $this->SubCategoryRepository = $SubCategoryRepository;
        $this->subjectRepository = $subjectRepository;
        $this->styleRepository = $styleRepository;
        $this->userRepository = $userRepository;
        $this->savedArtistRepository = $savedArtistRepository;
        $this->savedArtworkRepository = $savedArtworkRepository;
        $this->orderRepository = $orderRepository;
        $this->requestComissionRepository = $requestComissionRepository;
        $this->siteSettingRepository = $siteSettingRepository;
        $this->artwork_files = '/images/artwork_files/';
        $this->users_files = '/images/users_files/';
    }
    public function index(){
        $user_info = $this->userRepository->getData(['id'=>Auth::user()->id],'first',['artworks', 'artworks.artwork_like'],0);
        $like_count = 0;
        $artwork_count = 0;
        if(count($user_info->artworks) > 0){
           foreach($user_info->artworks as $artworks){
            $artwork_count++;
                $like_count = $like_count + count($artworks->artwork_like);
           }
        }
        $follow_count = $this->savedArtistRepository->getData(['artist_id'=>Auth::user()->id],'count',[],0);
        
         
    	return view('artist.artist_dashboard',compact('like_count','follow_count', 'artwork_count'));
    }
    public function add_artwork(){
        if(!empty(Auth::user()->paypal_email)){
            $categories = $this->categoryRepository->getData(['is_deleted'=>'no','is_active'=>'yes'],'get',[],0);
            $subjects = $this->subjectRepository->getData(['is_deleted'=>'no','is_active'=>'yes'],'get',[],0);
            $styles = $this->styleRepository->getData(['is_deleted'=>'no','is_active'=>'yes'],'get',[],0);
            return view('artist.add_artwork', compact('categories','subjects','styles'));
        }else{
            \Session::flash('error_message', 'Please Update the Paypal Email.'); 
            return redirect('/artist/profile/'.Auth::user()->id);
        }
            
    }
    public function profile($id){
        // $userId = Auth::id();
        if(Auth::user()->id == $id){
            $artist =  $this->userRepository->getData(['id'=>$id],'first',[],0);
            return view('artist.profile',compact('artist'));
        }else{
            \Session::flash('error_message', 'You are not authorized to access this URL.');
            return redirect('artist/dashboard');
        }
            
    } 
    public function artworks(){
        $artworks = $this->artworkRepository->getData(['is_deleted'=> 'no', 'user_id'=>Auth::user()->id],'get',['category_detail', 'sub_category_detail'],0);
        return view('artist/artworks',compact('artworks'));
    } 
    public function change_artwork_status($id, $status, $page, $user_id)
    {
        if($status == 'publish'){
            $data['is_publised'] = 'unpublish';
            $new_status = "Un-Published";
        }else{
            $data['is_publised'] = 'publish';
            $new_status = "Published";
        }
        $artist = $this->artworkRepository->createUpdateData(['id'=> $id],$data);
        \Session::flash('success_message', 'Artwork Status Changed to '.$new_status.' Succssfully!.');
        return redirect('/artist/artworks'); 
        
    } 
    
    public function delete_artwork($id)
    {
        $artwork = $this->artworkRepository->getData(['id'=>$id],'delete',[],0);
        \Session::flash('success_message', 'Artwork Deleted Succssfully!.'); 
            return redirect('/artist/artworks');
    } 
    public function view_artwork($id){
        $artwork_result = $this->artworkRepository->getData(['id'=> $id],'first',['artwork_images', 'variants', 'artist', 'artwork_like', 'category_detail', 'sub_category_detail','style_detail', 'subject_detail'],0);
        // echo "<pre>";
        // print_r($artwork_result); die;
        if(count($artwork_result->artwork_like) > 0){
            if(Auth::user()){
                $artwork_result['like_count'] = SavedArtwork::where(['artwork_id' => $id, 'status' => 'like'])->pluck('user_id')->toArray();
                $artwork_result['save_count'] = SavedArtwork::where(['artwork_id' => $id, 'status' => 'saved'])->pluck('user_id')->toArray();
            }else{
                $artwork_result['like_count'] = SavedArtwork::where(['artwork_id' => $id, 'status' => 'like'])->pluck('guest_id')->toArray();
                $artwork_result['save_count'] = SavedArtwork::where(['artwork_id' => $id, 'status' => 'saved'])->pluck('guest_id')->toArray();
            }
        }else{
            $artwork_result['like_count'] = [];
            $artwork_result['save_count'] = [];
        }
        $similar_artwork = $this->artworkRepository->getData(['is_publised' => 'publish','category'=> $artwork_result['category']],'get',['artwork_images', 'variants', 'artist', 'artwork_like'],0);
        if(count($similar_artwork)>0){
            foreach ($similar_artwork as $key => $artwork) {
                if(Auth::user()){
                    $artwork['like_count'] = SavedArtwork::where(['artwork_id' => $artwork['id'], 'status' => 'like'])->pluck('user_id')->toArray();
                    $artwork['save_count'] = SavedArtwork::where(['artwork_id' => $artwork['id'], 'status' => 'saved'])->pluck('user_id')->toArray();
                }else{
                    $artwork['like_count'] = SavedArtwork::where(['artwork_id' => $artwork['id'], 'status' => 'like'])->pluck('guest_id')->toArray();
                    $artwork['save_count'] = SavedArtwork::where(['artwork_id' => $artwork['id'], 'status' => 'saved'])->pluck('guest_id')->toArray();
                }
            }
        }
        return view('artist/view_artwork',compact('artwork_result', 'similar_artwork'));
    } 
    public function edit_artwork($id){
        $variant_types = [];
        $categories = $this->categoryRepository->getData(['is_deleted'=>'no','is_active'=>'yes'],'get',[],0);
        $subjects = $this->subjectRepository->getData(['is_deleted'=>'no','is_active'=>'yes'],'get',[],0);
        $styles = $this->styleRepository->getData(['is_deleted'=>'no','is_active'=>'yes'],'get',[],0);
        $subcategories = $this->SubCategoryRepository->getData(['category_id'=>$this->request->category_id, 'is_active'=>'yes'],'get',[],0);
        $artwork = $this->artworkRepository->getData(['id'=> $id],'first',['artwork_images', 'variants', 'artist', 'artwork_like', 'category_detail', 'sub_category_detail','style_detail', 'subject_detail'],0);
        // echo "<pre>";
        // print_r(count($artwork->artwork_images)); die;
        if(count($artwork->variants) > 0){
            foreach ($artwork->variants as $key => $value) {
                $variant_types[] = $value['variant_type'];
            }
        }
        return view('artist/edit_artwork',compact('artwork','categories','subjects','styles','subcategories', 'variant_types'));
    }
    public function deleteImage(){
        $image = ArtworkImage::where(['id'=> $this->request->id, 'artwork_id'=>$this->request->artwork_id])->forcedelete();

        // $artwork_images = ArtworkImage::where('artwork_id',$this->request->artwork_id)->get();

        // return view('artist.artwork_images',compact('artwork_images'));

         return response()->json(array(
                'message' => "image Succssfully deleted",   
                'status' => 200,
                ) , 200);
    }
    public function update_artist(){
        $validation = Validator::make($this->request->all(), [
        // $validate = $this->validate($this->request, [
            'paypal_email'         => trim('required|string|email|max:255|unique:users,paypal_email,'.$this->request->id),
            'paypal_email_confirmation' => 'required|same:paypal_email',

            'email'         => trim('required|string|email|max:255|unique:users,email,'.$this->request->id),
            'user_name'         => trim('required|string|max:255|unique:users,user_name,'.$this->request->id),
            'first_name'         => trim('required|string'),
            'last_name'         => trim('required|string'),
            'address'         => trim('required|string'),
            'postal_code'         => trim('required|string'),
            'state'         => trim('required|string'),
            'country'         => trim('required|string'),
        ]);
        // $validator = Validator::make($this->request->all() , $rules);
        if ($validation->fails()) {
            throw new ValidationException($validation);
        }
        
        $artist_array = [];
        $artist_array['first_name'] = $this->request->first_name;
        $artist_array['last_name'] = $this->request->last_name;
        $artist_array['email'] = $this->request->email;
        $artist_array['paypal_email'] = $this->request->paypal_email;
        $artist_array['address'] = $this->request->address;
        $artist_array['postal_code'] = $this->request->postal_code;
        $artist_array['user_name'] = $this->request->user_name;
        $artist_array['state'] = $this->request->state;
        $artist_array['country'] = $this->request->country;
        $artist_array['biography'] = $this->request->biography;
        if($this->request->hasFile('media_url')){
            $media_url = $this->request->file('media_url');
            $parts = pathinfo($media_url->getClientOriginalName());
            $extension = strtolower($parts['extension']);
            $imageName = uniqid() . mt_rand(999, 9999) . '.' . $extension;
            $imageName = uniqid() . mt_rand(999, 9999) . '.' . $extension;
            $media_url->move(public_path() . $this->users_files, $imageName);  
            $image_name = url($this->users_files . $imageName);
            $artist_array['media_url'] = $image_name;
        }
      
        $artist = $this->userRepository->createUpdateData(['id'=> $this->request->id],$artist_array);
        if($artist){
            \Session::flash('success_message', 'Artist Details Updated Succssfully.'); 
            return redirect('/artist/profile/'.$artist->id);
        }else{
            \Session::flash('error_message', 'Something went wrong.');
            return back()->withInput();
        }
    }
    
    public function upload_artwork(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all()); die;
        $artwork_array = [];
        $artwork_array['title'] = $this->request->title;
        $artwork_array['description'] = $this->request->description;
        $artwork_array['category'] = $this->request->category;
        $artwork_array['sub_category'] = $this->request->sub_category;
        $artwork_array['style'] = $this->request->style;
        $artwork_array['subject'] = $this->request->subject;
        $artwork_array['user_id'] = Auth::user()->id;
        $artwork = $this->artworkRepository->createUpdateData(['id'=> $this->request->id],$artwork_array);
        if($artwork){
            $upload_files = $this->request->file('upload_files');
            $main_image = $this->request->main_image_base64;
            if(!empty($main_image)){
                $image = $request->main_image_base64;
                $image = str_replace('data:image/jpeg;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = str_random(10).'.'.'jpeg';
                $success = file_put_contents(public_path() . $this->artwork_files.$imageName, base64_decode($image));
                $image_name = url($this->artwork_files . $imageName); 
                $uploads['media_url'] = $image_name;
                $uploads['artwork_id'] = $artwork['id'];
                $upload_file = $this->artworkImageRepository->createUpdateData(['id'=> $this->request->doc_id],$uploads);
            }
            if($this->request->has('hidden_image')){
                if(count($this->request->hidden_image) > 0){
                    foreach ($this->request->hidden_image as $file) {
                        if(!empty($file)){
                            $image = str_replace('data:image/jpeg;base64,', '', $file);
                            $image = str_replace(' ', '+', $image);
                            $imageName = str_random(10).'.'.'jpeg';
                            $success = file_put_contents(public_path() . $this->artwork_files.$imageName, base64_decode($image));
                            $image_name = url($this->artwork_files . $imageName); 
                            $uploads['media_url'] = $image_name;
                            $uploads['artwork_id'] = $artwork['id'];
                            $upload_file = $this->artworkImageRepository->createUpdateData(['id'=> $this->request->doc_id],$uploads);
                        }
                        // $parts = pathinfo($file->getClientOriginalName());
                        // $extension = strtolower($parts['extension']);
                        // $imageName = uniqid() . mt_rand(999, 9999) . '.' . $extension;
                        // $file->move(public_path() . $this->artwork_files, $imageName);  
                        // $image_name = url($this->artwork_files . $imageName); 
                        // $uploads['media_url'] = $image_name;
                        // $uploads['artwork_id'] = $artwork['id'];
                        // $upload_file = $this->artworkImageRepository->createUpdateData(['id'=> $this->request->doc_id],$uploads);
                    }
                }
            }
                
            $checked_variant_type = $this->request->checked_variant_type;
            $variant_type = explode(',', $checked_variant_type);
            $variant_id = [];
            
            foreach ($variant_type as $key => $value) {
                if($value == "original"){
                    $variant = [];
                    $variant['artwork_id'] = $artwork['id'];
                    $variant['variant_type'] = 'original';
                    $variant['width'] = $this->request->original_width;
                    $variant['height'] = $this->request->original_height;
                    $variant['price'] = $this->request->original_price;
                    $variant['worldwide_shipping_charge'] = $this->request->original_shipping_charge;
                    $variants = $this->variantRepository->createUpdateData(['id'=> $this->request->original_id],$variant);
                    $variant_id[] = $variants['id'];
                }
                if($value == "limited_edition"){
                    foreach ($this->request->limited_width as $key => $limited_edition) {
                        $variant = [];
                        $variant['artwork_id'] = $artwork['id'];
                        $variant['variant_type'] = "limited_edition";
                        $variant['editions_count'] = $this->request->limited_edition_count[$key];
                        $variant['width'] = $this->request->limited_width[$key];
                        $variant['height'] = $this->request->limited_height[$key];
                        $variant['price'] = $this->request->limited_price[$key];
                        $variant['worldwide_shipping_charge'] = $this->request->limited_edition_count[$key];
                        // $variant['not_for_sale'] = $this->request->not_for_sale;
                        $variants = $this->variantRepository->createUpdateData(['id'=> $this->request->limited_edition_id[$key]],$variant);
                        $variant_id[] = $variants['id'];
                    }
                }
                if($value == "art_paint"){
                    foreach ($this->request->art_width as $key => $art_paint) {
                        $variant = [];
                        $variant['artwork_id'] = $artwork['id'];
                        $variant['variant_type'] = "art_paint";
                        $variant['width'] = $this->request->art_width[$key];
                        $variant['height'] = $this->request->art_height[$key];
                        $variant['price'] = $this->request->art_price[$key];
                        $variant['worldwide_shipping_charge'] = $this->request->art_shipping_charge[$key];
                        // $variant['not_for_sale'] = $this->request->not_for_sale;
                        $variants = $this->variantRepository->createUpdateData(['id'=> $this->request->art_print_id[$key]],$variant);
                        $variant_id[] = $variants['id'];
                    }
                }
            }
            if(!empty($this->request->id)){
                if(count($variant_id) > 0){
                    $delete_variant = $this->variantRepository->getData(['variant_id'=>$variant_id, 'artwork_id'=> $this->request->id],'delete',[],0);
                }
            }
            \Session::flash('success_message', 'Artwork Details Updated Succssfully.'); 
            return redirect('/artist/artworks');
        }else{
            \Session::flash('error_message', 'Something went wrong.');
            return back()->withInput();
        }
    } 
    public function getSubcategory(){
        $subcategories = [];
        if(!empty($this->request->category_id)){
            $subcategories = $this->SubCategoryRepository->getData(['category_id'=>$this->request->category_id,'is_active'=>'yes'],'get',[],0);
        }
        $options = "";
        $options .='<option value="">Select Type</option>';
        if(!empty($this->request->category_id)){
            if(count($subcategories) > 0){
                foreach ($subcategories as $key => $value) {
                    $options .= '<option value="'.$value->id.'">'.$value->name.'</option>';
                }
            }
        }
        return response()->json(array(
            'result' => $options,
            'status' => 200,
        ), 200);
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
        // return view('chat.chat');
    } 

    public function order_list(){
        $user_type = "artist";
        $orders = $this->orderRepository->getData(['artist_user_orders'=>Auth::user()->id],'get',[],0);        
        return view('frontend/order_list', compact('orders', 'user_type'));
    } 

    public function req_comm_list(){
        $req_comm_user = $this->requestComissionRepository->getData(['artist_id'=>Auth::user()->id],'get',['artist','users'],0);
        // echo "<pre>";
        // print_r($req_comm_user); die;
        return view('artist/req_comm_list',compact('req_comm_user'));
    }

    public function change_commition_status($id, $status)
    {
        $data['request_status'] = $status;
        $req_stat = $this->requestComissionRepository->createUpdateData(['id'=> $id],$data);
        $req_stat_info = $this->requestComissionRepository->getData(['id'=> $id],'first',['artist','users'],0);

        // Mail to admin
        $admin_mail = [];
        $admin_mail['artist_name'] = $req_stat_info->artist->first_name.' '.$req_stat_info->artist->last_name;
        $admin_mail['artist_id'] = $req_stat_info->artist->id;
        $admin_mail['artist_email'] = $req_stat_info->artist->email;
        $admin_mail['user_email'] = $req_stat_info->users->email;
        $admin_mail['alias'] = $req_stat_info->users->user_name;
        $admin_mail['role'] = $req_stat_info->users->role;
        $admin_mail['user_name'] = $req_stat_info->users->first_name.' '.$req_stat_info->users->last_name;
        $admin_mail['user_id'] = $req_stat_info->users->id;
        $admin_mail['status'] = $req_stat_info->request_status;
        $toEmail = $this->siteSettingRepository->getData([],'first',[],0);
        if($status=='Accepted'){
            if($toEmail){
            Mail::to($toEmail->email)->send(new AdminRequestCommNotification($admin_mail));
            }else{
                $toEmail = $this->userRepository->getData(['role'=> 'admin'],'first',[],0);
                if($toEmail){
                    Mail::to($toEmail)->send(new AdminRequestCommNotification($admin_mail));
                }
            }
        }else{
            if($toEmail){
            Mail::to($toEmail->email)->send(new AdminRequestCommDeclineNotification($admin_mail));
            }else{
                $toEmail = $this->userRepository->getData(['role'=> 'admin'],'first',[],0);
                if($toEmail){
                    Mail::to($toEmail)->send(new AdminRequestCommDeclineNotification($admin_mail));
                }
            }
        }
        

        // Mail to buyer/gallery
        $buyer_mail = [];
        $buyer_mail['artist_name'] = $req_stat_info->artist->first_name.' '.$req_stat_info->artist->last_name;
        $buyer_mail['user_name'] = $req_stat_info->users->first_name;
        $buyer_mail['artist_id'] = $req_stat_info->artist->id;
        $buyer_mail['status'] = $req_stat_info->request_status;

        $buyer_email = $this->userRepository->getData(['id'=>$req_stat_info->user_id],'first',[],0);
        if($status=='Accepted'){
             if($buyer_email){
                Mail::to($buyer_email)->send(new UserRequestCommNotification($buyer_mail));
            }

        }else{
             if($buyer_email){
                Mail::to($buyer_email)->send(new UserRequestCommDeclineNotification($buyer_mail));
            }

        }
       

        \Session::flash('success_message', 'Commission Status Changed Succssfully!.'); 
        return redirect('/artist/req_comm_list');
    }


}