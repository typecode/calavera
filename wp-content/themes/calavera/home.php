<?php
/**
 * home 
 *
 */

get_header();
?>
	<script type="text/javascript">
		var ENVIRONMENT = {
			features: [{ 
				feature:"videos"
			}, { 
				feature:"scrollPane",
				options:{
					selector:".scroll-pane"
				} 
			}]
		};
	</script>

	<?php include(TEMPLATEPATH . '/rail.php'); ?>
	
	<div class="main">
		<div id="scroll-pane" class="scroll-pane">
			<div class="holder">
				<?php calavera_videos_main(); ?>
			</div>
			<div class="scroll-controls">
				<div class="graphic">
					<a class="prev" href="">
						<span>Up</span>
					</a>
					<a class="next" href="">
						<span>Down</span>
					</a>
				</div>
			</div>
		</div>
		<div class="footer">
			<cite>&copy;2011 Calavera</cite>
		</div>
	</div>
	
<?php get_footer(); ?>
