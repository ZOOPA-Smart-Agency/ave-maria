<?php
/**
 * Enqueue de estilos y scripts del theme Ave Maria
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_enqueue_scripts', function() {
    $ver = wp_get_theme()->get( 'Version' );

    // CSS principal (extraído de la maqueta HTML)
    wp_enqueue_style(
        'avemaria-main',
        get_template_directory_uri() . '/assets/css/main.css',
        [],
        $ver
    );

    // GSAP + ScrollTrigger (para el parallax de imágenes)
    wp_enqueue_script(
        'gsap',
        'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js',
        [],
        '3.12.5',
        true
    );
    wp_enqueue_script(
        'gsap-scrolltrigger',
        'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js',
        [ 'gsap' ],
        '3.12.5',
        true
    );

    // JS principal (extraído de la maqueta HTML)
    wp_enqueue_script(
        'avemaria-main',
        get_template_directory_uri() . '/assets/js/main.js',
        [ 'gsap-scrolltrigger' ],
        $ver,
        true
    );
} );

// Ocultar la admin bar por defecto en el front (opcional)
add_filter( 'show_admin_bar', '__return_false' );
