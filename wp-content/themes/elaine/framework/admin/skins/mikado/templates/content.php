<div class="edgtf-tabs-content">
    <div class="tab-content">
        <div class="tab-pane fade<?php if ($page->slug == $tab) echo " in active"; ?>">
            <div class="edgtf-tab-content">
                <div class="edgtf-page-title-holder clearfix">
                    <h2 class="edgtf-page-title"><?php echo esc_html($page->title); ?></h2>
                    <?php
	                    if($showAnchors) {
	                        $this->getAnchors($page);
	                    }
                    ?>
                </div>
                <form method="post" class="edgtf_ajax_form">
					<?php wp_nonce_field("edgtf_ajax_save_nonce","edgtf_ajax_save_nonce") ?>
                    <div class="edgtf-page-form">
                        <?php $page->render(); ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>