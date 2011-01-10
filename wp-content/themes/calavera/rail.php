<?php
/**
 * rail 
 *
 */
?>

<div class="rail">
	<div class="hd">
		<h1 class="logo graphic"><a href="<?php bloginfo('url'); ?>">
			<span><?php bloginfo("title"); ?></span>
		</a></h1>
	</div>
	<div class="bd">
		<ul id="menu" class="menu">
			<?php 
				wp_list_pages("title_li="); 
				calavera_videos_menu();
			?>
		</ul>
	</div>
</div>