<?php	


/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 



class class_qa_settings_page  {
	
	
    public function __construct(){
		
    }
	
	public function qa_settings_options($options = array()){
		
		$class_user_profile_functions = new class_user_profile_functions();



		$section_options = array(
			
			'user_profile_page_id'=>array(
				'css_class'=>'user_profile_page_id',					
				'title'=>__('User profile page', 'user-profile'),
				'option_details'=>__('Select user profile page where the shortcode placed <pre>[user_profile]</pre>', 'user-profile'),
				'input_type'=>'select', 
				'input_args'=> $class_user_profile_functions->get_pages_list(),
			),
			'user_profile_edit_page_id'=>array(
				'css_class'=>'user_profile_edit_page_id',					
				'title'=>__('User profile edit page', 'user-profile'),
				'option_details'=>__('Select user profile edit page where the shortcode placed <pre>[user_profile_edit]</pre>', 'user-profile'),
				'input_type'=>'select', 
				'input_args'=> $class_user_profile_functions->get_pages_list(),
			),
			

			
			
			
			
			
			
		);
		$options['<i class="fa fa-folder"></i> '.__('Pages', 'user-profile')] = apply_filters( 'qa_settings_section_question_post', $section_options );


		
		$options = apply_filters( 'qa_filter_settings_options', $options );
		
		return $options;
	}
	
	
	public function qa_settings_options_form(){
		
			global $post;
			
			$qa_settings_options = $this->qa_settings_options();
			$html = '';

			$html.= '<div class="para-settings qa-settings">';			

			$html_nav = '';
			$html_box = '';
					
			$i=1;
			foreach($qa_settings_options as $key=>$options){
			
			if( $i == 1 ) $html_nav.= '<li nav="'.$i.'" class="nav'.$i.' active">'.$key.'</li>';				
			else $html_nav.= '<li nav="'.$i.'" class="nav'.$i.'">'.$key.'</li>';
				
			if( $i == 1 ) $html_box.= '<li style="display: block;" class="box'.$i.' tab-box active">';				
			else $html_box.= '<li style="display: none;" class="box'.$i.' tab-box">';

			$single_html_box = '';
			
			foreach( $options as $option_key => $option_info ){
				
				$option_value =  get_option( "$option_key", '' );				
				if( empty( $option_value ) )
				$option_value = isset( $option_info['input_values'] ) ? $option_info['input_values'] : '';
				
				$placeholder = isset( $option_info['placeholder'] ) ? $option_info['placeholder'] : ''; 
				
				$single_html_box.= '<div class="option-box '.$option_info['css_class'].'">';
				$single_html_box.= '<p class="option-title">'.$option_info['title'].'</p>';
				$single_html_box.= '<p class="option-info">'.$option_info['option_details'].'</p>';
				
				if($option_info['input_type'] == 'text')
				$single_html_box.= '<input type="text" id="'.$option_key.'" placeholder="'.$placeholder.'" name="'.$option_key.'" value="'.$option_value.'" /> ';					
	
				elseif( $option_info['input_type'] == 'text-multi' ) {
					
/*

					$input_args = $option_info['input_args'];
					foreach( $input_args as $input_args_key => $input_args_values ) {
						if(empty($option_value[$input_args_key]))
						$option_value[$input_args_key] = $input_args[$input_args_key];
							
						$single_html_box.= '<label>'.ucfirst($input_args_key).'<br/><input class="job-bm-color" type="text" placeholder="'.$placeholder.'" name="'.$option_key.'['.$input_args_key.']" value="'.$option_value[$input_args_key].'" /></label><br/>';	
					}	

*/	
					
					$input_values = $option_value;
					$option_id = $option_key;
					
					$single_html_box.= '<div class="repatble">';
					$single_html_box.= '<div class="repatble-items">';
					
					if(!empty($input_values)){
						if(is_array($input_values)){
							
							foreach($input_values as $key=>$value){
								
								$single_html_box.= '<div class="single">';
								$single_html_box.= '<input type="text" name="'.$option_id.'['.$key.']" value="'.$input_values[$key].'" />';
								$single_html_box.= '<input class="remove-field button" type="button" value="'.__('Remove').'" />';	
								
								$single_html_box.= '</div>';
								}
	
							
							}
						else{
							$single_html_box.= '<input type="text" name="'.$option_id.'[]" value="'.$input_values.'" /> ';
							$single_html_box.= '<input class="remove-field button" type="button" value="'.__('Remove').'" />';
							}
						}
					else{
						$single_html_box.= '<input type="text" name="'.$option_id.'[]" value="'.$input_values.'" /> ';
						$single_html_box.= '<input class="remove-field button" type="button" value="'.__('Remove').'" />';
						}
					$single_html_box.= '</div>';
					//$html.= '<input type="text" placeholder="" name="'.$option_id.'[]" value="'.$input_values.'" /> ';
					$single_html_box.= '<input  class="add-field button" option-id="'.$option_id.'" type="button" value="'.__('Add more').'" /> ';
					$single_html_box.= '</div>';
					
					//$html.= '<br /><br />';						
				
				}
					
				elseif($option_info['input_type'] == 'textarea')
				$single_html_box.= '<textarea placeholder="'.$placeholder.'" name="'.$option_key.'" >'.$option_value.'</textarea> ';
					
				elseif( $option_info['input_type'] == 'radio' ) {
					
					$input_args = $option_info['input_args'];
					foreach( $input_args as $input_args_key => $input_args_values ) {
						
						$checked = ( $input_args_key == $option_value ) ? $checked = 'checked' : '';
							
						$html_box.= '<label><input class="'.$option_key.'" type="radio" '.$checked.' value="'.$input_args_key.'" name="'.$option_key.'"   >'.$input_args_values.'</label><br/>';
					}
				}
					
				elseif( $option_info['input_type'] == 'select' ) {
					
					$input_args = $option_info['input_args'];
					$single_html_box 	.= '<select name="'.$option_key.'" >';
					
					foreach( $input_args as $input_args_key => $input_args_values ) {
						$selected = ( $input_args_key == $option_value ) ? 'selected' : '';
						$single_html_box.= '<option '.$selected.' value="'.$input_args_key.'">'.$input_args_values.'</option>';
					}
					
					$single_html_box.= '</select>';
				}					
				
				elseif( $option_info['input_type'] == 'selectmultiple' ) {
					
					$input_args = $option_info['input_args'];
					$single_html_box.= '<select multiple="multiple" size="6" name="'.$option_key.'[]" >';

					foreach($input_args as $input_args_key=>$input_args_values){
						
						$selected = in_array( $input_args_key, $option_value ) ? 'selected' : '';
						$single_html_box.= '<option '.$selected.' value="'.$input_args_key.'">'.$input_args_values.'</option>';
					}
					$single_html_box.= '</select>';
				}				

				elseif( $option_info['input_type'] == 'checkbox' ) {
					foreach($option_info['input_args'] as $input_args_key=>$input_args_values){

						$checked = in_array( $input_args_key, $option_value ) ? 'checked' : '';
						$single_html_box.= '<label><input '.$checked.' value="'.$input_args_key.'" name="'.$option_key.'['.$input_args_key.']"  type="checkbox" >'.$input_args_values.'</label><br/>';
					}
				}
					
				elseif( $option_info['input_type'] == 'file' ){
					
					$single_html_box.= '<input type="text" id="file_'.$option_key.'" name="'.$option_key.'" value="'.$option_value.'" /><br />';
					$single_html_box.= '<input id="upload_button_'.$option_key.'" class="upload_button_'.$option_key.' button" type="button" value="Upload File" />';					
					$single_html_box.= '<br /><br /><div style="overflow:hidden;max-height:150px;max-width:150px;" class="logo-preview"><img style=" width:100%;" src="'.$option_value.'" /></div>';
					$single_html_box.= '
					<script>jQuery(document).ready(function($){
					var custom_uploader; 
					jQuery("#upload_button_'.$option_key.'").click(function(e) {
						e.preventDefault();
						if (custom_uploader) {
							custom_uploader.open();
							return;
						}
						custom_uploader = wp.media.frames.file_frame = wp.media({
							title: "Choose File",
							button: { text: "'.__('Choose File', 'user-profile').'" },
							multiple: false
						});
						custom_uploader.on("select", function() {
							attachment = custom_uploader.state().get("selection").first().toJSON();
							jQuery("#file_'.$option_key.'").val(attachment.url);
							jQuery(".logo-preview img").attr("src",attachment.url);											
						});
						custom_uploader.open();
					});
					})
					</script>';					
				}
				$single_html_box.= '</div>';
			}
			
			
			// $html_box .= apply_filters( 'qa_filters_setting_box_'.$key , $single_html_box );
			$html_box .= $single_html_box;
			
			$html_box.= '</li>';
			
			$i++;
			}
			
			
			$html.= '<ul class="tab-nav">';
			$html.= $html_nav;			
			$html.= '</ul>';
			$html.= '<ul class="box">';
			$html.= $html_box;
			$html.= '</ul>';		
			
			
			
			$html.= '</div>';			
			return $html;
		}

}

new class_qa_settings_page();







if(empty($_POST['qa_hidden']))
	{


		$class_qa_settings_page = new class_qa_settings_page();
		
			$qa_settings_options = $class_qa_settings_page->qa_settings_options();
			
			foreach($qa_settings_options as $options_tab=>$options){
				
				foreach($options as $option_key=>$option_data){
					
					${$option_key} = get_option( $option_key );
		
					//var_dump(${$option_key});
					}
				}






	}
else
	{	
		if($_POST['qa_hidden'] == 'Y') {
			//Form data sent

	
			$class_qa_settings_page = new class_qa_settings_page();
			
			$qa_settings_options = $class_qa_settings_page->qa_settings_options();
			
			foreach($qa_settings_options as $options_tab=>$options){
				
				foreach($options as $option_key=>$option_data){

					if(!empty($_POST[$option_key])){
						${$option_key} = stripslashes_deep($_POST[$option_key]);
						update_option($option_key, ${$option_key});
						}
					else{
						${$option_key} = array();
						update_option($option_key, ${$option_key});
						
						}


					// var_dump($option_key);
					
					}
				}
	
	
	
	

			?>
			<div class="updated"><p><strong><?php _e('Changes Saved.', 'user-profile' ); ?></strong></p></div>
	
			<?php
			} 
	}
	
	

	
	
?>





<div class="wrap">

	<div id="icon-tools" class="icon32"><br></div><?php echo "<h2>".sprintf(__('%s Settings', 'user-profile'), USER_PROFILE_PLUGIN_NAME)."</h2>";?>
		<form  method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input type="hidden" name="qa_hidden" value="Y">
        <?php settings_fields( 'qa_plugin_options' );
				do_settings_sections( 'qa_plugin_options' );
			
			
	$class_qa_settings_page = new class_qa_settings_page();
    echo $class_qa_settings_page->qa_settings_options_form(); 
	
			
			
		?>

    






<p class="submit">
                    <input class="button button-primary" type="submit" name="submit" value="<?php _e('Save Changes','user-profile' ); ?>" />
                </p>
		</form>


</div>
