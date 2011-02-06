<?php
/**
 * index 
 *
 */

get_header();
?>
	<script type="text/javascript">
		var ENVIRONMENT = {
			features: []
		};
	</script>
		
	<?php include(TEMPLATEPATH . '/rail.php'); ?>
	
	<div class="main">
		<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
				<div class="box">
					<div class="bd">
						<?php the_content(); ?>
					</div>
				</div>
			<?php endwhile; ?>
			<div class="box pagination">
				<span class="prev"><?php previous_posts_link('<span class="arr">&larr;</span>  Previous'); ?></span>
				<span class="next"><?php next_posts_link('Next <span class="arr">&rarr;</span>'); ?></span>
			</div>
		<?php endif; ?>
	</div>
	
<?php get_footer(); ?>