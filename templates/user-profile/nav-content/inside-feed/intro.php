<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

$user_profile_Functions = new User_profile_functions();
$relationships 		    = $user_profile_Functions->user_relationship();



?>

<div class="side-section">
    <div class="section-title">
        <?php echo apply_filters( 
            'user_profile_filter_feed_intro_header', 
            sprintf( "<i class='icofont icofont-info-square'></i> %s", __( 'Intro', 'user-profile' ) ), 
            $user_id ); 
        ?>
    </div>
    <div class="section-content intro">
    
    <?php foreach( $thisuser->get_educations() as $key => $education ) : 

        $item_education = sprintf( __( "Studied %s at %s from %s to %s", "user-profile" ), 
            sprintf( "<span class='highlight'>%s</span>", isset( $education['degree'] ) ? $education['degree'] : '-' ),
            sprintf( "<span class='highlight'>%s</span>", isset( $education['school'] ) ? $education['school'] : '-' ),
            sprintf( "<span class=''>%s</span>", isset( $education['start_date'] ) ? date("M Y", strtotime( $education['start_date'] )) : '-' ),
            sprintf( "<span class=''>%s</span>", isset( $education['end_date'] ) ? date("M Y", strtotime( $education['end_date'] )) : '-' )
        );
        echo apply_filters( 'user_profile_filter_education_item', 
            sprintf( "<div class='item'><span class='icon'><i class='icofont icofont-education'></i> %s</span></div>", $item_education ), $key, $user_id 
        );
        
    endforeach; ?>
   
    <?php foreach( $thisuser->get_works() as $key => $work ) : 

        if( isset( $work['running'] ) && $work['running'] == 'yes' ) {

            $item_work = sprintf( __( "Working at %s as %s from %s", "user-profile" ), 
                sprintf( "<span class='highlight'>%s</span>", isset( $work['company'] ) ? $work['company'] : '-' ),
                sprintf( "<span class='highlight'>%s</span>", isset( $work['position'] ) ? $work['position'] : '-' ),
                sprintf( "<span class=''>%s</span>", isset( $work['start_date'] ) ? date("M Y", strtotime( $work['start_date'] )) : '-' )
            );
        }
        else {

            $item_work = sprintf( __( "Worked at %s as %s from %s to %s", "user-profile" ), 
                sprintf( "<span class='highlight'>%s</span>", isset( $work['company'] ) ? $work['company'] : '-' ),
                sprintf( "<span class='highlight'>%s</span>", isset( $work['position'] ) ? $work['position'] : '-' ),
                sprintf( "<span class=''>%s</span>", isset( $work['start_date'] ) ? date("M Y", strtotime( $work['start_date'] )) : '-' ),
                sprintf( "<span class=''>%s</span>", isset( $work['end_date'] ) ? date("M Y", strtotime( $work['end_date'] )) : '-' )
            );
        }
        
        echo apply_filters( 'user_profile_filter_work_item', 
            sprintf( "<div class='item'><span class='icon'><i class='icofont icofont-education'></i> %s</span></div>", $item_work ), $key, $user_id 
        );
        
    endforeach; ?>

    <?php foreach( $thisuser->get_places() as $key => $place ) : 

        $item_place = sprintf( __( "Visited %s, %s", "user-profile" ), 
            sprintf( "<span class=''>%s</span>", isset( $place['address'] ) ? $place['address'] : '-' ),
            sprintf( "<span class=''>%s</span>", isset( $place['location'] ) ? $place['location'] : '-' )
        );
        
        echo apply_filters( 'user_profile_filter_place_item', 
            sprintf( "<div class='item'><span class='icon'><i class='icofont icofont-location-pin'></i> %s</span></div>", $item_place ), $key, $user_id 
        );
        
    endforeach; ?>

    <?php echo apply_filters( 'user_profile_filter_relationship_item', 
        sprintf( "<div class='item'><span class='icon'><i class='icofont icofont-heart'></i> %s</span></div>", 
        isset( $relationships[ $thisuser->relationship ]['title'] ) ? $relationships[ $thisuser->relationship ]['title'] : '-' ), $user_id 
    ); ?>

    </div>
</div>
