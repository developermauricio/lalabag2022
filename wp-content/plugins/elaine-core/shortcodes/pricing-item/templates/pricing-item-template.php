<div class="edgtf-price-item">
        <div class="edgtf-pi-inner">
            <div class="edgtf-pi-prices">
                <span class="edgtf-pi-currency" <?php echo elaine_edge_get_inline_style($currency_styles); ?>><?php echo esc_html($currency); ?></span>
                <p class="edgtf-pi-price" <?php echo elaine_edge_get_inline_style($price_styles); ?>><?php echo esc_html($price_value); ?></p>
            </div>

            <div class="edgtf-pi-content-holder">
                <h5 class="edgtf-pi-title"><?php echo esc_html($title); ?></h5>
                <p class="edgtf-pi-subtitle"><?php echo esc_html($subtitle); ?></p>
                <div class="edgtf-pi-content">
                    <?php echo do_shortcode($content); ?>
                </div>
            </div>
        </div>
</div>