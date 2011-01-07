<?php
/**
 * footer 
 * 
 */
?>
	</div>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/video-js/video.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/calavera.js"></script>
	<script type="text/javascript">
		(function(app, $) {
			
			$(function() {
				app.log("document[ready]");

				app.instances.menu = app.menu("#menu");
				
				if (typeof ENVIRONMENT === "object") {
					if (typeof ENVIRONMENT.features === "object") {
						$.each(ENVIRONMENT.features, function(i) {
							if ($.isFunction(app[ENVIRONMENT.features[i].feature])) {
								app.instances[i] = 
									app[ENVIRONMENT.features[i].feature](ENVIRONMENT.features[i].options || null);
							}
						});
					}
				}
			});

		}(CALAVERA, jQuery));
	</script>
	<?php wp_footer(); ?>
</body>
</html>