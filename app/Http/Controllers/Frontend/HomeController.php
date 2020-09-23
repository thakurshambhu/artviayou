<?php

namespace App\Http\Controllers\Frontend;
use Illuminate\Http\Request;
// use Request;
use App\Http\Controllers\Controller;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use App\Repository\ArtworkRepository;
use App\Repository\ArtworkImageRepository;
use App\Repository\SavedArtistRepository;
use App\Repository\SavedArtworkRepository;
use App\Repository\CmsRepository;
use App\Repository\FaqRepository;
use App\Repository\ContactFormRepository;
use App\Repository\SubCategoryRepository;
use App\Repository\StyleRepository;
use App\Repository\SubjectRepository;
use App\Repository\VariantRepository;
use App\Repository\BlogRepository;
use App\Repository\MessageRepository;
use App\Repository\RequestComissionRepository;
use App\Mail\ArtistRequestCommNotification;
use App\SavedArtwork;
use App\SavedArtist;
use App\Artwork;
use App\User;
use App\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Session;
use Mail;
use App\Mail\ContactForm;
class HomeController extends Controller
{
    /**
    * Construction function
    * @param $request(Array), $categoryRepository
    * @return 
    *
    * Created By: Shambhu Thakur
    * Created At: 
    */
    public function __construct(Request $request, CategoryRepository $categoryRepository,UserRepository $userRepository, ArtworkRepository $artworkRepository, ArtworkImageRepository $artworkImageRepository, CmsRepository $CmsRepository,FaqRepository $faqRepository,SavedArtistRepository $savedArtistRepository,SavedArtworkRepository $savedArtworkRepository,ContactFormRepository $contactFormRepository, SubCategoryRepository $subCategoryRepository, StyleRepository $styleRepository, VariantRepository $variantRepository, SubjectRepository $subjectRepository,BlogRepository $BlogRepository,MessageRepository $messageRepository,RequestComissionRepository $requestComissionRepository)
    {
        // dd(Session::has('random_id'));
        $this->request = $request;
        $this->categoryRepository = $categoryRepository;
        $this->userRepository = $userRepository;
        $this->artworkRepository = $artworkRepository;
        $this->artworkImageRepository = $artworkImageRepository;
        $this->CmsRepository = $CmsRepository;
        $this->FaqRepository = $faqRepository;
        $this->savedArtistRepository = $savedArtistRepository;
        $this->savedArtworkRepository = $savedArtworkRepository;
        $this->contactFormRepository = $contactFormRepository;
        $this->subCategoryRepository = $subCategoryRepository;
        $this->styleRepository = $styleRepository;
        $this->variantRepository = $variantRepository;
        $this->subjectRepository = $subjectRepository;
        $this->BlogRepository = $BlogRepository;
        $this->messageRepository = $messageRepository;
        $this->requestComissionRepository = $requestComissionRepository;
    }

    public function __destruct(){
        // echo "<pre>";
        // print_r(Session::get('random_id'));
        // dd(Session::has('random_id'));
    }

    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if(Session::has('random_id')) {
            
        }else{
            $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
            $rand = substr(str_shuffle($str_result), 0, 5);
            Session::put('random_id', $rand);
        }
        // dd(Session::get('random_id'));
        $topartworks = $this->artworkRepository->getData(['is_publised' => 'publish','top'=>'yes', 'is_deleted'=>'no'],'get',['category_detail', 'sub_category_detail', 'artist', 'artwork_images', 'variants','style_detail', 'subject_detail'],0);
        if(count($topartworks)>0){
            foreach ($topartworks as $key => $artwork) {
                if(Auth::user()){
                    $artwork['like_count'] = SavedArtwork::where(['artwork_id' => $artwork['id'], 'status' => 'like'])->pluck('user_id')->toArray();
                    $artwork['save_count'] = SavedArtwork::where(['artwork_id' => $artwork['id'], 'status' => 'saved'])->pluck('user_id')->toArray();
                }else{
                    $artwork['like_count'] = SavedArtwork::where(['artwork_id' => $artwork['id'], 'status' => 'like'])->pluck('guest_id')->toArray();
                    $artwork['save_count'] = SavedArtwork::where(['artwork_id' => $artwork['id'], 'status' => 'saved'])->pluck('guest_id')->toArray();
                }
            }
        }
        // dd($topartworks);die;
        $featuredArtworks = $this->artworkRepository->getData(['trending'=>'yes', 'is_deleted'=>'no'],'first',['category_detail', 'sub_category_detail', 'artist', 'artwork_images', 'variants','style_detail', 'subject_detail'],0);
        // echo "<pre>";
        // print_r($featuredArtworks); die;
        $topartists  = $this->userRepository->getData(['is_featured'=>'yes','role'=>'artist', 'is_deleted'=>'no'],'get',[],0);

        if(count($topartists)>0){
            foreach ($topartists as $key => $artist) {
                if(Auth::user()){
                    $artist['like_count'] = SavedArtist::where(['artist_id' => $artist['id'], 'status' => 'like'])->pluck('user_id')->toArray();
                }else{
                    $artist['like_count'] = SavedArtist::where(['artist_id' => $artist['id'], 'status' => 'like'])->pluck('guest_id')->toArray();
                }
            }
        }
        $categories = $this->categoryRepository->getData(['is_deleted'=>'no','is_active'=>'yes'],'get',[],0);
        $homes = $this->CmsRepository->getData(['slug'=>'home_page','is_deleted'=>'no'],'first',[],0);
        return view('frontend/home_page',compact('categories','topartworks','featuredArtworks','homes','topartists'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function about_us(){
          $about = $this->CmsRepository->getData(['slug'=>'about_us','is_deleted'=>'no'],'first',[],0);
        return view('frontend/about_us',compact('about'));
    }
    
    public function terms_conditions(){
          $terms = $this->CmsRepository->getData(['slug'=>'terms_n_conditions','is_deleted'=>'no'],'first',[],0);
        return view('frontend/terms_conditions',compact('terms'));
    }

    public function privacy_policy(){
          $policy = $this->CmsRepository->getData(['slug'=>'privacy_policy','is_deleted'=>'no'],'first',[],0);
        return view('frontend/privacy_policy',compact('policy'));
    }
    
    public function faq(){
        $faq = $this->FaqRepository->getData(['is_active'=>'yes'],'get',[],0);
        return view('frontend.faq', compact('faq'));
    }
    

    public function artist(){
        $artists = $this->userRepository->getData(['role'=>'artist','is_deleted'=>'no','page'=>10],'paginate',['artworks', 'artworks.artwork_images', 'artworks.category_detail', 'artworks.artwork_like', 'artworks.variants'],0);
        if(count($artists)>0){
            foreach ($artists as $key => $artist) {
                if(count($artist->artworks) > 0){
                    foreach ($artist->artworks as $key => $artwork) {
                        if(Auth::user()){
                            $artwork['like_count'] = SavedArtwork::where(['artwork_id' => $artwork['id'], 'status' => 'like'])->pluck('user_id')->toArray();
                            $artwork['save_count'] = SavedArtwork::where(['artwork_id' => $artwork['id'], 'status' => 'saved'])->pluck('user_id')->toArray();
                        }else{
                            $artwork['like_count'] = SavedArtwork::where(['artwork_id' => $artwork['id'], 'status' => 'like'])->pluck('guest_id')->toArray();
                            $artwork['save_count'] = SavedArtwork::where(['artwork_id' => $artwork['id'], 'status' => 'saved'])->pluck('guest_id')->toArray();
                        }
                    }
                }
                if(Auth::user()){
                    $artist['like_count'] = SavedArtist::where(['artist_id' => $artist['id'], 'status' => 'like'])->pluck('user_id')->toArray();
                }else{
                    $artist['like_count'] = SavedArtist::where(['artist_id' => $artist['id'], 'status' => 'like'])->pluck('guest_id')->toArray();
                }
            }
        }
        return view('frontend/artist',compact('artists'));
    }

    public function saved_artist(){
        return view('frontend/save_artist');
    }

    public function contact_us(){
        return view('frontend/contact_us');
    }

    public function user_profile($slug){
        // dd($slug);
        // $professional = [];
        // $profileDetails = $this->userRepository->getData(['user_name'=>$slug, 'is_deleted'=>'no'],'first',['artworks', 'artworks.artwork_images', 'artworks.category_detail', 'artworks.artwork_like', 'artworks.variants'],0);
        // if(!empty($profileDetails)){
        //     $all_follower_count = $this->savedArtistRepository->getData(['artist_id'=>$profileDetails['id']],'count',[],0);    
        //     $all_following_count = $this->savedArtistRepository->getData(['user_id'=>$profileDetails['id']],'count',[],0);    
        //     $all_likes = 0;
        //     if(!empty($profileDetails)){
        //         foreach ($profileDetails->artworks as $key => $value) {
        //             $professional[] = $value['category_detail']['name'];
        //             $all_likes = $all_likes + count($value->artwork_like);
        //         }
        //     }
        //     // dd($all_likes);
        //     $professional = array_unique($professional);
        //     return view('frontend/profile_details',compact('profileDetails', 'professional', 'all_follower_count', 'all_following_count', 'all_likes'));
        // }else{
        //     return redirect('/');
        // }

        $professional = [];
        $profileDetails = $this->userRepository->getData(['user_name'=>$slug, 'is_deleted'=>'no'],'first',['artworks', 'artworks.artwork_images', 'artworks.category_detail', 'artworks.artwork_like', 'artworks.variants'],0);
        $request_comm = '';
        if(!empty($profileDetails)){
            if(Auth::user()){
                $request_comm = $this->requestComissionRepository->getData(['user_id'=>Auth::user()->id, 'artist_id'=>$profileDetails->id, 'request_status'=>null],'first',[],0);

                $profileDetails['like_count'] = SavedArtist::where(['artist_id' => $profileDetails->id, 'status' => 'like'])->pluck('user_id')->toArray();
            }else{
                $profileDetails['like_count'] = SavedArtist::where(['artist_id' => $profileDetails->id, 'status' => 'like'])->pluck('guest_id')->toArray();
            }

            if(count($profileDetails->artworks)){
                foreach ($profileDetails->artworks as $key => $artwork_result) {
                    if(Auth::user()){
                        $artwork_result['like_count'] = SavedArtwork::where(['user_id' => Auth::user()->id, 'status' => 'like'])->pluck('artwork_id')->toArray();
                        $artwork_result['save_count'] = SavedArtwork::where(['user_id' => Auth::user()->id, 'status' => 'saved'])->pluck('user_id')->toArray();
                    }else{
                        $artwork_result['like_count'] = SavedArtwork::where(['guest_id' => Session::get('random_id'), 'status' => 'like'])->pluck('artwork_id')->toArray();
                        $artwork_result['save_count'] = SavedArtwork::where(['guest_id' => Session::get('random_id'), 'status' => 'saved'])->pluck('guest_id')->toArray();
                    }
                }
            }

            $all_follower_count = $this->savedArtistRepository->getData(['artist_id'=>$profileDetails->id],'count',[],0);    
            $all_following_count = $this->savedArtistRepository->getData(['user_id'=>$profileDetails->id],'count',[],0);    
            $all_likes = 0;
            if(!empty($profileDetails)){
                foreach ($profileDetails->artworks as $key => $value) {
                    $professional[] = $value['category_detail']['name'];
                    $all_likes = $all_likes + count($value->artwork_like);
                }
            }
            // dd($all_likes);
            $professional = array_unique($professional);
            return view('frontend/profile_details',compact('profileDetails', 'professional', 'all_follower_count', 'all_following_count', 'all_likes', 'request_comm'));
        }else{
            return redirect('/');
        }

            
    }

    public function profile_details($id){
        $professional = [];
        // $professional['like_count'] = [];
        $request_comm = "";
        $profileDetails = $this->userRepository->getData(['id'=>$id, 'is_deleted'=>'no'],'first',['artworks', 'artworks.artwork_images', 'artworks.category_detail', 'artworks.artwork_like', 'artworks.variants'],0);
        if(!empty($profileDetails)){
            if(Auth::user()){
                $request_comm = $this->requestComissionRepository->getData(['user_id'=>Auth::user()->id, 'artist_id'=>$id, 'request_status'=>null],'first',[],0);

                $profileDetails['like_count'] = SavedArtist::where(['artist_id' => $profileDetails->id, 'status' => 'like'])->pluck('user_id')->toArray();
                // dd($profileDetails['like_count']);
            }else{
                $profileDetails['like_count'] = SavedArtist::where(['artist_id' => $profileDetails->id, 'status' => 'like'])->pluck('guest_id')->toArray();
            }
        }
        if(count($profileDetails->artworks)){
            foreach ($profileDetails->artworks as $key => $artwork_result) {
                if(Auth::user()){
                    $artwork_result['like_count'] = SavedArtwork::where(['user_id' => Auth::user()->id, 'status' => 'like'])->pluck('artwork_id')->toArray();
                    $artwork_result['save_count'] = SavedArtwork::where(['user_id' => Auth::user()->id, 'status' => 'saved'])->pluck('user_id')->toArray();
                }else{
                    $artwork_result['like_count'] = SavedArtwork::where(['guest_id' => Session::get('random_id'), 'status' => 'like'])->pluck('artwork_id')->toArray();
                    $artwork_result['save_count'] = SavedArtwork::where(['guest_id' => Session::get('random_id'), 'status' => 'saved'])->pluck('guest_id')->toArray();
                }
            }
        }
        // echo "<pre>";
        // print_r($request_comm); die;
        $all_follower_count = $this->savedArtistRepository->getData(['artist_id'=>$id],'count',[],0);    
        $all_following_count = $this->savedArtistRepository->getData(['user_id'=>$id],'count',[],0);    
        $all_likes = 0;
        if(!empty($profileDetails)){
            foreach ($profileDetails->artworks as $key => $value) {
                $professional[] = $value['category_detail']['name'];
                $all_likes = $all_likes + count($value->artwork_like);
            }
        }
        $professional = array_unique($professional);
        return view('frontend/profile_details',compact('profileDetails', 'professional', 'all_follower_count', 'all_following_count', 'all_likes', 'request_comm'));
    }

    public function like_artist(){
        // dd($this->request->artist_id);
        if(Auth::user()){
            $saved_artist = [];
            $saved_artist['user_id'] = Auth::user()->id;
            $saved_artist['artist_id'] = $this->request->artist_id;
            $saved_artist['status'] = 'like';

            $count_saved = $this->savedArtistRepository->getData(['user_id'=> Auth::user()->id, 'artist_id' => $this->request->artist_id, 'status' => 'like'],'count',[],0);    
            if(empty($count_saved)){
                $artist = $this->savedArtistRepository->createUpdateData(['id'=> $this->request->id],$saved_artist);
                $text = "Following";
            }else{
                $count_saved = $this->savedArtistRepository->getData(['user_id'=> Auth::user()->id, 'artist_id' => $this->request->artist_id, 'status' => 'like'],'delete',[],0);
                $text = "Follow";
            }
        }else{
            $saved_artist = [];
            $saved_artist['guest_id'] = Session::get('random_id');
            $saved_artist['artist_id'] = $this->request->artist_id;
            $saved_artist['status'] = 'like';

            $count_saved = $this->savedArtistRepository->getData(['guest_id'=> Session::get('random_id'), 'artist_id' => $this->request->artist_id, 'status' => 'like'],'count',[],0);    
            if(empty($count_saved)){
                $artist = $this->savedArtistRepository->createUpdateData(['id'=> $this->request->id],$saved_artist);
                $text = "Following";
            }else{
                $count_saved = $this->savedArtistRepository->getData(['guest_id'=> Session::get('random_id'), 'artist_id' => $this->request->artist_id, 'status' => 'like'],'delete',[],0);
                $text = "Follow";
            }
        }
        $artist_liked = $this->savedArtistRepository->getData(['artist_id'=> $this->request->artist_id, 'status' => 'like'],'count',[],0);    
        return response()->json(array(
            'like_count' => $text,
            'all_count' => $artist_liked.' Followers',
            // 'all_count' => '('.$artist_liked.' Followers)',
            'status' => 200,
        ), 200);
    }

    public function save_artist(){
        // dd(Session::get('random_id'));
        if(Auth::user()){
            $saved_artist = [];
            $saved_artist['user_id'] = Auth::user()->id;
            $saved_artist['artist_id'] = $this->request->artist_id;
            $saved_artist['status'] = 'saved';

            $count_saved = $this->savedArtistRepository->getData(['user_id'=> Auth::user()->id, 'artist_id' => $this->request->artist_id, 'status' => 'saved'],'count',[],0);    
            if(empty($count_saved)){
                $artist = $this->savedArtistRepository->createUpdateData(['id'=> $this->request->id],$saved_artist);
            }else{
                $count_saved = $this->savedArtistRepository->getData(['user_id'=> Auth::user()->id, 'artist_id' => $this->request->artist_id, 'status' => 'saved'],'delete',[],0);
            }
            $artist_saved = $this->savedArtistRepository->getData(['user_id'=> Auth::user()->id, 'status' => 'saved'],'count',[],0);
        }else{
            $saved_artist = [];
            $saved_artist['guest_id'] = Session::get('random_id');
            $saved_artist['artist_id'] = $this->request->artist_id;
            $saved_artist['status'] = 'saved';

            $count_saved = $this->savedArtistRepository->getData(['guest_id'=> Session::get('random_id'), 'artist_id' => $this->request->artist_id, 'status' => 'saved'],'count',[],0);    
            if(empty($count_saved)){
                $artist = $this->savedArtistRepository->createUpdateData(['id'=> $this->request->id],$saved_artist);
            }else{
                $count_saved = $this->savedArtistRepository->getData(['guest_id'=> Session::get('random_id'), 'artist_id' => $this->request->artist_id, 'status' => 'saved'],'delete',[],0);
            }
            $artist_saved = $this->savedArtistRepository->getData(['guest_id'=> Session::get('random_id'), 'status' => 'saved'],'count',[],0);
        }
        
        return response()->json(array(
            'saved_count' => $artist_saved,
            'status' => 200,
        ), 200);
    }

    public function like_artwork(){
        if(Auth::user()){
            $saved_artwork = [];
            $saved_artwork['user_id'] = Auth::user()->id;
            $saved_artwork['artwork_id'] = $this->request->artwork_id;
            $saved_artwork['status'] = 'like';

            $count_saved = $this->savedArtworkRepository->getData(['user_id'=> Auth::user()->id, 'artwork_id' => $this->request->artwork_id, 'status' => 'like'],'count',[],0);    
            if(empty($count_saved)){
                $artwork = $this->savedArtworkRepository->createUpdateData(['id'=> $this->request->id],$saved_artwork);
                $img_source = url('/assets/images/red_heart.jpeg');
            }else{
                $count_saved = $this->savedArtworkRepository->getData(['user_id'=> Auth::user()->id, 'artwork_id' => $this->request->artwork_id, 'status' => 'like'],'delete',[],0);
                $img_source = url('/assets/images/like.png');
            }
        }else{
            $saved_artwork = [];
            $saved_artwork['guest_id'] = Session::get('random_id');
            $saved_artwork['artwork_id'] = $this->request->artwork_id;
            $saved_artwork['status'] = 'like';

            $count_saved = $this->savedArtworkRepository->getData(['guest_id'=> Session::get('random_id'), 'artwork_id' => $this->request->artwork_id, 'status' => 'like'],'count',[],0);    
            if(empty($count_saved)){
                $artwork = $this->savedArtworkRepository->createUpdateData(['id'=> $this->request->id],$saved_artwork);
                $img_source = url('/assets/images/red_heart.jpeg');
            }else{
                $count_saved = $this->savedArtworkRepository->getData(['guest_id'=> Session::get('random_id'), 'artwork_id' => $this->request->artwork_id, 'status' => 'like'],'delete',[],0);
                $img_source = url('/assets/images/like.png');
            }
        }
        $artwork_liked = $this->savedArtworkRepository->getData(['artwork_id'=> $this->request->artwork_id, 'status' => 'like'],'count',[],0);    

        $artwork_result = $this->artworkRepository->getData(['id'=> $this->request->artwork_id],'first',[],0);


        $professional = [];
        $profileDetails = $this->userRepository->getData(['id'=>$artwork_result->user_id, 'is_deleted'=>'no'],'first',['artworks', 'artworks.artwork_images', 'artworks.category_detail', 'artworks.artwork_like', 'artworks.variants'],0);
        
        $all_likes = 0;
        if(!empty($profileDetails)){
            foreach ($profileDetails->artworks as $key => $value) {
                $all_likes = $all_likes + count($value->artwork_like);
            }
        }
        

        return response()->json(array(
            'like_count' => $artwork_liked.' Likes',
            'img_source' => $img_source,
            'all_likes' => $all_likes.' Likes',
            'status' => 200,
        ), 200);
    }

    public function save_artwork(){
        // dd(Session::get('random_id'));
        if(Auth::user()){
            $saved_artwork = [];
            $saved_artwork['user_id'] = Auth::user()->id;
            $saved_artwork['artwork_id'] = $this->request->artwork_id;
            $saved_artwork['status'] = 'saved';

            $count_saved = $this->savedArtworkRepository->getData(['user_id'=> Auth::user()->id, 'artwork_id' => $this->request->artwork_id, 'status' => 'saved'],'count',[],0);    
            if(empty($count_saved)){
                $artwork = $this->savedArtworkRepository->createUpdateData(['id'=> $this->request->id],$saved_artwork);
                $img_source = url('/assets/images/save_filled.png');
            }else{
                $count_saved = $this->savedArtworkRepository->getData(['user_id'=> Auth::user()->id, 'artwork_id' => $this->request->artwork_id, 'status' => 'saved'],'delete',[],0);
                $img_source = url('/assets/images/saved.png');
            }
            $artwork_saved = $this->savedArtworkRepository->getData(['user_id'=> Auth::user()->id, 'status' => 'saved'],'count',[],0);
        }else{
            $saved_artwork = [];
            $saved_artwork['guest_id'] = Session::get('random_id');
            $saved_artwork['artwork_id'] = $this->request->artwork_id;
            $saved_artwork['status'] = 'saved';

            $count_saved = $this->savedArtworkRepository->getData(['guest_id'=> Session::get('random_id'), 'artwork_id' => $this->request->artwork_id, 'status' => 'saved'],'count',[],0);    
            if(empty($count_saved)){
                $artwork = $this->savedArtworkRepository->createUpdateData(['id'=> $this->request->id],$saved_artwork);
                $img_source = url('/assets/images/save_filled.png');
            }else{
                $count_saved = $this->savedArtworkRepository->getData(['guest_id'=> Session::get('random_id'), 'artwork_id' => $this->request->artwork_id, 'status' => 'saved'],'delete',[],0);
                $img_source = url('/assets/images/saved.png');
            }
            $artwork_saved = $this->savedArtworkRepository->getData(['guest_id'=> Session::get('random_id'), 'status' => 'saved'],'count',[],0);
        }
        
        return response()->json(array(
            'saved_count' => $artwork_saved,
            'img_source' => $img_source,
            'status' => 200,
        ), 200);
    }

    public function add_to_cart(){
        // dd(Session::get('random_id'));
        $message = "";
        if(Auth::user()){
            $saved_artwork = [];
            $saved_artwork['user_id'] = Auth::user()->id;
            $saved_artwork['artwork_id'] = $this->request->artwork_id;
            $saved_artwork['status'] = 'cart';

            $count_saved = $this->savedArtworkRepository->getData(['user_id'=> Auth::user()->id, 'artwork_id' => $this->request->artwork_id, 'status' => 'cart'],'count',[],0);    
            if(empty($count_saved)){
                $artwork = $this->savedArtworkRepository->createUpdateData(['id'=> $this->request->id],$saved_artwork);
                $message = "Item Added to Cart!";
                $btn_text = "REMOVE FROM CART";
            }else{
                $count_saved = $this->savedArtworkRepository->getData(['user_id'=> Auth::user()->id, 'artwork_id' => $this->request->artwork_id, 'status' => 'cart'],'delete',[],0);
                $message = "Item Removed from Cart!";
                $btn_text = "ADD TO CART";
            }
            $artwork_in_cart = $this->savedArtworkRepository->getData(['user_id'=> Auth::user()->id, 'status' => 'cart'],'count',[],0);
        }else{
            $saved_artwork = [];
            $saved_artwork['guest_id'] = Session::get('random_id');
            $saved_artwork['artwork_id'] = $this->request->artwork_id;
            $saved_artwork['status'] = 'cart';

            $count_saved = $this->savedArtworkRepository->getData(['guest_id'=> Session::get('random_id'), 'artwork_id' => $this->request->artwork_id, 'status' => 'cart'],'count',[],0);    
            if(empty($count_saved)){
                $artwork = $this->savedArtworkRepository->createUpdateData(['id'=> $this->request->id],$saved_artwork);
                $message = "Item Added to Cart!";
                $btn_text = "REMOVE FROM CART";
            }else{
                $count_saved = $this->savedArtworkRepository->getData(['guest_id'=> Session::get('random_id'), 'artwork_id' => $this->request->artwork_id, 'status' => 'cart'],'delete',[],0);
                $message = "Item Removed from Cart!";
                $btn_text = "ADD TO CART";
            }
            $artwork_in_cart = $this->savedArtworkRepository->getData(['guest_id'=> Session::get('random_id'), 'status' => 'cart'],'count',[],0);
        }
        
        return response()->json(array(
            'saved_count' => $artwork_in_cart,
            'msg' => $message,
            'btn_text' => $btn_text,
            'status' => 200,
        ), 200);
    }

    public function save_contact_form_details(){
       $contactForm = $this->contactFormRepository->createUpdateData(['id'=>  $this->request->id], $this->request->all());

         $toEmail = $this->userRepository->getData(['role'=> 'admin'],'first',[],0);   
         $comment =[];
         $comment['message'] = $this->request->message;
         $comment['mobile_number'] = $this->request->mobile_number;
         $comment['name'] = $this->request->name;
         if($toEmail){
            Mail::to($toEmail)->send(new ContactForm($comment));
         }
       return redirect()->to('/contact_us')->with('message', 'Contact Form Submit Successfully');
    }

    public static function header_counter()
    {
        $saved_count = "";
        $cart_count = "";
        $message_count = "";
        $all_messages = "";
        if(Auth::user()){
            $all_messages = Message::where(['read_status'=> 'unread', 'to_user_id'=>Auth::user()->id])->with('sender')->get();
            $message_count = Message::where(['read_status'=> 'unread', 'to_user_id'=>Auth::user()->id])->count();
            $saved_count = SavedArtwork::where(['user_id'=> Auth::user()->id, 'status' => 'saved'])->count();
            $cart_count = SavedArtwork::where(['user_id'=> Auth::user()->id, 'status' => 'cart'])->count();
        }else{
            $saved_count = SavedArtwork::where(['guest_id'=> Session::get('random_id'), 'status' => 'saved'])->count();
            $cart_count = SavedArtwork::where(['guest_id'=> Session::get('random_id'), 'status' => 'cart'])->count();
        } 
        $getArtworks  = Artwork::where(['is_deleted'=> 'no'])->get();
        $meta_description = "";
        $meta_title = "";
        $meta_artist = "";
        if(count($getArtworks) > 0){
            foreach ($getArtworks as $key => $value) {
                $meta_description .= $value->title.' ';
                $meta_title .= $value->title.', ';
                $meta_description .= $value->description.' ';
            }
        }
        $getArtist  = User::where(['role'=> 'artist'])->get();
        if(count($getArtist) > 0){
            foreach ($getArtist as $key => $value) {
                $meta_artist .= $value->first_name.' '.$value->last_name.', ';
            }
        }
        session(['saved_count' => $saved_count, 'cart_count' => $cart_count, 'meta_description' => $meta_description, 'meta_title' => $meta_title, 'meta_artist' => $meta_artist, 'message_count' => $message_count, 'all_messages' => $all_messages]);
    }
     
    public function filter_search(){
        if(!empty(Input::get('data_from'))){
            $filter_key = Input::get('filter_key');
            $data_from = Input::get('data_from');
            $i = 0;
            $artwork_name = [];
            $all_artwork = [];
            $user_filter_result = $this->userRepository->getData(['role'=> 'artist', 'filter_key' => $filter_key],'get',['artworks', 'artworks.artwork_images', 'artworks.variants', 'artworks.artist', 'artworks.artwork_like'],0);
            if(count($user_filter_result) > 0){
                foreach($user_filter_result as $key => $user_arr){
                    if(count($user_arr['artworks']) > 0){
                        foreach ($user_arr['artworks'] as $key => $artwork) {
                            $all_artwork[] = $artwork;
                            $artwork_name[$i][0] = $artwork['id'];
                            $artwork_name[$i][1] = $artwork['title'];
                            $i++;
                        }
                    }
                }
            }
            // dd($user_filter_result);
            $artwork_result = $this->artworkRepository->getData(['is_publised' => 'publish','is_deleted'=> 'no', 'filter_key' => $filter_key],'get',['artwork_images', 'variants', 'artist', 'artwork_like'],0);
            if(count($artwork_result) > 0){
                foreach ($artwork_result as $key => $value) {
                    if(count($value->variants)>0){
                        $all_artwork[] = $value;
                        $artwork_name[$i][0] = $value['id'];
                        $artwork_name[$i][1] = $value['title'];
                        $i++;
                    }
                }
            }
            // echo "<pre>";
            // print_r($all_artwork); die;
            if($data_from == "form"){
                $all_artwork = array_map("unserialize", array_unique(array_map("serialize", $all_artwork)));
                if(count($all_artwork) > 0){
                    foreach ($all_artwork as $key => $artwork_result) {
                        if(Auth::user()){
                            $artwork_result['like_count'] = SavedArtwork::where(['artwork_id' => $artwork_result->id, 'status' => 'like'])->pluck('user_id')->toArray();
                            $artwork_result['save_count'] = SavedArtwork::where(['artwork_id' => $artwork_result->id, 'status' => 'saved'])->pluck('user_id')->toArray();
                        }else{
                            $artwork_result['like_count'] = SavedArtwork::where(['artwork_id' => $artwork_result->id, 'status' => 'like'])->pluck('guest_id')->toArray();
                            $artwork_result['save_count'] = SavedArtwork::where(['artwork_id' => $artwork_result->id, 'status' => 'saved'])->pluck('guest_id')->toArray();
                        }    
                    }
                }
                $categories = $this->categoryRepository->getData(['is_active'=>'yes'],'get',['subcategories'],0);
                $styles= $this->styleRepository->getData(['is_active'=>'yes'], 'get', [], 0);
                $subjects= $this->subjectRepository->getData(['is_active'=>'yes'], 'get', [], 0);

                return view('frontend/artwork_lists', compact('all_artwork', 'categories', 'styles', 'subjects'));
            }else{
                $artwork_name = array_map("unserialize", array_unique(array_map("serialize", $artwork_name)));
                $html = "";
                $html .= "<ul>";
                if(count($artwork_name) > 0){
                    foreach ($artwork_name as $key => $artwork) {
                        $url = url('artwork_details').'/'.$artwork[0];
                        $html .= "<li><a href='".$url."'>".$artwork[1]."</a></li>";
                    }
                }else{
                    $html .= "<li><a href='javascript::void(0)'>No Result Found</a></li>";
                }
                $html .= "</ul>";
                return response()->json(array(
                    'result' => $html,
                    'status' => 200,
                ), 200);
            }
        }else{
            return redirect('/');
        }
            
    }

    public function remove_from_cart($artwork_id){
        $message = "";
        if(Auth::user()){
            $remove_item = $this->savedArtworkRepository->getData(['user_id'=> Auth::user()->id, 'artwork_id' => $artwork_id, 'status' => 'cart'],'delete',[],0);    
        }else{
            $remove_item = $this->savedArtworkRepository->getData(['guest_id'=> Session::get('random_id'), 'artwork_id' => $artwork_id, 'status' => 'cart'],'delete',[],0);    
        }
        return redirect('/cart');
    }

    public function exhibitions(){
       $blogs = $this->BlogRepository->getData(['is_deleted'=>'no','is_active'=>'yes','page'=>6],'paginate',['user'],0);
       //dd($blogs);
       return view('gallery.exhibitions',compact('blogs'));
    }

    public function exhibition_details($id){
        $blog_detail = $this->BlogRepository->getData(['id'=>$id,'is_deleted'=>'no'],'first',['user'],0);
        $leatests = $this->BlogRepository->getData(['except'=>$id, 'is_deleted'=>'no'],'get',['user'],0);
        // echo "<pre>";
        // print_r($leatests); die;
       return view('gallery.exhibition_details',compact('blog_detail','leatests'));
    }


    public function like_users(){
        $id = $this->request->user_id;
        $type = $this->request->btn_type;
        if($type == "followers"){
            $result = $this->savedArtistRepository->getData(['artist_id'=>$id],'get',['users'],0);
        }
        if($type == "like"){
            $result = $this->artworkRepository->getData(['user_id'=>$id, 'is_deleted'=>'no'],'get',['artwork_like', 'artwork_like.users'],0);  
            // echo "<pre>";
            // print_r($result);die;
        }
        if($type == "follow"){
            $result = $this->savedArtistRepository->getData(['user_id'=>$id],'get',['artist'],0);    
        }
           
        $html = view('frontend.profile_like_modal', compact('result', 'type'))->render();

        

        return response()->json(array(
            'html' => $html,
            'status' => 200,
        ), 200);
    }

     public function req_comm($user_id, $artist_id)
     {
        $request_comm['user_id'] = $user_id;
        $request_comm['artist_id'] = $artist_id;
        $req_comm = $this->requestComissionRepository->getData(['user_id'=> $user_id, 'artist_id' => $artist_id, 'request_status'=> null ],'first',[],0);
        if(empty($req_comm) ){
            $req_comm_records = $this->requestComissionRepository->createUpdateData(['id'=> $this->request->id],$request_comm);

        $req_stat_info = $this->requestComissionRepository->getData(['id'=> $this->request->id],'first',['artist','users'],0);
        $user_info = [];
        $user_info['artist_name'] = $req_stat_info->artist->first_name.' '.$req_stat_info->artist->last_name;
        $user_info['user_name'] = $req_stat_info->users->first_name;
        $user_info['alias'] = $req_stat_info->users->user_name;
        // $user_info['role'] = $req_stat_info->users->role;
         $user_info['artist_id'] = $req_stat_info->artist->id;
        // $user_info['status'] = $req_stat_info->request_status;

        $user_info_mail = $this->userRepository->getData(['id'=>$req_stat_info->artist->id],'first',[],0);
        if($user_info_mail){
                Mail::to($user_info_mail)->send(new ArtistRequestCommNotification($user_info));
        }

        }else{

        }
        \Session::flash('success_message', 'Comission Requested Successfully.');
        return back()->withInput(); 
        // return redirect('profile_details/'.$this->request->artist_id);
    }


    public function mark_all_as_read(){
        
        $result = Message::where(['to_user_id'=>Auth::user()->id])->update(['read_status' => 'read']);

        // $result = $this->messageRepository->createUpdateData(['to_user_id'=>Auth::user()->id],$read_status);
        return response()->json(array(
            'status' => 200,
        ), 200);
    }

    public function buy_now($id){
        if(Auth::user()){
            $saved_artwork = [];
            $saved_artwork['user_id'] = Auth::user()->id;
            $saved_artwork['artwork_id'] = $id;
            $saved_artwork['status'] = 'cart';

            $count_saved = $this->savedArtworkRepository->getData(['user_id'=> Auth::user()->id, 'artwork_id' => $id, 'status' => 'cart'],'count',[],0);    
            if(empty($count_saved)){
                $artwork = $this->savedArtworkRepository->createUpdateData(['id'=> $this->request->id],$saved_artwork);
            }else{
                
            }
            
        }else{
            $saved_artwork = [];
            $saved_artwork['guest_id'] = Session::get('random_id');
            $saved_artwork['artwork_id'] = $id;
            $saved_artwork['status'] = 'cart';

            $count_saved = $this->savedArtworkRepository->getData(['guest_id'=> Session::get('random_id'), 'artwork_id' => $id, 'status' => 'cart'],'count',[],0);    
            if(empty($count_saved)){
                $artwork = $this->savedArtworkRepository->createUpdateData(['id'=> $this->request->id],$saved_artwork);
            }else{
            
            }
        }
        return redirect('/cart');
    }

    public function facebook_login(){
        if(Auth::user()){
            $saved_artwork = [];
            $saved_artwork['user_id'] = Auth::user()->id;
            $saved_artwork['artwork_id'] = $id;
            $saved_artwork['status'] = 'cart';

            $count_saved = $this->savedArtworkRepository->getData(['user_id'=> Auth::user()->id, 'artwork_id' => $id, 'status' => 'cart'],'count',[],0);    
            if(empty($count_saved)){
                $artwork = $this->savedArtworkRepository->createUpdateData(['id'=> $this->request->id],$saved_artwork);
            }else{
                
            }
            
        }else{
            $saved_artwork = [];
            $saved_artwork['guest_id'] = Session::get('random_id');
            $saved_artwork['artwork_id'] = $id;
            $saved_artwork['status'] = 'cart';

            $count_saved = $this->savedArtworkRepository->getData(['guest_id'=> Session::get('random_id'), 'artwork_id' => $id, 'status' => 'cart'],'count',[],0);    
            if(empty($count_saved)){
                $artwork = $this->savedArtworkRepository->createUpdateData(['id'=> $this->request->id],$saved_artwork);
            }else{
            
            }
        }
        return redirect('/cart');
    }


    public function set_userrole(){
        Session::put('user_role', $this->request->role);        
        return response()->json(array(
            'status' => 200,
            'result' => $this->request->role,
        ), 200);
    }
}
