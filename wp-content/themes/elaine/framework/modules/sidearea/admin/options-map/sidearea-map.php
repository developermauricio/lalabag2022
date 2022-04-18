<?php

if ( ! function_exists( 'elaine_edge_sidearea_options_map' ) ) {
	function elaine_edge_sidearea_options_map() {

        elaine_edge_add_admin_page(
            array(
                'slug'  => '_side_area_page',
                'title' => esc_html__('Side Area', 'elaine'),
                'icon'  => 'fa fa-indent'
            )
        );

        $side_area_panel = elaine_edge_add_admin_panel(
            array(
                'title' => esc_html__('Side Area', 'elaine'),
                'name'  => 'side_area',
                'page'  => '_side_area_page'
            )
        );

        elaine_edge_add_admin_field(
            array(
                'parent'        => $side_area_panel,
                'type'          => 'select',
                'name'          => 'side_area_type',
                'default_value' => 'side-menu-slide-from-right',
                'label'         => esc_html__('Side Area Type', 'elaine'),
                'description'   => esc_html__('Choose a type of Side Area', 'elaine'),
                'options'       => array(
                    'side-menu-slide-from-right'       => esc_html__('Slide from Right Over Content', 'elaine'),
                    'side-menu-slide-with-content'     => esc_html__('Slide from Right With Content', 'elaine'),
                    'side-area-uncovered-from-content' => esc_html__('Side Area Uncovered from Content', 'elaine'),
                ),
            )
        );

        elaine_edge_add_admin_field(
            array(
                'parent'        => $side_area_panel,
                'type'          => 'text',
                'name'          => 'side_area_width',
                'default_value' => '',
                'label'         => esc_html__('Side Area Width', 'elaine'),
                'description'   => esc_html__('Enter a width for Side Area (px or %). Default width: 405px.', 'elaine'),
                'args'          => array(
                    'col_width' => 3,
                )
            )
        );

        $side_area_width_container = elaine_edge_add_admin_container(
            array(
                'parent'     => $side_area_panel,
                'name'       => 'side_area_width_container',
                'dependency' => array(
                    'show' => array(
                        'side_area_type' => 'side-menu-slide-from-right',
                    )
                )
            )
        );

        elaine_edge_add_admin_field(
            array(
                'parent'        => $side_area_width_container,
                'type'          => 'color',
                'name'          => 'side_area_content_overlay_color',
                'default_value' => '',
                'label'         => esc_html__('Content Overlay Background Color', 'elaine'),
                'description'   => esc_html__('Choose a background color for a content overlay', 'elaine'),
            )
        );

        elaine_edge_add_admin_field(
            array(
                'parent'        => $side_area_width_container,
                'type'          => 'text',
                'name'          => 'side_area_content_overlay_opacity',
                'default_value' => '',
                'label'         => esc_html__('Content Overlay Background Transparency', 'elaine'),
                'description'   => esc_html__('Choose a transparency for the content overlay background color (0 = fully transparent, 1 = opaque)', 'elaine'),
                'args'          => array(
                    'col_width' => 3
                )
            )
        );

        elaine_edge_add_admin_field(
            array(
                'parent'        => $side_area_panel,
                'type'          => 'select',
                'name'          => 'side_area_icon_source',
                'default_value' => 'icon_pack',
                'label'         => esc_html__('Select Side Area Icon Source', 'elaine'),
                'description'   => esc_html__('Choose whether you would like to use icons from an icon pack or SVG icons', 'elaine'),
                'options'       => elaine_edge_get_icon_sources_array()
            )
        );

        $side_area_icon_pack_container = elaine_edge_add_admin_container(
            array(
                'parent'     => $side_area_panel,
                'name'       => 'side_area_icon_pack_container',
                'dependency' => array(
                    'show' => array(
                        'side_area_icon_source' => 'icon_pack'
                    )
                )
            )
        );

        elaine_edge_add_admin_field(
            array(
                'parent'        => $side_area_icon_pack_container,
                'type'          => 'select',
                'name'          => 'side_area_icon_pack',
                'default_value' => 'font_elegant',
                'label'         => esc_html__('Side Area Icon Pack', 'elaine'),
                'description'   => esc_html__('Choose icon pack for Side Area icon', 'elaine'),
                'options'       => elaine_edge_icon_collections()->getIconCollectionsExclude(array('linea_icons', 'dripicons', 'simple_line_icons'))
            )
        );

        $side_area_svg_icons_container = elaine_edge_add_admin_container(
            array(
                'parent'     => $side_area_panel,
                'name'       => 'side_area_svg_icons_container',
                'dependency' => array(
                    'show' => array(
                        'side_area_icon_source' => 'svg_path'
                    )
                )
            )
        );

        elaine_edge_add_admin_field(
            array(
                'parent'      => $side_area_svg_icons_container,
                'type'        => 'textarea',
                'name'        => 'side_area_icon_svg_path',
                'label'       => esc_html__('Side Area Icon SVG Path', 'elaine'),
                'description' => esc_html__('Enter your Side Area icon SVG path here. Please remove version and id attributes from your SVG path because of HTML validation', 'elaine'),
            )
        );

        elaine_edge_add_admin_field(
            array(
                'parent'      => $side_area_svg_icons_container,
                'type'        => 'textarea',
                'name'        => 'side_area_close_icon_svg_path',
                'label'       => esc_html__('Side Area Close Icon SVG Path', 'elaine'),
                'description' => esc_html__('Enter your Side Area close icon SVG path here. Please remove version and id attributes from your SVG path because of HTML validation', 'elaine'),
            )
        );

        $side_area_icon_style_group = elaine_edge_add_admin_group(
            array(
                'parent'      => $side_area_panel,
                'name'        => 'side_area_icon_style_group',
                'title'       => esc_html__('Side Area Icon Style', 'elaine'),
                'description' => esc_html__('Define styles for Side Area icon', 'elaine')
            )
        );

        $side_area_icon_style_row1 = elaine_edge_add_admin_row(
            array(
                'parent' => $side_area_icon_style_group,
                'name'   => 'side_area_icon_style_row1'
            )
        );

        elaine_edge_add_admin_field(
            array(
                'parent' => $side_area_icon_style_row1,
                'type'   => 'colorsimple',
                'name'   => 'side_area_icon_color',
                'label'  => esc_html__('Color', 'elaine')
            )
        );

        elaine_edge_add_admin_field(
            array(
                'parent' => $side_area_icon_style_row1,
                'type'   => 'colorsimple',
                'name'   => 'side_area_icon_hover_color',
                'label'  => esc_html__('Hover Color', 'elaine')
            )
        );

        $side_area_icon_style_row2 = elaine_edge_add_admin_row(
            array(
                'parent' => $side_area_icon_style_group,
                'name'   => 'side_area_icon_style_row2',
                'next'   => true
            )
        );

        elaine_edge_add_admin_field(
            array(
                'parent' => $side_area_icon_style_row2,
                'type'   => 'colorsimple',
                'name'   => 'side_area_close_icon_color',
                'label'  => esc_html__('Close Icon Color', 'elaine')
            )
        );

        elaine_edge_add_admin_field(
            array(
                'parent' => $side_area_icon_style_row2,
                'type'   => 'colorsimple',
                'name'   => 'side_area_close_icon_hover_color',
                'label'  => esc_html__('Close Icon Hover Color', 'elaine')
            )
        );

        elaine_edge_add_admin_field(
            array(
                'parent'      => $side_area_panel,
                'type'        => 'color',
                'name'        => 'side_area_background_color',
                'label'       => esc_html__('Background Color', 'elaine'),
                'description' => esc_html__('Choose a background color for Side Area', 'elaine')
            )
        );

        elaine_edge_add_admin_field(
            array(
                'parent'      => $side_area_panel,
                'type'        => 'text',
                'name'        => 'side_area_padding',
                'label'       => esc_html__('Padding', 'elaine'),
                'description' => esc_html__('Define padding for Side Area in format top right bottom left', 'elaine'),
                'args'        => array(
                    'col_width' => 3
                )
            )
        );

        elaine_edge_add_admin_field(
            array(
                'parent'        => $side_area_panel,
                'type'          => 'selectblank',
                'name'          => 'side_area_aligment',
                'default_value' => '',
                'label'         => esc_html__('Text Alignment', 'elaine'),
                'description'   => esc_html__('Choose text alignment for side area', 'elaine'),
                'options'       => array(
                    ''       => esc_html__('Default', 'elaine'),
                    'left'   => esc_html__('Left', 'elaine'),
                    'center' => esc_html__('Center', 'elaine'),
                    'right'  => esc_html__('Right', 'elaine')
                )
            )
        );
    }

    add_action('elaine_edge_action_options_map', 'elaine_edge_sidearea_options_map', elaine_edge_set_options_map_position( 'sidearea' ) );
}