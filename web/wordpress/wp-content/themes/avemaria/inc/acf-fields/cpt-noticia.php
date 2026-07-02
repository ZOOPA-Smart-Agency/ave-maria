<?php
/**
 * ACF Field Group — Notícia (post nadiu)
 *
 * @package Ave_Maria
 */

defined( 'ABSPATH' ) || exit;

acf_add_local_field_group( [
    'key'      => 'group_avemaria_noticia',
    'title'    => 'Notícia — Camps addicionals',
    'location' => [ [ [ 'param' => 'post_type', 'operator' => '==', 'value' => 'post' ] ] ],
    'fields'   => [
        [ 'key' => 'field_noticia_lede_ca', 'label' => 'Entradeta / Lede (CA)', 'name' => 'lede_ca', 'type' => 'textarea', 'rows' => 3 ],
        [ 'key' => 'field_noticia_lede_es', 'label' => 'Entradilla / Lede (ES)', 'name' => 'lede_es', 'type' => 'textarea', 'rows' => 3 ],
        [ 'key' => 'field_noticia_cita_ca', 'label' => 'Cita destacada (CA)', 'name' => 'cita_destacada_ca', 'type' => 'textarea', 'rows' => 3 ],
        [ 'key' => 'field_noticia_cita_es', 'label' => 'Cita destacada (ES)', 'name' => 'cita_destacada_es', 'type' => 'textarea', 'rows' => 3 ],
        [ 'key' => 'field_noticia_cita_autor', 'label' => 'Cita — autor', 'name' => 'cita_autor', 'type' => 'text' ],
        [ 'key' => 'field_noticia_temps_lectura', 'label' => 'Temps lectura ("4 min")', 'name' => 'temps_lectura', 'type' => 'text' ],
        [ 'key' => 'field_noticia_color', 'label' => 'Color d\'accent', 'name' => 'color', 'type' => 'select',
            'choices' => [ 'taronja' => 'Taronja', 'verd' => 'Verd', 'blau' => 'Blau', 'groc' => 'Groc', 'rosa' => 'Rosa', 'coral' => 'Coral' ],
            'default_value' => 'taronja',
        ],
    ],
] );
