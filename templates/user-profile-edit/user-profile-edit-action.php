<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

/* Profile Header */

add_action('user_profile_action_user_profile_edit_main','user_profile_action_user_profile_edit_main_basic_info');

add_action('user_profile_action_user_profile_edit_main','user_profile_action_user_profile_edit_main_contacts');
add_action('user_profile_action_user_profile_edit_main','user_profile_action_user_profile_edit_main_work');
add_action('user_profile_action_user_profile_edit_main','user_profile_action_user_profile_edit_main_education');
add_action('user_profile_action_user_profile_edit_main','user_profile_action_user_profile_edit_main_places');



function user_profile_action_user_profile_edit_main_basic_info(){
	
	require_once( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile-edit/user-profile-edit-basic-info.php');
	
	}


function user_profile_action_user_profile_edit_main_contacts(){
	
	require_once( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile-edit/user-profile-edit-contacts.php');
	
	}	


function user_profile_action_user_profile_edit_main_work(){
	
	require_once( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile-edit/user-profile-edit-work.php');
	
	}
	
function user_profile_action_user_profile_edit_main_education(){
	
	require_once( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile-edit/user-profile-edit-education.php');
	
	}	
	
	
function user_profile_action_user_profile_edit_main_places(){
	
	require_once( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile-edit/user-profile-edit-places.php');
	
	}	
	
	
	
	
	
	
