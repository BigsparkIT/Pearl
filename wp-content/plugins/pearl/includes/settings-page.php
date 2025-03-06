<?php
/**
 * Settings page for the Pearl plugin.
 */

// This stops directly calling the code.
if (! defined('ABSPATH')) {
    exit;
}

/**
 * Register the settings and add the setting field.
 */
add_action('admin_menu', function () {
    // Add the Platform Identifier field.
    register_setting('pearl_settings', 'pearl_platform_identifier');
    add_settings_field(
        'pearl_platform_identifier',                // ID of the field.
        __('Platform Identifier', 'pearl'),         // Title of the field.
        function () {                               // Callback that renders the input field.
            $value = get_option('pearl_platform_identifier', '');
            echo '<input type="text" name="pearl_platform_identifier" value="' . esc_attr($value) . '" class="regular-text" />';
        },
        'pearl',                                    // Page slug the field is connected to.
        'pearl_settings_section'                    // Section where the field is shown.
    );

    // Add the settings section
    add_settings_section(
        'pearl_settings_section',                   // ID of the section.
        __('Algemene Instellingen', 'pearl'),       // Title of the section.
        function () {                               // Callback that renders extra information under the title.
            echo '<p>' . esc_html__('Vul hier de algemene instellingen in voor Pearl.', 'pearl') . '</p>';
        },
        'pearl'                                     // Page slug the section is connected to.
    );

    // Add the settings page to the admin menu.
    add_options_page(
        __('BigSpark Pearl Instellingen', 'pearl'), // Page title.
        __('BigSpark Pearl', 'pearl'),              // Menu title.
        'manage_options',                           // Required permission.
        'pearl-settings',                           // Menu slug.
        function () {                               // Callback function that renders the settings page.
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
