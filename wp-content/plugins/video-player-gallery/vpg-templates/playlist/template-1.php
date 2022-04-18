<?php 
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit; ?>
<div class="playlist-clearfix vpg-playlist-<?php echo $design_temp;?>">
<div class="vpg-medium-8 vpg-cells playlist-vpg-slider-outter">
	<div class=" vpg-platlist-video-outer">
	<div class="playlist-slider-for" id="my-vpg-video-slider-<?php echo $fix; ?>">
<?php while ($video_query->have_posts()) : $video_query->the_post();		
		$video_image = wp_get_attachment_url( get_post_thumbnail_id() );
		$mp4_video = get_post_meta($post->ID, '_prevpg_vpg_mp4', true);
		$wbbm_video = get_post_meta($post->ID, '_prevpg_vpg_wbbm', true);
		$ogg_video = get_post_meta($post->ID, '_prevpg_vpg_ogg', true);
		$youtube_url = get_post_meta($post->ID, '_prevpg_vpg_youtube', true);
		$vimeo_url = get_post_meta($post->ID, '_prevpg_vpg_vm', true);
		$video_url	= !empty( $youtube_url)	? $youtube_url : $vimeo_url;
?>
			<div class="vpg-playlist-single">
			<div class="single-img-wrap">				
				<div class="video_image_frame">
					<?php if($video_url != '') { ?>
					<a href="<?php echo $video_url; ?>" class="playlist-popup-youtube">						
						<?php if( $video_image ) { ?>
						<img src="<?php echo $video_image; ?>" alt="<?php the_title(); ?>" />
						<?php } ?>
						<span class="video_icon"></span>
					</a>
					<?php } else { ?>
						<a href="#video-modal-<?php echo $fix.'-'.$i; ?>" class="playlist-popup-modal">
						<?php if( $video_image ) { ?>
						<img src="<?php echo $video_image; ?>" alt="<?php the_title(); ?>" />
						<?php } ?>
						<span class="video_icon"></span>
						</a>			
					<?php } ?>
					<div id="video-modal-<?php echo $fix.'-'.$i; ?>" class="mfp-hide white-popup-block vpg-popup-wrp">
						<video id="video_<?php echo get_the_ID(); ?>" class="wp-hvgp-video-frame video-js vjs-default-skin" controls preload="none" width="100%" poster="<?php echo $video_image; ?>" data-setup="{}">
							<source src="<?php echo $mp4_video; ?>" type='video/mp4' />
							<source src="<?php echo $wbbm_video; ?>" type='video/webm' />
							<source src="<?php echo $ogg_video; ?>" type='video/ogg' />
						</video>
						<div class="popup-title">
							<?php the_title(); ?>
						</div>
					</div>
				</div>
					<?php if($show_title=="true") { ?>
					<div class="single-playlist-title">
							<?php the_title(); ?>
					</div>
				<?php } ?>
					</div>
					 <?php if($show_content=="true") { ?>
					<div class="single-playlist-content">
						<?php the_content(); ?>
			    	</div>
			    <?php } ?>
			</div>		
		<?php	$i++;		
		endwhile; 
		?>
        </div>
    </div>
        <div class="playlist-vpg-video-slider-js-call" data-conf="<?php echo htmlspecialchars(json_encode($slider_conf)); ?>"></div>		
		</div> <!-- cell-8 end -->
		<div class="vpg-medium-4 vpg-cells" style="padding: 0px;">
             <div class="playlist-slider-nav   vpg-slider-<?php echo $design_temp;?>" id="vpg-video-slider-<?php echo $fix; ?>">	       
			<?php while ($video_query->have_posts()) : $video_query->the_post();		
						$video_image = wp_get_attachment_url( get_post_thumbnail_id() );
						$mp4_video = get_post_meta($post->ID, '_prevpg_vpg_mp4', true);
						$wbbm_video = get_post_meta($post->ID, '_prevpg_vpg_wbbm', true);
						$ogg_video = get_post_meta($post->ID, '_prevpg_vpg_ogg', true);
						$youtube_url = get_post_meta($post->ID, '_prevpg_vpg_youtube', true);
						$vimeo_url = get_post_meta($post->ID, '_prevpg_vpg_vm', true);
						$video_url	= !empty( $youtube_url)	? $youtube_url : $vimeo_url;
            ?>            
			<div class="vpg_frame-playlist">
				<div class="vpg-medium-6 vpg-cells">
				<div class="video_image_frame">					
					<?php if($video_url != '') { ?>
						<?php if( $video_image ) { ?>
						<img src="<?php echo $video_image; ?>" alt="<?php the_title(); ?>" />
						<span class="video_icon"></span>
						<?php } ?>
					<?php } else { ?>
								<?php if( $video_image ) { ?>
						<img src="<?php echo $video_image; ?>" alt="<?php the_title(); ?>" />
						<span class="video_icon"></span>
						<?php } ?>
					<?php } ?>
				</div>
			</div>
            <div class="vpg-medium-6 vpg-cells">
            	<div class="platlist-content-wrap">            
				<div class="playlist-title"><?php the_title(); ?></div>			
			<div class="playlist-content">
				<p><?php //echo $content = vpg_get_excerpt(15); ?></p>
			</div>
			</div>
			</div>
			</div>
            <?php	$i++;		
		endwhile; ?>
        </div>
		</div> <!-- cell-4 end -->
		</div>