<?php

/**
 * Class VI_WORDPRESS_LUCKY_WHEEL_Frontend_Shortcode
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class VI_WORDPRESS_LUCKY_WHEEL_Frontend_Shortcode {
	protected $settings;
	protected $language;
	protected $prefix;
	protected $pointer_position;

	public function __construct() {
		$this->settings = new VI_WORDPRESS_LUCKY_WHEEL_DATA();
		$this->language = '';
		$this->prefix   = 'wp-lucky-wheel-shortcode-';
		if ( 'on' == $this->settings->get_params( 'general', 'enable' ) ) {
			add_action( 'init', array( $this, 'init' ) );
			add_action( 'elementor/frontend/after_enqueue_scripts', array(
				$this,
				'wp_enqueue_scripts_elementor'
			), 99 );
			add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ), 99 );
		}
	}


	public function set( $name ) {
		if ( is_array( $name ) ) {
			return implode( ' ', array_map( array( $this, 'set' ), $name ) );
		} else {
			return esc_attr__( $this->prefix . $name );
		}
	}

	public function init() {
		add_shortcode( 'wordpress_lucky_wheel', array( $this, 'wordpress_lucky_wheel' ) );
	}

	public function wp_enqueue_scripts_elementor() {
		if ( ! wp_script_is( 'wordpress-lucky-wheel-shortcode' ) ) {
			wp_enqueue_style( 'wordpress-lucky-wheel-shortcode', VI_WORDPRESS_LUCKY_WHEEL_CSS . 'shortcode.css', array(), VI_WORDPRESS_LUCKY_WHEEL_VERSION );
			wp_enqueue_script( 'wordpress-lucky-wheel-shortcode', VI_WORDPRESS_LUCKY_WHEEL_JS . 'shortcode.js', array(), VI_WORDPRESS_LUCKY_WHEEL_VERSION );
		}
	}

	public function wp_enqueue_scripts() {
		if ( ! wp_script_is( 'wordpress-lucky-wheel-shortcode', 'registered' ) ) {
			wp_register_style( 'wordpress-lucky-wheel-shortcode', VI_WORDPRESS_LUCKY_WHEEL_CSS . 'shortcode.css', array(), VI_WORDPRESS_LUCKY_WHEEL_VERSION );
			wp_register_script( 'wordpress-lucky-wheel-shortcode', VI_WORDPRESS_LUCKY_WHEEL_JS . 'shortcode.js', array(), VI_WORDPRESS_LUCKY_WHEEL_VERSION );
		}
	}

	function is_valid_url( $url ) {

		// Must start with http:// or https://.
		if ( 0 !== strpos( $url, 'http://' ) && 0 !== strpos( $url, 'https://' ) ) {
			return false;
		}

		// Must pass validation.
		if ( ! filter_var( $url, FILTER_VALIDATE_URL ) ) {
			return false;
		}

		return true;
	}

	public function wordpress_lucky_wheel( $atts ) {
		global $wplwl_shortcode_id;
		if ( $wplwl_shortcode_id === null ) {
			$wplwl_shortcode_id = 1;
		} else {
			$wplwl_shortcode_id ++;
		}
		$shortcode_id     = "wordpress-lucky-wheel-shortcode-{$wplwl_shortcode_id}";
		$shortcode_id_css = "#{$shortcode_id}.wp-lucky-wheel-shortcode-container";
		$args             = shortcode_atts(
			array(
				'bg_image'                          => $this->settings->get_params( 'wheel_wrap', 'bg_image' ),
				'bg_color'                          => $this->settings->get_params( 'wheel_wrap', 'bg_color' ),
				'text_color'                        => $this->settings->get_params( 'wheel_wrap', 'text_color' ),
				'pointer_color'                     => $this->settings->get_params( 'wheel_wrap', 'pointer_color' ),
				'spin_button_color'                 => $this->settings->get_params( 'wheel_wrap', 'spin_button_color' ),
				'pointer_position'                  => $this->settings->get_params( 'wheel_wrap', 'pointer_position' ),
				'spin_button_bg_color'              => $this->settings->get_params( 'wheel_wrap', 'spin_button_bg_color' ),
				'wheel_dot_color'                   => $this->settings->get_params( 'wheel_wrap', 'wheel_dot_color' ),
				'wheel_border_color'                => $this->settings->get_params( 'wheel_wrap', 'wheel_border_color' ),
				'wheel_center_color'                => $this->settings->get_params( 'wheel_wrap', 'wheel_center_color' ),
				'spinning_time'                     => $this->settings->get_params( 'wheel', 'spinning_time' ),
				'wheel_speed'                       => $this->settings->get_params( 'wheel', 'wheel_speed' ),
				'custom_field_name_enable'          => $this->settings->get_params( 'custom_field_name_enable' ),
				'custom_field_name_enable_mobile'   => $this->settings->get_params( 'custom_field_name_enable_mobile' ),
				'custom_field_name_required'        => $this->settings->get_params( 'custom_field_name_required' ),
				'custom_field_mobile_enable'        => $this->settings->get_params( 'custom_field_mobile_enable' ),
				'custom_field_mobile_enable_mobile' => $this->settings->get_params( 'custom_field_mobile_enable_mobile' ),
				'custom_field_mobile_required'      => $this->settings->get_params( 'custom_field_mobile_required' ),
				'font_size'                         => $this->settings->get_params( 'wheel', 'font_size' ),
				'wheel_size'                        => $this->settings->get_params( 'wheel', 'wheel_size' ),
				'congratulations_effect'            => $this->settings->get_params( 'wheel_wrap', 'congratulations_effect' ),
				'center_image'                      => wp_get_attachment_url( $this->settings->get_params( 'wheel_wrap', 'wheel_center_image' ) ),
				'class'                             => '',
				'is_elementor'                      => 'no',
			), $atts );
		if ( ! wp_script_is( 'wordpress-lucky-wheel-shortcode' ) ) {
			wp_enqueue_style( 'wordpress-lucky-wheel-shortcode' );
			wp_enqueue_script( 'wordpress-lucky-wheel-shortcode' );
			if ( $this->settings->get_params( 'wheel_wrap', 'congratulations_effect' ) == 'firework' ) {
				if ( ! wp_style_is( 'wordpress-lucky-wheel-frontend-style-firework' ) ) {
					wp_enqueue_style( 'wordpress-lucky-wheel-frontend-style-firework', VI_WORDPRESS_LUCKY_WHEEL_CSS . 'firework.css', array(), VI_WORDPRESS_LUCKY_WHEEL_VERSION );
				}
			}
		}
		if ( is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' ) ) {
			$default_lang     = apply_filters( 'wpml_default_language', null );
			$current_language = apply_filters( 'wpml_current_language', null );

			if ( $current_language && $current_language !== $default_lang ) {
				$this->language = $current_language;
			}
		} else if ( class_exists( 'Polylang' ) ) {
			$default_lang     = pll_default_language( 'slug' );
			$current_language = pll_current_language( 'slug' );
			if ( $current_language && $current_language !== $default_lang ) {
				$this->language = $current_language;
			}
		}
		/*css*/
		if ( $args['is_elementor'] !== 'yes' ) {
			$css = "{$shortcode_id_css}{";
			if ( $args['bg_image'] ) {
				$bg_image_url = $this->is_valid_url( $args['bg_image'] ) ? $args['bg_image'] : wp_get_attachment_url( $args['bg_image'] );
				if ( $bg_image_url ) {
					$css .= 'background-image:url("' . $bg_image_url . '");';
				}
			}
			if ( $args['bg_color'] ) {
				$css .= 'background-color:' . $args['bg_color'] . ';';
			}

			if ( $args['text_color'] ) {
				$css .= 'color:' . $args['text_color'] . ';';
			}
			$css .= '}';

			if ( $args['pointer_color'] ) {
				$css .= "{$shortcode_id_css} .wp-lucky-wheel-shortcode-wheel-pointer:before{color: {$args['pointer_color']};}";
			}
			//wheel wrap design
			$css .= "{$shortcode_id_css} .wp-lucky-wheel-shortcode-wheel-button-wrap{";
			if ( $args['spin_button_color'] ) {
				$css .= 'color:' . $args['spin_button_color'] . ';';
			}

			if ( $args['spin_button_bg_color'] ) {
				$css .= 'background-color:' . $args['spin_button_bg_color'] . ';';
			}
			$css .= '}';

			wp_add_inline_style( 'wordpress-lucky-wheel-shortcode', $css );
		}
		/*params*/
		$wheel                  = $this->settings->get_params( 'wheel' );
		$this->pointer_position = $args['pointer_position'];
		if ( $this->pointer_position == 'random' ) {
			$pointer_positions      = array(
				'center',
				'top',
				'right',
				'bottom',
			);
			$ran                    = rand( 0, 3 );
			$this->pointer_position = $pointer_positions[ $ran ];
		}
		$args            = wp_parse_args( $args, array(
			'ajaxurl'                     => $this->settings->get_params( 'ajax_endpoint' ) == 'ajax' ? ( admin_url( 'admin-ajax.php?action=wplwl_get_email' ) ) : site_url() . '/wp-json/wordpress_lucky_wheel/spin',
			'pointer_position'            => $this->pointer_position,
			'gdpr'                        => $this->settings->get_params( 'wheel_wrap', 'gdpr' ),
			'gdpr_warning'                => esc_html__( 'Please agree with our term and condition.', 'wordpress-lucky-wheel' ),
			'color'                       => $this->settings->get_params( 'wheel', 'random_color' ) == 'on' ? $this->get_random_color() : $wheel['bg_color'],
			'slices_text_color'           => $this->settings->get_params( 'wheel', 'slices_text_color' ),
			'prize_type'                  => $wheel['prize_type'],
			'label'                       => $wheel['custom_label'],
			'empty_email_warning'         => esc_html__( '*Please enter your email', 'wordpress-lucky-wheel' ),
			'invalid_email_warning'       => esc_html__( '*Please enter a valid email address', 'wordpress-lucky-wheel' ),
			'custom_field_name_message'   => esc_html__( '*Name is required!', 'wordpress-lucky-wheel' ),
			'custom_field_mobile_message' => esc_html__( '*Mobile is required!', 'wordpress-lucky-wheel' ),
			'language'                    => $this->language,
		) );
		$container_class = array( 'container', 'pointer-position-' . $this->pointer_position );
		if ( $this->pointer_position !== 'center' ) {
			$container_class[] = 'margin-position';
		}
		$shortcode_class = $this->set( $container_class );
		if ( $args['class'] ) {
			$shortcode_class .= ' ' . $args['class'];
		}
		ob_start();
		?>
        <div id="<?php echo esc_attr( $shortcode_id ) ?>" class="<?php echo $shortcode_class ?>"
             data-shortcode_args="<?php echo esc_attr( json_encode( $args ) ) ?>">
            <div class="<?php echo $this->set( 'wheel-container' ) ?>">
                <div class="<?php echo $this->set( 'wheel-canvas' ) ?>">
                    <canvas class="<?php echo $this->set( 'wheel-canvas-1' ) ?>"
                            id="<?php echo $this->set( 'wheel-canvas-1' ) ?>">
                    </canvas>
                    <canvas class="<?php echo $this->set( 'wheel-canvas-2' ) ?>"
                            id="<?php echo $this->set( 'wheel-canvas-2' ) ?>">
                    </canvas>
                    <canvas class="<?php echo $this->set( 'wheel-canvas-3' ) ?>">
                    </canvas>
                    <div class="<?php echo $this->set( 'wheel-pointer-container' ) ?>">
                        <div class="<?php echo $this->set( 'wheel-pointer-before' ) ?>">
                        </div>
                        <div class="<?php echo $this->set( 'wheel-pointer-main' ) ?>">
                            <span class="wplwl-location <?php echo $this->set( array(
	                            'wheel-pointer',
	                            'wheel-pointer-' . $this->pointer_position
                            ) ) ?>"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="<?php echo $this->set( 'content-container' ) ?>">
                <div class="<?php echo $this->set( 'wheel-description' ) ?>">
					<?php echo do_shortcode( $this->settings->get_params( 'wheel_wrap', 'description', $this->language ) ); ?>
                </div>
                <div class="wplwl-congratulations-effect">
                    <div class="wplwl-congratulations-effect-before"></div>
                    <div class="wplwl-congratulations-effect-after"></div>
                </div>
                <div class="<?php echo $this->set( 'wheel-fields-container' ) ?>">
					<?php
					if ( 'on' == $args['custom_field_name_enable'] ) {
						?>
                        <div class="<?php echo $this->set( array( 'wheel-field-name-wrap', 'wheel-field-wrap' ) ) ?>">
                            <input type="text"
                                   class="<?php echo $this->set( array( 'wheel-field-name', 'wheel-field' ) ) ?>"
                                   placeholder="<?php esc_attr_e( 'Please enter your name', 'wordpress-lucky-wheel' ) ?>">
                        </div>
						<?php
					}
					if ( 'on' == $args['custom_field_mobile_enable'] ) {
						?>
                        <div class="<?php echo $this->set( array( 'wheel-field-mobile-wrap', 'wheel-field-wrap' ) ) ?>">
                            <input type="text"
                                   class="<?php echo $this->set( array( 'wheel-field-mobile', 'wheel-field' ) ) ?>"
                                   placeholder="<?php esc_attr_e( 'Please enter your mobile', 'wordpress-lucky-wheel' ) ?>">
                        </div>
						<?php
					}
					?>
                    <div class="<?php echo $this->set( array( 'wheel-field-email-wrap', 'wheel-field-wrap' ) ) ?>">
                        <span class="<?php echo $this->set( array(
	                        'wheel-field-error-email',
	                        'wheel-field-error'
                        ) ) ?>"></span>
                        <input type="email"
                               class="<?php echo $this->set( array( 'wheel-field-email', 'wheel-field' ) ) ?>"
                               placeholder="<?php esc_attr_e( "Please enter your email", 'wordpress-lucky-wheel' ) ?>">
                    </div>
                    <div class="<?php echo $this->set( array( 'wheel-button-wrap' ) ) ?>">
                        <span class="<?php echo $this->set( array( 'wheel-button' ) ) ?>"><?php echo $this->settings->get_params( 'wheel_wrap', 'spin_button', $this->language ); ?></span>
                    </div>
					<?php
					if ( 'on' == $this->settings->get_params( 'wheel_wrap', 'gdpr' ) ) {
						$gdpr_message = $this->settings->get_params( 'wheel_wrap', 'gdpr_message', $this->language );
						if ( empty( $gdpr_message ) ) {
							$gdpr_message = esc_html__( 'I agree with the term and condition', 'wordpress-lucky-wheel' );
						}
						?>
                        <div class="<?php echo $this->set( array( 'wheel-gdpr-wrap' ) ) ?>">
                            <input type="checkbox">
                            <span><?php echo $gdpr_message ?></span>
                        </div>
						<?php
					}
					?>
                </div>
            </div>
            <div class="<?php echo $this->set( 'result-container' ) ?>">
            </div>
        </div>

		<?php
		return ob_get_clean();
	}

	public function get_random_color() {
		$colors_array = array(
			array(
				"#ffcdd2",
				"#b71c1c",
				"#e57373",
				"#e53935",
				"#ffcdd2",
				"#b71c1c",
				"#e57373",
				"#e53935",
				"#ffcdd2",
				"#b71c1c",
				"#e57373",
				"#e53935",
				"#ffcdd2",
				"#b71c1c",
				"#e57373",
				"#e53935",
				"#ffcdd2",
				"#b71c1c",
				"#e57373",
				"#e53935",
			),
			array(
				"#e1bee7",
				"#4a148c",
				"#ba68c8",
				"#8e24aa",
				"#e1bee7",
				"#4a148c",
				"#ba68c8",
				"#8e24aa",
				"#e1bee7",
				"#4a148c",
				"#ba68c8",
				"#8e24aa",
				"#e1bee7",
				"#4a148c",
				"#ba68c8",
				"#8e24aa",
				"#e1bee7",
				"#4a148c",
				"#ba68c8",
				"#8e24aa",
			),
			array(
				"#d1c4e9",
				"#311b92",
				"#9575cd",
				"#5e35b1",
				"#d1c4e9",
				"#311b92",
				"#9575cd",
				"#5e35b1",
				"#d1c4e9",
				"#311b92",
				"#9575cd",
				"#5e35b1",
				"#d1c4e9",
				"#311b92",
				"#9575cd",
				"#5e35b1",
				"#d1c4e9",
				"#311b92",
				"#9575cd",
				"#5e35b1",
			),
			array(
				"#c5cae9",
				"#1a237e",
				"#7986cb",
				"#3949ab",
				"#c5cae9",
				"#1a237e",
				"#7986cb",
				"#3949ab",
				"#c5cae9",
				"#1a237e",
				"#7986cb",
				"#3949ab",
				"#c5cae9",
				"#1a237e",
				"#7986cb",
				"#3949ab",
				"#c5cae9",
				"#1a237e",
				"#7986cb",
				"#3949ab",
			),
			array(
				"#bbdefb",
				"#64b5f6",
				"#1e88e5",
				"#0d47a1",
				"#bbdefb",
				"#64b5f6",
				"#1e88e5",
				"#0d47a1",
				"#bbdefb",
				"#64b5f6",
				"#1e88e5",
				"#0d47a1",
				"#bbdefb",
				"#64b5f6",
				"#1e88e5",
				"#0d47a1",
				"#bbdefb",
				"#64b5f6",
				"#1e88e5",
				"#0d47a1",
			),
			array(
				"#b2dfdb",
				"#004d40",
				"#4db6ac",
				"#00897b",
				"#b2dfdb",
				"#004d40",
				"#4db6ac",
				"#00897b",
				"#b2dfdb",
				"#004d40",
				"#4db6ac",
				"#00897b",
				"#b2dfdb",
				"#004d40",
				"#4db6ac",
				"#00897b",
				"#b2dfdb",
				"#004d40",
				"#4db6ac",
				"#00897b",
			),
			array(
				"#c8e6c9",
				"#1b5e20",
				"#81c784",
				"#43a047",
				"#c8e6c9",
				"#1b5e20",
				"#81c784",
				"#43a047",
				"#c8e6c9",
				"#1b5e20",
				"#81c784",
				"#43a047",
				"#c8e6c9",
				"#1b5e20",
				"#81c784",
				"#43a047",
				"#c8e6c9",
				"#1b5e20",
				"#81c784",
				"#43a047",
			),
			array(
				"#f0f4c3",
				"#827717",
				"#dce775",
				"#c0ca33",
				"#f0f4c3",
				"#827717",
				"#dce775",
				"#c0ca33",
				"#f0f4c3",
				"#827717",
				"#dce775",
				"#c0ca33",
				"#f0f4c3",
				"#827717",
				"#dce775",
				"#c0ca33",
				"#f0f4c3",
				"#827717",
				"#dce775",
				"#c0ca33",
			),
			array(
				"#fff9c4",
				"#f57f17",
				"#fff176",
				"#fdd835",
				"#fff9c4",
				"#f57f17",
				"#fff176",
				"#fdd835",
				"#fff9c4",
				"#f57f17",
				"#fff176",
				"#fdd835",
				"#fff9c4",
				"#f57f17",
				"#fff176",
				"#fdd835",
				"#fff9c4",
				"#f57f17",
				"#fff176",
				"#fdd835",
			),
			array(
				"#ffe0b2",
				"#e65100",
				"#ffb74d",
				"#fb8c00",
				"#ffe0b2",
				"#e65100",
				"#ffb74d",
				"#fb8c00",
				"#ffe0b2",
				"#e65100",
				"#ffb74d",
				"#fb8c00",
				"#ffe0b2",
				"#e65100",
				"#ffb74d",
				"#fb8c00",
				"#ffe0b2",
				"#e65100",
				"#ffb74d",
				"#fb8c00",
			),
			array(
				"#d7ccc8",
				"#3e2723",
				"#a1887f",
				"#6d4c41",
				"#d7ccc8",
				"#3e2723",
				"#a1887f",
				"#6d4c41",
				"#d7ccc8",
				"#3e2723",
				"#a1887f",
				"#6d4c41",
				"#d7ccc8",
				"#3e2723",
				"#a1887f",
				"#6d4c41",
				"#d7ccc8",
				"#3e2723",
				"#a1887f",
				"#6d4c41",
			),
			array(
				"#cfd8dc",
				"#263238",
				"#90a4ae",
				"#546e7a",
				"#cfd8dc",
				"#263238",
				"#90a4ae",
				"#546e7a",
				"#cfd8dc",
				"#263238",
				"#90a4ae",
				"#546e7a",
				"#cfd8dc",
				"#263238",
				"#90a4ae",
				"#546e7a",
				"#cfd8dc",
				"#263238",
				"#90a4ae",
				"#546e7a",
			),
		);
		$index        = rand( 0, 11 );
		$colors       = $colors_array[ $index ];
		$slices       = $this->settings->get_params( 'wheel', 'bg_color' );

		return array_slice( $colors, 0, count( $slices ) );
	}
}
