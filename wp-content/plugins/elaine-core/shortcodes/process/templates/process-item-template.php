<div class="edgtf-process-item <?php echo esc_attr( $holder_classes ); ?>">
	<div class="edgtf-process-image">
		<?php echo wp_get_attachment_image($image['image_id'], $image_size); ?>
		<span class="edgtf-process-line-image"></span>
	</div>
	<div class="edgtf-pi-content">
		<?php if(!empty($title)) { ?>
			<<?php echo esc_attr($title_tag); ?> class="edgtf-pi-title" <?php echo elaine_edge_get_inline_style($title_styles); ?>><?php echo esc_html($title); ?></<?php echo esc_attr($title_tag); ?>>
		<?php } ?>
		<?php if(!empty($text)) { ?>
			<p class="edgtf-pi-text" <?php echo elaine_edge_get_inline_style($text_styles); ?>><?php echo esc_html($text); ?></p>
		<?php } ?>
	</div>
</div>