<?php
/**
 * ACF Field Group — CPT Estadística
 *
 * @package Ave_Maria
 */

defined( 'ABSPATH' ) || exit;

acf_add_local_field_group( [
    'key'      => 'group_avemaria_estadistica',
    'title'    => 'Estadística — Dades',
    'location' => [ [ [ 'param' => 'post_type', 'operator' => '==', 'value' => 'estadistica' ] ] ],
    'fields'   => [
        [ 'key' => 'field_estadistica_numero', 'label' => 'Número (+39, ISO, +110.000…)', 'name' => 'numero', 'type' => 'text' ],
        [ 'key' => 'field_estadistica_label_ca', 'label' => 'Label (CA)', 'name' => 'label_ca', 'type' => 'text' ],
        [ 'key' => 'field_estadistica_label_es', 'label' => 'Label (ES)', 'name' => 'label_es', 'type' => 'text' ],
        [ 'key' => 'field_estadistica_color', 'label' => 'Color', 'name' => 'color', 'type' => 'select',
            'choices' => [ 'taronja' => 'Taronja', 'verd' => 'Verd', 'blau' => 'Blau', 'groc' => 'Groc', 'rosa' => 'Rosa', 'coral' => 'Coral' ],
            'default_value' => 'taronja',
        ],
    ],
] );
