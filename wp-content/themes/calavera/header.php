<?php
/**
 * header
 * 
 */
?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
	<title><?php calavera_title(); ?></title>
	
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>"/>	
	<?php if (is_front_page()) { ?>
		<!--<meta name="keywords" content=""/>-->
	<?php } ?>
	<meta name='description' content='<?php calavera_description(); ?>'/>

	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS" href="<?php bloginfo('rss2_url'); ?>"/>
	<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>"/>
	<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom 0.3" href="<?php bloginfo('atom_url'); ?>"/>

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>"/>

	<link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/images/favicon.ico"/>
	
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="all"/>
		
	<?php wp_head(); ?>	
</head>
<body class="<?php calavera_body_classes(); ?>">
	<div class="wrap">