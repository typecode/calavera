<?php
/**
 * functions
 *
 */

// slugs to identify the "news" page and category
define("CALAVERA_NEWS", "news");
define("CALAVERA_NEWS_CAT", "news");

/*----- Utils -----*/
require_once(TEMPLATEPATH . '/wp-utils/calavera.context.php');

function remove_generator_link() { 
	return ""; 
}
add_filter("the_generator", "remove_generator_link", 1);

/*----- Video listing and display -----*/

function generateVideoHash($title) {
	return str_replace(" ", "", $title);
}

$videos = get_category_by_slug('videos');
$videoSections = get_categories(array(
	'orderby' => 'id',
	'parent' => $videos->term_id
));

function calavera_videos_menu() {
	$output = "";
	$counter = 0;
	$baseURL = get_bloginfo("url");
	global $videoSections;
	foreach ($videoSections as $section) {
		if ($counter == 0) {
			$output .= "<li class='section-start'>";
		} else {
			$output .= "<li>";
		}
		$id = $section->term_id;
		$output .= "<a href='" . get_category_link($id) . "'>" . $section->name . "</a>";
		$videos = get_posts(array(
			'category' => $id
		));
		$output .= "<ul>";
		foreach ($videos as $video) {
			$output .= "<li>";
			$title = $video->post_title;
			$output .= "<a href='" . $baseURL . "/#" . generateVideoHash($title) . "'>";
			$output .= $title; 
			$output .= "</a></li>";
		}
		$output .= "</ul>";
		$output .= "</li>";
		$counter += 1;
	}
	echo $output;
}

function calavera_videos_main() {
	$output = "";
	global $videoSections;
	foreach ($videoSections as $section) {
		$videos = get_posts(array(
			'category' => $section->term_id
		));
		foreach ($videos as $video) {
			$title = $video->post_title;
			$output .= "<div id='" . generateVideoHash($title) . "' class='box'>";
			$output .= "<div class='hd'><h2>" . $title . "</h2><div class='meta'>Director: ---, Producer: ---</div></div>";
			$output .= "<div class='bd'>" 
				. str_replace(']]>', ']]&gt', apply_filters('the_content', $video->post_content)) 
			. "</div>";
			$output .= "</div>";
		}
	}
	echo $output;
}

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