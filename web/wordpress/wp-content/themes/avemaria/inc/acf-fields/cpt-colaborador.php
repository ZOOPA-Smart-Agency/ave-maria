<?php
/**
 * ACF Field Group — CPT Col·laborador
 *
 * @package Ave_Maria
 */

defined( 'ABSPATH' ) || exit;

acf_add_local_field_group( [
    'key'      => 'group_avemaria_colaborador',
    'title'    => 'Col·laborador — Dades',
    'location' => [ [ [ 'param' => 'post_type', 'operator' => '==', 'value' => 'colaborador' ] ] ],
    'fields'   => [
        [ 'key' => 'field_colaborador_nom', 'label' => 'Nom', 'name' => 'nom', 'type' => 'text' ],
        [ 'key' => 'field_colaborador_logo', 'label' => 'Logo', 'name' => 'logo', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium' ],
        [ 'key' => 'field_colaborador_url', 'label' => 'URL (opcional)', 'name' => 'url', 'type' => 'url' ],
    ],
] );
