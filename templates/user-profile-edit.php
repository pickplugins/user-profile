<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

$thisuser = new user_profile_user_data( get_current_user_id() );


$profile_edit_tabs[] = array(
    'id'=>'basic_info',
    'title' => __('Basic Info', 'user-profile'),
    'details' => __('Some basic information about you.', 'user-profile'),
);

$profile_edit_tabs[] = array(
    'id'=>'contact',
    'title' => __('Contact', 'user-profile'),
    'details' => __('Some basic information about you.', 'user-profile'),
);

$profile_edit_tabs[] = array(
    'id'=>'works',
    'title' => __('Works', 'user-profile'),
    'details' => __('Some basic information about you.', 'user-profile'),
);

$profile_edit_tabs[] = array(
    'id'=>'education',
    'title' => __('Education', 'user-profile'),
    'details' => __('Some basic information about you.', 'user-profile'),
);

$profile_edit_tabs[] = array(
    'id'=>'places',
    'title' => __('Places', 'user-profile'),
    'details' => __('Some basic information about you.', 'user-profile'),
);


$profile_edit_tabs = apply_filters('user_profile_edit_tabs', $profile_edit_tabs);






?> 
<div class="user-profile-edit">







	<?php do_action('user_profile_action_user_profile_edit_before', $thisuser ); ?>	

	<?php
    if( is_user_logged_in() ) :
        ?>


        <div class="tabs">

            <ul>
                <?php

                $tab_count = 1;
                foreach ($profile_edit_tabs as $tab_index => $tab){

                    $title = $tab['title'];
                    ?>
                    <li><a href="#tabs-<?php echo $tab_count; ?>"><?php echo $title; ?></a></li>
                    <?php

                    $tab_count++;
                }

                ?>

            </ul>


            <?php
            $tab_count = 1;
            foreach ($profile_edit_tabs as $tab_index => $tab){

                $id = $tab['id'];
                ?>

                <div id="tabs-<?php echo $tab_count; ?>">
                    <?php
                    do_action('profile_edit_tabs_'.$id, $thisuser);
                    ?>

                </div>
                <?php

                $tab_count++;
            }

            ?>
        </div>



        <?php do_action('user_profile_action_user_profile_edit_after', $thisuser ); ?>

	<?php
    else :
        do_action('user_profile_action_user_profile_edit_loggout');
    endif; ?>


    
</div>






<script>
    jQuery(document).ready(function($){

        $( ".tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
        $( ".tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
    })

</script>

<style>
    .ui-tabs-vertical { width: 55em; }
    .ui-tabs-vertical .ui-tabs-nav { padding: .2em .1em .2em .2em; float: left; width: 12em; }
    .ui-tabs-vertical .ui-tabs-nav li { clear: left; width: 100%; border-bottom-width: 1px !important; border-right-width: 0 !important; margin: 0 -1px .2em 0; }
    .ui-tabs-vertical .ui-tabs-nav li a { display:block; }
    .ui-tabs-vertical .ui-tabs-nav li.ui-tabs-active { padding-bottom: 0; padding-right: .1em; border-right-width: 1px; }
    .ui-tabs-vertical .ui-tabs-panel { padding: 1em; float: right; width: 40em;}


    .ui-tabs-vertical{
        background: none;
        border: none;
    }
    .ui-tabs-vertical .ui-tabs-nav{
        background: none;
        border: none;
    }
    .ui-tabs-vertical .ui-tabs-nav li{
        background: #ddd;
        border: none;
        margin: 0;
        border-radius: 0;
    }
    .ui-tabs-vertical .ui-tabs-nav li.ui-tabs-active{
        padding: 0;
        background: #ccc;
    }
    .ui-tabs-vertical .ui-tabs-nav li a{
        padding: 6px 10px;
        font-size: 14px;
        color: #fff;
        display: block;
        outline: none;
    }

    .ui-tabs-vertical .ui-tabs-panel {
        padding: 1em;
        float: right;
        width: 40em;
        padding: 0 15px;
    }

</style>








