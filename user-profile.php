<?php
/*
Plugin Name: User profile
Plugin URI: http://pickplugins.com
Description: Socialize your user profile.
Version: 2.0.21
Text Domain: user-profile
Author: pickplugins
Author URI: http://pickplugins.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if (!defined('ABSPATH')) exit;  // if direct access 

class UserProfile
{

	public function __construct()
	{

		$this->define_constants();

		$this->declare_classes();
		$this->declare_actions();

		$this->loading_functions();
		$this->loading_widgets();
		$this->loading_script();


		register_activation_hook(__FILE__, array($this, 'activation'));
		add_action('plugins_loaded', array($this, 'load_textdomain'));

		require_once(USER_PROFILE_PLUGIN_DIR . 'includes/classes/class-plugin-upadte.php');
	}

	public function activation()
	{

		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();

		$user_profile_follow = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}user_profile_follow (
			id int(100) NOT NULL AUTO_INCREMENT,
			author_id int(100) NOT NULL,
			follower_id int(100) NOT NULL,
			datetime datetime NOT NULL,
			
			UNIQUE KEY id (id)
		) $charset_collate;";

		$user_profile_reactions = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}user_profile_reactions (
			id int(100) NOT NULL AUTO_INCREMENT,
			post_id int(100) NOT NULL,
			user_id int(100) NOT NULL,
			reaction varchar(100) NOT NULL,
			datetime datetime NOT NULL,
			
			UNIQUE KEY id (id)
		) $charset_collate;";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

		dbDelta($user_profile_follow);
		dbDelta($user_profile_reactions);
	}

	public function load_textdomain()
	{


		$locale = apply_filters('plugin_locale', get_locale(), 'user-profile');
		load_textdomain('user-profile', WP_LANG_DIR . '/user-profile/user-profile-' . $locale . '.mo');

		load_plugin_textdomain('user-profile', false, plugin_basename(dirname(__FILE__)) . '/languages/');
	}

	public function loading_widgets()
	{

		require_once(USER_PROFILE_PLUGIN_DIR . 'includes/widgets/widget-users.php');

		add_action('widgets_init', array($this, 'widget_register'));
	}

	public function widget_register()
	{

		register_widget('UserProfileWidgetUsers');
	}

	public function loading_functions()
	{

		require_once(USER_PROFILE_PLUGIN_DIR . 'includes/functions.php');
		require_once(USER_PROFILE_PLUGIN_DIR . 'includes/functions-ajax.php');
		require_once(USER_PROFILE_PLUGIN_DIR . 'includes/functions-settings-new.php');
	}

	public function loading_script()
	{

		add_action('admin_enqueue_scripts', 'wp_enqueue_media');
		add_action('wp_enqueue_scripts', array($this, 'front_scripts'));
		add_action('admin_enqueue_scripts', array($this, 'admin_scripts'));
	}


	public function declare_actions()
	{

		require_once(USER_PROFILE_PLUGIN_DIR . 'includes/actions/action-user-profile.php');
		require_once(USER_PROFILE_PLUGIN_DIR . 'includes/actions/action-user-profile-edit.php');
	}

	public function declare_classes()
	{

		require_once(USER_PROFILE_PLUGIN_DIR . 'includes/classes/class-user.php');
		require_once(USER_PROFILE_PLUGIN_DIR . 'includes/classes/class-feed.php');
		require_once(USER_PROFILE_PLUGIN_DIR . 'includes/classes/class-functions.php');
		require_once(USER_PROFILE_PLUGIN_DIR . 'includes/classes/class-shortcodes.php');
		require_once(USER_PROFILE_PLUGIN_DIR . 'includes/classes/class-pick-settings.php');
		require_once(USER_PROFILE_PLUGIN_DIR . 'includes/classes/WPAdminMenu/class-wp-admin-menu.php');
	}

	public function define_constants()
	{

		$this->define('USER_PROFILE_PLUGIN_URL', plugins_url('/', __FILE__));
		$this->define('USER_PROFILE_PLUGIN_DIR', plugin_dir_path(__FILE__));
		$this->define('USER_PROFILE_PLUGIN_NAME', __('User Profile', 'user-profile'));
		$this->define('USER_PROFILE_PLUGIN_SUPPORT', 'http://www.pickplugins.com/questions/');
	}

	private function define($name, $value)
	{
		if ($name && $value)
			if (!defined($name)) {
				define($name, $value);
			}
	}




	public function front_scripts()
	{

		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-tabs');
		wp_enqueue_script('plupload-all');
		wp_enqueue_media();

		wp_enqueue_script('user_profile_front_js', plugins_url('/assets/front/js/scripts.js', __FILE__), array('jquery'), date("H: s", time()));
		wp_localize_script('user_profile_front_js', 'user_profile_ajax', array('user_profile_ajaxurl' => admin_url('admin-ajax.php')));

		wp_enqueue_style('hint.min', USER_PROFILE_PLUGIN_URL . 'assets/front/css/hint.min.css');
		wp_enqueue_style('icofont', USER_PROFILE_PLUGIN_URL . 'assets/fonts/icofont.css');
		wp_enqueue_style('jquery-ui', USER_PROFILE_PLUGIN_URL . 'assets/jquery-ui.css');

		wp_enqueue_style('user_profile_style', USER_PROFILE_PLUGIN_URL . 'assets/front/css/style.css', array(), date("H: s", time()));
	}

	public function admin_scripts()
	{

		wp_enqueue_script('jquery');

		wp_enqueue_style('icofont', USER_PROFILE_PLUGIN_URL . 'assets/fonts/icofont.css');
		//wp_enqueue_style('addons', USER_PROFILE_PLUGIN_URL.'assets/admin/css/style.css');
	}
}
new UserProfile();
