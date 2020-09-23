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

class ArtistController extends Controller
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
    * Function to artists listing page
    * @param $request(Array)
    * @return 
    *
    * Created By: Ram Krishna Murthy
    * Created At: 
    */
    public function index()
    {
    	$artists = $this->userRepository->getData(['role'=>'artist'],'get',[],0);
        return view('backend/artists', compact('artists'));
    }

    /**
    * Function to add artists page
    * @param $request(Array)
    * @return 
    *
    * Created By: Ram Krishna Murthy
    * Created At: 
    */
    public function add_artist()
    {
    	return view('backend/add_artist');
    }

    /**
    * Function to edit artists page
    * @param $request(Array)
    * @return 
    *
    * Created By: Ram Krishna Murthy
    * Created At: 
    */
    public function edit_artist($id)
    {
    	$artist = $this->userRepository->getData(['id'=>$id],'first',[],0);
    	return view('backend/edit_artist', compact('artist'));
    }

    /**
    * Function to delete artists
    * @param $request(Array)
    * @return 
    *
    * Created By: Ram Krishna Murthy
    * Created At: 
    */
    public function delete_artist($id)
    {
    	$artist = $this->userRepository->getData(['id'=>$id],'delete',[],0);
    	\Session::flash('success_message', 'Artist Deleted Succssfully!.'); 
            return redirect('/admin/artist');
    }

    /**
    * Function to change artists status
    * @param $request(Array)
    * @return 
    *
    * Created By: Ram Krishna Murthy
    * Created At: 
    */
    public function change_artist_status($id, $status)
    {
        if($status == 'yes'){
            $data['is_active'] = 'no';
        }else{
            $data['is_active'] = 'yes';
        }
        $artist = $this->userRepository->createUpdateData(['id'=> $id],$data);
        \Session::flash('success_message', 'Artist Status Changed Succssfully!.'); 
        return redirect('/admin/artist');
    }

    /**
    * Function to change artists status
    * @param $request(Array)
    * @return 
    *
    * Created By: Ram Krishna Murthy
    * Created At: 
    */
    public function change_featured_status($id, $status)
    {
    	if($status == 'yes'){
    		$data['is_featured'] = 'no';
    	}else{
    		$data['is_featured'] = 'yes';
    	}
    	$artist = $this->userRepository->createUpdateData(['id'=> $id],$data);
    	\Session::flash('success_message', 'Artist Status Changed Succssfully!.'); 
        return redirect('/admin/artist');
    }

    /**
    * Function to create/update artist
    * @param $request(Array)
    * @return 
    *
    * Created By: Ram Krishna Murthy
    * Created At: 18Sept2019 
    */

    public function update_artist()
    {
        $validate = $this->validate($this->request, [
            'email'         => trim('required|string|email|max:255|unique:users,email,'.$this->request->id),
            'first_name'         => 'required|string',
            'last_name'         => 'required|string',
        ]);
        $artist_array = [];
        $artist_array['first_name'] = $this->request->first_name;
        $artist_array['last_name'] = $this->request->last_name;
        $artist_array['email'] = $this->request->email;
        $artist_array['alias'] = $this->request->alias;
        $artist_array['biography'] = $this->request->biography;
        $artist_array['address'] = $this->request->address;
        $artist_array['postal_code'] = $this->request->postal_code;
        $artist_array['city'] = $this->request->city;
        $artist_array['state'] = $this->request->state;
        if(!empty($this->request->password)){
            $artist_array['password'] = $this->request->password;
        }
        $artist_array['country'] = $this->request->country;
        $artist_array['role'] ='artist';
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
            return redirect('/admin/artist');
        }else{
            \Session::flash('error_message', 'Something went wrong.');
            return back()->withInput();
        }
    }


}
