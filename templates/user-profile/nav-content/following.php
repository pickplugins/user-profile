<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

global $userprofile;

$following_users    = $thisuser->get_following_users();
$display_template   = get_option( 'user_profile_display_template' );
$display_template   = empty( $display_template ) ? 'default' : $display_template;

$userprofile->print_error( new WP_Error( 
    'total_users success',
    sprintf( __( '<b>Total Following</b> : %d Persons', 'user-profile' ), count( $following_users ) )
) );

foreach( $following_users as $following_user ) : 
    
    $author = new user_profile_user_data( $following_user['author_id'] );

    if( is_wp_error( $html_user = $userprofile->generate_html_user( $author, $display_template ) ) ) {
                
        $userprofile->print_error( $html_user );
        continue;
    }

    printf( $html_user );

endforeach;


