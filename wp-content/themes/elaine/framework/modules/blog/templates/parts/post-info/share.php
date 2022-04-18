<?php
    $share_type = isset( $share_type ) ? $share_type : 'list';
?>

<?php if ( elaine_edge_core_plugin_installed() && elaine_edge_options()->getOptionValue( 'enable_social_share' ) === 'yes' && elaine_edge_options()->getOptionValue( 'enable_social_share_on_post' ) === 'yes' ) { ?>
    <div class="edgtf-blog-share">
		<?php echo elaine_edge_get_social_share_html( array( 'type' => $share_type ) ); ?>
    </div>
<?php } ?>