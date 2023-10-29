<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

$whats_on_mind_text = __( "What is on your mind....", 'user-profile' );

if( get_current_user_id() != $thisuser->ID ) return;


// echo '<pre>'; print_r( $thisuser ); echo '</pre>';

?>

<form class="feed-new-post">

    <?php printf( "<textarea name='post_content' placeholder='%s'>%s</textarea>", $whats_on_mind_text, '' ); ?>
    
    <div class="uploaded_photos"></div>

    <div class="post-panel">
        <div class="publish-post button btn"><?php echo __( "Publish", 'user-profile' ); ?></div>
        <?php 
        printf( "<div data-title='%s' data-target='%s' data-buttontext='%s' class='publish-photo button btn'>%s</div>", 
            __( "Upload photo", 'user_profile' ),
            '.uploaded_photos',
            __( "Add selected photo(s)", 'user_profile' ),
            __( "Share photo", 'user_profile' )
        );
        ?>
    </div>

</form>