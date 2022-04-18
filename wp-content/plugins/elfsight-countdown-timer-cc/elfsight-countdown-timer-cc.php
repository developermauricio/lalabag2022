<?php
/*
Plugin Name: Elfsight Countdown Timer CC
Description: Create various counters and timers to stimulate purchasing on your website
Plugin URI: https://elfsight.com/countdown-timer-widget/codecanyon/?utm_source=markets&utm_medium=codecanyon&utm_campaign=countdown-timer&utm_content=plugin-site
Version: 1.2.0
Author: Elfsight
Author URI: https://elfsight.com/?utm_source=markets&utm_medium=codecanyon&utm_campaign=countdown-timer&utm_content=plugins-list
*/

if (!defined('ABSPATH')) exit;


require_once('core/elfsight-plugin.php');

$elfsight_countdown_timer_config_path = plugin_dir_path(__FILE__) . 'config.json';
$elfsight_countdown_timer_config = json_decode(file_get_contents($elfsight_countdown_timer_config_path), true);

new ElfsightCountdownTimerPlugin(
    array(
        'name' => esc_html__('Countdown Timer'),
        'description' => esc_html__('Create various counters and timers to stimulate purchasing on your website'),
        'slug' => 'elfsight-countdown-timer',
        'version' => '1.2.0',
        'text_domain' => 'elfsight-countdown-timer',
        'editor_settings' => $elfsight_countdown_timer_config['settings'],
        'editor_preferences' => $elfsight_countdown_timer_config['preferences'],
        'script_url' => plugins_url('assets/elfsight-countdown-timer.js', __FILE__),

        'plugin_name' => esc_html__('Elfsight Countdown Timer'),
        'plugin_file' => __FILE__,
        'plugin_slug' => plugin_basename(__FILE__),

        'vc_icon' => plugins_url('assets/img/vc-icon.png', __FILE__),

        'menu_icon' => plugins_url('assets/img/menu-icon.png', __FILE__),
        'update_url' => esc_url('https://a.elfsight.com/updates/v1/'),

        'preview_url' => plugins_url('preview/index.html', __FILE__),
        'observer_url' => plugins_url('preview/countdown-timer-observer.js', __FILE__),

        'product_url' => esc_url('https://codecanyon.net/item/countdown-timer-wordpress-countdown-timer-plugin/23178172?ref=Elfsight'),
        'support_url' => esc_url('https://elfsight.ticksy.com/submit/#100014349'),
    )
);

?>