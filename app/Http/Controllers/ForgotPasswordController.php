<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;

class ForgotPasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function sendResetLinkEmail(Request $request)
    {
        $data = $request->all();
        $response = DB::table('password_resets')->where('email', $data['email'])->first();
        $data['token'] = $response->token;
        Mail::send('email.reset_password', $confirmed = array('user_info'=>$data), function($message ) use ($data){ 
                $message->to($data['email']);
                $message->from('noreply@artviayou.com','Artviayou');
                $message->subject('Laravel Basic Testing Mail');
            });

        // Mail::send(['text'=>'reset_password'], $data, function($message) {
        //      $message->to('ram@yopmail.com', 'Artviayou')->subject
        //         ('Laravel Basic Testing Mail');
        //      $message->from('xyz@gmail.com','Ram');
        // });
        return redirect('/admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */

}
