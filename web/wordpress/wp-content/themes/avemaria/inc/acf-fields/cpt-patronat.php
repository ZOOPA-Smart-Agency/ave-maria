<?php
/**
 * ACF Field Group — CPT Patronat
 *
 * @package Ave_Maria
 */

defined( 'ABSPATH' ) || exit;

acf_add_local_field_group( [
    'key'      => 'group_avemaria_patronat',
    'title'    => 'Membre del Patronat — Dades',
    'location' => [ [ [ 'param' => 'post_type', 'operator' => '==', 'value' => 'patronat' ] ] ],
    'fields'   => [
        [ 'key' => 'field_patronat_nom', 'label' => 'Nom', 'name' => 'nom', 'type' => 'text' ],
        [ 'key' => 'field_patronat_carrec_ca', 'label' => 'Càrrec (CA)', 'name' => 'carrec_ca', 'type' => 'text' ],
        [ 'key' => 'field_patronat_carrec_es', 'label' => 'Cargo (ES)', 'name' => 'carrec_es', 'type' => 'text' ],
        [ 'key' => 'field_patronat_foto', 'label' => 'Foto (opcional)', 'name' => 'foto', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium',
            'instructions' => 'Si el deixes buit es mostra el placeholder "Pendent de foto".' ],
    ],
] );
