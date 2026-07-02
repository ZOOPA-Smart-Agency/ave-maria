<?php
/**
 * ACF Field Group — CPT Equip Àrea
 *
 * @package Ave_Maria
 */

defined( 'ABSPATH' ) || exit;

acf_add_local_field_group( [
    'key'      => 'group_avemaria_equip_area',
    'title'    => 'Àrea Equip — Dades',
    'location' => [ [ [ 'param' => 'post_type', 'operator' => '==', 'value' => 'equip_area' ] ] ],
    'fields'   => [
        [ 'key' => 'field_equip_area_numero', 'label' => 'Número (01…)', 'name' => 'numero', 'type' => 'text' ],
        [ 'key' => 'field_equip_area_titol_ca', 'label' => 'Títol (CA)', 'name' => 'titol_ca', 'type' => 'text' ],
        [ 'key' => 'field_equip_area_titol_es', 'label' => 'Título (ES)', 'name' => 'titol_es', 'type' => 'text' ],
        [ 'key' => 'field_equip_area_descripcio_ca', 'label' => 'Descripció (CA)', 'name' => 'descripcio_ca', 'type' => 'textarea', 'rows' => 3 ],
        [ 'key' => 'field_equip_area_descripcio_es', 'label' => 'Descripción (ES)', 'name' => 'descripcio_es', 'type' => 'textarea', 'rows' => 3 ],
        [ 'key' => 'field_equip_area_rols', 'label' => 'Rols (un per línia)', 'name' => 'rols', 'type' => 'textarea', 'rows' => 5 ],
        [ 'key' => 'field_equip_area_color', 'label' => 'Color', 'name' => 'color', 'type' => 'select',
            'choices' => [ 'taronja' => 'Taronja', 'verd' => 'Verd', 'blau' => 'Blau', 'groc' => 'Groc', 'rosa' => 'Rosa', 'coral' => 'Coral' ],
            'default_value' => 'blau',
        ],
    ],
] );
