<div class="edgtf-stacked-images-holder <?php echo esc_attr($holder_classes); ?>">
	<div class="edgtf-si-images">
		<?php if (!empty($item_image)) : ?>
			<?php echo wp_get_attachment_image($item_image, 'full', false, array('class' => 'edgtf-si-first-image')); ?>
		<?php endif; ?>
		<?php if (!empty($item_stack_image)): ?>
			<?php echo wp_get_attachment_image($item_stack_image, 'full', false, array('class' => 'edgtf-si-stack-image')); ?>
		<?php endif; ?>
	</div>
</div>