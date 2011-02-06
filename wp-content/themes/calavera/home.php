<?php
/**
 * home 
 *
 */

get_header();

$moreText = "Read more";
global $news_id;

?>
	<script type="text/javascript">
		var ENVIRONMENT = {
			features: [{ 
				feature: "infiniteScroll",
				options: {
					loadingImg: "<?php bloginfo('template_url'); ?>/images/loading.gif"
				}
			}, { 
				feature: "blogPosts",
				options: {
					moreText: "<?php echo $moreText; ?>",
					lessText: "Read less"
				}
			}]
		};
	</script>
		
	<?php include(TEMPLATEPATH . '/rail.php'); ?>
	
	<?php
		query_posts(array(
			"paged" => (get_query_var("paged")) ? get_query_var("paged") : 1,
			"cat" => $news_id
		));
	?>
	
	<div class="main">
		<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
				<div class="box post">
					<div class="hd">
						<h2><?php the_title(); ?></h2>
						<div class="meta">
							<cite><?php the_time( get_option("date_format") ); ?></cite>
						</div>
					</div>
					<div class="bd">
						<?php
							if (strpos($post->post_content, "<!--more-->")) {
								global $more;
								
								$more = 0;
								echo '<div class="part-1">';
								the_content("");
								echo "</div>";
								
								echo "<p class='more-link-holder'>";
								echo "<a class='more-link' href='#'>" . $moreText . "</a>";
								echo "</p>";
								
								$more = 1;
								echo '<div class="part-2">';
								the_content("", TRUE, "");
								echo "</div>";
							} else {
								the_content();
							}
						?>
					</div>
				</div>
			<?php endwhile; ?>
			<div class="box pagination">
				<span class="prev"><?php previous_posts_link('<span class="arr">&larr;</span>  Previous'); ?></span>
				<span class="next"><?php next_posts_link('Next <span class="arr">&rarr;</span>'); ?></span>
			</div>
		<?php endif; ?>
	</div>
	
<?php 
wp_reset_query();
get_footer();
?>