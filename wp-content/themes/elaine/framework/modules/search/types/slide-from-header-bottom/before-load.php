<?php

if ( ! function_exists( 'elaine_edge_set_search_slide_from_hb_global_option' ) ) {
    /**
     * This function set search type value for search options map
     */
    function elaine_edge_set_search_slide_from_hb_global_option( $search_type_options ) {
        $search_type_options['slide-from-header-bottom'] = esc_html__( 'Slide From Header Bottom', 'elaine' );

        return $search_type_options;
    }

    add_filter( 'elaine_edge_filter_search_type_global_option', 'elaine_edge_set_search_slide_from_hb_global_option' );
}