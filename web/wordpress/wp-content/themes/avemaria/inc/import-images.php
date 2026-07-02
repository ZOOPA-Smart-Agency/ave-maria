<?php
/**
 * One-shot script: imports all theme images (assets/img/) into the
 * WordPress Media Library and records the mapping in a theme option so
 * field defaults / seeds can reference them by filename.
 */

if (!function_exists('media_sideload_image')) {
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';
}

$source_dir = AVEMARIA_DIR . '/assets/img/';
$files = glob($source_dir . '*.{jpg,jpeg,png,svg,webp,gif}', GLOB_BRACE);

$existing_map = get_option('avemaria_imported_images', []);
$map = is_array($existing_map) ? $existing_map : [];

$upload_dir = wp_upload_dir();
$imported = 0;
$skipped = 0;

foreach ($files as $file) {
    $filename = basename($file);

    if (isset($map[$filename])) {
        $att = get_post($map[$filename]);
        if ($att && $att->post_type === 'attachment') {
            $skipped++;
            continue;
        }
    }

    $existing = get_page_by_title($filename, OBJECT, 'attachment');
    if ($existing) {
        $map[$filename] = (int) $existing->ID;
        $skipped++;
        continue;
    }

    $dest = trailingslashit($upload_dir['path']) . $filename;
    if (!file_exists($dest)) {
        copy($file, $dest);
    }

    $wp_filetype = wp_check_filetype($filename);
    $attachment = [
        'post_mime_type' => $wp_filetype['type'] ?: 'image/jpeg',
        'post_title'     => sanitize_file_name(pathinfo($filename, PATHINFO_FILENAME)),
        'post_content'   => '',
        'post_status'    => 'inherit',
    ];

    $attach_id = wp_insert_attachment($attachment, $dest);
    if (is_wp_error($attach_id) || !$attach_id) continue;

    $attach_data = wp_generate_attachment_metadata($attach_id, $dest);
    wp_update_attachment_metadata($attach_id, $attach_data);

    $map[$filename] = (int) $attach_id;
    $imported++;
}

update_option('avemaria_imported_images', $map);

echo "Importación completada: {$imported} nuevas, {$skipped} ya existían" . PHP_EOL;
echo "Total en Media Library: " . count($map) . PHP_EOL;
