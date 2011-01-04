<?php
/**
 * filters, and shortcodes
 *
 */

function remove_generator_link() { 
	return ""; 
}
add_filter("the_generator", "remove_generator_link", 1);

?>