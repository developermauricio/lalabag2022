<?php 
	$price = get_post_meta(get_the_ID(), 'restaurant_menu_item_price', true);
	$label = get_post_meta(get_the_ID(), 'restaurant_menu_item_label', true);
	$description = get_post_meta(get_the_ID(), 'restaurant_menu_item_description', true);
?>
<li class="edgtf-rml-item clearfix">
	<?php if($show_featured_image === 'yes') : ?>
			<div class="edgtf-rml-item-image">
				<a href="<?php echo esc_url(wp_get_attachment_url(get_post_thumbnail_id())); ?>" data-rel="prettyPhoto<?php echo esc_attr(get_the_ID()); ?>">
					<?php the_post_thumbnail('thumbnail'); ?>
				</a>
			</div>
	<?php endif; ?>
	<div class="edgtf-rml-item-content">
		<div class="edgtf-rml-top-holder">
			<div class="edgtf-rml-title-holder">
				<h5 class="edgtf-rml-title">
					<?php esc_html(the_title()); ?>
				</h5>
			</div>
			<div class="edgtf-rml-line"></div>

			<?php if(!empty($price)) : ?>
				<div class="edgtf-rml-price-holder">
					<h5 class="edgtf-rml-price"><?php echo esc_html($price); ?></h5>
				</div>

			<?php endif; ?>
		</div>
		<div class="edgtf-rml-bottom-holder clearfix">
			<?php if(!empty($description)) : ?>
			<div class="edgtf-rml-description-holder">
				<?php echo esc_html($description); ?>
			</div>
			<?php endif; ?>

			<?php if(!empty($label)) : ?>
				<div class="edgtf-rml-label-holder">
					<span class="edgtf-rml-label"><?php echo esc_html($label); ?></span>
				</div>
			<?php endif; ?>
		</div>
	</div>

</li>