<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 




?>

<div class="side-section ">
    <div class="section-title"><i class="icofont icofont-ui-image"></i> Photos</div>
    <div class="section-content photos">
    
        <?php foreach( $thisuser->get_photos() as $photo ) : 

            echo apply_filters( 'user_profile_filter_photo_item', 
                sprintf( "<div class='item'><img src='%s' /></div>", 
                wp_get_attachment_url( $photo->ID ), $photo->ID, $user_id ) );
        
        endforeach; ?>

    </div>
</div>




