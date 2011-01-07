<?php
/**
 * functions
 *
 */

/* Constant used to identify the "news" page */
define("CALAVERA_NEWS", "news");

/*----- Utils -----*/
require_once(TEMPLATEPATH . '/utils/context.php');
require_once(TEMPLATEPATH . '/utils/filters.php');

/*----- Video JS -----*/
/*
	from VideoJS Wordpresss Plugin by Steve Heffernan
	http://videojs.com/ */

function video_shortcode($atts) {
	extract(shortcode_atts(array(
		'mp4' => '',
		'webm' => '',
		'ogg' => '',
		'poster' => '',
		'width' => '',
		'height' => '',
		'preload' => false, 
		'autoplay' => false
	), $atts));
	
	if ($mp4) { 
		$mp4_source = '<source src="'.$mp4.'" type=\'video/mp4; codecs="avc1.42E01E, mp4a.40.2"\' />'; 
		$mp4_link = '<a href="'.$mp4.'">MP4</a>';
	}
	
	if ($webm) {
		$webm_source = '<source src="'.$webm.'" type=\'video/webm; codecs="vp8, vorbis"\' />'; 
		$webm_link = '<a href="'.$webm.'">WebM</a>';
	}
	
	if ($ogg) { 
		$ogg_source = '<source src="'.$ogg.'" type=\'video/ogg; codecs="theora, vorbis"\' />'; 
		$ogg_link = '<a href="'.$ogg.'">Ogg</a>';
	}
	
	if ($poster) {
		$poster_attribute = 'poster="'.$poster.'"'; 
		$flow_player_poster = '"http://video-js.zencoder.com/oceans-clip.png", ';
		$image_fallback = <<<_end_
			<img src="$poster" width="$width" height="$height" alt="Poster Image" title="No video playback capabilities." />
_end_;
	}
	
	if ($preload) { 
		$preload_attribute = 'preload="auto"'; 
		$flow_player_preload = ',"autoBuffering":true';
	} else {
		$preload_attribute = 'preload="none"';
		$flow_player_preload = ',"autoBuffering":false';
	}
	
	if ($autoplay) { 
		$autoplay_attribute = "autoplay"; 
		$flow_player_autoplay = ',"autoPlay":true';
	} else {
		$autoplay_attribute = ""; 
		$flow_player_autoplay = ',"autoPlay":false';
	}
	
	$videojs .= <<<_end_
	<div class="video-js-box calavera-player">
		<video class="video-js" width="{$width}" height="{$height}" {$poster_attribute} controls {$preload_attribute} {$autoplay_attribute}>
		{$mp4_source}
		{$webm_source}
		{$ogg_source}
		<object class="vjs-flash-fallback" width="{$width}" height="{$height}" type="application/x-shockwave-flash" data="http://releases.flowplayer.org/swf/flowplayer-3.2.1.swf">
			<param name="movie" value="http://releases.flowplayer.org/swf/flowplayer-3.2.1.swf" />
			<param name="allowfullscreen" value="true" />
			<param name="flashvars" value='config={"playlist":[$flow_player_poster{"url": "$mp4" $flow_player_autoplay $flow_player_preload }]}' />
			{$image_fallback}
		</object>
		</video>
	</div>
_end_;

	return $videojs;
}
add_shortcode('video', 'video_shortcode');

?>