<button type="submit" <?php elaine_edge_inline_style($button_styles); ?> <?php elaine_edge_class_attribute($button_classes); ?> <?php echo elaine_edge_get_inline_attrs($button_data); ?> <?php echo elaine_edge_get_inline_attrs($button_custom_attrs); ?>>
	<span class="edgtf-btn-text"><?php echo esc_html($text); ?></span>
	<?php if($params['type'] == "outline" ) { ?>
		<span class="edgtf-btn-lines">
			<span class="edgtf-btn-line" <?php elaine_edge_get_inline_style($border_styles); ?>></span>
			<span class="edgtf-btn-line" <?php elaine_edge_get_inline_style($border_styles); ?>></span>
			<span class="edgtf-btn-line" <?php elaine_edge_get_inline_style($border_styles); ?>></span>
			<span class="edgtf-btn-line" <?php elaine_edge_get_inline_style($border_styles); ?>></span>
		</span>
	<?php }  if($params['type'] == "solid"){ ?>
		<span class="edgtf-detached-effect"></span>
	<?php } ?>
	<?php echo elaine_edge_icon_collections()->renderIcon($icon, $icon_pack, $icon_params);?>
</button>