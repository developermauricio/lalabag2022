<div class="edgtf-page-header page-header clearfix">
    <div class="edgtf-theme-name pull-left" >
        <img src="<?php echo esc_url(elaine_edge_get_skin_uri() . '/assets/img/logo.png'); ?>" alt="<?php esc_attr_e( 'Logo', 'elaine' ); ?>" class="edgtf-header-logo pull-left"/>
        <h1 class="pull-left">
            <?php echo esc_html($themeName); ?>
            <small><?php echo esc_html($themeVersion); ?></small>
        </h1>
    </div>
    <div class="edgtf-top-section-holder">
        <div class="edgtf-top-section-holder-inner">
            <div class="edgtf-notification-holder">
                <div class="edgtf-input-change"><i class="fa fa-exclamation-circle"></i><?php esc_html_e('You should save your changes', 'elaine') ?></div>
                <div class="edgtf-changes-saved"><i class="fa fa-check-circle"></i><?php esc_html_e('All your changes are successfully saved', 'elaine') ?></div>
            </div>
            <div class="edgtf-top-buttons-holder">
                <?php if($showSaveButton) { ?>
                    <input type="button" id="edgtf_top_save_button" class="btn btn-info btn-sm" value="<?php esc_attr_e('Save Changes', 'elaine'); ?>"/>
                <?php } ?>
            </div>
        </div>
    </div>
</div>