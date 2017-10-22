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

if(isset($_POST['user_profile_places_hidden'])){
	
	
	
	$nonce = $_POST['_wpnonce'];
	if(wp_verify_nonce( $nonce, 'nonce_user_profile_places' )){
		
		$user_profile_places = stripslashes_deep($_POST['user_profile_places']);
		update_user_meta( $user_id, 'user_profile_places', $user_profile_places );
		
		$status_html.= '<span class="success"><i class="fa fa-check"></i> '.__('Saved successful.', 'user-profile').'</span>';
		}
		
	}
else{
	$user_profile_places = get_the_author_meta( 'user_profile_places', $user_id );	
	
	}







?>





<div class="section places">
   <h2><?php echo __('Places', 'user-profile'); ?></h2>
   
	<div class="status">
	<?php echo $status_html; ?>
    </div>
   
   		<form id="user-profile-places" class="" action="#user-profile-places" method="post">
        
        	<input name="user_profile_places_hidden" type="hidden" value="Y" />
        
   		<div class="add-places button"><?php echo __('Add', 'user-profile'); ?></div>
   		<div class="places-list sortable">
        
        
       <?php
        if(!empty($user_profile_places)):
		foreach($user_profile_places as $index=>$work){
			
			$location = $work['location'];
			$address = $work['address'];			
		
						
			
			?>
            <div class="item">
                <span class="remove user-profile-tooltip" title="<?php echo __('Delete', 'user-profile'); ?>"><i class="fa fa-times"></i></span>
                <span class="move user-profile-tooltip" title="<?php echo __('Sort', 'user-profile'); ?>"><i class="fa fa-bars" aria-hidden="true"></i></span>
                <input placeholder="<?php echo __('Location', 'user-profile'); ?>" type="text" name="user_profile_places[<?php echo $index; ?>][location]" value="<?php echo $location; ?>" />
                <input placeholder="<?php echo __('Address', 'user-profile'); ?>" type="text" name="user_profile_places[<?php echo $index; ?>][address]" value="<?php echo $address; ?>" />

                
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
        
        
        <?php wp_nonce_field( 'nonce_user_profile_places' ); ?>
        <input type="submit" value="<?php echo __('Update', 'user-profile'); ?>" />
        
        </form>
        
 <script>
jQuery(document).ready(function($){
	$(function() {
		$( ".sortable" ).sortable({ handle: '.move' });
	//$( ".items-container" ).disableSelection();
	});
	
	
$(document).on('click', '.add-places', function(){
	
	now = $.now();
	
	
	html = '<div class="item"><span class="remove"><i class="fa fa-times"></i></span> <span class="move"><i class="fa fa-bars" aria-hidden="true"></i></span> <input placeholder="Location" type="text" name="user_profile_places['+now+'][location]" value="" /> <input placeholder="Address" type="text" name="user_profile_places['+now+'][address]" value="" /> </div>';
	
	$('.places-list').append(html);
	
	})
});
</script>
   
   
</div>