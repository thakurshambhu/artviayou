<?php

namespace App\Http\Controllers\Gallery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\CategoryRepository;
use App\Repository\VariantRepository;
use App\Repository\UserRepository;
use Exeception;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use App\Repository\OrderRepository;
use App\Repository\BlogRepository;
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
use App\SavedArtwork;
use App\SavedArtist;

class GalleryUserController extends Controller
{
    private $blog_files;
    private $users_files;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request,UserRepository $userRepository,CategoryRepository $categoryRepository,VariantRepository $variantRepository,BlogRepository $BlogRepository,OrderRepository $orderRepository)
    {
        $this->middleware('auth');

        $this->request = $request;

        $this->blog_files = '/images/blog_files/';
        $this->users_files = '/images/users_files/';

        $this->userRepository = $userRepository;

        $this->categoryRepository = $categoryRepository;

        $this->variantRepository = $variantRepository;
        $this->BlogRepository = $BlogRepository;
        $this->orderRepository = $orderRepository;
    }

    public function index(){
        $categories = $this->categoryRepository->getData(['is_active'=>'yes'],'get',['artwork'],0);

        $styles= Style::where('is_active','yes')->get();
        $subjects= Subject::where('is_active','yes')->get();
    	return view('gallery.gallery_dashboard',compact('categories','styles','subjects'));
    }

    // public function exhibitions(){
    //    $blogs = $this->BlogRepository->getData(['is_deleted'=>'no'],'get',['user'],0);
    //    return view('gallery.exhibitions',compact('blogs'));
    // }

    // public function exhibition_details($id){
    //     $blog_detail = $this->BlogRepository->getData(['id'=>$id,'is_deleted'=>'no'],'first',['user'],0);
    //     $leatests = $this->BlogRepository->getData(['is_deleted'=>'no'],'get',['user'],0);
    //    return view('gallery.exhibition_details',compact('blog_detail','leatests'));
    // }



    //Profile
    public function profile($id){
        
        $gallery = $this->userRepository->getData(['id'=>$id],'first',[],0);
        
        return view('gallery.profile', compact('gallery'));
    }

    public function update_gallery()
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
        $gallery_array = [];
        $gallery_array['first_name'] = $this->request->first_name;
        $gallery_array['last_name'] = $this->request->last_name;
        $gallery_array['email'] = $this->request->email;
        $gallery_array['address'] = $this->request->address;
        $gallery_array['postal_code'] = $this->request->postal_code;
        $gallery_array['city'] = $this->request->city;
        $gallery_array['user_name'] = $this->request->user_name;
        $gallery_array['country'] = $this->request->country;
        $gallery_array['biography']=$this->request->biography;
        if($this->request->hasFile('media_url')){
            $media_url = $this->request->file('media_url');
            $parts = pathinfo($media_url->getClientOriginalName());
            $extension = strtolower($parts['extension']);
            $imageName = uniqid() . mt_rand(999, 9999) . '.' . $extension;
            $imageName = uniqid() . mt_rand(999, 9999) . '.' . $extension;
            $media_url->move(public_path() . $this->users_files, $imageName);  
            $image_name = url($this->users_files . $imageName);
            $gallery_array['media_url'] = $image_name;

        }
      
        $gallery = $this->userRepository->createUpdateData(['id'=> $this->request->id],$gallery_array);
        if($gallery){
            \Session::flash('success_message', 'Gallery Details Updated Succssfully.'); 
            return redirect('/gallery/profile/'.$gallery->id);
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

    public function add_blog(){
        $categories = $this->categoryRepository->getData(['is_active'=>'yes'],'get',['artwork'],0);

        $styles= Style::where('is_active','yes')->get();
        $subjects= Subject::where('is_active','yes')->get();
        return view('gallery/add_blog',compact('categories','styles','subjects'));
    }

    /**
    * Function to Create/Update About Us
    * @param
    * @return 
    *
    * Created By: Shambhu Thakur
    * Created At: 21Nov2019 
    */
    public function update_blog(Request $request) {
        $validator = $this->validate($request,[
            'title' => 'required',
            'des_first' => 'required'
        ]);
        $blog_array = [];
        $blog_array['title'] = $this->request->title;
        $blog_array['des_first'] = $this->request->des_first;
        $blog_array['user_id'] = Auth::user()->id;
        if($this->request->hasFile('media_url')){
            $media_url = $this->request->file('media_url');
            $parts = pathinfo($media_url->getClientOriginalName());
            $extension = strtolower($parts['extension']);
            $imageName = uniqid() . mt_rand(999, 9999) . '.' . $extension;
            $imageName = uniqid() . mt_rand(999, 9999) . '.' . $extension;
            $media_url->move(public_path() . $this->blog_files, $imageName);  
            $image_name = url($this->blog_files . $imageName);
            $blog_array['media_url'] = $image_name;

        }
        $blog = $this->BlogRepository->createUpdateData(['id'=> $request->id],$blog_array);

        if($blog){
            \Session::flash('success_message', 'Blog Post Successfully!'); 
            return redirect('/gallery/blog');
        }else{
            \Session::flash('error_message', 'Something went wrong.');
            return back()->withInput();
        }
        // try{

        //     $blog = $this->BlogRepository->createUpdateData(['id'=> $request->id],$request->all());
        //     \Session::flash('success_message', "Blog Post Successfully!");
        //     return redirect('/gallery/blog');
        // }catch (\Exception $ex){
        //     \Session::flash('error_message', $ex->getMessage());
        //     return back()->withInput();
        // }
    }

    public function blog(){
        $categories = $this->categoryRepository->getData(['is_active'=>'yes'],'get',['artwork'],0);
        $styles= Style::where('is_active','yes')->get();
        $subjects= Subject::where('is_active','yes')->get();
        $blogs = $this->BlogRepository->getData(['user_id'=>Auth::user()->id, 'is_deleted'=>'no'],'get',['user'],0);
        return view('gallery/blog',compact('categories','styles','subjects','blogs'));
    }

    public function edit_blog($id)
    {
        $categories = $this->categoryRepository->getData(['is_active'=>'yes'],'get',['artwork'],0);
        $styles= Style::where('is_active','yes')->get();
        $subjects= Subject::where('is_active','yes')->get();
        $blog = $this->BlogRepository->getData(['id'=>$id],'first',['user'],0);
        return view('gallery/edit_blog', compact('categories','styles','subjects','blog'));
    }


     /**
    * Function to delete blog
    * @param $request(Array)
    * @return 
    *
    * Created By: shambhu thakur
    * Created At: 13 Dec 2019
    */
    public function delete_blog($id)
    {
        $blog = $this->BlogRepository->getData(['id'=>$id],'delete',[],0);
        \Session::flash('success_message', 'Blog Deleted Succssfully!.'); 
            return redirect('/gallery/blog');
    }

    /**
    * Function to change blog status
    * @param $request(Array)
    * @return 
    *
    * Created By: Shambhu thakur
    * Created At:13 Dec 2019 
    */
    public function change_blog_status($id, $status)
    {
        if($status == 'yes'){
            $data['is_active'] = 'no';
        }else{
            $data['is_active'] = 'yes';
        }
        $blog = $this->BlogRepository->createUpdateData(['id'=> $id],$data);
        \Session::flash('success_message', 'Blog Status Changed Succssfully!.'); 
        return redirect('/gallery/blog');
    }

     public function getChat(){
        $html = view('chat.chat')->render();
        return response()->json(array(
            'result' => $html,
            'status' => 200,
        ), 200);
    }

    public function order_list(){
        $user_type = "gallery";
        $orders = $this->orderRepository->getData(['user_id'=>Auth::user()->id],'get',[],0);        
        return view('frontend/order_list', compact('orders', 'user_type'));
    }
}
