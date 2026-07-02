<?php
/**
 * ACF Field Groups loader
 *
 * Registers ACF field groups for pages and CPTs so that content
 * can be edited from the WordPress admin instead of being hardcoded.
 *
 * @package Ave_Maria
 */

defined('ABSPATH') || exit;

if (!function_exists('acf_add_local_field_group')) {
    return;
}

add_filter('acf/settings/save_json', function () {
    return AVEMARIA_DIR . '/acf-json';
});

add_filter('acf/settings/load_json', function ($paths) {
    $paths[] = AVEMARIA_DIR . '/acf-json';
    return $paths;
});

$acf_fields_dir = AVEMARIA_DIR . '/inc/acf-fields';
foreach (glob($acf_fields_dir . '/*.php') as $file) {
    require_once $file;
}

if (!function_exists('avemaria_field')) {
    function avemaria_field($field_name, $post_id = null, $default = '') {
        if (!function_exists('get_field')) {
            return $default;
        }
        $value = get_field($field_name, $post_id);
        return ($value === null || $value === false || $value === '') ? $default : $value;
    }
}
