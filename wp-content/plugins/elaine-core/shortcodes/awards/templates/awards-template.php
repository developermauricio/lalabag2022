<div class="edgtf-awards-holder <?php echo esc_attr($holder_classes); ?>" >
	<div class="edgtf-awards-inner">
		<div class="edgtf-awards-title" <?php echo elaine_edge_get_inline_style($title_styles); ?>>
			<span class="edgtf-awards-title-text">
			<?php if(!empty($title)) { ?>
			<?php echo esc_html($title);?>
			<?php } ?>
			</span>
		</div>
	</div>
		<div class="edgtf-awards-items-holder">
			<?php if(!empty($awards_items)) { ?>
				<div class="edgtf-awards-content-holder">
					<?php foreach($awards_items as $awards_item):?>
						<?php if(isset($awards_item['text'])) { ?>
							<div class="edgtf-awards-item-content" <?php echo elaine_edge_get_inline_style($items_styles); ?>>
								<?php echo esc_html($awards_item['text']);?>
							</div>
						<?php } ?>
					<?php endforeach; ?>
				</div>
			<?php } ?>
		</div>
</div>