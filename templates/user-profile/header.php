<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 
	
$user_profile_cover		= sprintf( "<img src='%s' />", apply_filters('user_profile_filter_profile_cover', empty( $thisuser->user_profile_cover ) ? USER_PROFILE_PLUGIN_URL.'assets/front/images/cover.png' : $thisuser->user_profile_cover ) );

$user_profile_img       = get_the_author_meta( 'user_profile_img', $thisuser->ID );
$user_profile_img       = empty( $user_profile_img ) ? get_avatar_url($thisuser->ID, array('size'=>250)) : wp_get_attachment_url($user_profile_img);
$user_profile_img		= sprintf( "<img src='%s' />", apply_filters('user_profile_filter_user_avatar', $user_profile_img) );

$logged_in_user_id      = get_current_user_id();


// echo "<pre>"; print_r( $thisuser->user_profile_cover ); echo "</pre>";

?>

<div class="profile-header">

	<div class="cover">

		<?php if( get_current_user_id() == $thisuser->ID ) : ?>
		
		<div class="cover-upload">
                
        <?php
		$field_id = 'cover_img';
        $plupload_init = array(
            'runtimes'            => 'html5,silverlight,flash,html4',
            'browse_button'       => 'plupload-browse-'.$field_id.'',
            'drop_element'        => 'plupload-drag-drop'.$field_id.'',
            'file_data_name'      => 'async-upload',
            'multiple_queues'     => true,
            'max_file_size'       => wp_max_upload_size().'b',
            'url'                 => admin_url('admin-ajax.php'),
            'filters'             => array(array('title' => __('Allowed Files', 'user-profile'), 'extensions' => 'gif,png,jpg,jpeg')),
            'multipart'           => true,
            'urlstream_upload'    => true,
            'multipart_params'    => array(
                '_ajax_nonce' => wp_create_nonce('upload_cover_img'),
                'action'      => 'user_profile_upload_cover_img',            // the ajax action name
            ),
        );
        $plupload_init = apply_filters('plupload_init', $plupload_init);

		echo '<div id="plupload-drag-drop'.$field_id.'" ><span id="plupload-browse-'.$field_id.'" class="clipart-upload"><i class="icofont icofont-upload-alt"></i></span></div>';
        echo '<script>
		jQuery(document).ready(function($){
			var uploader_'.$field_id.' = new plupload.Uploader('.json_encode($plupload_init).');
            uploader_'.$field_id.'.bind("Init", function(up){
            var uploaddiv = $("#plupload-'.$field_id.'");
            if(up.features.dragdrop){
            	uploaddiv.addClass("drag-drop");
                $("#plupload-drag-drop'.$field_id.'")
                .bind("dragover.wp-uploader", function(){ uploaddiv.addClass("drag-over"); })
                .bind("dragleave.wp-uploader, drop.wp-uploader", function(){ uploaddiv.removeClass("drag-over"); });
        	}else{
            	uploaddiv.removeClass("drag-drop");
                $("#plupload-drag-drop'.$field_id.'").unbind(".wp-uploader");
            }
        });
		uploader_'.$field_id.'.init();
		uploader_'.$field_id.'.bind("FilesAdded", function(up, files){
			$(".toast").html("'.__('Please wait.', 'user-profile').'");
			$(".toast").stop().fadeIn(400);
			var hundredmb = 100 * 1024 * 1024, max = parseInt(up.settings.max_file_size, 10);
			plupload.each(files, function(file){
				if (max > hundredmb && file.size > hundredmb && up.runtime != "html5"){}else{}
        	});
            up.refresh();
            up.start();
        });
        uploader_'.$field_id.'.bind("FileUploaded", function(up, file, response) {
        	$(".toast").fadeOut(400);
			var result = $.parseJSON(response.response);
            var attach_url = result.html.attach_url;
            var attach_id = result.html.attach_id;
            var attach_title = result.html.attach_title;
        	var html_new = "<img src="+attach_url+" />";
            $(".cover-thumb").html(html_new);
        });
        });   
    	</script>';
        ?>

        </div>
   		<?php endif; ?>

        
    	<div class="cover-thumb">
            <div class="cover-thumb-overlay"></div>
       		<?php echo $user_profile_cover; ?>
        </div>
    	
    </div>

    <div class="thumb">

        <?php if( get_current_user_id() == $thisuser->ID ) : ?>

        <div class="thumb-upload">
                
        <?php
        $field_id = 'profile_img';
        $plupload_init = array(
            'runtimes'            => 'html5,silverlight,flash,html4',
            'browse_button'       => 'plupload-browse-'.$field_id.'',
            'drop_element'        => 'plupload-drag-drop'.$field_id.'',
            'file_data_name'      => 'async-upload',
            'multiple_queues'     => true,
            'max_file_size'       => wp_max_upload_size().'b',
            'url'                 => admin_url('admin-ajax.php'),
            'filters'             => array(array('title' => __('Allowed Files', 'user-profile'), 'extensions' => 'gif,png,jpg,jpeg')),
            'multipart'           => true,
            'urlstream_upload'    => true,
            'multipart_params'    => array(
                '_ajax_nonce' => wp_create_nonce('upload_profile_img'),
                'action'      => 'user_profile_upload_profile_img',            // the ajax action name
            ),
        );
        $plupload_init = apply_filters('plupload_init', $plupload_init);


        echo '<div id="plupload-drag-drop'.$field_id.'" ><span id="plupload-browse-'.$field_id.'" class="clipart-upload"><i class="icofont icofont-upload-alt"></i></span></div>';
        echo '<script>
        jQuery(document).ready(function($){
            var uploader_'.$field_id.' = new plupload.Uploader('.json_encode($plupload_init).');
            uploader_'.$field_id.'.bind("Init", function(up){
            var uploaddiv = $("#plupload-'.$field_id.'");
            if(up.features.dragdrop){
                uploaddiv.addClass("drag-drop");
                $("#plupload-drag-drop'.$field_id.'")
                .bind("dragover.wp-uploader", function(){ uploaddiv.addClass("drag-over"); })
                .bind("dragleave.wp-uploader, drop.wp-uploader", function(){ uploaddiv.removeClass("drag-over"); });
            }else{
                uploaddiv.removeClass("drag-drop");
                $("#plupload-drag-drop'.$field_id.'").unbind(".wp-uploader");
            }
        });
        uploader_'.$field_id.'.init();
        uploader_'.$field_id.'.bind("FilesAdded", function(up, files){
            $(".toast").html("'.__('Please wait.', 'user-profile').'");
            $(".toast").stop().fadeIn(400);
            var hundredmb = 100 * 1024 * 1024, max = parseInt(up.settings.max_file_size, 10);
            plupload.each(files, function(file){
                if (max > hundredmb && file.size > hundredmb && up.runtime != "html5"){}else{}
            });
            up.refresh();
            up.start();
        });
        uploader_'.$field_id.'.bind("FileUploaded", function(up, file, response) {
            $(".toast").fadeOut(400);
            var result = $.parseJSON(response.response);
            var attach_url = result.html.attach_url;
            var attach_id = result.html.attach_id;
            var attach_title = result.html.attach_title;
            var html_new = "<img src="+attach_url+" />";
            $(".profile-avatar").html(html_new);
        });
        });   
        </script>';
        ?>

        </div>
        <?php endif; ?>

        <div class="profile-avatar"><?php echo $user_profile_img; ?></div>

    </div>

    <div class='name'><?php echo apply_filters( 'user_profile_filter_user_name', $thisuser->display_name, $thisuser ) ?></div>

    <?php
    echo do_shortcode('[user_profile_follow_button]');
    ?>

</div>