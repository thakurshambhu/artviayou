<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\FaqRepository;
use Validator;
use Exception;
use Session;
use Mail;
use DB;
use Hash;
use Cookie;
use Segment;
use DateTime;
class FaqController extends Controller
{
	
	/**
    * Construction function
    * @param $request(Array), $CmsRepository(Repository Interface)
    * @return 
    *
    * Created By: Shambhu Thakur
    * Created At: 21Nov2019 
    */
    public function __construct(Request $request, FaqRepository $faqRepository)
    {
        $this->request = $request;
        $this->FaqRepository = $faqRepository;
    }

 
    public function add_faq(){
        return view('backend/add_faq');
    }

    public function update_faq(Request $request) {
        // echo "<pre>";
        // print_r($request->all()); die;
        $validator = $this->validate($request,[
            'qus' => 'required',
            // 'ans' => 'required',
        ]);
        try{
            $faq = $this->FaqRepository->createUpdateData(['id'=> $request->id],$request->all());
            \Session::flash('success_message', "faq Saved Successfully!");
            return redirect('/admin/faq');
        }catch (\Exception $ex){
            \Session::flash('error_message', $ex->getMessage());
            return back()->withInput();
        }
    }

    public function edit_faq($id)
    {
        $faq = $this->FaqRepository->getData(['id'=>$id],'first',[],0);
        return view('backend/edit_faq', compact('faq'));
    }


    public function faq() {
        $faq = $this->FaqRepository->getData(['is_deleted'=>'no'],'get',[],0);
        return view('backend.faq', compact('faq'));
    }


     /**
    * Function to delete style
    * @param $request(Array)
    * @return 
    *
    * Created By: shambhu thakur
    * Created At: 03Dec2019
    */
    public function delete_faq($id)
    {
        $faq = $this->FaqRepository->getData(['id'=>$id],'delete',[],0);
        \Session::flash('success_message', 'faq Deleted Succssfully!.'); 
            return redirect('/admin/faq');
    }

    /**
    * Function to change style status
    * @param $request(Array)
    * @return 
    *
    * Created By: Shambhu thakur
    * Created At:03Dec2019 
    */
    public function change_faq_status($id, $status)
    {
        if($status == 'yes'){
            $data['is_active'] = 'no';
        }else{
            $data['is_active'] = 'yes';
        }
        $faq = $this->FaqRepository->createUpdateData(['id'=> $id],$data);
        \Session::flash('success_message', 'Faq Status Changed Succssfully!.'); 
        return redirect('/admin/faq');
    }



}
