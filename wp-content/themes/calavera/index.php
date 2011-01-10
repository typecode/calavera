<?php
/**
 * index 
 *
 */

if (is_page(CALAVERA_NEWS)) {
	query_posts(array(
		"category_name" => CALAVERA_NEWS_CAT,
		"paged" => (get_query_var("paged")) ? get_query_var("paged") : 1,
		"posts_per_page" => 20
	));
}

get_header();
?>
	<script type="text/javascript">
		var ENVIRONMENT = {
			features: []
		};
		<?php if (is_page(CALAVERA_NEWS)): ?>
			ENVIRONMENT.features.push({
				feature:"infiniteScroll"
			});
		<?php endif; ?>
	</script>
		
	<?php include(TEMPLATEPATH . '/rail.php'); ?>
	
	<div class="main">
		<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
				<div class="box">
					<?php if (is_page(CALAVERA_NEWS) || !is_page()) : ?>
						<div class="hd">
							<h2><?php the_title(); ?></h2>
							<div class="meta">
								<cite><?php the_date("F j, Y"); ?></cite>
							</div>
						</div>
					<?php endif; ?>
					<div class="bd">
						<?php the_content(); ?>
					</div>
				</div>
			<?php endwhile; ?>
		<?php endif; ?>
	</div>
	
<?php 
	if (is_page(CALAVERA_NEWS)) {
		wp_reset_query();
	}
	get_footer(); 
?>