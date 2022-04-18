<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Function to handle the `vpg_grid` shortcode
 * 
 * @package Video Player gallery 
 * @since 1.0.0
 */
function vpg_grid_shortcode( $atts, $content = null ) {	
	extract(shortcode_atts(array(
		"template"          => 'template-1',//gsp 
		"video_limit"    	=> '',//gsp
		"video_cat" 		=> '',//gsp
		"video_cell"        => '3',//gsp
		'post'     			=> array(),//gsp
		'exclude_post'		=> array(),//gsp
		'query_offset'		=> '',//gsp
		"show_title"        => 'true',//gsp
		"show_content"      => 'false',//gsp
		'order'				=> 'DESC',//gsp
		'orderby'			=> 'date',//gsp
		"popup_fix"		    => 'true',//gsp
		'popup_gallery'     => 'false',//gs
		'extra_class'			=> '',//gsp
	), $atts));
    $vpgdesign	= vpg_templates();
    $design_temp = $template;
	$design = array_key_exists( trim($design_temp)  , $vpgdesign ) ? $design_temp : 'template-1';
	$design_file_url 	= WP_VPG_DIR . '/vpg-templates/grid/' .'template-1.php';
	$design_template 	= (file_exists($design_file_url)) ? $design_file_url : '';
    $video_limit	= !empty( $video_limit)	? $video_limit	: -1;
    $cat	= !empty( $video_cat)	? $video_cat		        : '';
    $exclude_post		    = !empty($exclude_post)				? $exclude_post	: array();
    $popup_fix = ($popup_fix == 'true') ? 'true' : 'false';
    $show_title = ($show_title == 'true') ? 'true' : 'false';
    $show_content = ($show_content == 'true') ? 'true' : 'false';
    $order 				    = ($order == 'ASC' ) 	? 'ASC'  	: 'DESC';
	$orderby			    = !empty($orderby) 					? $orderby	: 'date';
    $posts 				    = !empty($post)						? explode(',', $post) 				: array();
	$exclude_post		    = !empty($exclude_post)				? explode(',', $exclude_post) 		: array();
	echo $query_offset		    = !empty($query_offset)				? $query_offset 					: null;
    $video_grid 				= vpg_grid_cell($video_cell);
    $extra_class		= vpg_sanitize_html_classes($extra_class);
	// Popup Configuration
	$popup_conf = compact('popup_fix', 'popup_gallery');	
	wp_enqueue_script( 'wpoh-magnific-js' );
	 wp_enqueue_script( 'vpg-custom-js' );	
	ob_start();
	// Create the Query
	$fix 		= vpg_get_static();
	$args = array ( 
								'post_type'      => WP_VPG_POST_TYPE,
								'post_status' 	=> array( 'publish' ),
								'posts_per_page' => $video_limit,
								'orderby'        => $orderby, 
								'order'			=> $order,
								'post__in'		=> $posts,
								'post__not_in'	=> $exclude_post,
								'ignore_sticky_posts' => true,
								'no_found_rows'  => 1,
								'offset'			=> $query_offset,
								) ;
			if($cat != ""){
            	$args['tax_query'] = array( array( 'taxonomy' => WP_VPG_CAT, 'field' => 'tearm_id', 'terms' => $cat) );
            } 		
	//count post type 
	$i = 1;
	$count = 1;
	$query = new WP_Query($args);
	$post_count = $query->post_count;	
	global $post;
	?>
	<?php if($extra_class!="") { ?>
	<div class="<?php echo $extra_class; ?>">
	<?php } ?>
	<div class="video-outer-row vpg-video-outer vpg-outer-fix vpg-video-<?php echo $design_temp;?>" id="vpg-static-<?php echo $fix; ?>">
	<?php
	// show Custom post details
	if( $post_count > 0) :	
		// video Post Loop
		while ($query->have_posts()) : $query->the_post();
		$first_last_cls = '';
		$video_image = wp_get_attachment_url( get_post_thumbnail_id() );
		$mp4_video = get_post_meta($post->ID, '_prevpg_vpg_mp4', true);
		$wbbm_video = get_post_meta($post->ID, '_prevpg_vpg_wbbm', true);
		$ogg_video = get_post_meta($post->ID, '_prevpg_vpg_ogg', true);
		$youtube_url = get_post_meta($post->ID, '_prevpg_vpg_youtube', true);
		$vimeo_url = get_post_meta($post->ID, '_prevpg_vpg_vm', true);		
		$video_url	= !empty( $youtube_url)	? $youtube_url : $vimeo_url;      	
         if( $count == 1 ){
					$first_last_cls = 'vpg-first';
				} elseif ( $count == $video_cell ) {
					$count = 0;
					$first_last_cls = 'vpg-last';
				}  	?>
		<?php 
		           if( $design_template ) {
					include($design_template);
					}
        ?>
		<?php
		$i++;
		$count++;
		endwhile;	
	endif;
	?>
		<div class="wp-vpg-popup-conf"><?php echo json_encode( $popup_conf ); ?></div><!-- end of-popup-conf -->
	</div><!-- end .video outter-row -->
	<?php if($extra_class!="") { ?>
 </div>
<?php } ?>
	<?php
	// Reset query to prevent conflicts
	wp_reset_query();	
	?>	
	<?php	
	return ob_get_clean();
}
add_shortcode("vpg_grid", "vpg_grid_shortcode");