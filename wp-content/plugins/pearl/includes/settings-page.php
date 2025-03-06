<?php
/**
 * Instellingenpagina voor de Pearl plugin.
 */

if (! defined('ABSPATH')) {
    exit; // Voorkom directe toegang.
}

/**
 * Registreer de instellingen en voeg de benodigde velden toe.
 */
add_action('admin_menu', function () {
    // Voeg het Platform Identifier veld toe.
    register_setting('pearl_settings', 'pearl_platform_identifier');
    add_settings_field(
        'pearl_platform_identifier',           // ID van het veld.
        __('Platform Identifier', 'pearl'),    // Titel van het veld.
        function () {                          // Callback die het invoerveld rendert.
            $value = get_option('pearl_platform_identifier', '');
            echo '<input type="text" name="pearl_platform_identifier" value="' . esc_attr($value) . '" class="regular-text" />';
        },
        'pearl',                               // Pagina slug.
        'pearl_settings_section'               // Sectie waarin het veld getoond wordt.
    );

    // Voeg een instellingen sectie toe.
    add_settings_section(
        'pearl_settings_section',              // ID van de sectie.
        __('Algemene Instellingen', 'pearl'),  // Titel van de sectie.
        function () {                          // Callback voor extra uitleg.
            echo '<p>' . esc_html__('Vul hier de algemene instellingen in voor Pearl.', 'pearl') . '</p>';
        },
        'pearl'                                // Pagina slug waar de sectie aan gekoppeld wordt.
    );

    // Voeg een instellingenpagina toe aan het admin menu.
    add_options_page(
        __('BigSpark Pearl Instellingen', 'pearl'),     // Paginatitel.
        __('BigSpark Pearl', 'pearl'),                  // Menutitel.
        'manage_options',                      // Vereiste rechten.
        'pearl-settings',                      // Menu slug.
        function () {                          // Callback functie voor de pagina.
            ?>
            <div class="wrap">
                <h1><?php esc_html_e('Pearl Instellingen', 'pearl'); ?></h1>
                <form method="post" action="options.php">
                    <?php
                    settings_fields('pearl_settings');
                    do_settings_sections('pearl');
                    submit_button();
                    ?>
                </form>
            </div>
            <?php
        }
    );
});
