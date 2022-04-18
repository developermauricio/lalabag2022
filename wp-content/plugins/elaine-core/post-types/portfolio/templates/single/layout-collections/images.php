<div class="edgtf-ps-image-holder">
    <div class="edgtf-ps-image-inner">
        <?php
        $media = elaine_core_get_portfolio_single_media();
    
        if(is_array($media) && count($media)) : ?>
            <?php foreach($media as $single_media) : ?>
                <div class="edgtf-ps-image">
                    <?php elaine_core_get_portfolio_single_media_html($single_media); ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<div class="edgtf-grid-row">
	<div class="edgtf-grid-col-8">
        <?php elaine_core_get_cpt_single_module_template_part('templates/single/parts/content', 'portfolio', $item_layout); ?>
    </div>
	<div class="edgtf-grid-col-4">
        <div class="edgtf-ps-info-holder">
	
	        <span class="edgtf-portfolio-info-title"><?php esc_html_e( 'Info', 'elaine-core' ); ?></span>
	
	        <?php
            //get portfolio custom fields section
            elaine_core_get_cpt_single_module_template_part('templates/single/parts/custom-fields', 'portfolio', $item_layout);
            
            //get portfolio categories section
            elaine_core_get_cpt_single_module_template_part('templates/single/parts/categories', 'portfolio', $item_layout);
            
            //get portfolio date section
            elaine_core_get_cpt_single_module_template_part('templates/single/parts/date', 'portfolio', $item_layout);
            
            //get portfolio tags section
            elaine_core_get_cpt_single_module_template_part('templates/single/parts/tags', 'portfolio', $item_layout);
            
            //get portfolio share section
            elaine_core_get_cpt_single_module_template_part('templates/single/parts/social', 'portfolio', $item_layout);
            ?>
        </div>
    </div>
</div>