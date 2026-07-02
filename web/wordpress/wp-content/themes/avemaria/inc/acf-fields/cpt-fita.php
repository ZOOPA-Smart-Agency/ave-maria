<?php
/**
 * ACF Field Group — CPT Fita (timeline de trajectòria)
 *
 * @package Ave_Maria
 */

defined( 'ABSPATH' ) || exit;

acf_add_local_field_group( [
    'key'      => 'group_avemaria_fita',
    'title'    => 'Fita — Dades',
    'location' => [ [ [ 'param' => 'post_type', 'operator' => '==', 'value' => 'fita' ] ] ],
    'fields'   => [
        [ 'key' => 'field_fita_any', 'label' => 'Any', 'name' => 'any', 'type' => 'number' ],
        [ 'key' => 'field_fita_entitat_ca', 'label' => 'Entitat (CA)', 'name' => 'entitat_ca', 'type' => 'text' ],
        [ 'key' => 'field_fita_entitat_es', 'label' => 'Entidad (ES)', 'name' => 'entitat_es', 'type' => 'text' ],
        [ 'key' => 'field_fita_titol_ca', 'label' => 'Títol (CA)', 'name' => 'titol_ca', 'type' => 'text' ],
        [ 'key' => 'field_fita_titol_es', 'label' => 'Título (ES)', 'name' => 'titol_es', 'type' => 'text' ],
        [ 'key' => 'field_fita_descripcio_ca', 'label' => 'Descripció (CA)', 'name' => 'descripcio_ca', 'type' => 'textarea', 'rows' => 3 ],
        [ 'key' => 'field_fita_descripcio_es', 'label' => 'Descripción (ES)', 'name' => 'descripcio_es', 'type' => 'textarea', 'rows' => 3 ],
    ],
] );
