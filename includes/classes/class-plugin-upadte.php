<?php
/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

class USER_Profile_update  {
	
	public $text_domain = 'user-profile';

	private $redirect_to = 'admin.php?page=user-profile';
	private $is_update_required = false;
	
	public function __construct(){
		
		if( ! is_admin() ) return;
		
		//$this->check_update_required();
		
		//add_action( 'admin_notices', array( $this, 'update_notice' ) );
		//add_action( 'admin_menu', array( $this, 'admin_menu' ), 20 );
		//add_action( 'admin_menu', array( $this, 'admin_menu' ), 20 );
    }
	
	public function update_page(){
		
		$USER_Profile_users	= new WP_User_Query( array( 'paged' => -1 ) );
		
		echo "<div class='wrap'>";
		
		printf( "<h2>%s</h2>", __("User profile - Update", $this->text_domain ) );
		printf( "<h3>%s : %d</h3>", __("Total users", $this->text_domain ), $USER_Profile_users->total_users );
		printf( "<div class='notice notice-error'><p>%s</p></div>", __("Do not close this browser tab until update is done.", $this->text_domain ) );
		
		
		echo "<div class='update_now button' paged='1' style='margin:20px 0;'>Update now</div>";
		echo "<div class='user_profile_update_list'></div>";
		
		
		echo "<script>jQuery(document).ready(function($) { $(document).on('click', '.update_now', function() {
			$(this).html('".__("Updating...", $this->text_domain)."');
			paged = parseInt( $(this).attr( 'paged' ) );
			$.ajax(
				{
			type: 'POST',
			context: this,
			url: '',
			data: { 'action' : 'user_profile_update_user_data', 'paged'	 : paged, },
			success: function( data ) {
				if( data.length == 0 ) window.location.href = '".admin_url( $this->redirect_to)."';
				else{
					$('.user_profile_update_list').append( data );
					$(this).attr( 'paged', paged + 1 );
					$('.update_now').trigger( 'click' );
				}
			}
				});
		}) });</script>";
				
		echo "</div>"; // wrap
	}
	
	public function admin_menu(){
		
		if( ! $this->is_update_required ) return;
		
		add_submenu_page( 'user-profile',
			__('User Profile - Update', $this->text_domain ), 
			__('User Profile - Update', $this->text_domain ), 
			'manage_options', 'user-profile-update', array( $this, 'update_page' )
		);
	}
	
	public function update_notice(){
		
		if( ! $this->is_update_required ) return;
		
		$update_notice  = __( "You need to update data to synchronize with Latest version ", $this->text_domain );
		$update_notice .= sprintf( "<a href='%s'>%s</a>", "admin.php?page=user-profile-update", __( "Update now", $this->text_domain ) );
		
		printf( "<div class='notice notice-warning is-dismissible'><p>%s</p></div>", $update_notice );
	}
	
	private function check_update_required(){
		
		$user_profile_update_data = get_option( 'user_profile_update_data', array() );
		$user_profile_update_data = empty( $user_profile_update_data ) ? array() : $user_profile_update_data;
		$is_completed 	= isset( $user_profile_update_data['is_completed'] ) ? $user_profile_update_data['is_completed'] : false;

	
		if( ! $is_completed ) $this->is_update_required = true;
	}
	
	
	
}

$USER_Profile_update = new USER_Profile_update();
global $wpdb;

if( isset( $_POST['action'] ) && $_POST['action'] == 'user_profile_update_user_data' ) {
	
	$paged 				= isset( $_POST['paged'] ) ? $_POST['paged'] : 0;
	$updated_users 		= array();
	$users_per_action	= 15;
	$USER_Profile_users	= new WP_User_Query( array(
		'number' => $users_per_action,
		'paged' => $paged,
	) );

	$total_pages = ceil( $USER_Profile_users->total_users / $users_per_action );
	
	if( $paged > $total_pages ) {
		
		$user_profile_update_data = get_option( 'user_profile_update_data', array() );
		$user_profile_update_data = empty( $user_profile_update_data ) ? array() : $user_profile_update_data;
		$user_profile_update_data['is_completed'] = true;
		
		update_option( 'user_profile_update_data', $user_profile_update_data );		
		die();
	}
	
	foreach( $USER_Profile_users->get_results() as $user ) :
		
		$basic_info 	= get_user_meta( $user->ID, 'user_profile_basic_info', true );
		$first_name		= isset( $basic_info['first_name'] ) ? $basic_info['first_name'] : '';
		$last_name		= isset( $basic_info['last_name'] ) ? $basic_info['last_name'] : '';
		$birth_date		= isset( $basic_info['birth_date'] ) ? $basic_info['birth_date'] : '';
		$relationship	= isset( $basic_info['relationship'] ) ? $basic_info['relationship'] : '';
		$gender			= isset( $basic_info['gender'] ) ? $basic_info['gender'] : '';
		$religious		= isset( $basic_info['religious'] ) ? $basic_info['religious'] : '';
		$website		= isset( $basic_info['website'] ) ? $basic_info['website'] : '';
		
		$wpdb->update( $wpdb->users, array( 'user_url' => $website, 'display_name' => $first_name.' '.$last_name ), array( 'ID' => $user->ID ) );

		//error_log($user->ID);
        if(!function_exists('wp_get_current_user')) {
            include(ABSPATH . "wp-includes/pluggable.php");
        }

        update_user_meta( $user->ID, 'first_name', $first_name );
		update_user_meta( $user->ID, 'last_name', $last_name );
		update_user_meta( $user->ID, 'up_date_of_birth', $birth_date );
		update_user_meta( $user->ID, 'up_relationship', $relationship );
		update_user_meta( $user->ID, 'up_gender', $gender );
		update_user_meta( $user->ID, 'up_religious', $religious);

		// echo "<pre>"; print_r( $user_profile_basic_info ); echo "</pre>";
		
		$updated_users[] = "<a href='user-edit.php?user_id={$user->ID}'>{$user->ID}</a>";
	
	endforeach;
	
	$updated = sprintf( __( "%d Updated : ", $USER_Profile_update->text_domain ), $users_per_action ) . implode( ", ", $updated_users );
	printf( "<div class='notice notice-success'><p>%s</p></div>", $updated );
	die();
}