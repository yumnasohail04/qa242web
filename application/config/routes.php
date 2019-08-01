<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

/////////////// ADMIN PAGES ////////////////
//$route['admin/login/submit_login'] = "login/submit_login";

	
	
	$route['admin'] = "login";
	$strHost = $_SERVER['SERVER_NAME'];
	$strHost = preg_replace('/www./', '', $strHost, 1);

	//$strHost == 'mixmat.no' ||

	 	$route['admin'] = "login";
		$route['admin/logout'] = "login/logout";
		$route['admin/(:any)'] = "$1/$1";
		////////////user profile routes by umar fAROOQ FOR WEB//////////
	    $front_folder = 'front/';
	    $route['index']=$front_folder.'index';
	    $route['default_controller'] = 'login';
		$route['404_override'] = '';


		///////////////////////////umar apis start/////////////////////////
		$api_folder = 'api/';
		$route['outlet-categories-product'] = $api_folder."outlet_categories_product";
		$route['user-login-action'] = $api_folder."user_login_action";
		$route['slider-types'] = $api_folder."slider_types";
		$route['outlet-favourite'] = $api_folder."outlet_favourite";
		$route['get-restaurants'] = $api_folder."get_restaurants";
		$route['outlet-detail'] = $api_folder."outlet_detail";
		$route['outlet-update'] = $api_folder."outlet_update";
		$route['outlet-types'] = $api_folder."outlet_types";
		$route['product-add-on-and-items'] = $api_folder."product_add_on_and_items";
		$route['customer-location'] = $api_folder."customer_location";
		$route['customer-default-location'] = $api_folder."customer_default_location";
		$route['customer-location-delete'] = $api_folder."customer_location_delete";
		$route['customer-password-reset'] = $api_folder."customer_password_reset";
		$route['restaurant-report'] = $api_folder."restaurant_report";
		$route['restaurant-report-delete'] = $api_folder."restaurant_report_delete";
		$route['user-profile-pic-update'] = $api_folder."user_profile_pic_update";
		$route['user-profile-info'] = $api_folder."user_profile_info";
		$route['user-profile-info-update'] = $api_folder."user_profile_info_update";
		$route['user-referal-code-info'] = $api_folder."user_referal_code_info";
		$route['add-user-referal-code'] = $api_folder."add_user_referal_code";
		$route['user-favourites-products'] = $api_folder."user_favourites_products";
		$route['user-favourite-products-add-or-delete'] = $api_folder."user_favourite_products_add_or_delete";
		$route['outlet-categories'] = $api_folder."outlet_categories";
		$route['get-catagory-outlets'] = $api_folder."get_catagory_outlets";
		$route['set-all-product-timing'] = $api_folder."set_all_product_timing";
		$route['checkout-detail'] = $api_folder."get_product_detail";
		$route['search-for-resturants'] = $api_folder."search_for_resturants";
		$route['checkout-info'] = $api_folder."checkout_info";
		$route['distance-wise-charges'] = $api_folder."distance_wise_charges";
		$route['promo-code-discount'] = $api_folder."promo_code_discount";
		$route['get-user-orders'] = $api_folder."get_user_orders";
		$route['order-detail'] = $api_folder."order_detail";
		$route['register-user-data'] = $api_folder."register_user_data";
		$route['resend-user-email'] = $api_folder."resend_user_email";
		$route['code-verification'] = $api_folder."code_verification";
		$route['password-reset-email'] = $api_folder."password_reset_email";
		$route['get-restaurant-catagories'] = $api_folder."get_restaurant_catagories";
		$route['register-restaurant'] = $api_folder."register_restaurant";
		$route['search-outlet'] = $api_folder."search_outlet";
		//////asad
		$route['place-order'] = $api_folder."place_order";
		$route['payment-responce'] = $api_folder."get_payment_responce";
		$route['payment-error'] = $api_folder."payment_error";
		$route['cancelurl'] = $api_folder  ."cancelurl";
		$route['accept-url'] = $api_folder."payment_accepturl";
		$route['favourite-outlets'] = $api_folder."get_favourite_outlets";
		$route['insert-order-rating'] = $api_folder."insert_order_rating";
		//////asad
		
		$route['driver-login'] = $api_folder."driver_login";
		$route['update-driver-profile'] = $api_folder."update_driver_profile";
		$route['driver-status-update'] = $api_folder."driver_status_update";
		$route['update-driver-profile-picture'] = $api_folder."update_driver_profile_picture";
		$route['driver-basic-profile'] = $api_folder."driver_basic_profile";
		$route['update-driver-password'] = $api_folder."update_driver_password";
		$route['driver-vehicles-information'] = $api_folder."driver_vehicles_information";
		$route['driver-active-vehicle'] = $api_folder."driver_active_vehicle";
		$route['update-driver-active-vehicle'] = $api_folder."update_driver_active_vehicle";
		$route['rating-outlet'] = $api_folder."rating_outlet";
		$route['country-list'] = $api_folder."country_list";
		$route['country-cities'] = $api_folder."country_cities";
		$route['city-towns'] = $api_folder."city_towns";
		$route['town-post-codes'] = $api_folder."town_post_codes";
		$route['get-dietary-list'] = $api_folder."get_dietary_list";
		$route['get-drivers-orders'] = $api_folder."get_drivers_orders";
		$route['driver-order-detail'] = $api_folder."driver_order_detail";
		$route['get-driver-notification'] = $api_folder."get_driver_notification";
		$route['driver-order-accept-or-reject'] = $api_folder."driver_order_accept_or_reject";
		$route['driver-password-reset-email'] = $api_folder."driver_password_reset_email";
		$route['changed-order-status'] = $api_folder."changed_order_status";
		$route['get-areas'] = $api_folder."get_areas";
		$route['offer-like-or-dislike'] = $api_folder."offer_like_or_dislike";
		$route['offer-share'] = $api_folder."offer_share";
		$route['product-share'] = $api_folder."product_share";
		$route['announcement-share'] = $api_folder."announcement_share";
		$route['trending-products'] = $api_folder."trending_products";
		///////////////////////////end umar apis/////////////////////////
		
		///////////////////////////admin apis start/////////////////////////
		$admin_api_folder = "admin_api/";
		$route['outlet-admin-login'] = $admin_api_folder."admin_login";
		$route['user-profile-update'] = $admin_api_folder."user_profile_update";
		$route['user-picture-update'] = $admin_api_folder."user_picture_update";
		$route['admin-password-reset-email'] = $admin_api_folder."admin_password_reset_email";
		$route['admin-password-code-verification'] = $admin_api_folder."admin_password_code_verification";
		$route['admin-verification-password-update'] = $admin_api_folder."admin_verification_password_update";
		$route['get-user-notification'] = $admin_api_folder."get_user_notification";
		$route['mobile-user-logout'] = $admin_api_folder."mobile_user_logout";
		$route['get-users-list'] = $admin_api_folder."get_users_list";		
		$route['change-status-for-review'] = $admin_api_folder."change_status_for_review";
		$route['change-status-for-approve'] = $admin_api_folder."change_status_for_approve";
		$route['update-user-password'] = $admin_api_folder."update_user_password";
		$route['user-chat-list'] = $admin_api_folder."user_chat_list";
		$route['send-user-message'] = $admin_api_folder."send_user_message";
		$route['submit-truck-inspection'] = $admin_api_folder."submit_truck_inspection";
		$route['submit-shipping-inspection'] = $admin_api_folder."submit_shipping_inspection";
		$route['submit-palletizing-inspection'] = $admin_api_folder."submit_palletizing_inspection";
		$route['submit-cleaning-inspection'] = $admin_api_folder."submit_cleaning_inspection";
		$route['submit-bulk-inspection'] = $admin_api_folder."submit_bulk_inspection";
		$route['submit-bulk-form-inspection'] = $admin_api_folder."submit_bulk_form_inspection";
		$route['submit-recode-inspection'] = $admin_api_folder."submit_recode_inspection";
		$route['submit-media-file'] = $admin_api_folder."submit_media_file";
		$route['delete-media-file'] = $admin_api_folder."delete_media_file";
		
		
		
		$route['basic-outlet-detail'] = $admin_api_folder."basic_outlet_detail";
		$route['outlet-order-list'] = $admin_api_folder."outlet_order_list";
		$route['outlet-order-detail'] = $admin_api_folder."outlet_order_detail";
		$route['outlet-driver-list'] = $admin_api_folder."outlet_driver_list";
		$route['outlet-driver-detail'] = $admin_api_folder."outlet_driver_detail";
		$route['assign-order-to-driver'] = $admin_api_folder."assign_order_to_driver";
		$route['admin-outlet-detail'] = $admin_api_folder."admin_outlet_detail";
		$route['outlet-user-profile-detail'] = $admin_api_folder."outlet_user_profile_detail";
		$route['outlet-open-close-status-change'] = $admin_api_folder."outlet_open_close_status_change";
		$route['outlet-order-income-reports'] = $admin_api_folder."outlet_order_income_reports";
		$route['broadcast-order-to-driver'] = $admin_api_folder."broadcast_order_to_driver";
		
		
		
		
		
		
		
		
		
		
		
		///////////////////Qa project api's//////////////////////
		
		
		$route['get-checklists-data']=$admin_api_folder."get_user_check_lists";
		$route['checklists-detail']=$admin_api_folder."checklists_detail";
		$route['submit-assignment-answer']=$admin_api_folder."submit_assignments_answers";
		
		
		///////////////////////////end admin apis//////////////////////////
		//////////////////new Routes by asad for new heyfood.pk///////////
		$route['get-offers-list'] = $api_folder."get_offers_list";
		$route['get-offers-detail'] = $api_folder."get_offers_detail";
		
		$route['get-announcements-list'] = $api_folder."get_announcements_list";
		$route['get-restaurant-rating'] = $api_folder."restaurant_rating";
		$route['get-restaurant-reviews'] = $api_folder."get_restaurant_reviews_list";
		$route['submit-restaurant-reviews'] = $api_folder."submit_restaurant_reviews";
		$route['report-restaurant'] = $api_folder."restaurant_report";
		$route['get-notifications-list']=$api_folder."get_notifications_list";
		$route['get-search-products']=$api_folder."get_search_products";
		$route['get-recipies-list']=$api_folder."get_recipes_list";
		$route['get-deal-detail']=$api_folder."get_deals_detail";
		$route['get-all-deals']=$api_folder."get_deals_list";
		$route['get-outlet-info']=$api_folder."get_oultet_info";
	
 	

$route['404_override'] = '';