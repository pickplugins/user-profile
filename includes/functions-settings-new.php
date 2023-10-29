<?php
/*
* @Author 		pickplugins
* Copyright: 	pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

global $userprofile;

$user_profile_pages = array(

    'page_nav' 	=> __( 'Pages', 'user-profile' ),
    'priority' => 10,
	'page_settings' => array(
		
		'section_general' => array(
			'title' 	=> 	__('General','user-profile'),
			'description' 	=> __('Select all pages from here','user-profile'),
			'options' 	=> array(
				array(
					'id'		=> 'user_profile_page_id',
					'title'		=> __('Profile Display Page','user-profile'),
					'details'	=> __('Select a page where the user profile will display, please use following shortcode <code>[user_profile]</code>','user-profile'),
					'type'		=> 'select2',
					'args'		=> 'PICK_PAGES_ARRAY',
				),
				array(
					'id'		=> 'user_profile_edit_page_id',
					'title'		=> __('Profile Edit Page','user-profile'),
					'details'	=> __('Select a page where the user can edit profile, please use following shortcode <code>[user_profile_edit]</code>','user-profile'),
					'type'		=> 'select2',
					'args'		=> 'PICK_PAGES_ARRAY',
				),
				
			)
		),
		
	),
);

$user_profile_options = array(

    'page_nav' 	=> __( 'Options', 'user-profile' ),
    'priority' => 15,
	'page_settings' => array(
		
		'section_templates' => array(
			'title' 	=> 	__('Templates','user-profile'),
			'description' 	=> __('Select display templates from here','user-profile'),
			'options' 	=> array(
				array(
					'id'		=> 'user_profile_display_template',
					'title'		=> __('User display template','user-profile'),
					'details'	=> __('Select how you want to display the single user item','user-profile'),
					'type'		=> 'select',
					'args'		=> $userprofile->get_user_templates( true ),
				),
				
			)
		),
		
	),
);






$user_profile_help = array(

    'page_nav' 	=> __( 'Help', 'user-profile' ),
    'priority' => 30,
    'show_submit' => false,
	'page_settings' => array(
		
		'section_general' => array(
			'options' 	=> array(
				array(
					'id'		=> 'changelog',
					'title'		=> __('Huge change, Right ?','user-profile'),
					'details'	=> 'Yes! we have changed huge feature for latest version, plugin is re-written and added more functinality to make your site user profile gives more social feel and look.
                    
                    
                    
                    <h3>Step 1</h3>
                    <p>Create new page for user profile and paste the following shortcdoe inside page content <pre>[user_profile]</pre> and go to settigns page and set <strong>User profile page</strong>, select that page you just created.
                    </p>
                    
                     <h3>Step 2</h3>
                    <p>Create new page for user profile edit and paste the following shortcdoe inside page content <pre>[user_profile_edit]</pre> and go to settigns page and set <strong>User profile edit page</strong>, select that page you just created.                   
                    
                    </p>
                    
                    
                     <h3>Step 3</h3>
                    <p>After creating pages you can visit to see user profile and profile edit form, and you are done.',
				),
				array(
					'id'		=> 'documentation',
					'title'		=> __('Documentation','user-profile'),
                    'details'	=> 'We are updating our documentation for this plugins, pelase check and learn more things we added. <br>
                    <a href="http://pickplugins.com/docs/documentation/user-profile/">http://pickplugins.com/docs/documentation/user-profile/</a>'
				),
				
				array(
					'id'		=> 'Demo',
					'title'		=> __('Demo','user-profile'),
                    'details'	=> 'Please see the live demo on our server <br>
                    <a href="http://www.pickplugins.com/demo/user-profile/?id=48">http://www.pickplugins.com/demo/user-profile/?id=48</a>'
				),
				
				array(
					'id'		=> 'older_version',
					'title'		=> __('Need older version?','user-profile'),
                    'details'	=> 'We are updating our plugin to make more useful. if you like to use older version please go following link and download older verison <br>
                    <a href="https://wordpress.org/plugins/user-profile/developers/">https://wordpress.org/plugins/user-profile/developers/</a>'
				),
				
			)
		),
		
	),
);

$args = array(
	'add_in_menu'       => true,
	'menu_type'         => 'main',
	'menu_title'        => __( 'User Profile', 'user-profile' ),
	'page_title'        => __( 'User Profile', 'user-profile' ),
	'menu_page_title'   => __( 'User Profile Settings', 'user-profile' ),
	'capability'        => "manage_options",
	'menu_slug'         => "user-profile",
    'menu_icon'         => "dashicons-businessman",
    'pages' 	        => array(
		'user_profile_pages'    => $user_profile_pages,
		'user_profile_options'  => $user_profile_options,

	),
);

$userProfile_AdminMenu = new userProfile_AdminMenu( $args );













$user_profile_addons = array(

    'page_nav' 	=> __( 'Addons', 'user-profile' ),
    'priority' => 15,
    'page_settings' => array(

        'section_templates' => array(
            'title' 	=> 	__('Ready Addons','user-profile'),
            'description' 	=> __('We have created some ready addons for your project.','user-profile'),
            'options' 	=> array(
                array(
                    'id'		=> 'user_profile_addons',
                    'title'		=> __('Addons list','user-profile'),
                    'details'	=> __('Some ready addons may help your project boosted.','user-profile'),
                    'type'		=> 'addons_grid',
                    'args'		=> array(
                        array(
                            'title'=> 'Online users',
                            'link'=> 'https://wordpress.org/plugins/user-profile-online-users/',
                            'content'=>'',
                            'thumb'=> USER_PROFILE_PLUGIN_URL.'assets/images/addons/online-users.png',
                        ),

                        array(
                            'title'=> 'Verified users',
                            'link'=> 'https://www.pickplugins.com/item/user-profile-verified-users/',
                            'content'=>'',
                            'thumb'=> USER_PROFILE_PLUGIN_URL.'assets/images/addons/verified-users.png',
                        ),

                        array(
                            'title'=> 'User directory',
                            'link'=> 'https://www.pickplugins.com/item/user-profile-user-directory/',
                            'content'=>'',
                            'thumb'=> USER_PROFILE_PLUGIN_URL.'assets/images/addons/user-directory.png',
                        ),




                    ),
                ),

            )
        ),

    ),
);




$args = array(
    'add_in_menu'       => true,
    'menu_type'         => 'submenu',
    'menu_title'        => __( 'Addons', 'user-profile' ),
    'page_title'        => __( 'User Profile - Addons', 'user-profile' ),
    'menu_page_title'   => __( 'User Profile - Addons', 'user-profile' ),
    'capability'        => "manage_options",
    'menu_slug'         => "user_profile_addons",
    'parent_slug'       => "user-profile",
    'menu_icon'         => "dashicons-businessman",
    'pages' 	        => array(
        'user_profile_addons'   => $user_profile_addons,

    ),
);

$userProfile_AdminMenu = new userProfile_AdminMenu( $args );





$args = array(
    'add_in_menu'       => true,
    'menu_type'         => 'submenu',
    'menu_title'        => __( 'Help', 'user-profile' ),
    'page_title'        => __( 'User Profile - Help', 'user-profile' ),
    'menu_page_title'   => __( 'User Profile - Help', 'user-profile' ),
    'capability'        => "manage_options",
    'menu_slug'         => "user-profile-help",
    'parent_slug'       => "user-profile",
    'menu_icon'         => "dashicons-businessman",
    'pages' 	        => array(
        'user_profile_help'     => $user_profile_help,

    ),
);

$userProfile_AdminMenu = new userProfile_AdminMenu( $args );










$user_profile_welcome_settings = array(

    'page_nav' 	=> __( 'Welcome', 'user-profile' ),
    'priority' => 15,
    'page_settings' => array(

        'section_templates' => array(
            'title' 	=> 	__('Ready Addons','user-profile'),
            'description' 	=> __('We have created some ready addons for your project.','user-profile'),
            'options' 	=> array(
                array(
                    'id'		=> 'user_profile_addons',
                    'title'		=> __('Addons list','user-profile'),
                    'details'	=> __('Some ready addons may help your project boosted.','user-profile'),


                ),

            )
        ),

    ),
);




$args = array(
    'add_in_menu'       => true,
    'menu_type'         => 'submenu',
    'menu_title'        => __( 'Welcome', 'user-profile' ),
    'page_title'        => __( 'User Profile - Welcome', 'user-profile' ),
    'menu_page_title'   => __( 'User Profile - Welcome', 'user-profile' ),
    'capability'        => "manage_options",
    'menu_slug'         => "user_profile_welcome",
    'parent_slug'       => "user-profile",
    'menu_icon'         => "dashicons-businessman",
    'pages' 	        => array(
        'user_profile_welcome'   => $user_profile_welcome_settings,

    ),
);

//$userProfile_AdminMenu = new userProfile_AdminMenu( $args );












