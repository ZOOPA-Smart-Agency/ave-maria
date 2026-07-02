<?php
/**
 * ACF Field Group — CPT Valor
 *
 * @package Ave_Maria
 */

defined( 'ABSPATH' ) || exit;

acf_add_local_field_group( [
    'key'      => 'group_avemaria_valor',
    'title'    => 'Valor — Dades',
    'location' => [ [ [ 'param' => 'post_type', 'operator' => '==', 'value' => 'valor' ] ] ],
    'fields'   => [
        [ 'key' => 'field_valor_numero', 'label' => 'Número (01…)', 'name' => 'numero', 'type' => 'text' ],
        [ 'key' => 'field_valor_titol_ca', 'label' => 'Títol (CA)', 'name' => 'titol_ca', 'type' => 'text' ],
        [ 'key' => 'field_valor_titol_es', 'label' => 'Título (ES)', 'name' => 'titol_es', 'type' => 'text' ],
        [ 'key' => 'field_valor_descripcio_ca', 'label' => 'Descripció (CA)', 'name' => 'descripcio_ca', 'type' => 'textarea', 'rows' => 3 ],
        [ 'key' => 'field_valor_descripcio_es', 'label' => 'Descripción (ES)', 'name' => 'descripcio_es', 'type' => 'textarea', 'rows' => 3 ],
        [ 'key' => 'field_valor_color', 'label' => 'Color', 'name' => 'color', 'type' => 'select',
            'choices' => [ 'taronja' => 'Taronja', 'verd' => 'Verd', 'blau' => 'Blau', 'groc' => 'Groc', 'rosa' => 'Rosa', 'coral' => 'Coral' ],
            'default_value' => 'verd',
        ],
    ],
] );
