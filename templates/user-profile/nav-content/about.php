<?php
/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

global $userprofile;

$contact_methods	= $userprofile->contact_methods();
$_gender 			= $userprofile->user_gender();		
$_relationship 		= $userprofile->user_relationship();

$gender				= isset( $_gender[$thisuser->gender]['title'] ) ? $_gender[$thisuser->gender]['title'] : "";
$gender_icon		= isset( $_gender[$thisuser->gender]['icon'] ) ? $_gender[$thisuser->gender]['icon'] : "";
$relationship		= isset( $_relationship[$thisuser->relationship]['title'] ) ? $_relationship[$thisuser->relationship]['title'] : "";

?>

<div class="basic-info">
	
	<div class="up-container">
		
		<h5><?php echo __('Basic Info', 'user-profile'); ?></h5>
                
        <?php do_action('user_profile_action_before_basic_info'); ?>
                
		<div class="item gender">
			<span><?php echo __('Gender', 'user-profile'); ?></span><span> : </span>
			<span><?php echo $gender_icon .' '. $gender; ?></span>
		</div> 
        
		<div class="item relationship">
			<span><?php echo __('Relationship', 'user-profile'); ?> </span><span> : </span>
			<span><?php echo $relationship; ?></span>
		</div>            

		<div class="item religious">
			<span><?php echo __('Religious', 'user-profile'); ?> </span><span> : </span>
			<span><?php echo $thisuser->religious; ?></span>
		</div>

		<div class="item birth_date">
			<span><?php echo __('Birth date', 'user-profile'); ?> </span><span> : </span>
			<span><?php echo date( "F j, Y", strtotime( $thisuser->date_of_birth ) ); ?> </span>
		</div>

		<div class="item website">
			<span><?php echo __('Website', 'user-profile'); ?> </span><span> : </span>
			<span><a href="<?php echo $thisuser->user_url; ?>"><?php echo $thisuser->user_url; ?></a></span>
		</div>            
        
		<?php do_action('user_profile_action_after_basic_info'); ?>
            
	</div>

	<div class="up-container">
        
		<h5><?php echo __('Contacts', 'user-profile'); ?></h5>
		<div class="contact-list">
		<?php foreach( $thisuser->get_contacts() as $contact ) : if( ! array_key_exists( $contact['network'], $contact_methods ) ) continue; ?>

			<?php echo apply_filters( 'user_profile_filter_contact_item', 
			sprintf( "<a style='background-color:%s' class='item %s hint--top' aria-label='%s' href='%s'>%s</a>", 
				isset( $contact_methods[ $contact['network'] ]['bg_color'] ) ? $contact_methods[ $contact['network'] ]['bg_color'] : '',
				isset( $contact['network'] ) ? $contact['network'] : '',
				isset( $contact_methods[ $contact['network'] ]['title'] ) ? $contact_methods[ $contact['network'] ]['title'] : '',
				isset( $contact['profile_link'] ) ? $contact['profile_link'] : '',
				isset( $contact_methods[ $contact['network'] ]['icon'] ) ? $contact_methods[ $contact['network'] ]['icon'] : ''
			), $contact, $thisuser ); ?>

		<?php endforeach; ?>
        </div>
	</div>

</div>
      
<div class="other-info">
	
	<div class="up-container">
            
        <div class="info-box education">
			
			<h4><?php echo __('Education', 'user-profile'); ?></h4>
				
			<?php foreach( $thisuser->get_educations() as $key => $education ) : 

			$item_education = sprintf( __( "Studied %s at %s from %s to %s", "user-profile" ), 
				sprintf( "<span class='degree'>%s</span>", isset( $education['degree'] ) ? $education['degree'] : '-' ),
				sprintf( "<span class='school'>%s</span>", isset( $education['school'] ) ? $education['school'] : '-' ),
				sprintf( "<span class='date'>%s</span>", isset( $education['start_date'] ) ? date("M Y", strtotime( $education['start_date'] )) : '-' ),
				sprintf( "<span class='date'>%s</span>", isset( $education['end_date'] ) ? date("M Y", strtotime( $education['end_date'] )) : '-' )
			);
			
			echo apply_filters( 'user_profile_filter_education_item', 
				sprintf( "<div class='item'><span class='icon'><i class='icofont icofont-education'></i> %s</span></div>", $item_education ), $key, $user_id 
			);

			endforeach; ?>

        </div>            
            
        <div class="info-box">
			
			<h4><?php echo __('Work', 'user-profile'); ?></h4>
			<?php foreach( $thisuser->get_works() as $key => $work ) : 

				if( isset( $work['running'] ) && $work['running'] == 'yes' ) {

					$item_work = sprintf( __( "Working at %s as %s from %s", "user-profile" ), 
						sprintf( "<span class='company'>%s</span>", isset( $work['company'] ) ? $work['company'] : '-' ),
						sprintf( "<span class='position'>%s</span>", isset( $work['position'] ) ? $work['position'] : '-' ),
						sprintf( "<span class=''>%s</span>", isset( $work['start_date'] ) ? date("M Y", strtotime( $work['start_date'] )) : '-' )
					);
				}
				else {

					$item_work = sprintf( __( "Worked at %s as %s from %s to %s", "user-profile" ), 
						sprintf( "<span class='company'>%s</span>", isset( $work['company'] ) ? $work['company'] : '-' ),
						sprintf( "<span class='position'>%s</span>", isset( $work['position'] ) ? $work['position'] : '-' ),
						sprintf( "<span class=''>%s</span>", isset( $work['start_date'] ) ? date("M Y", strtotime( $work['start_date'] )) : '-' ),
						sprintf( "<span class=''>%s</span>", isset( $work['end_date'] ) ? date("M Y", strtotime( $work['end_date'] )) : '-' )
					);
				}

				echo apply_filters( 'user_profile_filter_work_item', 
					sprintf( "<div class='item'><span class='icon'><i class='icofont icofont-briefcase'></i> %s</span></div>", $item_work ), $key, $user_id 
				);

			endforeach; ?>
		</div> 
            
        <div class="info-box">
			
			<h4><?php echo __('Places', 'user-profile'); ?></h4>
			<?php foreach( $thisuser->get_places() as $key => $place ) : 

				$item_place = sprintf( __( "Visited %s, %s", "user-profile" ), 
					sprintf( "<span class=''>%s</span>", isset( $place['address'] ) ? $place['address'] : '-' ),
					sprintf( "<span class=''>%s</span>", isset( $place['location'] ) ? $place['location'] : '-' )
				);

				echo apply_filters( 'user_profile_filter_place_item', 
					sprintf( "<div class='item'><span class='icon'><i class='icofont icofont-location-pin'></i> %s</span></div>", $item_place ), $key, $user_id 
				);

			endforeach; ?>
    	</div>             
            
        <?php do_action( 'user_profile_filter_profile_about', $thisuser ); ?>
            
    </div>

</div>