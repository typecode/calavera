<?php
/**
 * rail 
 *
 */

global $news_id;

?>

<div class="rail">
	<div class="hd">
		<h1 class="logo graphic"><a href="<?php echo get_category_link($news_id); ?>">
			<span><?php bloginfo("title"); ?></span>
		</a></h1>
	</div>
	<div class="bd">
		<ul id="menu" class="menu">
			<?php 
				wp_list_categories("title_li=&include=$news_id");
				wp_list_pages("title_li="); 
				calavera_videos_menu();
			?>
		</ul>
	</div>
</div>
