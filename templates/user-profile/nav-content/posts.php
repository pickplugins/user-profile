<?php
/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

$posts_per_page = get_option('posts_per_page');
$posts_per_page = empty( $posts_per_page ) ? 10 : $posts_per_page;
$paged 			= get_query_var('page') ? get_query_var('page') : 1;

$thisuser_posts_query = $thisuser->get_posts( 
	array( 
		'posts_per_page' => $posts_per_page,
		'paged' => $paged,
	), true
);
	
?>

<div class="user-posts">
		
	<?php if ( $thisuser_posts_query->have_posts() ) : while ( $thisuser_posts_query->have_posts() ) : $thisuser_posts_query->the_post(); ?>
			
	<div class="single">
        <div class="title"><a href="<?php echo get_permalink(); ?>"><?php echo the_title(); ?></a></div>
        <div class="excerpt"><?php echo get_the_excerpt(); ?></div>
        <div class="date"><?php echo the_date(); ?></div>                
    </div>
	
	<?php endwhile; ?>
		
    <?php $paginate_links = paginate_links( array(
		'base' => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
		'format' => '?paged=%#%',
		'current' => max( 1, $paged ),
		'total' => $thisuser_posts_query->max_num_pages
	) );

	printf( "<div class='paginate'>%s</div>", $paginate_links ); ?>

	<?php wp_reset_query(); ?>
	
	<?php else : ?> <i class="icofont icofont-warning-alt"></i> <?php echo __('No post found.'); ?>
	
	<?php endif; ?>
		
</div>