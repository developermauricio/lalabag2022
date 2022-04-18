<?php $post_classes = elaine_edge_return_has_media() ? 'edgtf-post-has-media' : 'edgtf-post-no-media'; ?>
<article id="post-<?php the_ID(); ?>" <?php post_class($post_classes); ?>>
    <div class="edgtf-post-content">
        <div class="edgtf-post-heading">
			<?php elaine_edge_get_module_template_part('templates/parts/post-info/date-list', 'blog', '', $part_params); ?>
            <?php elaine_edge_get_module_template_part('templates/parts/media', 'blog', $post_format, $part_params); ?>
        </div>
        <div class="edgtf-post-text">
            <div class="edgtf-post-text-inner">
                <div class="edgtf-post-info-top">
					<?php elaine_edge_get_module_template_part('templates/parts/post-info/author', 'blog', '', $part_params); ?>
					<?php elaine_edge_get_module_template_part('templates/parts/post-info/comments', 'blog', '', $part_params); ?>
                </div>
                <div class="edgtf-post-text-main">
                    <?php elaine_edge_get_module_template_part('templates/parts/title', 'blog', '', $part_params); ?>
                    <?php the_content(); ?>
                    <?php do_action('elaine_edge_action_single_link_pages'); ?>
                </div>
                <div class="edgtf-post-info-bottom clearfix">
                    <div class="edgtf-post-info-bottom-left">
	                    <?php elaine_edge_get_module_template_part('templates/parts/post-info/category', 'blog', '', $part_params); ?>
	                    <?php elaine_edge_get_module_template_part('templates/parts/post-info/tags', 'blog', '', $part_params); ?>
                    </div>
                    <div class="edgtf-post-info-bottom-right">
                        <?php elaine_edge_get_module_template_part('templates/parts/post-info/share', 'blog', '', $part_params); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>