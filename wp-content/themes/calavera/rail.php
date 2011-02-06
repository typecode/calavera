<?php
/**
 * rail 
 *
 */

global $video_page_id;

function home_classer() {
	$output = "page_item";
	if (is_home()) {
		$output .= " current_page_item";
	}
	echo $output;
}

?>

<div class="rail">
	<div class="hd">
		<h1 class="logo graphic"><a href="<?php bloginfo("url"); ?>">
			<span><?php bloginfo("title"); ?></span>
		</a></h1>
	</div>
	<div class="bd">
		<ul id="menu" class="menu">
			<li class="<?php home_classer(); ?>">
				<a href="<?php bloginfo("url"); ?>">News</a>
			</li>
			<?php 
				wp_list_pages("exclude=$video_page_id&title_li="); 
				calavera_videos_menu();
			?>
		</ul>
	</div>
</div>
