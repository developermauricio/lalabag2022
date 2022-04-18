<?php
namespace ElaineCore\CPT\Shortcodes\GalleryBlocks;

use ElaineCore\Lib;

class GalleryBlocks implements Lib\ShortcodeInterface {
	private $base;
	
	public function __construct() {
		$this->base = 'edgtf_gallery_blocks';
		
		add_action( 'vc_before_init', array( $this, 'vcMap' ) );
	}
	
	public function getBase() {
		return $this->base;
	}
	
	public function vcMap() {
		if ( function_exists( 'vc_map' ) ) {
			vc_map(
				array(
					'name'                      => esc_html__( 'Gallery Blocks', 'elaine-core' ),
					'base'                      => $this->getBase(),
					'category'                  => esc_html__( 'by ELAINE', 'elaine-core' ),
					'icon'                      => 'icon-wpb-gallery-blocks extended-custom-icon',
					'allowed_container_element' => 'vc_row',
					'params'                    => array(
						array(
							'type'        => 'textfield',
							'param_name'  => 'custom_class',
							'heading'     => esc_html__( 'Custom CSS Class', 'elaine-core' ),
							'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS', 'elaine-core' )
						),
						array(
							'type'        => 'attach_images',
							'param_name'  => 'images',
							'heading'     => esc_html__( 'Images', 'elaine-core' ),
							'description' => esc_html__( 'Select images from media library. The first image you upload will be set as the featured image if you set Featured Image Size.', 'elaine-core' )
						),
						array(
							'type'        => 'textfield',
							'param_name'  => 'featured_image_size',
							'heading'     => esc_html__( 'Featured Image Size', 'elaine-core' ),
							'description' => esc_html__( 'Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size', 'elaine-core' )
						),
						array(
							'type'        => 'textfield',
							'param_name'  => 'image_size',
							'heading'     => esc_html__( 'Image Size', 'elaine-core' ),
							'description' => esc_html__( 'Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size', 'elaine-core' )
						),
						array(
							'type'       => 'dropdown',
							'param_name' => 'enable_lightbox',
							'heading'    => esc_html__( 'Enable Lightbox Functionality', 'elaine-core' ),
							'value'      => array_flip( elaine_edge_get_yes_no_select_array( false ) )
						),
						array(
							'type'        => 'dropdown',
							'param_name'  => 'space_between_items',
							'heading'     => esc_html__( 'Space Between Items', 'elaine-core' ),
							'value'       => array_flip( elaine_edge_get_space_between_items_array() ),
							'save_always' => true
						)
					)
				)
			);
		}
	}
	
	public function render( $atts, $content = null ) {
		$args   = array(
			'custom_class'        => '',
			'images'              => '',
			'featured_image_size' => '',
			'image_size'          => 'full',
			'enable_lightbox'     => '',
			'space_between_items' => 'normal'
		);
		$params = shortcode_atts( $args, $atts );
		
		$params['holder_classes']      = $this->getHolderClasses( $params, $args );
		$params['images']              = $this->getImages( $params );
		$params['featured_image_size'] = $this->getFeaturedImageSize( $params['featured_image_size'] );
		$params['image_size']          = $this->getImageSize( $params['image_size'] );
		$params['enable_lightbox']     = ( $params['enable_lightbox'] === 'yes' ) ? true : false;
		
		$html = elaine_core_get_shortcode_module_template_part( 'templates/gallery-blocks', 'gallery-blocks', '', $params );
		
		return $html;
	}
	
	private function getHolderClasses( $params, $args ) {
		$holderClasses = array();
		
		$holderClasses[] = ! empty( $params['custom_class'] ) ? esc_attr( $params['custom_class'] ) : '';
		$holderClasses[] = ! empty( $params['space_between_items'] ) ? 'edgtf-' . $params['space_between_items'] . '-space' : 'edgtf-' . $args['space_between_items'] . '-space';
		
		return implode( ' ', $holderClasses );
	}
	
	private function getImages( $params ) {
		$image_ids = array();
		$images    = array();
		
		if ( $params['images'] !== '' ) {
			$image_ids = explode( ',', $params['images'] );
		}
		
		foreach ( $image_ids as $id ) {
			$image['id']    = $id;
			$image_original = wp_get_attachment_image_src( $id, 'full' );
			$image['url']   = $image_original[0];
			$image['alt']   = get_post_meta( $id, '_wp_attachment_image_alt', true );
			
			$images[] = $image;
		}
		
		return $images;
	}
	
	private function getFeaturedImageSize( $featured_image_size ) {
		$featured_image_size = trim( $featured_image_size );
		//Find digits
		preg_match_all( '/\d+/', $featured_image_size, $matches );
		if ( in_array( $featured_image_size, array( 'thumbnail', 'thumb', 'medium', 'large', 'full' ) ) ) {
			return $featured_image_size;
		} elseif ( ! empty( $matches[0] ) ) {
			return array(
				$matches[0][0],
				$matches[0][1]
			);
		} else {
			return 'no-image';
		}
	}
	
	private function getImageSize( $image_size ) {
		$image_size = trim( $image_size );
		//Find digits
		preg_match_all( '/\d+/', $image_size, $matches );
		if ( in_array( $image_size, array( 'thumbnail', 'thumb', 'medium', 'large', 'full' ) ) ) {
			return $image_size;
		} elseif ( ! empty( $matches[0] ) ) {
			return array(
				$matches[0][0],
				$matches[0][1]
			);
		} else {
			return 'thumbnail';
		}
	}
}