<?php
/**
 * Add a custom css input 
 *
 */



// --------------------------------------------------------------------------------------------------------------
// options form for the admin pages
// --------------------------------------------------------------------------------------------------------------
if (is_admin()) {

				// add page to theme options

				$args = array();
				$args['id'] = ktt_var_name('custom_css_page');
				$args['page_title'] = 'Custom CSS';
				$args['page_description'] = __('The custom CSS option allow you to do things like hide elements on a page, reposition images, or change fonts', THEME_TEXTDOMAIN);
				$args['menu_title'] = 'Custom CSS';
				$args['menu_order'] = 8;
				$args['parent'] = 'theme-options';

				$new_admin_submenu = new KTT_admin_submenu($args);




				// add option to admin panel

				$args                           = array();
				$args['option_id']              = ktt_var_name('custom_css');
				$args['option_name']            = __('Custom CSS', THEME_TEXTDOMAIN);
				$args['option_label']           = __('', THEME_TEXTDOMAIN);
				$args['option_description']     = __('Add your own custom CSS that override theme default style.', THEME_TEXTDOMAIN);
				$args['option_type']            = 'wp_editor';
				$args['option_type_vars'] 		= array(
												    	'wpautop' => false,
												    	'media_buttons' => false,
												    	'textarea_name' => ktt_var_name('custom_css'),
												    	'textarea_rows' => 15,
												    	'teeny' 	=> true,
												    	'quicktags' => false,
												    	'tinymce' => false,
												      	);
				$args['option_page']            = ktt_var_name('custom_css_page');

				$KTT_new_setting = new KTT_new_setting($args);

}




// add the custom css to wp_head

add_action('wp_head', 'KTT_print_custom_css');
function KTT_print_custom_css() {
	$custom_css = get_option(ktt_var_name('custom_css'));
	if ($custom_css) {?>
		<style >
		<?php echo $custom_css;?>
		</style>
	<?php } 
}


?>