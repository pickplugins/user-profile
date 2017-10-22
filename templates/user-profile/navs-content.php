<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


$class_user_profile_functions = new class_user_profile_functions();

$profile_navs = $class_user_profile_functions->profile_navs();


if(isset($_GET['nav'])){
	
	$nav = $_GET['nav'];
	
	}
else{$nav='post';}




?>





<div class="navs-content">
	<?php do_action('user_profile_action_before_profile_content'); ?>
    
    <?php
    
	foreach($profile_navs as $nav_key=>$navs){
		
		$html = $navs['html'];
		?>
        <div class="nav-content <?php echo $nav_key; ?> <?php if($nav==$nav_key) echo 'active';?>">
        <?php
		echo $html;
		?>
        </div>
        <?php		
		}

	?>   
	<?php do_action('user_profile_action_after_profile_content'); ?>
</div>
