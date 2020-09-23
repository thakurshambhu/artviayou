<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\UserRepository;
use Validator;
use Exception;
use Session;
use Mail;
use DB;
use Hash;
use Cookie;
use Segment;
use DateTime;

class GalleryUserController extends Controller
{
    private $users_files;
    /**
    * Construction function
    * @param $request(Array), $userRepository
    * @return 
    *
    * Created By: Ram Krishna Murthy
    * Created At: 
    */
    public function __construct(Request $request, UserRepository $userRepository)
    {
        $this->request = $request;
        $this->userRepository = $userRepository;
        $this->users_files = '/images/users_files/';
    }

    /**
    * Function to galleries listing page
    * @param $request(Array)
    * @return 
    *
    * Created By: Ram Krishna Murthy
    * Created At: 
    */
    public function index()
    {
    	$galleries = $this->userRepository->getData(['role'=>'gallery'],'get',[],0);
        return view('backend/galleries', compact('galleries'));
    }

    /**
    * Function to add galleries page
    * @param $request(Array)
    * @return 
    *
    * Created By: Ram Krishna Murthy
    * Created At: 
    */
    public function add_gallery()
    {
    	return view('backend/add_gallery');
    }

    /**
    * Function to edit galleries page
    * @param $request(Array)
    * @return 
    *
    * Created By: Ram Krishna Murthy
    * Created At: 
    */
    public function edit_gallery($id)
    {
    	$gallery = $this->userRepository->getData(['id'=>$id],'first',[],0);
    	return view('backend/edit_gallery', compact('gallery'));
    }

    /**
    * Function to delete galleries
    * @param $request(Array)
    * @return 
    *
    * Created By: Ram Krishna Murthy
    * Created At: 
    */
    public function delete_gallery($id)
    {
    	$gallery = $this->userRepository->getData(['id'=>$id],'delete',[],0);
    	\Session::flash('success_message', 'Gallery User Deleted Succssfully!.'); 
            return redirect('/admin/gallery');
    }

    /**
    * Function to change galleries status
    * @param $request(Array)
    * @return 
    *
    * Created By: Ram Krishna Murthy
    * Created At: 
    */
    public function change_gallery_status($id, $status)
    {
    	if($status == 'yes'){
    		$data['is_active'] = 'no';
    	}else{
    		$data['is_active'] = 'yes';
    	}
    	$gallery = $this->userRepository->createUpdateData(['id'=> $id],$data);
    	\Session::flash('success_message', 'Gallery User Status Changed Succssfully!.'); 
        return redirect('/admin/gallery');
    }

    /**
    * Function to create/update gallery
    * @param $request(Array)
    * @return 
    *
    * Created By: Ram Krishna Murthy
    * Created At: 18Sept2019 
    */

    public function update_gallery()
    {
         $validate = $this->validate($this->request, [
            'email'         => trim('required|string|email|max:255|unique:users,email,'.$this->request->id),
            'first_name'         => 'required|string',
            'last_name'         => 'required|string',
        ]);
        $gallery_array = [];
        $gallery_array['first_name'] = $this->request->first_name;
        $gallery_array['last_name'] = $this->request->last_name;
        $gallery_array['email'] = $this->request->email;
        $gallery_array['alias'] = $this->request->alias;
        $gallery_array['biography'] = $this->request->biography;
        $gallery_array['address'] = $this->request->address;
        $gallery_array['postal_code'] = $this->request->postal_code;
        $gallery_array['city'] = $this->request->city;
        $gallery_array['state'] = $this->request->state;
        if(!empty($this->request->password)){
            $gallery_array['password'] = $this->request->password;
        }
        $gallery_array['country'] = $this->request->country;
        $gallery_array['role'] ='gallery';
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
            return redirect('/admin/gallery');
        }else{
            \Session::flash('error_message', 'Something went wrong.');
            return back()->withInput();
        }
    }

    public function getChat(){
        return view('chat.chat');
    }


}
