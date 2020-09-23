<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\SubCategoryRepository;
use App\Repository\CategoryRepository;
use Validator;
use Exception;
use Session;
use Mail;
use DB;
use Hash;
use Cookie;
use Segment;
use DateTime;

class SubCategoryController extends Controller
{
    private $subcategory_files;
    /**
    * Construction function
    * @param $request(Array), $SubCategoryRepository(Repository Interface)
    * @return 
    *
    * Created By: Shambhu Thakur
    * Created At: 19Nov2019 
    */
    public function __construct(Request $request, SubCategoryRepository $SubCategoryRepository, CategoryRepository $categoryRepository)
    {
        $this->request = $request;
        $this->SubCategoryRepository = $SubCategoryRepository;
        $this->categoryRepository = $categoryRepository;
        $this->subcategory_files = '/images/subcategory_files/';
    }
    /**
    * Function To List all SubCategory
    * @param
    * @return 
    *
    * Created By: Shambhu Thakur
    * Created At: 19Nov2019 
    */
    public function index() {
        $subcategories = $this->SubCategoryRepository->getData(['is_deleted'=>'no'],'get',['category'],0);
        return view('backend.subcategories', compact('subcategories'));
    }
     /**
    * Function to render Add SubCategory Page
    * @param
    * @return 
    *
    * Created By: Shambhu Thakur
    * Created At: 19Nov2019 
    */
    public function add_subcategory() {
        $categories = $this->categoryRepository->getData(['is_deleted'=>'no'],'get',[],0);
        return view('backend.add_subcategory', compact('categories'));
    }

    /**
    * Function to Create/Update SubCategory
    * @param
    * @return 
    *
    * Created By: Shambhu Thakur
    * Created At: 19Nov2019 
    */
    public function update_subcategory(Request $request) {
        
        $validator = $this->validate($request,[
            'name' => 'required|max:255',
            'category_id' => 'required',
            'media_url' => 'required_without:old_image|mimes:jpg,png,jpeg,gif',
        ],
        [   
            'media_url.required_without'    => 'Image preview is required for this sub category.',
        ]);
        try{
            $subcategory_array = [];
            $subcategory_array['name'] = $this->request->name;
            $subcategory_array['category_id'] = $this->request->category_id;
            if($this->request->hasFile('media_url')){
                $media_url = $this->request->file('media_url');
                $parts = pathinfo($media_url->getClientOriginalName());
                $extension = strtolower($parts['extension']);
                $imageName = uniqid() . mt_rand(999, 9999) . '.' . $extension;
                $imageName = uniqid() . mt_rand(999, 9999) . '.' . $extension;
                $media_url->move(public_path() . $this->subcategory_files, $imageName);  
                $image_name = url($this->subcategory_files . $imageName);
                $subcategory_array['media_url'] = $image_name;

            }

            $subcategory = $this->SubCategoryRepository->createUpdateData(['id'=> $request->id],$subcategory_array);
            \Session::flash('success_message', "SubCategory Saved Successfully!");
            return redirect('/admin/subcategory');
        }catch (\Exception $ex){
            \Session::flash('error_message', $ex->getMessage());
            return back()->withInput();
        }
    }

    /**
    * Function to subcategory edit page
    * @param $request(Array)
    * @return 
    *
    * Created By: Shambhu Thakur
    * Created At: 19Nov2019
    */
    public function edit_subcategory($id)
    {
        $subcategory = $this->SubCategoryRepository->getData(['id'=>$id],'first',[],0);
        $categories = $this->categoryRepository->getData(['is_deleted'=>'no'],'get',[],0);
        return view('backend/edit_subcategory', compact('subcategory','categories'));
    }

     /**
    * Function to delete subject
    * @param $request(Array)
    * @return 
    *
    * Created By: shambhu thakur
    * Created At: 19Nov2019
    */
    public function delete_subcategory($id)
    {
        $subcategory = $this->SubCategoryRepository->getData(['id'=>$id],'delete',[],0);
        \Session::flash('success_message', 'Subcategory Deleted Succssfully!.'); 
            return redirect('admin/subcategory');
    }

    /**
    * Function to change SubCategory status
    * @param $request(Array)
    * @return 
    *
    * Created By: Shambhu thakur
    * Created At:19Nov2019 
    */
    public function change_subcategory_status($id, $status)
    {
        if($status == 'yes'){
            $data['is_active'] = 'no';
        }else{
            $data['is_active'] = 'yes';
        }
        $subcategory = $this->SubCategoryRepository->createUpdateData(['id'=> $id],$data);
        \Session::flash('success_message', 'Subcategory Status Changed Succssfully!.'); 
        return redirect('admin/subcategory');
    }


    
}
