<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Session; 
use App\Repository\SavedArtistRepository;
use App\Repository\SavedArtworkRepository;
use App\Repository\SiteSettingRepository;
use App\Repository\UserRepository;
use Mail;
use App\Mail\Notification;
use App\Mail\WelcomeNotification;
use App\Mail\GalleryWelcomeNotification;
use App\Mail\BuyerWelcomeNotification; 


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/user_login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request, SavedArtistRepository $savedArtistRepository, SavedArtworkRepository $savedArtworkRepository, SiteSettingRepository $siteSettingRepository,UserRepository $userRepository)
    {
        $this->middleware('guest');
        $this->request = $request;
        $this->siteSettingRepository = $siteSettingRepository;
        $this->savedArtistRepository = $savedArtistRepository;
        $this->savedArtworkRepository = $savedArtworkRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {   
       
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'user_name' => ['required','string','unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'agree_terms_and_conditions' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user_data = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'role' => $data['role'],
            'email' => $data['email'],
            'user_name' => $data['user_name'],
            'password' => Hash::make($data['password']),
            'name' => $data['first_name'].' '.$data['last_name'],
            'email_verified_at'=> date('Y-m-d H:i:s'),
        ]);
        $toEmail = $this->siteSettingRepository->getData([],'first',[],0);
        if($toEmail){
            Mail::to($toEmail)->send(new Notification($user_data));
        }else{
            $toEmail = $this->userRepository->getData(['role'=> 'admin'],'first',[],0);
        
            if($toEmail){
                Mail::to($toEmail)->send(new Notification($user_data));
            } 

        }
        if($data['role'] == 'artist'){
            $toEmailuser = $this->userRepository->getData(['id'=> $user_data->id],'first',[],0);
            if($toEmailuser){
                Mail::to($toEmailuser)->send(new WelcomeNotification($user_data));
            }
        }
        if($data['role'] == "gallery"){
            $toEmailuser = $this->userRepository->getData(['id'=> $user_data->id],'first',[],0);
            if($toEmailuser){
                Mail::to($toEmailuser)->send(new GalleryWelcomeNotification($user_data));
            }
        }
        if($data['role'] == "buyer"){
            $toEmailuser = $this->userRepository->getData(['id'=> $user_data->id],'first',[],0);
            if($toEmailuser){
                Mail::to($toEmailuser)->send(new BuyerWelcomeNotification($user_data));
            }
        }
            

        if ($data['role'] == "buyer" || $data['role'] == "artist" || $data['role'] == "gallery")
        {
            $user_info = [];
            $user_info['user_id'] = $user_data->id;
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

        // $user_role = Auth::user()->role;

        // if ($user_role == "admin")
        // {
        //     return redirect()->to('/admin/profile');
        // }
        // elseif ($user_role == "buyer")
        // {
        //     return redirect()->to('/buyer/dashboard');
        // }
        // elseif ($user_role == "artist")
        // {
        //     return redirect()->to('/artist/dashboard');
        // }
        // elseif ($user_role == "gallery")
        // {
        //     return redirect()->to('/gallery/dashboard');
        // }
        // else
        // {
        //     return redirect()
        //         ->back()
        //         ->with('message', 'Information not appropriate');
        // }
        return $user_data;
    }
}
