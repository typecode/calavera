<?php
/**
 * index 
 *
 */
get_header();
?>

	<body>
		<div class="wrap">
			<div class="rail">
				<div class="hd">
					<h1 class="logo graphic"><a href="<?php bloginfo('url'); ?>">
						<span><?php bloginfo("title"); ?></span>
					</a></h1>
				</div>
				<div class="bd">
					<ul id="menu" class="menu">
						<li><a href="">News</a></li>
						<li><a href="">Contact</a></li>
						<li><a href="">Info</a></li>
						<li><a href="">Features</a></li>
						<li>
							<a href="">Shorts</a>
							<ul>
								<li>
									<a href="">Darkmatter</a>
								</li>
								<li>
									<a href="">Death and the Blue-Eyed Boy</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="">Music Videos</a>
							<ul>
								<li>
									<a href="">Darkmatter</a>
								</li>
								<li>
									<a href="">Death and the Blue-Eyed Boy</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="">Commercials</a>
							<ul>
								<li>
									<a href="">Darkmatter</a>
								</li>
								<li>
									<a href="">Death and the Blue-Eyed Boy</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
			<div class="main">
				<div class="box">
					<div class="hd">
						<h2>Death and the Blue-Eyed Boy</h2>
						<div class="meta">
							<cite>Director: Grant Curatola, Producer: Brett Potter</cite>
						</div>
					</div>
					<div class="bd">
						
					</div>
				</div>
				<div class="pagination">
					<div class="controls graphic">
						<a class="prev" href="">
							<span>Up</span>
						</a>
						<a class="next" href="">
							<span>Down</span>
						</a>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/calavera.js"></script>
		<script type="text/javascript">
			(function(app, $) {

				$(function() {
					app.log("document[ready]");
					
					app.instances.menu = app.menu("#menu");
					
				});

			}(CALAVERA, jQuery));
		</script>
	</body>
</html>
