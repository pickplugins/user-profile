<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


class UserProfileWidgetUsers extends WP_Widget {

	function __construct() {
		
		parent::__construct( 'user_profile_widget_users', __('User Profile - Users', 'user-profile'), array( 'description' => __( 'Show Users.', 'user-profile' ), ) );
	}

	public function widget( $args, $instance ) {

		$title      = apply_filters( 'widget_title', $instance['title'] );
        $count      = isset( $instance[ 'count' ] ) ? $instance[ 'count' ] : 5;
        $template   = isset( $instance[ 'template' ] ) ? $instance[ 'template' ] : 'default';
        
        global $userprofile;
        echo $args['before_widget'];
        
        if ( ! empty( $title ) ) echo $args['before_title'] . $title . $args['after_title'];
        
        $users = get_users( array(
            'number' => $count,
        ) );
        
        foreach( $users as $user ) : $thisuser = new user_profile_user_data( $user->ID );

            if( is_wp_error( $html_user = $userprofile->generate_html_user( $thisuser, $template ) ) ) {
                
                $userprofile->print_error( $html_user );
                continue;
            }

            printf( $html_user );

        endforeach;
		
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		
		$title      = isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : __( 'Users', 'user-profile' );
        $count      = isset( $instance[ 'count' ] ) ? $instance[ 'count' ] : 5;
        $template   = isset( $instance[ 'template' ] ) ? $instance[ 'template' ] : 'default';

        global $userprofile;

        printf( "<p><label style='min-width:100px;display: inline-block;' for='%s'>%s</label><input id='%s' name='%s' type='text' value='%s' /></p>", 
            $this->get_field_id( 'title' ), __( 'Title' ), $this->get_field_id( 'title' ), $this->get_field_name( 'title' ), esc_attr( $title ) );
        
        printf( "<p><label style='min-width:100px;display: inline-block;' for='%s'>%s</label><input class='' id='%s' name='%s' type='text' value='%s' /></p>", 
            $this->get_field_id( 'count' ), __( 'Count' ), $this->get_field_id( 'count' ), $this->get_field_name( 'count' ), esc_attr( $count ) );
        

        printf( "<p><label style='min-width:100px;display: inline-block;' for='%s'>%s</label><select class='' id='%s' name='%s'>", 
            $this->get_field_id( 'template' ), __( 'Template' ), $this->get_field_id( 'template' ), $this->get_field_name( 'template' ) );
       
        foreach( $userprofile->get_user_templates() as $template_id => $template_info ){

            $selected = $template_id == $template ? 'selected' : '';
            printf( "<option %s value='%s'>%s</option>", $selected, $template_id, $template_info['title'] );
        }

        printf( "</select></p>" );
	}

	public function update( $new_instance, $old_instance ) {

		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['count'] = ( ! empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';
        $instance['template'] = ( ! empty( $new_instance['template'] ) ) ? strip_tags( $new_instance['template'] ) : '';
        
		return $instance;
	}
}