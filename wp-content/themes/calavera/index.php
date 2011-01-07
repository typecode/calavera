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
						
						<!-- Begin VideoJS -->
						  <div class="video-js-box calavera-player">
						    <!-- Using the Video for Everybody Embed Code http://camendesign.com/code/video_for_everybody -->
						    <video class="video-js" width="640" height="264" controls preload poster="http://video-js.zencoder.com/oceans-clip.png">
						      <source src="http://video-js.zencoder.com/oceans-clip.mp4" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"' />
						      <source src="http://video-js.zencoder.com/oceans-clip.webm" type='video/webm; codecs="vp8, vorbis"' />
						      <source src="http://video-js.zencoder.com/oceans-clip.ogv" type='video/ogg; codecs="theora, vorbis"' />
						      <!-- Flash Fallback. Use any flash video player here. Make sure to keep the vjs-flash-fallback class. -->
						      <object class="vjs-flash-fallback" width="640" height="264" type="application/x-shockwave-flash"
						        data="http://releases.flowplayer.org/swf/flowplayer-3.2.1.swf">
						        <param name="movie" value="http://releases.flowplayer.org/swf/flowplayer-3.2.1.swf" />
						        <param name="allowfullscreen" value="true" />
						        <param name="flashvars" value='config={"playlist":["http://video-js.zencoder.com/oceans-clip.png", {"url": "http://video-js.zencoder.com/oceans-clip.mp4","autoPlay":false,"autoBuffering":true}]}' />
						        <!-- Image Fallback. Typically the same as the poster image. -->
						        <img src="http://video-js.zencoder.com/oceans-clip.png" width="640" height="264" alt="Poster Image"
						          title="No video playback capabilities." />
						      </object>
						    </video>
						  </div>
						  <!-- End VideoJS -->
						
						
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
		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/video-js/video.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/calavera.js"></script>
		<script type="text/javascript">
			(function(app, $) {
				
				

				$(function() {
					app.log("document[ready]");
					
					app.instances.menu = app.menuSetup("#menu");
					
					app.instances.videos = app.videoSetup();
					
				});

			}(CALAVERA, jQuery));
		</script>
	</body>
</html>
