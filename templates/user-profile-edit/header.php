<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

$nonce 			= isset( $_POST['_wpnonce'] ) ? sanitize_text_field( $_POST['_wpnonce'] ) : '';
$edit_hidden 	= isset( $_POST['edit_hidden'] ) ? sanitize_text_field( $_POST['edit_hidden'] ) : '';
$update_user	= null;


if( $edit_hidden == 'y' && wp_verify_nonce( $nonce, 'nonce_user_profile_edit' ) ) :

	$update_user = $thisuser->update_user_data( array(

		'first_name' 	=> isset( $_POST[ 'first_name' ] ) ? sanitize_text_field( $_POST[ 'first_name' ] ) : '',
		'last_name'		=> isset( $_POST[ 'last_name' ] ) ? sanitize_text_field( $_POST[ 'last_name' ] ) : '',
		'date_of_birth'	=> isset( $_POST[ 'up_date_of_birth' ] ) ? sanitize_text_field( $_POST[ 'up_date_of_birth' ] ) : '',
		'relationship' 	=> isset( $_POST[ 'up_relationship' ] ) ? sanitize_text_field( $_POST[ 'up_relationship' ] ) : '',
		'gender' 		=> isset( $_POST[ 'up_gender' ] ) ? sanitize_text_field( $_POST[ 'up_gender' ] ) : '',
		'religious' 	=> isset( $_POST[ 'up_religious' ] ) ? sanitize_text_field( $_POST[ 'up_religious' ] ) : '',
		'description' 	=> isset( $_POST[ 'description' ] ) ? wp_kses_post( $_POST[ 'description' ] ) : '',
		'user_url' 		=> isset( $_POST[ 'user_url' ] ) ? esc_url_raw( $_POST[ 'user_url' ] ) : '',

		'user_profile_contacts'  => isset( $_POST[ 'user_profile_contacts' ] ) ? user_profile_recursive_sanitize_arr( $_POST[ 'user_profile_contacts' ] ) : '',
		'user_profile_work' 	 => isset( $_POST[ 'user_profile_work' ] ) ? user_profile_recursive_sanitize_arr( $_POST[ 'user_profile_work' ] ) : '',
		'user_profile_education' => isset( $_POST[ 'user_profile_education' ] ) ? user_profile_recursive_sanitize_arr( $_POST[ 'user_profile_education' ] ) : '',
		'user_profile_places' 	 => isset( $_POST[ 'user_profile_places' ] ) ? user_profile_recursive_sanitize_arr( $_POST[ 'user_profile_places' ] ) : '',

	) );

	
	// echo "<pre>"; print_r( $thisuser ); echo "</pre>";

endif;



?> <div class="user-profile user-profile-edit"> <?php 

global $userprofile;

if( is_wp_error( $update_user ) ) {
	
    $userprofile->print_error( 
        new WP_Error( 
            array( 'error', $update_user->get_error_code() ), 
            apply_filters( 
                'user_profile_filter_profile_update_message', 
                $update_user->get_error_message() 
            ), $thisuser 
        )
    );
}

if( $update_user ) {

    $userprofile->print_error( 
        new WP_Error( 
            'success', 
            apply_filters( 
                'user_profile_filter_profile_update_message', 
                __( 'Profile updated successfully', 'user-profile' ), $thisuser 
            )
        )
    );
}


?> <form id="user-profile-edit" action="" method="post">
        
       	