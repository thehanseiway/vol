<?php
/**
 * Combine all the css files in queue
 *
 */



/**
* check if the css combine feature is enabled
*/
function KTT_css_combine_is_enabled() {
	return get_option(ktt_var_name('active_css_combine'));
}




/**
* Combine the css files of the theme
*/
function KTT_combine_css() {


	require_once(ABSPATH . 'wp-admin/includes/file.php');
	WP_Filesystem();
	global $wp_filesystem;


    
    global $wp_styles;
	if ( !is_a($wp_styles, 'WP_Styles') )
		$wp_styles = new WP_Styles();
 
	$wp_styles->all_deps(array_keys($wp_styles->queue));

	//header('content-type: text/css; charset: UTF-8');

	$content = '';

	foreach ( $wp_styles->queue as $stle ) {

		
		$style = $wp_styles->registered[$stle];

		// if the source is exterior we dont combine it
		if(strpos($style->src, home_url()) !== false) {
			
			$style_src = str_replace(get_template_directory_uri(), get_template_directory(), $style->src);
			if (strpos($style_src,get_template_directory()) === false) continue;
			
		} else {

			//$style_src = ABSPATH . $style->src;
			continue;
		}


		if ( file_exists($style_src) ) 
			$content .= $wp_filesystem->get_contents($style_src);
		$content .= "\n\n";


		wp_dequeue_style( $stle );
		wp_deregister_style($stle);

		
	}


	// fix the urls
	$content = str_replace('../', get_template_directory_uri() . '/', $content );

	// remove breaklines
	$content = preg_replace('/^\s+|\n|\r|\s+$/m', '', $content);

	// Remove comments
	$content = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $content);

	// add style tag
	$content = '<style>' . $content . '</style>';

	// print all css combined
	echo $content;

}





// trigger the css combine feature
if (KTT_css_combine_is_enabled()) add_action('wp_print_styles', 'KTT_combine_css');





// --------------------------------------------------------------------------------------------------------------
// options form for the admin pages
// --------------------------------------------------------------------------------------------------------------
if (is_admin()) {


			// add page to theme options

			$args = array();
			$args['id'] = ktt_var_name('ajax-css_combine-page');
			$args['page_title'] = __('CSS Combine',THEME_TEXTDOMAIN);
			$args['page_description'] = __('The CSS Combine feature can be activated with just one click to accelerate and approach the pages load in the website.', THEME_TEXTDOMAIN);
			$args['menu_title'] = 'CSS Combine';
			$args['menu_order'] = 15;
			$args['parent'] = 'theme-options';

			$new_admin_submenu = new KTT_admin_submenu($args);




			// add option to admin panel

			$args                           = array();
			$args['option_id']              = ktt_var_name('active_css_combine');
			$args['option_name']            = __('CSS Combine', THEME_TEXTDOMAIN);
			$args['option_label']           = __('Active the CSS Combine feature.', THEME_TEXTDOMAIN);
			$args['option_description']     = __('This makes the site loading faster.', THEME_TEXTDOMAIN);
			$args['option_type']            = 'checkbox';
			$args['option_default'] 		= 1;
			$args['option_page']            = ktt_var_name('ajax-css_combine-page');

			$KTT_new_setting = new KTT_new_setting($args);




			

}
