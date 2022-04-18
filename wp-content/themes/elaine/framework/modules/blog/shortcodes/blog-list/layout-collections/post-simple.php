<li class="edgtf-bl-item edgtf-item-space">
	<div class="edgtf-bli-inner">
		<?php if ( $post_info_image == 'yes' ) {
			elaine_edge_get_module_template_part( 'templates/parts/media', 'blog', '', $params );
		} ?>
        <div class="edgtf-bli-content">
	
	        <?php
	        if ( $post_info_date == 'yes' ) {
		        elaine_edge_get_module_template_part( 'templates/parts/post-info/date', 'blog', '', $params );
	        }
	        ?>
         
	        <?php elaine_edge_get_module_template_part( 'templates/parts/title', 'blog', '', $params ); ?>
	
	        <div class="edgtf-bli-excerpt">
		        <?php elaine_edge_get_module_template_part( 'templates/parts/excerpt', 'blog', '', $params ); ?>
	        </div>
	        <div class="edgtf-bli-read-more">
		        <?php elaine_edge_get_module_template_part('templates/parts/post-info/read-more', 'blog', '', $params); ?>
	        </div>
        </div>
	</div>
</li>