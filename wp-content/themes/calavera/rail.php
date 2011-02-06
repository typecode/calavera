<?php
/**
 * rail 
 *
 */

global $video_page_id;

?>

<div class="rail">
	<div class="hd">
		<h1 class="logo graphic"><a href="<?php bloginfo("url"); ?>">
			<span><?php bloginfo("title"); ?></span>
		</a></h1>
	</div>
	<div class="bd">
		<ul id="menu" class="menu">
			<?php 
				wp_list_pages("exclude=$video_page_id&title_li="); 
				calavera_videos_menu();
			?>
		</ul>
	</div>
</div>
