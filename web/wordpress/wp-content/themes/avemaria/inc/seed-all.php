<?php
/**
 * One-shot seeding: walks all ACF field groups registered by the theme
 * and writes each field's `default_value` to the post meta of the page
 * the group is bound to (via location rule `page`).
 */

$groups = acf_get_field_groups();
$total  = 0;

foreach ($groups as $group) {
    $target_page_ids = [];

    if (!empty($group['location'])) {
        foreach ($group['location'] as $rule_group) {
            foreach ($rule_group as $rule) {
                if ($rule['param'] === 'page' && $rule['operator'] === '==' && is_numeric($rule['value'])) {
                    $target_page_ids[] = (int) $rule['value'];
                }
                if ($rule['param'] === 'page_type' && $rule['value'] === 'front_page') {
                    $front_id = (int) get_option('page_on_front');
                    if ($front_id) $target_page_ids[] = $front_id;
                }
            }
        }
    }

    $target_page_ids = array_unique($target_page_ids);
    if (empty($target_page_ids)) continue;

    $fields = acf_get_fields($group['key']);
    if (!$fields) continue;

    foreach ($target_page_ids as $pid) {
        foreach ($fields as $f) {
            if (empty($f['name']) || in_array($f['type'], ['tab', 'message', 'image', 'url', 'email'], true) === true && $f['type'] !== 'url' && $f['type'] !== 'email') {
                continue;
            }
            if (in_array($f['type'], ['tab', 'message'], true)) continue;
            if (!isset($f['default_value']) || $f['default_value'] === '' || $f['default_value'] === null) continue;

            $existing = get_post_meta($pid, $f['name'], true);
            if ($existing !== '' && $existing !== null && $existing !== false) continue;

            update_field($f['name'], $f['default_value'], $pid);
            $total++;
        }
    }
}

echo "Seed ACF completado: {$total} campos guardados" . PHP_EOL;
