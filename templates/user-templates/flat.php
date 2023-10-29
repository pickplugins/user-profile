<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

// echo '<pre>'; print_r( $thisuser ); echo '</pre>';

?>

    <div class="single-user single-user-flat">
        <?php printf( "<a href='%s'>%s</a>", $thisuser->profile_page, $thisuser->display_name ); ?>
    </div>