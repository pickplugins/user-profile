<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


$User_profile_functions = new User_profile_functions();
$profile_navs = $User_profile_functions->profile_navs();
$profile_nav_default = $User_profile_functions->profile_nav_default();

reset($profile_navs);

$nav_current = isset( $_GET['nav'] ) ? sanitize_text_field( $_GET['nav'] ) : $profile_nav_default;

$user_profile_page_id 	= get_option('user_profile_page_id');
$user_profile_page_url	= get_permalink($user_profile_page_id);

//var_dump($profile_navs);
//
//usort($profile_navs, function ($a,$b) {
//	return $a['priority'] > $b['priority'];
//});
//
//var_dump(key( $profile_navs ));



$pages_sorted = array();
foreach ($profile_navs as $page_key => $page) $pages_sorted[$page_key] = isset( $page['priority'] ) ? $page['priority'] : 0;
array_multisort($pages_sorted, SORT_ASC, $profile_navs);

//var_dump($profile_navs);




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
