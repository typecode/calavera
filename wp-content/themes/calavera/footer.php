<?php
/**
 * footer 
 * 
 */
?>
	</div>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/includes/video-js/video.js"></script>
	<?php global $news_id; if (is_category($news_id)): ?>
		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/includes/infinite-scroll/jquery.infinitescroll.min.js"></script>
	<?php endif; ?>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/calavera.js"></script>
	<?php wp_footer(); ?>
</body>
</html>