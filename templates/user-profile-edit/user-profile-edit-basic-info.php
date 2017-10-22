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


if(isset($_POST['user_profile_basic_info_hidden'])){
	
	
	$nonce = $_POST['_wpnonce'];
	if(wp_verify_nonce( $nonce, 'nonce_user_profile_basic_info' )){
		
		$user_profile_basic_info = stripslashes_deep($_POST['user_profile_basic_info']);
		
		//var_dump($user_profile_basic_info);
		$first_name= $user_profile_basic_info['first_name'];
		$last_name= $user_profile_basic_info['last_name'];
	
		update_user_meta( $user_id, 'user_profile_basic_info', $user_profile_basic_info );
		
		wp_update_user( array( 'ID' => $user_id, 'display_name' => $first_name.' '.$last_name ) );
		
		$status_html.= '<span class="success"><i class="fa fa-check"></i> '.__('Saved successful.', 'user-profile').'</span>';
		}
	
	
	}

else{
	$user_profile_basic_info = get_the_author_meta( 'user_profile_basic_info', $user_id );	
			
	
	}

	

		if(!empty($user_profile_basic_info['first_name'])){
			$first_name= $user_profile_basic_info['first_name'];
			}
		else{
			$first_name = '';
			}		
		
		if(!empty($user_profile_basic_info['last_name'])){
			$last_name= $user_profile_basic_info['last_name'];
			}
		else{
			$last_name = '';
			}		
		
		if(!empty($user_profile_basic_info['birth_date'])){
			$birth_date= $user_profile_basic_info['birth_date'];
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








		$class_user_profile_functions = new class_user_profile_functions();
		$user_relationship = $class_user_profile_functions->user_relationship();
		$user_gender = $class_user_profile_functions->user_gender();
?>





<div class="section basic-info">
	<h2><?php echo __('Basic Info', 'user-profile'); ?></h2>
        <div class="status">
        <?php echo $status_html; ?>
        </div>


   		<form id="user-profile-basic-info" class="" action="#user-profile-basic-info" method="post">
        
        	<input name="user_profile_basic_info_hidden" type="hidden" value="Y" />
   
			<p>
            <label>
            <?php echo __('First name', 'user-profile'); ?>
            </label>
            <input class="" placeholder="Jhon" type="text" name="user_profile_basic_info[first_name]" value="<?php echo $first_name; ?>" />
            
            <label>
            <?php echo __('Last name', 'user-profile'); ?>
            </label>
            <input class="" placeholder="Doe" type="text" name="user_profile_basic_info[last_name]" value="<?php echo $last_name; ?>" />            

            </p>                 
                

			<p>
            <label>
            <?php echo __('Birth date', 'user-profile'); ?>
            </label>
            <input class="user_profile_date" placeholder="2017-02-09" type="text" name="user_profile_basic_info[birth_date]" value="<?php echo $birth_date; ?>" />
            </p> 

			<p>
            <label>
            <?php echo __('Relationsship', 'user-profile'); ?>
            </label>
            
            <select name="user_profile_basic_info[relationship]">
            
            <?php
            foreach($user_relationship as $index=>$relation){
				
				$title = $relation['title'];
				
				
				?>
                <option <?php if($relationship == $index) echo 'selected'; ?>  value="<?php echo $index; ?>" ><?php echo $title; ?></option>
                <?php
				
				}
			
			?>
               
               
                
                           
            </select>

            </p> 


			<p>
            <label>
            <?php echo __('Gender', 'user-profile'); ?>
            </label>
            
            <select name="user_profile_basic_info[gender]">
                
            <?php
            foreach($user_gender as $index=>$gend){
				
				$title = $gend['title'];
				
				
				?>
                <option <?php if($gender == $index) echo 'selected'; ?>  value="<?php echo $index; ?>" ><?php echo $title; ?></option>
                <?php
				
				}
			
			?>
                
                
                
                
                
                                
            </select>

            </p> 





			<p>
            <label>
             <?php echo __('Religious', 'user-profile'); ?>
            </label>
            <input placeholder="Religious" type="text" name="user_profile_basic_info[religious]" value="<?php echo $religious; ?>" />
            </p>  
            
			<p>
            <label>
             <?php echo __('Website', 'user-profile'); ?>
            </label>
            <input placeholder="http://mydomain.com" type="text" name="user_profile_basic_info[website]" value="<?php echo $website; ?>" />
            </p> 
        
        

        
        
        
        
        <?php wp_nonce_field( 'nonce_user_profile_basic_info' ); ?>
        <input type="submit" value="<?php echo __('Update', 'user-profile'); ?>" />
        
        </form>
        



   
   
</div>