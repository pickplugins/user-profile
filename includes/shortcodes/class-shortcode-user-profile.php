<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

class class_user_profile_user_profile{
	
    public function __construct(){
		add_shortcode( 'user_profile', array( $this, 'user_profile_display' ) );
   	}	
	
	public function user_profile_display($atts, $content = null ) {
			
		$atts = shortcode_atts( array(
					
		), $atts);

		ob_start();
		include( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile/user-profile.php');
		return ob_get_clean();
	}
	
} 

new class_user_profile_user_profile();