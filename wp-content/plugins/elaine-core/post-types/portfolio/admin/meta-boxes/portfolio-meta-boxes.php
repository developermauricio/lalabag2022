<?php

if ( ! function_exists( 'elaine_core_map_portfolio_meta' ) ) {
	function elaine_core_map_portfolio_meta() {
		global $elaine_edge_global_Framework;
		
		$elaine_pages = array();
		$pages      = get_pages();
		foreach ( $pages as $page ) {
			$elaine_pages[ $page->ID ] = $page->post_title;
		}
		
		//Portfolio Images
		
		$elaine_portfolio_images = new ElaineEdgeClassMetaBox( 'portfolio-item', esc_html__( 'Portfolio Images (multiple upload)', 'elaine-core' ), '', '', 'portfolio_images' );
		$elaine_edge_global_Framework->edgtMetaBoxes->addMetaBox( 'portfolio_images', $elaine_portfolio_images );
		
		$elaine_portfolio_image_gallery = new ElaineEdgeClassMultipleImages( 'edgtf-portfolio-image-gallery', esc_html__( 'Portfolio Images', 'elaine-core' ), esc_html__( 'Choose your portfolio images', 'elaine-core' ) );
		$elaine_portfolio_images->addChild( 'edgtf-portfolio-image-gallery', $elaine_portfolio_image_gallery );
		
		//Portfolio Single Upload Images/Videos 
		
		$elaine_portfolio_images_videos = elaine_edge_create_meta_box(
			array(
				'scope' => array( 'portfolio-item' ),
				'title' => esc_html__( 'Portfolio Images/Videos (single upload)', 'elaine-core' ),
				'name'  => 'edgtf_portfolio_images_videos'
			)
		);
		elaine_edge_add_repeater_field(
			array(
				'name'        => 'edgtf_portfolio_single_upload',
				'parent'      => $elaine_portfolio_images_videos,
				'button_text' => esc_html__( 'Add Image/Video', 'elaine-core' ),
				'fields'      => array(
					array(
						'type'        => 'select',
						'name'        => 'file_type',
						'label'       => esc_html__( 'File Type', 'elaine-core' ),
						'options' => array(
							'image' => esc_html__('Image','elaine-core'),
							'video' => esc_html__('Video','elaine-core'),
						)
					),
					array(
						'type'        => 'image',
						'name'        => 'single_image',
						'label'       => esc_html__( 'Image', 'elaine-core' ),
						'dependency' => array(
							'show' => array(
								'file_type'  => 'image'
							)
						)
					),
					array(
						'type'        => 'select',
						'name'        => 'video_type',
						'label'       => esc_html__( 'Video Type', 'elaine-core' ),
						'options'	  => array(
							'youtube' => esc_html__('YouTube', 'elaine-core'),
							'vimeo' => esc_html__('Vimeo', 'elaine-core'),
							'self' => esc_html__('Self Hosted', 'elaine-core'),
						),
						'dependency' => array(
							'show' => array(
								'file_type'  => 'video'
							)
						)
					),
					array(
						'type'        => 'text',
						'name'        => 'video_id',
						'label'       => esc_html__( 'Video ID', 'elaine-core' ),
						'dependency' => array(
							'show' => array(
								'file_type' => 'video',
								'video_type'  => array('youtube','vimeo')
							)
						)
					),
					array(
						'type'        => 'text',
						'name'        => 'video_mp4',
						'label'       => esc_html__( 'Video mp4', 'elaine-core' ),
						'dependency' => array(
							'show' => array(
								'file_type' => 'video',
								'video_type'  => 'self'
							)
						)
					),
					array(
						'type'        => 'image',
						'name'        => 'video_cover_image',
						'label'       => esc_html__( 'Video Cover Image', 'elaine-core' ),
						'dependency' => array(
							'show' => array(
								'file_type' => 'video',
								'video_type'  => 'self'
							)
						)
					)
				)
			)
		);
		
		//Portfolio Additional Sidebar Items
		
		$elaine_additional_sidebar_items = elaine_edge_create_meta_box(
			array(
				'scope' => array( 'portfolio-item' ),
				'title' => esc_html__( 'Additional Portfolio Sidebar Items', 'elaine-core' ),
				'name'  => 'portfolio_properties'
			)
		);

		elaine_edge_add_repeater_field(
			array(
				'name'        => 'edgtf_portfolio_properties',
				'parent'      => $elaine_additional_sidebar_items,
				'button_text' => esc_html__( 'Add New Item', 'elaine-core' ),
				'fields'      => array(
					array(
						'type'        => 'text',
						'name'        => 'item_title',
						'label'       => esc_html__( 'Item Title', 'elaine-core' ),
					),
					array(
						'type'        => 'text',
						'name'        => 'item_text',
						'label'       => esc_html__( 'Item Text', 'elaine-core' )
					),
					array(
						'type'        => 'text',
						'name'        => 'item_url',
						'label'       => esc_html__( 'Enter Full URL for Item Text Link', 'elaine-core' )
					)
				)
			)
		);
	}
	
	add_action( 'elaine_edge_action_meta_boxes_map', 'elaine_core_map_portfolio_meta', 40 );
}