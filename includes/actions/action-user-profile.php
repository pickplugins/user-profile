<?php
/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

// echo "<pre>"; print_r( $user ); echo "</pre>";

/* --- */
/* User Profile Actions Main */
/* --- */

add_action( 'user_profile_action_user_profile_main', 'user_profile_action_user_profile_main_header', 10, 2 );
add_action( 'user_profile_action_user_profile_main', 'user_profile_action_user_profile_main_navs', 12, 2 );
add_action( 'user_profile_action_user_profile_main', 'user_profile_action_user_profile_main_contents', 15, 2 );



/* --- */
/* User Profile Actions Nav Content */
/* --- */

add_action( 'user_profile_action_nav_content_feed', 'user_profile_action_nav_content_feed', 10, 2 );
add_action( 'user_profile_action_nav_content_about', 'user_profile_action_nav_content_about', 10, 2 );
add_action( 'user_profile_action_nav_content_posts', 'user_profile_action_nav_content_posts', 10, 2 );
add_action( 'user_profile_action_nav_content_followers', 'user_profile_action_nav_content_followers', 10, 2 );
add_action( 'user_profile_action_nav_content_following', 'user_profile_action_nav_content_following', 10, 2 );




/* --- */
/* User Profile Actions Content Feed */
/* --- */

add_action( 'user_profile_action_content_feed_side', 'user_profile_action_content_feed_side_intro', 10, 2 );
add_action( 'user_profile_action_content_feed_side', 'user_profile_action_content_feed_side_photos', 12, 2 );
add_action( 'user_profile_action_content_feed_side', 'user_profile_action_content_feed_side_followers', 15, 2 );

add_action( 'user_profile_action_content_feed_items', 'user_profile_action_content_feed_items_new_post', 10, 2 );
add_action( 'user_profile_action_content_feed_items', 'user_profile_action_content_feed_items_posts', 12, 2 );



/* ========================= */

if( ! function_exists( 'user_profile_action_nav_content_following' ) ) {
    function user_profile_action_nav_content_following( $user_id, $thisuser ){
	    include( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile/nav-content/following.php');
    }
}

if( ! function_exists( 'user_profile_action_nav_content_followers' ) ) {
    function user_profile_action_nav_content_followers( $user_id, $thisuser ){
	    include( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile/nav-content/followers.php');
    }
}

if( ! function_exists( 'user_profile_action_nav_content_posts' ) ) {
    function user_profile_action_nav_content_posts( $user_id, $thisuser ){
	    include( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile/nav-content/posts.php');
    }
}

if( ! function_exists( 'user_profile_action_nav_content_about' ) ) {
    function user_profile_action_nav_content_about( $user_id, $thisuser ){
	    include( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile/nav-content/about.php');
    }
}

if( ! function_exists( 'user_profile_action_content_feed_items_posts' ) ) {
    function user_profile_action_content_feed_items_posts( $user_id, $thisuser ){
	    include( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile/nav-content/inside-feed/posts.php');
    }
}

if( ! function_exists( 'user_profile_action_content_feed_items_new_post' ) ) {
    function user_profile_action_content_feed_items_new_post( $user_id, $thisuser ){
	    include( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile/nav-content/inside-feed/new-post.php');
    }
}

if( ! function_exists( 'user_profile_action_content_feed_side_followers' ) ) {
    function user_profile_action_content_feed_side_followers( $user_id, $thisuser ){
	    include( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile/nav-content/inside-feed/followers.php');
    }
}

if( ! function_exists( 'user_profile_action_content_feed_side_photos' ) ) {
    function user_profile_action_content_feed_side_photos( $user_id, $thisuser ){
	    include( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile/nav-content/inside-feed/photos.php');
    }
}

if( ! function_exists( 'user_profile_action_content_feed_side_intro' ) ) {
    function user_profile_action_content_feed_side_intro( $user_id, $thisuser ){
	    include( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile/nav-content/inside-feed/intro.php');
    }
}

if( ! function_exists( 'user_profile_action_nav_content_feed' ) ) {
    function user_profile_action_nav_content_feed( $user_id, $thisuser ){
	    include( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile/nav-content/feed.php');
    }
}

if( ! function_exists( 'user_profile_action_user_profile_main_contents' ) ) {
    function user_profile_action_user_profile_main_contents( $user_id, $thisuser ){
	    include( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile/contents.php');
    }
}

if( ! function_exists( 'user_profile_action_user_profile_main_navs' ) ) {
    function user_profile_action_user_profile_main_navs( $user_id, $thisuser ){
	    include( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile/navs.php');
    }
}

if( ! function_exists( 'user_profile_action_user_profile_main_header' ) ) {
    function user_profile_action_user_profile_main_header( $user_id, $thisuser ){
	    include( USER_PROFILE_PLUGIN_DIR . 'templates/user-profile/header.php');
    }
}
