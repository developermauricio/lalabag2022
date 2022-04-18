<?php
$date = get_the_time('d');
$month_string = get_the_time('M');
$month = get_the_time('m');
$year = get_the_time('Y');
$title = get_the_title();
?>
<div itemprop="dateCreated" class="edgtf-post-info-date entry-date published updated">
    <?php if(empty($title) && elaine_edge_blog_item_has_link()) { ?>
        <a itemprop="url" href="<?php the_permalink() ?>">
    <?php } else { ?>
        <a itemprop="url" href="<?php echo get_month_link($year, $month); ?>">
    <?php } ?>
        <span class="edgtf-post-info-date-month"><?php echo esc_attr($month_string); ?></span>
        <span class="edgtf-post-info-date-day"><?php echo esc_attr($date); ?></span>
		<span class="edgtf-post-info-date-year"><?php echo esc_attr($year); ?></span>
        </a>
    <meta itemprop="interactionCount" content="UserComments: <?php echo get_comments_number(elaine_edge_get_page_id()); ?>"/>
</div>
