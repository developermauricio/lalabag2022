<?php

if ( ! function_exists( 'elaine_core_import_object' ) ) {
	function elaine_core_import_object() {
		$elaine_core_import_object = new ElaineCoreImport();
	}
	
	add_action( 'init', 'elaine_core_import_object' );
}

if ( ! function_exists( 'elaine_core_data_import' ) ) {
	function elaine_core_data_import() {
		$importObject = ElaineCoreImport::getInstance();
		
		if ( $_POST['import_attachments'] == 1 ) {
			$importObject->attachments = true;
		} else {
			$importObject->attachments = false;
		}
		
		$folder = "elaine/";
		if ( ! empty( $_POST['example'] ) ) {
			$folder = $_POST['example'] . "/";
		}
		
		$importObject->import_content( $folder . $_POST['xml'] );
		
		die();
	}
	
	add_action( 'wp_ajax_elaine_core_data_import', 'elaine_core_data_import' );
}

if ( ! function_exists( 'elaine_core_widgets_import' ) ) {
	function elaine_core_widgets_import() {
		$importObject = ElaineCoreImport::getInstance();
		
		$folder = "elaine/";
		if ( ! empty( $_POST['example'] ) ) {
			$folder = $_POST['example'] . "/";
		}
		
		$importObject->import_widgets( $folder . 'widgets.txt', $folder . 'custom_sidebars.txt' );
		
		die();
	}
	
	add_action( 'wp_ajax_elaine_core_widgets_import', 'elaine_core_widgets_import' );
}

if ( ! function_exists( 'elaine_core_options_import' ) ) {
	function elaine_core_options_import() {
		$importObject = ElaineCoreImport::getInstance();
		
		$folder = "elaine/";
		if ( ! empty( $_POST['example'] ) ) {
			$folder = $_POST['example'] . "/";
		}
		
		$importObject->import_options( $folder . 'options.txt' );
		
		die();
	}
	
	add_action( 'wp_ajax_elaine_core_options_import', 'elaine_core_options_import' );
}

if ( ! function_exists( 'elaine_core_other_import' ) ) {
	function elaine_core_other_import() {
		$importObject = ElaineCoreImport::getInstance();
		
		$folder = "elaine/";
		if ( ! empty( $_POST['example'] ) ) {
			$folder = $_POST['example'] . "/";
		}
		
		$importObject->import_options( $folder . 'options.txt' );
		$importObject->import_widgets( $folder . 'widgets.txt', $folder . 'custom_sidebars.txt' );
		$importObject->import_menus( $folder . 'menus.txt' );
		$importObject->import_settings_pages( $folder . 'settingpages.txt' );

		$importObject->edgtf_update_meta_fields_after_import($folder);
		$importObject->edgtf_update_options_after_import($folder);

		if ( elaine_core_is_revolution_slider_installed() ) {
			$importObject->rev_slider_import( $folder );
		}
		
		die();
	}
	
	add_action( 'wp_ajax_elaine_core_other_import', 'elaine_core_other_import' );
}