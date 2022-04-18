<li class="edgtf-<?php echo esc_html( $name ) ?>-share">
	<a itemprop="url" class="edgtf-share-link" href="#" onclick="<?php echo esc_attr( $link ); ?>">
	 	<?php if ($type == 'text') { ?>
	 	    <span class="edgtf-social-network-text"><?php echo esc_html($text); ?></span>
		<?php } elseif ( $custom_icon !== '' ) { ?>
			<img itemprop="image" src="<?php echo esc_url( $custom_icon ); ?>" alt="<?php echo esc_attr( $name ); ?>"/>
		<?php } else { ?>
			<span class="edgtf-social-network-icon <?php echo esc_attr( $icon ); ?>"></span>
		<?php } ?>
	</a>
</li>