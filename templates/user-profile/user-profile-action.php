<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

/* Profile Header */

add_action('user_profile_action_user_profile_main','user_profile_action_user_profile_main_header');
add_action('user_profile_action_profile_header','user_profile_action_user_profile_main_header_cover');
add_action('user_profile_action_profile_header','user_profile_action_user_profile_main_header_thumb');
add_action('user_profile_action_profile_header','user_profile_action_user_profile_main_header_name');
add_action('user_profile_action_profile_header','user_profile_action_user_profile_main_header_follow_button');
//add_action('user_profile_action_profile_header','user_profile_action_user_profile_main_header_message_button');



add_action('user_profile_action_user_profile_main','user_profile_action_user_profile_main_header_navs');




add_action('user_profile_action_user_profile_main','user_profile_action_user_profile_main_header_navs_content');

add_action('user_profile_action_user_profile_main','user_profile_action_user_profile_main_footer');
add_action('user_profile_action_user_profile_main','user_profile_action_user_profile_main_toast');

function user_profile_action_user_profile_main_header(){
	
	require_once( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile/header.php');
	
	}

function user_profile_action_user_profile_main_header_cover(){
	
	require_once( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile/header-cover.php');
	
	}

function user_profile_action_user_profile_main_header_thumb(){
	
	require_once( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile/header-thumb.php');
	
	}
	
function user_profile_action_user_profile_main_header_name(){
	
	require_once( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile/header-name.php');
	
	}	
	
function user_profile_action_user_profile_main_header_follow_button(){
	
	require_once( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile/header-follow-button.php');
	
	}	
	
	
function user_profile_action_user_profile_main_header_message_button(){
	
	require_once( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile/header-message-button.php');
	
	}	
	

function user_profile_action_user_profile_main_header_navs(){
	
	require_once( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile/header-navs.php');
	
	}


function user_profile_action_user_profile_main_header_navs_content(){
	
	require_once( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile/navs-content.php');
	
	}



function user_profile_action_user_profile_main_footer(){
	
	require_once( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile/footer.php');
	
	}


function user_profile_action_user_profile_main_toast(){
	
	require_once( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile/toast.php');
	
	}
