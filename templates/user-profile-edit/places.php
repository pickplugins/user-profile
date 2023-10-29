<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


$php_index = time();
global $userprofile;

// echo "<pre>"; print_r( $thisuser->get_places() ); echo "</pre>";
?>

<section class="places">
	
	<div class="section-title"><?php echo __('Places', 'user-profile'); ?></div>

    <div class="section-field">
        <div class="add-place button"><?php echo __('Add Place', 'user-profile'); ?></div>

        <div class="items sortable">
            <?php foreach( $thisuser->get_places() as $index => $work ) : ?>
                <?php echo $userprofile->generate_html_place( $index, $work ); ?>
            <?php endforeach; ?>
        </div>
    </div>


</section>

<script>
jQuery(document).ready(function($){
	
	$(document).on('click', '.add-place', function(){

		data 		= "<?php echo $userprofile->generate_html_place( $php_index ); ?>";
		data 		= data.replace( /<?php echo $php_index; ?>/g, $.now() );
		
		$(data).appendTo( $(this).parent().find('.items') ).hide().fadeIn();
	})
	
});
</script>