<?php
/**
 * ACF Field Group — CPT Testimoni
 *
 * @package Ave_Maria
 */

defined( 'ABSPATH' ) || exit;

acf_add_local_field_group( [
    'key'      => 'group_avemaria_testimoni',
    'title'    => 'Testimoni — Contingut',
    'location' => [ [ [ 'param' => 'post_type', 'operator' => '==', 'value' => 'testimoni' ] ] ],
    'fields'   => [
        [ 'key' => 'field_testimoni_text_ca', 'label' => 'Text (CA)', 'name' => 'text_ca', 'type' => 'textarea', 'rows' => 4 ],
        [ 'key' => 'field_testimoni_text_es', 'label' => 'Texto (ES)', 'name' => 'text_es', 'type' => 'textarea', 'rows' => 4 ],
        [ 'key' => 'field_testimoni_autor', 'label' => 'Autor', 'name' => 'autor', 'type' => 'text' ],
        [ 'key' => 'field_testimoni_rol_ca', 'label' => 'Rol (CA)', 'name' => 'rol_ca', 'type' => 'text' ],
        [ 'key' => 'field_testimoni_rol_es', 'label' => 'Rol (ES)', 'name' => 'rol_es', 'type' => 'text' ],
        [ 'key' => 'field_testimoni_color', 'label' => 'Color', 'name' => 'color', 'type' => 'select',
            'choices' => [ 'taronja' => 'Taronja', 'verd' => 'Verd', 'blau' => 'Blau', 'groc' => 'Groc', 'rosa' => 'Rosa', 'coral' => 'Coral' ],
            'default_value' => 'verd',
        ],
    ],
] );
