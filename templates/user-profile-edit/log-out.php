<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

global $userprofile;

$login_url      = wp_login_url( get_permalink() );
$login_required = sprintf( __("%s required to continue", 'user-profile'), sprintf( "<a href='%s'>%s</a>", $login_url, __('Login', 'user-profile') ) );
$login_required = sprintf( "<i class='icofont icofont-warning'></i> %s", $login_required );

$userprofile->print_error( new WP_Error( 'login_required', $login_required ) );