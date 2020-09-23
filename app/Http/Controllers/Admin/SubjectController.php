<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\SubjectRepository;
use Validator;
use Exception;
use Session;
use Mail;
use DB;
use Hash;
use Cookie;
use Segment;
use DateTime;

class SubjectController extends Controller
{
    /**
    * Construction function
    * @param $request(Array), $subjectRepository(Repository Interface)
    * @return 
    *
    * Created By: Shambhu Thakur
    * Created At: 19Nov2019 
    */
    public function __construct(Request $request, SubjectRepository $subjectRepository)
    {
        $this->request = $request;
        $this->subjectRepository = $subjectRepository;
    }
    /**
    * Function To List all subject
    * @param
    * @return 
    *
    * Created By: Shambhu Thakur
    * Created At: 19Nov2019 
    */
    public function index() {
        $subjects = $this->subjectRepository->getData(['is_deleted'=>'no'],'get',[],0);
        return view('backend.subjects', compact('subjects'));
    }
     /**
    * Function to render Add subject Page
    * @param
    * @return 
    *
    * Created By: Shambhu Thakur
    * Created At: 19Nov2019 
    */
    public function add_subject() {
        return view('backend.add_subject');
    }

    /**
    * Function to Create/Update subject
    * @param
    * @return 
    *
    * Created By: Shambhu Thakur
    * Created At: 19Nov2019 
    */
    public function update_subject(Request $request) {
        $validator = $this->validate($request,[
            'name' => 'required',
        ]);
        try{
            $subject = $this->subjectRepository->createUpdateData(['id'=> $request->id],$request->all());
            //dd($save_category);
            \Session::flash('success_message', "Subject Saved Successfully!");
            return redirect('/admin/subject');
        }catch (\Exception $ex){
            \Session::flash('error_message', $ex->getMessage());
            return back()->withInput();
        }
    }

    /**
    * Function to subject edit page
    * @param $request(Array)
    * @return 
    *
    * Created By: Shambhu Thakur
    * Created At: 19Nov2019
    */
    public function edit_subject($id)
    {
        $subject = $this->subjectRepository->getData(['id'=>$id],'first',[],0);
        return view('backend/edit_subject', compact('subject'));
    }

     /**
    * Function to delete subject
    * @param $request(Array)
    * @return 
    *
    * Created By: shambhu thakur
    * Created At: 19Nov2019
    */
    public function delete_subject($id)
    {
        $subject = $this->subjectRepository->getData(['id'=>$id],'delete',[],0);
        \Session::flash('success_message', 'Subject Deleted Succssfully!.'); 
            return redirect('/admin/subject');
    }

    /**
    * Function to change subject status
    * @param $request(Array)
    * @return 
    *
    * Created By: Shambhu thakur
    * Created At:19Nov2019 
    */
    public function change_subject_status($id, $status)
    {
        if($status == 'yes'){
            $data['is_active'] = 'no';
        }else{
            $data['is_active'] = 'yes';
        }
        $subject = $this->subjectRepository->createUpdateData(['id'=> $id],$data);
        \Session::flash('success_message', 'Subject Status Changed Succssfully!.'); 
        return redirect('admin/subject');
    }


    
}
