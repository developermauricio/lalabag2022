<div class="edgtf-instagram-list-holder <?php echo esc_attr($holder_classes); ?>">
    <?php if ( is_array( $images_array ) && count( $images_array ) ) { ?>
	    <ul class="edgtf-instagram-feed edgtf-outer-space <?php echo esc_attr($carousel_classes); ?> clearfix" <?php echo elaine_edge_get_inline_attrs( $data_attr ) ?>>
	    <?php
	    foreach ( $images_array as $image ) { ?>
		    <li class="edgtf-il-item edgtf-item-space">
			    <a href="<?php echo esc_url( $instagram_api->getHelper()->getImageLink( $image ) ); ?>" target="_blank">
				    <?php echo elaine_edge_kses_img( $instagram_api->getHelper()->getImageHTML( $image, $image_size ) ); ?>
				    <?php if ($show_instagram_icon =='yes' ) { ?>
                        <span class="edgtf-instagram-icon"><i class="social_instagram"></i></span>
				    <?php } ?>
			    </a>
		    </li>
	    <?php } ?>
    </ul>
    <?php } else { ?>
        <div class="edgtf-instagram-not-connected">
            <?php esc_html_e( 'It seems that you haven\'t connected with your Instagram account', 'elaine-instagram-feed' ); ?>
        </div>
    <?php } ?>
</div>