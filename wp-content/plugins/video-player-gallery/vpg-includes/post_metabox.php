<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Class for create plugin meta box
 * 
 * @package video player gallery
 * @since 1.0
 */ 
class vpg_Admin {	
	function __construct() {
		// Action to add metabox
		add_action( 'add_meta_boxes', array($this, 'vpg_post_metabox') );
		// Action to save metabox
		add_action( 'save_post', array($this,'vpg_post_metabox_value') );
	}
	/**
	 * video Post Settings Metabox
	 * 
	 * @package video player gallery
	 * @since 1.0
	 */
	function vpg_post_metabox() {
		add_meta_box( 'vpg-post-setting', __( 'Video Files URL OR Video Links', 'html5-videogallery-plus-player' ), array($this, 'vpg_post_setting'), 'vpg_video', 'normal', 'high' );
	}
	/**
	 * Video Post Settings Metabox for  HTML
	 * 
	 * @package video player gallery
	 * @since 1.0
	 */
	function vpg_post_setting() {
		global $post;
			$prefix = '_prevpg_'; // Metabox prefix
			// Getting saved values
			$vpg_mp4 	 = get_post_meta($post->ID, $prefix.'vpg_mp4', true);
			$vpg_wbbm    = get_post_meta($post->ID, $prefix.'vpg_wbbm', true);
			$vpg_ogg 	 = get_post_meta($post->ID, $prefix.'vpg_ogg', true);
			$vpg_youtube = get_post_meta($post->ID, $prefix.'vpg_youtube', true);
			$vpg_vm 	 = get_post_meta($post->ID, $prefix.'vpg_vm', true);
			?>
<div class="outer-tabs-wrp">
			<ul id="inner-tabs" class="inner-tabs">
		<li class="single-tab-nav active-tab">
			<a href="#vpg-html5"><?php _e('Simple HTML5', 'html5-videogallery-plus-player'); ?></a>
		</li>
		<li class="single-tab-nav">
			<a href="#vpg-yt"><?php _e('YouTube', 'html5-videogallery-plus-player'); ?></a>
		</li>
		<li class="single-tab-nav">
			<a href="#vpg-vm"><?php _e('Vimeo', 'html5-videogallery-plus-player'); ?></a>
		</li>
	</ul>
	<div id="vpg-html5" style="display:block;" class="vpg-yt wp-vgp-tab-cnt">
		<table class="form-table">
            <tbody>
            	<tr valign="top">
						<th scope="row">
							<label><?php _e('HTML5 Player', 'html5-videogallery-plus-player'); ?></label>
						</th>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="link-for-mp4"><?php _e('video/mp4', 'html5-videogallery-plus-player'); ?></label>
						</th>
						<td>
							<input type="url" value="<?php echo wp_vpg_esc_attr($vpg_mp4); ?>" class="large-text wpnw-more-link" id="link-for-mp4" name="<?php echo $prefix; ?>vpg_mp4" /><br/>
							<span class="description"><?php _e('ie http://videolink.mp4', 'html5-videogallery-plus-player'); ?></span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="link-for-webm"><?php _e('video/webm', 'html5-videogallery-plus-player'); ?></label>
						</th>
						<td>
							<input type="url" value="<?php echo wp_vpg_esc_attr($vpg_wbbm); ?>" class="large-text wpnw-more-link" id="link-for-webm" name="<?php echo $prefix; ?>vpg_wbbm" /><br/>
							<span class="description"><?php _e('ie http://videolink.webm', 'html5-videogallery-plus-player'); ?></span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="link-for-ogg"><?php _e('video/ogg', 'html5-videogallery-plus-player'); ?></label>
						</th>
						<td>
							<input type="url" value="<?php echo wp_vpg_esc_attr($vpg_ogg); ?>" class="large-text wpnw-more-link" id="link-for-ogg" name="<?php echo $prefix; ?>vpg_ogg" /><br/>
							<span class="description"><?php _e('ie http://videolink.ogg', 'html5-videogallery-plus-player'); ?></span>
						</td>
					</tr>
			</tbody>
		</table>
	</div>
	<div id="vpg-yt" class="vpg-yt wp-vgp-tab-cnt">
		<table class="form-table">
            <tbody>
            	<tr valign="top">
						<th scope="row">
							<label><?php _e('YouTube Link', 'html5-videogallery-plus-player'); ?></label>
						</th>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="link-for-youtube"><?php _e('Enter YouTube Link', 'html5-videogallery-plus-player'); ?></label>
						</th>
						<td>
							<input type="url" value="<?php echo wp_vpg_esc_attr($vpg_youtube); ?>" class="large-text wpnw-more-link" id="link-for-youtube" name="<?php echo $prefix; ?>vpg_youtube" /><br/>
							<span class="description"><?php _e('Like: https://www.youtube.com/watch?v=6d_uJWFAFro', 'html5-videogallery-plus-player'); ?></span>
						</td>
					</tr>
            </tbody>
        </table>
	</div>
	<div id="vpg-vm" class="vpg-yt wp-vgp-tab-cnt">
	<table class="form-table">
		<tbody>
					<tr valign="top">
						<th scope="row">
							<label><?php _e('Vimeo Link', 'html5-videogallery-plus-player'); ?></label>
						</th>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="link-for-vimeo"><?php _e('Enter Vimeo Link', 'html5-videogallery-plus-player'); ?></label>
						</th>
						<td>
							<input type="url" value="<?php echo wp_vpg_esc_attr($vpg_vm); ?>" class="large-text wpnw-more-link" id="link-for-vimeo" name="<?php echo $prefix; ?>vpg_vm" /><br/>
							<span class="description"><?php _e('ie https://vimeo.com/171807697', 'html5-videogallery-plus-player'); ?></span>
						</td>
					</tr>
		</tbody>
	</table>
	</div>
</div>		
	<?php }
	/**
	 * Function to save metabox values
	 * 
	 * @package WP News and Five Widgets Pro
	 * @since 1.0.0
	 */
	function vpg_post_metabox_value( $post_id ) {
		global $post_type;
		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )  || ( ! isset( $_POST['post_ID'] ) || $post_id != $_POST['post_ID'] ) || ( $post_type !=  'vpg_video' ) )
		{
		  return $post_id;
		}
		$prefix = '_prevpg_'; // Taking metabox prefix
		// Taking variables
		$vpg_mp4 	= isset($_POST[$prefix.'vpg_mp4']) 	        ? wp_vpg_clean_url($_POST[$prefix.'vpg_mp4']) 	: '';
		$vpg_youtube = isset($_POST[$prefix.'vpg_youtube']) 	? wp_vpg_clean_url($_POST[$prefix.'vpg_youtube']) 	: '';
		$vpg_wbbm 	= isset($_POST[$prefix.'vpg_wbbm']) 	    ? wp_vpg_clean_url($_POST[$prefix.'vpg_wbbm']) 	: '';
		$vpg_ogg 	= isset($_POST[$prefix.'vpg_ogg']) 	        ? wp_vpg_clean_url($_POST[$prefix.'vpg_ogg']) 	: '';
		$vpg_vm 	= isset($_POST[$prefix.'vpg_vm']) 	        ? wp_vpg_clean_url($_POST[$prefix.'vpg_vm']) 	: '';
       
		update_post_meta($post_id, $prefix.'vpg_mp4', $vpg_mp4);
		update_post_meta($post_id, $prefix.'vpg_wbbm', $vpg_wbbm);
		update_post_meta($post_id, $prefix.'vpg_ogg', $vpg_ogg);
		update_post_meta($post_id, $prefix.'vpg_youtube', $vpg_youtube);
		update_post_meta($post_id, $prefix.'vpg_vm', $vpg_vm);
	}
}
$vpg_admin = new vpg_Admin();