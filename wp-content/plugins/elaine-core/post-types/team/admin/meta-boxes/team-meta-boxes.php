<?php

if ( ! function_exists( 'elaine_core_map_team_single_meta' ) ) {
	function elaine_core_map_team_single_meta() {
		
		$meta_box = elaine_edge_create_meta_box(
			array(
				'scope' => 'team-member',
				'title' => esc_html__( 'Team Member Info', 'elaine-core' ),
				'name'  => 'team_meta'
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'        => 'edgtf_team_member_position',
				'type'        => 'text',
				'label'       => esc_html__( 'Position', 'elaine-core' ),
				'description' => esc_html__( 'The members\'s role within the team', 'elaine-core' ),
				'parent'      => $meta_box
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'        => 'edgtf_team_member_birth_date',
				'type'        => 'date',
				'label'       => esc_html__( 'Birth date', 'elaine-core' ),
				'description' => esc_html__( 'The members\'s birth date', 'elaine-core' ),
				'parent'      => $meta_box
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'        => 'edgtf_team_member_email',
				'type'        => 'text',
				'label'       => esc_html__( 'Email', 'elaine-core' ),
				'description' => esc_html__( 'The members\'s email', 'elaine-core' ),
				'parent'      => $meta_box
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'        => 'edgtf_team_member_phone',
				'type'        => 'text',
				'label'       => esc_html__( 'Phone', 'elaine-core' ),
				'description' => esc_html__( 'The members\'s phone', 'elaine-core' ),
				'parent'      => $meta_box
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'        => 'edgtf_team_member_address',
				'type'        => 'text',
				'label'       => esc_html__( 'Address', 'elaine-core' ),
				'description' => esc_html__( 'The members\'s addres', 'elaine-core' ),
				'parent'      => $meta_box
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'        => 'edgtf_team_member_education',
				'type'        => 'text',
				'label'       => esc_html__( 'Education', 'elaine-core' ),
				'description' => esc_html__( 'The members\'s education', 'elaine-core' ),
				'parent'      => $meta_box
			)
		);
		
		elaine_edge_create_meta_box_field(
			array(
				'name'        => 'edgtf_team_member_resume',
				'type'        => 'file',
				'label'       => esc_html__( 'Resume', 'elaine-core' ),
				'description' => esc_html__( 'Upload members\'s resume', 'elaine-core' ),
				'parent'      => $meta_box
			)
		);
		
		for ( $x = 1; $x < 6; $x ++ ) {
			
			$social_icon_group = elaine_edge_add_admin_group(
				array(
					'name'   => 'edgtf_team_member_social_icon_group' . $x,
					'title'  => esc_html__( 'Social Link ', 'elaine-core' ) . $x,
					'parent' => $meta_box
				)
			);
			
			$social_row1 = elaine_edge_add_admin_row(
				array(
					'name'   => 'edgtf_team_member_social_icon_row1' . $x,
					'parent' => $social_icon_group
				)
			);
			
			elaine_edge_icon_collections()->getIconsMetaBoxOrOption(
				array(
					'label'            => esc_html__( 'Icon ', 'elaine-core' ) . $x,
					'parent'           => $social_row1,
					'name'             => 'edgtf_team_member_social_icon_pack_' . $x,
					'defaul_icon_pack' => '',
					'type'             => 'meta-box',
					'field_type'       => 'simple'
				)
			);
			
			$social_row2 = elaine_edge_add_admin_row(
				array(
					'name'   => 'edgtf_team_member_social_icon_row2' . $x,
					'parent' => $social_icon_group
				)
			);
			
			elaine_edge_create_meta_box_field(
				array(
					'type'            => 'textsimple',
					'label'           => esc_html__( 'Link', 'elaine-core' ),
					'name'            => 'edgtf_team_member_social_icon_' . $x . '_link',
					'parent'          => $social_row2,
					'dependency' => array(
						'hide' => array(
							'edgtf_team_member_social_icon_pack_'. $x  => ''
						)
					)
				)
			);
			
			elaine_edge_create_meta_box_field(
				array(
					'type'            => 'selectsimple',
					'label'           => esc_html__( 'Target', 'elaine-core' ),
					'name'            => 'edgtf_team_member_social_icon_' . $x . '_target',
					'options'         => elaine_edge_get_link_target_array(),
					'parent'          => $social_row2,
					'dependency' => array(
						'hide' => array(
							'edgtf_team_member_social_icon_' . $x . '_link'  => ''
						)
					)
				)
			);
		}
	}
	
	add_action( 'elaine_edge_action_meta_boxes_map', 'elaine_core_map_team_single_meta', 46 );
}