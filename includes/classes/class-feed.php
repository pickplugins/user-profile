<?php
/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

class User_profile_feed{
	
	public $feed_query = null;
	public $posts_per_page = 10;
	public $feed_for_user = 0;
	public $post_template_url = "";
	public $pagination_template_url = "";
	public $paged = 1;

	public function __construct(){

		$this->feed_for_user = get_current_user_id();
		$this->set_template();
		$this->set_template_pagination();
	}

	public function feed_query(){
		
		$posts_of_users = $this->get_following_user();
		$posts_of_users = empty( $posts_of_users ) ? "" : implode( ",", $posts_of_users );
		$posts_of_users = empty( $posts_of_users ) ? $this->feed_for_user : $this->feed_for_user .",". $posts_of_users;

		$query_args = apply_filters( 'user_profile_filter_feed_query', array (
			'post_type'         => 'post',
			'orderby'           => 'date',
			'order'             => 'DESC',
			'author'            => $posts_of_users,
            'paged'             => $this->paged,
            'post_status'       => $this->post_status_to_show(),
			'posts_per_page'    => $this->posts_per_page,
		) );
		
		$this->feed_query = new WP_Query( $query_args );
    }
    
    public function post_status_to_show( $post_status = array( 'publish' ) ){

        $current_user_id = get_current_user_id();

        if( $current_user_id == $this->feed_for_user ) $post_status[] = 'any';
        if( in_array( $current_user_id, $this->get_following_user() ) ) $post_status[] = 'followers';
        
        return $post_status;
    }

	public function generate_feed(){

        $this->feed_query();

		if( $this->feed_query->post_count == 0 ) return false;

		ob_start();
		if ( $this->feed_query->have_posts() ) : while ( $this->feed_query->have_posts() ) : 
            
			$this->feed_query->the_post();
			echo $this->generate_single_feed_item( get_the_ID() );
		
		endwhile; wp_reset_query(); endif;
		return ob_get_clean();
	}

	public function generate_feed_pagination(){

		if( empty( $this->pagination_template_url ) ) return;

		ob_start();
		include $this->pagination_template_url;
		return ob_get_clean();
	}

	public function generate_single_feed_item( $post_id = null ){

        if( empty( $this->post_template_url ) || empty( $post_id ) ) 
            return new WP_Error( 'invalid_data', __('Invalid data passed !', 'user-profile') );

        $post       = get_post( $post_id );
        $thisuser   = new user_profile_user_data( $post->post_author );
        
        ob_start();
        include $this->post_template_url;
		return ob_get_clean();
	}
	
	public function get_following_user(){

		global $wpdb;
		$users = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}user_profile_follow WHERE follower_id = '$this->feed_for_user'" );

		$following_users = array();
		foreach( $users as $user ) $following_users[] = $user->author_id;

		return $following_users;
	}

	public function set_template_pagination( $template_url = '' ){
		if( empty( $template_url ) )
			$template_url = USER_PROFILE_PLUGIN_DIR . "templates/user-profile/nav-content/inside-feed/pagination.php";
		$this->pagination_template_url = apply_filters( 'user_profile_filter_feed_pagination_template', $template_url );
	}
	
	public function set_template( $template_url = '' ){
		if( empty( $template_url ) )
			$template_url = USER_PROFILE_PLUGIN_DIR . "templates/user-profile/nav-content/inside-feed/post-single.php";
		$this->post_template_url = apply_filters( 'user_profile_filter_feed_single_template', $template_url );
	}

	public function set_feed_for_user( $user_id ){
		$this->feed_for_user = $user_id;
	}

	public function set_posts_per_page( $count = 10 ){
		$this->posts_per_page = $count;
	}

	public function set_paged( $paged = 1 ){
		$this->paged = $paged;
	}
}