<?php
if(!empty($icon_pack)){
	$icon_html = elaine_edge_icon_collections()->renderIcon($icon, $icon_pack, $params);
} else {
	$icon_html= '';
}

?>
<div class="edgtf-is-item <?php echo esc_attr($showcase_item_class); ?>">
	<?php if ($item_position == 'right' && (!empty($icon) || !empty($custom_icon))) { ?>
		<?php if (!empty($custom_icon)) : ?>
			<div class="edgtf-item-custom-icon-outer">
				<div class="edgtf-item-custom-icon-inner" <?php echo elaine_edge_get_inline_style($icon_attributes); ?>>
					<div class="edgtf-item-custom-icon">
						<?php echo wp_get_attachment_image($custom_icon, 'full'); ?>
						<?php if (!empty($custom_hover_icon)) { ?>
							<span class="edgtf-isi-hover-icon">
							<?php echo wp_get_attachment_image($custom_hover_icon, 'full'); ?>
						</span>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php else: ?>
			<div class="edgtf-item-icon">
				<?php
				    echo elaine_edge_get_module_part($icon_html);
				?>
			</div>
		<?php endif; ?>
	<?php } ?>
	<div class="edgtf-is-content">
		<?php if (!empty($item_title)) { ?>
		<<?php echo esc_attr($item_title_tag); ?> class="edgtf-is-title" <?php echo elaine_edge_get_inline_style($item_title_styles); ?>>
		<?php if (!empty($item_link)) { ?><a href="<?php echo esc_url($item_link); ?>" target="<?php echo esc_attr($item_target); ?>"><?php } ?>
			<?php echo esc_html($item_title); ?>
			<?php if (!empty($item_link)) { ?></a><?php } ?>
	</<?php echo esc_attr($item_title_tag); ?>>
<?php } ?>
	<?php if (!empty($item_text)) { ?>
		<p class="edgtf-is-text" <?php echo elaine_edge_get_inline_style($item_text_styles); ?>><?php echo esc_html($item_text); ?></p>
	<?php } ?>
</div>
<?php if ($item_position == 'left' && (!empty($icon) || !empty($custom_icon))) { ?>
	<?php if (!empty($custom_icon)) : ?>
		<div class="edgtf-item-custom-icon-outer">
			<div class="edgtf-item-custom-icon-inner" <?php echo elaine_edge_get_inline_style($icon_attributes); ?>>
				<div class="edgtf-item-custom-icon">
					<?php echo wp_get_attachment_image($custom_icon, 'full'); ?>
					<?php if (!empty($custom_hover_icon)) { ?>
						<span class="edgtf-isi-hover-icon">
								<?php echo wp_get_attachment_image($custom_hover_icon, 'full'); ?>
							</span>
					<?php } ?>
				</div>
			</div>
		</div>
	<?php else: ?>
		<div class="edgtf-item-icon">
			<?php
			    echo elaine_edge_get_module_part($icon_html);
			?>
		</div>
	<?php endif; ?>
<?php } ?>
</div>