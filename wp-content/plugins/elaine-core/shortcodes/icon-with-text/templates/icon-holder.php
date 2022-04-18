<div class="edgtf-iwt-icon">
	<?php if(!empty($link)) : ?>
	<a itemprop="url" href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr($target); ?>">
		<?php endif; ?>
		<?php if(!empty($custom_icon)) : ?>
			<?php echo wp_get_attachment_image($custom_icon, 'full'); ?>
		<?php else: ?>
			<?php echo elaine_core_get_shortcode_module_template_part('templates/icon', 'icon-with-text', '', array('icon_parameters' => $icon_parameters)); ?>
		<?php endif; ?>
		<?php if(!empty($link)) : ?>
	</a>
<?php endif; ?>
</div>