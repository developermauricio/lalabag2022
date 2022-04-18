<?php
$image_src = get_the_post_thumbnail_url( get_the_ID() );
$image_meta = get_post_meta( get_the_ID(), 'edgtf_blog_list_featured_image_meta', true );
$image_src = !empty($image_meta) ? $image_meta : $image_src;
$author = get_post_meta( get_the_ID(), 'edgtf_post_quote_author_meta', true );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($post_classes); ?>>
    <div class="edgtf-post-content">
	    <div class="edgtf-post-text" style="background-image:url('<?php echo esc_url($image_src); ?>')">
            <div class="edgtf-post-text-inner">
                <div class="edgtf-post-text-main">
                    <?php elaine_edge_get_module_template_part('templates/parts/post-type/quote', 'blog', '', $part_params); ?>
                </div>
                <div class="edgtf-post-info-bottom clearfix">
                    <div class="edgtf-post-info-bottom-left">
	                    <div class="edgtf-quote-author">
                            <?php
                            if (empty($author))
                                elaine_edge_get_module_template_part('templates/parts/post-info/author', 'blog', '', $part_params);
                            ?>
	                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>