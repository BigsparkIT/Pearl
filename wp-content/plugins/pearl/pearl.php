<?php
/**
 * Plugin Name: Pearl
 * Description: Basis plugin voor Orca met een instellingenpagina voor API key en platform identifier.
 * Version: 1.0.0
 * Author: BigSpark
 * Author URI: https://bigspark.com
 * License: GPL2+
 * Text Domain: pearl
 */

if (! defined('ABSPATH')) {
    exit; // Voorkom directe toegang.
}

/**
 * Plugin initialisatie.
 */
add_action('init', function () {
    // // Registreer eerst het script met de benodigde dependencies.
    // wp_register_script(
    //     'orca-product-iframe-block',
    //     plugins_url('blocks/product-iframe/index.js', __FILE__),
    //     ['wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components'],
    //     '1.0.0',
    //     true // Laadt in de footer
    // );

    // $platform_identifier = get_option('orca_platform_identifier', '');
    // // echo '-------------------------------------------------------------'.$platform_identifier;

    // wp_localize_script(
    //     'orca-product-iframe-block',
    //     'pearlSettings',
    //     ['platformIdentifier' => $platform_identifier]
    // );

    // register_block_type(__DIR__ . '/build/blocks/product-iframe', ['editor_script' => 'orca-product-iframe-block']);

    wp_enqueue_script('pearl-product-iframe-block', plugins_url('build/blocks/product-iframe/index.js', __FILE__));
    wp_add_inline_script('pearl-product-iframe-block', 'const pearlSettings = ' . json_encode([
        'platformName' => get_option('pearl_platform_identifier', ''),
    ]), 'before' );
    register_block_type(__DIR__ . '/build/blocks/product-iframe');
});

// add_action('admin_enqueue_scripts', function () {
//     // Zorg dat het script altijd wordt ingeladen op alle adminpagina's.
//     wp_enqueue_script('orca-product-iframe-block');
// });

// Laad de settings-page code enkel in de admin omgeving.
if (is_admin()) {
    require_once plugin_dir_path(__FILE__) . 'includes/settings-page.php';
}
