<?php
$i    = 0;
$rand = rand( 0, 1000 );
?>
<div class="edgtf-image-gallery edgtf-grid-list edgtf-grid-masonry-list edgtf-disable-bottom-space <?php echo esc_attr( $holder_classes ); ?>">
	<div class="edgtf-ig-inner edgtf-outer-space edgtf-masonry-list-wrapper">
		<div class="edgtf-masonry-grid-sizer"></div>
		<div class="edgtf-masonry-grid-gutter"></div>
		<?php foreach ( $images as $image ) { ?>
			<?php
			$image_classes    = '';
			$image_size_class = get_post_meta( $image['image_id'], 'image_gallery_masonry_image_size', true );
			$new_image_size   = $image_size;
			
			if ( ! empty( $image_size_class ) ) {
				$image_classes = 'edgtf-fixed-masonry-item edgtf-masonry-size-' . esc_attr( $image_size_class );
				
				if ( $image_size_class === 'large-width-height' ) {
					$new_image_size = 'full';
				} else if ( $image_size_class === 'small' ) {
					$new_image_size = 'elaine_edge_image_square';
				} else if ( $image_size_class === 'large-width' ) {
					$new_image_size = 'elaine_edge_image_landscape';
				} else if ( $image_size_class === 'large-height' ) {
					$new_image_size = 'elaine_edge_image_portrait';
				} else {
					$new_image_size = 'full';
				}
			}
			?>
			<div class="edgtf-ig-image edgtf-item-space <?php echo esc_attr( $image_classes ); ?>">
				<div class="edgtf-ig-image-inner">
					<?php if ( $image_behavior === 'lightbox' ) { ?>
						<a itemprop="image" class="edgtf-ig-lightbox" href="<?php echo esc_url( $image['url'] ); ?>" data-rel="prettyPhoto[image_gallery_pretty_photo-<?php echo esc_attr( $rand ); ?>]" title="<?php echo esc_attr( $image['title'] ); ?>">
					<?php } else if ( $image_behavior === 'custom-link' && ! empty( $custom_links ) ) { ?>
						<a itemprop="url" class="edgtf-ig-custom-link" href="<?php echo esc_url( $custom_links[ $i ++ ] ); ?>" target="<?php echo esc_attr( $custom_link_target ); ?>" title="<?php echo esc_attr( $image['title'] ); ?>">
					<?php } ?>
						<?php if ( is_array( $image_size ) && count( $image_size ) ) :
							echo elaine_edge_generate_thumbnail( $image['image_id'], null, $image_size[0], $image_size[1] );
						else:
							echo wp_get_attachment_image( $image['image_id'], $new_image_size );
						endif; ?>
					<?php if ( $image_behavior === 'lightbox' || $image_behavior === 'custom-link' ) { ?>
						</a>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
	</div>
</div>