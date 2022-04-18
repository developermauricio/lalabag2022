<?php if(elaine_edge_core_plugin_installed()) { ?>
    <div class="edgtf-blog-like">
        <?php if( function_exists('elaine_edge_get_like') ) elaine_edge_get_like(); ?>
    </div>
<?php } ?>