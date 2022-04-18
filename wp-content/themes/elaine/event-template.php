<?php
$edgtf_sidebar_layout = elaine_edge_sidebar_layout();

get_header();
elaine_edge_get_title();
get_template_part('slider');
?>
<div class="edgtf-container edgtf-default-page-template">
	<?php do_action('elaine_edge_action_after_container_open'); ?>
	<div class="edgtf-container-inner clearfix">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="edgtf-grid-row edgtf-grid-huge-gutter">
				<div <?php echo elaine_edge_get_content_sidebar_class(); ?>>
					<?php
                    elaine_edge_get_tt_event_single_content();
					do_action('elaine_edge_action_page_after_content');
					?>
				</div>
				<?php if($edgtf_sidebar_layout !== 'no-sidebar') { ?>
					<div <?php echo elaine_edge_get_sidebar_holder_class(); ?>>
						<?php get_sidebar(); ?>
					</div>
				<?php } ?>
			</div>
		<?php endwhile; endif; ?>
	</div>
	<?php do_action('elaine_edge_action_before_container_close'); ?>
</div>
<?php get_footer(); ?>
