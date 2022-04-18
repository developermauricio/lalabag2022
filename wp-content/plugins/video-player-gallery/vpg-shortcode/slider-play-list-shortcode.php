<?php
/**
 * 'vpg_playlist' Shortcode
 * 
 * @package Video gallery and Player Pro
 * @since 1.0.0
 */
if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/**
 * Function to handle the `vpg_playlist` shortcode
 * 
 * @package Video Player gallery 
 * @since 1.0.0
 */
function vpg_play_list_shortcode( $atts, $content = null ) {
	// Shortcode Parameters
	$atts = shortcode_atts(array(
		'template'        		=> 'template-1',//gsp
		'video_limit'    		=> 20,//gsp
		'video_cat' 			=> '',//gsp
		'post'     				=> array(),//gsp
		'exclude_post'			=> array(),//gsp
		'query_offset'			=> '',//gsp
        'order'					=> 'DESC',//gsp
		'orderby'				=> 'date',//gsp
		'show_title'    		=> 'true',//gsp
		'show_content'  		=> 'false',//gsp
		'popup_fix'				=> 'true',//gsp
		'autoplay' 				=> 'true',//sp
		'autoplay_interval' 	=> 5000, //sp
		'speed' 				=> 2000,//sp
		'arrows' 				=> 'true',//sp
		'pagination_dots' 		=> 'true',//sp
		'loop' 					=> 'true',//sp
		'center_mode' 			=> 'false',//sp
        'auto_height'           => 'false',//sp
		'playlist_row'          => 4,  //p
		'playlist_arrow'        => "true", //p		
		'extra_class'			=> '', //gsp
	), $atts, 'video_playlist');
    $vpgdesign	= vpg_templates();
    $design_temp = $atts['template'];
	$design = array_key_exists( trim($design_temp)  , $vpgdesign ) ? $design_temp : 'template-1';
	$testimonials_design_file_url 	= WP_VPG_DIR . '/vpg-templates/playlist/template-1.php';
	$design_template 				= (file_exists($testimonials_design_file_url)) ? $testimonials_design_file_url : '';
	$atts['popup_fix'] 			    = ($atts['popup_fix'] == 'false') 			? 'false' 									: 'true';
	$atts['video_limit']				    = !empty($atts['video_limit']) 					? $atts['video_limit'] 			: 20;
	$atts['cat']			        = (!empty($atts['video_cat']))				? explode(',', $atts['video_cat']) 			: '';
	$atts['playlist_row']   	    = !empty($atts['playlist_row']) 			? $atts['playlist_row'] 					: 4;
	$atts['playlist_arrow'] 	    = ($atts['playlist_arrow'] == 'false' )			? 'false'								: 'true';
	$atts['auto_height'] 		    = ($atts['auto_height'] == 'false' )			? 'false'								: 'true';
	$atts['show_title'] 		    = ($atts['show_title'] == 'false' )			? 'false'									: 'true'; 	
	$atts['show_content'] 		    = ($atts['show_content'] == 'true' )		? 'true'									: 'false';
	$atts['order'] 				    = (strtolower($atts['order']) == 'asc' ) 	? 'ASC' 									: 'DESC';
	$atts['orderby']			    = !empty($atts['orderby']) 					? $atts['orderby'] 							: 'date';
	$atts['posts'] 				    = !empty($atts['post'])						? explode(',', $atts['post']) 				: array();
	$atts['exclude_post']		    = !empty($atts['exclude_post'])				? explode(',', $atts['exclude_post']) 		: array();
	$atts['autoplay_speed'] 	    = ($atts['autoplay_interval'] !== '') 		? $atts['autoplay_interval'] 					: 3000;
	$atts['speed'] 				    = (!empty($atts['speed'])) 					? $atts['speed'] 							: 300;
	$atts['arrows'] 			    = ($atts['arrows'] == 'false') 				? 'false' 									: 'true';
    $atts['dots'] 			        = ($atts['pagination_dots'] == 'false') 	? 'false' 						                : 'true';
  	$atts['autoplay'] 			    = ($atts['autoplay'] == 'false') 			? 'false' 									: 'true';
	$atts['loop'] 				    = ($atts['loop'] == 'false') 				? 'false' 									: 'true';
	$atts['query_offset']		    = !empty($atts['query_offset'])				? $atts['query_offset'] 					: null;
	$atts['extra_class']		    = vpg_sanitize_html_classes($atts['extra_class']);
	extract( $atts );     	 
     wp_enqueue_script( 'wpoh-magnific-js' );
	 wp_enqueue_script( 'wpoh-slick-js' );
	 wp_enqueue_script( 'vpg-custom-js' );
	// Taking some globals
	global $post;
	// Taking defoult variables
	$i = 1;
	$popup_html 	= '';	
	$fix 		= vpg_get_static();
	// WP Query Parameters
	$args = array ( 
					'post_type'				=> WP_VPG_POST_TYPE,
					'post_status' 			=> array( 'publish' ),
					'posts_per_page' 		=> $video_limit,
					'order' 				=> $order,
					'orderby' 				=> $orderby,
					'post__in' 				=> $posts,
					'post__not_in'			=> $exclude_post,
					'ignore_sticky_posts'	=> true,
					'offset'				=> $query_offset,
				);
	if($cat != ""){
            	$args['tax_query'] = array( array( 'taxonomy' => WP_VPG_CAT, 'field' => 'tearm_id', 'terms' => $cat) );
            } 	
	// WP Query
	$video_query = new WP_Query($args);
	// Taking some variables template
	$post_count = $video_query->post_count;
	// Slider and Popup Configuration	      
      $video_cell="1";
       $center_mode		= ($center_mode == 'true' && $video_cell % 2 != 0 && $video_cell != $post_count) ? 'true' : 'false';
	   $center_mode_cls	= ($center_mode == 'true') ? 'center' : '';	
		$slider_conf = compact('slides_column', 'slides_scroll', 'dots', 'arrows', 'rows',  'autoplay', 'autoplay_interval', 'loop', 'speed', 'center_mode', 'playlist_row', 'playlist_arrow', 'auto_height');
		$popup_conf = compact('popup_fix');		
	ob_start();
	// If post is there
	?>
	<?php if($extra_class!="") { ?>
	<div class="<?php echo $extra_class; ?>">
	<?php } ?>
	<?php
	if( $video_query->have_posts() ) {
		           if( $design_template ) {
					include($design_template);
					}
	wp_reset_query(); // Reset WP Query
	$content .= ob_get_clean();
    return $content;
?>
<?php } ?>
<?php if($extra_class!="") { ?>
 </div>
<?php } ?>
<?php
}
// `vpg_playlist` slider shortcode
add_shortcode('vpg_playlist', 'vpg_play_list_shortcode');