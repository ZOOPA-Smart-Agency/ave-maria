<?php
/**
 * Assigns imported Media Library attachments to ACF image fields on each page,
 * mirroring the hardcoded defaults that existed in the original templates.
 * Skips any field that already has a value (so a client's custom upload wins).
 */

$map = get_option('avemaria_imported_images', []);
if (empty($map)) {
    echo "No hay imágenes importadas. Ejecuta primero import-images.php" . PHP_EOL;
    return;
}

$get = function ($filename) use ($map) {
    return $map[$filename] ?? 0;
};

$assignments = [
    4 => [
        'home_hero_image'    => $get('hero-player.png'),
        'home_hero_bg'       => $get('lineas.svg'),
        'home_about_img1'    => $get('HOME_1.jpg'),
        'home_about_img2'    => $get('HOME_2.jpg'),
        'home_about_img3'    => $get('HOME_3.jpg'),
        'home_service1_img'  => $get('TEC_1.jpg'),
        'home_service2_img'  => $get('TEC_3.jpg'),
        'home_service3_img'  => $get('TEC_4.jpg'),
        'home_logistics_img' => $get('HOME_5.jpg'),
        'home_clients_img'   => $get('LOGOS_CLIENTS2.png'),
    ],
    5 => [
        'qs_exp_img'     => $get('HOME_1.jpg'),
        'qs_taller_img1' => $get('HOME_1.jpg'),
        'qs_taller_img2' => $get('HOME_2.jpg'),
        'qs_taller_img3' => $get('HOME_3.jpg'),
        'qs_prov_img'    => $get('HOME_41.jpg'),
    ],
    6 => [
        'srv_imp_img' => $get('TEC_1.jpg'),
        'srv_tra_img' => $get('TEC_3.jpg'),
        'srv_mar_img' => $get('TEC_4.jpg'),
        'srv_log_img' => $get('TEC_5.jpg'),
    ],
    7 => [
        'sol_r1_img' => $get('TEC_3.jpg'),
        'sol_r2_img' => $get('HOME_41.jpg'),
        'sol_r3_img' => $get('TEC_4.jpg'),
        'sol_r4_img' => $get('TEC_5.jpg'),
    ],
    9 => [
        'proc_1_img' => $get('TEC_1.jpg'),
        'proc_2_img' => $get('TEC_3.jpg'),
        'proc_3_img' => $get('TEC_4.jpg'),
        'proc_4_img' => $get('TEC_5.jpg'),
        'proc_5_img' => $get('HOME_1.jpg'),
        'proc_6_img' => $get('HOME_2.jpg'),
        'proc_7_img' => $get('HOME_5.jpg'),
    ],
    34 => [
        'ag_logos_img' => $get('LOGOS_CLIENTS2.png'),
    ],
];

$total = 0;
$skipped = 0;
foreach ($assignments as $pid => $fields) {
    foreach ($fields as $field_name => $attachment_id) {
        if (!$attachment_id) continue;

        $existing = get_field($field_name, $pid);
        if (!empty($existing)) {
            $skipped++;
            continue;
        }

        update_field($field_name, $attachment_id, $pid);
        $total++;
    }
}

echo "Imágenes asignadas: {$total} nuevas, {$skipped} ya tenían valor" . PHP_EOL;
