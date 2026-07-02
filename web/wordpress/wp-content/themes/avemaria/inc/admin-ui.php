<?php
/**
 * Admin UI helpers — visual page map + "View on web" button,
 * shown above the ACF field group on each page editor.
 *
 * @package Ave_Maria
 */

defined('ABSPATH') || exit;

add_action('admin_head', function () {
    $screen = get_current_screen();
    if (!$screen || $screen->base !== 'post' || $screen->post_type !== 'page') return;

    global $post;
    if ($post && in_array((int) $post->ID, avemaria_managed_page_ids(), true)) {
        echo '<style>#postdivrich,#wp-content-editor-container,#ed_toolbar,#wp-word-count,.wp-editor-tabs,#post-body-content > .postarea{display:none !important;}</style>';
    }
    ?>
    <style>
        .avemaria-wf {
            margin: 18px 0 24px;
            background: #fff;
            border: 1px solid #c3dacb;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .avemaria-wf__header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 12px 16px;
            background: linear-gradient(135deg, #2c7 0%, #0a8040 100%);
            color: #fff;
        }
        .avemaria-wf__header-title { font-size: 14px; font-weight: 600; margin: 0; }
        .avemaria-wf__header-title small { font-weight: 400; opacity: 0.85; margin-left: 6px; }
        .avemaria-wf__view-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255,255,255,0.2);
            color: #fff !important;
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            border: 1px solid rgba(255,255,255,0.35);
            transition: background 0.15s;
        }
        .avemaria-wf__view-btn:hover { background: rgba(255,255,255,0.3); color: #fff; }
        .avemaria-wf__body { padding: 10px 12px; display: grid; gap: 6px; }
        .avemaria-wf__row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            background: #f7faf8;
            border: 1px solid #e3ece7;
            border-radius: 6px;
            font-size: 13px;
        }
        .avemaria-wf__row--fixed { background: #f0f0f0; color: #666; font-style: italic; }
        .avemaria-wf__num {
            font-weight: 700;
            color: #fff;
            background: #0a8040;
            width: 26px;
            height: 26px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 13px;
            flex-shrink: 0;
        }
        .avemaria-wf__row--fixed .avemaria-wf__num {
            background: #999;
        }
        .avemaria-wf__label { font-weight: 600; color: #222; }
        .avemaria-wf__hint  { color: #666; font-size: 12px; margin-left: auto; }
        .avemaria-preview { margin: 18px 0 24px; background: #fff; border: 1px solid #c3dacb; border-radius: 10px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .avemaria-preview__header { display: flex; align-items: center; justify-content: space-between; padding: 10px 14px; background: #f3f6f4; border-bottom: 1px solid #e3ece7; font-size: 13px; }
        .avemaria-preview__header strong { color: #0a8040; }
        .avemaria-preview__controls { display: flex; gap: 8px; }
        .avemaria-preview__btn { display: inline-flex; align-items: center; gap: 5px; padding: 6px 12px; background: #fff; border: 1px solid #c3dacb; border-radius: 6px; color: #0a8040 !important; text-decoration: none; font-size: 12px; cursor: pointer; font-family: inherit; }
        .avemaria-preview__btn:hover { background: #f0f7f3; border-color: #0a8040; }
        .avemaria-preview__frame-wrap { position: relative; height: 640px; background: #f7faf8; }
        .avemaria-preview__frame { width: 100%; height: 100%; border: 0; display: block; }
        .avemaria-preview__hint { padding: 8px 14px; background: #fff9ed; border-top: 1px solid #f2e7cf; font-size: 12px; color: #7a5900; }
    </style>
    <?php
});

function avemaria_preview_html($slug) {
    $url = home_url('/' . ltrim($slug, '/'));
    $src = add_query_arg(['_cab_preview' => time()], $url);
    ob_start();
    ?>
    <div class="avemaria-preview">
        <div class="avemaria-preview__header">
            <span>🔍 <strong>Preview en vivo</strong> — así se ve tu página ahora mismo</span>
            <div class="avemaria-preview__controls">
                <button type="button" class="avemaria-preview__btn" onclick="(function(f){f.src=f.src.split('?')[0]+'?_cab_preview='+Date.now();})(document.getElementById('avemaria-preview-frame'))">🔁 Refrescar</button>
                <a class="avemaria-preview__btn" href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener">↗ Abrir en pestaña nueva</a>
            </div>
        </div>
        <div class="avemaria-preview__frame-wrap">
            <iframe id="avemaria-preview-frame" class="avemaria-preview__frame" src="<?php echo esc_url($src); ?>" loading="lazy"></iframe>
        </div>
        <p class="avemaria-preview__hint">💡 Tras pulsar <strong>"Actualizar"</strong> (botón azul de la derecha), pulsa <strong>🔁 Refrescar</strong> aquí para ver los cambios.</p>
    </div>
    <?php
    return ob_get_clean();
}

function avemaria_wireframe_html($title, $rows, $slug) {
    $view_url = home_url('/' . ltrim($slug, '/'));
    ob_start();
    ?>
    <div class="avemaria-wf">
        <div class="avemaria-wf__header">
            <p class="avemaria-wf__header-title">🗺️ Mapa de la página <small><?php echo esc_html($title); ?> — los números coinciden con las pestañas de abajo</small></p>
            <a href="<?php echo esc_url($view_url); ?>" target="_blank" rel="noopener" class="avemaria-wf__view-btn">
                👁️ Ver página en la web
            </a>
        </div>
        <div class="avemaria-wf__body">
            <?php foreach ($rows as $row): ?>
                <div class="avemaria-wf__row<?php echo !empty($row['fixed']) ? ' avemaria-wf__row--fixed' : ''; ?>">
                    <span class="avemaria-wf__num"><?php echo esc_html($row['num'] ?? '·'); ?></span>
                    <span class="avemaria-wf__label"><?php echo esc_html($row['label']); ?></span>
                    <?php if (!empty($row['hint'])): ?>
                        <span class="avemaria-wf__hint"><?php echo esc_html($row['hint']); ?></span>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

function avemaria_managed_page_ids() {
    $ids = [4, 5, 6, 7, 8, 9, 10];
    $sid = function_exists('avemaria_settings_id') ? avemaria_settings_id() : 0;
    if ($sid) $ids[] = $sid;
    return $ids;
}

add_filter('use_block_editor_for_post', function ($use, $post) {
    if ($post && $post->post_type === 'page' && in_array((int) $post->ID, avemaria_managed_page_ids(), true)) {
        return false;
    }
    return $use;
}, 10, 2);

add_action('admin_menu', function () {
    $settings_id = function_exists('avemaria_settings_id') ? avemaria_settings_id() : 0;
    if (!$settings_id) return;

    add_menu_page(
        'Ajustes Globales',
        '⚙️ Ajustes Globales',
        'edit_pages',
        'post.php?post=' . $settings_id . '&action=edit',
        '',
        'dashicons-admin-generic',
        25
    );
}, 99);

add_action('template_redirect', function () {
    if (!is_page('ajustes-globales')) return;
    wp_safe_redirect(home_url('/'), 302);
    exit;
});

add_filter('wp_list_pages_excludes', function ($exclude) {
    $id = function_exists('avemaria_settings_id') ? avemaria_settings_id() : 0;
    if ($id) $exclude[] = $id;
    return $exclude;
});

add_filter('get_pages', function ($pages) {
    $id = function_exists('avemaria_settings_id') ? avemaria_settings_id() : 0;
    if (!$id || !is_array($pages)) return $pages;
    return array_values(array_filter($pages, function ($p) use ($id) {
        return (int) $p->ID !== $id;
    }));
});

add_action('edit_form_after_title', function ($post) {
    if ($post->post_type !== 'page') return;
    $pid = (int) $post->ID;
    $front_id = (int) get_option('page_on_front');
    $settings_id = function_exists('avemaria_settings_id') ? avemaria_settings_id() : 0;

    if ($settings_id && $pid === $settings_id) {
        echo avemaria_wireframe_html('Ajustes Globales', [
            ['num' => '1', 'label' => 'CTA final',    'hint' => 'Se ve al final de casi todas las páginas'],
            ['num' => '2', 'label' => 'Barra de logos', 'hint' => 'Aparece en la Home'],
            ['num' => '3', 'label' => 'Pie de página (footer)', 'hint' => 'Dirección, teléfono, email, horarios y copyright'],
        ], '/');
        echo avemaria_preview_html('/');
        return;
    }

    if ($pid === $front_id || $pid === 4) {
        echo avemaria_wireframe_html('Home', [
            ['num' => '1', 'label' => 'Hero',         'hint' => 'Cabecera con título y 2 botones'],
            ['num' => '·', 'label' => 'Barra de logos', 'fixed' => true, 'hint' => 'Fija (no editable aquí)'],
            ['num' => '2', 'label' => 'Nosotros',     'hint' => '3 imágenes + 2 párrafos + botón'],
            ['num' => '3', 'label' => 'Diferenciales', 'hint' => '4 tarjetas'],
            ['num' => '4', 'label' => 'Servicios',    'hint' => '3 tarjetas con imagen'],
            ['num' => '5', 'label' => 'Logística',    'hint' => 'Bloque verde con imagen'],
            ['num' => '6', 'label' => 'Proceso',      'hint' => '7 pasos'],
            ['num' => '7', 'label' => 'Clientes',     'hint' => 'Título + barra de logos'],
            ['num' => '·', 'label' => 'CTA final',    'fixed' => true, 'hint' => 'Común a todas las páginas'],
        ], '/');
        echo avemaria_preview_html('/');
        return;
    }

    $map = [
        5  => ['quienes-somos', 'Quiénes Somos', [
            ['num' => '·', 'label' => 'Hero (cabecera)',     'fixed' => true, 'hint' => 'Abajo: "Hero de Página"'],
            ['num' => '1', 'label' => 'Experiencia',         'hint' => 'Texto + imagen'],
            ['num' => '2', 'label' => 'Estructura',          'hint' => '3 párrafos'],
            ['num' => '3', 'label' => 'Equipo Directivo',    'hint' => 'Gestionado en "Miembros"'],
            ['num' => '4', 'label' => 'Nuestro Taller',      'hint' => '3 imágenes + textos'],
            ['num' => '5', 'label' => 'Más que un proveedor', 'hint' => 'Texto + imagen'],
        ]],
        6  => ['servicios', 'Servicios', [
            ['num' => '·', 'label' => 'Hero (cabecera)', 'fixed' => true, 'hint' => 'Abajo: "Hero de Página"'],
            ['num' => '1', 'label' => 'Introducción',    'hint' => '3 párrafos'],
            ['num' => '2', 'label' => 'Cabecera de pestañas', 'hint' => 'Etiqueta + título + 4 botones'],
            ['num' => '3', 'label' => 'Tab: Impresión',  'hint' => 'Banner + 4 tarjetas'],
            ['num' => '4', 'label' => 'Tab: Transfer',   'hint' => 'Banner + 4 tarjetas'],
            ['num' => '5', 'label' => 'Tab: Marcado',    'hint' => 'Banner + 4 tarjetas'],
            ['num' => '6', 'label' => 'Tab: Logística',  'hint' => 'Banner + 4 tarjetas'],
        ]],
        7  => ['soluciones', 'Soluciones', [
            ['num' => '·', 'label' => 'Hero (cabecera)',  'fixed' => true, 'hint' => 'Abajo: "Hero de Página"'],
            ['num' => '1', 'label' => 'Fila 1: Equipaciones', 'hint' => 'Imagen izq. + texto'],
            ['num' => '2', 'label' => 'Fila 2: Merchandising', 'hint' => 'Imagen der. + texto'],
            ['num' => '3', 'label' => 'Fila 3: Ropa corporativa', 'hint' => 'Imagen izq. + texto'],
            ['num' => '4', 'label' => 'Fila 4: Parches', 'hint' => 'Imagen der. + texto'],
            ['num' => '5', 'label' => 'Casos destacados', 'hint' => '3 tarjetas'],
        ]],
        8  => ['portfolio', 'Portfolio', [
            ['num' => '·', 'label' => 'Hero (cabecera)',    'fixed' => true, 'hint' => 'Abajo: "Hero de Página"'],
            ['num' => '1', 'label' => 'Filtros + grid',     'hint' => 'Proyectos se gestionan en "Proyectos"'],
            ['num' => '2', 'label' => 'Caso destacado',     'hint' => 'Bloque con detalles y cita'],
        ]],
        9  => ['procesos', 'Procesos', [
            ['num' => '·', 'label' => 'Hero (cabecera)', 'fixed' => true, 'hint' => 'Abajo: "Hero de Página"'],
            ['num' => '1', 'label' => 'Barra superior',  'hint' => '7 etiquetas'],
            ['num' => '2', 'label' => 'Paso 01 Análisis'],
            ['num' => '3', 'label' => 'Paso 02 Diseño'],
            ['num' => '4', 'label' => 'Paso 03 Solución'],
            ['num' => '5', 'label' => 'Paso 04 Materiales'],
            ['num' => '6', 'label' => 'Paso 05 Producción'],
            ['num' => '7', 'label' => 'Paso 06 Control'],
            ['num' => '8', 'label' => 'Paso 07 Logística'],
        ]],
        10 => ['contacto', 'Contacto', [
            ['num' => '·', 'label' => 'Hero (cabecera)', 'fixed' => true, 'hint' => 'Abajo: "Hero de Página"'],
            ['num' => '1', 'label' => 'Formulario',      'hint' => 'Etiqueta, título, descripción, botón'],
            ['num' => '2', 'label' => 'Datos de contacto', 'hint' => 'Dirección, teléfono, email, horario'],
            ['num' => '3', 'label' => 'Mapa y CTA final', 'hint' => 'Google Maps + bloque teléfono'],
        ]],
    ];

    if (isset($map[$pid])) {
        [$slug, $title, $rows] = $map[$pid];
        echo avemaria_wireframe_html($title, $rows, '/' . $slug . '/');
        echo avemaria_preview_html('/' . $slug . '/');
    }
});
