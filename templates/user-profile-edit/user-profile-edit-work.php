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

if(isset($_POST['user_profile_work_hidden'])){
	
	
	$nonce = $_POST['_wpnonce'];
	if(wp_verify_nonce( $nonce, 'nonce_user_profile_work' )){
		
		$user_profile_work = stripslashes_deep($_POST['user_profile_work']);
		update_user_meta( $user_id, 'user_profile_work', $user_profile_work );
		
		$status_html.= '<span class="success"><i class="fa fa-check"></i> '.__('Saved successful.', 'user-profile').'</span>';
		}

	
	}
else{
	$user_profile_work = get_the_author_meta( 'user_profile_work', $user_id );	
	
	}



?>





<div class="section work">
   <h2><?php echo __('Work', 'user-profile'); ?></h2>
   
	<div class="status">
	<?php echo $status_html; ?>
    </div>

   
   		<form id="user-profile-work" class="" action="#user-profile-work" method="post">
        
        	<input name="user_profile_work_hidden" type="hidden" value="Y" />
        
   		<div class="add-work button"><?php echo __('Add', 'user-profile'); ?></div>
   		<div class="work-list sortable">
        
        <?php
        if(!empty($user_profile_work)):
		foreach($user_profile_work as $index=>$work){
			
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
						}
					else{
						$start_date = '';
						}						
					
					if(!empty($work['end_date'])){
						$end_date = $work['end_date'];
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
						
			
			?>
            <div class="item">
                <span class="remove user-profile-tooltip" title="<?php echo __('Delete', 'user-profile'); ?>"><i class="fa fa-times"></i></span>
                <span class="move user-profile-tooltip" title="<?php echo __('Sort', 'user-profile'); ?>"><i class="fa fa-bars" aria-hidden="true"></i></span>
                <input placeholder="<?php echo __('Position', 'user-profile'); ?>" type="text" name="user_profile_work[<?php echo $index; ?>][position]" value="<?php echo $position; ?>" />
                <input placeholder="<?php echo __('Company', 'user-profile'); ?>" type="text" name="user_profile_work[<?php echo $index; ?>][company]" value="<?php echo $company; ?>" />
                <input size="8" class="user_profile_date" placeholder="<?php echo __('Start date', 'user-profile'); ?>" type="text" name="user_profile_work[<?php echo $index; ?>][start_date]" value="<?php echo $start_date; ?>" />
                <input size="8" class="user_profile_date" placeholder="<?php echo __('End date', 'user-profile'); ?>" type="text" name="user_profile_work[<?php echo $index; ?>][end_date]" value="<?php echo $end_date; ?>" />
                <label><input title="" name="user_profile_work[<?php echo $index; ?>][running]" <?php if(!empty($running)) echo 'checked'; ?>  type="checkbox" value="yes" /> <?php echo __('Running', 'user-profile'); ?></label>
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
        
        
        <?php wp_nonce_field( 'nonce_user_profile_work' ); ?>
        <input type="submit" value="<?php echo __('Update', 'user-profile'); ?>" />
        
        </form>
        
 <script>
jQuery(document).ready(function($){
	$(function() {
		$( ".sortable" ).sortable({ handle: '.move' });
	//$( ".items-container" ).disableSelection();
	});
	
	
	
$(document).on('click', '.add-work', function(){
	
	now = $.now();
	
	
	html = '<div class="item"><span class="remove"><i class="fa fa-times"></i></span> <span class="move"><i class="fa fa-bars" aria-hidden="true"></i></span> <input placeholder="Position" type="text" name="user_profile_work['+now+'][position]" value="" /> <input placeholder="Company" type="text" name="user_profile_work['+now+'][company]" value="" /> <input size="8" class="user_profile_date" placeholder="Start date" type="text" name="user_profile_work['+now+'][start_date]" value="" /> <input size="8" class="user_profile_date" placeholder="End date" type="text" name="user_profile_work['+now+'][end_date]" value="" /> <label><input title="" name="user_profile_work['+now+'][running]"  type="checkbox" value="yes" /> Running</label></div>';
	
	$('.work-list').append(html);
	
	})
	
	
	
	
	
	
	
});
</script>
   
   
</div>