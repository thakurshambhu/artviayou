<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\CmsRepository;
use App\Repository\SiteSettingRepository;
use Validator;
use Exception;
use Session;
use Mail;
use DB;
use Hash;
use Cookie;
use Segment;
use DateTime;
class CmsController extends Controller
{
	private $aboutus_files;
    private $home_files;
	/**
    * Construction function
    * @param $request(Array), $CmsRepository(Repository Interface)
    * @return 
    *
    * Created By: Shambhu Thakur
    * Created At: 21Nov2019 
    */
    public function __construct(Request $request, CmsRepository $CmsRepository,SiteSettingRepository $SiteSettingRepository)
    {
        $this->request = $request;
        $this->CmsRepository = $CmsRepository;
        $this->SiteSettingRepository = $SiteSettingRepository;
        $this->aboutus_files = '/images/aboutus_files/';
        $this->home_files = '/images/home_files/';
    }

    /**
    * Function to Create/Update About Us
    * @param
    * @return 
    *
    * Created By: Shambhu Thakur
    * Created At: 21Nov2019 
    */
    public function update_aboutus(Request $request) {
    	
		$validate = $this->validate($request,[
            'title'	=> 'required|max:255',
			'des_first' => 'required',
			'des_second' => 'required',
			// 'first_img_url' => 'required|mimes:jpg,png,jpeg,gif',
			// 'second_img_url' => 'required|mimes:jpg,png,jpeg,gif',
        ]);
        
        try{
            $aboutus_array = [];
            $aboutus_array['title'] = $this->request->title;
            $aboutus_array['des_first'] = $this->request->des_first;
            $aboutus_array['des_second'] = $this->request->des_second;
        	
            if($this->request->hasFile('first_img_url')){
                $first_img_url = $this->request->file('first_img_url');
                $parts = pathinfo($first_img_url->getClientOriginalName());
                $extension = strtolower($parts['extension']);
                $imageName = uniqid() . mt_rand(999, 9999) . '.' . $extension;
                $imageName = uniqid() . mt_rand(999, 9999) . '.' . $extension;
                $first_img_url->move(public_path() . $this->aboutus_files, $imageName);  
                $image_name = url($this->aboutus_files . $imageName); 
                $aboutus_array['first_img_url'] = $image_name;    
            }
            if($this->request->hasFile('second_img_url')){
                $second_img_url = $this->request->file('second_img_url');
                $parts1 = pathinfo($second_img_url->getClientOriginalName());
                $extension1 = strtolower($parts['extension']);
                $imageName1 = uniqid() . mt_rand(999, 9999) . '.' . $extension;
                $imageName1 = uniqid() . mt_rand(999, 9999) . '.' . $extension;
                $second_img_url->move(public_path() . $this->aboutus_files, $imageName1);  
                $image_name1 = url($this->aboutus_files . $imageName1); 
                $aboutus_array['second_img_url'] = $image_name1;
            }
            
            	
            $upload_file = $this->CmsRepository->createUpdateData(['slug'=> $this->request->slug],$aboutus_array);
             \Session::flash('success_message', "AboutUs Saved Successfully!");
            return redirect('/admin/manage_cms/'.$this->request->slug);
        }catch (\Exception $ex){
            \Session::flash('error_message', $ex->getMessage());
            return back()->withInput();
        }
    }

     /**
    * Function to add cms page
    * @param $request(Array)
    * @return 
    *0
    * Created By: Shambhu thakur
    * Created At: 21Nov2019
    */
    public function manage_cms($slug)
    {
        $title = "";
        if($slug == "about_us"){
            $title = "About Us";
        }
        if($slug == "privacy_policy"){
            $title = "Privacy Policy";
        }
        if($slug == "terms_n_conditions"){
            $title = "Terms & Conditions";
        }   
        if($slug == "blog"){
            $title = "Blog";
        }
        if($slug == "home_page"){
            $title = "Home";
        }
        $cms_info = $this->CmsRepository->getData(['slug'=>$slug],'first',[],0);
        // echo "<pre>";print_r($cms_info);die;
    	return view('backend/edit_cms', compact('slug', 'title', 'cms_info'));
    }

     /**
    * Function to Create/Update cms
    * @param
    * @return 
    *
    * Created By: Shambhu Thakur
    * Created At: 21Nov2019 
    */
    public function update_cms(Request $request) {
        $validator = $this->validate($request,[
            'title' => 'required',
            'slug' => 'required',
            'des_first' => 'required'
        ]);
        try{

            $cms = $this->CmsRepository->createUpdateData(['slug'=> $request->slug],$request->all());
            \Session::flash('success_message', "Information Saved Successfully!");
            return redirect('/admin/manage_cms/'.$this->request->slug);
        }catch (\Exception $ex){
            \Session::flash('error_message', $ex->getMessage());
            return back()->withInput();
        }
    }

    /**
    * Function to Create/Update cms
    * @param
    * @return 
    *
    * Created By: Shambhu Thakur
    * Created At: 26Nov2019 
    */
    public function update_home(Request $request) {
        $validator = $this->validate($request,[
            // 'title' => 'required',
            'slug' => 'required',
            'des_first' => 'required',
        ]);
        try{
            $home_array = [];
            $home_array['title'] = $this->request->title;
            $home_array['des_first'] = $this->request->des_first;
            if($this->request->hasFile('first_img_url')){
                $first_img_url = $this->request->file('first_img_url');
                $parts = pathinfo($first_img_url->getClientOriginalName());
                $extension = strtolower($parts['extension']);
                $imageName = uniqid() . mt_rand(999, 9999) . '.' . $extension;
                $imageName = uniqid() . mt_rand(999, 9999) . '.' . $extension;
                $first_img_url->move(public_path() . $this->home_files, $imageName);  
                $image_name = url($this->home_files . $imageName); 
                $home_array['first_img_url'] = $image_name;    
            }
           
                
            $upload_file = $this->CmsRepository->createUpdateData(['slug'=> $this->request->slug],$home_array);
             \Session::flash('success_message', "Home banner Saved Successfully!");
            return redirect('/admin/manage_cms/'.$this->request->slug);
        }catch (\Exception $ex){
            \Session::flash('error_message', $ex->getMessage());
            return back()->withInput();
        }
    }

    public function site_setting(){
        $setting = $this->SiteSettingRepository->getData([],'first',[],0);
        return view('backend/site_setting', compact('setting'));
    } 


    /**
    * Function to Create/Update cms
    * @param
    * @return 
    *
    * Created By: Shambhu Thakur
    * Created At: 26Nov2019 
    */
    public function update_site_setting(Request $request) {
        $validator = $this->validate($request,[
            'email' => 'required|email',
            'commission_persentage' => 'required'
        ]);
        try{
                
            $upload_file = $this->SiteSettingRepository->createUpdateData(['id'=> $this->request->id],$this->request->all());
             \Session::flash('success_message', "Setiings Updated Successfully!");
            return redirect('/admin/site_setting');
        }catch (\Exception $ex){
            \Session::flash('error_message', $ex->getMessage());
            return back()->withInput();
        }
    }

}
