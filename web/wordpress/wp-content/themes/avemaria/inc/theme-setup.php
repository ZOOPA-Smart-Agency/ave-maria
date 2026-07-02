<?php
/**
 * Theme Setup — menus, supports, image sizes
 *
 * @package Ave_Maria
 */

add_action('after_setup_theme', function () {
    load_theme_textdomain('avemaria', AVEMARIA_DIR . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', [
        'height'      => 80,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ]);
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('editor-styles');
    add_theme_support('wp-block-styles');
    add_theme_support('responsive-embeds');

    add_image_size('avemaria-hero', 1400, 700, true);
    add_image_size('avemaria-card', 600, 600, true);
    add_image_size('avemaria-gallery', 800, 600, true);
    add_image_size('avemaria-team', 400, 400, true);

    register_nav_menus([
        'primary'   => __('Menú Principal', 'avemaria'),
        'footer'    => __('Menú Footer', 'avemaria'),
        'services'  => __('Menú Servicios (Footer)', 'avemaria'),
    ]);
});

add_action('widgets_init', function () {
    register_sidebar([
        'name'          => __('Footer Widget Area', 'avemaria'),
        'id'            => 'footer-widgets',
        'before_widget' => '<div class="footer__col">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer__heading">',
        'after_title'   => '</h4>',
    ]);
});
