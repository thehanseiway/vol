<?php
if (!class_exists('VC_Extensions_MediumGallery')) {

    class VC_Extensions_MediumGallery {
        function VC_Extensions_MediumGallery() {
          vc_map( array(
            "name" => __("Medium Gallery", 'vc_mediumgallery_cq'),
            "base" => "cq_vc_mediumgallery",
            "class" => "wpb_cq_vc_extension_mediumgallery",
            "controls" => "full",
            "icon" => "cq_allinone_mediumgallery",
            "category" => __('Sike Extensions', 'js_composer'),
            'description' => __('Smooth lightbox', 'js_composer' ),
            "params" => array(
              array(
                "type" => "attach_images",
                "heading" => __("Gallery Images:", "vc_mediumgallery_cq"),
                "param_name" => "images",
                "value" => "",
                "description" => __("Select images from media library.", "vc_mediumgallery_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => __("Row max height", "vc_mediumgallery_cq"),
                "param_name" => "maxrowheight",
                "value" => "",
                "description" => __("Maximum height of the row in px or in % (example: 300 or 200%) 200% will be 600px of the row with 300px hieght.", "vc_mediumgallery_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => __("Gutter of each image", "vc_mediumgallery_cq"),
                "param_name" => "gutter",
                "value" => "10",
                "description" => __("The space between the rows / columns. Default is 10.", "vc_mediumgallery_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => __("Gallery width", "vc_mediumgallery_cq"),
                "param_name" => "gallerywidth",
                "value" => "1020px",
                "description" => __("Default is 100%.", "vc_mediumgallery_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => __("Resize image to this width in the thumbnail (except the container is larger than the minimal width):", "vc_mediumgallery_cq"),
                "param_name" => "thumbwidth",
                "value" => "",
                "description" => __("Default is displaying the original image. Specify the value only, for example 640.", "vc_mediumgallery_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => __("Row height", "vc_mediumgallery_cq"),
                "param_name" => "rowheight",
                "value" => "300",
                "description" => __("Row height. Default is 300.", "vc_mediumgallery_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => __("Overlay background", "vc_mediumgallery_cq"),
                "param_name" => "background",
                "value" => "",
                "description" => __("Default is rgba(255,255,255,.85), white transparent overlay. You can change it to other value, like rgba(0,0,0,.85), black transparent overlay. Note it will effect globally in same page.", "vc_mediumgallery_cq")
              ),
              array(
                "type" => "exploded_textarea",
                "holder" => "",
                "class" => "vc_mediumgallery_cq",
                "heading" => __("Title for each image", 'vc_mediumgallery_cq'),
                "param_name" => "titles",
                "value" => __("", 'vc_mediumgallery_cq'),
                "description" => __("Enter title for each image here. Divide each with linebreaks (Enter), leave it to blank if you do not want it.", 'vc_mediumgallery_cq')
              ),
              array(
                "type" => "exploded_textarea",
                "holder" => "",
                "class" => "vc_mediumgallery_cq",
                "heading" => __("Alt for each image", 'vc_mediumgallery_cq'),
                "param_name" => "alts",
                "value" => __("", 'vc_mediumgallery_cq'),
                "description" => __("Enter alt for each image here. Divide each with linebreaks (Enter), leave it to blank if you do not want it.", 'vc_mediumgallery_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => __("Extra class name for the thumbnail", "vc_mediumgallery_cq"),
                "param_name" => "extra_class",
                "description" => __("You can append extra class to the container.", "vc_mediumgallery_cq")
              )

            )
        ));

        function cq_vc_mediumgallery_func($atts, $content=null, $tag) {
          if(version_compare(WPB_VC_VERSION,  "4.6") >= 0){
              $atts = vc_map_get_attributes($tag,$atts);
              extract($atts);
          }else{
            extract( shortcode_atts( array(
              'images' => '',
              'gallerywidth' => '',
              'thumbwidth' => '',
              'rowheight' => '',
              'background' => '',
              'gutter' => '',
              'extra_class' => '',
              'titles' => '',
              'alts' => '',
              'maxrowheight' => ''
            ), $atts ) );
          }


          wp_register_style( 'vc_mediumgallery_cq_style', plugins_url('css/style.css', __FILE__) );
          wp_enqueue_style( 'vc_mediumgallery_cq_style' );

          wp_register_style( 'jGallery_style', plugins_url('css/justifiedGallery.min.css', __FILE__) );
          wp_enqueue_style( 'jGallery_style' );

          wp_register_style( 'magnific-popup_style', plugins_url('css/magnific-popup.css', __FILE__) );
          wp_enqueue_style( 'magnific-popup_style' );
        //   wp_register_script('photosetgrid', plugins_url('js/jquery.photosetgrid.min.js', __FILE__), array("jquery"));
        //   wp_enqueue_script('photosetgrid');

          wp_register_script('jGallery_js', plugins_url('js/jquery.justifiedGallery.min.js', __FILE__), array("jquery"));
          wp_enqueue_script('jGallery_js');

          wp_register_script('debounce', plugins_url('js/jquery.ba-throttle-debounce.min.js', __FILE__), array('jquery'));
          wp_enqueue_script('debounce');

          wp_register_script('magnific-popup', plugins_url('js/jquery.magnific-popup.min.js', __FILE__), array('jquery'));
          wp_enqueue_script('magnific-popup');

          wp_register_script('photosetgrid_init', plugins_url('js/init.min.js', __FILE__), array("jquery", "jGallery_js", "magnific-popup"));
          wp_enqueue_script('photosetgrid_init');

          // $aligncenter = $aligncenter == 'center' ? 'center' : '';
          $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
          $imagesarr = explode(',', $images);
          $titlearr = explode(',', $titles);
          $altarr = explode(',', $alts);
          $i = -1;
          $output = '';
          $output .= '<div class="jgallery-wrapper" style="max-width:'.$gallerywidth.'"><div class="cq-medium-gallery" data-maxrowheight="'.$maxrowheight.'" data-background="'.$background.'" data-rowheight="'.$rowheight.'" data-gutter="'.$gutter.'"> ';
              foreach ($imagesarr as $key => $image) {
                $i++;
                if(!isset($titlearr[$i])) $titlearr[$i] = '';
                if(!isset($altarr[$i])) $altarr[$i] = '';
                if(wp_get_attachment_image_src(trim($image), 'full')){
                    $return_img_arr = wp_get_attachment_image_src(trim($image), 'full');
                    if($thumbwidth!=""){
                      $output .= '<a href="'.$return_img_arr[0].'"><img src="'.$return_img_arr[0].'" data-highres="'.$return_img_arr[0].'" class="mediumgallery-img '.$extra_class.'" title="'.$titlearr[$i].'" alt="'.$altarr[$i].'" /></a>';
                    }else{
                      $output .= '<a href="'.$return_img_arr[0].'"><img src="'.$return_img_arr[0].'" data-highres="'.$return_img_arr[0].'" class="mediumgallery-img '.$extra_class.'" title="'.$titlearr[$i].'" alt="'.$altarr[$i].'" /></a>';
                    }
                }
              }
          $output .= '</div></div>';

          return $output;

        }

        add_shortcode('cq_vc_mediumgallery', 'cq_vc_mediumgallery_func');

      }
  }

}

?>
