<?php
/**
 * Pro Designs and Plugins Feed
 *
 * @package video player gallery
 * @since 1.0
 */
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;
// Action to add menu
add_action('admin_menu', 'vpg_register_design_page');
/**
 * Register plugin design page in admin menu
 * 
 * @package video player gallery
 * @since 1.0
 */
function vpg_register_design_page() {
	add_submenu_page( 'edit.php?post_type='.WP_VPG_POST_TYPE, __('How it works, our plugins and offers', 'vpg-video-player'), __('Help and shortcode Generator', 'vpg-video-player'), 'manage_options', 'rtsw-designs', 'vpg_designs_page' );
}
/**
 * Function to display plugin design HTML
 * 
 * @package video player gallery
 * @since 1.0
 */
function vpg_designs_page() {
	$admin_feed_tabs = vpg_help_tabs();
	$active_tab 	= isset($_GET['tab']) ? wp_vpg_clean($_GET['tab']) : 'help-for-you';
?>		
	<div class="wrap rtsw-wrap">
		<h2 class="nav-tab-wrapper">
			<?php
			foreach ($admin_feed_tabs as $tab_key => $tab_val) {
				$tab_name	= $tab_val['name'];
				$active_cls = ($tab_key == $active_tab) ? 'nav-tab-active' : '';
				$tab_link 	= add_query_arg( array( 'post_type' => WP_VPG_POST_TYPE, 'page' => 'rtsw-designs', 'tab' => $tab_key), admin_url('edit.php') );			?>
			<a class="nav-tab <?php echo $active_cls; ?>" href="<?php echo $tab_link; ?>"><?php echo $tab_name; ?></a>
			<?php } ?>
		</h2>		
		<div class="rtsw-tab-cnt-wrp">
		<?php
			if( isset($active_tab) && $active_tab == 'help-for-you' ) {
				vpg_work_page();
			}
			if( isset($active_tab) && $active_tab == 'grid-shortcode' ) { 
				vpg_admin_grid_shortcode();
			}
			if( isset($active_tab) && $active_tab == 'slider-shortcode' ) {
				vpg_admin_slider_shortcode();
			}
			if( isset($active_tab) && $active_tab == 'playlist-shortcode' ) {
				vpg_admin_playlist_shortcode();
			}
			if( isset($active_tab) && $active_tab == 'hire-wpexpert' ) {
				echo  vpg_get_plugin_design('hire-wpexpert');
			}			
		?>
		</div><!-- end .rtsw-tab-cnt-wrp -->
	</div><!-- end .rtsw-wrap -->
<?php
}
/**
 * Function to get plugin feed tabs
 *
 * @packagevideo player gallery
 * @since 1.0
 */
function vpg_help_tabs() {
	$admin_feed_tabs = array(
						'help-for-you' 	=> array('name' => __('Help For You', 'vpg-video-player'),),
						'grid-shortcode' 	=> array('name' => __('Grid shortcode Generator', 'vpg-video-player'),),
		                'slider-shortcode' => array('name' => __('Slider shortcode Generator', 'vpg-video-player'),),
		                'playlist-shortcode' => array('name' => __('Playlist shortcode Generator', 'vpg-video-player'),),
		                'hire-wpexpert' 	=> array(
													'name'				=> __('WordPress Help ', 'wp-logo-slider-and-widget'),
													'url'				=> 'https://wponlinehelp.com/wordpress-help/help-offers.php',
													'offer_key'		=> 'wpoh_offers_feed',
													'offer_time'	=> 98600,
												)
					);
	return $admin_feed_tabs;
}
/**
 * Function to get 'How It Works' HTML
 *
 * @package video player gallery
 * @since 1.0
 */
function vpg_work_page() { ?>	
	<style type="text/css">
	  	.vpg-shortcode-preview{background-color: #e7e7e7; font-weight: bold; padding: 2px 5px; display: inline-block; margin:0 0 2px 0;}
	</style>
	<div class="post-box-container">
		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-1">			
				<!--Help for you HTML -->
				<div id="post-body-content">
					<div class="metabox-holder">
						<div class="meta-box-sortables ui-sortable">
							<div class="postbox">								
								<h3 class="hndle">
									<span><?php _e( 'Help for you - Display and shortcode', 'vpg-video-player' ); ?></span>
								</h3>								
								<div class="inside">
									<table class="form-table">
										<tbody>
											<tr>
												<th>
													<label><?php _e('Basic Step', 'vpg-video-player'); ?>:</label>
												</th>
												<td>
													<ul>
														<li><?php _e('Step-1. Go to " Video Player --> Add New".', 'vpg-video-player'); ?></li>
														<li><?php _e('Step-2. Add  Video title, description and images', 'vpg-video-player'); ?></li>
														<li><?php _e('Step-3. Add Video Details like Video URL.', 'vpg-video-player'); ?></li>
														<li><?php _e('Step-4. Once added, press Publish button', 'vpg-video-player'); ?></li>
													</ul>
												</td>
											</tr>
											<tr>
												<th>
													<label><?php _e('How to used Shortcode', 'vpg-video-player'); ?>:</label>
												</th>
												<td>
													<ul>
														<li><?php _e('Step-1. for example Create a page like name with Video Gallery.', 'vpg-video-player'); ?></li>
														<li><?php _e('Step-2. set shortcode as per your need. and put in page text section.', 'vpg-video-player'); ?></li>
													</ul>
												</td>
											</tr>
											<tr>
												<th>
													<label><?php _e('All Shortcodes', 'vpg-video-player'); ?>:</label>
												</th>
												<td>
													<span class="vpg-shortcode-preview">[vpg_grid]</span> – <?php _e('Display in grid with six designs tempalte.', 'vpg-video-player'); ?> <br />
													<span class="vpg-shortcode-preview">[vpg_slider]</span> – <?php _e('Display in slider with six designs template.', 'vpg-video-player'); ?> <br />
													<span class="vpg-shortcode-preview">[vpg_playlist]</span> – <?php _e('Display in Video playlist with six designs template.', 'vpg-video-player'); ?> <br />													
												</td>
											</tr>
											<tr>
												<th>
													<label><?php _e('Need Any Help?', 'vpg-video-player'); ?></label>
												</th>
												<td><a  href="mailto:help@wponlinehelp.com">help@wponlinehelp.com</a><br/> <br/>
													<a class="button button-primary" href="http://demo.wponlinehelp.com/video-player-gallery/" target="_blank"><?php _e('Live Demo', 'vpg-video-player'); ?></a>
													<a class="button button-primary" href="http://docs.wponlinehelp.com/docs-project/video-player-gallery/" target="_blank"><?php _e('Documentation', 'vpg-video-player'); ?></a>
												</td>
											</tr>
										</tbody>
									</table>
								</div><!-- .inside -->
							</div><!-- #general -->
						</div><!-- .meta-box-sortables ui-sortable -->
					</div><!-- .metabox-holder -->
				</div><!-- #post-body-content -->
			</div><!-- #post-body -->
		</div><!-- #poststuff -->
	</div><!-- #post-box-container -->
<?php }
/**
 * 'plugin Grid Short code
 *
 * @package video player gallery
 * @since 1.0
 */
function vpg_admin_grid_shortcode() { ?>	
	<style type="text/css">
		.shortcode-bg{background-color: #f0f0f0;padding: 10px 5px;display: inline-block;margin: 0 0 5px 0;font-size: 16px;border-radius: 5px;	
		}
		.vpg_admin_shortcode_generator label{font-weight: 700; width: 100%; float: left;}
		.vpg_admin_shortcode_generator select{width: 100%;}
	</style>
	<div id="post-body-content">
		<div class="metabox-holder">
			<div class="meta-box-sortables ui-sortable">
				<div class="postbox">
					<h3 style="font-size: 18px;">
						<?php _e('Create Video Grid Shortcode :-', 'vpg-video-player') ?>
					</h3>
					<div class="inside">
						<table cellpadding="10" cellspacing="10">
							<tbody><tr><td valign="top">
								<div class="postbox" style="width:300px;">
								<form id="shortcode_generator" style="padding:20px;" class="vpg_admin_shortcode_generator">
									<p><label for="vpg_grid_template"><?php _e('1) Select Template:', 'vpg-video-player'); ?></label>
										<?php $sg_tempalte = vpg_templates() ?>
										<select id="vpg_grid_template" name="vpg_grid_template"
										onchange="sg_vpg_grid()">
										<option value="default-template">Default Template</option>
										<?php  foreach ($sg_tempalte as $k): ?>
											<option value="<?php _e($k, 'vpg-video-player') ?>">
												<?php _e($k, 'vpg-video-player') ?>
											</option>
										<?php endforeach; ?>
									</select>
								</p>
								<p><label for="vpg_grid_limit"><?php _e('2) set video Limit:', 'vpg-video-player'); ?></label>
						                    <input id="vpg_grid_limit" name="vpg_grid_limit" type="text" value="-1"
										      onchange="sg_vpg_grid()">
										      <span class="howto"> <?php _e('for all "-1" Enter any Numeric No.).', 'vpg-video-player'); ?></span>
							   </p>
										<p><label for="vpg_cat">
												<?php _e('3) Select Category:', 'vpg-video-player') ?></label>
												<?php
												$args = array("post_type"=> WP_VPG_POST_TYPE, "post_status"=> "publish");
												$terms = get_terms(['taxonomy' => WP_VPG_CAT,$args]);   	      						
												 ?>
												<select id="vpg_cat" name="vpg_cat" onchange="sg_vpg_grid()">
												   <option value="nocat">All Video</option>
													<?php if ($terms!='') {
													foreach ($terms as $key => $value) { ?>
														<option value="<?php echo $value->term_id; ?>">
															<?php echo $value->name;  ?>
														</option>													
													<?php  } } ?>
												</select>
												<span class="howto"> By Default All video.</span>												
											</p>
											<p><label for="vpg_grid_cell"><?php _e('4) Select Grid Cell:', 'vpg-video-player'); ?></label>
												<?php $sg_tempalte = vpg_cell_arr() ?>
												<select id="vpg_grid_cell" name="vpg_grid_cell"
												onchange="sg_vpg_grid()">
												<option value="default-value">Default Template</option>
												<?php  foreach ($sg_tempalte as $k=>$i): ?>
													<option value="<?php _e($k, 'vpg-video-player') ?>">
														<?php _e($i, 'vpg-video-player') ?>
													</option>
												<?php endforeach; ?>
											</select>
										</p>
										<p><label for="vpg_grid_post"><?php _e('5) if Display fix video:', 'vpg-video-player'); ?></label>
						                    <input id="vpg_grid_post" name="vpg_grid_post" type="text" value=" " placeholder="Enter Post ID" 
										      onchange="sg_vpg_grid()">
										      <span class="howto"> <?php _e('Enter Post ID. like: 256, 258, 252 etc).', 'vpg-video-player'); ?></span>
							            </p>
							            <p><label for="vpg_exclude_post"><?php _e('6) if no Display Specific video:', 'vpg-video-player'); ?></label>
						                    <input id="vpg_exclude_post" name="vpg_exclude_post" type="text" value=" " placeholder="Enter Post ID" 
										      onchange="sg_vpg_grid()">
										      <span class="howto"> <?php _e('Enter Post ID. like: 256, 258, 252 etc).', 'vpg-video-player'); ?></span>
							            </p>
							             <p><label for="vpg_grid_offset"><?php _e('7) if no Display latest video:', 'vpg-video-player'); ?></label>
						                    <input id="vpg_grid_offset" name="vpg_grid_offset" type="text" value=" " placeholder="Enter Any number" 
										      onchange="sg_vpg_grid()">
										      <span class="howto"> <?php _e('Enter Post ID. like: 2, 3, 5, 1, etc).', 'vpg-video-player'); ?></span>
							            </p>
							              <p>
                                                <label for="vpg_grid_title"><?php _e('8) Display Title:', 'vpg-video-player'); ?> 
                                                </label>
                                                <?php $vpg_grid_title = sg_true_false(); ?>
                                                <select id="vpg_grid_title" name="vpg_grid_title" onchange="sg_vpg_grid()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($vpg_grid_title as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'vpg-video-player') ?>">
                                                            <?php _e($i, 'vpg-video-player') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <span class="howto"> By Default Display title.</span>
                                    </p>
                                    <p>
                                                <label for="vpg_grid_content"><?php _e('9) Display content:', 'vpg-video-player'); ?> 
                                                </label>
                                                <?php $vpg_grid_content = sg_true_false(); ?>
                                                <select id="vpg_grid_content" name="vpg_grid_content" onchange="sg_vpg_grid()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($vpg_grid_content as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'vpg-video-player') ?>">
                                                            <?php _e($i, 'vpg-video-player') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                 <span class="howto"> By Default Not Display content.</span>
                                    </p>
                                     <p>
                                                <label for="vpg_grid_order"><?php _e('10) Set Video Order:', 'vpg-video-player'); ?> 
                                                </label>
                                                <?php $vpg_grid_order = vpg_asc_desc(); ?>
                                                <select id="vpg_grid_order" name="vpg_grid_order" onchange="sg_vpg_grid()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($vpg_grid_order as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'vpg-video-player') ?>">
                                                            <?php _e($i, 'vpg-video-player') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <span class="howto"> Display Video Ascending and Descending order.</span>
                                    </p>    
                                       <p>
                                                <label for="vpg_grid_popup_fix"><?php _e('11) Set Video Orderby:', 'vpg-video-player'); ?> 
                                                </label>
                                                <?php $vpg_grid_orderby = vpg_orderby(); ?>
                                                <select id="vpg_grid_orderby" name="vpg_grid_orderby" onchange="sg_vpg_grid()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($vpg_grid_orderby as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'vpg-video-player') ?>">
                                                            <?php _e($i, 'vpg-video-player') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>                                                 
                                    </p> 
                                    <p>
                                                <label for="vpg_grid_popup_fix"><?php _e('12)  Set Video Popup Postion ', 'vpg-video-player'); ?> 
                                                </label>
                                                <?php $vpg_grid_popup_fix = sg_true_false(); ?>
                                                <select id="vpg_grid_popup_fix" name="vpg_grid_popup_fix" onchange="sg_vpg_grid()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($vpg_grid_popup_fix as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'vpg-video-player') ?>">
                                                            <?php _e($i, 'vpg-video-player') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                             <span class="howto">Set Video Popup Postion like: Scroll and fix. if true means popup Scroll.</span>
                                    </p>
                                     <p>
                                                <label for="vpg_grid_popup_gallery"><?php _e('13)  Set Video Popup Gallery ', 'vpg-video-player'); ?> 
                                                </label>
                                                <?php $vpg_grid_popup_gallery = sg_true_false(); ?>
                                                <select id="vpg_grid_popup_gallery" name="vpg_grid_popup_gallery" onchange="sg_vpg_grid()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($vpg_grid_popup_gallery as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'vpg-video-player') ?>">
                                                            <?php _e($i, 'vpg-video-player') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                             <span class="howto">Set Video Popup Gallery like: Gallery and signgle. if true means popup Gallery.</span>
                                    </p>
                                    <p><label for="vpg_grid_extra_class"><?php _e('14) Enter extra CSS class name:', 'vpg-video-player'); ?></label>
						                    <input id="vpg_grid_extra_class" name="vpg_grid_extra_class" type="text" value=" " placeholder="Enter Post ID" 
										      onchange="sg_vpg_grid()">
										      <span class="howto"> <?php _e('For CSS Class name for some Design Customization.).', 'vpg-video-player'); ?></span>
							            </p>
										</form>
									</div>
								</td>
								<td valign="top"><h3><?php _e('Shortcode:', 'vpg-video-player'); ?></h3> 
									<p style="font-size: 16px;"><?php _e('Use this shortcode to display the Video Gallery in your posts or pages! Just copy this piece of text and place it where you want it to display.', 'vpg-video-player'); ?> </p>
									<div id="vpg_sg_grid_shortcode" style="margin:20px 0; padding: 10px;
									background: #e7e7e7;font-size: 16px;border-left: 4px solid #13b0c5;" >
								</div>
								<div style="margin:20px 0; padding: 10px;
								background: #e7e7e7;font-size: 16px;border-left: 4px solid #13b0c5;" >
								&lt;?php do_shortcode(<span id="vpg_sg_grid_shortcode_php"></span>); ?&gt;
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div><!-- .inside -->
		<hr>
				</div>
			</div>
		</div>
	</div>			
<?php } 
/**
 * 'plugin Slider Short code Generater
 *
 * @package video player gallery
 * @since 1.0
 */
function vpg_admin_slider_shortcode() { ?>	
	<style type="text/css">
		.shortcode-bg{background-color: #f0f0f0;padding: 10px 5px;display: inline-block;margin: 0 0 5px 0;font-size: 16px;border-radius: 5px;}
		.vpg_admin_shortcode_generator label{font-weight: 700; width: 100%; float: left;}
		.vpg_admin_shortcode_generator select{width: 100%;}
	</style>
	<div id="post-body-content">
		<div class="metabox-holder">
			<div class="meta-box-sortables ui-sortable">
				<div class="postbox">
					<h3 style="font-size: 18px;">
						<?php _e('Create Video Slider Shortcode :-', 'vpg-video-player') ?>
					</h3>
					<div class="inside">
						<table cellpadding="10" cellspacing="10">
							<tbody><tr><td valign="top">
								<div class="postbox" style="width:300px;">
								<form id="shortcode_generator" style="padding:20px;" class="vpg_admin_shortcode_generator">
									<p><label for="vpg_slider_template"><?php _e('1) Select Template:', 'vpg-video-player'); ?></label>
										<?php $sg_tempalte = vpg_templates() ?>
										<select id="vpg_slider_template" name="vpg_slider_template"
										onchange="sg_vpg_slider()">
										<option value="default-template">default Template</option>
										<?php  foreach ($sg_tempalte as $k): ?>
											<option value="<?php _e($k, 'vpg-video-player') ?>">
												<?php _e($k, 'vpg-video-player') ?>
											</option>
										<?php endforeach; ?>
									</select>
								</p>
								<p><label for="vpg_slider_limit"><?php _e('2) set video Limit:', 'vpg-video-player'); ?></label>
						                    <input id="vpg_slider_limit" name="vpg_slider_limit" type="text" value="-1"
										      onchange="sg_vpg_slider()">
										      <span class="howto"> <?php _e('for all "-1" Enter any Numeric No.).', 'vpg-video-player'); ?></span>
							   </p>
										<p><label for="vpg_slider_cat">
												<?php _e('3) Select Category:', 'vpg-video-player') ?></label>
												<?php
												$args = array("post_type"=> WP_VPG_POST_TYPE, "post_status"=> "publish");
												$terms = get_terms(['taxonomy' => WP_VPG_CAT,$args]);   	      						
												 ?>
												<select id="vpg_slider_cat" name="vpg_slider_cat" onchange="sg_vpg_slider()">
												   <option value="nocat">All Video</option>
													<?php if ($terms!='') {
													foreach ($terms as $key => $value) { ?>
														<option value="<?php echo $value->term_id; ?>">
															<?php echo $value->name;  ?>
														</option>													
													<?php  } } ?>
												</select>
												<span class="howto"> by default All video.</span> 												
											</p>
											<p><label for="vpg_slider_cell"><?php _e('4) Enter slider Cell:', 'vpg-video-player'); ?></label>
											  <input id="vpg_slider_cell" name="vpg_slider_cell" type="text" value=" " onchange="sg_vpg_slider()">
										      <span class="howto"> <?php _e('Set how many video for each slide.).', 'vpg-video-player'); ?></span>
										</p>
										<p><label for="vpg_slider_post"><?php _e('5) if Display fix video:', 'vpg-video-player'); ?></label>
						                    <input id="vpg_slider_post" name="vpg_slider_post" type="text" value=" " placeholder="Enter Post ID" 
										      onchange="sg_vpg_slider()">
										      <span class="howto"> <?php _e('Enter Post ID. like: 256, 258, 252 etc).', 'vpg-video-player'); ?></span>
							            </p>
							            <p><label for="vpg_slider_exclude_post"><?php _e('6) if no Display Specific video:', 'vpg-video-player'); ?></label>
						                    <input id="vpg_slider_exclude_post" name="vpg_slider_exclude_post" type="text" value=" " placeholder="Enter Post ID" 
										      onchange="sg_vpg_slider()">
										      <span class="howto"> <?php _e('Enter Post ID. like: 256, 258, 252 etc).', 'vpg-video-player'); ?></span>
							            </p>
							             <p><label for="vpg_slider_offset"><?php _e('7) if no display latest video:', 'vpg-video-player'); ?></label>
						                    <input id="vpg_slider_offset" name="vpg_slider_offset" type="text" value=" " placeholder="Enter Any number" 
										      onchange="sg_vpg_slider()">
										      <span class="howto"> <?php _e('Enter Post ID. like: 2, 3, 5, 1, etc).', 'vpg-video-player'); ?></span>
							            </p>
							              <p>
                                                <label for="vpg_slider_title"><?php _e('8) Display Title:', 'vpg-video-player'); ?> 
                                                </label>
                                                <?php $vpg_slider_title = sg_true_false(); ?>
                                                <select id="vpg_slider_title" name="vpg_slider_title" onchange="sg_vpg_slider()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($vpg_slider_title as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'vpg-video-player') ?>">
                                                            <?php _e($i, 'vpg-video-player') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <span class="howto"> by default Dispaly title.</span>
                                    </p>
                                    <p>
                                                <label for="vpg_slider_content"><?php _e('9) Display content:', 'vpg-video-player'); ?> 
                                                </label>
                                                <?php $vpg_slider_content = sg_true_false(); ?>
                                                <select id="vpg_slider_content" name="vpg_slider_content" onchange="sg_vpg_slider()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($vpg_slider_content as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'vpg-video-player') ?>">
                                                            <?php _e($i, 'vpg-video-player') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                 <span class="howto"> by default Not Display content.</span>
                                    </p>
                                     <p>
                                                <label for="vpg_slider_order"><?php _e('10) Set Video Order:', 'vpg-video-player'); ?> 
                                                </label>
                                                <?php $vpg_slider_order = vpg_asc_desc(); ?>
                                                <select id="vpg_slider_order" name="vpg_slider_order" onchange="sg_vpg_slider()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($vpg_slider_order as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'vpg-video-player') ?>">
                                                            <?php _e($i, 'vpg-video-player') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                 <span class="howto"> Dispaly Video Ascending and Descending order.</span>
                                    </p>
                                       <p>
                                                <label for="vpg_grid_popup_fix"><?php _e('11) Set Video Orderby:', 'vpg-video-player'); ?> 
                                                </label>
                                                <?php $vpg_slider_orderby = vpg_orderby(); ?>
                                                <select id="vpg_slider_orderby" name="vpg_slider_orderby" onchange="sg_vpg_slider()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($vpg_slider_orderby as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'vpg-video-player') ?>">
                                                            <?php _e($i, 'vpg-video-player') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                 
                                    </p> 
                                    <p>
                                                <label for="vpg_grid_popup_fix"><?php _e('12)  Set Video Popup Postion ', 'vpg-video-player'); ?> 
                                                </label>
                                                <?php $vpg_slider_popup_fix = sg_true_false(); ?>
                                                <select id="vpg_slider_popup_fix" name="vpg_slider_popup_fix" onchange="sg_vpg_slider()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($vpg_slider_popup_fix as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'vpg-video-player') ?>">
                                                            <?php _e($i, 'vpg-video-player') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                             <span class="howto">Set Video Popup Postion like: Scroll and fix. if true means popup Scroll.</span>
                                    </p>
                                     <p>
                                                <label for="vpg_slider_popup_gallery"><?php _e('13)  Set Video Popup Gallery ', 'vpg-video-player'); ?> 
                                                </label>
                                                <?php $vpg_slider_popup_gallery = sg_true_false(); ?>
                                                <select id="vpg_slider_popup_gallery" name="vpg_slider_popup_gallery" onchange="sg_vpg_slider()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($vpg_slider_popup_gallery as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'vpg-video-player') ?>">
                                                            <?php _e($i, 'vpg-video-player') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                             <span class="howto">Set Video Popup Gallery like: Gallery and signgle. if true means popup Gallery.</span>
                                    </p>
                                     <p>
                                                <label for="vpg_slider_autoplay"><?php _e('14)  Set Video Autoplay ', 'vpg-video-player'); ?> 
                                                </label>
                                                <?php $vpg_slider_autoplay = sg_true_false(); ?>
                                                <select id="vpg_slider_autoplay" name="vpg_slider_autoplay" onchange="sg_vpg_slider()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($vpg_slider_autoplay as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'vpg-video-player') ?>">
                                                            <?php _e($i, 'vpg-video-player') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select> 
                                             <span class="howto">Set Video Automatic Scrolling.</span>
                                    </p>
                                    <p><label for="vpg_slider_autoplay_speed"><?php _e('15) Slides Moving Autoplay Speed:', 'vpg-video-player');?> </label>
						                    <input id="vpg_slider_autoplay_speed" name="vpg_slider_autoplay_speed" value="2000" onchange="sg_vpg_slider()" type="text">
										      <span class="howto"> (Set Slide Moving speed intervals, value in Milliseconds. Defoult value is 2000 ).</span>
									</p>
                                    <p><label for="vpg_slider_speed"><?php _e('16) Slides Moving Speed:', 'vpg-video-player');?> </label>
						                    <input id="vpg_slider_speed" name="vpg_slider_speed" value="1000" onchange="sg_vpg_slider()" type="text">
										      <span class="howto"> (Set each Slide Moving Speed value in Milliseconds. Defoult value is 1000 ).</span>
									</p>
									   <p>
                                                <label for="vpg_slider_arrow"><?php _e('17)  Dispaly Video Arrow: ', 'vpg-video-player'); ?> 
                                                </label>
                                                <?php $vpg_slider_arrow = sg_true_false(); ?>
                                                <select id="vpg_slider_arrow" name="vpg_slider_arrow" onchange="sg_vpg_slider()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($vpg_slider_arrow as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'vpg-video-player') ?>">
                                                            <?php _e($i, 'vpg-video-player') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select> 
                                             <span class="howto">Set Video Arrow for previous and next Slide.</span>
                                    </p>
                                     <p>
                                                <label for="vpg_slider_dots"><?php _e('18) Set Video Dots:', 'vpg-video-player'); ?> 
                                                </label>
                                                <?php $vpg_slider_dots = sg_true_false(); ?>
                                                <select id="vpg_slider_dots" name="vpg_slider_dots" onchange="sg_vpg_slider()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($vpg_slider_dots as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'vpg-video-player') ?>">
                                                            <?php _e($i, 'vpg-video-player') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select> 
                                             <span class="howto">Set Video Pagination dots Bullets.</span>
                                    </p>
                                    <p>
                                                <label for="vpg_slider_loop"><?php _e('19) Set Video loop:', 'vpg-video-player'); ?> 
                                                </label>
                                                <?php $vpg_slider_loop = sg_true_false(); ?>
                                                <select id="vpg_slider_loop" name="vpg_slider_loop" onchange="sg_vpg_slider()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($vpg_slider_loop as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'vpg-video-player') ?>">
                                                            <?php _e($i, 'vpg-video-player') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select> 
                                             <span class="howto">Set Video Infinite Scrolling.</span>
                                    </p>
                                    <p>
                                                <label for="vpg_slider_center_mode"><?php _e('20) Set Video Center Mode:', 'vpg-video-player'); ?> 
                                                </label>
                                                <?php $vpg_slider_center_mode = sg_true_false(); ?>
                                                <select id="vpg_slider_center_mode" name="vpg_slider_center_mode" onchange="sg_vpg_slider()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($vpg_slider_center_mode as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'vpg-video-player') ?>">
                                                            <?php _e($i, 'vpg-video-player') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select> 
                                             <span class="howto">Set Video as center mode. must be set: video cell like:  3,5,7,9 </span>
                                    </p>
                                     <p>
                                                <label for="vpg_slider_auto_height"><?php _e('21) Set Video Auto Hight:', 'vpg-video-player'); ?> 
                                                </label>
                                                <?php $vpg_slider_auto_height = sg_true_false(); ?>
                                                <select id="vpg_slider_auto_height" name="vpg_slider_auto_height" onchange="sg_vpg_slider()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($vpg_slider_auto_height as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'vpg-video-player') ?>">
                                                            <?php _e($i, 'vpg-video-player') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select> 
                                             <span class="howto">each Video is take auto height Adaptive.</span>
                                    </p>
                                    	<p><label for="vpg_slider_scroll"><?php _e('22). Scroll Video:', 'vpg-video-player'); ?></label>
						                    <input id="vpg_slider_scroll" name="vpg_slider_scroll" type="text" value="1"
										      onchange="sg_vpg_slider()">
										      <span class="howto"> <?php _e('(Move (Scroll) video for each slide Default value is "1" ).', 'vpg-video-player'); ?></span>
										  </p>
                                    <p><label for="vpg_slider_extra_class"><?php _e(' 23) Enter extra CSS class name:', 'vpg-video-player'); ?></label>
						                    <input id="vpg_slider_extra_class" name="vpg_slider_extra_class" type="text" value=" " placeholder="Enter Post ID" 
										      onchange="sg_vpg_slider()">
										      <span class="howto"> <?php _e('For CSS Class name for some Design Customization.).', 'vpg-video-player'); ?></span>
							            </p>
										</form>
									</div>
								</td>
								<td valign="top"><h3><?php _e('Shortcode:', 'vpg-video-player'); ?></h3> 
									<p style="font-size: 16px;"><?php _e('Use this shortcode to display the Video Gallery in your posts or pages! Just copy this piece of text and place it where you want it to display.', 'vpg-video-player'); ?> </p>
									<div id="vpg_sg_slider_shortcode" style="margin:20px 0; padding: 10px;
									background: #e7e7e7;font-size: 16px;border-left: 4px solid #13b0c5;" >
								</div>
								<div style="margin:20px 0; padding: 10px;
								background: #e7e7e7;font-size: 16px;border-left: 4px solid #13b0c5;" >
								&lt;?php do_shortcode(<span id="vpg_sg_slider_shortcode_php"></span>); ?&gt;
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div><!-- .inside -->
		<hr>
	</div>
	</div>
    </div>
	</div>		
<?php }
/**
 * 'plugin Playlist Short code Generater
 *
 * @package video player gallery
 * @since 1.0
 */
function vpg_admin_playlist_shortcode() { ?>	
	<style type="text/css">
		.shortcode-bg{background-color: #f0f0f0;padding: 10px 5px;display: inline-block;margin: 0 0 5px 0;font-size: 16px;border-radius: 5px;}
		.vpg_admin_shortcode_generator label{font-weight: 700; width: 100%; float: left;}
		.vpg_admin_shortcode_generator select{width: 100%;}
	</style>
	<div id="post-body-content">
		<div class="metabox-holder">
			<div class="meta-box-sortables ui-sortable">
				<div class="postbox">
					<h3 style="font-size: 18px;">
						<?php _e('Create Video Playlist Shortcode :-', 'vpg-video-player') ?>
					</h3>
					<div class="inside">
						<table cellpadding="10" cellspacing="10">
							<tbody><tr><td valign="top">
								<div class="postbox" style="width:300px;">
								<form id="shortcode_generator" style="padding:20px;" class="vpg_admin_shortcode_generator">
									<p><label for="vpg_playlist_template"><?php _e('1) Select Template:', 'vpg-video-player'); ?></label>
										<?php $sg_tempalte = vpg_templates() ?>
										<select id="vpg_playlist_template" name="vpg_playlist_template"
										onchange="sg_vpg_playlist()">
										<option value="default-template">default Template</option>
										<?php  foreach ($sg_tempalte as $k): ?>
											<option value="<?php _e($k, 'vpg-video-player') ?>">
												<?php _e($k, 'vpg-video-player') ?>
											</option>
										<?php endforeach; ?>
									</select>
								</p>
								<p><label for="vpg_playlist_limit"><?php _e('2) set video Limit:', 'vpg-video-player'); ?></label>
						                    <input id="vpg_playlist_limit" name="vpg_playlist_limit" type="text" value="-1"
										      onchange="sg_vpg_playlist()">
										      <span class="howto"> <?php _e('for all "-1" Enter any Numeric No.).', 'vpg-video-player'); ?></span>
							   </p>
							   	<p><label for="vpg_playlist_cat">
												<?php _e('3) Select Category:', 'vpg-video-player') ?></label>
												<?php
												$args = array("post_type"=> WP_VPG_POST_TYPE, "post_status"=> "publish");
												$terms = get_terms(['taxonomy' => WP_VPG_CAT,$args]);   	      						
												 ?>
												<select id="vpg_playlist_cat" name="vpg_playlist_cat" onchange="sg_vpg_playlist()">
												   <option value="nocat">All Video</option>
													<?php if ($terms!='') {
													foreach ($terms as $key => $value) { ?>
														<option value="<?php echo $value->term_id; ?>">
															<?php echo $value->name;  ?>
														</option>													
													<?php  } } ?>
												</select>
												<span class="howto"> by default All video.</span> 												
											</p>											
										<p><label for="vpg_playlist_post"><?php _e('4) if Display fix video:', 'vpg-video-player'); ?></label>
						                    <input id="vpg_playlist_post" name="vpg_playlist_post" type="text" value=" " placeholder="Enter Post ID" 
										      onchange="sg_vpg_playlist()">
										      <span class="howto"> <?php _e('Enter Post ID. like: 256, 258, 252 etc).', 'vpg-video-player'); ?></span>
							            </p>
							            <p><label for="vpg_playlist_exclude_post"><?php _e('5) if no Display Specific video:', 'vpg-video-player'); ?></label>
						                    <input id="vpg_playlist_exclude_post" name="vpg_playlist_exclude_post" type="text" value=" " placeholder="Enter Post ID" 
										      onchange="sg_vpg_playlist()">
										      <span class="howto"> <?php _e('Enter Post ID. like: 256, 258, 252 etc).', 'vpg-video-player'); ?></span>
							            </p>
							             <p><label for="vpg_playlist_offset"><?php _e('6) if no display latest video:', 'vpg-video-player'); ?></label>
						                    <input id="vpg_playlist_offset" name="vpg_playlist_offset" type="text" value=" " placeholder="Enter Any number" 
										      onchange="sg_vpg_playlist()">
										      <span class="howto"> <?php _e('Enter Post ID. like: 2, 3, 5, 1, etc).', 'vpg-video-player'); ?></span>
							            </p>
							              <p>
                                                <label for="vpg_playlist_title"><?php _e('7) Display Title:', 'vpg-video-player'); ?> 
                                                </label>
                                                <?php $vpg_playlist_title = sg_true_false(); ?>
                                                <select id="vpg_playlist_title" name="vpg_playlist_title" onchange="sg_vpg_playlist()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($vpg_playlist_title as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'vpg-video-player') ?>">
                                                            <?php _e($i, 'vpg-video-player') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <span class="howto"> by default Dispaly title.</span>
                                    </p>
                                    <p>
                                                <label for="vpg_playlist_content"><?php _e('8) Display content:', 'vpg-video-player'); ?> 
                                                </label>
                                                <?php $vpg_playlist_content = sg_true_false(); ?>
                                                <select id="vpg_playlist_content" name="vpg_playlist_content" onchange="sg_vpg_playlist()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($vpg_playlist_content as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'vpg-video-player') ?>">
                                                            <?php _e($i, 'vpg-video-player') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                 <span class="howto"> by default Not Display content.</span>
                                    </p>
                                     <p>
                                                <label for="vpg_playlist_order"><?php _e('9) Set Video Order:', 'vpg-video-player'); ?> 
                                                </label>
                                                <?php $vpg_playlist_order = vpg_asc_desc(); ?>
                                                <select id="vpg_playlist_order" name="vpg_playlist_order" onchange="sg_vpg_playlist()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($vpg_playlist_order as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'vpg-video-player') ?>">
                                                            <?php _e($i, 'vpg-video-player') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                 <span class="howto"> Dispaly Video Ascending and Descending order.</span>
                                    </p>
                                       <p>
                                                <label for="vpg_grid_popup_fix"><?php _e('10) Set Video Orderby:', 'vpg-video-player'); ?> 
                                                </label>
                                                <?php $vpg_playlist_orderby = vpg_orderby(); ?>
                                                <select id="vpg_playlist_orderby" name="vpg_playlist_orderby" onchange="sg_vpg_playlist()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($vpg_playlist_orderby as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'vpg-video-player') ?>">
                                                            <?php _e($i, 'vpg-video-player') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>                                                 
                                    </p> 
                                    <p>
                                                <label for="vpg_grid_popup_fix"><?php _e('11)  Set Video Popup Postion ', 'vpg-video-player'); ?> 
                                                </label>
                                                <?php $vpg_playlist_popup_fix = sg_true_false(); ?>
                                                <select id="vpg_playlist_popup_fix" name="vpg_playlist_popup_fix" onchange="sg_vpg_playlist()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($vpg_playlist_popup_fix as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'vpg-video-player') ?>">
                                                            <?php _e($i, 'vpg-video-player') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                             <span class="howto">Set Video Popup Postion like: Scroll and fix. if true means popup Scroll.</span>
                                    </p>                                     
                                     <p>
                                                <label for="vpg_playlist_autoplay"><?php _e('12)  Set Video Autoplay ', 'vpg-video-player'); ?> 
                                                </label>
                                                <?php $vpg_playlist_autoplay = sg_true_false(); ?>
                                                <select id="vpg_playlist_autoplay" name="vpg_playlist_autoplay" onchange="sg_vpg_playlist()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($vpg_playlist_autoplay as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'vpg-video-player') ?>">
                                                            <?php _e($i, 'vpg-video-player') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select> 
                                             <span class="howto">Set Video Automatic Scrolling.</span>
                                    </p>
                                    <p><label for="vpg_playlist_autoplay_speed"><?php _e('13) Slides Moving Autoplay Speed:', 'vpg-video-player');?> </label>
						                    <input id="vpg_playlist_autoplay_speed" name="vpg_playlist_autoplay_speed" value="2000" onchange="sg_vpg_playlist()" type="text">
										      <span class="howto"> (Set Slide Moving speed intervals, value in Milliseconds. Defoult value is 2000 ).</span>
									</p>
                                    <p><label for="vpg_playlist_speed"><?php _e('14) Slides Moving Speed:', 'vpg-video-player');?> </label>
						                    <input id="vpg_playlist_speed" name="vpg_playlist_speed" value="1000" onchange="sg_vpg_playlist()" type="text">
										      <span class="howto"> (Set each Slide Moving Speed value in Milliseconds. Defoult value is 1000 ).</span>
									</p>
									   <p>
                                                <label for="vpg_play_arrow"><?php _e('15)  Dispaly Video Arrow: ', 'vpg-video-player'); ?> 
                                                </label>
                                                <?php $vpg_play_arrow = sg_true_false(); ?>
                                                <select id="vpg_play_arrow" name="vpg_play_arrow" onchange="sg_vpg_playlist()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($vpg_play_arrow as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'vpg-video-player') ?>">
                                                            <?php _e($i, 'vpg-video-player') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select> 
                                             <span class="howto">Set Video Arrow for previous and next Slide.</span>
                                    </p>
                                     <p>
                                                <label for="vpg_playlist_dots"><?php _e('16) Set Video Dots:', 'vpg-video-player'); ?> 
                                                </label>
                                                <?php $vpg_playlist_dots = sg_true_false(); ?>
                                                <select id="vpg_playlist_dots" name="vpg_playlist_dots" onchange="sg_vpg_playlist()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($vpg_playlist_dots as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'vpg-video-player') ?>">
                                                            <?php _e($i, 'vpg-video-player') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select> 
                                             <span class="howto">Set Video Pagination dots Bullets.</span>
                                    </p>
                                    <p>
                                                <label for="vpg_playlist_loop"><?php _e('17) Set Video loop:', 'vpg-video-player'); ?> 
                                                </label>
                                                <?php $vpg_playlist_loop = sg_true_false(); ?>
                                                <select id="vpg_playlist_loop" name="vpg_playlist_loop" onchange="sg_vpg_playlist()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($vpg_playlist_loop as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'vpg-video-player') ?>">
                                                            <?php _e($i, 'vpg-video-player') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select> 
                                             <span class="howto">Set Video Infinite Scrolling.</span>
                                    </p>
                                    <p>
                                                <label for="vpg_playlist_center_mode"><?php _e('18) Set Video Center Mode:', 'vpg-video-player'); ?> 
                                                </label>
                                                <?php $vpg_playlist_center_mode = sg_true_false(); ?>
                                                <select id="vpg_playlist_center_mode" name="vpg_playlist_center_mode" onchange="sg_vpg_playlist()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($vpg_playlist_center_mode as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'vpg-video-player') ?>">
                                                            <?php _e($i, 'vpg-video-player') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select> 
                                             <span class="howto">Set Video as center mode. must be set: video cell like:  3,5,7,9 </span>
                                    </p> 
                                     <p> 
                                                <label for="vpg_playlist_auto_height"><?php _e('19) Set Video Auto Hight:', 'vpg-video-player'); ?> 
                                                </label>
                                                <?php $vpg_playlist_auto_height = sg_true_false(); ?>
                                                <select id="vpg_playlist_auto_height" name="vpg_playlist_auto_height" onchange="sg_vpg_playlist()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($vpg_playlist_auto_height as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'vpg-video-player') ?>">
                                                            <?php _e($i, 'vpg-video-player') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select> 
                                             <span class="howto">each Video is take auto height Adaptive.</span>
                                    </p>
                                    <p><label for="vpg_playlist_row"><?php _e(' 20) Set Video limit in Playlist:', 'vpg-video-player'); ?></label>
						                    <input id="vpg_playlist_row" name="vpg_playlist_row" type="text" value="4" onchange="sg_vpg_playlist()">
										      <span class="howto"> <?php _e('How many Video show in Playlist ).', 'vpg-video-player'); ?></span>
							            </p>
							             <p> 
                                                <label for="vpg_playlist_arrow"><?php _e('21) Set Video Arrow:', 'vpg-video-player'); ?> 
                                                </label>
                                                <?php $vpg_playlist_arrow = sg_true_false(); ?>
                                                <select id="vpg_playlist_arrow" name="vpg_playlist_arrow" onchange="sg_vpg_playlist()">
                                                	<option value="default-value">No Need</option>
                                                    <?php foreach ($vpg_playlist_arrow as $k=>$i): ?>
                                                        <option value="<?php _e($k, 'vpg-video-player') ?>">
                                                            <?php _e($i, 'vpg-video-player') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select> 
                                             <span class="howto">Set Arrow for Video Up Down Scroll.</span>
                                    </p>                                    	
                                    <p><label for="vpg_playlist_extra_class"><?php _e(' 22) Enter extra CSS class name:', 'vpg-video-player'); ?></label>
						                    <input id="vpg_playlist_extra_class" name="vpg_playlist_extra_class" type="text" value=" " placeholder="Enter class name" 
										      onchange="sg_vpg_playlist()">
										      <span class="howto"> <?php _e('For CSS Class name for some Design Customization.).', 'vpg-video-player'); ?></span>
							            </p>
										</form>
									</div>
								</td>
								<td valign="top"><h3><?php _e('Shortcode:', 'vpg-video-player'); ?></h3> 
									<p style="font-size: 16px;"><?php _e('Use this shortcode to display the Video Gallery in your posts or pages! Just copy this piece of text and place it where you want it to display.', 'vpg-video-player'); ?> </p>
									<div id="vpg_sg_playlist_shortcode" style="margin:20px 0; padding: 10px;
									background: #e7e7e7;font-size: 16px;border-left: 4px solid #13b0c5;" >
								</div>
								<div style="margin:20px 0; padding: 10px;
								background: #e7e7e7;font-size: 16px;border-left: 4px solid #13b0c5;" >
								&lt;?php do_shortcode(<span id="vpg_sg_playlist_shortcode_php"></span>); ?&gt;
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div><!-- .inside -->
		<hr>
	</div>
	</div>
    </div>
	</div>		
<?php }
/**
 * Gets the plugin design part feed
 *
 * @package Video gallery and Player
 * @since 1.0.0
 */
function vpg_get_plugin_design( $feed_type = '' ) {	
	$active_tab = wp_vpg_clean(isset($_GET['tab'])) ? $_GET['tab'] : '';
	// If tab is not set then return
	if( empty($active_tab) ) {
		return false;
	}
	// Taking some variables
	$wpoh_admin_tabs = vpg_help_tabs();
	$offer_key 	= isset($wpoh_admin_tabs[$active_tab]['offer_key']) 	? $wpoh_admin_tabs[$active_tab]['offer_key'] 	: 'wppf_' . $active_tab;
	$url 			= isset($wpoh_admin_tabs[$active_tab]['url']) 			? $wpoh_admin_tabs[$active_tab]['url'] 				: '';
	$offer_time = isset($wpoh_admin_tabs[$active_tab]['offer_time']) ? $wpoh_admin_tabs[$active_tab]['offer_time'] 	: 172800;
    $offercache 			= get_transient( $offer_key );	
	if ( false === $offercache) {
		
		$feed 			= wp_remote_get( wp_vpg_clean_url($url) );
		$response_code 	= wp_remote_retrieve_response_code( $feed );
		
		if ( ! is_wp_error( $feed ) && $response_code == 200 ) {
			if ( isset( $feed['body'] ) && strlen( $feed['body'] ) > 0 ) {
				$offercache = wp_remote_retrieve_body( $feed );
				set_transient( $offer_key, $offercache, $offer_time );
			}
		} else {
			$offercache = '<div class="error"><p>' . __( 'There was an error retrieving the data from the server. Please try again later.', 'html5-videogallery-plus-player' ) . '</div>';
		}
	}
	return $offercache;	
}