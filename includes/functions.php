<?php
if ( ! defined('ABSPATH')) exit;  // if direct access














function user_profile_show_admin_notice(){

    global $userprofile;

    if( empty( $userprofile->profile_page ) || empty( $userprofile->profile_edit_page ) )
        $userprofile->print_error( new WP_Error( 
            'settings_error',
            sprintf( __('Please update %s properly !', 'user-profile'), sprintf( "<a href='%s'>%s</a>", 'admin.php?page=user-profile', __('settings', 'user-profile') ) )
        ) );

}
add_action( 'admin_notices', 'user_profile_show_admin_notice' );

function user_profile_is_following( $user_id_to_check_from, $user_id_to_check ){
    
    global $wpdb;
    
    $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}user_profile_follow WHERE author_id = '$user_id_to_check' AND follower_id = '$user_id_to_check_from'", ARRAY_A );

    if( $wpdb->num_rows > 0 ) return true;
    else return false;
}

function user_profile_register_custom_post_status(){
        
    global $userprofile;
    
    foreach( $userprofile->get_all_post_status() as $post_status => $args ){

        register_post_status( $post_status, $args );
    }
}
add_action( 'init', 'user_profile_register_custom_post_status' );



function user_profile_current_user_attachments( $query ) {
    $user_id = get_current_user_id();
    if ( $user_id ) {
        $query['author'] = $user_id;
    }
    return $query;
}
add_filter( 'ajax_query_attachments_args', 'user_profile_current_user_attachments' );



function user_profile_shorten_string($string, $wordcount = 3, $RemoveHtml = true, $Extension = ' ...' ) {
		
	if( $RemoveHtml ) $string = strip_tags($string); 
	$array = explode( " ", $string );
	if ( count($array) > $wordcount ) {
		array_splice($array, $wordcount);
		return implode(" ", $array) . $Extension;
	}
	else return $string;
}



function user_profile_find_images_from_content( $content = '' ) {
	ob_start();
	ob_end_clean();
	preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);
	
	return isset( $matches[1][0] ) ? $matches[1][0] : "";
}



function user_profile_notice( $notice_type = '', $message = "", $is_front = true ){

	$notice_types = is_array( $notice_type ) ? implode( ' ', $notice_type ) : $notice_type;
	printf( "<p class='user-profile-notice %s'>%s</p>", $notice_types, $message );
}


function user_profile_get_post_status_icon( $post_status ){

    switch( $post_status ){

        case 'future'       : $html = '<i class="icofont icofont-bird-wings"></i>'; break;
        case 'draft'        : $html = '<i class="icofont icofont-save"></i>'; break;
        case 'pending'      : $html = '<i class="icofont icofont-list"></i>'; break;
        case 'private'      : $html = '<i class="icofont icofont-ui-lock"></i>'; break;
        case 'trash'        : $html = '<i class="icofont icofont-trash"></i>'; break;
        case 'followers'    : $html = '<i class="icofont icofont-users-alt-6"></i>'; break;
        
        default             : $html = '<i class="icofont icofont-earth"></i>'; break;
    }

    global $wp_post_statuses;

    $label  = isset( $wp_post_statuses[$post_status]->label ) ? $wp_post_statuses[$post_status]->label : '';
    $html   = sprintf( "<span class='post-status-icon hint--top' aria-label='%s'>%s</span>", $label, $html );

    return apply_filters( 'user_profile_filter_post_status_icon', $html, $post_status );
}

function user_profile_recursive_sanitize_arr($array) {

    foreach ( $array as $key => &$value ) {
        if ( is_array( $value ) ) {
            $value = user_profile_recursive_sanitize_arr($value);
        }
        else {
            $value = sanitize_text_field( $value );
        }
    }

    return $array;
}