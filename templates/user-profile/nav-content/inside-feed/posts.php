<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

$user_profile_feed  = new User_profile_feed();
$posts_per_page     = get_option('posts_per_page');
$posts_per_page     = empty( $posts_per_page ) ? 10 : $posts_per_page;

$user_profile_feed->set_feed_for_user( $user_id );
$user_profile_feed->set_posts_per_page( $posts_per_page );

// echo '<pre>'; print_r( $user_id ); echo '</pre>';

// $following_users = $user_profile_feed->get_following_user();

echo "<div class='user_profile_feed_loader'><div class='db1'></div><div class='db2'></div></div>";

printf( "<div class='list-items' id='list-items'>%s</div>", $user_profile_feed->generate_feed() );
printf( "<div class='list-load-more'>%s</div>", $user_profile_feed->generate_feed_pagination() );