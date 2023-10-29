<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


global $userprofile;

$profile_navs = $userprofile->profile_navs();
reset($profile_navs);

$nav_current = isset( $_GET['nav'] ) ? sanitize_text_field( $_GET['nav'] ) : key( $profile_navs );

$user_profile_page_id 	= get_option('user_profile_page_id');
$user_profile_page_url	= get_permalink($user_profile_page_id);

?>

<div class="profile-header-navs">

	<?php 
	foreach( $profile_navs as $nav_key => $nav ) :
		
		$nav_active	= $nav_current == $nav_key ? 'active' : '';
		$nav_url 	= $user_profile_page_url . "?" . http_build_query( array( 'id' => $user_id, 'nav' => $nav_key ) );

		printf( "<a class='%s' href='%s'>%s</a>", $nav_active, $nav_url, $nav['title'] );

	endforeach; 
	?>

</div>
