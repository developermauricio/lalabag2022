<div class="form-button-section clearfix">
    <div class="edgtf-input-change"><?php esc_html_e('You should save your changes' , 'elaine') ?></div>
    <div class="edgtf-changes-saved"><?php esc_html_e('All your changes are successfully saved' , 'elaine') ?></div>
    <div class="form-buttom-section-holder" id="anchornav">
        <div class="form-button-section-inner clearfix" >
            <?php if(is_array($page->layout) && count($page->layout)) { ?>
                <div class="edgtf-anchors-holder">
                    <span class="edgtf-page-anchors-label"><?php esc_html_e('Scroll to:' , 'elaine') ?></span>
                    <select class="nav-select edgtf-selectpicker" data-width="315px" data-hide-disabled="true" data-live-search="true" id="edgtf-select-anchor">
                        <option value="" disabled selected></option>
                        <?php foreach ($page->layout as $panel) { ?>
                            <option data-anchor="#edgtf_<?php echo esc_attr($panel->name); ?>"><?php echo esc_html($panel->title); ?></option>
                        <?php } ?>
                    </select>
                </div>
            <?php } ?>
            <div class="edgtf-form-save-holder">
                <input type="submit" class="btn btn-primary btn-sm pull-right" value="<?php esc_attr_e('Save Changes', 'elaine'); ?>"/>
            </div>
        </div>
    </div>
</div>