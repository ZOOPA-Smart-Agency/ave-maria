<?php
/**
 * Custom Post Types Registration
 *
 * @package Ave_Maria
 */

add_action( 'init', 'avemaria_register_post_types' );

function avemaria_register_post_types() {

    // --- Serveis (6 items) ---
    register_post_type( 'servei', [
        'labels' => [
            'name'               => __( 'Serveis', 'avemaria' ),
            'singular_name'      => __( 'Servei', 'avemaria' ),
            'add_new'            => __( 'Afegir Servei', 'avemaria' ),
            'add_new_item'       => __( 'Afegir nou Servei', 'avemaria' ),
            'edit_item'          => __( 'Editar Servei', 'avemaria' ),
            'new_item'           => __( 'Nou Servei', 'avemaria' ),
            'view_item'          => __( 'Veure Servei', 'avemaria' ),
            'search_items'       => __( 'Cercar Serveis', 'avemaria' ),
            'not_found'          => __( 'No s\'han trobat serveis', 'avemaria' ),
            'not_found_in_trash' => __( 'No hi ha serveis a la paperera', 'avemaria' ),
            'menu_name'          => __( 'Serveis', 'avemaria' ),
        ],
        'public'       => true,
        'has_archive'  => false,
        'rewrite'      => [ 'slug' => 'serveis/%servei%', 'with_front' => false ],
        'menu_icon'    => 'dashicons-heart',
        'supports'     => [ 'title', 'editor', 'thumbnail', 'page-attributes' ],
        'show_in_rest' => true,
    ] );

    // --- Testimonis (carrusel de "Veus") ---
    register_post_type( 'testimoni', [
        'labels' => [
            'name'          => __( 'Testimonis', 'avemaria' ),
            'singular_name' => __( 'Testimoni', 'avemaria' ),
            'add_new'       => __( 'Afegir Testimoni', 'avemaria' ),
            'add_new_item'  => __( 'Afegir nou Testimoni', 'avemaria' ),
            'edit_item'     => __( 'Editar Testimoni', 'avemaria' ),
            'menu_name'     => __( 'Testimonis', 'avemaria' ),
        ],
        'public'       => false,
        'show_ui'      => true,
        'has_archive'  => false,
        'rewrite'      => [ 'slug' => 'testimonis' ],
        'menu_icon'    => 'dashicons-format-quote',
        'supports'     => [ 'title', 'editor' ],
        'show_in_rest' => true,
    ] );

    // --- Patronat (4 membres) ---
    register_post_type( 'patronat', [
        'labels' => [
            'name'          => __( 'Patronat', 'avemaria' ),
            'singular_name' => __( 'Membre del Patronat', 'avemaria' ),
            'add_new'       => __( 'Afegir Membre', 'avemaria' ),
            'add_new_item'  => __( 'Afegir nou Membre', 'avemaria' ),
            'edit_item'     => __( 'Editar Membre', 'avemaria' ),
            'menu_name'     => __( 'Patronat', 'avemaria' ),
        ],
        'public'       => false,
        'show_ui'      => true,
        'has_archive'  => false,
        'rewrite'      => [ 'slug' => 'patronat' ],
        'menu_icon'    => 'dashicons-groups',
        'supports'     => [ 'title', 'thumbnail' ],
        'show_in_rest' => true,
    ] );

    // --- Equip Àrees (4 àrees) ---
    register_post_type( 'equip_area', [
        'labels' => [
            'name'          => __( 'Àrees Equip', 'avemaria' ),
            'singular_name' => __( 'Àrea Equip', 'avemaria' ),
            'add_new'       => __( 'Afegir Àrea', 'avemaria' ),
            'add_new_item'  => __( 'Afegir nova Àrea', 'avemaria' ),
            'edit_item'     => __( 'Editar Àrea', 'avemaria' ),
            'menu_name'     => __( 'Equip Àrees', 'avemaria' ),
        ],
        'public'       => false,
        'show_ui'      => true,
        'has_archive'  => false,
        'rewrite'      => [ 'slug' => 'equip-area' ],
        'menu_icon'    => 'dashicons-networking',
        'supports'     => [ 'title', 'editor' ],
        'show_in_rest' => true,
    ] );

    // --- Estadístiques (6 stats "El nostre impacte") ---
    register_post_type( 'estadistica', [
        'labels' => [
            'name'          => __( 'Estadístiques', 'avemaria' ),
            'singular_name' => __( 'Estadística', 'avemaria' ),
            'add_new'       => __( 'Afegir Estadística', 'avemaria' ),
            'add_new_item'  => __( 'Afegir nova Estadística', 'avemaria' ),
            'edit_item'     => __( 'Editar Estadística', 'avemaria' ),
            'menu_name'     => __( 'Estadístiques', 'avemaria' ),
        ],
        'public'       => false,
        'show_ui'      => true,
        'has_archive'  => false,
        'rewrite'      => [ 'slug' => 'estadistica' ],
        'menu_icon'    => 'dashicons-chart-bar',
        'supports'     => [ 'title', 'page-attributes' ],
        'show_in_rest' => true,
    ] );

    // --- Valors (5 valors de la Fundació) ---
    register_post_type( 'valor', [
        'labels' => [
            'name'          => __( 'Valors', 'avemaria' ),
            'singular_name' => __( 'Valor', 'avemaria' ),
            'add_new'       => __( 'Afegir Valor', 'avemaria' ),
            'add_new_item'  => __( 'Afegir nou Valor', 'avemaria' ),
            'edit_item'     => __( 'Editar Valor', 'avemaria' ),
            'menu_name'     => __( 'Valors', 'avemaria' ),
        ],
        'public'       => false,
        'show_ui'      => true,
        'has_archive'  => false,
        'rewrite'      => [ 'slug' => 'valor' ],
        'menu_icon'    => 'dashicons-heart',
        'supports'     => [ 'title', 'editor', 'page-attributes' ],
        'show_in_rest' => true,
    ] );

    // --- Fites (timeline de trajectòria) ---
    register_post_type( 'fita', [
        'labels' => [
            'name'          => __( 'Fites', 'avemaria' ),
            'singular_name' => __( 'Fita', 'avemaria' ),
            'add_new'       => __( 'Afegir Fita', 'avemaria' ),
            'add_new_item'  => __( 'Afegir nova Fita', 'avemaria' ),
            'edit_item'     => __( 'Editar Fita', 'avemaria' ),
            'menu_name'     => __( 'Fites', 'avemaria' ),
        ],
        'public'       => false,
        'show_ui'      => true,
        'has_archive'  => false,
        'rewrite'      => [ 'slug' => 'fita' ],
        'menu_icon'    => 'dashicons-calendar-alt',
        'supports'     => [ 'title' ],
        'show_in_rest' => true,
    ] );

    // --- Col·laboradors (marquesina de logos) ---
    register_post_type( 'colaborador', [
        'labels' => [
            'name'          => __( 'Col·laboradors', 'avemaria' ),
            'singular_name' => __( 'Col·laborador', 'avemaria' ),
            'add_new'       => __( 'Afegir Col·laborador', 'avemaria' ),
            'add_new_item'  => __( 'Afegir nou Col·laborador', 'avemaria' ),
            'edit_item'     => __( 'Editar Col·laborador', 'avemaria' ),
            'menu_name'     => __( 'Col·laboradors', 'avemaria' ),
        ],
        'public'       => false,
        'show_ui'      => true,
        'has_archive'  => false,
        'rewrite'      => [ 'slug' => 'colaborador' ],
        'menu_icon'    => 'dashicons-networking',
        'supports'     => [ 'title', 'thumbnail', 'page-attributes' ],
        'show_in_rest' => true,
    ] );
}

/**
 * Rewrite del CPT `servei` amb URL /serveis/{slug}/
 */
add_filter( 'post_type_link', 'avemaria_servei_permalink', 10, 2 );
function avemaria_servei_permalink( $post_link, $post ) {
    if ( is_object( $post ) && $post->post_type === 'servei' ) {
        $post_link = str_replace( '%servei%', $post->post_name, $post_link );
    }
    return $post_link;
}

// Flush rewrite rules on theme activation
add_action( 'after_switch_theme', function () {
    avemaria_register_post_types();
    flush_rewrite_rules();
} );
