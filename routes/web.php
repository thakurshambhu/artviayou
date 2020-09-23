<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Auth::routes();
// Route::group(['middleware' => ['UserSlug']],function(){ 
	Auth::routes();
	/*************Common Login Controller Routes Start************************/
	Route::get('/user_login','CommonLoginController@login');
	Route::post('/submit_login','CommonLoginController@submitLogin');
	Route::post('/check_email', 'CommonLoginController@check_email_status');
	Route::post('/check_username', 'CommonLoginController@check_username_status');
	Route::get('/logout','CommonLoginController@logout');
	/*************Common Login Controller Routes End************************/

	// Route::get('/profile/{slug}', 'Frontend\HomeController@user_profile')->where('slug', '^[-@./#&+\w\s]*$');
	Route::get('/checkphp','CommonLoginController@phpinfo');



	Route::group(['namespace' => 'Artist','prefix' => 'artist', 'middleware' => ['ArtistCheck','verified','auth']],function(){ 

		Route::get('/dashboard','ArtistUserController@index');
		Route::get('/add_artwork','ArtistUserController@add_artwork');
		Route::post('/upload_artwork','ArtistUserController@upload_artwork');
		Route::post('/getSubcategory','ArtistUserController@getSubcategory');
		Route::get('/profile/{id}','ArtistUserController@profile')->where('id', '[0-9]+');
		Route::post('/update_artist','ArtistUserController@update_artist');
		Route::get('/artworks/{id?}','ArtistUserController@artworks');
		Route::get('/change_artwork_status/{id}/{stauts}/{page}/{user_id?}', 'ArtistUserController@change_artwork_status');
		Route::get('/delete_artwork/{id}', 'ArtistUserController@delete_artwork');
		Route::get('/view_artwork/{id}', 'ArtistUserController@view_artwork');
		Route::get('/edit_artwork/{id}', 'ArtistUserController@edit_artwork');
		Route::put('profile/password','ArtistUserController@password');
		Route::post('/deleteImage','ArtistUserController@deleteImage');
		Route::get('/chat', 'ArtistUserController@getChat')->name('chat');
		Route::get('/order_list', 'ArtistUserController@order_list');
		Route::get('/req_comm_list', 'ArtistUserController@req_comm_list');
		Route::get('/change_commition_status/{id}/{stauts}', 'ArtistUserController@change_commition_status');

	});

	Route::post('/buyer/sub-categories','Buyer\BuyerFilterController@getSubCategories');

	Route::group(['namespace' => 'Buyer','prefix' => 'buyer', 'middleware' => ['verified','BuyerCheck']],function(){ 

		Route::get('/dashboard','BuyerUserController@index');
		Route::get('/profile/{id}', 'BuyerUserController@profile')->where('id', '[0-9]+');
		Route::post('/update_buyer', 'BuyerUserController@update_buyer');
		Route::put('profile/password','BuyerUserController@password');
		Route::get('/chat', 'BuyerUserController@getChat')->name('chat');
		Route::get('/order_list', 'BuyerUserController@order_list');


	});

	Route::group(['namespace' => 'Gallery','prefix' => 'gallery', 'middleware' => ['verified','GalleryCheck']],function(){ 

		Route::get('/dashboard','GalleryUserController@index');
		Route::get('/profile/{id}', 'GalleryUserController@profile')->where('id', '[0-9]+');
		Route::post('/update_gallery', 'GalleryUserController@update_gallery');
		Route::put('profile/password','GalleryUserController@password');
		Route::get('/add_blog','GalleryUserController@add_blog');
		Route::post('/update_blog','GalleryUserController@update_blog');
		Route::get('/blog','GalleryUserController@blog');
		Route::get('/edit_blog/{id}','GalleryUserController@edit_blog');
		Route::get('/delete_blog/{id}','GalleryUserController@delete_blog');
		Route::get('/change_blog_status/{id}/{status}','GalleryUserController@change_blog_status');
		Route::get('/chat', 'GalleryUserController@getChat')->name('chat');
		Route::get('/order_list', 'GalleryUserController@order_list');
		

	});

	Route::get('/auth/redirect/{provider}', 'CommonLoginController@redirect');
	Route::get('/callback/{provider}', 'CommonLoginController@callback');


	Route::post('set_userrole', 'Frontend\HomeController@set_userrole');
	Route::get('pay_now', 'Frontend\PaymentController@index');
	Route::post('paypal', 'Frontend\PaymentController@payWithpaypal');
	Route::get('status', 'Frontend\PaymentController@getPaymentStatus');
	Route::get('payout/{order_id}', 'Frontend\PaymentController@payout');

	Route::get('/', 'Frontend\HomeController@index');
	Route::get('/about_us', 'Frontend\HomeController@about_us');
	Route::get('/faq', 'Frontend\HomeController@faq');
	Route::get('/terms_conditions', 'Frontend\HomeController@terms_conditions');
	Route::get('/privacy_policy', 'Frontend\HomeController@privacy_policy');
	Route::get('/artist', 'Frontend\HomeController@artist');
	Route::get('/saved_artist', 'Frontend\HomeController@saved_artist');
	Route::get('/profile_details/{id?}', 'Frontend\HomeController@profile_details');
	Route::post('/like_artist', 'Frontend\HomeController@like_artist');
	Route::post('/save_artist', 'Frontend\HomeController@save_artist');
	Route::post('/like_artwork', 'Frontend\HomeController@like_artwork');
	Route::post('/save_artwork', 'Frontend\HomeController@save_artwork');
	Route::post('/add_to_cart', 'Frontend\HomeController@add_to_cart');
	Route::get('/contact_us', 'Frontend\HomeController@contact_us');
	Route::post('/save_contact_form', 'Frontend\HomeController@save_contact_form_details');
	Route::post('/get_shipping_status', 'Frontend\ArtworkController@get_shipping_status');
	Route::post('/update_shipping_status', 'Frontend\ArtworkController@update_shipping_status');
	Route::post('/like_users', 'Frontend\HomeController@like_users');
	Route::get('/req_comm/{user_id}/{artist_id}', 'Frontend\HomeController@req_comm');

	Route::get('/mark_all_as_read', 'Frontend\HomeController@mark_all_as_read');
	Route::get('/filter_search/{key?}/{type?}', 'Frontend\HomeController@filter_search');
	Route::get('/saved_artwork', 'Frontend\ArtworkController@saved_artwork');
	Route::get('/cart', 'Frontend\ArtworkController@items_cart');
	Route::get('/artwork_details/{key}', 'Frontend\ArtworkController@artwork_details');
	Route::get('/artworks/{id?}', 'Frontend\ArtworkController@artworks');
	Route::get('/remove_from_cart/{id}', 'Frontend\HomeController@remove_from_cart');
	Route::get('/buy_now/{id}', 'Frontend\HomeController@buy_now');
	Route::get('/facebook_login', 'Frontend\HomeController@facebook_login');


	Route::get('/exhibitions','Frontend\HomeController@exhibitions');
	Route::get('/exhibition_details/{id}','Frontend\HomeController@exhibition_details');

	// Route::get('/', function () {
	//     return view('welcome');
	// });

	Route::get('/home', 'HomeController@index')->name('home');
	Route::get('/admin', 'Auth\LoginController@admin')->name('admin');

	Route::group(['prefix'=>'admin','middleware' => ['auth', 'AdminCheck']], function () {
		Route::resource('user', 'UserController', ['except' => ['show']]);
		Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
		Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
		Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);

		// Buyer Management
		Route::get('/buyer', 'Admin\BuyerController@index');
		Route::get('/add_buyer', 'Admin\BuyerController@add_buyer');
		Route::post('/update_buyer', 'Admin\BuyerController@update_buyer');
		Route::get('/edit_buyer/{id}', 'Admin\BuyerController@edit_buyer');
		Route::get('/delete_buyer/{id}', 'Admin\BuyerController@delete_buyer');
		Route::get('/change_buyer_status/{id}/{stauts}', 'Admin\BuyerController@change_buyer_status');
		
		// Gallery User Management
		Route::get('/gallery', 'Admin\GalleryUserController@index');
		Route::get('/add_gallery', 'Admin\GalleryUserController@add_gallery');
		Route::post('/update_gallery', 'Admin\GalleryUserController@update_gallery');
		Route::get('/edit_gallery/{id}', 'Admin\GalleryUserController@edit_gallery');
		Route::get('/delete_gallery/{id}', 'Admin\GalleryUserController@delete_gallery');
		Route::get('/change_gallery_status/{id}/{stauts}', 'Admin\GalleryUserController@change_gallery_status');
		
		// Artist Management
		Route::get('/artist', 'Admin\ArtistController@index');
		Route::get('/add_artist', 'Admin\ArtistController@add_artist');
		Route::post('/update_artist', 'Admin\ArtistController@update_artist');
		Route::get('/edit_artist/{id}', 'Admin\ArtistController@edit_artist');
		Route::get('/delete_artist/{id}', 'Admin\ArtistController@delete_artist');
		Route::get('/change_artist_status/{id}/{stauts}', 'Admin\ArtistController@change_artist_status');
		Route::get('/change_featured_status/{id}/{stauts}', 'Admin\ArtistController@change_featured_status');
		// Artwork Management
		Route::get('/artwork/{artist_id}', 'Admin\ArtworkController@index');
		Route::get('/view_artwork/{artist_id}', 'Admin\ArtworkController@view_artwork');
		Route::get('/get_gallery_images/{artist_id}', 'Admin\ArtworkController@get_gallery_images');
		Route::get('/change_artwork_status/{id}/{stauts}/{page}/{user_id?}', 'Admin\ArtworkController@change_artwork_status');
		Route::get('/change_top_status/{id}/{stauts}/{page}/{user_id?}', 'Admin\ArtworkController@change_top_status');
		Route::get('/change_trending_status/{id}/{stauts}/{page}/{user_id?}', 'Admin\ArtworkController@change_trending_status');
		Route::get('/manage_artworks', 'Admin\ArtworkController@manage_artworks');
		Route::get('/top_artwork', 'Admin\ArtworkController@top_artwork');
		Route::get('/delete_artwork/{id}/{page}/{user_id?}', 'Admin\ArtworkController@delete_artwork');
		Route::get('/trending_artwork', 'Admin\ArtworkController@trending_artwork');
		//category Management
		Route::get('/add_category','Admin\CategoryController@add_category');
		Route::post('/update_category','Admin\CategoryController@update_category');
		Route::get('/category','Admin\CategoryController@index');
		Route::get('/edit_category/{id}', 'Admin\CategoryController@edit_category');
		Route::get('/delete_category/{id}', 'Admin\CategoryController@delete_category');
		Route::get('/change_category_status/{id}/{stauts}', 'Admin\CategoryController@change_category_status');
		//Subject Management
		Route::get('/add_subject','Admin\SubjectController@add_subject');
		Route::post('/update_subject','Admin\SubjectController@update_subject');
		Route::get('/subject','Admin\SubjectController@index');
		Route::get('/edit_subject/{id}', 'Admin\SubjectController@edit_subject');
		Route::get('/delete_subject/{id}', 'Admin\SubjectController@delete_subject');
		Route::get('/change_subject_status/{id}/{stauts}', 'Admin\SubjectController@change_subject_status');
		//Style Management
		Route::get('/add_style','Admin\StyleController@add_style');
		Route::post('/update_style','Admin\StyleController@update_style');
		Route::get('/style','Admin\StyleController@index');
		Route::get('/edit_style/{id}', 'Admin\StyleController@edit_style');
		Route::get('/delete_style/{id}', 'Admin\StyleController@delete_style');
		Route::get('/change_style_status/{id}/{stauts}', 'Admin\StyleController@change_style_status');
		//SubCategory Management
		Route::get('/add_subcategory','Admin\SubCategoryController@add_subcategory');
		Route::post('/update_subcategory','Admin\SubCategoryController@update_subcategory');
		Route::get('/subcategory','Admin\SubCategoryController@index');
		Route::get('/edit_subcategory/{id}', 'Admin\SubCategoryController@edit_subcategory');
		Route::get('/delete_subcategory/{id}', 'Admin\SubCategoryController@delete_subcategory');
		Route::get('/change_subcategory_status/{id}/{stauts}', 'Admin\SubCategoryController@change_subcategory_status');
		//CMS Management
		// Route::get('/add_aboutus', 'Admin\CmsController@add_aboutus');
		Route::post('/update_aboutus', 'Admin\CmsController@update_aboutus');
		Route::get('/manage_cms/{slug}','Admin\CmsController@manage_cms');
		Route::post('/update_cms','Admin\CmsController@update_cms');
		Route::post('/update_home','Admin\CmsController@update_home'); 

		//Faq management

		Route:: get('/add_faq', 'Admin\FaqController@add_faq');
		Route::post('/update_faq', 'Admin\FaqController@update_faq');
		Route::get('/edit_faq/{id}', 'Admin\FaqController@edit_faq');
		Route::get('/faq','Admin\FaqController@faq');
		Route::get('/delete_faq/{id}', 'Admin\FaqController@delete_faq');
		Route::get('/change_faq_status/{id}/{stauts}', 'Admin\FaqController@change_faq_status');

	   Route:: get('/site_setting', 'Admin\CmsController@site_setting');
	   Route:: post('/update_site_setting', 'Admin\CmsController@update_site_setting');

	   Route:: get('/payment_history', 'Admin\ArtworkController@payment_history');



	});

	// Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail');
	// Route::get('password/reset/{token}', 'ForgotPasswordController@sendResetLinkEmail');

	Route::group(['middleware' => 'auth'], function () {
		Route::get('{page}', ['as' => 'page.index', 'uses' => 'PageController@index']);
	});


// });

Route::get('/profile/{slug}', 'Frontend\HomeController@user_profile');
