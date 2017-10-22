<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 



if(is_user_logged_in()){
	
	$logged_user_id = get_current_user_id(); 
	$user_id = get_current_user_id();
	//var_dump($logged_user_id);
	}
else{
	return;
	}

$status_html = '';

if(isset($_POST['user_profile_education_hidden'])){
	
	
	
	$nonce = $_POST['_wpnonce'];
	if(wp_verify_nonce( $nonce, 'nonce_user_profile_education' )){
		
		$user_profile_education = stripslashes_deep($_POST['user_profile_education']);
		update_user_meta( $user_id, 'user_profile_education', $user_profile_education );
		
		$status_html.= '<span class="success"><i class="fa fa-check"></i> '.__('Saved successful.', 'user-profile').'</span>';
		}
	
	
	
	

	
	}
else{
	$user_profile_education = get_the_author_meta( 'user_profile_education', $user_id );	
	
	}






?>





<div class="section education">
   <h2><?php echo __('Education', 'user-profile'); ?></h2>
   
	<div class="status">
	<?php echo $status_html; ?>
    </div>
   
   		<form id="user-profile-education" class="" action="#user-profile-education" method="post">
        
        	<input name="user_profile_education_hidden" type="hidden" value="Y" />
        
   		<div class="add-education button"><?php echo __('Add', 'user-profile'); ?></div>
   		<div class="education-list sortable">
        
        
        <?php
        if(!empty($user_profile_education)):
		foreach($user_profile_education as $index=>$education){
			
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
						}
					else{
						$start_date = '';
						}					
					
					if(!empty($education['end_date'])){
						$end_date = $education['end_date'];
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
						
			
			?>
            <div class="item">
                <span class="remove user-profile-tooltip" title="<?php echo __('Delete', 'user-profile'); ?>"><i class="fa fa-times"></i></span>
                <span class="move user-profile-tooltip" title="<?php echo __('Sort', 'user-profile'); ?>"><i class="fa fa-bars" aria-hidden="true"></i></span>
                <input placeholder="<?php echo __('School/College/University', 'user-profile'); ?>" type="text" name="user_profile_education[<?php echo $index; ?>][school]" value="<?php echo $school; ?>" />
                <input placeholder="<?php echo __('Degree', 'user-profile'); ?>" type="text" name="user_profile_education[<?php echo $index; ?>][degree]" value="<?php echo $degree; ?>" />
                <input size="8" class="user_profile_date" placeholder="<?php echo __('Start date', 'user-profile'); ?>" type="text" name="user_profile_education[<?php echo $index; ?>][start_date]" value="<?php echo $start_date; ?>" />
                <input size="8" class="user_profile_date" placeholder="<?php echo __('End date', 'user-profile'); ?>" type="text" name="user_profile_education[<?php echo $index; ?>][end_date]" value="<?php echo $end_date; ?>" />
                <label><input title="" name="user_profile_education[<?php echo $index; ?>][running]" <?php if(!empty($running)) echo 'checked'; ?>  type="checkbox" value="yes" /> <?php echo __('Running', 'user-profile'); ?></label>
            </div>
            
            
            <?php

			}
		else:
		
		?>
        <div class="item"></div>
        <?php
		
		
		
		endif;
		?>   
        
        
        </div>
        
        
        <?php wp_nonce_field( 'nonce_user_profile_education' ); ?>
        <input type="submit" value="<?php echo __('Update', 'user-profile'); ?>" />
        
        </form>
        
 <script>
jQuery(document).ready(function($){
	
	$(function() {
		$( ".sortable" ).sortable({ handle: '.move' });
	//$( ".items-container" ).disableSelection();
	});
	
$(document).on('click', '.add-education', function(){
	
	now = $.now();
	
	
	html = '<div class="item"><span class="remove"><i class="fa fa-times"></i></span> <span class="move"><i class="fa fa-bars" aria-hidden="true"></i></span> <input placeholder="School/College" type="text" name="user_profile_education['+now+'][school]" value="" /> <input placeholder="Degree" type="text" name="user_profile_education['+now+'][degree]" value="" /> <input size="8" class="user_profile_date" placeholder="Start date" type="text" name="user_profile_education['+now+'][start_date]" value="" /> <input size="8" class="user_profile_date" placeholder="End date" type="text" name="user_profile_education['+now+'][end_date]" value="" /> <label><input title="" name="user_profile_education['+now+'][running]"  type="checkbox" value="yes" /> Running</label></div>';
	
	$('.education-list').append(html);
	
	})
	
	
});
</script>
   
   
</div>