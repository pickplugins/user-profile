<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

$php_index = time();
global $userprofile;

?>

<section class="educations">
	
	<div class="section-title"><?php echo __('Educations', 'user-profile'); ?></div>
    <div class="section-field">

        <div class="add-education button"><?php echo __('Add Education', 'user-profile'); ?></div>

        <div class="items sortable">
            <?php foreach( $thisuser->get_educations() as $index => $work ) : ?>
                <?php echo $userprofile->generate_html_education( $index, $work ); ?>
            <?php endforeach; ?>
        </div>
    </div>


</section>

<script>
jQuery(document).ready(function($){
	
	$(document).on('click', '.add-education', function(){

		data 		= "<?php echo $userprofile->generate_html_education( $php_index ); ?>";
		data 		= data.replace( /<?php echo $php_index; ?>/g, $.now() );
		
		$(data).appendTo( $(this).parent().find('.items') ).hide().fadeIn();
	})
	
});
</script>