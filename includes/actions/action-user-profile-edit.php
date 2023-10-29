<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

/* --- */
/* User Profile Edit Actions Main */
/* --- */

add_action('user_profile_action_user_profile_edit_before','user_profile_action_user_profile_edit_main_header', 10);

add_action('profile_edit_tabs_basic_info','user_profile_action_user_profile_edit_main_basic_info', 10);
add_action('profile_edit_tabs_contact','user_profile_action_user_profile_edit_main_contacts', 15);
add_action('profile_edit_tabs_works','user_profile_action_user_profile_edit_main_works', 20);
add_action('profile_edit_tabs_education','user_profile_action_user_profile_edit_main_educations', 25);
add_action('profile_edit_tabs_places','user_profile_action_user_profile_edit_main_places', 30);
add_action('user_profile_action_user_profile_edit_after','user_profile_action_user_profile_edit_main_footer', 35);



/* --- */
/* User Profile Edit Actions Logged out */
/* --- */

add_action('user_profile_action_user_profile_edit_loggout','user_profile_action_user_profile_edit_loggout');



/* ========================= */

if( ! function_exists( 'user_profile_action_user_profile_edit_main_footer' ) ) {
    function user_profile_action_user_profile_edit_main_footer( $thisuser ){
	    include( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile-edit/footer.php');
    }
}

if( ! function_exists( 'user_profile_action_user_profile_edit_loggout' ) ) {
    function user_profile_action_user_profile_edit_loggout( $thisuser ){
	    include( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile-edit/log-out.php');
    }
}

if( ! function_exists( 'user_profile_action_user_profile_edit_main_places' ) ) {
    function user_profile_action_user_profile_edit_main_places( $thisuser ){
	    include( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile-edit/places.php');
    }
}

if( ! function_exists( 'user_profile_action_user_profile_edit_main_educations' ) ) {
    function user_profile_action_user_profile_edit_main_educations( $thisuser ){
	    include( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile-edit/educations.php');
    }
}

if( ! function_exists( 'user_profile_action_user_profile_edit_main_works' ) ) {
    function user_profile_action_user_profile_edit_main_works( $thisuser ){
	    include( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile-edit/works.php');
    }
}

if( ! function_exists( 'user_profile_action_user_profile_edit_main_contacts' ) ) {
    function user_profile_action_user_profile_edit_main_contacts( $thisuser ){
	    include( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile-edit/contacts.php');
    }
}

if( ! function_exists( 'user_profile_action_user_profile_edit_main_basic_info' ) ) {
    function user_profile_action_user_profile_edit_main_basic_info( $thisuser ){
	    include( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile-edit/basic-info.php');
    }
}

if( ! function_exists( 'user_profile_action_user_profile_edit_main_header' ) ) {
    function user_profile_action_user_profile_edit_main_header( $thisuser ){
	    include( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile-edit/header.php');
    }
}

