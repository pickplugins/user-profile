<?php
/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


class User_profile_functions{
    
    public $profile_page = '';
    public $profile_edit_page = '';
    public $current_user_id = '';

    public function __construct(){

        add_action( 'init', array( $this, 'init' ) );
    }

    public function init(){

        $this->current_user_id = get_current_user_id();

        $user_profile_page_id = get_option( 'user_profile_page_id' );
        $user_profile_edit_page_id = get_option( 'user_profile_edit_page_id' );

        $post = get_post( $user_profile_edit_page_id );

        if( ! empty( $user_profile_page_id ) ) $this->profile_page = get_permalink( $user_profile_page_id );
        if( ! empty( $user_profile_edit_page_id ) ) $this->profile_edit_page = get_permalink( $user_profile_edit_page_id );
    }

    public function generate_html_contact_single( $contact = array() ){

        $network        = isset( $contact['network'] ) ? $contact['network'] : '';
        $profile_link   = isset( $contact['profile_link'] ) ? $contact['profile_link'] : '';

        if( ! array_key_exists( $network, $contact_methods = $this->contact_methods() ) ) return; 

        ob_start();

        echo apply_filters( 'user_profile_filter_contact_single', 
		    sprintf( "<a style='background-color:%s' class='item %s hint--top' aria-label='%s' href='%s'>%s</a>", 
                isset( $contact_methods[$network]['bg_color'] ) ? $contact_methods[$network]['bg_color'] : '',
                $network,
                isset( $contact_methods[ $network ]['title'] ) ? $contact_methods[ $network ]['title'] : '',
                isset( $contact['profile_link'] ) ? $contact['profile_link'] : '',
                isset( $contact_methods[ $network ]['icon'] ) ? $contact_methods[ $network ]['icon'] : ''
            ), 
            $contact 
        );
            
        return ob_get_clean();
    }

    public function generate_html_user( $thisuser = null, $template = '' ){

        if( empty( $thisuser ) ) return new WP_Error( 'empty_data', __('Invalid or empty user data given !', 'user-profile') );
        if( empty( $template ) ) $template = 'default';
        
        $template_dir = sprintf( "%stemplates/user-templates/%s.php", USER_PROFILE_PLUGIN_DIR, $template );
        $template_dir = apply_filters( 'user_profile_filter_user_template_dir', $template_dir, $template, $thisuser );
        $template_dir = file_exists( $template_dir ) ? $template_dir : '';

        if( empty( $template_dir ) ) return new WP_Error( 'empty_data', __('Invalid or empty template directory found !', 'user-profile') );

        ob_start();
        include $template_dir;
        return ob_get_clean();
    }

	public function generate_html_place( $index = '', $data = array() ){

		$index		= empty( $index ) ? time() : $index;
		$location		= isset( $data['location'] ) ? $data['location'] : '';
		$address		= isset( $data['address'] ) ? $data['address'] : '';
		
		ob_start();

		echo "<div class='item'>";
		printf( "<span class='meta remove hint--top' aria-label='%s'><i class='icofont icofont-close'></i></span>", __('Delete', 'user-profile') );
		printf( "<span class='meta move hint--top' aria-label='%s'><i class='icofont icofont-hand-drag'></i></span>", __('Sort', 'user-profile') );
		printf( "<input class='meta' type='text' name='user_profile_places[%s][location]' value='%s' placeholder='%s' >", $index, $location, __('Location', 'user-profile') );
		printf( "<input class='meta' type='text' name='user_profile_places[%s][address]' value='%s' placeholder='%s' >", $index, $address, __('Address', 'user-profile') );	
		echo "</div>";	
		
		return ob_get_clean();
	}
	
	public function generate_html_education( $index = '', $data = array() ){

		$index		= empty( $index ) ? time() : $index;
		$school		= isset( $data['school'] ) ? $data['school'] : '';
		$degree		= isset( $data['degree'] ) ? $data['degree'] : '';
		$start_date	= isset( $data['start_date'] ) ? $data['start_date'] : '';
		$end_date 	= isset( $data['end_date'] ) ? $data['end_date'] : '';
		$running	= isset( $data['running'] ) ? $data['running'] : '';
		$checked	= $running == 'yes' ? 'checked' : '';
		$disabled	= $running == 'yes' ? 'disabled' : '';

		ob_start();

		echo "<div class='item'>";
		printf( "<span class='meta remove hint--top' aria-label='%s'><i class='icofont icofont-close'></i></span>", __('Delete', 'user-profile') );
		printf( "<span class='meta move hint--top' aria-label='%s'><i class='icofont icofont-hand-drag'></i></span>", __('Sort', 'user-profile') );
		
		printf( "<input class='meta' type='text' name='user_profile_education[%s][school]' value='%s' placeholder='%s' >", $index, $school, __('School/College/University', 'user-profile') );
		printf( "<input class='meta' type='text' name='user_profile_education[%s][degree]' value='%s' placeholder='%s' >", $index, $degree, __('Degree', 'user-profile') );
		printf( "<input class='meta user_profile_date' type='text' name='user_profile_education[%s][start_date]' value='%s' placeholder='%s' >", $index, $start_date, __('Start date', 'user-profile') );
		printf( "<input class='meta user_profile_date end_date' type='text' name='user_profile_education[%s][end_date]' value='%s' placeholder='%s' %s >", $index, $end_date, __('End date', 'user-profile'), $disabled );
		printf( "<input class='meta user_profile_checkbox' id='user_profile_checkbox_%s' name='user_profile_education[%s][running]' %s type='checkbox' value='yes'>", $index, $index, $checked, __('Running', 'user-profile') );
		printf( "<label class='meta' for='user_profile_checkbox_%s'> %s</label>", $index, __('Running', 'user-profile') );

		echo "</div>";	
		
		return ob_get_clean();
	}
	
	public function generate_html_work( $index = '', $data = array() ){

		$index		= empty( $index ) ? time() : $index;
		$position	= isset( $data['start_date'] ) ? $data['position'] : '';
		$company	= isset( $data['start_date'] ) ? $data['company'] : '';
		$start_date	= isset( $data['start_date'] ) ? $data['start_date'] : '';
		$end_date 	= isset( $data['end_date'] ) ? $data['end_date'] : '';
		$running	= isset( $data['running'] ) ? $data['running'] : '';
		$checked	= $running == 'yes' ? 'checked' : '';
		$disabled	= $running == 'yes' ? 'disabled' : '';

		ob_start();

		echo "<div class='item'>";
		printf( "<span class='meta remove hint--top' aria-label='%s'><i class='icofont icofont-close'></i></span>", __('Delete', 'user-profile') );
		printf( "<span class='meta move hint--top' aria-label='%s'><i class='icofont icofont-hand-drag'></i></span>", __('Sort', 'user-profile') );
		printf( "<input class='meta' type='text' name='user_profile_work[%s][position]' value='%s' placeholder='%s' >", $index, $position, __('Position', 'user-profile') );
		printf( "<input class='meta' type='text' name='user_profile_work[%s][company]' value='%s' placeholder='%s' >", $index, $company, __('Company', 'user-profile') );
		printf( "<input class='meta user_profile_date' type='text' name='user_profile_work[%s][start_date]' value='%s' placeholder='%s' >", $index, $start_date, __('Start date', 'user-profile') );
		printf( "<input class='meta user_profile_date end_date' type='text' name='user_profile_work[%s][end_date]' value='%s' placeholder='%s' %s >", $index, $end_date, __('End date', 'user-profile'), $disabled );
		printf( "<input class='meta user_profile_checkbox' id='user_profile_checkbox_%s' name='user_profile_work[%s][running]' %s type='checkbox' value='yes'>", $index, $index, $checked, __('Running', 'user-profile') );
		printf( "<label class='meta' for='user_profile_checkbox_%s'> %s</label>", $index, __('Running', 'user-profile') );
		echo "</div>";		
		
		return ob_get_clean();
	}

	public function generate_html_contact( $index = '', $data = array() ){
		
		$index			= empty( $index ) ? time() : $index;
		$username 		= isset( $data['username'] ) ? $data['username'] : '';
		$profile_link 	= isset( $data['profile_link'] ) ? $data['profile_link'] : '';
		$network		= isset( $data['profile_link'] ) ? $data['network'] : '';

		ob_start();

		echo "<div class='item'>";
		printf( "<span class='meta remove hint--top' aria-label='%s'><i class='icofont icofont-close'></i></span>", __('Delete', 'user-profile') );
		printf( "<span class='meta move hint--top' aria-label='%s'><i class='icofont icofont-hand-drag'></i></span>", __('Sort', 'user-profile') );
		printf( "<input class='meta' type='text' name='user_profile_contacts[%s][username]' value='%s' placeholder='%s' >", $index, $username, __('Username', 'user-profile') );
		printf( "<input class='meta' type='text' name='user_profile_contacts[%s][profile_link]' value='%s' placeholder='%s' >", $index, $profile_link, __('Profile link', 'user-profile') );
		printf( "<select class='meta' name='user_profile_contacts[%s][network]'>", $index );

		foreach( $this->contact_methods() as $key => $method ) :	
		printf( "<option %s value='%s'>%s</option>", $key == $network ? 'selected' : '', $key, isset( $method['title'] ) ? $method['title'] : '' );
		endforeach;

		echo "</select>";
		echo "</div>";		
		
		return ob_get_clean();
	}

	public function profile_edit_navs(){
	
		return apply_filters('user_profile_filter_profile_edit_navs', array(

			'basicinfo' => array(
				'title'	=> __('Basic Info', 'user-profile'),
			),
			'contacts' => array(
				'title'	=> __('Contacts', 'user-profile'),
			),
			'works' => array(
				'title'	=> __('Works', 'user-profile'),
			),
			'educations' => array(
				'title'	=> __('Educations', 'user-profile'),
			),
			'places' => array(
				'title'	=> __('Places', 'user-profile'),
			),

		) );
	}


	public function profile_navs(){


		$navs['feed'] = array('title'	=> __('Feed', 'user-profile'), 'priority'=> 1);
		$navs['about'] = array('title'	=> __('About', 'user-profile'), 'priority'=> 2);
		$navs['followers'] = array('title'	=> __('Followers', 'user-profile'), 'priority'=> 3);
		$navs['following'] = array('title'	=> __('Following', 'user-profile'), 'priority'=> 4);

		return apply_filters('user_profile_filter_profile_navs', $navs);

	}


	public function profile_nav_default(){

		return apply_filters('user_profile_filter_profile_nav_default', 'feed');

	}

	
	public function contact_methods() {
		
		return apply_filters( 'user_profile_contact_methods', array(
            
            'facehook'      => array( 
                'title'     => 'Facebook',
				'icon'      => '<i class="icofont icofont-social-facebook"></i>',
				'bg_color'  => '#4968aa',
			),	
		    'twitter'       => array(
				'title'     => 'Twitter',
				'icon'      => '<i class="icofont icofont-social-twitter"></i>',
				'bg_color'  => '#55acee',
            ),
		    'google_plus'   => array(
				'title'     => 'Google+',
				'icon'      => '<i class="icofont icofont-social-google-plus"></i>',
				'bg_color'  => '#e7463a',
            ),		
		    'linkedin'      => array(
			    'title'=>'Linkedin',
				'icon'=>'<i class="icofont icofont-brand-linkedin"></i>',
				'bg_color'=>'#55acee',
            ),	
		    'pinterest'     => array(
				'title'     => 'Pinterest',
				'icon'      => '<i class="icofont icofont-social-pinterest"></i>',
				'bg_color'  => '#cb1f26',
            ),	
		    'youtube'       => array(
				'title'     => 'Youtube',
				'icon'      => '<i class="icofont icofont-social-youtube"></i>',
				'bg_color'  => '#cc181e',
            )
        ) );
	}	
	
	public function user_gender() {
		
		return apply_filters( 'user_profile_user_gender', array(

		    'male'      => array(
			    'title' => __('Male', 'user-profile'),
				'icon'  => '<i class="icofont icofont-man-in-glasses"></i>',
            ),
		    'female'    => array(
			    'title' => __('Female', 'user-profile'),
				'icon'  => '<i class="icofont icofont-woman-in-glasses"></i>',
            ),	
		    'others'    => array(
				'title' => __('Others', 'user-profile'),
				'icon'  => '<i class="icofont icofont-funky-man"></i>',
            )

        ) );
	}
	
	public function user_relationship() {
		
		return apply_filters( 'user_profile_user_relationship', array(

		    'single'    => array(
                'title' => __('Single', 'user-profile'),
            ),				
		    'engaged'   => array(
				'title' => __('Engaged', 'user-profile'),
            ),
		    'in_relationship' => array(
				'title' => __('In a relationship', 'user-profile'),
            ),
		    'married'   => array(
				'title' => __('Married', 'user-profile'),
            ),			
		    'separated' => array(
				'title' => __('Separated', 'user-profile'),
            ),			
		    'divorced'  => array(
				'title' => __('Divorced', 'user-profile'),
            ),
		    'widowed'   => array(
				'title' => __('Widowed', 'user-profile'),
            )
            	
        ) );

    }
    


    public function get_user_templates( $two_dimensional = false ){
        
        $user_templates = apply_filters( 'user_profile_filter_user_templates', array(

            'default'   => array( 
                'title' => __( 'Template - Default', 'user-profile' ),
            ),
            'social'    => array(
                'title' => __( 'Template - Social logo', 'user-profile' ),
            ),
            'flat'      => array( 
                'title' => __( 'Template - Flat', 'user-profile' ),
            ),

        ) );

        if( $two_dimensional ){
            $_user_templates = array();
            foreach( $user_templates as $key => $value ){
                $_user_templates[ $key ] = isset( $value['title'] ) ? $value['title'] : '';
            }
            return $_user_templates;
        }

        return $user_templates;
    }

    public function get_current_user(){

        if( is_user_logged_in() ) return new user_profile_user_data( get_current_user_id() );
        else return null;
    }

    public function print_error( $wp_error ){
        
        $classes = array( $wp_error->get_error_code() );

        if( is_admin() ) $classes[] = 'is-dismissible';

        printf( "<div class='notice notice-error error user-profile-notice %s'><p>%s</p></div>", 
            implode( ' ', $classes ), $wp_error->get_error_message() 
        );   
    }

    public function get_all_post_status(){

        return apply_filters( 'user_profile_filter_post_status', array(
            
            'followers' => array(
                'label' => __( 'Followers', 'user-profile' ),
                'public'                    => true,
                'exclude_from_search'       => false,
                'show_in_admin_all_list'    => true,
                'show_in_admin_status_list' => true,
                'label_count'               => _n_noop( 
                    'Followers <span class="count">(%s)</span>', 
                    'Followers <span class="count">(%s)</span>', 
                    'user-profile' 
                ),
            ),

        ) );
    }

    public function get_all_reactions(){

        return apply_filters( 'user_profile_filter_post_reactions', array(

            'like' => array(
                'label' => __( 'Liked it', 'user-profile' ),
                'icon'  => '<i class="icofont icofont-thumbs-up"></i>',
            ),
            'love' => array(
                'label' => __( 'Love', 'user-profile' ),
                'icon'  => '<i class="icofont icofont-emo-heart-eyes"></i>',
            ),
            'smile' => array(
                'label' => __( 'Smile', 'user-profile' ),
                'icon'  => '<i class="icofont icofont-emo-slightly-smile"></i>',
            ),
            'cry' => array(
                'label' => __( 'Crying', 'user-profile' ),
                'icon'  => '<i class="icofont icofont-emo-crying"></i>',
            ),
            'tounge' => array(
                'label' => __( 'Stuck-out-tounge', 'user-profile' ),
                'icon'  => '<i class="icofont icofont-emo-stuck-out-tongue"></i>',
            ),
            'dizzy' => array(
                'label' => __( 'Dizzy', 'user-profile' ),
                'icon'  => '<i class="icofont icofont-emo-dizzy"></i>',
            ),
            'smirk' => array(
                'label' => __( 'Smirk', 'user-profile' ),
                'icon'  => '<i class="icofont icofont-emo-smirk"></i>',
            ),
            // 'dislike' => array(
            //     'label' => __( 'Disliked it', 'user-profile' ),
            //     'icon'  => '<i class="icofont icofont-thumbs-down"></i>',
            // ),


        ) );
    }

    public function add_post_reaction( $post_id = 0, $reaction = '', $user_id = 0 ){

        if( $user_id == 0 ) $user_id = $this->current_user_id;

        if( $user_id == 0 ) {
            return new WP_Error( 'login_required', __( 'Please login to continue !', 'user-profile' ) );
        }

        if( $post_id == 0 || empty( $reaction ) || $user_id == 0 ) {
            return new WP_Error( 'empty_data', __( 'Invalid data found !', 'user-profile' ) );
        }

        global $wpdb;

        $check_query    = sprintf( "select * from %s where post_id=%s and user_id=%s", $wpdb->prefix . "user_profile_reactions", $post_id, $user_id );
        $is_found       = $wpdb->get_row( $check_query );

        if( $is_found !== null ) {

            return $wpdb->update( $wpdb->prefix . "user_profile_reactions",
                array( 
                    'reaction' => $reaction,
                ), 
                array( 
                    'post_id' => $post_id,
                    'user_id' => $user_id,
                )
            );
        }

        return $wpdb->insert( $wpdb->prefix . "user_profile_reactions",
            array( 
                'post_id' => $post_id, 
                'user_id' => $user_id, 
                'reaction' => $reaction, 
                'datetime' => current_time( 'mysql' ), 
            )
        );        
    }

    public function get_reaction_count( $post_id = 0 ){

        global $wpdb;
        $count_query = sprintf( "select count(*) from %s where post_id=%s", $wpdb->prefix . "user_profile_reactions", $post_id );

        return $wpdb->get_var( $count_query );
    }

    public function get_reaction( $post_id = 0, $user_id = 0 ){

        if( $user_id == 0 ) $user_id = $this->current_user_id;

        global $wpdb;
        $reaction_query = sprintf( "select reaction from %s where post_id=%s and user_id=%s", $wpdb->prefix . "user_profile_reactions", $post_id, $user_id );

        return $wpdb->get_var( $reaction_query );
    }



}

global $userprofile;
$userprofile = new User_profile_functions();



// echo '<pre>'; print_r( $userprofile ); echo '</pre>';