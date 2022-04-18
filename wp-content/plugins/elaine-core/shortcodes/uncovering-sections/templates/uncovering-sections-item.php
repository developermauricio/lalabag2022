<li class="edgtf-uss-item <?php echo esc_attr($holder_classes); ?>" <?php echo elaine_edge_get_inline_attrs($holder_data); ?>>
    <div class="edgtf-uss-image-holder" <?php echo elaine_edge_get_inline_attrs($image_data); ?> <?php elaine_edge_inline_style($holder_styles); ?>></div>
    <div class="edgtf-uss-item-outer">
        <div class="edgtf-uss-item-inner" <?php elaine_edge_inline_style($item_inner_styles); ?>>
            <?php echo do_shortcode($content); ?>
        </div>
	</div>
	<?php if(!empty($link)) { ?>
		<a itemprop="url" class="edgtf-uss-item-link" href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr($link_target); ?>"></a>
	<?php } ?>
</li>