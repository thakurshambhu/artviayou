<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\StyleRepository;
use Validator;
use Exception;
use Session;
use Mail;
use DB;
use Hash;
use Cookie;
use Segment;
use DateTime;

class StyleController extends Controller
{
    /**
    * Construction function
    * @param $request(Array), $styleRepository(Repository Interface)
    * @return 
    *
    * Created By: Shambhu Thakur
    * Created At: 19Nov2019 
    */
    public function __construct(Request $request, StyleRepository $styleRepository)
    {
        $this->request = $request;
        $this->styleRepository = $styleRepository;
    }
    /**
    * Function To List all style
    * @param
    * @return 
    *
    * Created By: Shambhu Thakur
    * Created At: 19Nov2019 
    */
    public function index() {
        $styles = $this->styleRepository->getData(['is_deleted'=>'no'],'get',[],0);
        return view('backend.styles', compact('styles'));
    }
     /**
    * Function to render Add style Page
    * @param
    * @return 
    *
    * Created By: Shambhu Thakur
    * Created At: 19Nov2019 
    */
    public function add_style() {
        return view('backend.add_style');
    }

    /**
    * Function to Create/Update subject
    * @param
    * @return 
    *
    * Created By: Shambhu Thakur
    * Created At: 19Nov2019 
    */
    public function update_style(Request $request) {
        $validator = $this->validate($request,[
            'name' => 'required',
        ]);
        try{
            $subject = $this->styleRepository->createUpdateData(['id'=> $request->id],$request->all());
            \Session::flash('success_message', "Style Saved Successfully!");
            return redirect('/admin/style');
        }catch (\Exception $ex){
            \Session::flash('error_message', $ex->getMessage());
            return back()->withInput();
        }
    }

    /**
    * Function to style edit page
    * @param $request(Array)
    * @return 
    *
    * Created By: Shambhu Thakur
    * Created At: 19Nov2019
    */
    public function edit_style($id)
    {
        $style = $this->styleRepository->getData(['id'=>$id],'first',[],0);
        return view('backend/edit_style', compact('style'));
    }

     /**
    * Function to delete style
    * @param $request(Array)
    * @return 
    *
    * Created By: shambhu thakur
    * Created At: 19Nov2019
    */
    public function delete_style($id)
    {
        $style = $this->styleRepository->getData(['id'=>$id],'delete',[],0);
        \Session::flash('success_message', 'Style Deleted Succssfully!.'); 
            return redirect('/admin/style');
    }

    /**
    * Function to change style status
    * @param $request(Array)
    * @return 
    *
    * Created By: Shambhu thakur
    * Created At:19Nov2019 
    */
    public function change_style_status($id, $status)
    {
        if($status == 'yes'){
            $data['is_active'] = 'no';
        }else{
            $data['is_active'] = 'yes';
        }
        $style = $this->styleRepository->createUpdateData(['id'=> $id],$data);
        \Session::flash('success_message', 'Style Status Changed Succssfully!.'); 
        return redirect('/admin/style');
    }


    
}
