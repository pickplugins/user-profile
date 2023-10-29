<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

$php_index = time();
global $userprofile;
?>

<section class="contacts">
	
	<div class="section-title"><?php echo __('Contacts', 'user-profile'); ?></div>



    <div class="section-field">
        <div class="add-contacts button"><?php echo __('Add contact', 'user-profile'); ?></div>
        <div class="items sortable">
            <?php foreach( $thisuser->get_contacts() as $index => $work ) : ?>
                <?php echo $userprofile->generate_html_contact( $index, $work ); ?>
            <?php endforeach; ?>
        </div>

    </div>



</section>

<script>
jQuery(document).ready(function($){
	
	$(document).on('click', '.add-contacts', function(){

		data 		= "<?php echo $userprofile->generate_html_contact( $php_index ); ?>";
		data 		= data.replace( /<?php echo $php_index; ?>/g, $.now() );
		
		console.log( data );

		$(data).appendTo( $(this).parent().find('.items') ).hide().fadeIn();
	})
});
</script>
