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
	
	
    if(isset($_POST['user_profile_contacts_hidden'])){
		
		$nonce = $_POST['_wpnonce'];
		if(wp_verify_nonce( $nonce, 'nonce_user_profile_contacts' )){
			
			$user_profile_contacts = stripslashes_deep($_POST['user_profile_contacts']);
			
			//var_dump($user_profile_contacts);
			
			update_user_meta( $user_id, 'user_profile_contacts', $user_profile_contacts );
			
			
			$status_html.= '<span class="success"><i class="fa fa-check"></i> '.__('Saved successful.', 'user-profile').'</span>';
			
			}
        

        
        }
    else{
        $user_profile_contacts = get_the_author_meta( 'user_profile_contacts', $user_id );	
        
        }
    
	
	$class_user_profile_functions = new class_user_profile_functions();
	$contact_methods = $class_user_profile_functions->contact_methods();	
	
	
	
	
    ?>




<div class="section contacts">
   <h2><?php echo __('Contacts', 'user-profile'); ?></h2>
   
	<div class="status">
	<?php echo $status_html; ?>
    </div>







   
   		<form id="user-profile-contacts" class="" action="#user-profile-contacts" method="post">
        
        	<input name="user_profile_contacts_hidden" type="hidden" value="Y" />
        
   		<div class="add-contacts button"><?php echo __('Add', 'user-profile'); ?></div>
   		<div class="contacts-list sortable">
        
        
       <?php
        if(!empty($user_profile_contacts)):
		foreach($user_profile_contacts as $index=>$work){
			
			$username = $work['username'];
			$profile_link = $work['profile_link'];			
			$network = $work['network'];			
						
			
			?>
            <div class="item">
                <span class="remove user-profile-tooltip" title="<?php echo __('Delete', 'user-profile'); ?>"><i class="fa fa-times"></i></span>
                <span class="move user-profile-tooltip" title="<?php echo __('Sort', 'user-profile'); ?>"><i class="fa fa-bars" aria-hidden="true"></i></span>
                <input placeholder="<?php echo __('Location', 'user-profile'); ?>" type="text" name="user_profile_contacts[<?php echo $index; ?>][username]" value="<?php echo $username; ?>" />
                <input placeholder="<?php echo __('Address', 'user-profile'); ?>" type="text" name="user_profile_contacts[<?php echo $index; ?>][profile_link]" value="<?php echo $profile_link; ?>" />
				<select name="user_profile_contacts[<?php echo $index; ?>][network]">
                 	
                    <?php
                    if(!empty($contact_methods)):
					foreach($contact_methods as $index=>$methods){
						
						$title = $methods['title'];
						
						?>
                        <option <?php if($network == $index) echo 'selected'; ?>  value="<?php echo $index; ?>"><?php echo $title;?></option>
                        <?php
						
						}
						
					endif;
					?>
                    
                                   
                   
                    
                </select>
                
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
        
        
        <?php wp_nonce_field( 'nonce_user_profile_contacts' ); ?>
        <input type="submit" value="<?php echo __('Update', 'user-profile'); ?>" />
        
        </form>
        
 <script>
jQuery(document).ready(function($){
	$(function() {
		$( ".sortable" ).sortable({ handle: '.move' });
	//$( ".items-container" ).disableSelection();
	});
	
	
$(document).on('click', '.add-contacts', function(){
	
	now = $.now();
	
	<?php 
	$network_option = '';
	foreach($contact_methods as $index=>$methods){
		
		$title = $methods['title'];
		
		$network_option.='<option value="'.$index.'">'.$title.'</option>';
		
	}
	
	?>
	
	html = '<div class="item"><span class="remove"><i class="fa fa-times"></i></span> <span class="move"><i class="fa fa-bars" aria-hidden="true"></i></span> <input placeholder="Username" type="text" name="user_profile_contacts['+now+'][username]" value="" /> <input placeholder="Profile link" type="text" name="user_profile_contacts['+now+'][profile_link]" value="" />				<select name="user_profile_contacts['+now+'][network]"><?php echo $network_option; ?></select></div>';
	
	$('.contacts-list').append(html);
	
	})
	
	
	
	

});
</script>
   
   
</div>