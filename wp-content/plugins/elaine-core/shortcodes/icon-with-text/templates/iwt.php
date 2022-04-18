<div <?php elaine_edge_class_attribute($holder_classes); ?>>
	
	<?php if($type != 'icon-right') { ?>
		<?php echo elaine_core_get_shortcode_module_template_part('templates/icon-holder', 'icon-with-text', '', array('icon_parameters' => $icon_parameters)); ?>
	<?php } ?>
	<div class="edgtf-iwt-content" <?php elaine_edge_inline_style($content_styles); ?>>
		<?php if(!empty($title)) { ?>
			<<?php echo esc_attr($title_tag); ?> class="edgtf-iwt-title" <?php elaine_edge_inline_style($title_styles); ?>>
				<?php if(!empty($link)) : ?>
					<a itemprop="url" href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr($target); ?>">
				<?php endif; ?>
				<span class="edgtf-iwt-title-text"><?php echo esc_html($title); ?></span>
				<?php if(!empty($link)) : ?>
					</a>
				<?php endif; ?>
			</<?php echo esc_attr($title_tag); ?>>
		<?php } ?>
		<?php if(!empty($text)) { ?>
			<p class="edgtf-iwt-text" <?php elaine_edge_inline_style($text_styles); ?>><?php echo esc_html($text); ?></p>
		<?php } ?>
	</div>
	<?php if($type == 'icon-right') { ?>
		<?php echo elaine_core_get_shortcode_module_template_part('templates/icon-holder', 'icon-with-text', '', array('icon_parameters' => $icon_parameters)); ?>
	<?php } ?>
</div>