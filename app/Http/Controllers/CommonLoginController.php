<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Input;
use Session;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Redirect, Response, File;
use Socialite;
use App\Repository\SavedArtistRepository;
use App\Repository\SavedArtworkRepository;
class CommonLoginController extends Controller
{
    public function __construct(Request $request, SavedArtistRepository $savedArtistRepository, SavedArtworkRepository $savedArtworkRepository)
    {
        $this->request = $request;
        $this->savedArtistRepository = $savedArtistRepository;
        $this->savedArtworkRepository = $savedArtworkRepository;
    }

    public function login()
    {

        //dd(Auth::user());
        if (!Auth::check())
        {
            //dd('not login');
            return redirect()->to('/');

        }
        else
        {
            //dd('login');

            $user_role = Auth::user()->role;

            if ($user_role == "admin")
            {
                return redirect()->to('/admin/profile');
            }
            elseif ($user_role == "buyer")
            {
                return redirect()->to('/buyer/dashboard');
            }
            elseif ($user_role == "artist")
            {
                return redirect()->to('/artist/dashboard');
            }
            elseif ($user_role == "gallery")
            {
                return redirect()->to('/gallery/dashboard');
            }
            else
            {
                return redirect()
                    ->back()
                    ->with('message', 'Information not appropriate');
            }
        }
    }

    public function submitLogin(Request $request)
    {
        $rules = array(
            'email' => 'required|min:6',
            'password' => 'required|min:6',
        );

        $validator = Validator::make($request->all() , $rules);

        if ($validator->fails())
        {
            return redirect()
                ->back()
                ->withErrors($validator);
        }
        else
        {

            $userdata = array(
                'email' => Input::get('email') ,
                'password' => Input::get('password') ,
            );

            if (Auth::attempt($userdata))
            {

                $user_role = Auth::user()->role;

                if ($user_role == "admin")
                {

                    $url = url('/home');
                }

                if ($user_role == "buyer")
                {
                    if(url()->previous() != url('/')){
                        $url = url()->previous();
                    }else{
                        $url = url('/buyer/dashboard');
                    }
                        

                }

                if ($user_role == "artist")
                {
                    if(url()->previous() != url('/')){
                        $url = url()->previous();
                    }else{
                        $url = url('/artist/dashboard');
                    }
                    // $url = url('/artist/dashboard');

                }

                if ($user_role == "gallery")
                {
                    if(url()->previous() != url('/')){
                        $url = url()->previous();
                    }else{
                        $url = url('/gallery/dashboard');
                    }
                    // $url = url('/gallery/dashboard');

                }

                if ($user_role == "buyer" || $user_role == "artist" || $user_role == "gallery")
                {
                    $user_info = [];
                    $user_info['user_id'] = Auth::user()->id;
                    $user_info['guest_id'] = "";
                    if (Session::has('random_id'))
                    {
                        $count_artist = $this
                            ->savedArtistRepository
                            ->getData(['guest_id' => Session::get('random_id') ], 'get', [], 0);

                        if (count($count_artist) > 0)
                        {
                            foreach ($count_artist as $key => $value)
                            {
                                $artist = $this
                                    ->savedArtistRepository
                                    ->createUpdateData(['id' => $value['id']], $user_info);
                            }
                        }

                        $count_artwork = $this
                            ->savedArtworkRepository
                            ->getData(['guest_id' => Session::get('random_id') ], 'get', [], 0);
                        if (count($count_artwork) > 0)
                        {
                            foreach ($count_artwork as $key => $value)
                            {
                                $artist = $this
                                    ->savedArtworkRepository
                                    ->createUpdateData(['id' => $value['id']], $user_info);
                            }
                        }
                        Session::forget('random_id');
                    }
                }

                return response()->json(array(
                    'redirect_url' => $url,
                    'status' => 200,
                ) , 200);

            }
            else
            {

                return response()->json(array(
                    'message' => 'User not found with these credentials!',
                    'status' => 400,
                ) , 200);
            }
        }

    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()
            ->to('/')
            ->with('message', 'You are Successfully Logged Out');
    }

    public function redirect($provider)
    {

        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $getInfo = Socialite::driver($provider)->user();
        $user = $this->createUser($getInfo, $provider);
        auth()->login($user);

        return redirect()->to('/user_login');
    }

    public function createUser($getInfo, $provider)
    {
        $user = User::where('provider_id', $getInfo->id)->first();
        if (!$user)
        {
            $user = User::create(['role' => Session::get('user_role'), 'name' => $getInfo->name, 'first_name' => $getInfo->name, 'email' => $getInfo->email, 'provider' => $provider, 'provider_id' => $getInfo->id, 'email_verified_at'=> date('Y-m-d H:i:s')]);
        }
        return $user;
    }

    public function check_email_status(){
       
        $users = User::where('email', $this->request->email)->first();

        if(!empty($users)){
            return response()->json(array(
                'message' => 'Email Already Exists',
                'status' => 200,
            ) , 200);
        }
        
    }

    public function check_username_status(){
        $users = User::where('user_name', $this->request->user_name)->first();

        if(!empty($users)){
            return response()->json(array(
                'message' => 'UserName Already Exists',
                'status' => 200,
            ) , 200);
        }
    }
}


