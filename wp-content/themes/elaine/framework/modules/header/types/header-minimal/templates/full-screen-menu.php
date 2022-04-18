<div class="edgtf-fullscreen-menu-holder-outer">
	<div class="edgtf-fullscreen-menu-holder">
		<div class="edgtf-fullscreen-menu-holder-inner">
			<?php if ($fullscreen_menu_in_grid) : ?>
				<div class="edgtf-container-inner">
			<?php endif; ?>

			<div class="edgtf-fullscreen-above-menu-widget-holder">
				<?php elaine_edge_get_header_widget_area_one(); ?>
			</div>
			
			<?php 
			//Navigation
			elaine_edge_get_module_template_part('templates/full-screen-menu-navigation', 'header/types/header-minimal');;

			?>

			<div class="edgtf-fullscreen-below-menu-widget-holder">
				<?php elaine_edge_get_header_widget_area_two(); ?>
			</div>
			
			<?php if ($fullscreen_menu_in_grid) : ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>