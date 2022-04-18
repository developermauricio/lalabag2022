<?php

elaine_edge_get_single_post_format_html( $blog_single_type );

do_action( 'elaine_edge_action_after_article_content' );

elaine_edge_get_module_template_part( 'templates/parts/single/author-info', 'blog' );

elaine_edge_get_module_template_part( 'templates/parts/single/single-navigation', 'blog' );

elaine_edge_get_module_template_part( 'templates/parts/single/related-posts', 'blog', '', $single_info_params );

elaine_edge_get_module_template_part( 'templates/parts/single/comments', 'blog' );