<?php
/**
 * Assigns descriptive titles and alt text to imported images.
 */

$alt_map = [
    'hero-player.png'       => ['Deportista con equipación personalizada', 'Imagen principal del hero de la Home'],
    'hero-updated.png'      => ['Hero actualizado',                       ''],
    'hero-blue-gradient.png' => ['Fondo hero azul',                       ''],
    'HOME_1.jpg'            => ['Taller Fundació Ave Maria — producción',         'Vista del taller de Fundació Ave Maria'],
    'HOME_2.jpg'            => ['Producción industrial textil',           'Detalle de producción industrial'],
    'HOME_3.jpg'            => ['Detalle de customización',               'Detalle de una prenda personalizada'],
    'HOME_4.png'            => ['Imagen secundaria Home',                 ''],
    'HOME_41.jpg'           => ['Colaboración profesional',               'Equipo colaborando en proyecto'],
    'HOME_5.jpg'            => ['Almacén logístico',                      'Instalación de logística textil'],
    'TEC_1.jpg'             => ['Impresión DTF',                          'Técnica de impresión DTF sobre tejido'],
    'TEC_2.jpg'             => ['Técnicas de impresión',                  'Aplicación de técnicas de impresión'],
    'TEC_3.jpg'             => ['Transfer y parches',                     'Aplicación de transfer y parches'],
    'TEC_4.jpg'             => ['Marcado en prenda',                      'Marcado industrial en prendas'],
    'TEC_5.jpg'             => ['Logística textil',                       'Gestión logística de prendas'],
    'TEC_6.jpg'             => ['Técnicas de customización',              'Detalle de customización textil'],
    'LOGOS_CLIENTS.png'     => ['Clientes Fundació Ave Maria',                    'Logotipos de marcas clientes'],
    'LOGOS_CLIENTS2.png'    => ['Clientes Fundació Ave Maria',                    'Logotipos de marcas clientes'],
    'logo.png'              => ['Logo Fundació Ave Maria',                        'Logotipo oficial Fundació Ave Maria'],
    'lineas.svg'            => ['Líneas decorativas',                     ''],
    'header.jpg'            => ['Cabecera Fundació Ave Maria',                    ''],
    'FONDO_AZUL.jpg'        => ['Fondo azul',                             ''],
];

$map = get_option('avemaria_imported_images', []);
$updated = 0;

foreach ($alt_map as $filename => [$title, $alt]) {
    $id = $map[$filename] ?? 0;
    if (!$id) continue;

    wp_update_post([
        'ID'           => $id,
        'post_title'   => $title,
        'post_excerpt' => $alt,
    ]);

    if ($alt) update_post_meta($id, '_wp_attachment_image_alt', $alt);
    $updated++;
}

echo "Alt text y títulos aplicados a {$updated} imágenes" . PHP_EOL;
