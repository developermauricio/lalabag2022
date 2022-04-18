<?php
/*
Class Name: VI_WORDPRESS_LUCKY_WHEEL_Admin_Admin
Author: Andy Ha (support@villatheme.com)
Author URI: http://villatheme.com
Copyright 2015 villatheme.com. All rights reserved.
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class VI_WORDPRESS_LUCKY_WHEEL_Admin_Admin {
	protected $settings;
	protected $languages;
	protected $default_language;
	protected $languages_data;

	function __construct() {
		$this->settings         = new VI_WORDPRESS_LUCKY_WHEEL_DATA();
		$this->languages        = array();
		$this->languages_data   = array();
		$this->default_language = '';
		add_action( 'admin_menu', array( $this, 'add_menu' ) );
		add_action( 'admin_init', array( $this, 'save_settings' ) );
		add_action( 'admin_init', array( $this, 'check_update' ) );
		add_action( 'admin_init', array( $this, 'export_emails' ) );
		add_action( 'wp_ajax_wplwl_search_active_campaign_list', array( $this, 'search_active_campaign_list' ) );
		add_action( 'wp_ajax_wplwl_preview_emails', array( $this, 'preview_emails_ajax' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_action( 'media_buttons', array( $this, 'preview_emails_button' ) );
		add_action( 'admin_footer', array( $this, 'preview_emails_html' ) );

	}

	function preview_emails_html() {
		global $pagenow;
		if ( $pagenow == 'admin.php' && isset( $_REQUEST['page'] ) && $_REQUEST['page'] == 'wordpress-lucky-wheel' ) {
			?>
            <div class="preview-emails-html-container preview-html-hidden">
                <div class="preview-emails-html-overlay"></div>
                <div class="preview-emails-html"></div>
            </div>
			<?php
		}
	}

	function add_menu() {
		add_menu_page(
			esc_html__( 'WordPress Lucky Wheel', 'wordpress-lucky-wheel' ), esc_html__( 'WP Lucky Wheel', 'wordpress-lucky-wheel' ), 'manage_options', 'wordpress-lucky-wheel', array(
			$this,
			'settings_page'
		), 'dashicons-wheel', 2
		);
		add_submenu_page( 'wordpress-lucky-wheel', esc_html__( 'Emails', 'wordpress-lucky-wheel' ), esc_html__( 'Emails', 'wordpress-lucky-wheel' ), 'manage_options', 'edit.php?post_type=wplwl_email' );
		add_submenu_page(
			'wordpress-lucky-wheel', esc_html__( 'Report', 'wordpress-lucky-wheel' ), esc_html__( 'Report', 'wordpress-lucky-wheel' ), 'manage_options', 'wplwl-report', array(
				$this,
				'report_callback'
			)
		);
		add_submenu_page(
			'wordpress-lucky-wheel', esc_html__( 'System Status', 'wordpress-lucky-wheel' ), esc_html__( 'System Status', 'wordpress-lucky-wheel' ), 'manage_options', 'wplwl-system-status', array(
				$this,
				'system_status'
			)
		);
	}


	public function preview_emails_button( $editor_id ) {
		global $pagenow;
		if ( $pagenow == 'admin.php' && isset( $_REQUEST['page'] ) && $_REQUEST['page'] == 'wordpress-lucky-wheel' ) {
			$editor_ids = array( 'content' );
			if ( count( $this->languages ) ) {
				foreach ( $this->languages as $key => $value ) {
					$editor_ids[] = 'content_' . $value;
				}
			}
			if ( in_array( $editor_id, $editor_ids ) ) {
				ob_start();
				?>
                <span class="button wplwl-preview-emails-button"
                      data-wplwl_language="<?php echo str_replace( 'content', '', $editor_id ) ?>"><?php esc_html_e( 'Preview emails', 'wordpress-lucky-wheel' ) ?></span>
				<?php
				echo ob_get_clean();
			}
		}
	}

	public function preview_emails_ajax() {
		$date_format   = get_option( 'date_format', 'F d, Y' );
		$date          = new DateTime();
		$now           = $date->format( $date_format );
		$content       = isset( $_GET['content'] ) ? wp_kses_post( stripslashes( $_GET['content'] ) ) : '';
		$email_heading = isset( $_GET['heading'] ) ? ( stripslashes( $_GET['heading'] ) ) : '';
		$bg            = isset( $_GET['email_background_color'] ) ? $_GET['email_background_color'] : '';
		$body          = isset( $_GET['email_body_background_color'] ) ? $_GET['email_body_background_color'] : '';
		$base          = isset( $_GET['email_base_color'] ) ? $_GET['email_base_color'] : '';
		$text          = isset( $_GET['email_body_text_color'] ) ? $_GET['email_body_text_color'] : '';
		$img           = isset( $_GET['header_image'] ) ? $_GET['header_image'] : '';
		$footer_text   = isset( $_GET['footer_text'] ) ? wpautop( wp_kses_post( wptexturize( $_GET['footer_text'] ) ) ) : '';

		$label           = 'HAPPY NEW YEAR 2019';
		$value           = 'happy_abc_xyz_123';
		$customer_name   = 'John';
		$customer_mobile = '0123456789';
		$content         = str_replace( '{prize_label}', $label, $content );
		$content         = str_replace( '{customer_name}', $customer_name, $content );
		$content         = str_replace( '{customer_mobile}', $customer_mobile, $content );
		$content         = str_replace( '{prize_value}', $value, $content );
		$content         = str_replace( '{today}', $now, $content );

		ob_start();
		?>
        <!DOCTYPE html>
        <html <?php language_attributes(); ?>>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>"/>
            <title><?php echo get_bloginfo( 'name', 'display' ); ?></title>
        </head>
        <body <?php echo is_rtl() ? 'rightmargin' : 'leftmargin'; ?>="0" marginwidth="0" topmargin="0"
        marginheight=
        "0" offset="0">
        <div id="wrapper" dir="<?php echo is_rtl() ? 'rtl' : 'ltr' ?>"
             style="background-color: <?php echo esc_attr( $bg ); ?>;
                     margin: 0;
                     padding: 70px 0 70px 0;
                     -webkit-text-size-adjust: none !important;
                     width: 100%;">
            <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                <tr>
                    <td align="center" valign="top">
                        <div id="template_header_image">
							<?php
							if ( $img ) {
								echo '<p style="margin-top:0;"><img src="' . esc_url( $img ) . '" alt="' . get_bloginfo( 'name', 'display' ) . '" /></p>';
							}
							?>
                        </div>
                        <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_container"
                               style="box-shadow: 0 1px 4px rgba(0,0,0,0.1) !important;
                                       background-color: <?php echo esc_attr( $body ); ?>;
                                       border-radius: 3px !important;">
                            <tr>
                                <td align="center" valign="top">
                                    <!-- Header -->
                                    <table border="0" cellpadding="0" cellspacing="0" width="600"
                                           id="template_header"
                                           style="background-color: <?php echo esc_attr( $base ); ?>;
                                                   border-radius: 3px 3px 0 0 !important;
                                                   border-bottom: 0;
                                                   font-weight: bold;
                                                   line-height: 100%;
                                                   vertical-align: middle;
                                                   font-family: Helvetica, Roboto, Arial, sans-serif;">
                                        <tr>
                                            <td id="header_wrapper" style="padding: 36px 48px;
	display: block;">
                                                <h1><?php echo $email_heading; ?></h1>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- End Header -->
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <!-- Body -->
                                    <table border="0" cellpadding="0" cellspacing="0" width="600"
                                           id="template_body">
                                        <tr>
                                            <td valign="top" id="body_content"
                                                style="background-color: <?php echo esc_attr( $body ); ?>;">
                                                <!-- Content -->
                                                <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td valign="top" style="padding: 48px;">
                                                            <div id="body_content_inner" style="
                                                                    font-family: Helvetica, Roboto, Arial, sans-serif;
                                                                    font-size: 14px;
                                                                    line-height: 150%;
                                                                    text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;">
                                                                <div class="text"
                                                                     style="color: <?php echo esc_attr( $text ); ?>;
                                                                             font-family: Helvetica, Roboto, Arial, sans-serif;">
																	<?php
																	echo $content;
																	?>

                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!-- End Content -->
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- End Body -->
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <!-- Footer -->
                                    <table border="0" cellpadding="10" cellspacing="0" width="600"
                                           id="template_footer">
                                        <tr>
                                            <td valign="top">
                                                <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td colspan="2" valign="middle" id="credit" style="border:0;
                                                                font-family: Arial;
                                                                font-size:12px;
                                                                line-height:125%;
                                                                text-align:center;
                                                                padding: 0 48px 48px 48px;">
															<?php echo $footer_text; ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- End Footer -->
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        </body>
        </html>

		<?php
		$message = ob_get_clean();
		// print the preview email
		wp_send_json(
			array(
				'html' => $message,
			)
		);
	}

	public function search_active_campaign_list() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		ob_start();
		$keyword = filter_input( INPUT_GET, 'keyword', FILTER_SANITIZE_STRING );
		if ( empty( $keyword ) ) {
			die();
		}
		$active_campaign = new VI_WORDPRESS_LUCKY_WHEEL_Admin_Active_Campaign();
		$list            = $active_campaign->list_list( $keyword );
		$found_products  = array();
		if ( $list['result_code'] == 1 ) {
			foreach ( $list as $key => $val ) {
				if ( is_array( $val ) ) {
					if ( isset( $val['id'] ) ) {
						$product          = array( 'id' => $val['id'], 'text' => $val['name'] );
						$found_products[] = $product;
					}
				}
			}
		}
		wp_send_json( $found_products );
		die;
	}

	public function admin_enqueue_scripts() {
		global $pagenow;
		if ( $pagenow == 'admin.php' && isset( $_REQUEST['page'] ) && $_REQUEST['page'] == 'wordpress-lucky-wheel' ) {
			global $wp_scripts;
			$scripts = $wp_scripts->registered;
			foreach ( $scripts as $k => $script ) {
				preg_match( '/select2/i', $k, $result );
				if ( count( array_filter( $result ) ) ) {
					unset( $wp_scripts->registered[ $k ] );
					wp_dequeue_script( $script->handle );
				}
				preg_match( '/bootstrap/i', $k, $result );
				if ( count( array_filter( $result ) ) ) {
					unset( $wp_scripts->registered[ $k ] );
					wp_dequeue_script( $script->handle );
				}
			}
			wp_enqueue_script( 'wordpress-lucky-wheel-fontselect-js', VI_WORDPRESS_LUCKY_WHEEL_JS . 'jquery.fontselect.min.js', array( 'jquery' ) );
			wp_enqueue_style( 'wordpress-lucky-wheel-fontselect-css', VI_WORDPRESS_LUCKY_WHEEL_CSS . 'fontselect-default.css' );

			wp_enqueue_script( 'wordpress-lucky-wheel-semantic-js-form', VI_WORDPRESS_LUCKY_WHEEL_JS . 'form.js', array( 'jquery' ) );
			wp_enqueue_style( 'wordpress-lucky-wheel-semantic-css-form', VI_WORDPRESS_LUCKY_WHEEL_CSS . 'form.min.css' );
			wp_enqueue_style( 'wordpress-lucky-wheel-semantic-css-icon', VI_WORDPRESS_LUCKY_WHEEL_CSS . 'icon.min.css' );
			wp_enqueue_script( 'wordpress-lucky-wheel-semantic-js-transition', VI_WORDPRESS_LUCKY_WHEEL_JS . 'transition.min.js', array( 'jquery' ) );
			wp_enqueue_style( 'wordpress-lucky-wheel-semantic-css-transition', VI_WORDPRESS_LUCKY_WHEEL_CSS . 'transition.min.css' );
			wp_enqueue_script( 'wordpress-lucky-wheel-semantic-js-dropdown', VI_WORDPRESS_LUCKY_WHEEL_JS . 'dropdown.min.js', array( 'jquery' ) );
			wp_enqueue_style( 'wordpress-lucky-wheel-semantic-css-dropdown', VI_WORDPRESS_LUCKY_WHEEL_CSS . 'dropdown.min.css' );
			wp_enqueue_script( 'wordpress-lucky-wheel-semantic-js-checkbox', VI_WORDPRESS_LUCKY_WHEEL_JS . 'checkbox.js', array( 'jquery' ) );
			wp_enqueue_style( 'wordpress-lucky-wheel-semantic-css-checkbox', VI_WORDPRESS_LUCKY_WHEEL_CSS . 'checkbox.min.css' );
			wp_enqueue_script( 'wordpress-lucky-wheel-select2-js', VI_WORDPRESS_LUCKY_WHEEL_JS . 'select2.js', array( 'jquery' ) );
			wp_enqueue_style( 'wordpress-lucky-wheel-select2-css', VI_WORDPRESS_LUCKY_WHEEL_CSS . 'select2.min.css' );
			wp_enqueue_script( 'wordpress-lucky-wheel-semantic-js-tab', VI_WORDPRESS_LUCKY_WHEEL_JS . 'tab.js', array( 'jquery' ) );
			wp_enqueue_style( 'wordpress-lucky-wheel-semantic-css-tab', VI_WORDPRESS_LUCKY_WHEEL_CSS . 'tab.css' );
			wp_enqueue_style( 'wordpress-lucky-wheel-semantic-css-input', VI_WORDPRESS_LUCKY_WHEEL_CSS . 'button.min.css' );
			wp_enqueue_style( 'wordpress-lucky-wheel-semantic-css-table', VI_WORDPRESS_LUCKY_WHEEL_CSS . 'table.min.css' );
			wp_enqueue_style( 'wordpress-lucky-wheel-semantic-css-segment', VI_WORDPRESS_LUCKY_WHEEL_CSS . 'segment.min.css' );
			wp_enqueue_style( 'wordpress-lucky-wheel-semantic-css-label', VI_WORDPRESS_LUCKY_WHEEL_CSS . 'label.min.css' );
			wp_enqueue_style( 'wordpress-lucky-wheel-semantic-css-menu', VI_WORDPRESS_LUCKY_WHEEL_CSS . 'menu.min.css' );
			wp_enqueue_script( 'jquery-ui-sortable' );
			/*Color picker*/
			wp_enqueue_script(
				'iris', admin_url( 'js/iris.min.js' ), array(
				'jquery-ui-draggable',
				'jquery-ui-slider',
				'jquery-touch-punch'
			), false, 1
			);

			wp_enqueue_script( 'media-upload' );
			if ( ! did_action( 'wp_enqueue_media' ) ) {
				wp_enqueue_media();
			}

			wp_enqueue_script( 'wordpress-lucky-wheel-jquery-address-javascript', VI_WORDPRESS_LUCKY_WHEEL_JS . 'jquery.address-1.6.min.js', array( 'jquery' ), VI_WORDPRESS_LUCKY_WHEEL_VERSION );
			wp_enqueue_script( 'wordpress-lucky-wheel-admin-javascript', VI_WORDPRESS_LUCKY_WHEEL_JS . 'admin-javascript.js', array( 'jquery' ), VI_WORDPRESS_LUCKY_WHEEL_VERSION );
			wp_localize_script( 'wordpress-lucky-wheel-admin-javascript', 'wp_lucky_wheel_params_admin', array(
				'url' => admin_url( 'admin-ajax.php' )
			) );
			wp_enqueue_style( 'wordpress-lucky-wheel-admin-style', VI_WORDPRESS_LUCKY_WHEEL_CSS . 'admin-style.css', array(), VI_WORDPRESS_LUCKY_WHEEL_VERSION );
		}
		wp_enqueue_style( 'wordpress-lucky-wheel-admin-icon-style', VI_WORDPRESS_LUCKY_WHEEL_CSS . 'admin-icon-style.css' );
	}

	public function settings_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$this->settings = new VI_WORDPRESS_LUCKY_WHEEL_DATA();
		?>
        <div class="wrap">
            <h2><?php esc_html_e( 'WordPress Lucky Wheel Settings', 'wordpress-lucky-wheel' ); ?></h2>
            <form action="" method="POST" class="vi-ui form">
				<?php wp_nonce_field( 'wplwl_settings_page_save', 'wplwl_nonce_field' ); ?>
                <div class="vi-ui top attached tabular menu">
                    <div class="item active"
                         data-tab="general"><?php esc_html_e( 'General', 'wordpress-lucky-wheel' ); ?></div>
                    <div class="item"
                         data-tab="popup"><?php esc_html_e( 'Pop-up', 'wordpress-lucky-wheel' ); ?></div>
                    <div class="item"
                         data-tab="wheel-wrap"><?php esc_html_e( 'Wheel Background', 'wordpress-lucky-wheel' ); ?></div>
                    <div class="item"
                         data-tab="custom-fields"><?php esc_html_e( 'Custom Fields', 'wordpress-lucky-wheel' ); ?></div>
                    <div class="item"
                         data-tab="wheel"><?php esc_html_e( 'Wheel Settings', 'wordpress-lucky-wheel' ); ?></div>
                    <div class="item"
                         data-tab="email"><?php esc_html_e( 'Email', 'wordpress-lucky-wheel' ); ?></div>
                    <div class="item"
                         data-tab="result"><?php esc_html_e( 'Inform Result', 'wordpress-lucky-wheel' ); ?></div>
                    <div class="item"
                         data-tab="email_api"><?php esc_html_e( 'Email API', 'wordpress-lucky-wheel' ); ?></div>
                    <div class="item"
                         data-tab="update"><?php esc_html_e( 'Update', 'wordpress-lucky-wheel' ); ?></div>
                </div>
                <div class="vi-ui bottom attached active tab segment" data-tab="general">
                    <table class="form-table">
                        <tbody>
                        <tr>
                            <th>
                                <label for="wplwl_enable"><?php esc_html_e( 'Enable', 'wordpress-lucky-wheel' ); ?></label>
                            </th>
                            <td colspan="2">
                                <div class="vi-ui toggle checkbox">
                                    <input type="checkbox" name="wplwl_enable"
                                           id="wplwl_enable" <?php checked( $this->settings->get_params( 'general', 'enable' ), 'on' ) ?>>
                                    <label></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="wplwl_enable_mobile"><?php esc_html_e( 'Enable mobile', 'wordpress-lucky-wheel' ); ?></label>
                            </th>
                            <td colspan="2">
                                <div class="vi-ui toggle checkbox">
                                    <input type="checkbox" name="wplwl_enable_mobile"
                                           id="wplwl_enable_mobile" <?php checked( $this->settings->get_params( 'general', 'mobile' ), 'on' ) ?>>
                                    <label></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="ajax_endpoint"><?php esc_html_e( 'Ajax endpoint', 'wordpress-lucky-wheel' ); ?></label>
                            </th>
                            <td colspan="2">
                                <div class="vi-ui toggle checkbox">
                                    <input type="radio" name="ajax_endpoint"
                                           id="ajax_endpoint_ajax"
                                           value="ajax" <?php checked( $this->settings->get_params( 'ajax_endpoint' ), 'ajax' ) ?>>
                                    <label for="ajax_endpoint_ajax"><?php esc_html_e( 'Ajax', 'wordpress-lucky-wheel' ); ?></label>
                                </div>
                                <p>
                                <div class="vi-ui toggle checkbox">
                                    <input type="radio" name="ajax_endpoint"
                                           id="ajax_endpoint_rest_api"
                                           value="rest_api" <?php checked( $this->settings->get_params( 'ajax_endpoint' ), 'rest_api' ) ?>>
                                    <label for="ajax_endpoint_rest_api"><?php esc_html_e( 'REST API', 'wordpress-lucky-wheel' ); ?></label>
                                </div>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="wplwl_spin_num"><?php esc_html_e( 'Times spinning per email', 'wordpress-lucky-wheel' ); ?></label>
                            </th>
                            <td colspan="2">
                                <input type="number" id="wplwl_spin_num" name="wplwl_spin_num" min="1"
                                       value="<?php echo $this->settings->get_params( 'general', 'spin_num' ); ?>">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="wplwl_delay"><?php esc_html_e( 'Delay between each spin of an email', 'wordpress-lucky-wheel' ); ?></label>
                            </th>
                            <td>
                                <input type="number" id="wplwl_delay" name="wplwl_delay"
                                       min="0" value="<?php echo $this->settings->get_params( 'general', 'delay' ); ?>">
                            </td>
                            <td>
                                <select name="wplwl_delay_unit" class="vi-ui fluid dropdown">
                                    <option value="s" <?php selected( $this->settings->get_params( 'general', 'delay_unit' ), 's' ) ?>>
										<?php esc_html_e( 'Seconds', 'wordpress-lucky-wheel' ); ?>
                                    </option>
                                    <option value="m" <?php selected( $this->settings->get_params( 'general', 'delay_unit' ), 'm' ) ?>><?php esc_html_e( 'Minutes', 'wordpress-lucky-wheel' ); ?></option>
                                    <option value="h" <?php selected( $this->settings->get_params( 'general', 'delay_unit' ), 'h' ) ?>><?php esc_html_e( 'Hours', 'wordpress-lucky-wheel' ); ?></option>
                                    <option value="d" <?php selected( $this->settings->get_params( 'general', 'delay_unit' ), 'd' ) ?>><?php esc_html_e( 'Days', 'wordpress-lucky-wheel' ); ?></option>
                                </select>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <div class="vi-ui bottom attached tab segment" data-tab="popup">
                    <table class="form-table">
                        <tbody>
                        <tr>
                            <th>
                                <label for="notify_position"><?php esc_html_e( 'Popup icon position', 'wordpress-lucky-wheel' ); ?></label>
                            </th>
                            <td colspan="2">
                                <select name="notify_position" id="notify_position" class="vi-ui fluid dropdown">
                                    <option value="top-left" <?php selected( $this->settings->get_params( 'notify', 'position' ), 'top-left' ) ?>><?php esc_html_e( 'Top Left', 'wordpress-lucky-wheel' ); ?></option>
                                    <option value="top-right" <?php selected( $this->settings->get_params( 'notify', 'position' ), 'top-right' ) ?>><?php esc_html_e( 'Top Right', 'wordpress-lucky-wheel' ); ?></option>
                                    <option value="middle-left" <?php selected( $this->settings->get_params( 'notify', 'position' ), 'middle-left' ) ?>><?php esc_html_e( 'Middle Left', 'wordpress-lucky-wheel' ); ?></option>
                                    <option value="middle-right" <?php selected( $this->settings->get_params( 'notify', 'position' ), 'middle-right' ) ?>><?php esc_html_e( 'Middle Right', 'wordpress-lucky-wheel' ); ?></option>
                                    <option value="bottom-left" <?php selected( $this->settings->get_params( 'notify', 'position' ), 'bottom-left' ) ?>><?php esc_html_e( 'Bottom Left', 'wordpress-lucky-wheel' ); ?></option>
                                    <option value="bottom-right" <?php selected( $this->settings->get_params( 'notify', 'position' ), 'bottom-right' ) ?>><?php esc_html_e( 'Bottom Right', 'wordpress-lucky-wheel' ); ?></option>
                                </select>
                                <p><?php esc_html_e( 'Position of the popup on screen', 'wordpress-lucky-wheel' ); ?></p>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <label for="notify_intent"><?php esc_html_e( 'Select intent', 'wordpress-lucky-wheel' ); ?>
                                </label>
                            </th>
                            <td colspan="2">
                                <select name="notify_intent" class="vi-ui fluid dropdown">
                                    <option value="popup_icon" <?php selected( $this->settings->get_params( 'notify', 'intent' ), 'popup_icon' ) ?>><?php esc_html_e( 'Popup icon', 'wordpress-lucky-wheel' ); ?></option>
                                    <option value="show_wheel" <?php selected( $this->settings->get_params( 'notify', 'intent' ), 'show_wheel' ) ?>><?php esc_html_e( 'Automactically show wheel after initial time', 'wordpress-lucky-wheel' ); ?></option>
                                    <option value="on_scroll" <?php selected( $this->settings->get_params( 'notify', 'intent' ), 'on_scroll' ) ?>><?php esc_html_e( 'Show wheel after users scroll down a specific value', 'wordpress-lucky-wheel' ); ?></option>
                                    <option value="on_exit" <?php selected( $this->settings->get_params( 'notify', 'intent' ), 'on_exit' ) ?>><?php esc_html_e( 'Show wheel when users move mouse over the top to close browser', 'wordpress-lucky-wheel' ); ?></option>
                                    <option value="random" <?php selected( $this->settings->get_params( 'notify', 'intent' ), 'random' ) ?>><?php esc_html_e( 'Random one of these above', 'wordpress-lucky-wheel' ); ?></option>
                                </select>
                            </td>

                        </tr>
                        <tr>
                            <th>
                                <label for="show_wheel"><?php esc_html_e( 'Initial time', 'wordpress-lucky-wheel' ); ?>
                                </label>
                            </th>
                            <td colspan="2">
                                <input type="text" id="show_wheel" name="show_wheel"
                                       value="<?php echo $this->settings->get_params( 'notify', 'show_wheel' ); ?>"><?php esc_html_e( 'Enter min,max to set random between min and max (seconds).', 'wordpress-lucky-wheel' ); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="scroll_amount"><?php esc_html_e( 'Scroll amount(%)', 'wordpress-lucky-wheel' ); ?>
                                </label>
                            </th>
                            <td colspan="2">
                                <input type="number" id="scroll_amount" name="scroll_amount"
                                       value="<?php echo $this->settings->get_params( 'notify', 'scroll_amount' ); ?>">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="notify_hide_popup"><?php esc_html_e( 'Hide popup icon', 'wordpress-lucky-wheel' ); ?></label>
                            </th>
                            <td colspan="2">
                                <div class="vi-ui toggle checkbox">
                                    <input type="checkbox" name="notify_hide_popup"
                                           id="notify_hide_popup" <?php checked( $this->settings->get_params( 'notify', 'hide_popup' ), 'on' ) ?>>
                                    <label></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="notify_time_on_close"><?php esc_html_e( 'If customers close and not spin, show popup again after', 'wordpress-lucky-wheel' ); ?></label>
                            </th>
                            <td>
                                <input type="number" id="notify_time_on_close" name="notify_time_on_close"
                                       min="0"
                                       value="<?php echo $this->settings->get_params( 'notify', 'time_on_close' ); ?>">
                            </td>
                            <td>
                                <select name="notify_time_on_close_unit" class="vi-ui fluid dropdown">
                                    <option value="m" <?php selected( $this->settings->get_params( 'notify', 'time_on_close_unit' ), 'm' ) ?>><?php esc_html_e( 'Minutes', 'wordpress-lucky-wheel' ); ?></option>
                                    <option value="h" <?php selected( $this->settings->get_params( 'notify', 'time_on_close_unit' ), 'h' ) ?>><?php esc_html_e( 'Hours', 'wordpress-lucky-wheel' ); ?></option>
                                    <option value="d" <?php selected( $this->settings->get_params( 'notify', 'time_on_close_unit' ), 'd' ) ?>><?php esc_html_e( 'Days', 'wordpress-lucky-wheel' ); ?></option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <label for="notify_show_again"><?php esc_html_e( 'When finishing a spin, show popup again after', 'wordpress-lucky-wheel' ); ?></label>
                            </th>
                            <td>
                                <input type="number" id="notify_show_again" name="notify_show_again"
                                       min="0"
                                       value="<?php echo $this->settings->get_params( 'notify', 'show_again' ); ?>">
                            </td>
                            <td>
                                <select name="notify_show_again_unit" class="vi-ui fluid dropdown">
                                    <option value="s" <?php selected( $this->settings->get_params( 'notify', 'show_again_unit' ), 's' ) ?>><?php esc_html_e( 'Seconds', 'wordpress-lucky-wheel' ); ?></option>
                                    <option value="m" <?php selected( $this->settings->get_params( 'notify', 'show_again_unit' ), 'm' ) ?>><?php esc_html_e( 'Minutes', 'wordpress-lucky-wheel' ); ?></option>
                                    <option value="h" <?php selected( $this->settings->get_params( 'notify', 'show_again_unit' ), 'h' ) ?>><?php esc_html_e( 'Hours', 'wordpress-lucky-wheel' ); ?></option>
                                    <option value="d" <?php selected( $this->settings->get_params( 'notify', 'show_again_unit' ), 'd' ) ?>><?php esc_html_e( 'Days', 'wordpress-lucky-wheel' ); ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="notify_frontpage_only"><?php esc_html_e( 'Show only on Homepage', 'wordpress-lucky-wheel' ); ?></label>
                            </th>
                            <td colspan="2">
                                <div class="vi-ui toggle checkbox">
                                    <input type="checkbox" name="notify_frontpage_only"
                                           id="notify_frontpage_only" <?php checked( $this->settings->get_params( 'notify', 'show_only_front' ), 'on' ) ?>>
                                    <label></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="notify_blogpage_only"><?php esc_html_e( 'Show only on Blog page', 'wordpress-lucky-wheel' ); ?></label>
                            </th>
                            <td colspan="2">
                                <div class="vi-ui toggle checkbox">
                                    <input type="checkbox" name="notify_blogpage_only"
                                           id="notify_blogpage_only" <?php checked( $this->settings->get_params( 'notify', 'show_only_blog' ), 'on' ) ?>>
                                    <label></label>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <label for="notify_conditional_tags"><?php esc_html_e( 'Conditional tags', 'wordpress-lucky-wheel' ); ?></label>
                            </th>
                            <td colspan="2">
                                <input type="text" name="notify_conditional_tags"
                                       placeholder="<?php esc_html_e( 'Ex: !is_page(array(123,41,20))', 'wordpress-lucky-wheel' ) ?>"
                                       id="notify_conditional_tags"
                                       value="<?php if ( $this->settings->get_params( 'notify', 'conditional_tags' ) ) {
									       echo htmlentities( $this->settings->get_params( 'notify', 'conditional_tags' ) );
								       } ?>">
                                <p class="description"><?php esc_html_e( 'Let you control on which pages WordPress Lucky wheel icon appears using ', 'wordpress-lucky-wheel' ) ?>
                                    <a href="http://codex.wordpress.org/Conditional_Tags"><?php esc_html_e( 'WP\'s conditional tags', 'wordpress-lucky-wheel' ) ?></a>
                                </p>
                                <p class="description">
                                    <strong>*</strong><?php esc_html_e( '"Home page", "Blog page" options above must be disabled to run these conditional tags.', 'wordpress-lucky-wheel' ) ?>
                                </p>
                                <p class="description">
                                    <strong>***</strong><?php esc_html_e( 'Use exclamation mark(!) before a conditional to hide wheel if the conditional matched. e.g use ', 'wordpress-lucky-wheel' ); ?>
                                    <strong>!is_home()</strong><?php esc_html_e( ' to hide wheel on homepage', 'wordpress-lucky-wheel' ) ?>
                                </p>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <div class="vi-ui bottom attached tab segment" data-tab="wheel-wrap">
                    <table class="form-table">
                        <tbody>
                        <tr>
                            <th>
                                <label for="wheel_wrap_bg_image"><?php esc_html_e( 'Background image', 'wordpress-lucky-wheel' ); ?></label>
                            </th>
                            <td id="wplwl-bg-image">
								<?php
								if ( $this->settings->get_params( 'wheel_wrap', 'bg_image' ) ) {
									$bg_image_url = wp_get_attachment_url( $this->settings->get_params( 'wheel_wrap', 'bg_image' ) );
									?>
                                    <div class="wplwl-image-container">
                                        <img style="border: 1px solid;width: 300px;" class="review-images"
                                             src="<?php echo $bg_image_url; ?>"/>
                                        <input class="wheel_wrap_bg_image" name="wheel_wrap_bg_image"
                                               type="hidden"
                                               value="<?php echo $this->settings->get_params( 'wheel_wrap', 'bg_image' ); ?>"/>
                                        <span class="wplwl-remove-image negative vi-ui button"><?php esc_html_e( 'Remove', 'wordpress-lucky-wheel' ); ?></span>
                                    </div>
                                    <div id="wplwl-new-image" style="float: left;">
                                    </div>
                                    <span style="display: none;"
                                          class="positive vi-ui button wplwl-upload-custom-img"><?php esc_html_e( 'Add Image', 'wordpress-lucky-wheel' ); ?></span>
									<?php

								} else {
									?>
                                    <div id="wplwl-new-image" style="float: left;">
                                    </div>
                                    <span class="positive vi-ui button wplwl-upload-custom-img"><?php esc_html_e( 'Add Image', 'wordpress-lucky-wheel' ); ?></span>
									<?php
								}
								?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="wheel_wrap_bg_color"><?php esc_html_e( 'Background color', 'wordpress-lucky-wheel' ); ?></label>
                            </th>
                            <td>
                                <input name="wheel_wrap_bg_color" id="wheel_wrap_bg_color" type="text"
                                       class="color-picker"
                                       value="<?php if ( $this->settings->get_params( 'wheel_wrap', 'bg_color' ) ) {
									       echo $this->settings->get_params( 'wheel_wrap', 'bg_color' );
								       } ?>"
                                       style="background: <?php if ( $this->settings->get_params( 'wheel_wrap', 'bg_color' ) ) {
									       echo $this->settings->get_params( 'wheel_wrap', 'bg_color' );
								       } ?>;"/>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="background_effect"><?php esc_html_e( 'Background effect', 'wordpress-lucky-wheel' ); ?></label>
                            </th>
                            <td>

                                <select name="background_effect" id="background_effect"
                                        class="vi-ui fluid dropdown">
                                    <option value="none" <?php selected( $this->settings->get_params( 'wheel_wrap', 'background_effect' ), 'none' ) ?>>
										<?php esc_html_e( 'None', 'wordpress-lucky-wheel' ); ?>
                                    </option>
                                    <option value="snowflakes" <?php selected( $this->settings->get_params( 'wheel_wrap', 'background_effect' ), 'snowflakes' ) ?>>
										<?php esc_html_e( 'Snowflake', 'wordpress-lucky-wheel' ); ?>
                                    </option>
                                    <option value="snowflakes-1" <?php selected( $this->settings->get_params( 'wheel_wrap', 'background_effect' ), 'snowflakes-1' ) ?>>
										<?php esc_html_e( 'Snowflake 1', 'wordpress-lucky-wheel' ); ?>
                                    </option>
                                    <option value="snowflakes-2-1" <?php selected( $this->settings->get_params( 'wheel_wrap', 'background_effect' ), 'snowflakes-2-1' ) ?>>
										<?php esc_html_e( 'Snowballs', 'wordpress-lucky-wheel' ); ?>
                                    </option>
                                    <option value="snowflakes-2-2" <?php selected( $this->settings->get_params( 'wheel_wrap', 'background_effect' ), 'snowflakes-2-2' ) ?>>
										<?php esc_html_e( 'Snowflake 2', 'wordpress-lucky-wheel' ); ?>
                                    </option>
                                    <option value="snowflakes-2-3" <?php selected( $this->settings->get_params( 'wheel_wrap', 'background_effect' ), 'snowflakes-2-3' ) ?>>
										<?php esc_html_e( 'Blurred snows', 'wordpress-lucky-wheel' ); ?>
                                    </option>
                                    <option value="random" <?php selected( $this->settings->get_params( 'wheel_wrap', 'background_effect' ), 'random' ) ?>>
										<?php esc_html_e( 'Random', 'wordpress-lucky-wheel' ); ?>
                                    </option>
                                </select>

                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="wheel_wrap_text_color"><?php esc_html_e( 'Text color', 'wordpress-lucky-wheel' ); ?></label>
                            </th>
                            <td>
                                <input name="wheel_wrap_text_color" id="wheel_wrap_text_color" type="text"
                                       class="color-picker"
                                       value="<?php if ( $this->settings->get_params( 'wheel_wrap', 'text_color' ) ) {
									       echo $this->settings->get_params( 'wheel_wrap', 'text_color' );
								       } ?>"
                                       style="background: <?php if ( $this->settings->get_params( 'wheel_wrap', 'text_color' ) ) {
									       echo $this->settings->get_params( 'wheel_wrap', 'text_color' );
								       } ?>;"/>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="wheel_wrap_description"><?php esc_html_e( 'Wheel description', 'wordpress-lucky-wheel' ); ?>
                                </label>
                            </th>
                            <td>
								<?php
								$desc_option = array( 'editor_height' => 200, 'media_buttons' => true );
								wp_editor( stripslashes( $this->settings->get_params( 'wheel_wrap', 'description' ) ), 'wheel_wrap_description', $desc_option );
								if ( count( $this->languages ) ) {
									foreach ( $this->languages as $key => $value ) {
										?>
                                        <p>
                                            <label for="<?php echo 'wheel_wrap_description_' . $value; ?>"><?php
												if ( isset( $this->languages_data[ $value ]['country_flag_url'] ) && $this->languages_data[ $value ]['country_flag_url'] ) {
													?>
                                                    <img src="<?php echo esc_url( $this->languages_data[ $value ]['country_flag_url'] ); ?>">
													<?php
												}
												echo $value;
												if ( isset( $this->languages_data[ $value ]['translated_name'] ) ) {
													echo '(' . $this->languages_data[ $value ]['translated_name'] . ')';
												}
												?>:</label>
                                        </p>
										<?php
										wp_editor( stripslashes( $this->settings->get_params( 'wheel_wrap', 'description', $value ) ), 'wheel_wrap_description_' . $value, array(
											'editor_height' => 300,
											'media_buttons' => true
										) );
									}
								}
								?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="wheel_wrap_spin_button"><?php esc_html_e( 'Button spin', 'wordpress-lucky-wheel' ); ?></label>
                            </th>
                            <td>
                                <input type="text" name="wheel_wrap_spin_button" id="wheel_wrap_spin_button"
                                       value="<?php if ( $this->settings->get_params( 'wheel_wrap', 'spin_button' ) ) {
									       echo $this->settings->get_params( 'wheel_wrap', 'spin_button' );
								       } ?>">
								<?php
								if ( count( $this->languages ) ) {
									foreach ( $this->languages as $key => $value ) {
										?>
                                        <p>
                                            <label for="<?php echo 'wheel_wrap_spin_button_' . $value; ?>"><?php
												if ( isset( $this->languages_data[ $value ]['country_flag_url'] ) && $this->languages_data[ $value ]['country_flag_url'] ) {
													?>
                                                    <img src="<?php echo esc_url( $this->languages_data[ $value ]['country_flag_url'] ); ?>">
													<?php
												}
												echo $value;
												if ( isset( $this->languages_data[ $value ]['translated_name'] ) ) {
													echo '(' . $this->languages_data[ $value ]['translated_name'] . ')';
												}
												?>:</label>
                                        </p>
                                        <input id="<?php echo 'wheel_wrap_spin_button_' . $value ?>" type="text"
                                               name="<?php echo 'wheel_wrap_spin_button_' . $value ?>"
                                               value="<?php echo stripslashes( $this->settings->get_params( 'wheel_wrap', 'spin_button', $value ) ); ?>">
										<?php
									}
								}
								?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="wheel_wrap_spin_button_color"><?php esc_html_e( 'Button spin color', 'wordpress-lucky-wheel' ); ?></label>
                            </th>
                            <td>
                                <input type="text" class="color-picker" name="wheel_wrap_spin_button_color"
                                       id="wheel_wrap_spin_button_color"
                                       value="<?php if ( $this->settings->get_params( 'wheel_wrap', 'spin_button_color' ) ) {
									       echo $this->settings->get_params( 'wheel_wrap', 'spin_button_color' );
								       } ?>"
                                       style="background-color:<?php if ( $this->settings->get_params( 'wheel_wrap', 'spin_button_color' ) ) {
									       echo $this->settings->get_params( 'wheel_wrap', 'spin_button_color' );
								       } ?>;">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="wheel_wrap_spin_button_bg_color"><?php esc_html_e( 'Button spin background color', 'wordpress-lucky-wheel' ); ?></label>
                            </th>
                            <td>
                                <input type="text" class="color-picker" name="wheel_wrap_spin_button_bg_color"
                                       id="wheel_wrap_spin_button_bg_color"
                                       value="<?php if ( $this->settings->get_params( 'wheel_wrap', 'spin_button_bg_color' ) ) {
									       echo $this->settings->get_params( 'wheel_wrap', 'spin_button_bg_color' );
								       } ?>"
                                       style="background-color:<?php if ( $this->settings->get_params( 'wheel_wrap', 'spin_button_bg_color' ) ) {
									       echo $this->settings->get_params( 'wheel_wrap', 'spin_button_bg_color' );
								       } ?>;">
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <label for="wheel_wrap_close_option"><?php esc_html_e( 'Show text option to not display wheel again', 'wordpress-lucky-wheel' ); ?></label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input type="checkbox" name="wheel_wrap_close_option"
                                           id="wheel_wrap_close_option" <?php checked( $this->settings->get_params( 'wheel_wrap', 'close_option' ), 'on' ) ?>>
                                    <label></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="wplwl-google-font-select"><?php esc_html_e( 'Select font', 'wordpress-lucky-wheel' ); ?></label>
                            </th>
                            <td>

                                <input type="text" name="wplwl_google_font_select"
                                       id="wplwl-google-font-select"
                                       value="<?php echo $this->settings->get_params( 'wheel_wrap', 'font' ) ?>"><span
                                        class="wplwl-google-font-select-remove wplwl-cancel"
                                        style="<?php if ( ! $this->settings->get_params( 'wheel_wrap', 'font' ) ) {
											echo 'display:none';
										} ?>"></span>

                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="gdpr_policy"><?php esc_html_e( 'GDPR checkbox', 'wordpress-lucky-wheel' ) ?></label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input class="gdpr_policy" type="checkbox" id="gdpr_policy"
                                           name="gdpr_policy"
                                           value="on" <?php checked( $this->settings->get_params( 'wheel_wrap', 'gdpr' ), 'on' ) ?>>
                                    <label></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="gdpr_message"><?php esc_html_e( 'GDPR message', 'wordpress-lucky-wheel' ) ?></label>
                            </th>
                            <td>
								<?php
								$option = array( 'editor_height' => 300, 'media_buttons' => false );
								wp_editor( stripslashes( $this->settings->get_params( 'wheel_wrap', 'gdpr_message' ) ), 'gdpr_message', $option );
								if ( count( $this->languages ) ) {
									foreach ( $this->languages as $key => $value ) {
										?>
                                        <p>
                                            <label for="<?php echo 'gdpr_message_' . $value; ?>"><?php
												if ( isset( $this->languages_data[ $value ]['country_flag_url'] ) && $this->languages_data[ $value ]['country_flag_url'] ) {
													?>
                                                    <img src="<?php echo esc_url( $this->languages_data[ $value ]['country_flag_url'] ); ?>">
													<?php
												}
												echo $value;
												if ( isset( $this->languages_data[ $value ]['translated_name'] ) ) {
													echo '(' . $this->languages_data[ $value ]['translated_name'] . ')';
												}
												?>:</label>
                                        </p>
										<?php
										wp_editor( stripslashes( $this->settings->get_params( 'wheel_wrap', 'gdpr_message', $value ) ), 'gdpr_message_' . $value, array(
											'editor_height' => 300,
											'media_buttons' => true
										) );
									}
								}
								?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="custom_css"><?php esc_html_e( 'Custom css', 'wordpress-lucky-wheel' ) ?></label>
                            </th>
                            <td>
                                <textarea
                                        name="custom_css"><?php echo wp_kses_post( $this->settings->get_params( 'wheel_wrap', 'custom_css' ) ) ?></textarea>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="vi-ui bottom attached tab segment" data-tab="custom-fields">
                    <table class="form-table">
                        <tbody>
                        <tr>
                            <th>
                                <label for="custom_field_name_enable"><?php esc_html_e( 'Enable field name', 'wordpress-lucky-wheel' ) ?></label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input class="custom_field_name_enable" type="checkbox"
                                           id="custom_field_name_enable"
                                           name="custom_field_name_enable"
                                           value="on" <?php checked( $this->settings->get_params( 'custom_field_name_enable' ), 'on' ) ?>>
                                    <label></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="custom_field_name_enable_mobile"><?php esc_html_e( 'Enable field name on mobile', 'wordpress-lucky-wheel' ) ?></label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input class="custom_field_name_enable_mobile" type="checkbox"
                                           id="custom_field_name_enable_mobile"
                                           name="custom_field_name_enable_mobile"
                                           value="on" <?php checked( $this->settings->get_params( 'custom_field_name_enable_mobile' ), 'on' ) ?>>
                                    <label></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="custom_field_name_required"><?php esc_html_e( 'Field name is required', 'wordpress-lucky-wheel' ) ?></label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input class="custom_field_name_required" type="checkbox"
                                           id="custom_field_name_required"
                                           name="custom_field_name_required"
                                           value="on" <?php checked( $this->settings->get_params( 'custom_field_name_required' ), 'on' ) ?>>
                                    <label></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <th>
                                <label for="custom_field_mobile_enable"><?php esc_html_e( 'Enable field phone number', 'wordpress-lucky-wheel' ) ?></label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input class="custom_field_mobile_enable" type="checkbox"
                                           id="custom_field_mobile_enable"
                                           name="custom_field_mobile_enable"
                                           value="on" <?php checked( $this->settings->get_params( 'custom_field_mobile_enable' ), 'on' ) ?>>
                                    <label></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="custom_field_mobile_enable_mobile"><?php esc_html_e( 'Enable field phone number on mobile', 'wordpress-lucky-wheel' ) ?></label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input class="custom_field_mobile_enable_mobile" type="checkbox"
                                           id="custom_field_mobile_enable_mobile"
                                           name="custom_field_mobile_enable_mobile"
                                           value="on" <?php checked( $this->settings->get_params( 'custom_field_mobile_enable_mobile' ), 'on' ) ?>>
                                    <label></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="custom_field_mobile_required"><?php esc_html_e( 'Field phone number is required', 'wordpress-lucky-wheel' ) ?></label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input class="custom_field_mobile_required" type="checkbox"
                                           id="custom_field_mobile_required"
                                           name="custom_field_mobile_required"
                                           value="on" <?php checked( $this->settings->get_params( 'custom_field_mobile_required' ), 'on' ) ?>>
                                    <label></label>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="vi-ui bottom attached tab segment" data-tab="wheel">
                    <span class="vi-ui positive button preview-lucky-wheel"><?php esc_html_e( 'Preview Wheel', 'wordpress-lucky-wheel' ); ?></span>
                    <table class="form-table wheel-settings">
                        <tbody class="content">
                        <tr>
                            <th>
                                <label for="pointer_position"><?php esc_html_e( 'Pointer position', 'wordpress-lucky-wheel' ); ?></label>
                            </th>
                            <td>
                                <select name="pointer_position" id="pointer_position" class="vi-ui fluid dropdown">
                                    <option value="center" <?php selected( $this->settings->get_params( 'wheel_wrap', 'pointer_position' ), 'center' ) ?>><?php esc_html_e( 'Center', 'wordpress-lucky-wheel' ); ?></option>
                                    <option value="top" <?php selected( $this->settings->get_params( 'wheel_wrap', 'pointer_position' ), 'top' ) ?>><?php esc_html_e( 'Top', 'wordpress-lucky-wheel' ); ?></option>
                                    <option value="right" <?php selected( $this->settings->get_params( 'wheel_wrap', 'pointer_position' ), 'right' ) ?>><?php esc_html_e( 'Right', 'wordpress-lucky-wheel' ); ?></option>
                                    <option value="bottom" <?php selected( $this->settings->get_params( 'wheel_wrap', 'pointer_position' ), 'bottom' ) ?>><?php esc_html_e( 'Bottom', 'wordpress-lucky-wheel' ); ?></option>
                                    <option value="random" <?php selected( $this->settings->get_params( 'wheel_wrap', 'pointer_position' ), 'random' ) ?>><?php esc_html_e( 'Random', 'wordpress-lucky-wheel' ); ?></option>
                                </select>

                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="pointer_color"><?php esc_html_e( 'Wheel pointer color', 'wordpress-lucky-wheel' ); ?></label>
                            </th>
                            <td>
                                <input name="pointer_color" id="pointer_color" type="text"
                                       class="color-picker"
                                       value="<?php if ( $this->settings->get_params( 'wheel_wrap', 'pointer_color' ) ) {
									       echo $this->settings->get_params( 'wheel_wrap', 'pointer_color' );
								       } ?>"
                                       style="background-color: <?php if ( $this->settings->get_params( 'wheel_wrap', 'pointer_color' ) ) {
									       echo $this->settings->get_params( 'wheel_wrap', 'pointer_color' );
								       } ?>;"/>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="wplwl-center-image1"><?php esc_html_e( 'Wheel center background image', 'wordpress-lucky-wheel' ); ?></label>
                            </th>
                            <td id="wplwl-bg-image1">
								<?php
								if ( $this->settings->get_params( 'wheel_wrap', 'wheel_center_image' ) ) {
									?>
                                    <div class="wplwl-image-container1">
                                        <img style="border: 1px solid;" class="review-images1"
                                             src="<?php echo wp_get_attachment_thumb_url( $this->settings->get_params( 'wheel_wrap', 'wheel_center_image' ) ); ?>"/>
                                        <input class="wheel_center_image" name="wheel_center_image"
                                               type="hidden"
                                               value="<?php echo $this->settings->get_params( 'wheel_wrap', 'wheel_center_image' ); ?>"/>
                                        <span class="wplwl-remove-image1 negative vi-ui button"><?php esc_html_e( 'Remove', 'wordpress-lucky-wheel' ); ?></span>
                                    </div>
                                    <div id="wplwl-new-image1" style="float: left;">
                                    </div>
                                    <span style="display: none;"
                                          class="positive vi-ui button wplwl-upload-custom-img1"><?php esc_html_e( 'Add Image', 'wordpress-lucky-wheel' ); ?></span>
									<?php

								} else {
									?>
                                    <div id="wplwl-new-image1" style="float: left;">
                                    </div>
                                    <span class="positive vi-ui button wplwl-upload-custom-img1"><?php esc_html_e( 'Add Image', 'wordpress-lucky-wheel' ); ?></span>
									<?php
								}
								?>
                            </td>
                        </tr>


                        <tr>
                            <th>
                                <label for="wheel_center_color"><?php esc_html_e( 'Wheel center color', 'wordpress-lucky-wheel' ); ?></label>
                            </th>
                            <td>
                                <input name="wheel_center_color" id="wheel_center_color" type="text"
                                       class="color-picker"
                                       value="<?php if ( $this->settings->get_params( 'wheel_wrap', 'wheel_center_color' ) ) {
									       echo $this->settings->get_params( 'wheel_wrap', 'wheel_center_color' );
								       } ?>"
                                       style="background-color: <?php if ( $this->settings->get_params( 'wheel_wrap', 'wheel_center_color' ) ) {
									       echo $this->settings->get_params( 'wheel_wrap', 'wheel_center_color' );
								       } ?>;"/>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="wheel_border_color"><?php esc_html_e( 'Wheel border color', 'wordpress-lucky-wheel' ); ?></label>
                            </th>
                            <td>
                                <input name="wheel_border_color" id="wheel_border_color" type="text"
                                       class="color-picker"
                                       value="<?php if ( $this->settings->get_params( 'wheel_wrap', 'wheel_border_color' ) ) {
									       echo $this->settings->get_params( 'wheel_wrap', 'wheel_border_color' );
								       } ?>"
                                       style="background-color: <?php if ( $this->settings->get_params( 'wheel_wrap', 'wheel_border_color' ) ) {
									       echo $this->settings->get_params( 'wheel_wrap', 'wheel_border_color' );
								       } ?>;"/>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="wheel_dot_color"><?php esc_html_e( 'Wheel border dot color', 'wordpress-lucky-wheel' ); ?></label>
                            </th>
                            <td>
                                <input name="wheel_dot_color" id="wheel_dot_color" type="text"
                                       class="color-picker"
                                       value="<?php if ( $this->settings->get_params( 'wheel_wrap', 'wheel_dot_color' ) ) {
									       echo $this->settings->get_params( 'wheel_wrap', 'wheel_dot_color' );
								       } ?>"
                                       style="background-color: <?php if ( $this->settings->get_params( 'wheel_wrap', 'wheel_dot_color' ) ) {
									       echo $this->settings->get_params( 'wheel_wrap', 'wheel_dot_color' );
								       } ?>;"/>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="wheel_speed"><?php esc_html_e( 'Wheel speed', 'wordpress-lucky-wheel' ); ?></label>
                            </th>
                            <td>
                                <select name="wheel_speed" id="wheel_speed" class="vi-ui fluid dropdown">
									<?php
									for ( $i = 1; $i <= 10; $i ++ ) {
										?>
                                        <option value="<?php esc_attr_e( $i ) ?>" <?php selected( $this->settings->get_params( 'wheel', 'wheel_speed' ), $i ) ?>><?php esc_html_e( $i ); ?></option>
										<?php
									}
									?>
                                </select>

                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="wheel_spinning_time">
									<?php esc_html_e( 'Wheel spinning duration', 'wordpress-lucky-wheel' ); ?>

                                </label>
                            </th>
                            <td colspan="4">
                                <div class="inline fields">
                                    <input type="number" min="3" max="15" name="wheel_spinning_time"
                                           id="wheel_spinning_time"
                                           value="<?php echo $this->settings->get_params( 'wheel', 'spinning_time' ); ?>"><?php esc_html_e( 'seconds', 'wordpress-lucky-wheel' ); ?>
                                </div>
                                <p><?php esc_html_e( 'From 3s to 15s.', 'wordpress-lucky-wheel' ); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="show_full_wheel"><?php esc_html_e( 'Show full wheel', 'wordpress-lucky-wheel' ) ?></label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input class="show_full_wheel" type="checkbox" id="show_full_wheel"
                                           name="show_full_wheel"
                                           value="on" <?php checked( $this->settings->get_params( 'wheel', 'show_full_wheel' ), 'on' ) ?>>
                                    <label><?php esc_html_e( 'Make all wheel slices visible on desktop', 'wordpress-lucky-wheel' ) ?></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="font_size"><?php esc_html_e( 'Adjust font size of text on the wheel by(%)', 'wordpress-lucky-wheel' ) ?></label>
                            </th>
                            <td>
                                <input type="number" class="font_size" id="font_size"
                                       name="font_size"
                                       value="<?php echo $this->settings->get_params( 'wheel', 'font_size' ) ?>">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="wheel_size"><?php esc_html_e( 'Adjust the size of the wheel by(%)', 'wordpress-lucky-wheel' ) ?></label>
                            </th>
                            <td>
                                <input type="number" class="wheel_size" id="wheel_size"
                                       name="wheel_size"
                                       value="<?php echo $this->settings->get_params( 'wheel', 'wheel_size' ) ?>">
                            </td>
                        </tr>
                        </tbody>

                    </table>
                    <table class="form-table wheel-settings" style="margin-top: 0;">
                        <tbody>
                        <tr class="wheel-slices" style="background-color: #000000;">
                            <td width="40"><?php esc_attr_e( 'Index', 'wordpress-lucky-wheel' ) ?></td>
                            <td><?php esc_attr_e( 'Prize Type', 'wordpress-lucky-wheel' ) ?></td>
                            <td><?php esc_attr_e( 'Label', 'wordpress-lucky-wheel' ) ?></td>
                            <td><?php esc_attr_e( 'Value', 'wordpress-lucky-wheel' ) ?></td>
                            <td><?php esc_attr_e( 'Probability(%)', 'wordpress-lucky-wheel' ) ?></td>
                            <td><?php esc_attr_e( 'Color', 'wordpress-lucky-wheel' ) ?></td>
                            <td><?php esc_attr_e( 'Text Color', 'wordpress-lucky-wheel' ) ?></td>
                        </tr>
                        </tbody>
                        <tbody class="ui-sortable">
						<?php
						for ( $count = 0; $count < count( $this->settings->get_params( 'wheel', 'prize_type' ) ); $count ++ ) {
							?>
                            <tr class="wheel_col">
                                <td class="wheel_col_index" width="40"><?php echo( $count + 1 ); ?></td>
                                <td class="wheel_col_coupons">
                                    <select name="prize_type[]" class="coupons_select vi-ui fluid dropdown">
                                        <option value="non" <?php selected( $this->settings->get_params( 'wheel', 'prize_type' )[ $count ], 'non' ); ?>><?php esc_attr_e( 'Non', 'wordpress-lucky-wheel' ) ?></option>
                                        <option value="custom" <?php selected( $this->settings->get_params( 'wheel', 'prize_type' )[ $count ], 'custom' ); ?>><?php esc_attr_e( 'Custom', 'wordpress-lucky-wheel' ) ?></option>
                                    </select>
                                </td>
                                <td class="wheel_col_coupons_value">
                                    <input type="text" name="custom_type_label[]"
										<?php
										echo ' class="custom_type_label" value="' . ( isset( $this->settings->get_params( 'wheel', 'custom_label' )[ $count ] ) ? $this->settings->get_params( 'wheel', 'custom_label' )[ $count ] : '' ) . '"';
										?> placeholder="Label"/>
                                </td>
                                <td class="wheel_col_coupons_value">
                                    <input type="text" name="custom_type_value[]" class="custom_type_value"
                                           value="<?php echo isset( $this->settings->get_params( 'wheel', 'custom_value' )[ $count ] ) ? $this->settings->get_params( 'wheel', 'custom_value' )[ $count ] : ''; ?>"
                                           placeholder="Value/Code"/>
                                </td>
                                <td class="wheel_col_probability">
                                    <input type="number" name="probability[]"
                                           class="probability probability_<?php echo $count; ?>" min="0"
                                           max="100" placeholder="Probability"
                                           value="<?php echo absint( $this->settings->get_params( 'wheel', 'probability' )[ $count ] ) ?>"/>
                                </td>
                                <td>
                                    <input type="text" id="bg_color" name="bg_color[]" class="color-picker"
                                           value=" <?php echo trim( $this->settings->get_params( 'wheel', 'bg_color' )[ $count ] ); ?>"
                                           style="background: <?php echo trim( $this->settings->get_params( 'wheel', 'bg_color' )[ $count ] ); ?>"/>
                                </td>
                                <td class="remove_field_wrap">
                                    <input type="text" id="slices_text_color" name="slices_text_color[]"
                                           class="color-picker"
                                           value=" <?php echo trim( $this->settings->get_params( 'wheel', 'slices_text_color' )[ $count ] ); ?>"
                                           style="background: <?php echo trim( $this->settings->get_params( 'wheel', 'slices_text_color' )[ $count ] ); ?>"/>
                                    <span class="remove_field negative vi-ui button"><?php esc_attr_e( 'Remove', 'wordpress-lucky-wheel' ); ?></span>
                                    <span class="clone_piece positive vi-ui button"><?php esc_attr_e( 'Clone', 'wordpress-lucky-wheel' ); ?></span>
                                </td>
                            </tr>
							<?php
						}
						?>
                        <tbody>
                        <tr>
                            <td class="col_add_new" colspan="3">
                                <i><?php esc_attr_e( 'Slices positions are sortable by drag and drop.', 'wordpress-lucky-wheel' ); ?></i>
                            </td>

                            <td class="col_add_new col_total_probability">
                                <i><?php esc_attr_e( '*The total Probability: ', 'wordpress-lucky-wheel' ); ?>
                                    <strong class="total_probability" data-total_probability=""> 100 </strong> (
                                    % )</i></td>
                            <td></td>
                            <td class="col_add_new">
								<?php
								self::auto_color();
								?>
                                <p>
                                    <span class="auto_color positive vi-ui button"><?php esc_attr_e( 'Auto Color', 'wordpress-lucky-wheel' ) ?></span>
                                </p>
                                <div class="vi-ui toggle checkbox">
                                    <p>
                                        <input class="random_color" type="checkbox" id="random_color"
                                               name="random_color"
                                               value="on" <?php checked( $this->settings->get_params( 'wheel', 'random_color' ), 'on' ) ?>>
                                        <label><?php esc_html_e( 'Color is set randomly from predefined sets for each visitor', 'wordpress-lucky-wheel' ) ?></label>
                                    </p>
                                </div>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <div class="vi-ui bottom attached tab segment" data-tab="email">
                    <table class="form-table">
                        <tbody>
                        <tr>
                            <th>
                                <label for="from_name"><?php esc_html_e( '"From" name', 'wordpress-lucky-wheel' ) ?></label>
                            </th>
                            <td>
                                <input id="from_name" type="text" name="from_name"
                                       value="<?php echo isset( $this->settings->get_params( 'result', 'email' )['from_name'] ) ? htmlentities( $this->settings->get_params( 'result', 'email' )['from_name'] ) : ''; ?>">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="from_address"><?php esc_html_e( '"From" address', 'wordpress-lucky-wheel' ) ?></label>
                            </th>
                            <td>
                                <input id="from_address" type="text" name="from_address"
                                       value="<?php echo isset( $this->settings->get_params( 'result', 'email' )['from_address'] ) ? htmlentities( $this->settings->get_params( 'result', 'email' )['from_address'] ) : ''; ?>">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="subject"><?php esc_html_e( 'Email subject', 'wordpress-lucky-wheel' ) ?></label>
                            </th>
                            <td>
                                <input id="subject" type="text" name="subject"
                                       value="<?php echo htmlentities( $this->settings->get_params( 'result', 'email' )['subject'] ); ?>">
								<?php esc_html_e( 'The subject of emails sending to customers when they win.', 'wordpress-lucky-wheel' ) ?>
								<?php
								if ( count( $this->languages ) ) {
									foreach ( $this->languages as $key => $value ) {
										?>
                                        <p>
                                            <label for="<?php echo 'subject_' . $value; ?>"><?php
												if ( isset( $this->languages_data[ $value ]['country_flag_url'] ) && $this->languages_data[ $value ]['country_flag_url'] ) {
													?>
                                                    <img src="<?php echo esc_url( $this->languages_data[ $value ]['country_flag_url'] ); ?>">
													<?php
												}
												echo $value;
												if ( isset( $this->languages_data[ $value ]['translated_name'] ) ) {
													echo '(' . $this->languages_data[ $value ]['translated_name'] . ')';
												}
												?>:</label>
                                        </p>
                                        <input id="<?php echo 'subject_' . $value ?>" type="text"
                                               name="<?php echo 'subject_' . $value ?>"
                                               value="<?php echo stripslashes( $this->settings->get_params( 'result', 'email', $value )['subject'] ); ?>">
										<?php
									}
								}
								?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="heading"><?php esc_html_e( 'Email heading', 'wordpress-lucky-wheel' ) ?></label>
                            </th>
                            <td>
                                <input id="heading" type="text" name="heading"
                                       value="<?php echo htmlentities( $this->settings->get_params( 'result', 'email' )['heading'] ); ?>">
								<?php esc_html_e( 'The heading of emails sending to customers when they win.', 'wordpress-lucky-wheel' ) ?>
								<?php
								if ( count( $this->languages ) ) {
									foreach ( $this->languages as $key => $value ) {
										?>
                                        <p>
                                            <label for="<?php echo 'heading_' . $value; ?>"><?php
												if ( isset( $this->languages_data[ $value ]['country_flag_url'] ) && $this->languages_data[ $value ]['country_flag_url'] ) {
													?>
                                                    <img src="<?php echo esc_url( $this->languages_data[ $value ]['country_flag_url'] ); ?>">
													<?php
												}
												echo $value;
												if ( isset( $this->languages_data[ $value ]['translated_name'] ) ) {
													echo '(' . $this->languages_data[ $value ]['translated_name'] . ')';
												}
												?>:</label>
                                        </p>
                                        <input id="<?php echo 'heading_' . $value ?>" type="text"
                                               name="<?php echo 'heading_' . $value ?>"
                                               value="<?php echo stripslashes( $this->settings->get_params( 'result', 'email', $value )['heading'] ); ?>">
										<?php
									}
								}
								?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="content"><?php esc_html_e( 'Email content', 'wordpress-lucky-wheel' ) ?></label>
                                <p><?php esc_html_e( 'The content of email sending to customers to inform them the prize they win.', 'wordpress-lucky-wheel' ) ?></p>
                            </th>
                            <td><?php
								$option = array( 'editor_height' => 300, 'media_buttons' => true );
								wp_editor( stripslashes( $this->settings->get_params( 'result', 'email' )['content'] ), 'content', $option );
								if ( count( $this->languages ) ) {
									foreach ( $this->languages as $key => $value ) {
										?>
                                        <p>
                                            <label for="<?php echo 'content_' . $value; ?>"><?php
												if ( isset( $this->languages_data[ $value ]['country_flag_url'] ) && $this->languages_data[ $value ]['country_flag_url'] ) {
													?>
                                                    <img src="<?php echo esc_url( $this->languages_data[ $value ]['country_flag_url'] ); ?>">
													<?php
												}
												echo $value;
												if ( isset( $this->languages_data[ $value ]['translated_name'] ) ) {
													echo '(' . $this->languages_data[ $value ]['translated_name'] . ')';
												}
												?>:</label>
                                        </p>
										<?php
										wp_editor( stripslashes( $this->settings->get_params( 'result', 'email', $value )['content'] ), 'content_' . $value, array(
											'editor_height' => 300,
											'media_buttons' => true
										) );
									}
								}
								?>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <ul>
                                    <li>{customer_name}
                                        - <?php esc_html_e( 'Customer\'s name.', 'wordpress-lucky-wheel' ) ?></li>
                                    <li>{customer_mobile}
                                        - <?php esc_html_e( 'Customer\'s mobile if any.', 'wordpress-lucky-wheel' ) ?></li>
                                    <li>{prize_value}
                                        - <?php esc_html_e( 'Value of prize that will be sent to customer.', 'wordpress-lucky-wheel' ) ?></li>
                                    <li>{prize_label}
                                        - <?php esc_html_e( 'Label of prize that customers win', 'wordpress-lucky-wheel' ) ?></li>
                                    <li>{today}
                                        - <?php esc_html_e( 'Current date', 'wordpress-lucky-wheel' ) ?></li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="footer_text"><?php esc_html_e( 'Footer text', 'wordpress-lucky-wheel' ); ?></label>
                            </th>
                            <td>
                                <input name="footer_text" id="footer_text" type="text"
                                       value="<?php if ( isset( $this->settings->get_params( 'result', 'email' )['footer_text'] ) ) {
									       echo $this->settings->get_params( 'result', 'email' )['footer_text'];
								       } ?>"/>
								<?php
								if ( count( $this->languages ) ) {
									foreach ( $this->languages as $key => $value ) {
										?>
                                        <p>
                                            <label for="<?php echo 'footer_text_' . $value; ?>"><?php
												if ( isset( $this->languages_data[ $value ]['country_flag_url'] ) && $this->languages_data[ $value ]['country_flag_url'] ) {
													?>
                                                    <img src="<?php echo esc_url( $this->languages_data[ $value ]['country_flag_url'] ); ?>">
													<?php
												}
												echo $value;
												if ( isset( $this->languages_data[ $value ]['translated_name'] ) ) {
													echo '(' . $this->languages_data[ $value ]['translated_name'] . ')';
												}
												?>:</label>
                                        </p>
                                        <input id="<?php echo 'footer_text_' . $value ?>" type="text"
                                               name="<?php echo 'footer_text_' . $value ?>"
                                               value="<?php echo stripslashes( $this->settings->get_params( 'result', 'email', $value )['footer_text'] ); ?>">
										<?php
									}
								}
								?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="email_base_color"><?php esc_html_e( 'Base color', 'wordpress-lucky-wheel' ); ?></label>
                            </th>
                            <td>
                                <input name="email_base_color" id="email_base_color" type="text"
                                       class="color-picker"
                                       value="<?php if ( isset( $this->settings->get_params( 'result', 'email' )['base_color'] ) ) {
									       echo $this->settings->get_params( 'result', 'email' )['base_color'];
								       } ?>"
                                       style="background: <?php if ( isset( $this->settings->get_params( 'result', 'email' )['base_color'] ) ) {
									       echo $this->settings->get_params( 'result', 'email' )['base_color'];
								       } ?>;"/>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="email_background_color"><?php esc_html_e( 'Background color', 'wordpress-lucky-wheel' ); ?></label>
                            </th>
                            <td>
                                <input name="email_background_color" id="email_background_color" type="text"
                                       class="color-picker"
                                       value="<?php if ( isset( $this->settings->get_params( 'result', 'email' )['background_color'] ) ) {
									       echo $this->settings->get_params( 'result', 'email' )['background_color'];
								       } ?>"
                                       style="background: <?php if ( isset( $this->settings->get_params( 'result', 'email' )['background_color'] ) ) {
									       echo $this->settings->get_params( 'result', 'email' )['background_color'];
								       } ?>;"/>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="email_body_background_color"><?php esc_html_e( 'Body background color', 'wordpress-lucky-wheel' ); ?></label>
                            </th>
                            <td>
                                <input name="email_body_background_color" id="email_body_background_color"
                                       type="text"
                                       class="color-picker"
                                       value="<?php if ( isset( $this->settings->get_params( 'result', 'email' )['body_background_color'] ) ) {
									       echo $this->settings->get_params( 'result', 'email' )['body_background_color'];
								       } ?>"
                                       style="background: <?php if ( isset( $this->settings->get_params( 'result', 'email' )['body_background_color'] ) ) {
									       echo $this->settings->get_params( 'result', 'email' )['body_background_color'];
								       } ?>;"/>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="email_body_text_color"><?php esc_html_e( 'Body text color', 'wordpress-lucky-wheel' ); ?></label>
                            </th>
                            <td>
                                <input name="email_body_text_color" id="email_body_text_color" type="text"
                                       class="color-picker"
                                       value="<?php if ( isset( $this->settings->get_params( 'result', 'email' )['body_text_color'] ) ) {
									       echo $this->settings->get_params( 'result', 'email' )['body_text_color'];
								       } ?>"
                                       style="background: <?php if ( isset( $this->settings->get_params( 'result', 'email' )['body_text_color'] ) ) {
									       echo $this->settings->get_params( 'result', 'email' )['body_text_color'];
								       } ?>;"/>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <label for="admin_email_enable"><?php esc_html_e( 'Enable admin notification', 'wordpress-lucky-wheel' ) ?></label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input type="checkbox" name="admin_email_enable"
                                           id="admin_email_enable" <?php checked( $this->settings->get_params( 'result', 'admin_email' )['enable'], 'on' ) ?>>
                                    <label for="admin_email_enable"><?php esc_html_e( 'Enable', 'wordpress-lucky-wheel' ) ?></label>
                                </div>
                                <p class="description"><?php esc_html_e( 'Send admin notification when someone wins a prize', 'wordpress-lucky-wheel' ) ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="admin_email_to"><?php esc_html_e( 'Send notification to:', 'wordpress-lucky-wheel' ) ?></label>
                            </th>
                            <td>
                                <input id="admin_email_to" type="text" name="admin_email_to"
                                       value="<?php echo isset( $this->settings->get_params( 'result', 'admin_email' )['to'] ) ? htmlentities( $this->settings->get_params( 'result', 'admin_email' )['to'] ) : ''; ?>">
                                <p><?php esc_html_e( 'Send notification to this email when someone wins a prize. The from email will be used if this field is blank', 'wordpress-lucky-wheel' ) ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="admin_email_subject"><?php esc_html_e( 'Notification Email subject', 'wordpress-lucky-wheel' ) ?></label>
                            </th>
                            <td>
                                <input id="admin_email_subject" type="text" name="admin_email_subject"
                                       value="<?php echo htmlentities( $this->settings->get_params( 'result', 'admin_email' )['subject'] ); ?>">
								<?php esc_html_e( 'The subject of emails sending to admin.', 'wordpress-lucky-wheel' ) ?>

                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="admin_email_heading"><?php esc_html_e( 'Notification Email heading', 'wordpress-lucky-wheel' ) ?></label>
                            </th>
                            <td>
                                <input id="admin_email_heading" type="text" name="admin_email_heading"
                                       value="<?php echo htmlentities( $this->settings->get_params( 'result', 'admin_email' )['heading'] ); ?>">
								<?php esc_html_e( 'The heading of emails sending to admin.', 'wordpress-lucky-wheel' ) ?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="admin_email_content"><?php esc_html_e( 'Notification Email content', 'wordpress-lucky-wheel' ) ?></label>
                                <p><?php esc_html_e( 'The content of email sending to admin.', 'wordpress-lucky-wheel' ) ?></p>
                            </th>
                            <td><?php $option = array( 'editor_height' => 300, 'media_buttons' => true );
								wp_editor( stripslashes( $this->settings->get_params( 'result', 'admin_email' )['content'] ), 'admin_email_content', $option ); ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <ul>
                                    <li>{customer_name}
                                        - <?php esc_html_e( 'Customer\'s name.', 'wordpress-lucky-wheel' ) ?></li>
                                    <li>{customer_mobile}
                                        - <?php esc_html_e( 'Customer\'s mobile if any.', 'wordpress-lucky-wheel' ) ?></li>
                                    <li>{prize_value}
                                        - <?php esc_html_e( 'Value of prize that will be sent to customer.', 'wordpress-lucky-wheel' ) ?></li>
                                    <li>{prize_label}
                                        - <?php esc_html_e( 'Label of prize that customers win', 'wordpress-lucky-wheel' ) ?></li>
                                    <li>{today}
                                        - <?php esc_html_e( 'Current date', 'wordpress-lucky-wheel' ) ?></li>
                                </ul>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="vi-ui bottom attached tab segment" data-tab="result">
                    <table class="form-table">
                        <tbody>
                        <tr>
                            <th>
                                <label for="result-auto_close"><?php esc_html_e( 'Automatically hide wheel after finishing spinning', 'wordpress-lucky-wheel' ); ?>
                                </label>
                            </th>
                            <td>
                                <div class="inline fields">
                                    <input type="number" name="result-auto_close" min="0"
                                           id="result-auto_close"
                                           value="<?php echo intval( $this->settings->get_params( 'result', 'auto_close' ) ) ?>">
									<?php esc_html_e( 'seconds', 'wordpress-lucky-wheel' ); ?>
                                </div>
                                <p><?php esc_html_e( 'Left 0 to disable this feature', 'wordpress-lucky-wheel' ); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="result_win"><?php esc_html_e( 'Frontend Message if win', 'wordpress-lucky-wheel' ) ?></label>
                            </th>
                            <td>
								<?php
								$win_option = array( 'editor_height' => 200, 'media_buttons' => true );
								wp_editor( stripslashes( $this->settings->get_params( 'result', 'notification' )['win'] ), 'result_win', $win_option );
								if ( count( $this->languages ) ) {
									foreach ( $this->languages as $key => $value ) {
										?>
                                        <p>
                                            <label for="<?php echo 'result_win_' . $value; ?>"><?php
												if ( isset( $this->languages_data[ $value ]['country_flag_url'] ) && $this->languages_data[ $value ]['country_flag_url'] ) {
													?>
                                                    <img src="<?php echo esc_url( $this->languages_data[ $value ]['country_flag_url'] ); ?>">
													<?php
												}
												echo $value;
												if ( isset( $this->languages_data[ $value ]['translated_name'] ) ) {
													echo '(' . $this->languages_data[ $value ]['translated_name'] . ')';
												}
												?>:</label>
                                        </p>
										<?php
										wp_editor( stripslashes( $this->settings->get_params( 'result', 'notification', $value )['win'] ), 'result_win_' . $value, array(
											'editor_height' => 300,
											'media_buttons' => true
										) );
									}
								}
								?>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <ul>
                                    <li>{prize_label}
                                        - <?php esc_html_e( 'Label of prize that customers win', 'wordpress-lucky-wheel' ) ?></li>
                                    <li>{customer_name}
                                        - <?php esc_html_e( 'Customers\'name if they enter', 'wordpress-lucky-wheel' ) ?></li>
                                    <li>{customer_email}
                                        - <?php esc_html_e( 'Email that customers enter to spin', 'wordpress-lucky-wheel' ) ?></li>
                                    <li>{prize_value}
                                        - <?php esc_html_e( 'Prize value will be sent to customer.', 'wordpress-lucky-wheel' ) ?></li>
                                    <li>{today}
                                        - <?php esc_html_e( 'Current date', 'wordpress-lucky-wheel' ) ?></li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="congratulations_effect"><?php esc_html_e( 'Winning effect', 'wordpress-lucky-wheel' ); ?></label>
                            </th>
                            <td>
                                <select name="congratulations_effect" id="congratulations_effect"
                                        class="vi-ui fluid dropdown">
                                    <option value="none" <?php selected( $this->settings->get_params( 'wheel_wrap', 'congratulations_effect' ), 'none' ) ?>>
										<?php esc_html_e( 'None', 'wordpress-lucky-wheel' ); ?>
                                    </option>
                                    <option value="firework" <?php selected( $this->settings->get_params( 'wheel_wrap', 'congratulations_effect' ), 'firework' ) ?>>
										<?php esc_html_e( 'Firework', 'wordpress-lucky-wheel' ); ?>
                                    </option>
                                </select>

                            </td>
                        </tr>

                        <tr>
                            <th>
                                <label for="result_lost"><?php esc_html_e( 'Frontend message if lost', 'wordpress-lucky-wheel' ) ?></label>
                            </th>
                            <td>
								<?php
								$lost_option = array( 'editor_height' => 200, 'media_buttons' => true );
								wp_editor( stripslashes( $this->settings->get_params( 'result', 'notification' )['lost'] ), 'result_lost', $lost_option );
								if ( count( $this->languages ) ) {
									foreach ( $this->languages as $key => $value ) {
										?>
                                        <p>
                                            <label for="<?php echo 'result_lost_' . $value; ?>"><?php
												if ( isset( $this->languages_data[ $value ]['country_flag_url'] ) && $this->languages_data[ $value ]['country_flag_url'] ) {
													?>
                                                    <img src="<?php echo esc_url( $this->languages_data[ $value ]['country_flag_url'] ); ?>">
													<?php
												}
												echo $value;
												if ( isset( $this->languages_data[ $value ]['translated_name'] ) ) {
													echo '(' . $this->languages_data[ $value ]['translated_name'] . ')';
												}
												?>:</label>
                                        </p>
										<?php
										wp_editor( stripslashes( $this->settings->get_params( 'result', 'notification', $value )['lost'] ), 'result_lost_' . $value, array(
											'editor_height' => 300,
											'media_buttons' => true
										) );
									}
								}

								?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="vi-ui bottom attached tab segment" data-tab="email_api">
                    <table class="form-table">
                        <tbody>

                        <tr valign="top">
                            <th scope="row">
                                <label for="mailchimp_enable"><?php esc_html_e( 'Enable Mailchimp', 'wordpress-lucky-wheel' ) ?></label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox checked">
                                    <input type="checkbox" name="mailchimp_enable"
                                           id="mailchimp_enable" <?php checked( $this->settings->get_params( 'mailchimp', 'enable' ), 'on' ) ?>>
                                    <label for="mailchimp_enable"><?php esc_html_e( 'Enable', 'wordpress-lucky-wheel' ) ?></label>
                                </div>
                                <p class="description"><?php esc_html_e( 'Turn on to use MailChimp system', 'wordpress-lucky-wheel' ) ?></p>

                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="mailchimp_api"></label><?php esc_html_e( 'API key', 'wordpress-lucky-wheel' ) ?>
                            </th>
                            <td>
                                <input type="text" id="mailchimp_api" name="mailchimp_api"
                                       value="<?php echo $this->settings->get_params( 'mailchimp', 'api_key' ) ?>">

                                <p class="description"><?php esc_html_e( ' The API key for connecting with your MailChimp account. Get your API key ', 'wordpress-lucky-wheel' ) ?>
                                    <a href="https://admin.mailchimp.com/account/api"><?php esc_html_e( 'here', 'wordpress-lucky-wheel' ) ?></a>.
                                </p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="mailchimp_lists"><?php esc_html_e( 'Mailchimp lists', 'wordpress-lucky-wheel' ) ?></label>
                            </th>
                            <td>
                                <select class="select-who vi-ui fluid dropdown" name="mailchimp_lists"
                                        id="mailchimp_lists">
									<?php
									$mailchimp  = new VI_WORDPRESS_LUCKY_WHEEL_Admin_Mailchimp();
									$mail_lists = $mailchimp->get_lists();
									if ( ! $mail_lists ) {
										$mail_lists = array();
									}

									if ( count( $mail_lists ) ) {
										foreach ( $mail_lists as $key_m => $mail_list ) {
											echo "<option value='$key_m' " . selected( $this->settings->get_params( 'mailchimp', 'lists' ), $key_m ) . ">$mail_list</option>";
										}
									}
									?>
                                </select>
								<?php
								if ( count( $this->languages ) ) {
									foreach ( $this->languages as $key => $value ) {
										?>
                                        <p>
                                            <label for="<?php echo 'mailchimp_lists_' . $value; ?>"><?php
												if ( isset( $this->languages_data[ $value ]['country_flag_url'] ) && $this->languages_data[ $value ]['country_flag_url'] ) {
													?>
                                                    <img src="<?php echo esc_url( $this->languages_data[ $value ]['country_flag_url'] ); ?>">
													<?php
												}
												echo $value;
												if ( isset( $this->languages_data[ $value ]['translated_name'] ) ) {
													echo '(' . $this->languages_data[ $value ]['translated_name'] . ')';
												}
												?>:</label>
                                        </p>
                                        <select class="select-who vi-ui fluid dropdown"
                                                name="<?php echo 'mailchimp_lists_' . $value; ?>"
                                                id="<?php echo 'mailchimp_lists_' . $value; ?>">
											<?php
											$mail_lists = $mailchimp->get_lists();
											if ( ! $mail_lists ) {
												$mail_lists = array();
											}

											if ( count( $mail_lists ) ) {
												foreach ( $mail_lists as $key_m => $mail_list ) {
													echo "<option value='$key_m' " . selected( $this->settings->get_params( 'mailchimp', 'lists', $value ), $key_m ) . ">$mail_list</option>";
												}
											}
											?>
                                        </select>
										<?php
									}
								}
								?>
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                        </tr>

                        <tr valign="top">
                            <th scope="row">
                                <label for="wplwl_enable_active_campaign"><?php esc_html_e( 'Active Campaign', 'wordpress-lucky-wheel' ) ?></label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox checked">
                                    <input type="checkbox" name="wplwl_enable_active_campaign"
                                           id="wplwl_enable_active_campaign" <?php checked( $this->settings->get_params( 'active_campaign', 'enable' ), 'on' ) ?>>
                                    <label for="wplwl_enable_active_campaign"><?php esc_html_e( 'Enable', 'wordpress-lucky-wheel' ) ?></label>
                                </div>

                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="wplwl_active_campaign_key"></label><?php esc_html_e( 'Active Campaign API Key', 'wordpress-lucky-wheel' ) ?>
                            </th>
                            <td>
                                <input type="text" id="wplwl_active_campaign_key" name="wplwl_active_campaign_key"
                                       value="<?php echo $this->settings->get_params( 'active_campaign', 'key' ); ?>">

                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="wplwl_active_campaign_url"></label><?php esc_html_e( 'Active Campaign API URL', 'wordpress-lucky-wheel' ) ?>
                            </th>
                            <td>
                                <input type="text" id="wplwl_active_campaign_url" name="wplwl_active_campaign_url"
                                       value="<?php echo $this->settings->get_params( 'active_campaign', 'url' ); ?>">

                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="wplwl_active_campaign_list"><?php esc_html_e( 'Active Campaign list', 'wordpress-lucky-wheel' ) ?></label>
                            </th>
                            <td>
                                <select class="wplwl-ac-search-list" name="wplwl_active_campaign_list">
									<?php
									if ( $this->settings->get_params( 'active_campaign', 'list' ) ) {
										?>
                                        <option value="<?php echo $this->settings->get_params( 'active_campaign', 'list' ); ?>"
                                                selected>
											<?php
											$active_campaign = new VI_WORDPRESS_LUCKY_WHEEL_Admin_Active_Campaign();
											$result          = $active_campaign->list_view( $this->settings->get_params( 'active_campaign', 'list' ) );
											if ( isset( $result['name'] ) && $result['name'] ) {
												echo $result['name'];
											}
											?>
                                        </option>
										<?php
									}
									?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="wplwl_sendgrid_enable"><?php esc_html_e( 'SendGrid', 'wordpress-lucky-wheel' ) ?></label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox checked">
                                    <input type="checkbox" name="wplwl_sendgrid_enable"
                                           id="wplwl_sendgrid_enable" <?php checked( $this->settings->get_params( 'sendgrid', 'enable' ), 'on' ) ?>>
                                    <label for="wplwl_sendgrid_enable"><?php esc_html_e( 'Enable', 'wordpress-lucky-wheel' ) ?></label>
                                </div>

                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="wplwl_sendgrid_key"></label><?php esc_html_e( 'SendGrid API Key', 'wordpress-lucky-wheel' ) ?>
                            </th>
                            <td>
                                <input type="text" id="wplwl_sendgrid_key" name="wplwl_sendgrid_key"
                                       value="<?php echo $this->settings->get_params( 'sendgrid', 'key' ); ?>">
                                <p><?php esc_html_e( '*This is the API key that\'s shown only once when your created it, not the API key ID.', 'wordpress-lucky-wheel' ) ?></p>
                                <p><?php esc_html_e( '**This API Key must have full-access permission of API Keys. You can set it ', 'wordpress-lucky-wheel' ) ?>
                                    <a href="https://app.sendgrid.com/settings/api_keys"
                                       target="_blank"><?php esc_html_e( 'here.', 'wordpress-lucky-wheel' ) ?></a>
                                </p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="sendgrid_lists"><?php esc_html_e( 'Sendgrid lists', 'wordpress-lucky-wheel' ) ?></label>
                            </th>
                            <td>
                                <select class="select-who vi-ui fluid dropdown" name="sendgrid_lists"
                                        id="sendgrid_lists">
                                    <option value="none"><?php esc_html_e( 'Do not add to any list', 'wordpress-lucky-wheel' ) ?></option>
									<?php
									$sendgrid      = new VI_WORDPRESS_LUCKY_WHEEL_Admin_Sendgrid();
									$mail_lists    = $sendgrid->get_lists();
									$sendgrid_list = $this->settings->get_params( 'sendgrid', 'list' );
									if ( is_array( $mail_lists ) && count( $mail_lists ) ) {
										foreach ( $mail_lists as $key_m => $mail_list ) {
											?>
                                            <option value="<?php echo $mail_list->id ?>" <?php selected( $sendgrid_list, $mail_list->id ) ?>><?php echo $mail_list->name ?></option>
											<?php
										}
									}
									?>
                                </select>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="vi-ui bottom attached tab segment" data-tab="update">
                    <table class="form-table">
                        <tbody>
                        <tr valign="top">
                            <th scope="row">
                                <label for="auto-update-key"></label><?php esc_html_e( 'Auto update key', 'wordpress-lucky-wheel' ) ?>
                            </th>
                            <td>
                                <div class="fields">
                                    <div class="ten wide field">
                                        <input type="text" name="wplwl_update_key" id="auto-update-key"
                                               class="villatheme-autoupdate-key-field"
                                               value="<?php echo $this->settings->get_params( 'key' ); ?>">
                                    </div>
                                    <div class="six wide field">
                                        <span class="vi-ui button green villatheme-get-key-button"
                                              data-href="https://api.envato.com/authorization?response_type=code&client_id=villatheme-download-keys-6wzzaeue&redirect_uri=https://villatheme.com/update-key"
                                              data-id="21800061"><?php echo esc_html__( 'Get Key', 'wordpress-lucky-wheel' ) ?></span>
                                    </div>
                                </div>

								<?php do_action( 'wordpress-lucky-wheel_key' ) ?>
                                <p class="description"><?php _e( 'Please fill your key what you get from https://villatheme.com/my-download. See <a target="_blank" href="https://villatheme.com/knowledge-base/how-to-use-auto-update-feature/">guide</a>.', 'wordpress-lucky-wheel' ) ?>
                                </p>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <p><input id="submit" type="submit" class="vi-ui primary button" name="submit"
                          value="<?php esc_html_e( 'Save', 'wordpress-lucky-wheel' ); ?>">
                    <input type="submit" class="vi-ui button"
                           name="wplwl_check_key"
                           value="<?php esc_html_e( 'Save & Check Key', 'wordpress-lucky-wheel' ); ?>">

                </p>

            </form>
        </div>
        <div class="wordpress-lucky-wheel-preview preview-html-hidden">
            <div class="wordpress-lucky-wheel-preview-overlay"></div>
            <div class="wordpress-lucky-wheel-preview-html">
                <canvas id="wplwl_canvas"></canvas>
                <canvas id="wplwl_canvas1"></canvas>
                <canvas id="wplwl_canvas2"></canvas>
            </div>
        </div>
		<?php
		do_action( 'villatheme_support_wordpress-lucky-wheel' );
	}

	public function check_update() {
		/**
		 * Check update
		 */
		$key = $this->settings->get_params( 'key' );
		/*Check update*/
		if ( class_exists( 'VillaTheme_Plugin_Check_Update' ) ) {
			$setting_url = admin_url( '?page=wordpress-lucky-wheel' );
			new VillaTheme_Plugin_Check_Update (
				VI_WORDPRESS_LUCKY_WHEEL_VERSION,                    // current version
				'https://villatheme.com/wp-json/downloads/v3',  // update path
				'wordpress-lucky-wheel/wordpress-lucky-wheel.php',                  // plugin file slug
				'wordpress-lucky-wheel', '13600', $key, $setting_url
			);
			new VillaTheme_Plugin_Updater( 'wordpress-lucky-wheel/wordpress-lucky-wheel.php', 'wordpress-lucky-wheel', $setting_url );

		}
	}

	public function save_settings() {
		global $wp_lucky_wheel_settings, $pagenow;
		if ( $pagenow == 'admin.php' && isset( $_REQUEST['page'] ) && $_REQUEST['page'] == 'wordpress-lucky-wheel' ) {
			/*wpml*/
			if ( is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' ) ) {
				global $sitepress;
				$default_lang           = $sitepress->get_default_language();
				$this->default_language = $default_lang;
				$languages              = icl_get_languages( 'skip_missing=N&orderby=KEY&order=DIR&link_empty_to=str' );
				$this->languages_data   = $languages;
				if ( count( $languages ) ) {
					foreach ( $languages as $key => $language ) {
						if ( $key != $default_lang ) {
							$this->languages[] = $key;
						}
					}
				}
			} elseif ( class_exists( 'Polylang' ) ) {
				/*Polylang*/
				$languages    = pll_languages_list();
				$default_lang = pll_default_language( 'slug' );
				foreach ( $languages as $language ) {
					if ( $language == $default_lang ) {
						continue;
					}
					$this->languages[] = $language;
				}
			}
			if ( empty( $_POST['wplwl_nonce_field'] ) || ! wp_verify_nonce( $_POST['wplwl_nonce_field'], 'wplwl_settings_page_save' ) ) {
				return;
			}
			if ( isset( $_POST['wplwl_check_key'] ) ) {
				delete_transient( '_site_transient_update_plugins' );
				delete_option( 'wordpress-lucky-wheel_messages' );
			}
			$args = array(
				'general'    => array(
					'enable'     => isset( $_POST['wplwl_enable'] ) ? sanitize_text_field( $_POST['wplwl_enable'] ) : 'off',
					'mobile'     => isset( $_POST['wplwl_enable_mobile'] ) ? sanitize_text_field( $_POST['wplwl_enable_mobile'] ) : 'off',
					'spin_num'   => isset( $_POST['wplwl_spin_num'] ) ? sanitize_text_field( $_POST['wplwl_spin_num'] ) : 0,
					'delay'      => isset( $_POST['wplwl_delay'] ) ? sanitize_text_field( $_POST['wplwl_delay'] ) : 0,
					'delay_unit' => isset( $_POST['wplwl_delay_unit'] ) ? sanitize_text_field( $_POST['wplwl_delay_unit'] ) : 's',
				),
				'notify'     => array(
					'position'           => isset( $_POST['notify_position'] ) ? sanitize_text_field( $_POST['notify_position'] ) : '',
					'size'               => isset( $_POST['notify_size'] ) ? sanitize_text_field( $_POST['notify_size'] ) : 0,
					'color'              => isset( $_POST['notify_color'] ) ? sanitize_text_field( $_POST['notify_color'] ) : '',
					'intent'             => isset( $_POST['notify_intent'] ) ? sanitize_text_field( $_POST['notify_intent'] ) : '',
					'show_again'         => isset( $_POST['notify_show_again'] ) ? sanitize_text_field( $_POST['notify_show_again'] ) : 0,
					'hide_popup'         => isset( $_POST['notify_hide_popup'] ) ? sanitize_text_field( $_POST['notify_hide_popup'] ) : 'off',
					'show_wheel'         => isset( $_POST['show_wheel'] ) ? sanitize_text_field( $_POST['show_wheel'] ) : '',
					'scroll_amount'      => isset( $_POST['scroll_amount'] ) ? sanitize_text_field( $_POST['scroll_amount'] ) : '',
					'show_again_unit'    => isset( $_POST['notify_show_again_unit'] ) ? sanitize_text_field( $_POST['notify_show_again_unit'] ) : 0,
					'show_only_front'    => isset( $_POST['notify_frontpage_only'] ) ? sanitize_text_field( $_POST['notify_frontpage_only'] ) : 'off',
					'show_only_blog'     => isset( $_POST['notify_blogpage_only'] ) ? sanitize_text_field( $_POST['notify_blogpage_only'] ) : 'off',
					'show_only_shop'     => isset( $_POST['notify_shop_only'] ) ? sanitize_text_field( $_POST['notify_shop_only'] ) : 'off',
					'conditional_tags'   => isset( $_POST['notify_conditional_tags'] ) ? stripslashes( sanitize_text_field( $_POST['notify_conditional_tags'] ) ) : '',
					'time_on_close'      => isset( $_POST['notify_time_on_close'] ) ? stripslashes( sanitize_text_field( $_POST['notify_time_on_close'] ) ) : '',
					'time_on_close_unit' => isset( $_POST['notify_time_on_close_unit'] ) ? stripslashes( sanitize_text_field( $_POST['notify_time_on_close_unit'] ) ) : '',
				),
				'wheel_wrap' => array(
					'description'            => isset( $_POST['wheel_wrap_description'] ) ? wp_kses_post( stripslashes( $_POST['wheel_wrap_description'] ) ) : '',
					'bg_image'               => isset( $_POST['wheel_wrap_bg_image'] ) ? sanitize_text_field( $_POST['wheel_wrap_bg_image'] ) : '',
					'bg_color'               => isset( $_POST['wheel_wrap_bg_color'] ) ? sanitize_text_field( $_POST['wheel_wrap_bg_color'] ) : '',
					'text_color'             => isset( $_POST['wheel_wrap_text_color'] ) ? sanitize_text_field( $_POST['wheel_wrap_text_color'] ) : '',
					'spin_button'            => isset( $_POST['wheel_wrap_spin_button'] ) ? sanitize_text_field( stripslashes( $_POST['wheel_wrap_spin_button'] ) ) : 'Try Your Lucky',
					'spin_button_color'      => isset( $_POST['wheel_wrap_spin_button_color'] ) ? sanitize_text_field( $_POST['wheel_wrap_spin_button_color'] ) : '',
					'spin_button_bg_color'   => isset( $_POST['wheel_wrap_spin_button_bg_color'] ) ? sanitize_text_field( $_POST['wheel_wrap_spin_button_bg_color'] ) : '',
					'pointer_position'       => isset( $_POST['pointer_position'] ) ? sanitize_text_field( $_POST['pointer_position'] ) : 'center',
					'pointer_color'          => isset( $_POST['pointer_color'] ) ? sanitize_text_field( $_POST['pointer_color'] ) : '',
					'wheel_center_image'     => isset( $_POST['wheel_center_image'] ) ? sanitize_text_field( $_POST['wheel_center_image'] ) : '',
					'wheel_center_color'     => isset( $_POST['wheel_center_color'] ) ? sanitize_text_field( $_POST['wheel_center_color'] ) : '',
					'wheel_border_color'     => isset( $_POST['wheel_border_color'] ) ? sanitize_text_field( $_POST['wheel_border_color'] ) : '',
					'wheel_dot_color'        => isset( $_POST['wheel_dot_color'] ) ? sanitize_text_field( $_POST['wheel_dot_color'] ) : '',
					'close_option'           => isset( $_POST['wheel_wrap_close_option'] ) ? sanitize_text_field( $_POST['wheel_wrap_close_option'] ) : '',
					'font'                   => isset( $_POST['wplwl_google_font_select'] ) ? sanitize_text_field( $_POST['wplwl_google_font_select'] ) : '',
					'gdpr'                   => isset( $_POST['gdpr_policy'] ) ? sanitize_textarea_field( $_POST['gdpr_policy'] ) : "off",
					'gdpr_message'           => isset( $_POST['gdpr_message'] ) ? wp_kses_post( stripslashes( $_POST['gdpr_message'] ) ) : "",
					'congratulations_effect' => isset( $_POST['congratulations_effect'] ) ? sanitize_text_field( $_POST['congratulations_effect'] ) : "",
					'background_effect'      => isset( $_POST['background_effect'] ) ? sanitize_text_field( $_POST['background_effect'] ) : "",
					'custom_css'             => isset( $_POST['custom_css'] ) ? wp_kses_post( stripslashes( $_POST['custom_css'] ) ) : "",
				),
				'wheel'      => array(
					'wheel_speed'       => isset( $_POST['wheel_speed'] ) ? sanitize_text_field( $_POST['wheel_speed'] ) : 5,
					'spinning_time'     => isset( $_POST['wheel_spinning_time'] ) ? sanitize_text_field( $_POST['wheel_spinning_time'] ) : 3,
					'prize_type'        => isset( $_POST['prize_type'] ) ? stripslashes_deep( array_map( 'sanitize_text_field', $_POST['prize_type'] ) ) : array(),
					'custom_value'      => isset( $_POST['custom_type_value'] ) ? array_map( 'wplwl_sanitize_text_field', $_POST['custom_type_value'] ) : array(),
					'custom_label'      => isset( $_POST['custom_type_label'] ) ? array_map( 'wplwl_sanitize_text_field', $_POST['custom_type_label'] ) : array(),
					'probability'       => isset( $_POST['probability'] ) ? array_map( 'sanitize_text_field', $_POST['probability'] ) : array(),
					'bg_color'          => isset( $_POST['bg_color'] ) ? array_map( 'sanitize_text_field', $_POST['bg_color'] ) : array(),
					'slices_text_color' => isset( $_POST['slices_text_color'] ) ? array_map( 'sanitize_text_field', $_POST['slices_text_color'] ) : array(),
					'slice_text_color'  => isset( $_POST['slice_text_color'] ) ? wp_kses_post( stripslashes( $_POST['slice_text_color'] ) ) : "",
					'show_full_wheel'   => isset( $_POST['show_full_wheel'] ) ? sanitize_text_field( $_POST['show_full_wheel'] ) : "",
					'font_size'         => isset( $_POST['font_size'] ) ? sanitize_text_field( $_POST['font_size'] ) : "",
					'wheel_size'        => isset( $_POST['wheel_size'] ) ? sanitize_text_field( $_POST['wheel_size'] ) : "",
					'random_color'      => isset( $_POST['random_color'] ) ? sanitize_text_field( $_POST['random_color'] ) : "",
				),

				'result'                            => array(
					'auto_close'   => isset( $_POST['result-auto_close'] ) ? sanitize_text_field( $_POST['result-auto_close'] ) : 0,
					'email'        => array(
						'from_name'             => isset( $_POST['from_name'] ) ? stripslashes( sanitize_text_field( $_POST['from_name'] ) ) : "",
						'from_address'          => isset( $_POST['from_address'] ) ? stripslashes( sanitize_text_field( $_POST['from_address'] ) ) : "",
						'subject'               => isset( $_POST['subject'] ) ? stripslashes( sanitize_text_field( $_POST['subject'] ) ) : "",
						'heading'               => isset( $_POST['heading'] ) ? stripslashes( sanitize_text_field( $_POST['heading'] ) ) : "",
						'content'               => isset( $_POST['content'] ) ? wp_kses_post( $_POST['content'] ) : "",
						'header_image'          => '',
						'footer_text'           => isset( $_POST['footer_text'] ) ? stripslashes( sanitize_text_field( $_POST['footer_text'] ) ) : "",
						'base_color'            => isset( $_POST['email_base_color'] ) ? sanitize_text_field( $_POST['email_base_color'] ) : '',
						'background_color'      => isset( $_POST['email_background_color'] ) ? sanitize_text_field( $_POST['email_background_color'] ) : '',
						'body_background_color' => isset( $_POST['email_body_background_color'] ) ? sanitize_text_field( $_POST['email_body_background_color'] ) : '',
						'body_text_color'       => isset( $_POST['email_body_text_color'] ) ? sanitize_text_field( $_POST['email_body_text_color'] ) : '',
					),
					'notification' => array(
						'win'  => isset( $_POST['result_win'] ) ? wp_kses_post( stripslashes( $_POST['result_win'] ) ) : "",
						'lost' => isset( $_POST['result_lost'] ) ? wp_kses_post( stripslashes( $_POST['result_lost'] ) ) : "",
					),
					'admin_email'  => array(
						'enable'  => isset( $_POST['admin_email_enable'] ) ? stripslashes( sanitize_text_field( $_POST['admin_email_enable'] ) ) : "off",
						'to'      => isset( $_POST['admin_email_to'] ) ? stripslashes( sanitize_text_field( $_POST['admin_email_to'] ) ) : "",
						'subject' => isset( $_POST['admin_email_subject'] ) ? stripslashes( sanitize_text_field( $_POST['admin_email_subject'] ) ) : "",
						'heading' => isset( $_POST['admin_email_heading'] ) ? stripslashes( sanitize_text_field( $_POST['admin_email_heading'] ) ) : "",
						'content' => isset( $_POST['admin_email_content'] ) ? wp_kses_post( $_POST['admin_email_content'] ) : "",
					)
				),
				'mailchimp'                         => array(
					'enable'  => isset( $_POST['mailchimp_enable'] ) ? sanitize_text_field( $_POST['mailchimp_enable'] ) : 'off',
					'api_key' => isset( $_POST['mailchimp_api'] ) ? sanitize_text_field( $_POST['mailchimp_api'] ) : '',
					'lists'   => isset( $_POST['mailchimp_lists'] ) ? sanitize_text_field( $_POST['mailchimp_lists'] ) : '',
				),
				'active_campaign'                   => array(
					'enable' => isset( $_POST['wplwl_enable_active_campaign'] ) ? sanitize_text_field( $_POST['wplwl_enable_active_campaign'] ) : 'off',
					'key'    => isset( $_POST['wplwl_active_campaign_key'] ) ? sanitize_text_field( $_POST['wplwl_active_campaign_key'] ) : '',
					'url'    => isset( $_POST['wplwl_active_campaign_url'] ) ? sanitize_text_field( $_POST['wplwl_active_campaign_url'] ) : '',
					'list'   => isset( $_POST['wplwl_active_campaign_list'] ) ? sanitize_text_field( $_POST['wplwl_active_campaign_list'] ) : '',
				),
				'key'                               => isset( $_POST['wplwl_update_key'] ) ? sanitize_text_field( $_POST['wplwl_update_key'] ) : '',
				'button_shop_title'                 => isset( $_POST['wplwl_button_shop_title'] ) ? sanitize_text_field( $_POST['wplwl_button_shop_title'] ) : '',
				'button_shop_url'                   => isset( $_POST['wplwl_button_shop_url'] ) ? sanitize_text_field( $_POST['wplwl_button_shop_url'] ) : '',
				'button_shop_color'                 => isset( $_POST['wplwl_button_shop_color'] ) ? sanitize_text_field( $_POST['wplwl_button_shop_color'] ) : '',
				'button_shop_bg_color'              => isset( $_POST['wplwl_button_shop_bg_color'] ) ? sanitize_text_field( $_POST['wplwl_button_shop_bg_color'] ) : '',
				'button_shop_size'                  => isset( $_POST['wplwl_button_shop_size'] ) ? sanitize_text_field( $_POST['wplwl_button_shop_size'] ) : '',
				'suggested_products'                => isset( $_POST['wplwl_suggested_products'] ) ? stripslashes_deep( $_POST['wplwl_suggested_products'] ) : '',
				'sendgrid'                          => array(
					'enable' => isset( $_POST['wplwl_sendgrid_enable'] ) ? sanitize_text_field( $_POST['wplwl_sendgrid_enable'] ) : '',
					'key'    => isset( $_POST['wplwl_sendgrid_key'] ) ? stripslashes( sanitize_text_field( $_POST['wplwl_sendgrid_key'] ) ) : '',
					'list'   => isset( $_POST['sendgrid_lists'] ) ? stripslashes( sanitize_text_field( $_POST['sendgrid_lists'] ) ) : '',
				),
				'ajax_endpoint'                     => isset( $_POST['ajax_endpoint'] ) ? sanitize_text_field( $_POST['ajax_endpoint'] ) : 'ajax',
				'custom_field_mobile_enable'        => isset( $_POST['custom_field_mobile_enable'] ) ? sanitize_text_field( $_POST['custom_field_mobile_enable'] ) : '',
				'custom_field_mobile_enable_mobile' => isset( $_POST['custom_field_mobile_enable_mobile'] ) ? sanitize_text_field( $_POST['custom_field_mobile_enable_mobile'] ) : '',
				'custom_field_mobile_required'      => isset( $_POST['custom_field_mobile_required'] ) ? sanitize_text_field( $_POST['custom_field_mobile_required'] ) : '',
				'custom_field_name_enable'          => isset( $_POST['custom_field_name_enable'] ) ? sanitize_text_field( $_POST['custom_field_name_enable'] ) : '',
				'custom_field_name_enable_mobile'   => isset( $_POST['custom_field_name_enable_mobile'] ) ? sanitize_text_field( $_POST['custom_field_name_enable_mobile'] ) : '',
				'custom_field_name_required'        => isset( $_POST['custom_field_name_required'] ) ? sanitize_text_field( $_POST['custom_field_name_required'] ) : '',
			);
			if ( count( $this->languages ) ) {
				foreach ( $this->languages as $key => $value ) {
					$args['result'][ 'email_' . $value ]            = array(
						'subject'     => isset( $_POST[ 'subject_' . $value ] ) ? wp_kses_post( stripslashes( $_POST[ 'subject_' . $value ] ) ) : "",
						'heading'     => isset( $_POST[ 'heading_' . $value ] ) ? wp_kses_post( stripslashes( $_POST[ 'heading_' . $value ] ) ) : "",
						'content'     => isset( $_POST[ 'content_' . $value ] ) ? wp_kses_post( stripslashes( $_POST[ 'content_' . $value ] ) ) : "",
						'footer_text' => isset( $_POST[ 'footer_text_' . $value ] ) ? wp_kses_post( stripslashes( $_POST[ 'footer_text_' . $value ] ) ) : "",
					);
					$args['result'][ 'notification_' . $value ]     = array(
						'win'  => isset( $_POST[ 'result_win_' . $value ] ) ? wp_kses_post( stripslashes( $_POST[ 'result_win_' . $value ] ) ) : "",
						'lost' => isset( $_POST[ 'result_lost_' . $value ] ) ? wp_kses_post( stripslashes( $_POST[ 'result_lost_' . $value ] ) ) : "",
					);
					$args['wheel_wrap'][ 'spin_button_' . $value ]  = isset( $_POST[ 'wheel_wrap_spin_button_' . $value ] ) ? sanitize_text_field( $_POST[ 'wheel_wrap_spin_button_' . $value ] ) : '';
					$args['wheel_wrap'][ 'description_' . $value ]  = isset( $_POST[ 'wheel_wrap_description_' . $value ] ) ? wp_kses_post( stripslashes( $_POST[ 'wheel_wrap_description_' . $value ] ) ) : '';
					$args['wheel_wrap'][ 'gdpr_message_' . $value ] = isset( $_POST[ 'gdpr_message_' . $value ] ) ? wp_kses_post( stripslashes( $_POST[ 'gdpr_message_' . $value ] ) ) : '';
					$args['mailchimp'][ 'lists_' . $value ]         = isset( $_POST[ 'mailchimp_lists_' . $value ] ) ? sanitize_text_field( $_POST[ 'mailchimp_lists_' . $value ] ) : '';
				}
			}

			if ( isset( $_POST['submit'] ) || isset( $_POST['wplwl_check_key'] ) ) {
				if ( $_POST['probability'] ) {
					if ( count( $_POST['probability'] ) < 3 ) {
						wp_die( 'There must be at least 3 rows!' );
					}
					if ( array_sum( $_POST['probability'] ) != 100 ) {
						wp_die( 'The total probability must be equal to 100%!' );
					}
				}
				if ( isset( $_POST['custom_type_label'] ) && is_array( $_POST['custom_type_label'] ) ) {
					foreach ( $_POST['custom_type_label'] as $key => $val ) {
						if ( $_POST['custom_type_label'][ $key ] === '' ) {
							add_action( 'admin_notices', function () {
								?>
                                <div class="updated">
                                    <p><?php esc_html_e( 'Label cannot be empty.', 'wordpress-lucky-wheel' ) ?></p>
                                </div>
								<?php
							} );

							return;
						}
						if ( isset( $_POST['custom_type_value'] ) && is_array( $_POST['custom_type_value'] ) ) {
							if ( $_POST['prize_type'][ $key ] == 'custom' && $_POST['custom_type_value'][ $key ] == '' ) {
								add_action( 'admin_notices', function () {
									?>
                                    <div class="updated">
                                        <p><?php esc_html_e( 'Please enter value for custom type.', 'wordpress-lucky-wheel' ) ?></p>
                                    </div>
									<?php
								} );

								return;
							}
						}
					}
				}

				$args = wp_parse_args( $args, get_option( '_wplwl_settings', $wp_lucky_wheel_settings ) );
				update_option( '_wplwl_settings', $args );
				$wp_lucky_wheel_settings = $args;
				add_action( 'admin_notices', function () {
					?>
                    <div class="updated">
                        <p><?php esc_html_e( 'Your settings have been saved!', 'wordpress-lucky-wheel' ) ?></p>
                    </div>
					<?php
				} );
			}
		}

	}

	public function export_emails() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		if ( isset( $_POST['submit'] ) && isset( $_POST['wplwl_export_nonce_field'] ) && wp_verify_nonce( $_POST['wplwl_export_nonce_field'], 'wplwl_export_nonce_field_action' ) ) {
			$start    = isset( $_POST['wplwl_export_start'] ) ? sanitize_text_field( $_POST['wplwl_export_start'] ) : '';
			$end      = isset( $_POST['wplwl_export_end'] ) ? sanitize_text_field( $_POST['wplwl_export_end'] ) : '';
			$filename = "wp_lucky_wheel_email_";
			if ( ! $start && ! $end ) {
				$args1    = array(
					'post_type'      => 'wplwl_email',
					'posts_per_page' => - 1,
					'post_status'    => 'publish',
				);
				$filename .= date( 'Y-m-d_h-i-s', time() ) . ".csv";
			} elseif ( ! $start ) {
				$args1    = array(
					'post_type'      => 'wplwl_email',
					'posts_per_page' => - 1,
					'post_status'    => 'publish',
					'date_query'     => array(
						array(
							'before'    => $end,
							'inclusive' => true

						)
					),
				);
				$filename .= 'before_' . $end . ".csv";
			} elseif ( ! $end ) {
				$args1    = array(
					'post_type'      => 'wplwl_email',
					'posts_per_page' => - 1,
					'post_status'    => 'publish',
					'date_query'     => array(
						array(
							'after'     => $start,
							'inclusive' => true
						)
					),

				);
				$filename .= 'from' . $start . 'to' . date( 'Y-m-d' ) . ".csv";
			} else {
				if ( strtotime( $start ) > strtotime( $end ) ) {
					wp_die( 'Incorrect input date' );
				}
				$args1    = array(
					'post_type'      => 'wplwl_email',
					'posts_per_page' => - 1,
					'post_status'    => 'publish',
					'date_query'     => array(
						array(
							'before'    => $end,
							'after'     => $start,
							'inclusive' => true

						)
					),
				);
				$filename .= 'from' . $start . 'to' . $end . ".csv";
			}
			$the_query        = new WP_Query( $args1 );
			$csv_source_array = array();
			$names            = array();
			$mobiles          = array();
			$coupons_labels   = array();
			if ( $the_query->have_posts() ) {
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					$id                 = get_the_ID();
					$csv_source_array[] = get_the_title();
					$names[]            = get_the_content();
					$mobiles[]          = get_post_meta( $id, 'wplwl_email_mobile', true );
					$label              = get_post_meta( $id, 'wplwl_email_labels', true );
					if ( is_array( $label ) && count( $label ) ) {
						$coupons_labels[] = implode( ", ", $label );
					}
				}
				wp_reset_postdata();
				$data_rows  = array();
				$header_row = array(
					'Order',
					'Email',
					'Name',
					'Mobile',
					'Prize',
				);
				$i          = 1;
				foreach ( $csv_source_array as $key => $result ) {
					$row         = array( $i, $result, $names[ $key ], $mobiles[ $key ], $coupons_labels[ $key ] );
					$data_rows[] = $row;
					$i ++;
				}
				header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
				header( 'Content-type: text/csv' );
				header( 'Content-Description: File Transfer' );
				header( 'Content-Disposition: attachment; filename=' . $filename );
				header( 'Expires: 0' );
				header( 'Pragma: public' );
				$fh = fopen( 'php://output', 'w' );
				fprintf( $fh, chr( 0xEF ) . chr( 0xBB ) . chr( 0xBF ) );
				fputcsv( $fh, $header_row );
				foreach ( $data_rows as $data_row ) {
					fputcsv( $fh, $data_row );
				}
				fclose( $fh );
				die;
			}
		}
	}

	public function report_callback() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$total_spin = $email_subscribe = $coupon_given = 0;

		$args      = array(
			'post_type'      => 'wplwl_email',
			'posts_per_page' => - 1,
			'post_status'    => 'publish',
		);
		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) {
			$email_subscribe = $the_query->post_count;
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$id = get_the_ID();
				if ( get_post_meta( $id, 'wplwl_spin_times', true ) ) {
					$total_spin += get_post_meta( $id, 'wplwl_spin_times', true )['spin_num'];
				}
				if ( get_post_meta( $id, 'wplwl_email_coupons', true ) ) {
					$coupon       = get_post_meta( $id, 'wplwl_email_coupons', true );
					$coupon_given += sizeof( $coupon );
				}
			}
			wp_reset_postdata();
		}

		?>
        <div class="wrap">
            <form action="" method="post">
				<?php wp_nonce_field( 'wplwl_export_nonce_field_action', 'wplwl_export_nonce_field' ); ?>
                <h2><?php esc_html_e( 'Lucky Wheel Report', 'wordpress-lucky-wheel' ) ?></h2>
                <table cellspacing="0" id="status" class="widefat">
                    <tbody>
                    <tr>
                        <th><?php esc_html_e( 'Total Spins', 'wordpress-lucky-wheel' ) ?></th>
                        <th><?php esc_html_e( 'Emails Subcribed', 'wordpress-lucky-wheel' ) ?></th>
                        <th><?php esc_html_e( 'Coupon Given', 'wordpress-lucky-wheel' ) ?></th>
                    </tr>
                    <tr>
                        <td><?php echo $total_spin; ?></td>
                        <td><?php echo $email_subscribe; ?></td>
                        <td><?php echo $coupon_given; ?></td>
                    </tr>
                    </tbody>

                </table>
                <label for="wplwl_export_start"><?php esc_html_e( 'From', 'wordpress-lucky-wheel' ); ?></label><input
                        type="date" name="wplwl_export_start" id="wplwl_export_start" class="wplwl_export_date">
                <label for="wplwl_export_end"><?php esc_html_e( 'To', 'wordpress-lucky-wheel' ); ?></label><input
                        type="date" name="wplwl_export_end" id="wplwl_export_end" class="wplwl_export_date">

                <input id="submit"
                       type="submit"
                       class="button-primary"
                       name="submit"
                       value="<?php esc_html_e( 'Export Emails', 'wordpress-lucky-wheel' ); ?>"/>
            </form>
        </div>
		<?php
	}

	function system_status() {
		?>
        <div class="wrap">
            <h2><?php esc_html_e( 'System Status', 'wordpress-lucky-wheel' ) ?></h2>
            <table cellspacing="0" id="status" class="widefat">
                <tbody>
                <tr>
                    <td data-export-label="file_get_contents"><?php esc_html_e( 'file_get_contents', 'wordpress-lucky-wheel' ) ?></td>
                    <td>
						<?php
						if ( function_exists( 'file_get_contents' ) ) {
							echo '<span class="wplwl-status-ok">&#10004;</span> ';
						} else {
							echo '<span class="wplwl-status-error">&#10005; </span>';
						}
						?>
                    </td>
                </tr>
                <tr>
                    <td data-export-label="<?php esc_html_e( 'Allow URL Open', 'wordpress-lucky-wheel' ) ?>"><?php esc_html_e( 'Allow URL Open', 'wordpress-lucky-wheel' ) ?></td>
                    <td>
						<?php
						if ( ini_get( 'allow_url_fopen' ) == 'On' ) {
							echo '<span class="wplwl-status-ok">&#10004;</span> ';
						} else {
							echo '<span class="wplwl-status-error">&#10005;</span>';
						}
						?>
                </tr>
                </tbody>
            </table>
        </div>
		<?php
	}

	public static function auto_color() {
		$palette     = '{
  "red": {
    "100": "#ffcdd2",
    "900": "#b71c1c",
    "300": "#e57373",
    "600": "#e53935"
  },
  "purple": {
    "100": "#e1bee7",
    "900": "#4a148c",
    "300": "#ba68c8",
    "600": "#8e24aa"
  },
  "deeppurple": {
    "100": "#d1c4e9",
    "900": "#311b92",
     "300": "#9575cd",
    "600": "#5e35b1"
  },
  "indigo": {
    "100": "#c5cae9",
    "900": "#1a237e",
    "300": "#7986cb",
    "600": "#3949ab"
  },
  "blue": {
    "100": "#bbdefb",
     "300": "#64b5f6",
    "600": "#1e88e5",
    "900": "#0d47a1"
  },
  "teal": {
    "100": "#b2dfdb",
    "900": "#004d40",
    "300": "#4db6ac",
    "600": "#00897b"
  },
  "green": {
    "100": "#c8e6c9",
    "900": "#1b5e20",
    "300": "#81c784",
    "600": "#43a047"
  },
  "lime": {
    "100": "#f0f4c3",
    "900": "#827717",
     "300": "#dce775",
    "600": "#c0ca33"
  },
  "yellow": {
    "100": "#fff9c4",
    "900": "#f57f17",
    "300": "#fff176",
    "600": "#fdd835"
  },
  "orange": {
    "100": "#ffe0b2",
    "900": "#e65100",
    "300": "#ffb74d",
    "600": "#fb8c00"
  },
  "brown": {
    "100": "#d7ccc8",
    "900": "#3e2723",
     "300": "#a1887f",
    "600": "#6d4c41"
  },
  "bluegrey": {
    "100": "#cfd8dc",
    "900": "#263238",
    "300": "#90a4ae",
    "600": "#546e7a"
  }
}';
		$palette     = json_decode( $palette );
		$color_array = array();
		foreach ( $palette as $colors ) {
			$color_row = array();
			foreach ( $colors as $color ) {
				$color_row[] = $color;
			}
			$color_array[] = $color_row;
		}
		$color_array[] = array(
			'#e6194b',
			'#3cb44b',
			'#ffe119',
			'#0082c8',
			'#f58231',
			'#911eb4',
			'#46f0f0',
			'#f032e6',
			'#d2f53c',
			'#fabebe',
			'#008080',
			'#e6beff',
			'#aa6e28',
			'#fffac8',
			'#800000',
			'#aaffc3',
			'#808000',
			'#ffd8b1',
			'#000080',
			'#808080',
			'#FFFFFF',
			'#000000'
		);
		echo '<div class="color_palette" style="display: none;">';
		foreach ( $color_array as $colors ) {
			echo '<div>';
			$i = 0;
			foreach ( $colors as $color ) {
				echo '<div class="wplwl_color_palette" data-color_code="' . $color . '" style="width: 20px;height: 20px;float:left;border:1px solid #ffffff;background-color: ' . $color . ';';
				if ( $i == ( sizeof( $colors ) - 1 ) ) {
					echo 'display:block;';
				} else {
					echo 'display:none;';
				}
				echo '"></div>';
				$i ++;
			}
			echo '</div>';
		}

		echo '</div>';
		echo '<div class="auto_color_ok_cancel"><div class="vi-ui buttons"><span class="auto_color_ok positive vi-ui button">' . esc_html__( 'OK', 'wordpress-lucky-wheel' ) . '</span>';
		echo '<div class="or"></div><span class="auto_color_cancel vi-ui button">' . esc_html__( 'Cancel', 'wordpress-lucky-wheel' ) . '</span></div></div>';
	}
}