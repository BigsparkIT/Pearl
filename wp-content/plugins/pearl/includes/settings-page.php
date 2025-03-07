<?php
/**
 * Settings page for the Pearl plugin.
 */

// This stops directly calling the code.
if (! defined('ABSPATH')) {
    exit;
}

add_action('admin_menu', function () {
    register_setting(
        option_group: 'pearl_settings',
        option_name: 'pearl_platform_identifier'
    );
    add_settings_field(
        id: 'pearl_platform_identifier',
        title: __('Platform Identifier', 'pearl'),
        callback: function () {
            $value = get_option('pearl_platform_identifier', '');
            echo '<input type="text" name="pearl_platform_identifier" value="' . esc_attr($value) . '" class="regular-text" />';
        },
        page: 'pearl',
        section: 'pearl_settings_section'
    );

    add_settings_section(
        id: 'pearl_settings_section',
        title: __('Algemene Instellingen', 'pearl'),
        callback: function () {
            echo '<p>' . esc_html__('Vul hier de algemene instellingen in voor Pearl.', 'pearl') . '</p>';
        },
        page: 'pearl'
    );

    add_options_page(
        page_title: __('BigSpark Pearl Instellingen', 'pearl'),
        menu_title: __('BigSpark Pearl', 'pearl'),
        capability: 'manage_options',
        menu_slug: 'pearl-settings',
        callback: function () {
            ?>
            <div class="wrap">
                <h1><?php esc_html_e('Pearl Instellingen', 'pearl'); ?></h1>
                <form method="post" action="options.php">
                    <?php
                    settings_fields(option_group: 'pearl_settings');
                    do_settings_sections(page: 'pearl');
                    submit_button();
                    ?>
                </form>
            </div>
            <?php
        }
    );
});
