<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


class class_qa_settings  {
	
	public function __construct(){

		add_action( 'admin_menu', array( $this, 'admin_menu' ), 12 );
    }
	
	public function admin_menu() {
		
		add_menu_page(__('User Profile', 'user-profile'), __('User Profile', 'user-profile'), 'manage_options', 'user-profile', array( $this, 'settings' ));
		
		//add_dashboard_page( '', '', 'manage_options', 'qa-setup', '' );
		add_submenu_page( 'user-profile', __( 'Help', 'user-profile' ), __( 'Help', 'user-profile' ), 'manage_options', 'help', array( $this, 'help' ) );
		add_submenu_page( 'user-profile', __( 'Add-on', 'user-profile' ), __( 'Add-on', 'user-profile' ), 'manage_options', 'addons', array( $this, 'addons' ) );
				
		
		
		do_action( 'qa_action_admin_menus' );
		
	}
	
	public function settings(){
		include( USER_PROFILE_PLUGIN_DIR. 'includes/menus/settings.php' );
	}	

	
	public function help(){
		include( USER_PROFILE_PLUGIN_DIR. 'includes/menus/help.php' );
	}	
	
	public function addons(){
		include( USER_PROFILE_PLUGIN_DIR. 'includes/menus/addons.php' );
	}	
	
	
	
} new class_qa_settings();

