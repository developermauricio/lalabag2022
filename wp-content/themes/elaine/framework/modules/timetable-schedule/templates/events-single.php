<div class="edgtf-ttevents-single">
    <?php if(has_post_thumbnail()) : ?>
        <div class="edgtf-ttevents-single-image-holder">
            <?php the_post_thumbnail('full'); ?>
        </div>
    <?php endif; ?>

    <div class="edgtf-ttevents-single-holder">
        <?php if(!empty($subtitle)) : ?>
            <p class="edgtf-ttevents-single-subtitle"><?php echo esc_html($subtitle); ?></p>
        <?php endif; ?>

        <h2 class="edgtf-ttevents-single-title"><?php the_title(); ?></h2>

        <div class="edgtf-ttevents-single-content">
            <?php the_content(); ?>
        </div>
    </div>
</div>
