<?php
/*
Class Name: VI_WORDPRESS_LUCKY_WHEEL_Admin_Mailchimp
Author: Andy Ha (support@villatheme.com)
Author URI: http://villatheme.com
Copyright 2015 villatheme.com. All rights reserved.
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class VI_WORDPRESS_LUCKY_WHEEL_Admin_Sendgrid {
	protected $settings;
	protected $api_key;

	function __construct() {
		$this->settings = new VI_WORDPRESS_LUCKY_WHEEL_DATA();
		$this->api_key  =  $this->settings->get_params('sendgrid','key');
	}

	public function get_custom_field() {
		if ( ! $this->api_key ) {
			return;
		}
		$curl = curl_init();

		curl_setopt_array( $curl, array(
			CURLOPT_URL            => "https://api.sendgrid.com/v3/contactdb/custom_fields",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING       => "",
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_TIMEOUT        => 30,
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST  => "GET",
			CURLOPT_POSTFIELDS     => "{}",
			CURLOPT_HTTPHEADER     => array(
				"authorization: Bearer " . $this->api_key
			),
		) );

		$response = curl_exec( $curl );
		$err      = curl_error( $curl );

		curl_close( $curl );

		if ( $err ) {
			echo "cURL Error #:" . $err;
		} else {
			$data = json_decode( $response );
			print_r( $data );
		}
	}

	public function add_custom_field( $name = '', $type = 'text' ) {
		if ( ! $this->api_key ) {
			return;
		}
		if ( ! $name ) {
			return;
		}
		$curl       = curl_init();
		$post_field = array(
			'name' => $name,
			'type' => $type,
		);
		$post_field = json_encode( $post_field );
		$post_field = "$post_field";
		curl_setopt_array( $curl, array(
			CURLOPT_URL            => "https://api.sendgrid.com/v3/contactdb/custom_fields",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING       => "",
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_TIMEOUT        => 30,
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST  => "POST",
			CURLOPT_POSTFIELDS     => $post_field,
			CURLOPT_HTTPHEADER     => array(
				"authorization: Bearer " . $this->api_key,
				"content-type: application/json"
			),
		) );

		$response = curl_exec( $curl );
		$err      = curl_error( $curl );
		curl_close( $curl );
		if ( $err ) {
			echo "cURL Error #:" . $err;
		} else {
			$data = json_decode( $response );
			print_r( $data );
		}
	}

	public function get_list_id( $list = '' ) {
		if ( ! $this->api_key ) {
			return '';
		}
		if ( ! $list ) {
			return '';
		}
		$post_field = "{}";
		$url        = "https://api.sendgrid.com/v3/contactdb/lists";
		$curl       = curl_init();
		curl_setopt_array( $curl, array(
			CURLOPT_URL            => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING       => "",
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_TIMEOUT        => 30,
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST  => "GET",
			CURLOPT_POSTFIELDS     => $post_field,
			CURLOPT_HTTPHEADER     => array(
				"authorization: Bearer " . $this->api_key,
			),
		) );

		$response = curl_exec( $curl );
		$err      = curl_error( $curl );

		curl_close( $curl );

		if ( ! $err ) {
			$data = json_decode( $response );
			if ( count( $data->lists ) ) {
				foreach ( $data->lists as $item ) {
					if ( isset( $item->name ) && $list == $item->name ) {
						return isset( $item->id ) ? $item->id : '';
					}
				}
			}

		}

		return '';
	}

	public function get_lists() {
		if ( ! $this->api_key ) {
			return array();
		}

		$post_field = "{}";
		$url        = "https://api.sendgrid.com/v3/contactdb/lists";
		$curl       = curl_init();
		curl_setopt_array( $curl, array(
			CURLOPT_URL            => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING       => "",
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_TIMEOUT        => 30,
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST  => "GET",
			CURLOPT_POSTFIELDS     => $post_field,
			CURLOPT_HTTPHEADER     => array(
				"authorization: Bearer " . $this->api_key,
			),
		) );

		$response = curl_exec( $curl );
		$err      = curl_error( $curl );

		curl_close( $curl );

		if ( ! $err ) {
			$data = json_decode( $response );
			if ( count( $data->lists ) ) {
				return $data->lists;
			}

		}

		return array();
	}

	public function add_recipient( $email = '', $firstname = '', $lastname = '' ) {
		if ( ! $this->api_key ) {
			return;
		}
		if ( ! $email ) {
			return;
		}
		$curl       = curl_init();
		$post_field = array(
			'email'      => $email,
			'first_name' => $firstname,
			'last_name'  => $lastname,
		);
		$post_field = json_encode( $post_field );
		$post_field = "[$post_field]";
		$url        = "https://api.sendgrid.com/v3/contactdb/recipients";
		curl_setopt_array( $curl, array(
			CURLOPT_URL            => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING       => "",
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_TIMEOUT        => 30,
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST  => "POST",
			CURLOPT_POSTFIELDS     => $post_field,
			CURLOPT_HTTPHEADER     => array(
				"authorization: Bearer " . $this->api_key,
				"content-type: application/json"
			),
		) );
		$response = curl_exec( $curl );
		$err      = curl_error( $curl );
		curl_close( $curl );
	}

	public function add_recipient_to_list( $email = '', $list_id = '' ) {
		if ( ! $this->api_key ) {
			return;
		}
		if ( ! $email || ! $list_id ) {
			return;
		}
		$curl       = curl_init();
		$post_field = "null";
		$url        = "https://api.sendgrid.com/v3/contactdb/lists/$list_id/recipients/" . base64_encode( $email );
		curl_setopt_array( $curl, array(
			CURLOPT_URL            => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING       => "",
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_TIMEOUT        => 30,
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST  => "POST",
			CURLOPT_POSTFIELDS     => $post_field,
			CURLOPT_HTTPHEADER     => array(
				"authorization: Bearer " . $this->api_key,
			),
		) );
		$response = curl_exec( $curl );
		$err      = curl_error( $curl );
		curl_close( $curl );
	}
}
