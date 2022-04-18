<div <?php elaine_edge_class_attribute($holder_classes); ?> <?php elaine_edge_inline_style($holder_styles); ?>>
	<div class="edgtf-wh-holder-inner">
		<?php if($enable_frame === 'yes') : ?>
			<div class="edgtf-wh-frame"></div>
			<div class="edgtf-wh-frame-2"></div>
		<?php endif; ?>

		<?php if(is_array($working_hours) && count($working_hours)) : ?>
				<?php if($title !== '') : ?>
					<div class="edgtf-wh-title-holder">
						<h2 class="edgtf-wh-title"><?php echo esc_html($title); ?>
							<?php if($title_accent_word !== '') : ?>
								<span class="edgtf-wh-title-accent-word"><?php echo esc_html($title_accent_word); ?></span>
							<?php endif; ?>
						</h2>
					</div>
				<?php endif; ?>

			<?php foreach($working_hours as $working_hour) : ?>
				<div class="edgtf-wh-item clearfix">
					<span class="edgtf-wh-day">
						<span class="edgtf-wh-icon">
							<span class="icon_clock_alt"></span>
						</span>
						<?php echo esc_html($working_hour['label']); ?>
					</span>
					<span class="edgtf-wh-dots"><span class="edgtf-wh-dots-inner"></span></span>
					<span class="edgtf-wh-hours">
						<?php if(isset($working_hour['from']) && $working_hour['from'] !== '') : ?>
							<span class="edgtf-wh-from"><?php echo esc_html($working_hour['from']); ?></span>
						<?php endif; ?>

						<?php if(isset($working_hour['to']) && $working_hour['to'] !== '') : ?>
							<span class="edgtf-wh-delimiter">-</span>
							<span class="edgtf-wh-to"><?php echo esc_html($working_hour['to']); ?></span>
						<?php endif; ?>
					</span>
				</div>
			<?php endforeach; ?>
		<?php else: ?>
		<p><?php esc_html_e('Working hours are not set', 'elaine-restaurant'); ?></p>
		<?php endif; ?>
	</div>
</div>