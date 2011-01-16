<?php
/**
 * news 
 *
 */
get_header();
?>
	<script type="text/javascript">
		var ENVIRONMENT = {
			features: [{ 
				feature: "infiniteScroll",
				options: {
					loadingImg: "<?php bloginfo('template_url'); ?>/images/loading.gif"
				}
			}]
		};
	</script>
		
	<?php include(TEMPLATEPATH . '/rail.php'); ?>
	
	<div class="main">
		<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
				<div class="box post">
					<div class="hd">
						<h2><?php the_title(); ?></h2>
						<div class="meta">
							<cite><?php the_date("F j, Y"); ?></cite>
						</div>
					</div>
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