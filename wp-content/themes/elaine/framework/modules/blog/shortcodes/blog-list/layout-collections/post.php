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
	        <div class="edgtf-post-info-bottom clearfix">
		        <?php if ($post_info_section == 'yes') { ?>
		        <div class="edgtf-post-info-bottom-left">
			        <?php
				        if ( $post_info_author == 'yes' ) {
				            elaine_edge_get_module_template_part('templates/parts/post-info/author', 'blog', '', $params);
				        }
				         if ( $post_info_comments == 'yes' ) {
					         elaine_edge_get_module_template_part( 'templates/parts/post-info/comments', 'blog', '', $params );
				         }
				         if ( $post_info_category == 'yes' ) {
					         elaine_edge_get_module_template_part( 'templates/parts/post-info/category', 'blog', '', $params );
				         }
			        ?>
			    </div>
		        <div class="edgtf-post-info-bottom-right">
			        <?php
			        if ( $post_info_share == 'yes' ) {
				        elaine_edge_get_module_template_part( 'templates/parts/post-info/share', 'blog', '', $params );
			        }
			        ?>
		        </div>
		        <?php } ?>
	        </div>
        </div>
	</div>
</li>