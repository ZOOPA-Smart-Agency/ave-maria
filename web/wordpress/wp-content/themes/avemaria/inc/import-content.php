<?php
/**
 * Import initial content on theme activation.
 * Creates pages with correct slugs and assigns templates.
 * Creates default team members and portfolio categories.
 *
 * @package Ave_Maria
 */

// NOTE (migració Ave Maria): aquest script és herència de CAB Global
// i crea pàgines/CPTs que ja no apliquen. Es deixa al repositori com a
// referència però NO es dispara automàticament. Quan es defineixin els
// seeds propis d'Ave Maria s'activarà de nou o es substituirà.
// add_action('after_switch_theme', 'avemaria_import_initial_content');

function avemaria_import_initial_content() {
    // Prevent running twice
    if (get_option('avemaria_content_imported')) return;

    // --- Create Pages ---
    $pages = [
        [
            'title'    => 'Home',
            'slug'     => 'home',
            'template' => '',
            'content'  => '',
        ],
        [
            'title'    => 'Quiénes Somos',
            'slug'     => 'quienes-somos',
            'template' => 'page-quienes-somos.php',
            'content'  => '',
            'meta'     => [
                '_cab_hero_label'    => 'Quiénes somos',
                '_cab_hero_subtitle' => 'Más de 20 años ofreciendo soluciones industriales de customización, producción y logística para marcas, clubes e instituciones que requieren precisión, capacidad operativa y fiabilidad.',
            ],
        ],
        [
            'title'    => 'Servicios',
            'slug'     => 'servicios',
            'template' => 'page-servicios.php',
            'content'  => '',
            'meta'     => [
                '_cab_hero_label'    => 'Lo que hacemos',
                '_cab_hero_subtitle' => 'Customización integral y logística a medida para proyectos de cualquier escala. Tecnología, precisión y fiabilidad en cada paso.',
            ],
        ],
        [
            'title'    => 'Soluciones',
            'slug'     => 'soluciones',
            'template' => 'page-soluciones.php',
            'content'  => '',
            'meta'     => [
                '_cab_hero_label'    => 'Soluciones a medida',
                '_cab_hero_subtitle' => 'Desarrollamos soluciones industriales de customización textil adaptadas a cada sector, uso y volumen de producción.',
            ],
        ],
        [
            'title'    => 'Portfolio',
            'slug'     => 'portfolio',
            'template' => 'page-portfolio.php',
            'content'  => '',
            'meta'     => [
                '_cab_hero_label'    => 'Nuestros trabajos',
                '_cab_hero_subtitle' => 'Una selección representativa de proyectos de customización textil realizados para marcas, clubes, empresas y eventos.',
            ],
        ],
        [
            'title'    => 'Procesos',
            'slug'     => 'procesos',
            'template' => 'page-procesos.php',
            'content'  => '',
            'meta'     => [
                '_cab_hero_label'    => 'Nuestra metodología',
                '_cab_hero_subtitle' => 'Siete procesos consecutivos diseñados para garantizar control total, eficiencia operativa y consistencia en cada proyecto de personalización.',
            ],
        ],
        [
            'title'    => 'Contacto',
            'slug'     => 'contacto',
            'template' => 'page-contacto.php',
            'content'  => '',
            'meta'     => [
                '_cab_hero_label'    => 'Hablemos',
                '_cab_hero_subtitle' => 'Cuéntanos tu proyecto y te ayudaremos a encontrar la mejor solución de personalización textil para tu marca.',
            ],
        ],
    ];

    $home_page_id = 0;

    foreach ($pages as $page_data) {
        $existing = get_page_by_path($page_data['slug']);
        if ($existing) continue;

        $page_id = wp_insert_post([
            'post_title'   => $page_data['title'],
            'post_name'    => $page_data['slug'],
            'post_content' => $page_data['content'],
            'post_status'  => 'publish',
            'post_type'    => 'page',
        ]);

        if ($page_id && !is_wp_error($page_id)) {
            if (!empty($page_data['template'])) {
                update_post_meta($page_id, '_wp_page_template', $page_data['template']);
            }
            if (!empty($page_data['meta'])) {
                foreach ($page_data['meta'] as $key => $value) {
                    update_post_meta($page_id, $key, $value);
                }
            }
            if ($page_data['slug'] === 'home') {
                $home_page_id = $page_id;
            }
        }
    }

    // Set front page to Home
    if ($home_page_id) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $home_page_id);
    }

    // --- Create Team Members ---
    $team = [
        ['name' => 'Juan',           'init' => 'J',  'role' => 'CEO',                'order' => 1],
        ['name' => 'Aleix',          'init' => 'A',  'role' => 'COO',                'order' => 2],
        ['name' => 'Tomás Martí',    'init' => 'TM', 'role' => 'Admin y Logística',  'order' => 3],
        ['name' => 'Alfredo Berca',  'init' => 'AB', 'role' => 'Production Manager', 'order' => 4],
    ];

    foreach ($team as $member) {
        $post_id = wp_insert_post([
            'post_title'  => $member['name'],
            'post_status' => 'publish',
            'post_type'   => 'avemaria_miembro',
            'menu_order'  => $member['order'],
        ]);
        if ($post_id && !is_wp_error($post_id)) {
            update_post_meta($post_id, '_cab_iniciales', $member['init']);
            update_post_meta($post_id, '_cab_cargo', $member['role']);
        }
    }

    // --- Create Portfolio Categories ---
    $categories = ['Impresión', 'Parches', 'Marcado'];
    foreach ($categories as $cat) {
        if (!term_exists($cat, 'avemaria_cat_proyecto')) {
            wp_insert_term($cat, 'avemaria_cat_proyecto', ['slug' => sanitize_title($cat)]);
        }
    }

    // --- Create Sample Portfolio Projects ---
    $projects = [
        ['title' => 'DTF Full Color — Camiseta Running',        'cat' => 'impresion'],
        ['title' => 'Parche 3D TPU — Equipación Fútbol',        'cat' => 'parches'],
        ['title' => 'Etiquetado Integral — Colección Retail',   'cat' => 'marcado'],
        ['title' => 'Sublimación Total — Polo Corporativo',     'cat' => 'impresion'],
        ['title' => 'Parche Bordado HD — Chaqueta Premium',     'cat' => 'parches'],
        ['title' => 'Planchado Transfer — Serie Limitada',      'cat' => 'marcado'],
        ['title' => 'Transfer Antimigración — Sudadera Oscura', 'cat' => 'impresion'],
        ['title' => 'Parche Silicona 3D — Gorra Streetwear',    'cat' => 'parches'],
        ['title' => 'Control QC + Embalaje — Lote 5.000 uds',  'cat' => 'marcado'],
        ['title' => 'Vinilo Reflectante — Chaleco Seguridad',   'cat' => 'impresion'],
        ['title' => 'Parche UV Premium — Mochila Outdoor',      'cat' => 'parches'],
        ['title' => 'Marcado Láser — Equipación Basket Pro',    'cat' => 'marcado'],
    ];

    foreach ($projects as $proj) {
        $post_id = wp_insert_post([
            'post_title'  => $proj['title'],
            'post_status' => 'publish',
            'post_type'   => 'avemaria_proyecto',
        ]);
        if ($post_id && !is_wp_error($post_id)) {
            $term = get_term_by('slug', $proj['cat'], 'avemaria_cat_proyecto');
            if ($term) {
                wp_set_object_terms($post_id, $term->term_id, 'avemaria_cat_proyecto');
            }
        }
    }

    // --- Set Permalink Structure ---
    update_option('permalink_structure', '/%postname%/');

    // Mark as imported
    update_option('avemaria_content_imported', true);
    flush_rewrite_rules();
}

// Admin button to re-import if needed
add_action('admin_menu', function () {
    add_theme_page(
        __('Importar Contenido Ave Maria', 'avemaria'),
        __('Importar Contenido', 'avemaria'),
        'manage_options',
        'avemaria-import',
        function () {
            if (isset($_POST['avemaria_reimport']) && wp_verify_nonce($_POST['_wpnonce'], 'avemaria_reimport')) {
                delete_option('avemaria_content_imported');
                avemaria_import_initial_content();
                echo '<div class="notice notice-success"><p>' . __('Contenido importado correctamente.', 'avemaria') . '</p></div>';
            }
            ?>
            <div class="wrap">
                <h1><?php _e('Importar Contenido Inicial', 'avemaria'); ?></h1>
                <p><?php _e('Pulsa el botón para crear las páginas, miembros de equipo y proyectos de ejemplo.', 'avemaria'); ?></p>
                <form method="post">
                    <?php wp_nonce_field('avemaria_reimport'); ?>
                    <input type="hidden" name="avemaria_reimport" value="1">
                    <?php submit_button(__('Importar / Re-importar', 'avemaria')); ?>
                </form>
            </div>
            <?php
        }
    );
});
