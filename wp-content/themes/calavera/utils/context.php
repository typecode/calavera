<?php
/**
 * functions that generate info based on page context
 *
 * based on WP Framework
 * http://wpframework.com/
 *
 *
 */

$calavera_post_classes_alt = 1;
$parse_comment_alt = 1;

function calavera_description($toEcho = true) {
	$desc = "";
	
	if (is_single()) {
	 	the_post();
		$desc = get_the_excerpt();
		rewind_posts();
	} else {
		$desc = get_bloginfo('description');
	}
	
	$desc = apply_filters('calavera_description', $desc);
		
	if ($toEcho) echo($desc);
	else return $desc;
}

function calavera_title($toEcho = true, $sep = '&larr;') {
	$sc = "";
	
	if (is_front_page() || is_single() || is_attachment() || is_page() || is_paged() || is_page_template()) {
		$sc = wp_title( $sep, true, 'right' );
	}
	elseif (is_archive()) {
		$sc = "Archive of: " . wp_title( '', false, 'right' ) . " $sep ";
	}
	elseif (is_search()) {
		global $s;
		$sc = "Search Results for \"$s\" $sep ";
	}
	elseif (is_404()) {
		$sc = '404 &mdash; Not Found' . " $sep ";
	}
	$sc .= get_bloginfo('name');
	
	$sc = apply_filters('calavera_title', $sc);
	
	if ($toEcho) echo($sc);
	else return $sc;
}

function calavera_h1($toEcho = true) {
	$h1 = "<a href='" . get_bloginfo('url') . "'>" . get_bloginfo('name') . "</a>";
	
	if (is_front_page() || is_home()) {
		$h1 .= " <strong>" . get_bloginfo('description') . "</strong>";
	}
	elseif (is_single() || is_attachment() || is_page() || is_paged() || is_page_template()) {
		$h1 .= " <strong>" . wp_title('', false, 'right') . "</strong>";
	}
	elseif (is_archive()) {
		$h1 .= " <strong>" . "Archive of: " . wp_title('', false, 'right') . "</strong>";
	}
	elseif (is_search()) {
		global $s;
		$h1 .= " <strong>" . "Search Results for <em>\"$s\"</em></strong>";
	}
	elseif (is_404()) {
		$h1 .= " <strong>" . '404 &mdash; Not Found' . "</strong>";
	}
	
	$h1 = apply_filters('calavera_h1', $h1);
	
	if ($toEcho) echo($h1);
	else return $h1;
}

function calavera_body_classes($toEcho = true) {
	global $wp_query, $current_user;
	
	$sc = array();
	
	// Applies the time- and date-based classes (below) to BODY element
	apply_time( time(), $sc );
	
	// Generic semantic classes for what type of content is displayed
	is_front_page()  ? $sc[] = 'home'       : null;
	is_home()        ? $sc[] = 'blog'       : null;
	is_archive()     ? $sc[] = 'archive'    : null;
	is_date()        ? $sc[] = 'date'       : null;
	is_search()      ? $sc[] = 'search'     : null;
	is_paged()       ? $sc[] = 'paged'      : null;
	is_attachment()  ? $sc[] = 'attachment' : null;
	is_404()         ? $sc[] = 'error404'   : null;

	if ( is_single() ) {
		$postID = $wp_query->post->ID;
		the_post();
		
		// Adds 'single' class and class with the post ID
		$sc[] = 'single postid-' . $postID;

		// Adds classes for the month, day, and hour when the post was published
		if ( isset( $wp_query->post->post_date ) )
			apply_time( mysql2date( 'U', $wp_query->post->post_date ), $sc, 's-' );

		// Adds category classes for each category on single posts
		if ( $cats = get_the_category() )
			foreach ( $cats as $cat )
				$sc[] = 's-category-' . $cat->slug;
				
		// Adds tag classes for each tags on single posts
		if ( $tags = get_the_tags() )
			foreach ( $tags as $tag )
				$sc[] = 's-tag-' . $tag->slug;

		// Adds MIME-specific classes for attachments
		if ( is_attachment() ) {
			$mime_type = get_post_mime_type();
			$mime_prefix = array( 'application/', 'image/', 'text/', 'audio/', 'video/', 'music/' );
			$sc[] = 'attachmentid-' . $postID . ' attachment-' . str_replace( $mime_prefix, "", "$mime_type" );
		}
		
		// Adds author class for the post author
		$sc[] = 's-author-' . sanitize_title_with_dashes( strtolower( get_the_author_login() ) );
		
		rewind_posts();
	}
	elseif ( is_author() ) {
		$author = $wp_query->get_queried_object();
		$sc[] = 'author';
		$sc[] = 'author-' . $author->user_nicename;
	} 
	elseif ( is_category() ) {
		$cat = $wp_query->get_queried_object();
		$sc[] = 'category';
		$sc[] = 'category-' . $cat->slug;
	}
	elseif ( is_tag() ) {
		$tags = $wp_query->get_queried_object();
		$sc[] = 'tag';
		$sc[] = 'tag-' . $tags->slug;
	}
	elseif ( is_page() ) {
		$pageID = $wp_query->post->ID;
		$page_children = wp_list_pages( "child_of=$pageID&echo=0" );
		the_post();
		$sc[] = 'page pageid-' . $pageID;
		$sc[] = 'page-author-' . sanitize_title_with_dashes( strtolower( get_the_author('login') ) );
		// Checks to see if the page has children and/or is a child page; props to Adam
		if ( $page_children )
			$sc[] = 'page-parent';
		if ( $wp_query->post->post_parent )
			$sc[] = 'page-child parent-pageid-' . $wp_query->post->post_parent;
		if ( is_page_template() ) // Hat tip to Ian, themeshaper.com
			$sc[] = 'page-template page-template-' . str_replace( '.php', '-php', get_post_meta( $pageID, '_wp_page_template', true ) );
		rewind_posts();
	} 
	elseif ( is_search() ) {
		the_post();
		if ( have_posts() ) {
			$sc[] = 'search-results';
		} else {
			$sc[] = 'search-no-results'; 
		}
		rewind_posts();
	}
	
	// For when a visitor is logged in while browsing
	if ( $current_user->ID )
		$sc[] = 'loggedin';

	// Paged classes; for 'page X' classes of index, single, etc.
	if ( ( ( $page = $wp_query->get( 'paged' ) ) || ( $page = $wp_query->get( 'page' ) ) ) && $page > 1 ) {
		$sc[] = 'paged-' . $page;
		if ( is_single() ) {
			$sc[] = 'single-paged-' . $page;
		} elseif ( is_page() ) {
			$sc[] = 'page-paged-' . $page;
		} elseif ( is_category() ) {
			$sc[] = 'category-paged-' . $page;
		} elseif ( is_tag() ) {
			$sc[] = 'tag-paged-' . $page;
		} elseif ( is_date() ) { 
			$sc[] = 'date-paged-' . $page; 
		} elseif ( is_author() ) { 
			$sc[] = 'author-paged-' . $page; 
		} elseif ( is_search() ) { 
			$sc[] = 'search-paged-' . $page;
		}
	}

	$browser = $_SERVER[ 'HTTP_USER_AGENT' ];
	
	// Mac, PC ...or Linux
	if ( preg_match( "/Mac/", $browser ) ) {
		$sc[] = 'mac';
	} elseif ( preg_match( "/Windows/", $browser ) ){
		$sc[] = 'windows';
	} elseif ( preg_match( "/Linux/", $browser ) ) {
		$sc[] = 'linux';
	} else {
		$sc[] = 'unknown-os';
	}
	
	// Checks browsers in this order: Chrome, Safari, Opera, MSIE, FF
	if ( preg_match( "/Chrome/", $browser ) ) {
		$sc[] = 'chrome';
		
		preg_match( "/Chrome\/(\d.\d)/si", $browser, $matches);
		$ch_version = 'ch' . str_replace( '.', '-', $matches[1] );
		$sc[] = $ch_version;
	
	} elseif ( preg_match( "/Safari/", $browser ) ) {
		$sc[] = 'safari';
				
		preg_match( "/Version\/(\d.\d)/si", $browser, $matches);
		$sf_version = 'sf' . str_replace( '.', '-', $matches[1] );
		$sc[] = $sf_version;
		
	} elseif ( preg_match( "/Opera/", $browser ) ) {
		$sc[] = 'opera';
				
		preg_match( "/Opera\/(\d.\d)/si", $browser, $matches); 
		$op_version = 'op' . str_replace( '.', '-', $matches[1] ); 
		$sc[] = $op_version;
	
	} elseif ( preg_match( "/MSIE/", $browser ) ) {
		$sc[] = 'msie';
		
		if( preg_match( "/MSIE 6.0/", $browser ) ) {
			$sc[] = 'ie6';
		} elseif ( preg_match( "/MSIE 7.0/", $browser ) ){
			$sc[] = 'ie7';
		} elseif ( preg_match( "/MSIE 8.0/", $browser ) ){
			$sc[] = 'ie8';
		}
	
	} elseif ( preg_match( "/Firefox/", $browser ) && preg_match( "/Gecko/", $browser ) ) {
		$sc[] = 'firefox';
		
		preg_match( "/Firefox\/(\d)/si", $browser, $matches);
		$ff_version = 'ff' . str_replace( '.', '-', $matches[1] );
		$sc[] = $ff_version;
	
	} else {
		$sc[] = 'unknown-browser';
	}
	
	$sc = join( ' ', apply_filters( 'calavera_body_classes',  $sc ) );
	
	if ($toEcho) echo($sc);
	else return $sc;
}

function calavera_post_classes($toEcho = true) {
	global $post, $calavera_post_classes_alt;
	
	// hentry for hAtom compliace, gets 'alt' for every other post DIV, describes the post type and p[n]
	$sc = array( 'hentry', "alt$calavera_post_classes_alt", $post->post_type, $post->post_status );
		
	// Author for the post queried
	$sc[] = 'author-' . sanitize_title_with_dashes( strtolower( get_the_author( 'login' ) ) );
	
	// Category for the post queried
	foreach ( (array) get_the_category() as $scat )
		$sc[] = 'category-' . $scat->slug;
		
	// Tags for the post queried; if not tagged, use .untagged
	if ( get_the_tags() == null ) {
		$sc[] = 'untagged';
	} else {
		foreach ( (array) get_the_tags() as $tag )
			$sc[] = 'tag-' . $tag->slug;
	}
	
	// For password-protected posts
	if ( $post->post_password )
		$sc[] = 'protected';
	
	// Applies the time- and date-based classes (below) to post DIV
	apply_time( mysql2date( 'U', $post->post_date ), $sc );
	
	// If it's the other to the every, then add 'alt' class
	if ( ++$calavera_post_classes_alt % 2 )
		$sc[] = 'alt';
	
	$sc = join( ' ', apply_filters( 'calavera_post_classes', $sc ) );
	
	if ($toEcho) echo($sc);
	else return $sc;
}

function calavera_comment_classes($toEcho = true) {
	global $comment, $post, $parse_comment_alt;
	
	$sc = array( $comment->comment_type );
	
	// Counts trackbacks (t[n]) or comments (c[n])
	if ( $comment->comment_type == 'comment' ) {
		$sc[] = "c$parse_comment_alt";
	} else {
		$sc[] = "t$parse_comment_alt";
	}
	
	// If the comment author has an id (registered), then print the login name
	if ( $comment->user_id > 0 ) {
	$user = get_userdata( $comment->user_id );
	// For all registered users, 'byuser'; to specificy the registered user, 'commentauthor+[log in name]'
	$sc[] = 'byuser comment-author-' . sanitize_title_with_dashes( strtolower( $user->user_login ) );
	// For comment authors who are the author of the post
	if ( $comment->user_id === $post->post_author )
		$sc[] = 'bypostauthor';
	}
	
	// If it's the other to the every, then add 'alt' class; collects time- and date-based classes
	apply_time( mysql2date( 'U', $comment->comment_date ), $sc, 'c-' );
	if ( ++$parse_comment_alt % 2 )
		$sc[] = 'alt';
		
	$sc = join( ' ', apply_filters( 'calavera_comment_classes', $sc ) );
	
	if ($toEcho) echo($sc);
	else return $sc;
}

function calavera_n_comments_class($toEcho = true) {
	$sc = "n-comments";
	
	if (!in_the_loop()) {
		the_post();
	}
	if (get_comments_number() == 0) {
		$sc .= " zero";
	} else {
		$sc .= " has-comments";
	}
	if (!in_the_loop()) {
		rewind_posts();
	}
	
	$sc = apply_filters('calavera_n_comments_class', $sc);
	
	if ($toEcho) echo($sc);
	else return $sc;
}

function apply_time($t, &$sc, $p = '') {
	$t = $t + ( get_option( 'gmt_offset' ) * 3600 );
	$sc[] = $p . 'y' . gmdate( 'Y', $t );
	$sc[] = $p . 'm' . gmdate( 'm', $t );
	$sc[] = $p . 'd' . gmdate( 'd', $t );
	$sc[] = $p . 'h' . gmdate( 'H', $t );
}

?>