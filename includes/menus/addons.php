<?php	


/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 



class class_user_profile_addons{
	
	
    public function __construct(){
		
    }
	
	

	public function addons_data($addons_data = array()){
		
		$addons_data_new = array(
							

			'verified-users'=>array(	'title'=>'Verified users',
										'version'=>'1.0.0',
										'price'=>'19',
										'content'=>'',										
										'item_link'=>'https://www.pickplugins.com/item/user-profile-verified-users/',
										'thumb'=>USER_PROFILE_PLUGIN_URL.'assets/admin/images/addons/verified-users.png',							
			),	


			'user-directory'=>array(	'title'=>'User directory',
										'version'=>'1.0.0',
										'price'=>'19',
										'content'=>'',										
										'item_link'=>'https://www.pickplugins.com/item/user-profile-user-directory/',
										'thumb'=>USER_PROFILE_PLUGIN_URL.'assets/admin/images/addons/user-directory.png',							
			),	

/*
 *
 			'message'=>array(	'title'=>'Message',
										'version'=>'1.0.0',
										'price'=>'0',
										'content'=>'',
										'item_link'=>'#',
										'thumb'=>USER_PROFILE_PLUGIN_URL.'assets/admin/images/addons/message.png',
			),
 * */




		);
		
		$addons_data = array_merge($addons_data_new,$addons_data);
		
		$addons_data = apply_filters('user_profile_filters_addons_data', $addons_data);
		
		return $addons_data;
		
		
		}



	public function qa_addons_html(){
		
		$html = '';
		
		$addons_data = $this->addons_data();
		
		foreach($addons_data as $key=>$values){
			
			$html.= '<div class="single '.$key.'">';
			$html.= '<div class="thumb"><a href="'.$values['item_link'].'"><img src="'.$values['thumb'].'" /></a></div>';			
			$html.= '<div class="title"><a href="'.$values['item_link'].'">'.$values['title'].'</a></div>';
			$html.= '<div class="content">'.$values['content'].'</div>';						
			$html.= '<div class="meta version"><b>'.__('Version:', 'user-profile').'</b> '.$values['version'].'</div>';
			
			if($values['price']==0){
				
				$price = __('Free', 'user-profile');
				}
			else{
				$price = '$'.$values['price'];
				
				}		
			$html.= '<div class="meta price"><b>'.__('Price:', 'user-profile').'</b> '.$price.'</div>';
			$html.= '<div class="meta download"><a href="'.$values['item_link'].'">'.__('Download', 'user-profile').'</a></div>';
			
			
			
			$html.= '</div>';
			
		
			
			}
		
		$html.= '';		
		
		return $html;
		}







}

new class_user_profile_addons();




	
	
?>





<div class="wrap">

	<div id="icon-tools" class="icon32"><br></div><?php echo "<h2>".sprintf(__('%s - Addons', 'user-profile'), USER_PROFILE_PLUGIN_NAME)."</h2>";?>

		<div class="user-profile-addons">
        
			<?php
            
            $class_user_profile_addons = new class_user_profile_addons();
            
            echo $class_user_profile_addons->qa_addons_html();
            
            
            ?>
        
        
        </div>

</div>
