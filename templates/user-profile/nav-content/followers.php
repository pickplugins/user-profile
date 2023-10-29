<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


global $userprofile;

$followers          = $thisuser->get_followers();
$display_template   = get_option( 'user_profile_display_template' );
$display_template   = empty( $display_template ) ? 'default' : $display_template;

$userprofile->print_error( new WP_Error( 
    'total_users success',
    sprintf( __( '<b>Total Followers</b> : %d Persons', 'user-profile' ), count( $followers ) )
) );

foreach( $followers as $follower ) : 
    
    $author = new user_profile_user_data( $follower['follower_id'] );

    if( is_wp_error( $html_user = $userprofile->generate_html_user( $author, $display_template ) ) ) {
                
        $userprofile->print_error( $html_user );
        continue;
    }

    printf( $html_user );

endforeach;



