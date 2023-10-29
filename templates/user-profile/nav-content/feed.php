<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

?>
<div class="user-feed">
    
    <div class="feed-side">
        
        <?php do_action( 'user_profile_action_content_feed_side', $user_id, $thisuser ) ?>
    
    </div>

    <div class="feed-items">

        <?php do_action( 'user_profile_action_content_feed_items', $user_id, $thisuser ) ?>

    </div>

</div>

        