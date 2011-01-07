<?php
/**
 * home 
 *
 */
get_header();
?>
	<script type="text/javascript">
		var ENVIRONMENT = {
			features: [{ feature:"videos"}, { feature:"scrollPane" }]
		};
	</script>

			<div class="rail">
				<div class="hd">
					<h1 class="logo graphic"><a href="<?php bloginfo('url'); ?>">
						<span><?php bloginfo("title"); ?></span>
					</a></h1>
				</div>
				<div class="bd">
					<ul id="menu" class="menu">
						<?php wp_list_pages("title_li="); ?>
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
		<?php get_footer(); ?>
