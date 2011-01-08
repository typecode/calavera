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
		<?php if (is_page(CALAVERA_NEWS)): ?>
			ENVIRONMENT.features.push({
				feature:"infiniteScroll"
			});
			
		<?php endif; ?>
		ENVIRONMENT.features.push({feature:"videos"});
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
		<?php get_footer(); ?>