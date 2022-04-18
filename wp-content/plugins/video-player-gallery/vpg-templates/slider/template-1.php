<?php 
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit; ?>
<div class="vpg-wrap">
	<div class="vpg-single-video">
			<div class="vpg_frame">
				<div class="video_image_frame">					
					<?php if($video_url != '') { ?>
					<a href="<?php echo $video_url; ?>" class="popup-youtube">						
						<?php if( $video_image ) { ?>
						<img src="<?php echo $video_image; ?>" alt="<?php the_title(); ?>" />
						<?php } ?>
						<span class="video_icon"></span>
					</a>
					<?php } else { ?>
						<a href="#video-modal-<?php echo $fix.'-'.$i; ?>" class="popup-modal">
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
                 <?php if($show_title == "true") {?>
				<div class="video_title"><?php the_title(); ?></div>
				<?php } ?>						
				</div>				
				<?php if($show_content == "true") { ?>
				        <div class="video-content"><?php the_content(); ?></div>
			     <?php } ?>
			</div>
		</div>
		</div>