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
		<?php endif; ?>
	</div>
	
<?php get_footer(); ?>