<?php
/*
Plugin Name: User profile
Plugin URI: http://pickplugins.com
Description: Socialize your user profile.
Version: 2.0.9
Text Domain: user-profile
Author: pickplugins
Author URI: http://pickplugins.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


class UserProfile{
	
	public function __construct(){
	
		$this->user_profile_define_constants();
		
		$this->user_profile_declare_classes();
		$this->user_profile_declare_shortcodes();
		$this->user_profile_declare_actions();
		
		$this->user_profile_loading_script();
		//$this->user_profile_loading_plugin();
		//$this->user_profile_loading_widgets();
		$this->user_profile_loading_functions();
		
		register_activation_hook( __FILE__, array( $this, 'user_profile_activation' ) );
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ));

	}
	
	public function user_profile_activation() {


		
		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();
		$table = $wpdb->prefix .'user_profile_follow';
		
		$sql = "CREATE TABLE IF NOT EXISTS ".$table ." (
			id int(100) NOT NULL AUTO_INCREMENT,
			author_id int(100) NOT NULL,
			follower_id int(100) NOT NULL,
			datetime datetime NOT NULL,
			
				
			UNIQUE KEY id (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

		
	}
	
	public function load_textdomain() {
		
		load_plugin_textdomain( 'user-profile', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' );
	}
	
	public function user_profile_loading_widgets() {

		//require_once( USER_PROFILE_PLUGIN_DIR . 'includes/classes/class-widget-leaderboard.php');
	

		add_action( 'widgets_init', array( $this, 'user_profile_widget_register' ) );
	}
	
	public function user_profile_widget_register() {
		//register_widget( 'QAWidgetLeaderboard' );

	}
	
	public function user_profile_loading_functions() {
		
		require_once( USER_PROFILE_PLUGIN_DIR . 'includes/functions.php');
	}
	
	public function user_profile_loading_plugin() {
		
		
		
	}
	
	public function user_profile_loading_script() {
	
		add_action( 'admin_enqueue_scripts', 'wp_enqueue_media' );
		add_action( 'wp_enqueue_scripts', array( $this, 'user_profile_front_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'user_profile_admin_scripts' ) );
	}

	
	public function user_profile_declare_actions() {


		require_once( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile/user-profile-action.php');
		require_once( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile-edit/user-profile-edit-action.php');	
		require_once( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile-feed/user-profile-feed-action.php');		
			
		
	}
	
	public function user_profile_declare_shortcodes() {
		
		require_once( USER_PROFILE_PLUGIN_DIR . 'includes/shortcodes/class-shortcode-user-profile.php');
		require_once( USER_PROFILE_PLUGIN_DIR . 'includes/shortcodes/class-shortcode-user-profile-edit.php');			
		require_once( USER_PROFILE_PLUGIN_DIR . 'includes/shortcodes/class-shortcode-user-feed.php');			

	}
	
	public function user_profile_declare_classes() {
		
		require_once( USER_PROFILE_PLUGIN_DIR . 'includes/classes/class-functions.php');			
		require_once( USER_PROFILE_PLUGIN_DIR . 'includes/classes/class-settings.php');	

	}
	
	public function user_profile_define_constants() {

		$this->define('USER_PROFILE_PLUGIN_URL', plugins_url('/', __FILE__)  );
		$this->define('USER_PROFILE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		$this->define('USER_PROFILE_PLUGIN_NAME', __('User Profile', 'user-profile') );
		$this->define('USER_PROFILE_PLUGIN_SUPPORT', 'http://www.pickplugins.com/questions/'  );
		
	}
	
	private function define( $name, $value ) {
		if( $name && $value )
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}
	

		
		
	public function user_profile_front_scripts(){
		
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_script( 'jquery-ui-core' );
		
			
		wp_enqueue_script('user_profile_front_js', plugins_url( '/assets/front/js/scripts.js' , __FILE__ ) , array( 'jquery' ));
		wp_localize_script('user_profile_front_js', 'user_profile_ajax', array( 'user_profile_ajaxurl' => admin_url( 'admin-ajax.php')));
		
		wp_enqueue_style('user_profile_style', USER_PROFILE_PLUGIN_URL.'assets/front/css/user-profile.css');
		wp_enqueue_style('user_profile_edit_style', USER_PROFILE_PLUGIN_URL.'assets/front/css/user-profile-edit.css');
		wp_enqueue_style('user_profile_feed_style', USER_PROFILE_PLUGIN_URL.'assets/front/css/user-profile-feed.css');		
		
		wp_enqueue_style('tooltipster.bundle.min', USER_PROFILE_PLUGIN_URL.'assets/front/css/tooltipster.bundle.min.css');			
		
		wp_enqueue_script('tooltipster.bundle.min', plugins_url( '/assets/front/js/tooltipster.bundle.min.js' , __FILE__ ) , array( 'jquery' ));		
		//global
		wp_enqueue_style('font-awesome', USER_PROFILE_PLUGIN_URL.'assets/global/css/font-awesome.css');
		wp_enqueue_style('jquery-ui', USER_PROFILE_PLUGIN_URL.'assets/global/css/jquery-ui.css');
		
		wp_enqueue_script('plupload-all');
		
		//wp_enqueue_style('user_profile_global_style', USER_PROFILE_PLUGIN_URL.'assets/global/css/style.css');

		
		// ParaAdmin
		//wp_enqueue_script('user_profile_ParaAdmin', plugins_url( '/assets/global/ParaAdmin/ParaAdmin.js' , __FILE__ ) , array( 'jquery' ));		
		//wp_enqueue_style('user_profile_paraAdmin', USER_PROFILE_PLUGIN_URL.'assets/global/ParaAdmin/ParaAdmin.css');
		
		//wp_enqueue_script('plupload-all');	
		//wp_enqueue_script('plupload_js', plugins_url( '/assets/global/js/scripts-plupload.js' , __FILE__ ) , array( 'jquery' ));
		
		//
	}

	public function user_profile_admin_scripts(){
		
		wp_enqueue_script('jquery');
		
		//wp_enqueue_script('user_profile_admin_js', plugins_url( '/assets/admin/js/scripts.js' , __FILE__ ) , array( 'jquery' ));
		//wp_localize_script( 'user_profile_admin_js', 'user_profile_ajax', array( 'user_profile_ajaxurl' => admin_url( 'admin-ajax.php')));
		
		//wp_enqueue_style('user_profile_admin_style', USER_PROFILE_PLUGIN_URL.'assets/admin/css/style.css');
			
		
		wp_enqueue_script('user_profile_ParaAdmin', plugins_url( '/assets/admin/ParaAdmin/js/ParaAdmin.js' , __FILE__ ) , array( 'jquery' ));		
		wp_enqueue_style('user_profile_paraAdmin', USER_PROFILE_PLUGIN_URL.'assets/admin/ParaAdmin/css/ParaAdmin.css');
		
		//global
		wp_enqueue_style('font-awesome', USER_PROFILE_PLUGIN_URL.'assets/global/css/font-awesome.css');
		wp_enqueue_style('addons', USER_PROFILE_PLUGIN_URL.'assets/admin/css/addons.css');
		
		//wp_enqueue_style( 'wp-color-picker' );
		//wp_enqueue_script( 'user_profile_color_picker', plugins_url('/assets/admin/js/color-picker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
	}
	
	
} new UserProfile();