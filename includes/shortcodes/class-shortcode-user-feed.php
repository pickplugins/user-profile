<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

class class_user_profile_user_feed{
	
    public function __construct(){
		add_shortcode( 'user_profile_feed', array( $this, 'user_profile_display' ) );
   	}	
	
	public function user_profile_display($atts, $content = null ) {
			
		$atts = shortcode_atts( array(
					
		), $atts);

		ob_start();
		include( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile-feed/user-profile-feed.php');
		return ob_get_clean();
	}
	
} 

new class_user_profile_user_feed();