<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

// echo "<pre>"; print_r( $thisuser ); echo "</pre>";

?>

<div class="side-section">
    <div class="section-title"><i class="icofont icofont-users-alt-6"></i> Followers</div>
    <div class="section-content followers">
    
        <?php foreach( $thisuser->get_followers() as $follower ) : if( ! isset( $follower[ 'follower_id' ] ) ) continue;

            $follower_user = new user_profile_user_data( $follower['follower_id'] );

            echo apply_filters( 'user_profile_filter_follower_item', 
                sprintf( "<div class='item hint--top' aria-label='%s'><a href='%s'><img src='%s' /></a></div>", 
                $follower_user->display_name, $follower_user->profile_page, $follower_user->user_profile_img ), $follower['follower_id'], $user_id );

        endforeach; ?>

    </div>
</div>