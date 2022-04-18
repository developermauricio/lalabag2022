<?php
$image_src = get_the_post_thumbnail_url( get_the_ID() );
$author = get_post_meta( get_the_ID(), 'edgtf_post_quote_author_meta', true );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="edgtf-post-content">
	    <div class="edgtf-post-text" style="background-image:url('<?php echo esc_url($image_src); ?>')">
            <div class="edgtf-post-text-inner">
                <div class="edgtf-post-text-main">
                    <?php elaine_edge_get_module_template_part('templates/parts/post-type/link', 'blog', '', $part_params); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="edgtf-post-additional-content">
        <?php the_content(); ?>
    </div>
	<div class="edgtf-post-info-bottom clearfix">
		<div class="edgtf-post-info-bottom-left">
			<?php elaine_edge_get_module_template_part('templates/parts/post-info/author', 'blog', '', $part_params); ?>
			<?php elaine_edge_get_module_template_part('templates/parts/post-info/comments', 'blog', '', $part_params); ?>
			<?php elaine_edge_get_module_template_part('templates/parts/post-info/category', 'blog', '', $part_params); ?>
			<?php elaine_edge_get_module_template_part('templates/parts/post-info/tags', 'blog', '', $part_params); ?>
		</div>
		<div class="edgtf-post-info-bottom-right">
			<?php elaine_edge_get_module_template_part('templates/parts/post-info/share', 'blog', '', $part_params); ?>
		</div>
	</div>
</article>