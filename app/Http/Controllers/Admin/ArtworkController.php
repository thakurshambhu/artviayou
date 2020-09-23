<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\GalleryUserRepository;
use App\Repository\ArtworkRepository;
use App\Repository\ArtworkImageRepository;
use App\Repository\VariantRepository;
use App\Repository\OrderRepository;
use Validator;
use Exception;
use Session;
use Mail;
use DB;
use Hash;
use Cookie;
use Segment;
use DateTime;

class ArtworkController extends Controller
{
    /**
    * Construction function
    * @param $request(Array), $galleryUserRepository
    * @return 
    *
    * Created By: Ram Krishna Murthy
    * Created At: 
    */
    public function __construct(Request $request, GalleryUserRepository $galleryUserRepository, ArtworkRepository $artworkRepository, ArtworkImageRepository $artworkImageRepository, VariantRepository $variantRepository,OrderRepository $orderRepository)
    {
        $this->request = $request;
        $this->galleryUserRepository = $galleryUserRepository;
        $this->artworkRepository = $artworkRepository;
        $this->artworkImageRepository = $artworkImageRepository;
        $this->variantRepository = $variantRepository;
        $this->orderRepository = $orderRepository;
    }

    /**
    * Function to artwork listing page
    * @param $request(Array)
    * @return 
    *
    * Created By: Ram Krishna Murthy
    * Created At: 
    */
    public function index($artist_id)
    {
    	$artworks = $this->artworkRepository->getData(['user_id'=>$artist_id],'get',['category_detail', 'sub_category_detail'],0);
    	
        return view('backend/artworks', compact('artworks', 'artist_id'));
    }

    /**
    * Function to artwork detail page
    * @param $request(Array)
    * @return 
    *
    * Created By: Ram Krishna Murthy
    * Created At: 
    */
    public function view_artwork($artwork_id)
    {
    	$artworks = $this->artworkRepository->getData(['id'=>$artwork_id],'first',['category_detail', 'sub_category_detail', 'artist', 'artwork_images', 'variants', 'artwork_images', 'style_detail', 'subject_detail'],0);


        // $artworks = $this->artworkRepository->getData(['top'=>'yes', 'is_deleted'=>'no'],'get',['category_detail', 'sub_category_detail', 'artist', 'artwork_images', 'variants', 'artwork_images', 'style_detail', 'subject_detail'],0);
        // echo "<pre>";
        // print_r($artworks); die;

    	$artist_id = $artworks['user_id'];
        return view('backend/artwork_detail', compact('artworks', 'artist_id'));
    }

    /**
    * Function to artwork detail page
    * @param $request(Array)
    * @return 
    *
    * Created By: Ram Krishna Murthy
    * Created At: 
    */
    public function get_gallery_images($artwork_id)
    {
    	$gallery = $this->artworkImageRepository->getData(['artwork_id'=>$artwork_id],'get',[],0);
    	return view('backend/ajax/gallery_slider', compact('gallery'));
    }

    /**
    * Function to change artists status
    * @param $request(Array)
    * @return 
    *
    * Created By: Ram Krishna Murthy
    * Created At: 
    */
    public function change_artwork_status($id, $status, $page, $user_id)
    {
    	if($status == 'publish'){
    		$data['is_publised'] = 'unpublish';
            $new_status = "Un-Published";
    	}else{
    		$data['is_publised'] = 'publish';
            $new_status = "Published";
    	}
    	$artist = $this->artworkRepository->createUpdateData(['id'=> $id],$data);
    	\Session::flash('success_message', 'Artwork Status Changed to '.$new_status.' Succssfully!.'); 
    	if($page == "list"){
            return redirect('/admin/artwork/'.$user_id);
        }elseif($page == "manage_artworks"){
            return redirect('/admin/manage_artworks');
        }elseif($page == "trending_artwork"){
            return redirect('/admin/trending_artwork');
        }elseif($page == "top_artwork"){
            return redirect('/admin/top_artwork');
        }else{
            return redirect('/admin/view_artwork/'.$id);
        }
    }

    /**
    * Function to artwork listing page
    * @param $request(Array)
    * @return 
    *
    * Created By: Ram Krishna Murthy
    * Created At: 
    */
    public function manage_artworks()
    {
        $artworks = $this->artworkRepository->getData([],'get',['artist', 'category_detail', 'sub_category_detail'],0);
        return view('backend/manage_artworks', compact('artworks'));
    }

    /**
    * Function to artwork listing page
    * @param $request(Array)
    * @return 
    *
    * Created By: Ram Krishna Murthy
    * Created At: 
    */
    public function top_artwork()
    {
        $artworks = $this->artworkRepository->getData(['top'=>'yes'],'get',['artist', 'category_detail', 'sub_category_detail'],0);
        return view('backend/top_artworks', compact('artworks'));
    }

    /**
    * Function to artwork listing page
    * @param $request(Array)
    * @return 
    *
    * Created By: Ram Krishna Murthy
    * Created At: 
    */
    public function trending_artwork()
    {
        $artworks = $this->artworkRepository->getData(['trending'=>'yes'],'get',['artist', 'category_detail', 'sub_category_detail'],0);
        return view('backend/trending_artworks', compact('artworks'));
    }

    /**
    * Function to change artists status
    * @param $request(Array)
    * @return 
    *
    * Created By: Ram Krishna Murthy
    * Created At: 
    */
    public function change_top_status($id, $status, $page, $user_id)
    {
        if($status == 'yes'){
            $data['top'] = 'no';
            $new_status = "Artwork Removed From Top Listing";
        }else{
            $data['top'] = 'yes';
            $new_status = "Artwork Added To Top Listing";
        }
        $artist = $this->artworkRepository->createUpdateData(['id'=> $id],$data);
        \Session::flash('success_message', $new_status); 
        if($page == "list"){
            return redirect('/admin/artwork/'.$user_id);
        }elseif($page == "manage_artworks"){
            return redirect('/admin/manage_artworks');
        }elseif($page == "trending_artwork"){
            return redirect('/admin/trending_artwork');
        }elseif($page == "top_artwork"){
            return redirect('/admin/top_artwork');
        }else{
            return redirect('/admin/view_artwork/'.$id);
        }
    }

    /**
    * Function to change artists status
    * @param $request(Array)
    * @return 
    *
    * Created By: Ram Krishna Murthy
    * Created At: 
    */
    public function change_trending_status($id, $status, $page, $user_id)
    {
        if($status == 'yes'){
            $data['trending'] = 'no';
            $new_status = "Artwork Removed From Featured List";
        }else{
            $data['trending'] = 'yes';
            $new_status = "Artwork Added To Featured List";
        }

        $all_artworks = $this->artworkRepository->getData(['trending'=>'yes'],'count',[],0);
        if($all_artworks > 0){
            $trending['trending'] = 'no';
            $artwork = $this->artworkRepository->createUpdateData(['trending'=> 'yes'],$trending);
        }
        $artist = $this->artworkRepository->createUpdateData(['id'=> $id],$data);
        \Session::flash('success_message', $new_status); 
        if($page == "list"){
            return redirect('/admin/artwork/'.$user_id);
        }elseif($page == "manage_artworks"){
            return redirect('/admin/manage_artworks');
        }elseif($page == "trending_artwork"){
            return redirect('/admin/trending_artwork');
        }elseif($page == "top_artwork"){
            return redirect('/admin/top_artwork');
        }else{
            return redirect('/admin/view_artwork/'.$id);
        }
    }
    public function payment_history(){
        $payment_history = $this->orderRepository->getData(['users'],'get',[],0);
        return view('backend/payment_history', compact('payment_history'));
    }

    /**
    * Function to delete_artwork
    * @param $request(Array)
    * @return 
    *
    * Created By: Ram Krishna Murthy
    * Created At: 
    */
    public function delete_artwork($id, $page, $user_id)
    {
        $artist = $this->artworkRepository->getData(['id'=> $id],'delete',[],0);
        \Session::flash('success_message', "Artwork Deleted Successfully"); 
        if($page == "list"){
            return redirect('/admin/artwork/'.$user_id);
        }elseif($page == "manage_artworks"){
            return redirect('/admin/manage_artworks');
        }elseif($page == "trending_artwork"){
            return redirect('/admin/trending_artwork');
        }elseif($page == "top_artwork"){
            return redirect('/admin/top_artwork');
        }else{
            return redirect('/admin/view_artwork/'.$id);
        }
    }

}
