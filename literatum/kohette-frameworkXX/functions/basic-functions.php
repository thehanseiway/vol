<?php
/**
 * Custom functions by Kohette Framework.
 *
 */

// return the correct name for a option (postmeta, usermeta, etc) adding the theme prefix
function ktt_var_name($string) {
    return THEME_PREFIX . $string;
}


// transform a local path in a direct url
function KTT_path_to_url($string) {
	return str_replace( WP_CONTENT_DIR, WP_CONTENT_URL, $string );
}