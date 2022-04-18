<div class="edgtf-testimonials-holder clearfix <?php echo esc_attr($holder_classes); ?>">
    <div class="edgtf-testimonials edgtf-owl-slider" <?php echo elaine_edge_get_inline_attrs( $data_attr ) ?>>

    <?php if ( $query_results->have_posts() ):
        while ( $query_results->have_posts() ) : $query_results->the_post();
            $text     = get_post_meta( get_the_ID(), 'edgtf_testimonial_text', true );
            $author   = get_post_meta( get_the_ID(), 'edgtf_testimonial_author', true );
            $position = get_post_meta( get_the_ID(), 'edgtf_testimonial_author_position', true );

            $current_id = get_the_ID();
    ?>

            <div class="edgtf-testimonial-content" id="edgtf-testimonials-<?php echo esc_attr( $current_id ) ?>">
                <div class="edgtf-testimonial-text-holder">
                    <?php if ( ! empty( $text ) ) { ?>
                        <p class="edgtf-testimonial-text"><?php echo esc_html( $text ); ?></p>
                    <?php } ?>
	                <?php if ( has_post_thumbnail() ) { ?>
		                <div class="edgtf-testimonial-image">
			                <?php echo get_the_post_thumbnail( get_the_ID(), array( 74, 74 ) ); ?>
		                </div>
	                <?php } ?>
                    <?php if ( ! empty( $author ) ) { ?>
                        <div class="edgtf-testimonial-author">
                            <div class="edgtf-testimonials-author-name"><?php echo esc_html( $author ); ?></div>
                            <?php if ( ! empty( $position ) ) { ?>
                                <div class="edgtf-testimonials-author-job"><?php echo esc_html( $position ); ?></div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>

    <?php
        endwhile;
    else:
        echo esc_html__( 'Sorry, no posts matched your criteria.', 'elaine-core' );
    endif;

    wp_reset_postdata();
    ?>

    </div>
</div>