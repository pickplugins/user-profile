<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

$User_profile_functions = new User_profile_functions();
$profile_navs	= $User_profile_functions->profile_navs();
$profile_nav_default = $User_profile_functions->profile_nav_default();

reset( $profile_navs );
$current_nav	= isset( $_GET['nav'] ) ? sanitize_text_field( $_GET['nav'] ) : $profile_nav_default;

?>

<div class="navs-content">

	<div class="nav-content <?php echo $current_nav; ?> active">
	
		<?php
        do_action( "user_profile_action_nav_content_$current_nav", $user_id, $thisuser );
        ?>
	
	</div>
	
</div>
