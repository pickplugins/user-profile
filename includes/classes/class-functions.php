<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


class class_user_profile_functions{
	
	public function __construct() {

		//add_action('add_meta_boxes', array($this, 'meta_boxes_question'));
		//add_action('save_post', array($this, 'meta_boxes_question_save'));

	}
	
	
	
	
	
	
	public function profile_navs(){


		if(isset($_GET['id'])){
			
			$user_id = sanitize_text_field($_GET['id']);
			//var_dump($user_id);
			}
		else{
			
			$user_id = get_current_user_id(); 
			}





		$navs['post'] = array(
							'title'=>__('Post', 'user-profile'),
							'html'=>apply_filters('user_profile_filter_profile_navs_post', $this->user_profile_filter_profile_navs_post($user_id)),	
							);
							
		$navs['about'] = array(
							'title'=>__('About', 'user-profile'),
							'html'=>apply_filters('user_profile_filter_profile_navs_about', $this->user_profile_filter_profile_navs_about($user_id)),	
							);							
							
		$navs['follower'] = array(
							'title'=>__('Followers', 'user-profile'),
							'html'=>apply_filters('user_profile_filter_profile_navs_follower', $this->user_profile_filter_profile_navs_follower($user_id)),	
							);							
							
		$navs['following'] = array(
							'title'=>__('Following', 'user-profile'),
							'html'=>apply_filters('user_profile_filter_profile_navs_following', $this->user_profile_filter_profile_navs_following($user_id)),	
							);								
							
							
							
							
							

		$navs = apply_filters('user_profile_filter_profile_navs', $navs);		

		return $navs;

		}		
	
	
	function user_profile_filter_profile_navs_post($user_id){
		ob_start();
		
		$posts_per_page = get_option('posts_per_page');
		
		//echo $user_id;
		
		if ( get_query_var('paged') ) {
		
			$paged = get_query_var('paged');
		
		} elseif ( get_query_var('page') ) {
		
			$paged = get_query_var('page');
		
		} else {
		
			$paged = 1;
		}
		

		$wp_query = new WP_Query(
			array (
				'post_type' => 'post',
				'orderby' => 'date',
				'order' => 'DESC',
				'author' => $user_id,
				'posts_per_page' => $posts_per_page,
				'paged' => $paged,
				
				) );
				
		
		?>
        <div class="user-posts">
        <?php
			
		if ( $wp_query->have_posts() ) :
		while ( $wp_query->have_posts() ) : $wp_query->the_post();
		
		?>
        	<div class="single">
            
            	<div class="title"><a href="<?php echo get_permalink(); ?>"><?php echo the_title(); ?></a></div>
            	<div class="excerpt"><?php echo get_the_excerpt(); ?></div>
            	<div class="date"><?php echo the_date(); ?></div>                
                             
            </div>
        <?php
			
		endwhile;
		
		//echo '</table>'; 
		?>
        <div class="paginate">
        <?php
		$big = 999999999; // need an unlikely integer
		echo paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, $paged ),
			'total' => $wp_query->max_num_pages
			) );
		?>
        </div>
        <?php


		wp_reset_query();
		
		else:
		?>
        <i class="fa fa-exclamation-circle" aria-hidden="true"></i> <?php echo __('No post found.'); ?>
        <?php		
	
		
		endif;
			
			
		?>
		
        </div>
        
        
        <?php
		
		return ob_get_clean();
		}
	
	
	function user_profile_filter_profile_navs_about($user_id){
		ob_start();
		
		$class_user_profile_functions = new class_user_profile_functions();
		$contact_methods = $class_user_profile_functions->contact_methods();
		$user_gender = $class_user_profile_functions->user_gender();		
		$user_relationship = $class_user_profile_functions->user_relationship();

		$user_profile_basic_info = get_the_author_meta( 'user_profile_basic_info', $user_id );
		
		if(!empty($user_profile_basic_info['birth_date'])){
			$birth_date= $user_profile_basic_info['birth_date'];
			
			$birth_date = new DateTime($birth_date);
			$birth_date = $birth_date->format('d M, Y');
			}
		else{
			$birth_date = '';
			}
		
		
		
		if(!empty($user_profile_basic_info['religious'])){
			$religious= $user_profile_basic_info['religious'];
			}
		else{
			$religious= '';
			}
		
		if(!empty( $user_profile_basic_info['gender'])){
			$gender= $user_profile_basic_info['gender'];
			}
		else{
			$gender= '';
			}
		
		if(!empty( $user_profile_basic_info['relationship'])){
			$relationship= $user_profile_basic_info['relationship'];
			}
		else{
			$relationship= '';
			}
		
		if(!empty( $user_profile_basic_info['website'])){
			$website= $user_profile_basic_info['website'];
			}
		else{
			$website= '';
			}		
		
		
		
		$user_profile_contacts = get_the_author_meta( 'user_profile_contacts', $user_id );			
		$user_profile_work = get_the_author_meta( 'user_profile_work', $user_id );	
		$user_profile_education = get_the_author_meta( 'user_profile_education', $user_id );
		$user_profile_places = get_the_author_meta( 'user_profile_places', $user_id );

		if(!empty($user_gender[$gender])){
			
			$gender_info = $user_gender[$gender];
			$gender_title = $gender_info['title'];
			
			}

		if(!empty($user_relationship[$relationship])){
			
			$relationship_info = $user_relationship[$relationship];
			$relationship_title = $relationship_info['title'];	
			
			}
		
		

		?>
		<div class="basic-info">
        	<div class="container">
            
                <h5 class=""><?php echo __('Basic Info', 'user-profile'); ?></h5>
                
                <?php do_action('user_profile_action_before_basic_info'); ?>
                
 				<?php
                if(!empty($gender_title)):
				?>
                <div class="item gender">
                    <span class=""><?php echo __('Gender:', 'user-profile'); ?> </span><span class=""><?php echo $gender_title; ?></span>
                </div> 
                <?php
                endif;
				?>
                               
 				<?php
                if(!empty($relationship_title)):
				?>
                <div class="item relationship">
               	 <span class=""><?php echo __('Relationship:', 'user-profile'); ?> </span><span class=""><?php echo $relationship_title; ?></span>
                </div>            
                
                <?php
                endif;
				?>
                
                
                <div class="item religious">
                	<span class=""><?php echo __('Religious:', 'user-profile'); ?> </span><span class=""><?php echo $religious; ?></span>
                </div>            
                
                <div class="item birth_date">
                	<span class=""><?php echo __('Birth date:', 'user-profile'); ?> </span><span class=""><?php echo $birth_date; ?></span>
                </div>
                
                <div class="item website">
                	<span class=""><?php echo __('Website:', 'user-profile'); ?> </span><span class=""><a href="<?php echo $website; ?>"><?php echo $website; ?></a></span>
                </div>            
                
                <?php do_action('user_profile_action_after_basic_info'); ?>
            
            </div>
            
            
            
            <div class="container">
            	
               <h5 class=""><?php echo __('Contacts', 'user-profile'); ?></h5>
                <div class="contact-list">
                <?php
                if(!empty($user_profile_contacts))
				foreach($user_profile_contacts as $contacts){
					
					$username = $contacts['username'];
					$profile_link = $contacts['profile_link'];			
					$network = $contacts['network'];
					
					
					foreach($contact_methods as $index=>$methods){
						
						$title = $methods['title'];
						$icon = $methods['icon'];
						$bg_color = $methods['bg_color'];
						
						if($network==$index && !empty($profile_link)){
							
							?><a style=" background-color:<?php echo $bg_color; ?>" class="item <?php echo $network; ?>" href="<?php echo $profile_link; ?>"><?php //echo $username; ?><?php echo $icon; ?></a><?php
							}
						
						}
					
					
					
					
					
					}
				
				
				?>
                </div>
                
                
                
                
                
                
                
            </div>
            
            
            
            
            
            
            
            
            
            
            
        
        </div>
        
        <div class="other-info">
        	<div class="container">
            
            	<div class="info-box">
                <h4><?php echo __('Education', 'user-profile'); ?></h4>
                
                <?php 
				
				if(!empty($user_profile_education))
				foreach($user_profile_education as $index=>$education){
					
					//if(empty($work)) break;
					
					if(!empty($education['school'])){
						$school = $education['school'];
						}
					else{
						$school = '';
						}
					
					if(!empty($education['degree'])){
						$degree = $education['degree'];
						}
					else{
						$degree = '';
						}					
					
					if(!empty($education['start_date'])){
						$start_date = $education['start_date'];
						
						$start_date 	= new DateTime($start_date);
						$start_date 	= $start_date->format('M d, Y');
						
						}
					else{
						$start_date = '';
						}					
					
					if(!empty($education['end_date'])){
						$end_date = $education['end_date'];
						
						$end_date 	= new DateTime($end_date);
						$end_date 	= $end_date->format('M d, Y');
						
						
						}
					else{
						$end_date = '';
						}					
		
					if(!empty($education['running'])){
						$running = $education['running'];
						}
					else{
						$running = '';
						}	
					
					
					
					?><div class="item">
                    <span class="icon"><i class="fa fa-graduation-cap" aria-hidden="true"></i></span>
                    <span class="school"><?php echo $school; ?></span>
                    <span class="degree"><?php echo $degree; ?></span>
                    
                    
                    <?php
                    
					if(!empty($running)):
					
					?>
                    <span class="date"> <?php echo __('Running.', 'user-profile'); ?></span>
                    <?php
					
					else:
					
					?>
                    <span class="date"><?php echo $start_date; ?> to <?php echo $end_date; ?></span>
                    <?php
					
					endif;

					?>                  
                    
                    </div>
                    <?php
					
					}
				
				
				?>
                
                </div>            
            
            	<div class="info-box">
                <h4><?php echo __('Work', 'user-profile'); ?></h4>
                
                <?php 
				
				if(!empty($user_profile_work))
				foreach($user_profile_work as $index=>$work){
					
					//if(empty($work)) break;
					if(!empty($work['position'])){
						$position = $work['position'];
						}
					else{
						$position = '';
						}
					
					if(!empty($work['company'])){
						$company = $work['company'];
						}
					else{
						$company = '';
						}					
					
					if(!empty($work['start_date'])){
						$start_date = $work['start_date'];
						
						$start_date 	= new DateTime($start_date);
						$start_date 	= $start_date->format('M d, Y');
						
						}
					else{
						$start_date = '';
						}						
					
					if(!empty($work['end_date'])){
						$end_date = $work['end_date'];
						$end_date 	= new DateTime($end_date);
						$end_date 	= $end_date->format('M d, Y');
						
						}
					else{
						$end_date = '';
						}					
					
					if(!empty($work['running'])){
						$running = $work['running'];
						}
					else{
						$running = '';
						}
					

					
					
					
					?><div class="item">
                    <span class="icon"><i class="fa fa-briefcase" aria-hidden="true"></i></span>
                    <span class="company"><?php echo $company; ?></span>
                    <span class="position"><?php echo $position; ?></span>
                
                    <?php
                    
					if(!empty($running)):
					
					?>
                    <span class="date"> <?php echo __('Running.', 'user-profile'); ?></span>
                    <?php
					
					else:
					
					?>
                    <span class="date"><?php echo $start_date; ?> to <?php echo $end_date; ?></span>
                    <?php
					
					endif;

					?>

                    </div>
                    <?php
					
					}
				
				
				?>
                
                </div> 
            
            
            	<div class="info-box">
                <h4><?php echo __('Places', 'user-profile'); ?></h4>
                
                <?php 
				
				if(!empty($user_profile_places))
				foreach($user_profile_places as $index=>$place){
					
					//if(empty($work)) break;
					
					$location = $place['location'];
					$address = $place['address'];
					
					
					
					?><div class="item">
                    <span class="icon user_profile-tooltip" title="<?php echo __('Click to delete.', 'user-profile'); ?>"><i class="fa fa-map-pin" aria-hidden="true"></i></span>
                    
                    <span class="location"><?php echo $location; ?></span>
                    <span class="address"><?php echo $address; ?></span>                 
                    
                    </div>
                    <?php
					
					}
				
				
				?>
                
                </div>             
            
            
            
            
            
            
            
            
            
            
            
            </div>
        </div>
        
        <?php
		return ob_get_clean();
		
		}	
	
	
	function user_profile_filter_profile_navs_following($user_id){
		ob_start();
		
		$user_profile_page_id = get_option('user_profile_page_id');
		$user_profile_page_url = get_permalink($user_profile_page_id);
		$total_following = (int)get_the_author_meta( 'total_following', $user_id );

		global $wpdb;
		$table = $wpdb->prefix . "user_profile_follow";
		
		
		$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
		$limit = 10;
		$offset = ( $pagenum - 1 ) * $limit;
		$follower_query = $wpdb->get_results( "SELECT * FROM $table WHERE follower_id = '$user_id' ORDER BY id DESC LIMIT $offset, $limit" );		

		//$follower_query = $wpdb->get_results("SELECT * FROM $table WHERE author_id = '$user_id'", ARRAY_A);

		$logged_user_id = get_current_user_id();
		
		if(!empty($total_following)):
		?>
		<div class="tottal-following">
        <?php echo sprintf(__('Total following: %s', 'user-profile'), $total_following); ?>
        </div>
        <?php
		
		
		endif;
		?>

		<div class="follower-list">
        
        <?php
		
		
		$count = 1;
		
		if(!empty($follower_query)):
        foreach($follower_query as $entry){
			

			$follower_id = $entry->follower_id;
			$author_id = $entry->author_id;	
			$datetime = $entry->datetime;					
			
			//$follower_id = $follower['id'];
			//$author_id = $follower['author_id'];			
			//$follower_id = $follower['follower_id'];			
			//$datetime = $follower['datetime'];			
			
			$follower_info = get_user_by('ID', $author_id);
			
			$display_name = $follower_info->display_name;
			$user_email = $follower_info->user_email;			
			
			$user_profile_cover_id = get_the_author_meta( 'user_profile_cover', $author_id );		
				
			//var_dump($user_profile_cover_id);
			
			if(empty($user_profile_cover_id)){
				
					$user_profile_cover = USER_PROFILE_PLUGIN_URL.'assets/front/images/cover.png';
					$user_profile_cover = '<img src="'.$user_profile_cover.'" />';
				}
			else{
					$user_profile_cover =  wp_get_attachment_url($user_profile_cover_id);
					$user_profile_cover = '<img src="'.$user_profile_cover.'" />';
					//$user_profile_cover = apply_filters('user_profile_filter_profile_cover', $user_profile_cover);
				}
				

			
			
			$follow_result = $wpdb->get_results("SELECT * FROM $table WHERE author_id = '$author_id' AND follower_id = '$logged_user_id'", ARRAY_A);
			//var_dump($logged_user_id);
			
			$already_insert = $wpdb->num_rows;
			if($already_insert > 0 ){
				
				
				$follow_text = __('Following', 'user-profile');
				$follow_class = 'following';			
				
				}
			else{
				
				$follow_text = __('Follow', 'user-profile');
				$follow_class = '';
				}
			
			
			
			
			
			
			
			//echo '<pre>'.var_export($follower_info, true).'</pre>';
			$user_avatar = get_avatar($author_id, 250);
			?><div class="single">
            	<div class="cover"><a href="<?php echo $user_profile_page_url.'?id='.$author_id; ?>"><?php echo $user_profile_cover; ?></a></div>            
            	<div class="thumb"><a href="<?php echo $user_profile_page_url.'?id='.$author_id; ?>"><?php echo $user_avatar; ?></a></div>
                <div class="name"><?php echo apply_filters('user_profile_filter_following_list_user_name', $display_name, $author_id); ?></div>
                <div user_id="<?php echo $author_id; ?>" class="follow <?php echo $follow_class; ?>"><?php echo $follow_text; ?></div>                
            </div><?php
			
			$count++;
			}
		else:
		echo 'Nothing found.';
		endif;
		
		

 
		$total = $wpdb->get_var( "SELECT COUNT(`id`) FROM $table WHERE author_id = '$user_id'" );
		$num_of_pages = ceil( $total / $limit );
		$page_links = paginate_links( array(
			'base' => add_query_arg( 'pagenum', '%#%' ),
			'format' => '',
			'prev_text' => '&laquo;',
			'next_text' => '&raquo;',
			'total' => $num_of_pages,
			'current' => $pagenum
		) );
		 
		if ( $page_links ) {
			echo '<div class="paginate">' . $page_links . '</div>';
		}
 

		
		
		
		
		?>
        </div>
        <?php
		return ob_get_clean();
		
		}	
	
	
	
	function user_profile_filter_profile_navs_follower($user_id){
		ob_start();
		
		$user_profile_page_id = get_option('user_profile_page_id');
		$user_profile_page_url = get_permalink($user_profile_page_id);
		$total_follower = (int)get_the_author_meta( 'total_follower', $user_id );

		global $wpdb;
		$table = $wpdb->prefix . "user_profile_follow";
		
		
		$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
		$limit = 10;
		$offset = ( $pagenum - 1 ) * $limit;
		$follower_query = $wpdb->get_results( "SELECT * FROM $table WHERE author_id = '$user_id' ORDER BY id DESC LIMIT $offset, $limit" );		

		//$follower_query = $wpdb->get_results("SELECT * FROM $table WHERE author_id = '$user_id'", ARRAY_A);

		$logged_user_id = get_current_user_id();
		
		if(!empty($total_follower)):
		?>
		<div class="tottal-follower">
        <?php echo sprintf(__('Total follower: %s', 'user-profile'), $total_follower); ?>
        </div>
        <?php
		
		
		endif;
		?>


		<div class="follower-list">
        
        <?php
		
		
		$count = 1;
		
		if(!empty($follower_query)):
        foreach($follower_query as $entry){
			

			$follower_id = $entry->follower_id;
			$author_id = $entry->author_id;	
			$datetime = $entry->datetime;					
			
			//$follower_id = $follower['id'];
			//$author_id = $follower['author_id'];			
			//$follower_id = $follower['follower_id'];			
			//$datetime = $follower['datetime'];			
			
			$follower_info = get_user_by('ID', $follower_id);
			
			$display_name = $follower_info->display_name;
			$user_email = $follower_info->user_email;			
			
			$user_profile_cover_id = get_the_author_meta( 'user_profile_cover', $follower_id );		
			
			//var_dump($user_profile_cover_id);
			
			if(empty($user_profile_cover_id)){
				
				$user_profile_cover = USER_PROFILE_PLUGIN_URL.'assets/front/images/cover.png';
				$user_profile_cover = '<img src="'.$user_profile_cover.'" />';
				
				}
			else{

					$user_profile_cover =  wp_get_attachment_url($user_profile_cover_id);
					$user_profile_cover = '<img src="'.$user_profile_cover.'" />';
					//$user_profile_cover = apply_filters('user_profile_filter_profile_cover', $user_profile_cover);

				}
			
			
			$follow_result = $wpdb->get_results("SELECT * FROM $table WHERE author_id = '$follower_id' AND follower_id = '$logged_user_id'", ARRAY_A);
			//var_dump($logged_user_id);
			
			$already_insert = $wpdb->num_rows;
			if($already_insert > 0 ){
				
				
				$follow_text = __('Following', 'user-profile');
				$follow_class = 'following';			
				
				}
			else{
				
				$follow_text = __('Follow', 'user-profile');
				$follow_class = '';
				}
			
			
			
			
			
			
			
			//echo '<pre>'.var_export($follower_info, true).'</pre>';
			$user_avatar = get_avatar($follower_id, 250);
			?><div class="single">
            	<div class="cover"><a href="<?php echo $user_profile_page_url.'?id='.$follower_id; ?>"><?php echo $user_profile_cover; ?></a></div>            
            	<div class="thumb"><a href="<?php echo $user_profile_page_url.'?id='.$follower_id; ?>"><?php echo $user_avatar; ?></a></div>
                <div class="name"><?php echo apply_filters('user_profile_filter_follower_list_user_name', $display_name, $follower_id); ?></div>
                <div user_id="<?php echo $follower_id; ?>" class="follow <?php echo $follow_class; ?>"><?php echo $follow_text; ?></div>                
            </div><?php
			
			$count++;
			}
		else:
		echo __('No follower found', 'user-profile');
		endif;
		
		

 
		$total = $wpdb->get_var( "SELECT COUNT(`id`) FROM $table WHERE author_id = '$user_id'" );
		$num_of_pages = ceil( $total / $limit );
		$page_links = paginate_links( array(
			'base' => add_query_arg( 'pagenum', '%#%' ),
			'format' => '',
			'prev_text' => '&laquo;',
			'next_text' => '&raquo;',
			'total' => $num_of_pages,
			'current' => $pagenum
		) );
		 
		if ( $page_links ) {
			echo '<div class="paginate">' . $page_links . '</div>';
		}
 

		
		
		
		
		?>
        </div>
        <?php
		return ob_get_clean();
		
		}	
	
		
	
	
	public function contact_methods() {
		
		
		$methods['facebook'] = array(
									'title'=>'Facebook',
									'icon'=>'<i class="fa fa-facebook"></i>',
									'bg_color'=>'#4968aa',
									
									);
									
		$methods['twitter'] = array(
									'title'=>'Twitter',
									'icon'=>'<i class="fa fa-twitter" aria-hidden="true"></i>',
									'bg_color'=>'#55acee',
									
									);									
									
		$methods['google_plus'] = array(
									'title'=>'Google+',
									'icon'=>'<i class="fa fa-google-plus-official" aria-hidden="true"></i>',
									'bg_color'=>'#e7463a',
									
									);									
									
		$methods['linkedin'] = array(
									'title'=>'Linkedin',
									'icon'=>'<i class="fa fa-linkedin" aria-hidden="true"></i>',
									'bg_color'=>'#55acee',
									
									);									
									
		$methods['pinterest'] = array(
									'title'=>'Pinterest',
									'icon'=>'<i class="fa fa-pinterest-p" aria-hidden="true"></i>',
									'bg_color'=>'#cb1f26',
									
									);	
									
		$methods['youtube'] = array(
									'title'=>'Youtube',
									'icon'=>'<i class="fa fa-youtube-play" aria-hidden="true"></i>',
									'bg_color'=>'#cc181e',
									
									);											
		
		
		return apply_filters('user_profile_contact_methods', $methods);
		
		}	
	
	
	
	public function user_gender() {
		
		
		$gender['male'] = array(
									'title'=>__('Male', 'user-profile'),
									'icon'=>'<i class="fa fa-male"></i>',

									
									);
									
		$gender['female'] = array(
									'title'=>__('Female', 'user-profile'),
									'icon'=>'<i class="fa fa-female" aria-hidden="true"></i>',
									);									
									
		$gender['others'] = array(
									'title'=>__('Others', 'user-profile'),
									'icon'=>'<i class="fa fa-google-plus-official" aria-hidden="true"></i>',

									
									);									
									
											
		
		
		return apply_filters('user_profile_user_gender', $gender);
		
		}	
	
	
	public function user_relationship() {
		
		
		$relations['single'] = array(
									'title'=>__('Single', 'user-profile'),
									'icon'=>'<i class="fa fa-facebook"></i>',
									);
									
		$relations['engaged'] = array(
									'title'=>__('Engaged', 'user-profile'),
									'icon'=>'<i class="fa fa-facebook"></i>',
									);
									
		$relations['in_relationship'] = array(
									'title'=>__('In a relationship', 'user-profile'),
									'icon'=>'<i class="fa fa-facebook"></i>',
									);
								
		$relations['married'] = array(
									'title'=>__('Married', 'user-profile'),
									'icon'=>'<i class="fa fa-facebook"></i>',
									);								
								
		$relations['separated'] = array(
									'title'=>__('Separated', 'user-profile'),
									'icon'=>'<i class="fa fa-facebook"></i>',
									);								
								
		$relations['divorced'] = array(
									'title'=>__('Divorced', 'user-profile'),
									'icon'=>'<i class="fa fa-facebook"></i>',
									);								
		$relations['widowed'] = array(
									'title'=>__('Widowed', 'user-profile'),
									'icon'=>'<i class="fa fa-facebook"></i>',
									);									
											
		
		
		return apply_filters('user_profile_user_relationship', $relations);
		
		}		
	
	
	
	
	
	
	
	
	
	public function get_pages_list() {
		$array_pages[''] = __('None', 'user-profile');
		
		foreach( get_pages() as $page )
		if ( $page->post_title ) $array_pages[$page->ID] = $page->post_title;
		
		return $array_pages;
	}
	

} new class_user_profile_functions();