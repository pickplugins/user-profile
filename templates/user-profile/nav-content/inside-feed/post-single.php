<?php
/*
* @Author 		: pickplugins
* Copyright     : 2015 pickplugins
* Passed Data   :
    $post       : Current Post object inside loop
    $thisuser   : User object of post author or current post inside loop
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

global $userprofile;

$post_thumbnail_url = get_the_post_thumbnail_url( $post->ID );
$post_thumbnail_url = empty( $post_thumbnail_url ) ? user_profile_find_images_from_content( $post->post_content ) : $post_thumbnail_url;

$excerpt_content = $post->post_content;
$excerpt_content = user_profile_shorten_string( $excerpt_content, rand( 20, 30 ) );
$excerpt_content = apply_filters( 'the_content', $excerpt_content );

$time_ago = human_time_diff( get_the_date( 'U', $post->ID ), current_time( 'timestamp' ) );
$time_ago = sprintf( __('Posted %s ago', 'user-profile'), $time_ago );

?>

    <div class="single single-<?php echo $post->ID; ?>" post-id="<?php echo $post->ID; ?>" id="single-<?php echo $post->ID; ?>">

        <div class="post-header">
            <div class="post-header-left">
                <div class="post-avatar">
                    <?php echo get_avatar( $thisuser->ID ); ?>
                </div>

                <?php do_action( 'user_profile_action_post_header_left', $post->ID ); ?>

            </div>
            <div class="post-header-right">
                <div class="post-username">
                    <?php printf( "<a href='%s'>%s</a>", $thisuser->profile_page, $thisuser->display_name ); ?>
                </div>
                <div class="date hint--top" aria-label="<?php echo $time_ago; ?>">
                    <i class="icofont icofont-time"></i>
                    <?php echo get_the_date( 'F j, Y', $post->ID ); ?>
                </div>

                <?php do_action( 'user_profile_action_post_header_right', $post->ID ); ?>

            </div>

            <div class="post-header-action">

                <?php 
                echo user_profile_get_post_status_icon( $post->post_status );

                if( get_current_user_id() == $thisuser->ID ) {
                    
                    global $wp_post_statuses;

                    printf( "<select post_id='%s' class='post-status-box'>", $post->ID );
                    foreach( $wp_post_statuses as $post_status => $args ){

                        if( in_array( $post_status, array( 'auto-draft', 'future', 'inherit', ) ) ) continue;
                        $selected = $post->post_status == $post_status ? 'selected' : '';
                        printf( "<option %s value='%s'>%s</option>", $selected, $post_status, $args->label );
                    }
                    printf( "</select>" );
                } 
                ?>

                <?php do_action( 'user_profile_action_post_header_action', $post->ID ); ?>

            </div>

        </div>

        <div class="post-content">
            <div class="excerpt">
                <?php echo $excerpt_content; ?>
            </div>

            <?php if( ! empty( $post_thumbnail_url ) ) : ?>
            <div class="post-thumbnail">
                <img src="<?php echo $post_thumbnail_url; ?>" />
            </div>
            <?php endif; ?>
        </div>

        <div class="post-view-more">
            <?php _e('View more', 'user-profile'); ?>
        </div>

        <div class="post-reactions">

            <div class="reaction_count">
                <?php echo $userprofile->get_reaction_count( $post->ID ); ?>
            </div>

            <div class="reactions emos" post-id="<?php echo $post->ID; ?>">

                <?php $reaction_done = $userprofile->get_reaction( $post->ID ); ?>

                <?php foreach( $userprofile->get_all_reactions() as $key => $reaction ) : 

                    printf( "<span aria-label='%s' reaction='%s' class='emo hint--top %s %s'>%s</span>", 
                        isset( $reaction['label'] ) ? $reaction['label'] : '',
                        $key, $key, $reaction_done == $key ? 'reacted' : '',
                        isset( $reaction['icon'] ) ? $reaction['icon'] : '<i class="icofont icofont-chart-pie-alt"></i>'
                    ); 
                    
                endforeach; ?>
            </div>

            <span class="reaction_notice"></span>


        </div>

    </div>