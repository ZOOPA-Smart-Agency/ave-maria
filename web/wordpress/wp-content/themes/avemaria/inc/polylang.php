<?php
/**
 * Polylang integration for Fundació Ave Maria theme.
 *
 * Registra los textos fijos del tema (los que viven dentro de plantillas PHP,
 * no en campos ACF) para que sean traducibles desde:
 *   WP Admin > Idiomas > Traducciones de cadenas.
 *
 * Si Polylang no está activo, este archivo no hace nada.
 *
 * @package Ave_Maria
 */

defined('ABSPATH') || exit;

add_action('init', function () {
    if (!function_exists('pll_register_string')) {
        return;
    }

    $group = 'Fundació Ave Maria — Tema';

    $strings = [
        // Header
        'header_cta'          => 'Solicitar presupuesto',
        'header_menu_aria'    => 'Menú',
        'header_lang_aria'    => 'Selector de idioma',

        // Home · STATS section
        'stats_label'         => 'Ave Maria en números',
        'stats_title'         => 'Datos que <span class="text-green">nos respaldan</span>',
        'stats_desc_1'        => 'Años de experiencia',
        'stats_desc_2'        => 'Prendas al día',
        'stats_desc_3'        => 'Marcas clientes',
        'stats_desc_4'        => 'Proyectos realizados',

        // Home · SHOWLOG (Sevilla F.C.) section
        'showlog_case_label'  => 'Caso real · Sevilla F.C.',
        'showlog_case_title'  => 'Camisetas oficiales<br><span class="text-green">360° de personalización</span>',
        'showlog_case_text'   => 'Producción de la equipación oficial del Sevilla F.C. — sublimación tintorera de alto detalle, escudos bordados, dorsales con transfer termopegable y etiquetado oficial LaLiga.',
        'showlog_feat_1_b'    => 'Sublimación.',
        'showlog_feat_1_t'    => 'Colores vivos y duraderos',
        'showlog_feat_2_b'    => 'Bordado 3D.',
        'showlog_feat_2_t'    => 'Escudo con relieve y volumen',
        'showlog_feat_3_b'    => 'Transfer premium.',
        'showlog_feat_3_t'    => 'Dorsales y números',
        'showlog_feat_4_b'    => 'Etiquetado oficial.',
        'showlog_feat_4_t'    => 'Compliance LaLiga',

        // Footer · Tour Virtual
        'footer_tour_label'   => 'Conoce nuestras instalaciones',
        'footer_tour_title'   => 'Tour Virtual <span class="text-green">360°</span>',
        'footer_tour_btn'     => 'Iniciar tour virtual',

        // Footer · Marcas del grupo
        'footer_brands_label' => 'Marcas del grupo',

        // Quiénes Somos · Stats labels
        'qs_stats_label_years'    => 'Años de experiencia',
        'qs_stats_label_garments' => 'Prendas al día',
        'qs_stats_label_space'    => 'Instalaciones',
        'qs_stats_label_brands'   => 'Marcas clientes',

        // Quiénes Somos · Hablemos
        'qs_manifest_cta'         => 'Hablemos de tu proyecto',

        // Soluciones · Section labels
        'sol_hero_label'          => 'Qué hacemos',
        'sol_hero_scroll'         => 'Scroll',
        'sol_why_label'           => 'Por qué Ave Maria',
        'sol_why_title'           => 'Integración completa de <span class="text-green">producción, calidad y entrega</span>',
        'sol_why1_title'          => 'Capacidad industrial',
        'sol_why1_text'           => 'Más de 5.000 prendas al día en producción continua con la máxima precisión y control.',
        'sol_why2_title'          => 'Calidad premium',
        'sol_why2_text'           => 'Procesos certificados y control de calidad exhaustivo en cada etapa de la cadena.',
        'sol_why3_title'          => 'Rapidez y flexibilidad',
        'sol_why3_text'           => 'Pedidos express, adaptación a picos de demanda y entregas ajustadas a tu calendario.',
        'sol_why4_title'          => 'Escala global',
        'sol_why4_text'           => 'Trabajamos con marcas y clubes en más de 20 países con logística integrada.',
        'sol_cases_label_hard'    => 'Casos reales',

        // Soluciones · Bullets (4 soluciones, 3 bullets cada una)
        'sol_r1_b1' => 'Clubes · federaciones · marcas',
        'sol_r1_b2' => 'Calidad técnica certificada',
        'sol_r1_b3' => 'Acabados resistentes al uso intensivo',
        'sol_r2_b1' => 'Líneas completas de producto',
        'sol_r2_b2' => 'Diseño alineado a tu marca',
        'sol_r2_b3' => 'Producción flexible y escalable',
        'sol_r3_b1' => 'Uniformes oficina · campo · industria',
        'sol_r3_b2' => 'Tejidos técnicos y normativa EPI',
        'sol_r3_b3' => 'Personalización con bordado y transfer',
        'sol_r4_b1' => 'Parches tejidos · bordados · transfer',
        'sol_r4_b2' => 'Combinaciones de técnicas',
        'sol_r4_b3' => 'Compliance oficial deportivo',

        // Contacto · Hero + form
        'ct_hero_label'           => 'Contacto',
        'ct_form_section_label'   => 'Escríbenos',
        'ct_form_heading_hard'    => 'Cuéntanos qué necesitas',
        'ct_form_lbl_name'        => 'Nombre',
        'ct_form_lbl_company'     => 'Empresa',
        'ct_form_lbl_email'       => 'Email',
        'ct_form_lbl_phone'       => 'Teléfono',
        'ct_form_lbl_message'     => 'Mensaje',
        'ct_form_ph_name'         => 'Tu nombre completo',
        'ct_form_ph_company'      => 'Nombre de tu empresa',
        'ct_form_ph_email'        => 'tu@email.com',
        'ct_form_ph_phone'        => '+34 600 000 000',
        'ct_form_ph_message'      => 'Cuéntanos sobre tu proyecto, volumen estimado, plazos…',
        'ct_info_title_address'   => 'Dirección',
        'ct_info_title_contact'   => 'Contacto directo',
        'ct_info_title_hours'     => 'Horario',
        'ct_info_hours_l1'        => 'Lunes a Jueves · 8:30 – 18:00',
        'ct_info_hours_l2'        => 'Viernes · 8:30 – 14:30',
        'ct_location_label'       => 'Encuéntranos',
        'ct_location_title'       => 'Carrer Pujades 77<br><span class="text-green">Barcelona</span>',
        'ct_location_text'        => 'Nuestro taller central está en el corazón del 22@ de Barcelona, a 5 min del metro Llacuna (L4).',
        'ct_location_map_title'   => 'Mapa de Fundació Ave Maria · Carrer Pujades 77, Barcelona',

        // Servicios · Marcado defaults (avemaria_field defaults)
        'srv_mar_c1_t_def' => 'Planchado técnico',
        'srv_mar_c1_x_def' => 'Capacidad de procesar hasta 5.000 prendas diarias, garantizando uniformidad en la fijación y precisión en la colocación.',
        'srv_mar_c4_t_def' => 'Escalabilidad',
        'srv_mar_c4_x_def' => 'Estructura operativa diseñada para adaptarse a picos de demanda y campañas de alto volumen, ampliando capacidad productiva.',

        // CTA Final defaults (cuando el campo ACF está vacío)
        'cta_title_def'    => 'Empecemos a construir<br>tu <span class="text-green">próximo proyecto</span>',
        'cta_text_def'     => 'Cuéntanos tu idea y te proponemos la mejor solución de personalización textil para tu marca.',
        'cta_btn2_def'     => 'Llamar ahora — 932 50 06 38',
        'logos_alt_def'    => 'Clientes Fundació Ave Maria',

        // Procesos · Hero hardcoded
        'proc_hero_label'  => 'Nuestra metodología',
        'proc_hero_word'   => 'Procesos',
        'proc_hero_sub'    => 'Siete procesos consecutivos diseñados para garantizar control total, eficiencia operativa y consistencia en cada proyecto de personalización.',

        // Procesos · Bullets (7 procesos x 3 bullets)
        'proc_1_b1'        => 'Reunión técnica con briefing',
        'proc_1_b2'        => 'Revisión de volúmenes y calendario',
        'proc_1_b3'        => 'Planificación a medida',
        'proc_2_b1'        => 'Propuestas visuales',
        'proc_2_b2'        => 'Previsualización digital',
        'proc_2_b3'        => 'Prototipos y ajustes',
        'proc_3_b1'        => 'Análisis técnico detallado',
        'proc_3_b2'        => 'Selección de maquinaria',
        'proc_3_b3'        => 'Optimización de costes',
        'proc_4_b1'        => 'Soportes certificados',
        'proc_4_b2'        => 'Colores Pantone exactos',
        'proc_4_b3'        => 'Proveedores premium',
        'proc_5_b1'        => '+5.000 prendas/día',
        'proc_5_b2'        => 'Maquinaria industrial',
        'proc_5_b3'        => 'Procesos controlados',
        'proc_6_b1'        => 'Inspección por lote',
        'proc_6_b2'        => 'Trazabilidad completa',
        'proc_6_b3'        => 'Corrección en tiempo real',
        'proc_7_b1'        => 'Almacenaje y picking',
        'proc_7_b2'        => 'Distribución global',
        'proc_7_b3'        => 'Entregas express',

        // Servicios · Pilares titles
        'srv_pilar1_title' => 'Creatividad <span class="text-green">& técnica</span>',
        'srv_pilar2_title' => '<span class="text-green">Excelencia</span> en cada prenda',
        'srv_pilar3_title' => '<span class="text-green">Innovación</span> continua',

        // Footer Services fallback menu
        'srv_menu_impresion' => 'Impresión',
        'srv_menu_transfer'  => 'Transfer y Parches',
        'srv_menu_marcado'   => 'Marcado en Prenda',
        'srv_menu_logistica' => 'Logística',

        // Soluciones · Hero defaults + cases labels
        'sol_hero_line1_def' => 'Nuestro',
        'sol_hero_green_def' => 'Ecosistema',
        'sol_hero_sub_def'   => 'Soluciones integrales de personalización textil industrial — del diseño a la distribución, en una sola casa.',
        'sol_cases_label_sol'=> 'Solución',
        'sol_cases_label_res'=> 'Resultado',

        // Portfolio · aria-label
        'pf_filters_aria'    => 'Filtros de portfolio',

        // Home · hero alt
        'home_hero_alt'      => 'Customización deportiva',

        // Soluciones · Cases hardcoded title
        'sol_cases_title_h'  => 'Proyectos que <span class="text-green">hablan por nosotros</span>',
    ];

    foreach ($strings as $name => $value) {
        pll_register_string($name, $value, $group, true);
    }
});
