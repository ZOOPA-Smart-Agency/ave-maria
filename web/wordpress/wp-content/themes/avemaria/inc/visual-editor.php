<?php
/**
 * Editor Visual — Ave Maria
 * Vista de cada página con edición directa: clic en textos e imágenes para modificar.
 */

if ( ! defined( 'ABSPATH' ) ) exit;


add_action( 'admin_enqueue_scripts', function( $hook ) {
    if ( strpos( (string) $hook, 'avemaria-visual' ) === false ) return;
    wp_enqueue_media();
} );

/* ----------------------------- Menú admin ----------------------------- */

add_action( 'admin_menu', function() {
    add_submenu_page(
        'avemaria-editor',
        'Editor Visual',
        '👁️ Editor Visual',
        'edit_theme_options',
        'avemaria-visual',
        'avemaria_render_visual_editor'
    );
}, 20 );

/* ----------------------------- Páginas disponibles ----------------------------- */

function avemaria_pages_list() {
    return [
        'home'        => [ 'label' => '🏠 Inici', 'hash' => '#home' ],
        'quisom'      => [ 'label' => 'Qui Som', 'hash' => '#quisom' ],
        'historia'    => [ 'label' => 'Història', 'hash' => '#historia' ],
        'missio'      => [ 'label' => 'Missió i Valors', 'hash' => '#missio' ],
        'equip'       => [ 'label' => 'Equip', 'hash' => '#equip' ],
        'transparencia' => [ 'label' => 'Transparència', 'hash' => '#transparencia' ],
        'serveis'     => [ 'label' => '── Serveis (índex)', 'hash' => '#serveis' ],
        'campus'      => [ 'label' => '── Campus Residencial', 'hash' => '#campus' ],
        'llars'       => [ 'label' => '── Llars amb Suport', 'hash' => '#llars' ],
        'sad'         => [ 'label' => '── Atenció Domiciliària', 'hash' => '#sad' ],
        'centresdia'  => [ 'label' => '── Centres de Dia', 'hash' => '#centresdia' ],
        'families'    => [ 'label' => '── Suport Famílies + Inclusió', 'hash' => '#families' ],
        'recerca'     => [ 'label' => '── Recerca i Innovació', 'hash' => '#recerca' ],
        'collabora'   => [ 'label' => 'Col·labora', 'hash' => '#collabora' ],
        'donar'       => [ 'label' => '── Fer un donatiu', 'hash' => '#donar' ],
        'art'         => [ 'label' => '── Fons d\'Art', 'hash' => '#art' ],
        'botiga'      => [ 'label' => '── Botiga', 'hash' => '#botiga' ],
        'actualitat'  => [ 'label' => 'Actualitat', 'hash' => '#actualitat' ],
        'noticia-1'   => [ 'label' => '── Notícia 1 (SAD)', 'hash' => '#noticia-1' ],
        'noticia-2'   => [ 'label' => '── Notícia 2 (Grangel)', 'hash' => '#noticia-2' ],
        'noticia-3'   => [ 'label' => '── Notícia 3 (Benviure)', 'hash' => '#noticia-3' ],
        'noticia-4'   => [ 'label' => '── Notícia 4 (Torneig)', 'hash' => '#noticia-4' ],
        'noticia-5'   => [ 'label' => '── Notícia 5 (Concert)', 'hash' => '#noticia-5' ],
        'noticia-6'   => [ 'label' => '── Notícia 6 (Maria Pilar)', 'hash' => '#noticia-6' ],
        'contacte'    => [ 'label' => 'Contacte', 'hash' => '#contacte' ],
    ];
}

/* ----------------------------- Render de la pantalla admin ----------------------------- */

function avemaria_render_visual_editor() {
    $pages = avemaria_pages_list();
    $current_page = isset( $_GET['view'] ) ? sanitize_text_field( $_GET['view'] ) : 'home';
    $current_lang = isset( $_GET['lang'] ) ? sanitize_text_field( $_GET['lang'] ) : 'ca';
    if ( ! isset( $pages[ $current_page ] ) ) $current_page = 'home';
    if ( ! in_array( $current_lang, [ 'ca', 'es' ], true ) ) $current_lang = 'ca';

    $frame_url = home_url( '/?avm_editmode=1&avm_lang=' . $current_lang ) . $pages[ $current_page ]['hash'];
    ?>
    <style>
        #wpcontent { padding-left: 0 !important; }
        #wpbody-content { padding-bottom: 0 !important; }
        .avm-visual-wrap { display: grid; grid-template-columns: 260px 1fr; height: calc(100vh - 32px); }
        .avm-visual-sidebar { background: #1e1e1e; color: #eee; overflow-y: auto; padding: 20px 0; }
        .avm-visual-sidebar h2 { color: #fff; margin: 0 20px 12px; font-size: 15px; font-weight: 700; }
        .avm-visual-sidebar .lang-switch { padding: 0 20px 16px; border-bottom: 1px solid #333; }
        .avm-visual-sidebar .lang-switch button { flex:1; background: #333; color: #999; border: none; padding: 8px; font-size: 12px; font-weight: 700; letter-spacing: .1em; cursor: pointer; }
        .avm-visual-sidebar .lang-switch button.active { background: #E8863A; color: #fff; }
        .avm-visual-sidebar .lang-switch-btns { display: flex; gap: 4px; }
        .avm-visual-sidebar ul { list-style: none; margin: 12px 0 0; padding: 0; }
        .avm-visual-sidebar li a { display: block; padding: 6px 20px; color: #ccc; text-decoration: none; font-size: 13px; border-left: 3px solid transparent; }
        .avm-visual-sidebar li a:hover { background: #2a2a2a; color: #fff; }
        .avm-visual-sidebar li a.active { background: #E8863A22; color: #fff; border-left-color: #E8863A; font-weight: 600; }
        .avm-visual-main { position: relative; background: #f0f0f1; }
        .avm-toolbar { background: #fff; border-bottom: 1px solid #ddd; padding: 10px 20px; display: flex; align-items: center; gap: 12px; }
        .avm-toolbar .title { font-weight: 600; font-size: 14px; }
        .avm-toolbar .hint { color: #666; font-size: 12px; }
        .avm-frame-wrap { height: calc(100vh - 32px - 55px); }
        .avm-frame-wrap iframe { width: 100%; height: 100%; border: 0; background: #fff; }
        .avm-toast { position: fixed; bottom: 30px; right: 30px; background: #2d936c; color: #fff; padding: 12px 20px; border-radius: 6px; font-size: 13px; z-index: 10000; opacity: 0; transform: translateY(20px); transition: .3s; box-shadow: 0 10px 30px rgba(0,0,0,.2); }
        .avm-toast.show { opacity: 1; transform: translateY(0); }
        .avm-toast.error { background: #a00; }
    </style>

    <div class="avm-visual-wrap">
        <aside class="avm-visual-sidebar">
            <h2>👁️ Editor Visual</h2>
            <div class="lang-switch">
                <div style="font-size:11px;color:#999;text-transform:uppercase;letter-spacing:.14em;margin-bottom:6px">Idioma vista</div>
                <div class="lang-switch-btns">
                    <button type="button" class="<?php echo $current_lang==='ca'?'active':''; ?>" onclick="avmSetLang('ca')">🏴 CA</button>
                    <button type="button" class="<?php echo $current_lang==='es'?'active':''; ?>" onclick="avmSetLang('es')">🇪🇸 ES</button>
                </div>
            </div>
            <ul>
                <?php foreach ( $pages as $slug => $p ):
                    $url = add_query_arg( [ 'page' => 'avemaria-visual', 'view' => $slug, 'lang' => $current_lang ], admin_url( 'admin.php' ) );
                ?>
                <li><a href="<?php echo esc_url( $url ); ?>" class="<?php echo $slug===$current_page?'active':''; ?>"><?php echo esc_html( $p['label'] ); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </aside>
        <main class="avm-visual-main">
            <div class="avm-toolbar">
                <span class="title">📝 <?php echo esc_html( $pages[ $current_page ]['label'] ); ?></span>
                <span class="hint">Clica sobre qualsevol text o imatge per editar-lo directament. Els canvis es guarden automàticament.</span>
            </div>
            <div class="avm-frame-wrap">
                <iframe id="avm-frame" src="<?php echo esc_url( $frame_url ); ?>"></iframe>
            </div>
        </main>
    </div>

    <div id="avm-toast" class="avm-toast"></div>

    <script>
    const AVM_AJAX = "<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>";
    const AVM_NONCE = "<?php echo esc_attr( wp_create_nonce( 'avm_save' ) ); ?>";
    const AVM_LANG = "<?php echo esc_js( $current_lang ); ?>";

    function avmSetLang(lang) {
        const url = new URL(location.href);
        url.searchParams.set('lang', lang);
        location.href = url.toString();
    }

    function avmToast(msg, isErr) {
        const t = document.getElementById('avm-toast');
        t.textContent = msg;
        t.className = 'avm-toast show' + (isErr ? ' error' : '');
        setTimeout(()=>t.classList.remove('show'), 2000);
    }

    window.addEventListener('message', function(e) {
        if (!e.data || !e.data.avm) return;
        const d = e.data;
        if (d.type === 'pick_image') {
            // Abrir Media Library en el padre
            if (!window.wp || !wp.media) { avmToast('Media Library no disponible', true); return; }
            const frame = wp.media({title:'Selecciona una imatge', multiple:false, library:{type:'image'}});
            frame.on('select', function(){
                const a = frame.state().get('selection').first().toJSON();
                const form = new FormData();
                form.append('action','avm_save_image');
                form.append('_wpnonce', AVM_NONCE);
                form.append('key', d.key);
                form.append('url', a.url);
                fetch(AVM_AJAX,{method:'POST',body:form,credentials:'same-origin'}).then(r=>r.json()).then(res=>{
                    if (res.success) {
                        avmToast('✅ Imatge canviada');
                        document.getElementById('avm-frame').contentWindow.location.reload();
                    } else avmToast('❌ Error', true);
                });
            });
            frame.open();
        }

        if (d.type === 'save_text') {
            const form = new FormData();
            form.append('action', 'avm_save_text');
            form.append('_wpnonce', AVM_NONCE);
            form.append('key', d.key);
            form.append('lang', d.lang);
            form.append('value', d.value);
            fetch(AVM_AJAX, {method: 'POST', body: form, credentials: 'same-origin'})
                .then(r=>r.json())
                .then(res=>{
                    if (res.success) avmToast('✅ Guardat: ' + d.key);
                    else avmToast('❌ Error: ' + (res.data||'desconegut'), true);
                });
        }
        if (d.type === 'save_image') {
            const form = new FormData();
            form.append('action', 'avm_save_image');
            form.append('_wpnonce', AVM_NONCE);
            form.append('key', d.key);
            form.append('url', d.url);
            fetch(AVM_AJAX, {method: 'POST', body: form, credentials: 'same-origin'})
                .then(r=>r.json())
                .then(res=>{
                    if (res.success) avmToast('✅ Imatge canviada: ' + d.key);
                    else avmToast('❌ Error', true);
                });
        }
    });
    </script>
    <?php
}

/* ----------------------------- AJAX handlers ----------------------------- */

add_action( 'wp_ajax_avm_save_text', function() {
    if ( ! current_user_can( 'edit_theme_options' ) ) wp_send_json_error( 'sense permís' );
    check_ajax_referer( 'avm_save' );
    $key = sanitize_text_field( $_POST['key'] ?? '' );
    $lang = sanitize_text_field( $_POST['lang'] ?? 'ca' );
    $value = wp_kses_post( wp_unslash( $_POST['value'] ?? '' ) );

    if ( strpos( $key, 'txt_' ) === 0 ) {
        $o = get_option( 'avemaria_texts', [] ); if ( ! is_array($o) ) $o = [];
        $d = avemaria_default_texts();
        if ( ! isset( $d[$key] ) ) wp_send_json_error( 'key desconeguda' );
        if ( ! isset( $o[$key] ) ) $o[$key] = [];
        if ( $value !== $d[$key][$lang] ) $o[$key][$lang] = $value;
        else if ( isset( $o[$key][$lang] ) ) unset( $o[$key][$lang] );
        if ( empty( $o[$key] ) ) unset( $o[$key] );
        update_option( 'avemaria_texts', $o );
        wp_send_json_success();
    }
    if ( strpos( $key, 'mono_' ) === 0 ) {
        $o = get_option( 'avemaria_texts_mono', [] ); if ( ! is_array($o) ) $o = [];
        $d = avemaria_default_texts_mono();
        if ( ! isset( $d[$key] ) ) wp_send_json_error( 'key desconeguda' );
        $orig = $d[$key]['text'] ?? '';
        if ( ! isset( $o[$key] ) ) $o[$key] = [];
        if ( $lang === 'ca' ) {
            if ( $value !== $orig ) $o[$key]['ca'] = $value;
            else if ( isset( $o[$key]['ca'] ) ) unset( $o[$key]['ca'] );
        } else {
            if ( $value !== '' && $value !== $orig ) $o[$key]['es'] = $value;
            else if ( isset( $o[$key]['es'] ) ) unset( $o[$key]['es'] );
        }
        if ( empty( $o[$key] ) ) unset( $o[$key] );
        update_option( 'avemaria_texts_mono', $o );
        wp_send_json_success();
    }
    wp_send_json_error( 'tipus desconegut' );
} );

add_action( 'wp_ajax_avm_save_image', function() {
    if ( ! current_user_can( 'edit_theme_options' ) ) wp_send_json_error( 'sense permís' );
    check_ajax_referer( 'avm_save' );
    $key = sanitize_text_field( $_POST['key'] ?? '' );
    $url = esc_url_raw( $_POST['url'] ?? '' );
    if ( strpos( $key, 'img_' ) !== 0 ) wp_send_json_error( 'key invàlida' );
    $o = get_option( 'avemaria_images', [] ); if ( ! is_array($o) ) $o = [];
    if ( $url === '' ) unset( $o[$key] );
    else $o[$key] = $url;
    update_option( 'avemaria_images', $o );
    wp_send_json_success();
} );

/* ----------------------------- Modo edición en el front (iframe) ----------------------------- */

/**
 * Envuelve cada texto reemplazado en un <span data-avm-edit-txt="key" data-avm-lang="ca"> en lugar del valor plano.
 * Se activa solo cuando ?avm_editmode=1
 */
function avemaria_is_edit_mode() {
    return isset( $_GET['avm_editmode'] ) && $_GET['avm_editmode'] === '1' && current_user_can( 'edit_theme_options' );
}

function avemaria_apply_texts_editmode( $html ) {
    $lang_view = isset( $_GET['avm_lang'] ) && $_GET['avm_lang'] === 'es' ? 'es' : 'ca';
    // Bilingües
    foreach ( avemaria_get_texts() as $k => $d ) {
        $ca = $d['ca']; $es = $d['es'];
        $wrap_ca = '<span class="avm-edit avm-edit-txt" data-avm-key="' . $k . '" data-avm-lang="ca">' . $ca . '</span>';
        $wrap_es = '<span class="avm-edit avm-edit-txt" data-avm-key="' . $k . '" data-avm-lang="es">' . $es . '</span>';
        $html = str_replace( '{{' . $k . '_ca}}', $wrap_ca, $html );
        $html = str_replace( '{{' . $k . '_es}}', $wrap_es, $html );
    }
    // Monolingües: envolvemos ambos, pero mono_XXX es un solo placeholder que actualmente inserta
    // <span data-lang-ca>...</span><span data-lang-es>...</span>. En edit_mode envolvemos cada uno.
    foreach ( avemaria_get_texts_mono() as $k => $d ) {
        $orig = $d['text'] ?? '';
        $ca = $d['ca'] ?? $orig;
        $es = $d['es'] ?? $ca;
        $inner = '<span data-lang-ca><span class="avm-edit avm-edit-mono" data-avm-key="' . $k . '" data-avm-lang="ca">' . $ca . '</span></span>';
        $inner .= '<span data-lang-es><span class="avm-edit avm-edit-mono" data-avm-key="' . $k . '" data-avm-lang="es">' . $es . '</span></span>';
        $html = str_replace( '{{' . $k . '}}', $inner, $html );
    }
    return $html;
}

function avemaria_apply_images_editmode( $html ) {
    foreach ( avemaria_get_images() as $k => $url ) {
        // Marcamos con un data-avm-img en el elemento (via un span invisible pos-parent en el JS)
        // Aquí simplemente hacemos el reemplazo normal; en JS del iframe buscamos los patrones.
        // Para poder detectar cada uso: hacemos que la URL vaya con un fragmento único.
        $marked = $url . '#avm-img-' . $k;
        $html = str_replace( '{{' . $k . '}}', $marked, $html );
    }
    return $html;
}

/**
 * Inyecta CSS y JS del editor en el iframe (front) solo si edit_mode activo.
 */
add_action( 'wp_head', function() {
    if ( ! avemaria_is_edit_mode() ) return;
    ?>
    <style id="avm-edit-styles">
        html.avm-editing body { padding-top: 0 !important; }
        .avm-edit { outline: 1px dashed transparent; outline-offset: 3px; cursor: text; transition: outline-color .2s, background .2s; border-radius: 2px; }
        .avm-edit:hover { outline-color: #E8863A; background: rgba(232,134,58,.08); }
        .avm-edit[contenteditable="true"] { outline: 2px solid #2271b1; background: #fffdd8; padding: 2px 4px; }
        .avm-img-hover { position: relative; }
        .avm-img-hover::after { content: '📷 Clic per canviar imatge'; position: absolute; top: 10px; left: 10px; background: #E8863A; color: #fff; padding: 6px 10px; font-family: sans-serif; font-size: 12px; font-weight: 600; border-radius: 4px; z-index: 100; pointer-events: none; opacity: 0; transition: opacity .2s; }
        .avm-img-hover:hover::after { opacity: 1; }
        .avm-img-hover:hover { outline: 3px dashed #E8863A; outline-offset: -3px; cursor: pointer; }
        /* Ocultar el switcher CA/ES original — usamos el del panel */
        .lang-toggle { display: none !important; }
    </style>
    <?php
} );

add_action( 'wp_footer', function() {
    if ( ! avemaria_is_edit_mode() ) return;
    $lang_view = isset( $_GET['avm_lang'] ) && $_GET['avm_lang'] === 'es' ? 'es' : 'ca';
    // WP admin URL para poder usar wp.media
    $wp_admin = admin_url();
    ?>
    <script>
    (function(){
        document.documentElement.classList.add('avm-editing');
        // Forzar idioma en la vista
        document.body.classList.toggle('lang-es', <?php echo $lang_view === 'es' ? 'true' : 'false'; ?>);

        // === Textos editables inline ===
        document.querySelectorAll('.avm-edit').forEach(function(el){
            const lang = el.dataset.avmLang;
            const viewLang = '<?php echo esc_js( $lang_view ); ?>';
            // Solo mostrar la del idioma actual
            if (lang && lang !== viewLang) {
                // Ocultamos las del otro idioma en el iframe editor
                // (el CSS del theme ya oculta según lang-es/lang-ca; aquí solo permitimos edición al visible)
            }
            el.addEventListener('click', function(e){
                if (el.getAttribute('contenteditable') === 'true') return;
                e.preventDefault(); e.stopPropagation();
                el.setAttribute('contenteditable', 'true');
                el.focus();
                // Seleccionar todo
                const range = document.createRange();
                range.selectNodeContents(el);
                const sel = window.getSelection();
                sel.removeAllRanges(); sel.addRange(range);
            });
            let last = el.textContent;
            el.addEventListener('blur', function(){
                el.setAttribute('contenteditable', 'false');
                const now = el.textContent;
                if (now === last) return;
                last = now;
                parent.postMessage({avm:true, type:'save_text', key: el.dataset.avmKey, lang: el.dataset.avmLang, value: now}, '*');
            });
            el.addEventListener('keydown', function(e){
                if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); el.blur(); }
                if (e.key === 'Escape') { el.textContent = last; el.blur(); }
            });
        });

        // === Imágenes editables ===
        // Buscamos elementos con background-image que contengan #avm-img-XXX
        function findImageElements() {
            const out = new Map();
            document.querySelectorAll('*').forEach(function(el){
                const bg = el.style.backgroundImage || getComputedStyle(el).backgroundImage;
                const m = bg && bg.match(/#avm-img-(\w+)/);
                if (m && !out.has(el)) out.set(el, m[1]);
                // src
                if (el.src) {
                    const m2 = el.src.match(/#avm-img-(\w+)/);
                    if (m2 && !out.has(el)) out.set(el, m2[1]);
                }
            });
            return out;
        }
        const imgs = findImageElements();
        imgs.forEach(function(key, el){
            el.classList.add('avm-img-hover');
            el.setAttribute('data-avm-img-key', key);
            el.addEventListener('click', function(e){
                if (el.closest('.avm-edit[contenteditable="true"]')) return;
                e.preventDefault(); e.stopPropagation();
                // Delegar al padre para que abra wp.media
                parent.postMessage({avm:true, type:'pick_image', key: key}, '*');
            });
        });
    })();
    </script>
    <?php
} );


/* Ordenar Editor Visual al principio del submenú */
add_action( 'admin_menu', function() {
    global $submenu;
    if ( ! isset( $submenu['avemaria-editor'] ) ) return;
    $visual = null;
    $others = [];
    foreach ( $submenu['avemaria-editor'] as $item ) {
        if ( isset( $item[2] ) && $item[2] === 'avemaria-visual' ) $visual = $item;
        else $others[] = $item;
    }
    if ( $visual ) $submenu['avemaria-editor'] = array_merge( [ $visual ], $others );
}, 999 );

