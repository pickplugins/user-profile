<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

global $userprofile;

$user_id = isset( $_GET['id'] ) ? sanitize_text_field( $_GET['id'] ) : get_current_user_id();
$thisuser = new user_profile_user_data( $user_id );

if( $thisuser->ID == 0 ) {

    $userprofile->print_error( new WP_Error( 'login_required', sprintf( __( 'No or Invalid user found !', 'user-profile' ) ) ) );
    return;
}


?>

    <div class="user-profile">

        <?php do_action( 'user_profile_action_before_user_profile', $user_id, $thisuser ); ?>

        <?php do_action( 'user_profile_action_user_profile_main', $user_id, $thisuser ); ?>

        <?php do_action( 'user_profile_action_after_user_profile', $user_id, $thisuser ); ?>

        <div class="toast"></div>

    </div>