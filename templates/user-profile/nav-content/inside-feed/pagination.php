<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


if( $this->paged >= $this->feed_query->max_num_pages ) return;

?>

<div 
    class="button btn feed-load-more" 
    data-paged="<?php echo $this->paged; ?>" 
    data-postsperpage="<?php echo $this->posts_per_page; ?>" 
    data-feedforuser="<?php echo $this->feed_for_user; ?>"
    >
    <?php echo __( "Load more", "user-profile" ); ?>
</div>

