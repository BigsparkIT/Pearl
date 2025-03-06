<?php
/**
 * Plugin Name: BigSpark Pearl
 * Description: Voegt een Gutenberg block toe om een in-article-widget te maken.
 * Version: 1.0.0
 * Author: BigSpark
 * Author URI: https://bigspark.com
 * License: GPL2+
 * Text Domain: pearl
 */

 
// This stops directly calling the code.
if (! defined('ABSPATH')) {
    exit;
}

add_action('init', function () {
    register_block_type(__DIR__ . '/build/blocks/product-iframe');
});

// Only load the settings page and inject the the platform name in the admin environment.
if (is_admin()) {
    require_once plugin_dir_path(__FILE__) . 'includes/settings-page.php';

    add_action('init', function () {
        // Add the platformName to the code to give the frontend access to the value.
        wp_enqueue_script('pearl-product-iframe-block', plugins_url('build/blocks/product-iframe/index.js', __FILE__));
        wp_add_inline_script('pearl-product-iframe-block', 'const pearlSettings = ' . json_encode([
            'platformName' => get_option('pearl_platform_identifier', ''),
        ]), 'before' );
    });
}
