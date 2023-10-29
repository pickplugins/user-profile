<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


$php_index = time();
global $userprofile;

// echo "<pre>"; print_r( $thisuser->get_works() ); echo "</pre>";
?>

<section class="works">
	
	<div class="section-title"><?php echo __('Works', 'user-profile'); ?></div>
    <div class="section-field">
        <div class="add-work button"><?php echo __('Add work', 'user-profile'); ?></div>
        <div class="items sortable">
            <?php foreach( $thisuser->get_works() as $index => $work ) : ?>
                <?php echo $userprofile->generate_html_work( $index, $work ); ?>
            <?php endforeach; ?>
        </div>

    </div>


</section>

<script>
jQuery(document).ready(function($){
	
	$(document).on('click', '.add-work', function(){

		data 		= "<?php echo $userprofile->generate_html_work( $php_index ); ?>";
		data 		= data.replace( /<?php echo $php_index; ?>/g, $.now() );
		
		$(data).appendTo( $(this).parent().find('.items') ).hide().fadeIn();
	})
	
	$(document).on('change', '.user_profile_checkbox', function(){

		if( $(this).is(":checked") ) $(this).parent().find('.end_date').prop('disabled', true);
        else $(this).parent().find('.end_date').prop('disabled', false);
	})
	
});
</script>