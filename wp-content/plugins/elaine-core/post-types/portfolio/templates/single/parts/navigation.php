<?php if(elaine_edge_options()->getOptionValue('portfolio_single_hide_pagination') !== 'yes') : ?>
    <?php
    $back_to_link = get_post_meta(get_the_ID(), 'portfolio_single_back_to_link', true);
    $nav_same_category = elaine_edge_options()->getOptionValue('portfolio_single_nav_same_category') == 'yes';
    ?>
    <div class="edgtf-ps-navigation">
        <?php if(get_previous_post() !== '') : ?>
            <div class="edgtf-ps-prev">
                <?php if($nav_same_category) {
	                previous_post_link('%link','<span aria-hidden="true" class="edgtf-icon-font-elegant arrow_carrot-left edgtf-icon-element" style=""></span><span class="edgtf-ps-prev-item">' . esc_html__( "previous", "elaine-core" ) . '</span>', true, '', 'portfolio-category');
                } else {
	                previous_post_link('%link','<span aria-hidden="true" class="edgtf-icon-font-elegant arrow_carrot-left edgtf-icon-element" style=""></span><span class="edgtf-ps-prev-item">' . esc_html__( "previous", "elaine-core" ) . '</span>');
                } ?>
	            
            </div>
        <?php endif; ?>

        <?php if($back_to_link !== '') : ?>
            <div class="edgtf-ps-back-btn">
                <a itemprop="url" href="<?php echo esc_url(get_permalink($back_to_link)); ?>">
	                <span aria-hidden="true" class="edgtf-icon-font-elegant icon_grid-2x2 edgtf-icon-element" style=""></span>
                </a>
            </div>
        <?php endif; ?>

        <?php if(get_next_post() !== '') : ?>
            <div class="edgtf-ps-next">
                <?php if($nav_same_category) {
                    next_post_link('%link', '<span class="edgtf-ps-next-item">' . esc_html__( "next", "elaine-core" ) . '</span><span aria-hidden="true" class="edgtf-icon-font-elegant arrow_carrot-right edgtf-icon-element" style=""></span>', true, '', 'portfolio-category');
                } else {
                    next_post_link('%link', '<span class="edgtf-ps-next-item">' . esc_html__( "next", "elaine-core" ) . '</span><span aria-hidden="true" class="edgtf-icon-font-elegant arrow_carrot-right edgtf-icon-element" style=""></span>');
                } ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>