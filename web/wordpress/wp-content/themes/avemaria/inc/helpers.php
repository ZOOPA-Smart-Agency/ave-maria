<?php
/**
 * Theme Helper Functions
 *
 * @package Ave_Maria
 */

/**
 * Helper de traducción rápida: devuelve la cadena traducida vía Polylang
 * si el plugin está activo, o la cadena original si no lo está.
 *
 * La cadena debe estar registrada en inc/polylang.php con pll_register_string().
 */
function avemaria_t($text) {
    return function_exists('pll__') ? pll__($text) : $text;
}

/**
 * Get theme asset URL with cache-busting (filemtime) para imágenes/vídeos/etc.
 * Si el archivo existe localmente, añade ?v=<timestamp> a la URL para
 * invalidar la caché del navegador cada vez que se actualiza el archivo.
 */
function avemaria_asset($path) {
    $rel  = ltrim($path, '/');
    $url  = AVEMARIA_URI . '/assets/' . $rel;
    $file = get_stylesheet_directory() . '/assets/' . $rel;
    if (file_exists($file)) {
        $url .= (strpos($url, '?') === false ? '?' : '&') . 'v=' . filemtime($file);
    }
    return $url;
}

/**
 * Render the page hero section used on subpages
 */
function avemaria_page_hero($title = '', $options = []) {
    $post_id  = get_the_ID();
    $label    = avemaria_field('hero_label', $post_id);
    $subtitle = avemaria_field('hero_subtitle', $post_id);
    $green_word_field = avemaria_field('hero_green_word', $post_id);

    if (empty($title)) {
        $title = get_the_title();
    }

    $green_word = $green_word_field ?: ($options['green_word'] ?? $title);
    ?>
    <section class="page-hero" data-bg="#000000">
        <!-- Stop al final para mantener el body negro durante TODO el hero;
             así el cambio de color ocurre en la frontera con la siguiente sección,
             no dentro del hero (evita el corte visual hero↔body). -->
        <div class="page-hero__stop" data-bg="#000000" style="position:absolute; left:0; top:95%; width:1px; height:1px; opacity:0; pointer-events:none;"></div>
        <div class="page-hero__container" data-animate="fadeInUp">
            <?php if ($label) : ?>
                <p class="section-label section-label--center"><?php echo esc_html($label); ?></p>
            <?php endif; ?>
            <h1 class="page-hero__title"><span class="text-green"><?php echo esc_html($green_word); ?></span></h1>
            <?php if ($subtitle) : ?>
                <p class="page-hero__subtitle"><?php echo esc_html($subtitle); ?></p>
            <?php endif; ?>
        </div>
    </section>
    <?php
}

/**
 * ID de la página "Ajustes Globales" donde viven los campos comunes.
 * Si Polylang está activo, devuelve la traducción para el idioma actual.
 */
function avemaria_settings_id() {
    $id = (int) get_option('avemaria_settings_page_id', 0);
    if (!$id) {
        $p = get_page_by_path('ajustes-globales', OBJECT, 'page');
        $id = $p ? (int) $p->ID : 0;
        if ($id) update_option('avemaria_settings_page_id', $id);
    }
    if ($id && function_exists('pll_get_post')) {
        $tr = pll_get_post($id);
        if ($tr) return (int) $tr;
    }
    return $id;
}

/**
 * Permalink de una página por slug, traducido al idioma actual si Polylang está activo.
 * Devuelve home_url($fallback_path) si no encuentra nada.
 */
function avemaria_page_url($slug, $fallback_path = '/') {
    $page = get_page_by_path($slug);
    if (!$page) return home_url($fallback_path);
    $id = (int) $page->ID;
    if (function_exists('pll_get_post')) {
        $tr = pll_get_post($id);
        if ($tr) $id = (int) $tr;
    }
    $url = get_permalink($id);
    return $url ?: home_url($fallback_path);
}

/**
 * Render the CTA Final section (reusable)
 */
function avemaria_cta_final() {
    $settings_id = avemaria_settings_id();
    $contact_url = avemaria_page_url('contacto', '/contacto/');

    $title     = avemaria_field('ag_cta_title',     $settings_id, avemaria_t('Empecemos a construir<br>tu <span class="text-green">próximo proyecto</span>'));
    $text      = avemaria_field('ag_cta_text',      $settings_id, avemaria_t('Cuéntanos tu idea y te proponemos la mejor solución de personalización textil para tu marca.'));
    $btn1_text = avemaria_field('ag_cta_btn1_text', $settings_id, avemaria_t('Solicitar presupuesto'));
    $btn2_text = avemaria_field('ag_cta_btn2_text', $settings_id, avemaria_t('Llamar ahora — 932 50 06 38'));
    $btn2_tel  = avemaria_field('ag_cta_btn2_tel',  $settings_id, '932500638');
    ?>
    <section class="cta-final" data-bg="#000000">
        <div class="cta-final__container" data-animate="fadeInUp">
            <h2 class="cta-final__title"><?php echo wp_kses_post($title); ?></h2>
            <p class="cta-final__text"><?php echo esc_html($text); ?></p>
            <div class="cta-final__actions">
                <a href="<?php echo esc_url($contact_url); ?>" class="btn btn--primary btn--lg"><?php echo esc_html($btn1_text); ?></a>
                <a href="tel:<?php echo esc_attr($btn2_tel); ?>" class="btn btn--ghost btn--lg"><?php echo esc_html($btn2_text); ?></a>
            </div>
        </div>
    </section>
    <?php
}

/**
 * Render logos bar
 */
function avemaria_logos_bar() {
    $settings_id = avemaria_settings_id();
    $logo_url = avemaria_field('ag_logos_img', $settings_id) ?: avemaria_asset('img/LOGOS_CLIENTS2.png');
    $logo_alt = avemaria_field('ag_logos_alt', $settings_id, avemaria_t('Clientes Fundació Ave Maria'));
    ?>
    <section class="logos-bar">
        <div class="logos-bar__track">
            <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($logo_alt); ?>" class="logos-bar__img">
            <img src="<?php echo esc_url($logo_url); ?>" alt="" class="logos-bar__img" aria-hidden="true">
        </div>
    </section>
    <?php
}

/**
 * Get custom logo URL or fallback
 */
function avemaria_logo_url() {
    $custom_logo_id = get_theme_mod('custom_logo');
    if ($custom_logo_id) {
        return wp_get_attachment_image_url($custom_logo_id, 'full');
    }
    return avemaria_asset('img/logo.png');
}
