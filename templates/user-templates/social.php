<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

global $userprofile;

$is_following   = user_profile_is_following( get_current_user_id(), $thisuser->ID );
$follow_text    = $is_following ? __( 'Following', 'user-profile' ) : __( 'Follow', 'user-profile' );
$follow_class   = $is_following ? 'follow following' : 'follow';  

?>

    <div class="single-user single-user-social">
        <div class="cover">
            <?php printf( "<a href='%s'><img src='%s' /></a>", $thisuser->profile_page, $thisuser->user_profile_cover ); ?>
        </div>
        <div class="thumb">
            <?php printf( "<a href='%s'><img src='%s' class='avatar photo' /></a>", $thisuser->profile_page, $thisuser->user_profile_img ); ?>
        </div>
        <?php printf( "<div class='name'><a href='%s'>%s</a></div>", $thisuser->profile_page, $thisuser->display_name ); ?>


        <div class="social-icons">
            <?php foreach( $thisuser->get_contacts() as $contact ) : ?>
            <?php echo $userprofile->generate_html_contact_single( $contact ); ?>
            <?php endforeach; ?>
        </div>

        <div class="user-website">
            <?php printf( "<a href='%s'>%s</a>", $thisuser->user_url, $thisuser->user_url ); ?>
        </div>

        <!-- <div user_id="<?php // echo $thisuser->ID; ?>" class="<?php // echo $follow_class; ?> ">
            <i class="icofont icofont-contact-add"></i>
        </div> -->

    </div>