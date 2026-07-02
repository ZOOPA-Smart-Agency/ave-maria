<?php
/**
 * Gestor de blocs dinàmics — Ave Maria
 *
 * Permet afegir, editar, eliminar i reordenar Serveis, Notícies i Testimonis
 * des del panel WP.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/* ----------------------------- Data ----------------------------- */

function avemaria_block_defaults() {
    static $c = null; if ( $c !== null ) return $c;
    $p = get_template_directory() . '/inc/blocks-defaults.json';
    $c = file_exists( $p ) ? json_decode( file_get_contents( $p ), true ) : [];
    return is_array( $c ) ? $c : [];
}
function avemaria_get_blocks( $type ) {
    $stored = get_option( 'avemaria_blocks_' . $type, null );
    if ( is_array( $stored ) ) return $stored;
    $d = avemaria_block_defaults();
    return $d[ $type ] ?? [];
}
function avemaria_save_blocks( $type, $items ) {
    return update_option( 'avemaria_blocks_' . $type, $items );
}

/* ----------------------------- Menú ----------------------------- */

add_action( 'admin_menu', function() {
    add_submenu_page(
        'avemaria-editor',
        'Blocs dinàmics',
        '📦 Blocs dinàmics',
        'edit_theme_options',
        'avemaria-blocks',
        'avemaria_render_blocks_editor'
    );
}, 15 );

add_action( 'admin_enqueue_scripts', function( $hook ) {
    if ( strpos( (string) $hook, 'avemaria-blocks' ) === false ) return;
    wp_enqueue_media();
} );

/* ----------------------------- Guardar ----------------------------- */

add_action( 'admin_init', function() {
    if ( ! isset( $_POST['avm_blocks_save'] ) ) return;
    if ( ! current_user_can( 'edit_theme_options' ) ) return;
    check_admin_referer( 'avm_blocks_save' );
    $type = sanitize_text_field( $_POST['type'] ?? '' );
    if ( ! in_array( $type, [ 'serveis_home', 'noticies_home', 'testimonis' ], true ) ) return;
    $items = $_POST['items'] ?? [];
    $clean = [];
    if ( is_array( $items ) ) {
        foreach ( $items as $it ) {
            if ( empty( $it ) || ! is_array( $it ) ) continue;
            $entry = [];
            foreach ( $it as $k => $v ) {
                $entry[ sanitize_key( $k ) ] = wp_kses_post( wp_unslash( is_string($v) ? $v : '' ) );
            }
            $clean[] = $entry;
        }
    }
    avemaria_save_blocks( $type, $clean );
    wp_redirect( add_query_arg( [ 'saved' => '1', 'type' => $type ], admin_url( 'admin.php?page=avemaria-blocks' ) ) );
    exit;
} );

/* ----------------------------- Render ----------------------------- */

function avemaria_render_blocks_editor() {
    $type = sanitize_text_field( $_GET['type'] ?? 'serveis_home' );
    $tabs = [
        'serveis_home'  => [ 'label' => '📋 Serveis (home)',   'fn' => 'avemaria_render_tab_serveis' ],
        'noticies_home' => [ 'label' => '📰 Notícies (home)',  'fn' => 'avemaria_render_tab_noticies' ],
        'testimonis'    => [ 'label' => '💬 Testimonis',       'fn' => 'avemaria_render_tab_testimonis' ],
    ];
    if ( ! isset( $tabs[ $type ] ) ) $type = 'serveis_home';
    ?>
    <div class="wrap">
        <h1>📦 Blocs dinàmics</h1>
        <?php if ( ! empty( $_GET['saved'] ) ): ?><div class="notice notice-success is-dismissible"><p><strong>Canvis guardats.</strong></p></div><?php endif; ?>
        <p style="max-width:820px">Aquí pots <strong>afegir, editar, eliminar i reordenar</strong> els elements repetitius de la web: serveis, notícies i testimonis.</p>

        <h2 class="nav-tab-wrapper" style="margin-top:20px">
            <?php foreach ( $tabs as $k => $t ):
                $url = add_query_arg( [ 'page' => 'avemaria-blocks', 'type' => $k ], admin_url( 'admin.php' ) );
                $cls = $k === $type ? 'nav-tab nav-tab-active' : 'nav-tab';
            ?>
            <a href="<?php echo esc_url( $url ); ?>" class="<?php echo $cls; ?>"><?php echo esc_html( $t['label'] ); ?></a>
            <?php endforeach; ?>
        </h2>
        <div style="background:#fff;padding:20px;border:1px solid #ccd0d4;border-top:none">
            <?php call_user_func( $tabs[ $type ]['fn'] ); ?>
        </div>
    </div>
    <style>
        .avm-block-item { background: #fafafa; border: 1px solid #ddd; border-radius: 6px; padding: 16px; margin-bottom: 14px; position: relative; }
        .avm-block-item.dragging { opacity: 0.4; }
        .avm-block-actions { position: absolute; top: 12px; right: 12px; display: flex; gap: 6px; }
        .avm-drag-handle { cursor: move; color: #999; font-size: 20px; margin-right: 10px; }
        .avm-block-item .row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 10px; }
        .avm-block-item label { display: block; font-size: 12px; font-weight: 600; color: #555; margin-bottom: 3px; }
        .avm-block-item input[type="text"], .avm-block-item textarea, .avm-block-item select { width: 100%; }
        .avm-add-block { background: #E8863A; color: #fff; border: 0; padding: 10px 18px; font-weight: 600; cursor: pointer; border-radius: 4px; }
        .avm-remove-btn { background: #a00; color: #fff; border: 0; padding: 5px 10px; font-size: 11px; cursor: pointer; border-radius: 3px; }
        .avm-move-btn { background: #666; color: #fff; border: 0; padding: 5px 8px; font-size: 11px; cursor: pointer; border-radius: 3px; }
        .avm-img-picker { display: flex; gap: 10px; align-items: center; }
        .avm-img-picker .preview { width: 80px; height: 60px; background: #eee center/cover no-repeat; border-radius: 3px; border: 1px solid #ddd; }
    </style>
    <script>
    function avmPickImage(input) {
        if (!window.wp || !wp.media) return;
        const frame = wp.media({title:'Selecciona imatge', multiple:false, library:{type:'image'}});
        frame.on('select', function(){
            const a = frame.state().get('selection').first().toJSON();
            input.value = a.url;
            const preview = input.closest('.avm-img-picker').querySelector('.preview');
            preview.style.backgroundImage = "url('"+a.url+"')";
        });
        frame.open();
    }
    function avmMove(btn, delta) {
        const item = btn.closest('.avm-block-item');
        const parent = item.parentElement;
        const items = Array.from(parent.querySelectorAll('.avm-block-item'));
        const idx = items.indexOf(item);
        const target = idx + delta;
        if (target < 0 || target >= items.length) return;
        if (delta < 0) parent.insertBefore(item, items[target]);
        else parent.insertBefore(items[target], item);
        avmReindex();
    }
    function avmRemove(btn) {
        if (!confirm('Eliminar aquest bloc?')) return;
        btn.closest('.avm-block-item').remove();
        avmReindex();
    }
    function avmAdd(templateId) {
        const tpl = document.getElementById(templateId).innerHTML;
        const container = document.getElementById('avm-blocks-list');
        const wrap = document.createElement('div');
        wrap.innerHTML = tpl;
        container.appendChild(wrap.firstElementChild);
        avmReindex();
    }
    function avmReindex() {
        document.querySelectorAll('#avm-blocks-list .avm-block-item').forEach(function(item, idx){
            item.querySelectorAll('[name]').forEach(function(el){
                el.name = el.name.replace(/items\[\d+\]/, 'items['+idx+']');
            });
        });
    }
    </script>
    <?php
}

/* ---------- Serveis ---------- */

function avemaria_render_tab_serveis() {
    $items = avemaria_get_blocks( 'serveis_home' );
    $pages = [
        'campus' => 'Campus Residencial',
        'llars' => 'Llars amb Suport',
        'sad' => 'Atenció Domiciliària',
        'centresdia' => 'Centres de Dia',
        'families' => 'Suport Famílies + Inclusió',
        'recerca' => 'Recerca i Innovació',
        'serveis' => '── (Índex de serveis)',
    ];
    ?>
    <form method="post">
        <?php wp_nonce_field( 'avm_blocks_save' ); ?>
        <input type="hidden" name="type" value="serveis_home">
        <div id="avm-blocks-list">
            <?php foreach ( $items as $i => $it ) avemaria_render_servei_row( $i, $it, $pages ); ?>
        </div>
        <p><button type="button" class="avm-add-block" onclick="avmAdd('avm-tpl-servei')">+ Afegir servei</button></p>
        <hr>
        <p><button type="submit" name="avm_blocks_save" class="button button-primary button-hero">💾 Guardar</button></p>
    </form>
    <template id="avm-tpl-servei"><?php avemaria_render_servei_row( 999, [], $pages, true ); ?></template>
    <?php
}
function avemaria_render_servei_row( $idx, $it, $pages, $is_template = false ) {
    $img = $it['img'] ?? '';
    $img_url = $img;
    if ( $img && ! preg_match( '~^https?://|^/wp-content/~', $img ) ) {
        $img_url = get_template_directory_uri() . '/assets/img/' . $img;
    }
    ?>
    <div class="avm-block-item">
        <div class="avm-block-actions">
            <button type="button" class="avm-move-btn" onclick="avmMove(this,-1)">↑</button>
            <button type="button" class="avm-move-btn" onclick="avmMove(this,1)">↓</button>
            <button type="button" class="avm-remove-btn" onclick="avmRemove(this)">🗑️ Eliminar</button>
        </div>
        <h4 style="margin:0 0 10px"><span class="avm-drag-handle">⋮⋮</span> Servei</h4>
        <div class="row">
            <label>Número<input type="text" name="items[<?php echo $idx; ?>][num]" value="<?php echo esc_attr( $it['num'] ?? '' ); ?>" placeholder="01"></label>
            <label>Pàgina destí
                <select name="items[<?php echo $idx; ?>][link_page]">
                    <?php foreach ( $pages as $k => $v ): ?>
                        <option value="<?php echo esc_attr( $k ); ?>" <?php selected( $it['link_page'] ?? '', $k ); ?>><?php echo esc_html( $v ); ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>
        <div class="row">
            <label>Títol (HTML, pot incloure spans CA/ES)<textarea name="items[<?php echo $idx; ?>][title_html]" rows="2"><?php echo esc_textarea( $it['title_html'] ?? '' ); ?></textarea></label>
            <label>Descripció (HTML)<textarea name="items[<?php echo $idx; ?>][desc_html]" rows="2"><?php echo esc_textarea( $it['desc_html'] ?? '' ); ?></textarea></label>
        </div>
        <label>Imatge
            <div class="avm-img-picker">
                <div class="preview" style="background-image:url('<?php echo esc_url( $img_url ); ?>')"></div>
                <input type="text" name="items[<?php echo $idx; ?>][img]" value="<?php echo esc_attr( $img ); ?>" placeholder="URL imatge">
                <button type="button" class="button" onclick="avmPickImage(this.previousElementSibling)">Triar…</button>
            </div>
        </label>
    </div>
    <?php
}

/* ---------- Notícies ---------- */

function avemaria_render_tab_noticies() {
    $items = avemaria_get_blocks( 'noticies_home' );
    $pages = [ 'noticia-1'=>'Notícia 1','noticia-2'=>'Notícia 2','noticia-3'=>'Notícia 3','noticia-4'=>'Notícia 4','noticia-5'=>'Notícia 5','noticia-6'=>'Notícia 6','actualitat'=>'Actualitat (índex)' ];
    ?>
    <p style="color:#666">Notícies que apareixen a la home (últimes destacades). Per gestionar totes les notícies, veure "Actualitat" del menú principal.</p>
    <form method="post">
        <?php wp_nonce_field( 'avm_blocks_save' ); ?>
        <input type="hidden" name="type" value="noticies_home">
        <div id="avm-blocks-list">
            <?php foreach ( $items as $i => $it ) avemaria_render_noticia_row( $i, $it, $pages ); ?>
        </div>
        <p><button type="button" class="avm-add-block" onclick="avmAdd('avm-tpl-noticia')">+ Afegir notícia</button></p>
        <hr>
        <p><button type="submit" name="avm_blocks_save" class="button button-primary button-hero">💾 Guardar</button></p>
    </form>
    <template id="avm-tpl-noticia"><?php avemaria_render_noticia_row( 999, [], $pages ); ?></template>
    <?php
}
function avemaria_render_noticia_row( $idx, $it, $pages ) {
    $img = $it['img'] ?? '';
    $img_url = $img;
    if ( $img && ! preg_match( '~^https?://|^/wp-content/~', $img ) ) {
        $img_url = get_template_directory_uri() . '/assets/img/' . $img;
    }
    ?>
    <div class="avm-block-item">
        <div class="avm-block-actions">
            <button type="button" class="avm-move-btn" onclick="avmMove(this,-1)">↑</button>
            <button type="button" class="avm-move-btn" onclick="avmMove(this,1)">↓</button>
            <button type="button" class="avm-remove-btn" onclick="avmRemove(this)">🗑️</button>
        </div>
        <h4 style="margin:0 0 10px"><span class="avm-drag-handle">⋮⋮</span> Notícia</h4>
        <div class="row">
            <label>Data (HTML)<textarea name="items[<?php echo $idx; ?>][date_html]" rows="1"><?php echo esc_textarea( $it['date_html'] ?? '' ); ?></textarea></label>
            <label>Pàgina destí
                <select name="items[<?php echo $idx; ?>][link_page]">
                    <?php foreach ( $pages as $k => $v ): ?>
                        <option value="<?php echo esc_attr( $k ); ?>" <?php selected( $it['link_page'] ?? '', $k ); ?>><?php echo esc_html( $v ); ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>
        <label>Titular (HTML)<textarea name="items[<?php echo $idx; ?>][title_html]" rows="2"><?php echo esc_textarea( $it['title_html'] ?? '' ); ?></textarea></label>
        <label style="margin-top:8px">Imatge
            <div class="avm-img-picker">
                <div class="preview" style="background-image:url('<?php echo esc_url( $img_url ); ?>')"></div>
                <input type="text" name="items[<?php echo $idx; ?>][img]" value="<?php echo esc_attr( $img ); ?>" placeholder="URL imatge">
                <button type="button" class="button" onclick="avmPickImage(this.previousElementSibling)">Triar…</button>
            </div>
        </label>
    </div>
    <?php
}

/* ---------- Testimonis ---------- */

function avemaria_render_tab_testimonis() {
    $items = avemaria_get_blocks( 'testimonis' );
    $colors = [ 'taronja','verd','blau','groc','rosa','coral' ];
    ?>
    <form method="post">
        <?php wp_nonce_field( 'avm_blocks_save' ); ?>
        <input type="hidden" name="type" value="testimonis">
        <div id="avm-blocks-list">
            <?php foreach ( $items as $i => $it ) avemaria_render_testimoni_row( $i, $it, $colors ); ?>
        </div>
        <p><button type="button" class="avm-add-block" onclick="avmAdd('avm-tpl-testimoni')">+ Afegir testimoni</button></p>
        <hr>
        <p><button type="submit" name="avm_blocks_save" class="button button-primary button-hero">💾 Guardar</button></p>
    </form>
    <template id="avm-tpl-testimoni"><?php avemaria_render_testimoni_row( 999, [], $colors ); ?></template>
    <?php
}
function avemaria_render_testimoni_row( $idx, $it, $colors ) {
    ?>
    <div class="avm-block-item">
        <div class="avm-block-actions">
            <button type="button" class="avm-move-btn" onclick="avmMove(this,-1)">↑</button>
            <button type="button" class="avm-move-btn" onclick="avmMove(this,1)">↓</button>
            <button type="button" class="avm-remove-btn" onclick="avmRemove(this)">🗑️</button>
        </div>
        <h4 style="margin:0 0 10px"><span class="avm-drag-handle">⋮⋮</span> Testimoni</h4>
        <label>Text del testimoni (HTML, pot incloure spans CA/ES)<textarea name="items[<?php echo $idx; ?>][text_html]" rows="4"><?php echo esc_textarea( $it['text_html'] ?? '' ); ?></textarea></label>
        <div class="row" style="margin-top:8px">
            <label>Autor (HTML)<textarea name="items[<?php echo $idx; ?>][author_html]" rows="1"><?php echo esc_textarea( $it['author_html'] ?? '' ); ?></textarea></label>
            <label>Rol (HTML)<textarea name="items[<?php echo $idx; ?>][role_html]" rows="1"><?php echo esc_textarea( $it['role_html'] ?? '' ); ?></textarea></label>
        </div>
        <label style="margin-top:8px">Color de marca
            <select name="items[<?php echo $idx; ?>][color]" style="width:200px">
                <?php foreach ( $colors as $c ): ?>
                    <option value="<?php echo esc_attr( $c ); ?>" <?php selected( $it['color'] ?? 'coral', $c ); ?>><?php echo esc_html( ucfirst( $c ) ); ?></option>
                <?php endforeach; ?>
            </select>
        </label>
    </div>
    <?php
}

/* ----------------------------- Render dinàmic al front ----------------------------- */

function avemaria_render_serveis_home() {
    $items = avemaria_get_blocks( 'serveis_home' );
    $out = '';
    foreach ( $items as $it ) {
        $img = $it['img'] ?? '';
        if ( $img && ! preg_match( '~^https?://|^/wp-content/~', $img ) ) {
            $img = get_template_directory_uri() . '/assets/img/' . $img;
        }
        $link = '#' . ( $it['link_page'] ?? 'serveis' );
        $onclick = "showPage('" . esc_js( $it['link_page'] ?? 'serveis' ) . "')";
        $out .= '<div class="servei-card" data-reveal>';
        $out .= '<div class="servei-img" style="background-image:url(\'' . esc_url( $img ) . '\')"></div>';
        $out .= '<div class="servei-content">';
        $out .= '<span class="servei-num">' . esc_html( $it['num'] ?? '' ) . '</span>';
        $out .= '<h3>' . ( $it['title_html'] ?? '' ) . '</h3>';
        $out .= '<p>' . ( $it['desc_html'] ?? '' ) . '</p>';
        $out .= '<a href="' . esc_attr( $link ) . '" onclick="' . esc_attr( $onclick ) . '"><span data-lang-ca>Més informació</span><span data-lang-es>Más información</span> <span class="arr">→</span></a>';
        $out .= '</div></div>';
    }
    return $out;
}
function avemaria_render_noticies_home() {
    $items = avemaria_get_blocks( 'noticies_home' );
    $out = '';
    foreach ( $items as $it ) {
        $img = $it['img'] ?? '';
        if ( $img && ! preg_match( '~^https?://|^/wp-content/~', $img ) ) {
            $img = get_template_directory_uri() . '/assets/img/' . $img;
        }
        $onclick = "showPage('" . esc_js( $it['link_page'] ?? 'actualitat' ) . "')";
        $out .= '<div class="noticia-card" data-reveal>';
        $out .= '<div class="noticia-img" style="background-image:url(\'' . esc_url( $img ) . '\')"></div>';
        $out .= '<div class="noticia-content">';
        $out .= '<p class="noticia-date">' . ( $it['date_html'] ?? '' ) . '</p>';
        $out .= '<h3><a href="#' . esc_attr( $it['link_page'] ?? '' ) . '" onclick="' . esc_attr( $onclick ) . '">' . ( $it['title_html'] ?? '' ) . '</a></h3>';
        $out .= '</div></div>';
    }
    return $out;
}
function avemaria_render_testimonis() {
    $items = avemaria_get_blocks( 'testimonis' );
    $out = '';
    foreach ( $items as $it ) {
        $color = $it['color'] ?? 'coral';
        $out .= '<article class="tc-card" style="--card-acc:var(--' . esc_attr( $color ) . ')">';
        $out .= '<span class="tc-mark">"</span>';
        $out .= '<p class="tc-text">' . ( $it['text_html'] ?? '' ) . '</p>';
        $out .= '<div class="tc-foot">';
        $out .= '<p class="tc-author">' . ( $it['author_html'] ?? '' ) . '</p>';
        $out .= '<p class="tc-role">' . ( $it['role_html'] ?? '' ) . '</p>';
        $out .= '</div></article>';
    }
    return $out;
}

function avemaria_apply_blocks_to_html( $html ) {
    $html = str_replace( '{{BLOCK_SERVEIS_HOME}}', avemaria_render_serveis_home(), $html );
    $html = str_replace( '{{BLOCK_NOTICIES_HOME}}', avemaria_render_noticies_home(), $html );
    $html = str_replace( '{{BLOCK_TESTIMONIS}}', avemaria_render_testimonis(), $html );
    return $html;
}
