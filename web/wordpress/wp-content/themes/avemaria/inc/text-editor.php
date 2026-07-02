<?php
/**
 * Editor de textos Ave Maria — versión completa
 * Cubre textos bilingües (CA/ES) y monolingües (para traducir a ES).
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* ----------------------------- Datos por defecto ----------------------------- */

function avemaria_default_texts() {
    static $c = null; if ( $c !== null ) return $c;
    $p = get_template_directory() . '/inc/texts-defaults.json';
    $c = file_exists( $p ) ? json_decode( file_get_contents( $p ), true ) : [];
    return is_array( $c ) ? $c : [];
}
function avemaria_default_texts_mono() {
    static $c = null; if ( $c !== null ) return $c;
    $p = get_template_directory() . '/inc/texts-mono-defaults.json';
    $c = file_exists( $p ) ? json_decode( file_get_contents( $p ), true ) : [];
    return is_array( $c ) ? $c : [];
}

function avemaria_get_texts() {
    $d = avemaria_default_texts();
    $o = get_option( 'avemaria_texts', [] );
    if ( ! is_array( $o ) ) $o = [];
    foreach ( $o as $k => $v ) {
        if ( isset( $d[ $k ] ) ) {
            if ( isset( $v['ca'] ) ) $d[ $k ]['ca'] = $v['ca'];
            if ( isset( $v['es'] ) ) $d[ $k ]['es'] = $v['es'];
        }
    }
    return $d;
}
function avemaria_get_texts_mono() {
    $d = avemaria_default_texts_mono();
    $o = get_option( 'avemaria_texts_mono', [] );
    if ( ! is_array( $o ) ) $o = [];
    foreach ( $o as $k => $v ) {
        if ( ! isset( $d[ $k ] ) ) continue;
        if ( isset( $v['ca'] ) ) $d[ $k ]['ca'] = $v['ca'];
        if ( isset( $v['es'] ) ) $d[ $k ]['es'] = $v['es'];
        // Si no tiene "ca" en defaults, el "text" original es CA
    }
    return $d;
}

/* ----------------------------- Menú admin ----------------------------- */

add_action( 'admin_menu', function() {
    add_menu_page(
        'Editor Ave Maria', 'Editor Ave Maria', 'edit_theme_options',
        'avemaria-editor', 'avemaria_render_text_editor',
        'dashicons-edit-large', 3
    );
    add_submenu_page( 'avemaria-editor', 'Textos bilingües (CA/ES)', '📝 Textos bilingües', 'edit_theme_options', 'avemaria-editor', 'avemaria_render_text_editor' );
    add_submenu_page( 'avemaria-editor', 'Traduccions ES', '🌍 Traduccions ES', 'edit_theme_options', 'avemaria-mono', 'avemaria_render_mono_editor' );
    add_submenu_page( 'avemaria-editor', 'Imatges', '🖼️ Imatges', 'edit_theme_options', 'avemaria-images', 'avemaria_render_image_editor' );
    add_submenu_page( 'avemaria-editor', 'Restaurar tot', '↩️ Restaurar tot', 'edit_theme_options', 'avemaria-reset', 'avemaria_render_reset' );
} );

/* ----------------------------- Guardado ----------------------------- */

add_action( 'admin_init', function() {
    if ( ! current_user_can( 'edit_theme_options' ) ) return;

    if ( isset( $_POST['avemaria_save_texts'] ) ) {
        check_admin_referer( 'avemaria_save_texts' );
        $d = avemaria_default_texts();
        $o = [];
        foreach ( ( $_POST['txt'] ?? [] ) as $k => $langs ) {
            if ( ! isset( $d[ $k ] ) ) continue;
            $ca = wp_kses_post( wp_unslash( $langs['ca'] ?? '' ) );
            $es = wp_kses_post( wp_unslash( $langs['es'] ?? '' ) );
            $entry = [];
            if ( $ca !== $d[ $k ]['ca'] ) $entry['ca'] = $ca;
            if ( $es !== $d[ $k ]['es'] ) $entry['es'] = $es;
            if ( ! empty( $entry ) ) $o[ $k ] = $entry;
        }
        update_option( 'avemaria_texts', $o );
        wp_redirect( add_query_arg( 'saved', '1', admin_url( 'admin.php?page=avemaria-editor' ) ) );
        exit;
    }

    if ( isset( $_POST['avemaria_save_mono'] ) ) {
        check_admin_referer( 'avemaria_save_mono' );
        $d = avemaria_default_texts_mono();
        $o = [];
        foreach ( ( $_POST['mono'] ?? [] ) as $k => $langs ) {
            if ( ! isset( $d[ $k ] ) ) continue;
            $ca = wp_kses_post( wp_unslash( $langs['ca'] ?? '' ) );
            $es = wp_kses_post( wp_unslash( $langs['es'] ?? '' ) );
            $entry = [];
            // "ca" es el original — solo guardo override si difiere
            $orig_ca = $d[ $k ]['text'] ?? '';
            if ( $ca !== $orig_ca ) $entry['ca'] = $ca;
            if ( $es !== '' && $es !== $orig_ca ) $entry['es'] = $es;
            if ( ! empty( $entry ) ) $o[ $k ] = $entry;
        }
        update_option( 'avemaria_texts_mono', $o );
        wp_redirect( add_query_arg( 'saved', '1', admin_url( 'admin.php?page=avemaria-mono' ) ) );
        exit;
    }

    if ( isset( $_POST['avemaria_reset_all'] ) ) {
        check_admin_referer( 'avemaria_reset_all' );
        delete_option( 'avemaria_texts' );
        delete_option( 'avemaria_texts_mono' );
        delete_option( 'avemaria_images' );
        wp_redirect( add_query_arg( 'reset', '1', admin_url( 'admin.php?page=avemaria-reset' ) ) );
        exit;
    }
} );

/* ----------------------------- Render — Textos bilingües ----------------------------- */

function avemaria_render_text_editor() {
    $texts = avemaria_get_texts();
    $groups = [];
    foreach ( $texts as $k => $d ) {
        $s = $d['section'] ?? 'ALTRES';
        $groups[ $s ][ $k ] = $d;
    }
    ?>
    <div class="wrap">
        <h1>📝 Textos bilingües (CA/ES)</h1>
        <?php if ( ! empty( $_GET['saved'] ) ): ?><div class="notice notice-success is-dismissible"><p><strong>Canvis guardats.</strong></p></div><?php endif; ?>
        <p style="max-width:820px">Textos que ja tenen versió en <strong>català i castellà</strong>. <?php echo count( $texts ); ?> entrades en <?php echo count( $groups ); ?> seccions.</p>

        <div style="display:grid;grid-template-columns:220px 1fr;gap:24px;margin-top:20px">
            <nav style="position:sticky;top:40px;align-self:start;background:#fff;padding:14px;border:1px solid #dcdcde;border-radius:6px;max-height:80vh;overflow-y:auto">
                <h3 style="margin:0 0 10px;font-size:13px;text-transform:uppercase;letter-spacing:.1em;color:#666">Seccions</h3>
                <ul style="list-style:none;margin:0;padding:0;font-size:13px">
                    <?php foreach ( $groups as $s => $items ): ?>
                        <li style="margin:6px 0"><a href="#s-<?php echo sanitize_title( $s ); ?>"><?php echo esc_html( $s ); ?> <span style="color:#999">(<?php echo count( $items ); ?>)</span></a></li>
                    <?php endforeach; ?>
                </ul>
            </nav>
            <form method="post">
                <?php wp_nonce_field( 'avemaria_save_texts' ); ?>
                <?php foreach ( $groups as $s => $items ): ?>
                    <div id="s-<?php echo sanitize_title( $s ); ?>" style="background:#fff;padding:20px 24px;border:1px solid #dcdcde;border-radius:6px;margin-bottom:20px">
                        <h2 style="margin:0 0 6px"><?php echo esc_html( $s ); ?></h2>
                        <p style="margin:0 0 20px;color:#666;font-size:13px"><?php echo count( $items ); ?> textos</p>
                        <?php foreach ( $items as $k => $d ):
                            $prev = mb_substr( wp_strip_all_tags( $d['ca'] ), 0, 60 ); ?>
                            <div style="border-top:1px solid #f0f0f1;padding:12px 0">
                                <div style="display:flex;justify-content:space-between;margin-bottom:6px"><strong style="font-size:11px;color:#666"><?php echo esc_html( $k ); ?></strong><span style="font-size:11px;color:#999;font-style:italic">"<?php echo esc_html( $prev ); ?>…"</span></div>
                                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                                    <label><span style="display:block;font-size:11px;font-weight:600;color:#2271b1;margin-bottom:3px">🏴 Català</span><textarea name="txt[<?php echo esc_attr( $k ); ?>][ca]" rows="2" style="width:100%"><?php echo esc_textarea( $d['ca'] ); ?></textarea></label>
                                    <label><span style="display:block;font-size:11px;font-weight:600;color:#a00;margin-bottom:3px">🇪🇸 Castellano</span><textarea name="txt[<?php echo esc_attr( $k ); ?>][es]" rows="2" style="width:100%"><?php echo esc_textarea( $d['es'] ); ?></textarea></label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
                <div style="position:sticky;bottom:20px;background:#fff;padding:14px;border:2px solid #2271b1;border-radius:6px;text-align:right"><button type="submit" name="avemaria_save_texts" class="button button-primary button-hero">💾 Guardar</button></div>
            </form>
        </div>
    </div>
    <?php
}

/* ----------------------------- Render — Textos monolingües ----------------------------- */

function avemaria_render_mono_editor() {
    $texts = avemaria_get_texts_mono();
    $groups = [];
    foreach ( $texts as $k => $d ) {
        $s = $d['section'] ?? 'ALTRES';
        $groups[ $s ][ $k ] = $d;
    }
    ?>
    <div class="wrap">
        <h1>🌍 Traduccions ES i textos monolingües</h1>
        <?php if ( ! empty( $_GET['saved'] ) ): ?><div class="notice notice-success is-dismissible"><p><strong>Canvis guardats.</strong></p></div><?php endif; ?>
        <p style="max-width:820px">Textos que originàriament només tenien versió catalana (títols de secció, subtítols, contingut, etc.). Aquí pots <strong>editar el català</strong> i <strong>afegir la traducció al castellà</strong>. <?php echo count( $texts ); ?> entrades en <?php echo count( $groups ); ?> seccions.</p>

        <div style="display:grid;grid-template-columns:220px 1fr;gap:24px;margin-top:20px">
            <nav style="position:sticky;top:40px;align-self:start;background:#fff;padding:14px;border:1px solid #dcdcde;border-radius:6px;max-height:80vh;overflow-y:auto">
                <h3 style="margin:0 0 10px;font-size:13px;text-transform:uppercase;letter-spacing:.1em;color:#666">Seccions</h3>
                <ul style="list-style:none;margin:0;padding:0;font-size:13px">
                    <?php foreach ( $groups as $s => $items ): ?>
                        <li style="margin:6px 0"><a href="#m-<?php echo sanitize_title( $s ); ?>"><?php echo esc_html( $s ); ?> <span style="color:#999">(<?php echo count( $items ); ?>)</span></a></li>
                    <?php endforeach; ?>
                </ul>
            </nav>
            <form method="post">
                <?php wp_nonce_field( 'avemaria_save_mono' ); ?>
                <?php foreach ( $groups as $s => $items ): ?>
                    <div id="m-<?php echo sanitize_title( $s ); ?>" style="background:#fff;padding:20px 24px;border:1px solid #dcdcde;border-radius:6px;margin-bottom:20px">
                        <h2 style="margin:0 0 6px"><?php echo esc_html( $s ); ?></h2>
                        <p style="margin:0 0 20px;color:#666;font-size:13px"><?php echo count( $items ); ?> textos</p>
                        <?php foreach ( $items as $k => $d ):
                            $orig = $d['text'] ?? '';
                            $ca = $d['ca'] ?? $orig;
                            $es = $d['es'] ?? '';
                            $prev = mb_substr( wp_strip_all_tags( $orig ), 0, 60 ); ?>
                            <div style="border-top:1px solid #f0f0f1;padding:12px 0">
                                <div style="display:flex;justify-content:space-between;margin-bottom:6px"><strong style="font-size:11px;color:#666"><?php echo esc_html( $k ); ?></strong><span style="font-size:11px;color:#999;font-style:italic">&lt;<?php echo esc_html( $d['parent_tag'] ?? '' ); ?>&gt; "<?php echo esc_html( $prev ); ?>…"</span></div>
                                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                                    <label><span style="display:block;font-size:11px;font-weight:600;color:#2271b1;margin-bottom:3px">🏴 Català</span><textarea name="mono[<?php echo esc_attr( $k ); ?>][ca]" rows="2" style="width:100%"><?php echo esc_textarea( $ca ); ?></textarea></label>
                                    <label><span style="display:block;font-size:11px;font-weight:600;color:#a00;margin-bottom:3px">🇪🇸 Castellano</span><textarea name="mono[<?php echo esc_attr( $k ); ?>][es]" rows="2" placeholder="Deixa buit per usar el català per defecte" style="width:100%"><?php echo esc_textarea( $es ); ?></textarea></label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
                <div style="position:sticky;bottom:20px;background:#fff;padding:14px;border:2px solid #2271b1;border-radius:6px;text-align:right"><button type="submit" name="avemaria_save_mono" class="button button-primary button-hero">💾 Guardar</button></div>
            </form>
        </div>
    </div>
    <?php
}

/* ----------------------------- Render — Restaurar tot ----------------------------- */

function avemaria_render_reset() {
    ?>
    <div class="wrap">
        <h1>↩️ Restaurar tot</h1>
        <?php if ( ! empty( $_GET['reset'] ) ): ?><div class="notice notice-success is-dismissible"><p><strong>Restauració completada.</strong> Tots els textos i imatges han tornat a l'original.</p></div><?php endif; ?>
        <p style="max-width:820px">Aquesta acció esborra <strong>tots els canvis</strong> fets al panell (textos bilingües, traduccions al castellà i imatges) i restaura l'estat original de la maqueta.</p>
        <form method="post" onsubmit="return confirm('Segur que vols restaurar tots els textos i imatges? Aquesta acció no es pot desfer.');">
            <?php wp_nonce_field( 'avemaria_reset_all' ); ?>
            <button type="submit" name="avemaria_reset_all" class="button button-secondary button-hero" style="background:#a00;color:#fff;border-color:#a00">🗑️ Restaurar tot al valor original</button>
        </form>
    </div>
    <?php
}

/* ----------------------------- Aplicación al front ----------------------------- */

function avemaria_apply_texts_to_html( $html ) {
    $r = [];
    foreach ( avemaria_get_texts() as $k => $d ) {
        $r[ '{{' . $k . '_ca}}' ] = $d['ca'];
        $r[ '{{' . $k . '_es}}' ] = $d['es'];
    }
    foreach ( avemaria_get_texts_mono() as $k => $d ) {
        $orig = $d['text'] ?? '';
        $ca = $d['ca'] ?? $orig;
        $es = $d['es'] ?? '';
        // Si no hay traducción ES, uso el CA (para que la web muestre algo)
        if ( $es === '' ) $es = $ca;
        // Formato: mono_XXX se emite tal cual sin diferenciar idioma;
        // envolvemos ambos idiomas en spans data-lang para el switcher
        $r[ '{{' . $k . '}}' ] = '<span data-lang-ca>' . $ca . '</span><span data-lang-es>' . $es . '</span>';
    }
    return strtr( $html, $r );
}
