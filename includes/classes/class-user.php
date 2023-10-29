<?php
/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

if( ! class_exists( 'user_profile_user_data' ) ) {
class user_profile_user_data extends WP_User {
	
 	public function __construct( $user_id = 0 ) {
		
		parent::__construct( $user_id );
		$this->collect_data();
	}

	public function collect_data(){

		if( $this->ID == 0 ) return;
		
		$this->date_of_birth 	= get_user_meta( $this->ID, 'up_date_of_birth', true );
		$this->relationship 	= get_user_meta( $this->ID, 'up_relationship', true );
		$this->gender 			= get_user_meta( $this->ID, 'up_gender', true );
		$this->religious 		= get_user_meta( $this->ID, 'up_religious', true );
        $this->description 		= get_user_meta( $this->ID, 'description', true );
        
        $user_profile_cover     = get_user_meta( $this->ID, 'user_profile_cover', true );
        $user_profile_cover     = wp_get_attachment_url( $user_profile_cover );

        global $userprofile;
        $this->profile_page         = sprintf( "%s?id=%s", $userprofile->profile_page, $this->ID );
        $this->user_profile_img     = $this->get_profile_picture_url();

        $this->user_profile_cover   = empty( $user_profile_cover ) ? USER_PROFILE_PLUGIN_URL.'assets/front/images/cover.png' : $user_profile_cover;

        $display_name           = $this->first_name . ' ' . $this->last_name;
        $this->display_name     = empty( $this->first_name ) ? $this->user_login : $display_name;
	}

	public function get_posts( $args = array(), $return_wp_query = false ){

		$args = wp_parse_args( $args, array(
			'post_type' => 'post',
			'orderby' => 'date',
			'order' => 'DESC',
			'author' => $this->ID,
			'posts_per_page' => 10,
			'paged' => 1,
		) );

		if( $return_wp_query ) return new WP_Query( $args );
		else return get_posts( $args );
	}

	public function get_profile_picture_url(){
		
		$user_profile_img = get_the_author_meta( 'user_profile_img', $this->ID );
		
		return empty( $user_profile_img ) ? get_avatar_url( $this->ID, array('size'=>250)) : wp_get_attachment_url( $user_profile_img );
	}

	public function get_profile_picture(){
		
		$user_profile_img = get_the_author_meta( 'user_profile_img', $this->ID );
		$user_profile_img = empty( $user_profile_img ) ? get_avatar_url( $this->ID, array('size'=>250)) : wp_get_attachment_url( $user_profile_img );
		
		return sprintf( "<img src='%s' />", apply_filters('user_profile_filter_user_avatar', $user_profile_img) );
	}

	public function get_followers( $count = 5 ){

		global $wpdb;
		$res = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}user_profile_follow WHERE author_id = '$this->ID' ORDER BY id DESC LIMIT 0, $count" );

		$followers = array();
		foreach( $res as $follower ) {
			$followers[] = array( 
				'author_id' => $follower->author_id,
				'follower_id' => $follower->follower_id,
				'datetime' => $follower->datetime,
			);
		}
		return $followers;
    }
    
    public function get_following_users( $count = 5 ){

        global $wpdb;
		$res = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}user_profile_follow WHERE follower_id = '$this->ID' ORDER BY id DESC LIMIT 0, $count" );

		$following_users = array();
		foreach( $res as $following_user ) {
			$following_users[] = array( 
				'author_id' => $following_user->author_id,
				'follower_id' => $following_user->follower_id,
				'datetime' => $following_user->datetime,
			);
		}
		return $following_users;
    }

	public function get_photos( $count = 5 ){
		
		return get_posts( array ( 'post_type' => 'attachment', 'numberposts' => $count, 'author' => $this->ID, 'post_status' => null, 'post_parent' => null ) );
	}

	public function get_places(){

		if( $this->ID == 0 ) return;
		$places = get_user_meta( $this->ID, 'user_profile_places', true );
		return empty( $places ) ? array() : $places;
	}

	public function get_works(){

		if( $this->ID == 0 ) return;
		$works = get_user_meta( $this->ID, 'user_profile_work', true );
		return empty( $works ) ? array() : $works;
	}
	
	public function get_educations(){

		if( $this->ID == 0 ) return;
		$educations = get_user_meta( $this->ID, 'user_profile_education', true );
		return empty( $educations ) ? array() : $educations;
	}

	public function get_contacts(){

		if( $this->ID == 0 ) return;
		$contacts = get_user_meta( $this->ID, 'user_profile_contacts', true );
		return empty( $contacts ) ? array() : $contacts;
	}

	public function update_user_data( $args = array() ){

		if( empty( $args ) ) 
		return new WP_Error( 'empty_data', __( 'Nothing to update', '' ) );

		$userdata  = array( 'ID' => $this->ID );

		if( isset( $args['user_pass'] ) ) 		$userdata ['user_pass'] = $args['user_pass'];
		if( isset( $args['user_login'] ) ) 		$userdata ['user_login'] = $args['user_login'];
		if( isset( $args['user_nicename'] ) ) 	$userdata ['user_nicename'] = $args['user_nicename'];
		if( isset( $args['user_url'] ) ) 		$userdata ['user_url'] = $args['user_url'];
		if( isset( $args['user_email'] ) ) 		$userdata ['user_email'] = $args['user_email'];
		if( isset( $args['display_name'] ) ) 	$userdata ['display_name'] = $args['display_name'];
		if( isset( $args['nickname'] ) ) 		$userdata ['nickname'] = $args['nickname'];
		if( isset( $args['first_name'] ) ) 		$userdata ['first_name'] = $args['first_name'];
		if( isset( $args['last_name'] ) ) 		$userdata ['last_name'] = $args['last_name'];
		if( isset( $args['description'] ) ) 	$userdata ['description'] = $args['description'];

		if( isset( $args['rich_editing'] ) ) 	$userdata ['rich_editing'] = $args['rich_editing'];
		if( isset( $args['user_registered'] ) ) $userdata ['user_registered'] = $args['user_registered'];
		if( isset( $args['role'] ) ) 			$userdata ['role'] = $args['role'];
		if( isset( $args['jabber'] ) ) 			$userdata ['jabber'] = $args['jabber'];
		if( isset( $args['aim'] ) ) 			$userdata ['aim'] = $args['aim'];
		if( isset( $args['yim'] ) ) 			$userdata ['yim'] = $args['yim'];

		if( is_wp_error( $ret = wp_update_user( $userdata ) ) ) return $ret;

        $up_date_of_birth   = isset( $args['date_of_birth'] ) ? $args['date_of_birth'] : '';
        $up_relationship    = isset( $args['relationship'] ) ? $args['relationship'] : '';
        $up_gender          = isset( $args['gender'] ) ? $args['gender'] : '';
        $up_religious       = isset( $args['religious'] ) ? $args['religious'] : '';

        update_user_meta( $this->ID, 'up_date_of_birth', $up_date_of_birth );
        update_user_meta( $this->ID, 'up_relationship', $up_relationship );
        update_user_meta( $this->ID, 'up_gender', $up_gender );
        update_user_meta( $this->ID, 'up_religious', $up_religious );

		foreach( $userdata as $key => $value ) if( $this->{$key} ) $this->{$key} = $value;
		
		if( isset( $args['user_profile_contacts'] ) ) 	if( is_wp_error( $ret = $this->set_contacts( $args['user_profile_contacts'] ) ) ) return $ret;
		if( isset( $args['user_profile_work'] ) ) 		if( is_wp_error( $ret = $this->set_works( $args['user_profile_work'] ) ) ) return $ret;
		if( isset( $args['user_profile_education'] ) ) 	if( is_wp_error( $ret = $this->set_educations( $args['user_profile_education'] ) ) ) return $ret;
		if( isset( $args['user_profile_places'] ) ) 	if( is_wp_error( $ret = $this->set_places( $args['user_profile_places'] ) ) ) return $ret;
        
        // echo "<pre>"; print_r( $args ); echo "</pre>";


        // echo "<pre>"; print_r( get_post_meta( $this->ID, 'up_date_of_birth', true ) ); echo "</pre>";
        // wp_die();

		do_action( 'user_profile_action_update_user', $this->ID, $args );

        $this->collect_data();
        
		return true;
	}

	public function set_contacts( $contacts = array() ){

		update_user_meta( $this->ID, 'user_profile_contacts', $contacts );
	}
	
	public function set_educations( $educations = array() ){

		update_user_meta( $this->ID, 'user_profile_education', $educations );
	}

	public function set_works( $works = array() ){

		update_user_meta( $this->ID, 'user_profile_work', $works );
	}

	public function set_places( $places = array() ){

		update_user_meta( $this->ID, 'user_profile_places', $places );
	}

}

}

