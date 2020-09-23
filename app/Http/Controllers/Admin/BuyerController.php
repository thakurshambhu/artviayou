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

class BuyerController extends Controller
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
    * Function to buyers listing page
    * @param $request(Array)
    * @return 
    *
    * Created By: Ram Krishna Murthy
    * Created At: 
    */
    public function index()
    {
    	$buyers = $this->userRepository->getData(['role'=>'buyer'],'get',[],0);
        return view('backend/buyers', compact('buyers'));
    }

    /**
    * Function to add buyers page
    * @param $request(Array)
    * @return 
    *
    * Created By: Ram Krishna Murthy
    * Created At: 
    */
    public function add_buyer()
    {
    	return view('backend/add_buyer');
    }

    /**
    * Function to edit buyers page
    * @param $request(Array)
    * @return 
    *
    * Created By: Ram Krishna Murthy
    * Created At: 
    */
    public function edit_buyer($id)
    {
    	$buyer = $this->userRepository->getData(['id'=>$id],'first',[],0);
    	return view('backend/edit_buyer', compact('buyer'));
    }

    /**
    * Function to delete buyers
    * @param $request(Array)
    * @return 
    *
    * Created By: Ram Krishna Murthy
    * Created At: 
    */
    public function delete_buyer($id)
    {
    	$buyer = $this->userRepository->getData(['id'=>$id],'delete',[],0);
    	\Session::flash('success_message', 'Buyer Deleted Succssfully!.'); 
            return redirect('/admin/buyer');
    }

    /**
    * Function to change buyers status
    * @param $request(Array)
    * @return 
    *
    * Created By: Ram Krishna Murthy
    * Created At: 
    */
    public function change_buyer_status($id, $status)
    {
    	if($status == 'yes'){
    		$data['is_active'] = 'no';
    	}else{
    		$data['is_active'] = 'yes';
    	}
    	$buyer = $this->userRepository->createUpdateData(['id'=> $id],$data);
    	\Session::flash('success_message', 'Buyer Status Changed Succssfully!.'); 
        return redirect('/admin/buyer');
    }

    /**
    * Function to create/update buyer
    * @param $request(Array)
    * @return 
    *
    * Created By: Ram Krishna Murthy
    * Created At:  
    */

    public function update_buyer()
    {
        $validate = $this->validate($this->request, [
            'email'         => trim('required|string|email|max:255|unique:users,email,'.$this->request->id),
            'first_name'         => 'required|string',
            'last_name'         => 'required|string',
        ]);
        $buyer_array = [];
        $buyer_array['first_name'] = $this->request->first_name;
        $buyer_array['last_name'] = $this->request->last_name;
        $buyer_array['email'] = $this->request->email;
        $buyer_array['alias'] = $this->request->alias;
        $buyer_array['biography'] = $this->request->biography;
        $buyer_array['address'] = $this->request->address;
        $buyer_array['postal_code'] = $this->request->postal_code;
        $buyer_array['city'] = $this->request->city;
        $buyer_array['state'] = $this->request->state;
        if(!empty($this->request->password)){
            $buyer_array['password'] = $this->request->password;
        }
        $buyer_array['country'] = $this->request->country;
        $buyer_array['role'] ='buyer';
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
            return redirect('/admin/buyer');
        }else{
            \Session::flash('error_message', 'Something went wrong.');
            return back()->withInput();
        }
    }


}
