<?php
/**
 * SEED · Translations EN + CA for all pages, CPTs and global settings.
 *
 * Crea la traducción inglesa y catalana de cada contenido en español,
 * copia todos los campos ACF traducidos y enlaza las versiones vía Polylang.
 *
 * Ejecutar UNA SOLA VEZ con:
 *   docker compose exec wordpress wp --allow-root eval-file \
 *     wp-content/themes/avemaria/inc/seed-translations.php
 *
 * Es idempotente: si la traducción ya existe, la actualiza en vez de duplicarla.
 *
 * @package Ave_Maria
 */

if (!function_exists('PLL') || !function_exists('pll_get_post')) {
    fwrite(STDERR, "Polylang no está activo. Aborto.\n");
    return;
}

$pll = PLL();
$model = $pll->model;

/**
 * Crea o actualiza la traducción de un post fuente.
 *
 * @param int    $source_id ID del post en español
 * @param string $lang_slug 'en' | 'ca'
 * @param array  $data      ['title','slug','content','excerpt','meta'=>[k=>v]]
 * @return int   ID del post traducido
 */
function avemaria_seed_translation(int $source_id, string $lang_slug, array $data): int {
    $pll = PLL();
    $model = $pll->model;
    $source = get_post($source_id);
    if (!$source) {
        fwrite(STDERR, "Source $source_id no existe\n");
        return 0;
    }
    $lang = $model->get_language($lang_slug);
    if (!$lang) {
        fwrite(STDERR, "Idioma $lang_slug no existe\n");
        return 0;
    }

    // ¿Ya existe la traducción?
    $tr_id = pll_get_post($source_id, $lang_slug);
    $args = [
        'post_type'      => $source->post_type,
        'post_status'    => $source->post_status === 'private' ? 'private' : 'publish',
        'post_title'     => $data['title']   ?? $source->post_title,
        'post_content'   => $data['content'] ?? $source->post_content,
        'post_excerpt'   => $data['excerpt'] ?? $source->post_excerpt,
        'post_name'      => $data['slug']    ?? '',
        'menu_order'     => $source->menu_order,
        'post_parent'    => 0,
        'comment_status' => $source->comment_status,
        'ping_status'    => $source->ping_status,
    ];
    if ($tr_id) {
        $args['ID'] = $tr_id;
        wp_update_post($args);
    } else {
        $tr_id = wp_insert_post($args);
        if (is_wp_error($tr_id) || !$tr_id) {
            fwrite(STDERR, "Error creando traducción de $source_id [$lang_slug]\n");
            return 0;
        }
        pll_set_post_language($tr_id, $lang_slug);
    }

    // Plantilla (page template)
    $tpl = get_post_meta($source_id, '_wp_page_template', true);
    if ($tpl) update_post_meta($tr_id, '_wp_page_template', $tpl);

    // Thumbnail (featured image) — compartida con la versión española
    $thumb = get_post_thumbnail_id($source_id);
    if ($thumb) set_post_thumbnail($tr_id, $thumb);

    // Vincular traducciones
    $current = pll_get_post_translations($source_id);
    $current[$lang_slug] = $tr_id;
    $current[pll_get_post_language($source_id)] = $source_id;
    pll_save_post_translations($current);

    // Meta fields traducidos (los que NO se pasen se copian del español)
    $src_meta = get_post_meta($source_id);
    $translated_keys = array_keys($data['meta'] ?? []);
    foreach ($src_meta as $k => $v) {
        if (in_array($k, ['_edit_lock','_edit_last','_pingme','_encloseme'])) continue;
        // Si la clave está traducida, salta — la pondremos luego
        if (in_array($k, $translated_keys)) continue;
        $val = is_array($v) ? $v[0] : $v;
        update_post_meta($tr_id, $k, maybe_unserialize($val));
    }
    foreach (($data['meta'] ?? []) as $k => $v) {
        update_post_meta($tr_id, $k, $v);
    }

    echo "  [$lang_slug] ".($args['ID'] ?? 'NEW')." → '".$args['post_title']."' (id $tr_id)\n";
    return (int) $tr_id;
}

/*
|--------------------------------------------------------------------------
| TRADUCCIONES
|--------------------------------------------------------------------------
*/

$T = []; // [source_id => [lang => [...data]]]

// =============================================================
// HOME (front page) — id 4
// =============================================================
$T[4]['en'] = [
    'title' => 'Home',
    'slug'  => 'home-en',
    'meta'  => [
        'home_hero_label'        => 'Industrial textile production',
        'home_hero_title_green'  => 'CUSTOMIZATION',
        'home_hero_title_line2'  => 'PROFESSIONAL AT',
        'home_hero_title_bold'   => 'LARGE SCALE',
        'home_hero_subtitle'     => 'Over 20 years transforming ideas into custom products for the most demanding brands on the market.',
        'home_hero_cta1_text'    => 'Request a quote',
        'home_hero_cta2_text'    => 'Discover services',
        'home_about_label'       => 'About us',
        'home_about_title'       => 'Integral solutions for<br><span class="text-green">textile customization</span>',
        'home_about_text1'       => 'We are a multidisciplinary team specialized in large-scale textile customization. From our workshop in Barcelona, we offer a complete service that covers everything from design and production to quality control and logistics.',
        'home_about_text2'       => 'We work with leading sports brands, clubs, institutions and companies that need a reliable partner for their customization projects.',
        'home_about_button'      => 'Meet us',
        'home_values_label'      => 'What sets us apart',
        'home_values_title'      => 'Why <span class="text-green">Fundació Ave Maria</span>?',
        'home_value1_title'      => '20+ years of experience',
        'home_value1_text'       => 'More than two decades working with leading brands in high-volume industrial textile customization.',
        'home_value2_title'      => 'Industrial capacity',
        'home_value2_text'       => 'Infrastructure to process more than 5,000 garments per day with maximum quality and precision.',
        'home_value3_title'      => 'Advanced technology',
        'home_value3_text'       => 'DTF, sublimation, UV printing, transfer, embroidery and more. Always with the most cutting-edge technology in the sector.',
        'home_value4_title'      => 'Total reliability',
        'home_value4_text'       => 'Exhaustive quality control and on-time deliveries. Your project in the best hands, always on schedule.',
        'home_services_label'    => 'What we do',
        'home_services_desc'     => 'We offer a full-service textile customization solution: from applying printing techniques to comprehensive logistics management of your project.',
        'home_services_title_green'  => 'SERVICES',
        'home_services_title_italic' => 'of application',
        'home_service1_title'    => 'Printing',
        'home_service1_sub'      => 'DTF · UV · Sublimation · Vinyl',
        'home_service2_title'    => 'Transfers & Patches',
        'home_service2_sub'      => 'Screen-printed · Embroidery · 3D UV/TPU',
        'home_service3_title'    => 'Garment Marking',
        'home_service3_sub'      => 'Pressing · Labelling · QC Control',
        'home_logistics_label'   => 'Tailored solutions',
        'home_logistics_title1'  => 'LOGISTICS',
        'home_logistics_title2'  => 'SERVICES',
        'home_logistics_text'    => 'We manage the entire logistics process of your project: storage, picking, packaging and distribution. Total scalability to adapt to any volume.',
        'home_logistics_button'  => 'Learn more',
        'home_process_label'     => 'Our methodology',
        'home_process_title'     => 'Our workflow<br><span class="text-green">in 7 steps</span>',
        'home_step1_title'       => 'Analysis',
        'home_step1_text'        => 'Needs assessment and project planning.',
        'home_step2_title'       => 'Design',
        'home_step2_text'        => 'Visual proposals aligned with your brand identity.',
        'home_step3_title'       => 'Solution',
        'home_step3_text'        => 'Choosing the optimal customization technique.',
        'home_step4_title'       => 'Materials',
        'home_step4_text'        => 'Preparation and adjustments of formats, colors and supports.',
        'home_step5_title'       => 'Production',
        'home_step5_text'        => 'Industrial execution with controlled processes.',
        'home_step6_title'       => 'QC Control',
        'home_step6_text'        => 'Systematic review before every delivery.',
        'home_step7_title'       => 'Logistics',
        'home_step7_text'        => 'Storage, picking and full distribution.',
        'home_clients_label'     => 'Trusted by leading brands',
        'home_clients_title'     => 'BRANDS THAT <span class="text-green-gradient">TRUST</span> US',
        'hero_label'             => '',
        'hero_green_word'        => '',
        'hero_subtitle'          => '',
    ],
];
$T[4]['ca'] = [
    'title' => 'Inici',
    'slug'  => 'inici',
    'meta'  => [
        'home_hero_label'        => 'Producció tèxtil industrial',
        'home_hero_title_green'  => 'PERSONALITZACIÓ',
        'home_hero_title_line2'  => 'PROFESSIONAL A',
        'home_hero_title_bold'   => 'GRAN ESCALA',
        'home_hero_subtitle'     => 'Més de 20 anys transformant idees en productes personalitzats per a les marques més exigents del mercat.',
        'home_hero_cta1_text'    => 'Sol·licitar pressupost',
        'home_hero_cta2_text'    => 'Descobrir serveis',
        'home_about_label'       => 'Qui som',
        'home_about_title'       => 'Solucions integrals de<br><span class="text-green">personalització tèxtil</span>',
        'home_about_text1'       => 'Som un equip multidisciplinari especialitzat en personalització tèxtil a gran escala. Des del nostre taller a Barcelona oferim un servei complet que va del disseny i la producció al control de qualitat i la logística.',
        'home_about_text2'       => 'Treballem amb les principals marques esportives, clubs, institucions i empreses que necessiten un soci fiable per als seus projectes de personalització.',
        'home_about_button'      => 'Coneix-nos',
        'home_values_label'      => 'Els nostres trets diferencials',
        'home_values_title'      => 'Per què <span class="text-green">Fundació Ave Maria</span>?',
        'home_value1_title'      => '+20 anys d\'experiència',
        'home_value1_text'       => 'Més de dues dècades treballant amb marques líders en personalització tèxtil industrial d\'alt volum.',
        'home_value2_title'      => 'Capacitat industrial',
        'home_value2_text'       => 'Infraestructura per processar més de 5.000 peces diàries amb la màxima qualitat i precisió.',
        'home_value3_title'      => 'Tecnologia avançada',
        'home_value3_text'       => 'DTF, sublimació, impressió UV, transfer, brodat i més. Sempre amb la tecnologia més puntera del sector.',
        'home_value4_title'      => 'Fiabilitat total',
        'home_value4_text'       => 'Control de qualitat exhaustiu i lliuraments puntuals. El teu projecte en les millors mans, sempre a temps.',
        'home_services_label'    => 'El que fem',
        'home_services_desc'     => 'Oferim un servei integral de personalització tèxtil: des de l\'aplicació de tècniques d\'impressió fins a la gestió logística completa del teu projecte.',
        'home_services_title_green'  => 'SERVEIS',
        'home_services_title_italic' => 'd\'aplicació',
        'home_service1_title'    => 'Impressió',
        'home_service1_sub'      => 'DTF · UV · Sublimació · Vinil',
        'home_service2_title'    => 'Transfers i Pegats',
        'home_service2_sub'      => 'Serigràfics · Brodat · 3D UV/TPU',
        'home_service3_title'    => 'Marcatge de Peces',
        'home_service3_sub'      => 'Planxat · Etiquetatge · Control QC',
        'home_logistics_label'   => 'Solucions a mida',
        'home_logistics_title1'  => 'SERVEIS',
        'home_logistics_title2'  => 'LOGÍSTICS',
        'home_logistics_text'    => 'Gestionem tot el procés logístic del teu projecte: emmagatzematge, picking, embalatge i distribució. Escalabilitat total per adaptar-nos a qualsevol volum.',
        'home_logistics_button'  => 'Més informació',
        'home_process_label'     => 'La nostra metodologia',
        'home_process_title'     => 'Procés de treball<br><span class="text-green">en 7 passos</span>',
        'home_step1_title'       => 'Anàlisi',
        'home_step1_text'        => 'Avaluació de necessitats i planificació del projecte.',
        'home_step2_title'       => 'Disseny',
        'home_step2_text'        => 'Propostes visuals alineades amb la teva identitat de marca.',
        'home_step3_title'       => 'Solució',
        'home_step3_text'        => 'Definició de la tècnica de personalització òptima.',
        'home_step4_title'       => 'Materials',
        'home_step4_text'        => 'Preparació i ajustos de formats, colors i suports.',
        'home_step5_title'       => 'Producció',
        'home_step5_text'        => 'Execució industrial amb processos controlats.',
        'home_step6_title'       => 'Control QC',
        'home_step6_text'        => 'Revisió sistemàtica abans de cada lliurament.',
        'home_step7_title'       => 'Logística',
        'home_step7_text'        => 'Emmagatzematge, picking i distribució completa.',
        'home_clients_label'     => 'Confiança de grans marques',
        'home_clients_title'     => 'MARQUES QUE <span class="text-green-gradient">CONFIEN</span> EN NOSALTRES',
        'hero_label'             => '',
        'hero_green_word'        => '',
        'hero_subtitle'          => '',
    ],
];

// =============================================================
// QUIÉNES SOMOS — id 5
// =============================================================
$T[5]['en'] = [
    'title' => 'About Us',
    'slug'  => 'about-us',
    'meta'  => [
        'hero_label'    => 'About us',
        'hero_subtitle' => 'Over 20 years offering industrial customization, production and logistics solutions for brands, clubs and institutions that demand precision, operational capacity and reliability.',
        'qs_exp_label'  => 'Experience and Expertise',
        'qs_exp_title'  => 'Experience and expertise<br>at the service of <span class="text-green">every project</span>',
        'qs_exp_p1'     => 'We have a solid track record in large-volume projects with high technical demands.',
        'qs_exp_p2'     => 'Our approach is not based solely on execution, but on the integral management of the entire process. We combine technical know-how, optimized processes and a clear focus on efficiency to guarantee consistent results aligned with each brand\'s requirements.',
        'qs_exp_p3'     => 'This allows us to take on complex projects with operational control, reliability and a long-term vision.',
        'qs_est_label'  => 'Structure',
        'qs_est_title'  => 'A structure prepared to <span class="text-green">grow</span> with our clients',
        'qs_est_p1'     => 'We have a multidisciplinary team made up of professionals specialized in technical design, production, handling, quality control and logistics. This structure allows us to support our clients at every stage of the project.',
        'qs_est_p2'     => 'Coordination between departments and the continuous improvement of our processes are key to delivering a scalable, flexible service aligned with industry standards.',
        'qs_est_p3'     => 'Our goal is to integrate as an operational partner within the client\'s value chain, providing stability, efficiency and the ability to adapt.',
        'qs_team_label' => 'Leadership Team',
        'qs_team_title' => 'Our <span class="text-green">team</span>',
        'qs_team_subtitle' => 'A leadership team with experience, strategic vision and deep knowledge of the industrial and textile sectors, focused on managing large-scale projects and operations.',
        'qs_taller_label' => 'Our Workshop',
        'qs_taller_title' => 'Our <span class="text-green">workshop</span>',
        'qs_taller_p1'  => 'Facilities equipped to tackle complex projects, combining order, technology and control at every step of the process.',
        'qs_taller_p2'  => 'The workshop carries out the marking of each garment, combining technology and controlled processes.',
        'qs_prov_label' => 'More Than a Supplier',
        'qs_prov_title' => 'More than a <span class="text-green">supplier</span>',
        'qs_prov_p1'    => 'We don\'t just supply customization solutions: we accompany our clients on every project, understanding their needs and offering strategic support to optimize results.',
        'qs_prov_p2'    => 'We act as a trusted ally, capable of adapting to specific requirements and responding with speed and precision to any challenge.',
        'qs_prov_sub'   => 'Driven by excellence',
        'qs_prov_p3'    => 'Quality, efficiency and control are the backbone of our work. We continuously invest in technology, processes and talent to evolve and respond to an increasingly demanding market.',
        'hero_green_word' => 'About Us',
        'qs_stats_label'=> 'Ave Maria in numbers',
        'qs_stats_title'=> 'Industrial scale, <span class="text-green">artisan</span> attention',
    ],
];
$T[5]['ca'] = [
    'title' => 'Qui Som',
    'slug'  => 'qui-som',
    'meta'  => [
        'hero_label'    => 'Qui som',
        'hero_subtitle' => 'Més de 20 anys oferint solucions industrials de personalització, producció i logística per a marques, clubs i institucions que requereixen precisió, capacitat operativa i fiabilitat.',
        'qs_exp_label'  => 'Experiència i Especialització',
        'qs_exp_title'  => 'Experiència i especialització<br>al servei de <span class="text-green">cada projecte</span>',
        'qs_exp_p1'     => 'Tenim una sòlida trajectòria en projectes de gran volum i alta exigència tècnica.',
        'qs_exp_p2'     => 'El nostre enfocament no es basa únicament en l\'execució, sinó en la gestió integral del procés. Combinem coneixement tècnic, processos optimitzats i una clara orientació a l\'eficiència per garantir resultats consistents i alineats amb els requisits de cada marca.',
        'qs_exp_p3'     => 'Això ens permet assumir projectes complexos amb control operatiu, fiabilitat i visió a llarg termini.',
        'qs_est_label'  => 'Estructura',
        'qs_est_title'  => 'Una estructura preparada per <span class="text-green">créixer</span> amb els nostres clients',
        'qs_est_p1'     => 'Comptem amb un equip multidisciplinari format per professionals especialitzats en disseny tècnic, producció, manipulació, control de qualitat i logística. Aquesta estructura ens permet acompanyar els nostres clients en totes les fases del projecte.',
        'qs_est_p2'     => 'La coordinació entre departaments i la millora contínua dels nostres processos són claus per oferir un servei escalable, flexible i alineat amb els estàndards de l\'entorn.',
        'qs_est_p3'     => 'El nostre objectiu és integrar-nos com a soci operatiu dins la cadena de valor del client, aportant estabilitat, eficiència i capacitat d\'adaptació.',
        'qs_team_label' => 'Equip Directiu',
        'qs_team_title' => 'El nostre <span class="text-green">equip</span>',
        'qs_team_subtitle' => 'Un equip directiu amb experiència, visió estratègica i coneixement profund del sector industrial i tèxtil, orientat a la gestió de projectes i operacions a gran escala.',
        'qs_taller_label' => 'El Nostre Taller',
        'qs_taller_title' => 'El nostre <span class="text-green">taller</span>',
        'qs_taller_p1'  => 'Instal·lacions equipades per afrontar projectes complexos, combinant ordre, tecnologia i control a cada pas del procés.',
        'qs_taller_p2'  => 'El taller executa el marcatge de cada peça, combinant tecnologia i processos controlats.',
        'qs_prov_label' => 'Més que un Proveïdor',
        'qs_prov_title' => 'Més que un <span class="text-green">proveïdor</span>',
        'qs_prov_p1'    => 'No només subministrem solucions de personalització: acompanyem els nostres clients en cada projecte, entenent les seves necessitats i oferint suport estratègic per optimitzar resultats.',
        'qs_prov_p2'    => 'Actuem com un aliat de confiança, capaç d\'adaptar-se a requisits específics i de respondre amb rapidesa i precisió davant qualsevol repte.',
        'qs_prov_sub'   => 'Orientats a l\'excel·lència',
        'qs_prov_p3'    => 'La qualitat, l\'eficiència i el control són l\'eix de la nostra feina. Apostem contínuament per tecnologia, processos i talent per evolucionar i respondre a un mercat cada cop més exigent.',
        'hero_green_word' => 'Qui Som',
        'qs_stats_label'=> 'Ave Maria en xifres',
        'qs_stats_title'=> 'Escala industrial, atenció <span class="text-green">artesanal</span>',
    ],
];

// =============================================================
// SERVICIOS — id 6
// =============================================================
$T[6]['en'] = [
    'title' => 'Services',
    'slug'  => 'services',
    'meta'  => [
        'hero_label'    => 'What we do',
        'hero_subtitle' => 'Integral customization and tailored logistics for projects of any scale. Technology, precision and reliability at every step.',
        'srv_intro_p1'  => 'We drive every project with creativity and technical capacity, offering a portfolio of services that turns any idea into unique, high-quality garments.',
        'srv_intro_p2'  => 'Our commitment to excellence ensures that each garment receives the attention it needs, delivering reliable results.',
        'srv_intro_p3'  => 'Innovation is part of our day-to-day: we explore new techniques, we incorporate state-of-the-art machinery and we execute logistics with efficiency in mind, ensuring that every project is delivered without room for error.',
        'srv_tabs_label' => 'Our services',
        'srv_tabs_title' => 'Integral <span class="text-green">customization</span> solutions',
        'srv_tab1_btn'  => 'Printing',
        'srv_tab2_btn'  => 'Transfers & Patches',
        'srv_tab3_btn'  => 'Garment Marking',
        'srv_tab4_btn'  => 'Logistics',
        'srv_imp_intro' => 'Industrial printing solutions adapted to different materials and applications, guaranteeing quality and durability.',
        'srv_imp_c1_t'  => 'DTF',
        'srv_imp_c1_x'  => 'We work with DTF printing for custom runs with resistant, flexible and high-fidelity finishes.',
        'srv_imp_c2_t'  => 'UV Printing',
        'srv_imp_c2_x'  => 'Precise finishes on rigid or flexible surfaces and 3D reliefs for maximum visual impact.',
        'srv_imp_c3_t'  => 'Sublimation',
        'srv_imp_c3_x'  => 'Permanent design on fabric, with the freedom of vibrant colors and detail, with no added feel.',
        'srv_imp_c4_t'  => 'Textile Vinyl',
        'srv_imp_c4_x'  => 'Versatile, durable and precise — perfect for logos, numbers or designs with a professional relief.',
        'srv_tra_intro' => 'Transfer and patch solutions for all kinds of garments and high-quality finishes.',
        'srv_tra_c1_t'  => 'Screen-printed transfers',
        'srv_tra_c1_x'  => 'Professional finish, resistant to use and washing, with anti-migration properties.',
        'srv_tra_c2_t'  => 'Embroidery',
        'srv_tra_c2_x'  => 'Application for corporate and sports garments, which can be done directly on the garment or via patches.',
        'srv_tra_c3_t'  => '3D UV/TPU Crests',
        'srv_tra_c3_x'  => 'Technology that creates volume and defined textures, with sharp reliefs and a strong visual finish.',
        'srv_tra_c4_t'  => 'Hybrid Patches',
        'srv_tra_c4_x'  => 'Custom-developed patches, designed to fit each brand, combining different materials and finishes in a single element.',
        'srv_mar_intro' => 'Industrial-scale garment marking and handling services with exhaustive control.',
        'srv_mar_c1_t'  => 'Technical pressing',
        'srv_mar_c1_x'  => 'Our current capacity allows us to process up to 5,000 garments daily, guaranteeing uniform fixation, precise placement and a stable finish throughout the production.',
        'srv_mar_c2_t'  => 'Labelling',
        'srv_mar_c2_x'  => 'Integration of technical and brand labels according to the client\'s specifications. The process is prepared to handle thousands of units per day, ensuring correct product identification.',
        'srv_mar_c3_t'  => 'Bagging',
        'srv_mar_c3_x'  => 'We bag and organize large volumes of product, keeping order, cleanliness and protection throughout the handling phase.',
        'srv_mar_c4_t'  => 'Quality control',
        'srv_mar_c4_x'  => 'Constant supervision during the production process and a final review before shipping. Every batch is verified to ensure all garments meet finish and presentation standards.',
        'srv_log_intro' => 'Storage and integral logistics management services for projects of any volume.',
        'srv_log_c1_t'  => 'Storage',
        'srv_log_c1_x'  => 'Organized stock management in facilities prepared for handling. Our infrastructure allows storing a large volume of garments while maintaining traceability and control of each reference.',
        'srv_log_c2_t'  => 'Picking',
        'srv_log_c2_x'  => 'Order preparation adapted to different distribution channels: retail, events or direct distribution.',
        'srv_log_c3_t'  => 'Shipping management',
        'srv_log_c3_x'  => 'Logistics coordination for national and international shipments, ensuring that every order leaves correctly prepared, identified and scheduled for delivery.',
        'srv_log_c4_t'  => 'Scalability',
        'srv_log_c4_x'  => 'Our operational structure is designed to adapt to demand peaks and high-volume campaigns, expanding production and logistics capacity when the project requires it.',
        'hero_green_word' => 'Services',
        // Stats
        'srv_stat1_num' => '8',
        'srv_stat1_desc' => 'Available techniques',
        'srv_stat2_num' => '5000',
        'srv_stat2_desc' => 'Garments per day',
        'srv_stat3_num' => '20',
        'srv_stat3_desc' => 'Years of experience',
        // Pilares
        'srv_pilar1_text' => 'Technical capacity and creativity to turn any idea into unique, high-quality garments.',
        'srv_pilar2_text' => 'Commitment to excellence and attention to detail in every garment, delivering reliable results project after project.',
        'srv_pilar3_text' => 'New techniques, state-of-the-art machinery and efficient logistics ensure error-free delivery.',
    ],
];
$T[6]['ca'] = [
    'title' => 'Serveis',
    'slug'  => 'serveis',
    'meta'  => [
        'hero_label'    => 'El que fem',
        'hero_subtitle' => 'Personalització integral i logística a mida per a projectes de qualsevol escala. Tecnologia, precisió i fiabilitat a cada pas.',
        'srv_intro_p1'  => 'Impulsem cada projecte amb creativitat i capacitat tècnica, oferint una cartera de serveis que permet transformar qualsevol idea en peces úniques d\'alta qualitat.',
        'srv_intro_p2'  => 'El nostre compromís amb l\'excel·lència garanteix que cada peça rebi l\'atenció necessària, lliurant resultats fiables.',
        'srv_intro_p3'  => 'La innovació forma part del nostre dia a dia: explorem noves tècniques, incorporem maquinària d\'última generació i executem la logística amb criteris d\'eficiència, assegurant que cada projecte es lliuri sense marge d\'error.',
        'srv_tabs_label' => 'Els nostres serveis',
        'srv_tabs_title' => 'Solucions de <span class="text-green">personalització</span> integral',
        'srv_tab1_btn'  => 'Impressió',
        'srv_tab2_btn'  => 'Transfers i Pegats',
        'srv_tab3_btn'  => 'Marcatge de Peces',
        'srv_tab4_btn'  => 'Logística',
        'srv_imp_intro' => 'Solucions d\'impressió industrial adaptades a diferents materials i aplicacions, garantint qualitat i durabilitat.',
        'srv_imp_c1_t'  => 'DTF',
        'srv_imp_c1_x'  => 'Treballem amb impressió DTF per a produccions personalitzades amb acabats resistents, flexibles i d\'alta fidelitat.',
        'srv_imp_c2_t'  => 'Impressió UV',
        'srv_imp_c2_x'  => 'Acabats precisos sobre superfícies rígides o flexibles i relleus 3D per a màxim impacte visual.',
        'srv_imp_c3_t'  => 'Sublimació',
        'srv_imp_c3_x'  => 'Disseny permanent al teixit, amb llibertat de colors vibrants i detall, sense tacte addicional.',
        'srv_imp_c4_t'  => 'Vinil Tèxtil',
        'srv_imp_c4_x'  => 'Versàtil, resistent i precís, perfecte per a logos, números o dissenys amb relleu professional.',
        'srv_tra_intro' => 'Solucions de transfer i pegats per a tota mena de peces i acabats d\'alta qualitat.',
        'srv_tra_c1_t'  => 'Transfers serigràfics',
        'srv_tra_c1_x'  => 'Acabat professional, resistent a l\'ús i al rentat, amb propietats antimigració.',
        'srv_tra_c2_t'  => 'Brodat',
        'srv_tra_c2_x'  => 'Aplicació per a peces corporatives i esportives, que es pot fer directament sobre la peça o mitjançant pegats.',
        'srv_tra_c3_t'  => 'Escuts 3D UV/TPU',
        'srv_tra_c3_x'  => 'Tecnologia que genera volum i textures definides, creant relleus precisos amb un acabat visual potent.',
        'srv_tra_c4_t'  => 'Pegats híbrids',
        'srv_tra_c4_x'  => 'Pegats desenvolupats a mida, dissenyats per ajustar-se a cada marca, integrant diferents materials i acabats en un sol element.',
        'srv_mar_intro' => 'Serveis de marcatge i manipulació de peces a escala industrial amb control exhaustiu.',
        'srv_mar_c1_t'  => 'Planxat tècnic',
        'srv_mar_c1_x'  => 'La nostra capacitat actual permet processar fins a 5.000 peces diàries, garantint uniformitat en la fixació, precisió en la col·locació i estabilitat de l\'acabat en tota la producció.',
        'srv_mar_c2_t'  => 'Etiquetatge',
        'srv_mar_c2_x'  => 'Integració d\'etiquetes tècniques i de marca segons les especificacions del client. El procés està preparat per gestionar milers d\'unitats per jornada, assegurant la correcta identificació del producte.',
        'srv_mar_c3_t'  => 'Embossat',
        'srv_mar_c3_x'  => 'Embossem i organitzem grans volums de producte, mantenint ordre, neteja i protecció durant tota la fase de manipulació.',
        'srv_mar_c4_t'  => 'Control de qualitat',
        'srv_mar_c4_x'  => 'Supervisió constant durant el procés productiu i revisió final abans de l\'enviament. Cada lot és verificat per assegurar que totes les peces compleixen els estàndards d\'acabat i presentació.',
        'srv_log_intro' => 'Serveis d\'emmagatzematge i gestió logística integral per a projectes de qualsevol volum.',
        'srv_log_c1_t'  => 'Emmagatzematge',
        'srv_log_c1_x'  => 'Gestió organitzada de l\'estoc en instal·lacions preparades per a la manipulació. La nostra infraestructura permet emmagatzemar un gran volum de peces, mantenint traçabilitat i control de cada referència.',
        'srv_log_c2_t'  => 'Picking',
        'srv_log_c2_x'  => 'Preparació de comandes adaptada a diferents canals de distribució: retail, esdeveniments o distribució directa.',
        'srv_log_c3_t'  => 'Gestió d\'enviaments',
        'srv_log_c3_x'  => 'Coordinació logística per a enviaments nacionals i internacionals, assegurant que cada comanda surti correctament preparada, identificada i programada per al lliurament.',
        'srv_log_c4_t'  => 'Escalabilitat',
        'srv_log_c4_x'  => 'La nostra estructura operativa està dissenyada per adaptar-se a pics de demanda i campanyes d\'alt volum, ampliant capacitat productiva i logística quan el projecte ho requereix.',
        'hero_green_word' => 'Serveis',
        // Stats
        'srv_stat1_num' => '8',
        'srv_stat1_desc' => 'Tècniques disponibles',
        'srv_stat2_num' => '5000',
        'srv_stat2_desc' => 'Peces al dia',
        'srv_stat3_num' => '20',
        'srv_stat3_desc' => 'Anys d\'experiència',
        // Pilares
        'srv_pilar1_text' => 'Capacitat tècnica i creativitat per transformar qualsevol idea en peces úniques d\'alta qualitat.',
        'srv_pilar2_text' => 'Compromís amb l\'excel·lència i atenció al detall en cada peça, lliurant resultats fiables projecte rere projecte.',
        'srv_pilar3_text' => 'Noves tècniques, maquinària d\'última generació i logística eficient asseguren lliuraments sense marge d\'error.',
    ],
];

// =============================================================
// SOLUCIONES — id 7
// =============================================================
$T[7]['en'] = [
    'title' => 'Solutions',
    'slug'  => 'solutions',
    'meta'  => [
        'hero_label'    => 'Tailored solutions',
        'hero_subtitle' => 'We develop industrial textile customization solutions adapted to each sector, use case and production volume.',
        'sol_r1_label'  => 'Sportswear Kits',
        'sol_r1_title'  => '<span class="text-green">Custom</span> sports kits',
        'sol_r1_p1'     => 'We customize kits for clubs, federations and sports brands, combining technical quality and lasting finishes.',
        'sol_r1_p2'     => 'We handle everything from the design applied to the garment to production and delivery, adapting to tight schedules and large volumes.',
        'sol_r1_p3'     => 'Our workshop integrates different marking techniques so that each set reflects the team\'s identity with precision and consistency.',
        'sol_r1_btn'    => 'Contact us',
        'sol_r2_label'  => 'Merchandising',
        'sol_r2_title'  => 'Merchandising for <span class="text-green">brands and entities</span>',
        'sol_r2_p1'     => 'We develop textile merchandising lines aligned with corporate or campaign image, with proposals that connect with the target audience.',
        'sol_r2_p2'     => 'We select supports, finishes and customization techniques according to the intended use: events, retail, promotions or B2B distribution.',
        'sol_r2_p3'     => 'We coordinate production and timelines so each delivery meets quality and traceability expectations across the chain.',
        'sol_r2_btn'    => 'Contact us',
        'sol_r3_label'  => 'Corporate Apparel',
        'sol_r3_title'  => 'Corporate apparel and <span class="text-green">workwear</span>',
        'sol_r3_p1'     => 'Uniformity and comfort for teams in offices, the field or industry, with garments designed for daily use and brand image.',
        'sol_r3_p2'     => 'We work with corporate catalogues, sizing and restocks with stable processes that make long-term management easier.',
        'sol_r3_p3'     => 'Marking is applied with resistance and legibility in mind, paying attention to detail on chest, back or sleeves according to the brand guidelines.',
        'sol_r3_btn'    => 'Contact us',
        'sol_r4_label'  => 'Patches & Applications',
        'sol_r4_title'  => 'Patches and <span class="text-green">special applications</span>',
        'sol_r4_p1'     => 'Woven, embroidered, transfer patches and technical combinations for garments, accessories or promotional items.',
        'sol_r4_p2'     => 'We advise on materials, fixation and wash resistance so that the application is reliable under real-world conditions.',
        'sol_r4_p3'     => 'We integrate applications into production flows with quality control and repeatability between batches.',
        'sol_r4_btn'    => 'Contact us',
        'sol_cases_label' => 'Case studies',
        'sol_cases_title' => 'Projects that <span class="text-green">speak for us</span>',
        'sol_case1_title' => 'Sports Kits',
        'sol_case1_sol' => 'Integral customization of kits for competition and training, with combined techniques and batch control.',
        'sol_case1_res' => 'Coordinated delivery, consistent finishes and reinforcement of the club\'s image every matchday.',
        'sol_case2_title' => 'Brand Merchandising',
        'sol_case2_sol' => 'Textile product capsules for campaigns and points of sale, with consistent branding.',
        'sol_case2_res' => 'Greater brand visibility and rotation aligned with the commercial calendar.',
        'sol_case3_title' => 'Corporate Apparel',
        'sol_case3_sol' => 'Uniformity programme with restocks and scaling by team and location.',
        'sol_case3_res' => 'Unified image, predictable processes and less operational friction for HR and procurement.',
    ],
];
$T[7]['ca'] = [
    'title' => 'Solucions',
    'slug'  => 'solucions',
    'meta'  => [
        'hero_label'    => 'Solucions a mida',
        'hero_subtitle' => 'Desenvolupem solucions industrials de personalització tèxtil adaptades a cada sector, ús i volum de producció.',
        'sol_r1_label'  => 'Equipaments Esportius',
        'sol_r1_title'  => 'Equipaments esportius <span class="text-green">personalitzats</span>',
        'sol_r1_p1'     => 'Personalitzem equipaments per a clubs, federacions i marques esportives, combinant qualitat tècnica i acabats duradors.',
        'sol_r1_p2'     => 'Gestionem des del disseny aplicat a la peça fins a la producció i el lliurament, adaptant-nos a calendaris i volums exigents.',
        'sol_r1_p3'     => 'El nostre taller integra diferents tècniques de marcatge perquè cada conjunt reflecteixi la identitat de l\'equip amb precisió i consistència.',
        'sol_r1_btn'    => 'Contactar',
        'sol_r2_label'  => 'Marxandatge',
        'sol_r2_title'  => 'Marxandatge per a <span class="text-green">marques i entitats</span>',
        'sol_r2_p1'     => 'Desenvolupem línies de marxandatge tèxtil alineades amb la imatge corporativa o de campanya, amb propostes que connecten amb el públic objectiu.',
        'sol_r2_p2'     => 'Seleccionem suports, acabats i tècniques de personalització segons l\'ús previst: esdeveniments, retail, promocions o distribució B2B.',
        'sol_r2_p3'     => 'Coordinem producció i terminis perquè cada lliurament compleixi expectatives de qualitat i traçabilitat en cadena.',
        'sol_r2_btn'    => 'Contactar',
        'sol_r3_label'  => 'Roba Corporativa',
        'sol_r3_title'  => 'Roba corporativa i <span class="text-green">vestuari laboral</span>',
        'sol_r3_p1'     => 'Uniformitat i confort per a equips a oficina, camp o indústria, amb peces pensades per a l\'ús diari i la imatge de marca.',
        'sol_r3_p2'     => 'Treballem catàlegs corporatius, tallatges i reposicions amb processos estables que faciliten la gestió a llarg termini.',
        'sol_r3_p3'     => 'El marcatge s\'aplica amb criteris de resistència i llegibilitat, cuidant cada detall a pit, esquena o mànigues segons el manual de marca.',
        'sol_r3_btn'    => 'Contactar',
        'sol_r4_label'  => 'Pegats i Aplicacions',
        'sol_r4_title'  => 'Pegats i <span class="text-green">aplicacions especials</span>',
        'sol_r4_p1'     => 'Pegats teixits, brodats, transfer i combinacions tècniques per a peces, complements o articles promocionals.',
        'sol_r4_p2'     => 'Assessorem en materials, fixació i resistència al rentat perquè l\'aplicació sigui fiable en condicions reals d\'ús.',
        'sol_r4_p3'     => 'Integrem aplicacions en fluxos de producció amb control de qualitat i repetibilitat entre lots.',
        'sol_r4_btn'    => 'Contactar',
        'sol_cases_label' => 'Casos',
        'sol_cases_title' => 'Projectes que <span class="text-green">parlen per nosaltres</span>',
        'sol_case1_title' => 'Equipaments Esportius',
        'sol_case1_sol' => 'Personalització integral d\'equipaments per a competició i entrenament, amb tècniques combinades i control de lots.',
        'sol_case1_res' => 'Lliurament coordinat, acabats homogenis i reforç d\'imatge de club a cada jornada.',
        'sol_case2_title' => 'Marxandatge per a Marques',
        'sol_case2_sol' => 'Càpsules de producte tèxtil per a campanyes i punts de venda, amb un branding consistent.',
        'sol_case2_res' => 'Major visibilitat de marca i rotació alineada amb el calendari comercial.',
        'sol_case3_title' => 'Roba Corporativa',
        'sol_case3_sol' => 'Programa d\'uniformitat amb reposicions i escalat per equips i ubicacions.',
        'sol_case3_res' => 'Imatge unificada, processos previsibles i menys fricció operativa per a RH i compres.',
    ],
];

// =============================================================
// PORTFOLIO — id 8
// =============================================================
$T[8]['en'] = [
    'title' => 'Portfolio',
    'slug'  => 'portfolio-en',
    'meta'  => [
        'hero_label'    => 'Our work',
        'hero_subtitle' => 'A representative selection of textile customization projects carried out for brands, clubs, companies and events.',
        'pf_filters_label' => 'Browse by category',
        'pf_filters_title' => 'Pick a category to <span class="text-green">filter</span> the work',
        'pf_pill_all'   => 'All',
        'pf_pill_imp'   => 'Printing',
        'pf_pill_par'   => 'Patches',
        'pf_pill_mar'   => 'Marking',
        'pf_case_label' => 'Featured case',
        'pf_case_title' => 'From idea to <span class="text-green">finished garment</span>',
        'pf_case_cli_label' => 'Client',
        'pf_case_cli_text'  => 'European sports brand',
        'pf_case_obj_label' => 'Objective',
        'pf_case_obj_text'  => 'Unify color and resistance criteria across competition kits.',
        'pf_case_sol_label' => 'Solution',
        'pf_case_sol_text'  => 'Combination of marking techniques and batch control in the workshop.',
        'pf_case_tec_label' => 'Techniques',
        'pf_case_tec_text'  => 'Digital printing, transfers and special finishes.',
        'pf_case_res_label' => 'Result',
        'pf_case_res_text'  => 'On-time deliveries and consistent finishes throughout the season.',
        'pf_case_quote' => '«The coordination with production gave us peace of mind in a very tight schedule.»',
        'pf_case_badge' => 'Success case',
        'hero_green_word' => 'Portfolio',
    ],
];
$T[8]['ca'] = [
    'title' => 'Portfoli',
    'slug'  => 'portfoli',
    'meta'  => [
        'hero_label'    => 'Els nostres treballs',
        'hero_subtitle' => 'Una selecció representativa de projectes de personalització tèxtil realitzats per a marques, clubs, empreses i esdeveniments.',
        'pf_filters_label' => 'Explora per categoria',
        'pf_filters_title' => 'Selecciona una categoria per <span class="text-green">filtrar</span> el treball',
        'pf_pill_all'   => 'Tots',
        'pf_pill_imp'   => 'Impressió',
        'pf_pill_par'   => 'Pegats',
        'pf_pill_mar'   => 'Marcatge',
        'pf_case_label' => 'Cas destacat',
        'pf_case_title' => 'De la idea a la <span class="text-green">peça acabada</span>',
        'pf_case_cli_label' => 'Client',
        'pf_case_cli_text'  => 'Marca esportiva europea',
        'pf_case_obj_label' => 'Objectiu',
        'pf_case_obj_text'  => 'Unificar criteris de color i resistència en equipaments de competició.',
        'pf_case_sol_label' => 'Solució',
        'pf_case_sol_text'  => 'Combinació de tècniques de marcatge i control per lots al taller.',
        'pf_case_tec_label' => 'Tècniques',
        'pf_case_tec_text'  => 'Impressió digital, transfer i acabats especials.',
        'pf_case_res_label' => 'Resultat',
        'pf_case_res_text'  => 'Lliuraments puntuals i acabats homogenis durant tota la temporada.',
        'pf_case_quote' => '«La coordinació amb producció ens va donar tranquil·litat en un calendari molt ajustat.»',
        'pf_case_badge' => 'Cas d\'èxit',
        'hero_green_word' => 'Portfoli',
    ],
];

// =============================================================
// PROCESOS — id 9
// =============================================================
$T[9]['en'] = [
    'title' => 'Processes',
    'slug'  => 'processes',
    'meta'  => [
        'hero_label'    => 'Our methodology',
        'hero_subtitle' => 'Seven consecutive processes designed to guarantee total control, operational efficiency and consistency in every customization project.',
        'proc_bar_1'    => 'Analysis',
        'proc_bar_2'    => 'Design',
        'proc_bar_3'    => 'Solution',
        'proc_bar_4'    => 'Materials',
        'proc_bar_5'    => 'Production',
        'proc_bar_6'    => 'Control',
        'proc_bar_7'    => 'Logistics',
        'proc_1_label'  => 'Process 1',
        'proc_1_title'  => 'Project Analysis',
        'proc_1_p1'     => 'The process starts with an exhaustive analysis of the client\'s needs and the project\'s operational requirements. In this phase we assess key aspects such as product type, end use, target audience, production volumes, delivery deadlines and logistics needs.',
        'proc_1_p2'     => 'This analysis lets us identify technical constraints, define priorities and establish realistic planning aligned with the client\'s standards and goals. It is the foundation on which the entire project is built.',
        'proc_2_label'  => 'Process 2',
        'proc_2_title'  => 'Design',
        'proc_2_p1'     => 'The design is developed from the information gathered in the analysis phase. The team works on visual proposals aligned with the client\'s brand identity, taking into account aesthetic, functional and technical criteria.',
        'proc_2_p2'     => 'We study design positioning on the garment or support, legibility, color adaptation and compatibility with the planned customization systems, ensuring the final design is viable, reproducible and consistent at industrial scale.',
        'proc_3_label'  => 'Process 3',
        'proc_3_title'  => 'Solution Definition',
        'proc_3_p1'     => 'Once the design is validated, the most suitable solution for its application is defined. This process involves selecting the customization technique based on the fabric or surface, the intended use of the product, and durability, resistance and maintenance requirements.',
        'proc_3_p2'     => 'In this phase we determine processes such as sublimation, Direct to Film (DTF), anti-migration transfers, heat-applied patches, embroidery or direct UV printing, ensuring a technically optimal and consistent result in volume production.',
        'proc_4_label'  => 'Process 4',
        'proc_4_title'  => 'Material Preparation',
        'proc_4_p1'     => 'Material preparation is a key phase to guarantee the efficiency and stability of the production process. At this point we adjust formats, colors and supports, and we run prior technical tests to verify the compatibility between materials and customization techniques.',
        'proc_4_p2'     => 'This step lets us anticipate possible incidents, reduce errors in production and ensure all elements are correctly prepared before starting manufacturing.',
        'proc_5_label'  => 'Process 5',
        'proc_5_title'  => 'Production & Customization',
        'proc_5_p1'     => 'Production is carried out using state-of-the-art machinery and highly controlled industrial processes. During this phase the customization techniques previously defined are applied, guaranteeing precision, uniformity and repeatability in every unit produced.',
        'proc_5_p2'     => 'The experience of the technical team, together with process control, allows us to maintain high quality standards both in one-off productions and in large volumes and recurring series.',
        'proc_6_label'  => 'Process 6',
        'proc_6_title'  => 'Quality Control',
        'proc_6_p1'     => 'Before delivery, every product goes through a rigorous and systematic quality control. We check aspects such as fidelity to the approved design, quality of finishes, resistance of the customization and correct application of the techniques used.',
        'proc_6_p2'     => 'This process ensures that the final product meets the defined standards and client expectations, minimizing incidents and ensuring consistency in every delivery.',
        'proc_7_label'  => 'Process 7',
        'proc_7_title'  => 'Logistics & Delivery',
        'proc_7_p1'     => 'The last process is logistics management and product delivery. Fundació Ave Maria offers storage services, inventory management and order preparation (picking), adapting to the specific needs of each project and distribution channel.',
        'proc_7_p2'     => 'Logistics is planned in a coordinated way to guarantee on-time, traceable deliveries in optimal conditions, closing the process efficiently and under control.',
    ],
];
$T[9]['ca'] = [
    'title' => 'Processos',
    'slug'  => 'processos',
    'meta'  => [
        'hero_label'    => 'La nostra metodologia',
        'hero_subtitle' => 'Set processos consecutius dissenyats per garantir control total, eficiència operativa i consistència en cada projecte de personalització.',
        'proc_bar_1'    => 'Anàlisi',
        'proc_bar_2'    => 'Disseny',
        'proc_bar_3'    => 'Solució',
        'proc_bar_4'    => 'Materials',
        'proc_bar_5'    => 'Producció',
        'proc_bar_6'    => 'Control',
        'proc_bar_7'    => 'Logística',
        'proc_1_label'  => 'Procés 1',
        'proc_1_title'  => 'Anàlisi del Projecte',
        'proc_1_p1'     => 'El procés s\'inicia amb una anàlisi exhaustiva de les necessitats del client i dels requisits operatius del projecte. En aquesta fase s\'avaluen aspectes clau com el tipus de producte, l\'ús final, el públic objectiu, els volums de producció, els terminis de lliurament i les necessitats logístiques.',
        'proc_1_p2'     => 'Aquesta anàlisi permet identificar condicionants tècnics, definir prioritats i establir una planificació realista, alineada amb els estàndards i objectius del client. És la base sobre la qual es construeix tot el desenvolupament posterior del projecte.',
        'proc_2_label'  => 'Procés 2',
        'proc_2_title'  => 'Disseny',
        'proc_2_p1'     => 'El disseny es desenvolupa a partir de la informació obtinguda en la fase d\'anàlisi. L\'equip treballa en propostes visuals alineades amb la identitat de marca del client, tenint en compte criteris estètics, funcionals i tècnics.',
        'proc_2_p2'     => 'S\'estudia el posicionament del disseny a la peça o suport, la llegibilitat, l\'adaptació cromàtica i la compatibilitat amb els sistemes de personalització previstos, garantint que el disseny final sigui viable, reproduïble i coherent a escala industrial.',
        'proc_3_label'  => 'Procés 3',
        'proc_3_title'  => 'Definició de la Solució',
        'proc_3_p1'     => 'Un cop validat el disseny, es defineix la solució més adequada per a la seva aplicació. Aquest procés implica seleccionar la tècnica de personalització en funció del teixit o superfície, l\'ús previst del producte i els requisits de durabilitat, resistència i manteniment.',
        'proc_3_p2'     => 'En aquesta fase es determinen processos com la sublimació, el Direct to Film (DTF), el transfer antimigració, els pegats termoadhesius, el brodat o la impressió directa UV, assegurant un resultat tècnicament òptim i consistent en produccions de volum.',
        'proc_4_label'  => 'Procés 4',
        'proc_4_title'  => 'Preparació de Materials',
        'proc_4_p1'     => 'La preparació de materials és una fase clau per garantir l\'eficiència i l\'estabilitat del procés productiu. En aquest punt s\'ajusten formats, colors i suports, i es fan proves tècniques prèvies per verificar la compatibilitat entre materials i tècniques de personalització.',
        'proc_4_p2'     => 'Aquest pas permet anticipar possibles incidències, reduir errors en producció i assegurar que tots els elements estiguin correctament preparats abans d\'iniciar la fabricació.',
        'proc_5_label'  => 'Procés 5',
        'proc_5_title'  => 'Producció i Personalització',
        'proc_5_p1'     => 'La producció es duu a terme mitjançant maquinària d\'última generació i processos industrials altament controlats. Durant aquesta fase s\'apliquen les tècniques de personalització definides prèviament, garantint precisió, uniformitat i repetibilitat en cada unitat produïda.',
        'proc_5_p2'     => 'L\'experiència de l\'equip tècnic, juntament amb el control del procés, permet mantenir alts estàndards de qualitat tant en produccions puntuals com en grans volums i sèries recurrents.',
        'proc_6_label'  => 'Procés 6',
        'proc_6_title'  => 'Control de Qualitat',
        'proc_6_p1'     => 'Abans del lliurament, tots els productes passen per un control de qualitat rigorós i sistemàtic. Es revisen aspectes com la fidelitat al disseny aprovat, la qualitat dels acabats, la resistència de la personalització i la correcta aplicació de les tècniques utilitzades.',
        'proc_6_p2'     => 'Aquest procés garanteix que el producte final compleix els estàndards definits i les expectatives del client, minimitzant incidències i assegurant consistència en cada lliurament.',
        'proc_7_label'  => 'Procés 7',
        'proc_7_title'  => 'Logística i Lliurament',
        'proc_7_p1'     => 'L\'últim procés correspon a la gestió logística i el lliurament del producte. Fundació Ave Maria ofereix serveis d\'emmagatzematge, gestió d\'inventari i preparació de comandes (picking), adaptant-se a les necessitats específiques de cada projecte i canal de distribució.',
        'proc_7_p2'     => 'La logística es planifica de manera coordinada per garantir lliuraments puntuals, traçables i en condicions òptimes, tancant el procés de manera eficient i controlada.',
    ],
];

// =============================================================
// CONTACTO — id 10
// =============================================================
$T[10]['en'] = [
    'title' => 'Contact',
    'slug'  => 'contact',
    'meta'  => [
        'hero_label'    => 'Let\'s talk',
        'hero_subtitle' => 'Tell us about your project and we\'ll help you find the best textile customization solution for your brand.',
        'cont_form_label' => 'Write to us',
        'cont_form_title_l1' => 'Let\'s talk about',
        'cont_form_title_l2' => 'your project',
        'cont_form_desc'  => 'Tell us what you need: garment type, volume, deadlines and references. We\'ll get back to you with a clear proposal.',
        'cont_form_submit' => 'Send message',
        'cont_info_label' => 'Find us',
        'cont_info_title' => '<span class="text-green">Contact</span> information',
        'cont_addr_title' => 'Address',
        'cont_addr_name'  => 'Fundació Ave Maria',
        'cont_addr_line1' => 'Carrer Pujades 77, 1C',
        'cont_addr_line2' => '08005 Barcelona',
        'cont_tel_title'  => 'Contact',
        'cont_tel_display' => '+34 932 50 06 38',
        'cont_tel_raw'    => '932500638',
        'cont_email'      => 'info@cabglobal.es',
        'cont_hr_title'   => 'Hours',
        'cont_hr_line1'   => 'Monday to Thursday: 8:30 – 18:00',
        'cont_hr_line2'   => 'Friday: 8:30 – 14:30',
        'cont_map_addr'   => 'Carrer Pujades 77, 1C',
        'cont_map_city'   => '08005 Barcelona, Spain',
        'cont_map_link_text' => 'View on Google Maps',
        'cont_cta_title'  => 'Prefer to talk<br>on the <span class="text-green">phone</span>?',
        'cont_cta_text'   => 'Call us directly and we\'ll listen to you with no commitment. We\'d love to hear about your project.',
        'cont_cta_button' => 'Call now — +34 932 50 06 38',
    ],
];
$T[10]['ca'] = [
    'title' => 'Contacte',
    'slug'  => 'contacte',
    'meta'  => [
        'hero_label'    => 'Parlem',
        'hero_subtitle' => 'Explica\'ns el teu projecte i t\'ajudarem a trobar la millor solució de personalització tèxtil per a la teva marca.',
        'cont_form_label' => 'Escriu-nos',
        'cont_form_title_l1' => 'Parlem del',
        'cont_form_title_l2' => 'teu projecte',
        'cont_form_desc'  => 'Explica\'ns què necessites: tipus de peça, volum, terminis i referències. Et respondrem amb una proposta clara.',
        'cont_form_submit' => 'Enviar missatge',
        'cont_info_label' => 'Troba\'ns',
        'cont_info_title' => 'Informació de <span class="text-green">contacte</span>',
        'cont_addr_title' => 'Adreça',
        'cont_addr_name'  => 'Fundació Ave Maria',
        'cont_addr_line1' => 'Carrer Pujades 77, 1C',
        'cont_addr_line2' => '08005 Barcelona',
        'cont_tel_title'  => 'Contacte',
        'cont_tel_display' => '932 50 06 38',
        'cont_tel_raw'    => '932500638',
        'cont_email'      => 'info@cabglobal.es',
        'cont_hr_title'   => 'Horari',
        'cont_hr_line1'   => 'Dilluns a dijous: 8:30 – 18:00',
        'cont_hr_line2'   => 'Divendres: 8:30 – 14:30',
        'cont_map_addr'   => 'Carrer Pujades 77, 1C',
        'cont_map_city'   => '08005 Barcelona, Espanya',
        'cont_map_link_text' => 'Veure a Google Maps',
        'cont_cta_title'  => 'Prefereixes parlar<br>per <span class="text-green">telèfon</span>?',
        'cont_cta_text'   => 'Truca\'ns directament i t\'atendrem sense compromís. Estarem encantats d\'escoltar el teu projecte.',
        'cont_cta_button' => 'Truca ara — 932 50 06 38',
    ],
];

// =============================================================
// AJUSTES GLOBALES — id 34
// =============================================================
$T[34]['en'] = [
    'title' => 'Global Settings',
    'slug'  => 'global-settings',
    'meta'  => [
        'ag_cta_title'    => 'Let\'s start building<br>your <span class="text-green">next project</span>',
        'ag_cta_text'     => 'Tell us your idea and we\'ll propose the best textile customization solution for your brand.',
        'ag_cta_btn1_text' => 'Request a quote',
        'ag_cta_btn2_text' => 'Call now — +34 932 50 06 38',
        'ag_cta_btn2_tel' => '932500638',
        'ag_logos_alt'    => 'Fundació Ave Maria clients',
        'ag_footer_addr1' => 'Carrer Pujades 77, 1C',
        'ag_footer_addr2' => '08005 Barcelona',
        'ag_footer_h_nav' => 'Navigation',
        'ag_footer_h_srv' => 'Services',
        'ag_footer_h_con' => 'Contact',
        'ag_footer_tel_display' => '+34 932 50 06 38',
        'ag_footer_tel_raw' => '932500638',
        'ag_footer_email' => 'info@cabglobal.es',
        'ag_footer_hours1' => 'Mon – Thu: 8:30 – 18:00',
        'ag_footer_hours2' => 'Fri: 8:30 – 14:30',
        'ag_footer_copyright' => 'All rights reserved.',
    ],
];
$T[34]['ca'] = [
    'title' => 'Configuració Global',
    'slug'  => 'configuracio-global',
    'meta'  => [
        'ag_cta_title'    => 'Comencem a construir<br>el teu <span class="text-green">pròxim projecte</span>',
        'ag_cta_text'     => 'Explica\'ns la teva idea i et proposem la millor solució de personalització tèxtil per a la teva marca.',
        'ag_cta_btn1_text' => 'Sol·licitar pressupost',
        'ag_cta_btn2_text' => 'Truca ara — 932 50 06 38',
        'ag_cta_btn2_tel' => '932500638',
        'ag_logos_alt'    => 'Clients Fundació Ave Maria',
        'ag_footer_addr1' => 'Carrer Pujades 77, 1C',
        'ag_footer_addr2' => '08005 Barcelona',
        'ag_footer_h_nav' => 'Navegació',
        'ag_footer_h_srv' => 'Serveis',
        'ag_footer_h_con' => 'Contacte',
        'ag_footer_tel_display' => '932 50 06 38',
        'ag_footer_tel_raw' => '932500638',
        'ag_footer_email' => 'info@cabglobal.es',
        'ag_footer_hours1' => 'Dl – Dj: 8:30 – 18:00',
        'ag_footer_hours2' => 'Dv: 8:30 – 14:30',
        'ag_footer_copyright' => 'Tots els drets reservats.',
    ],
];

// =============================================================
// MIEMBROS (avemaria_miembro) — ids 11..14
// =============================================================
$T[11]['en'] = ['title' => 'Juan', 'slug' => 'juan-en', 'meta' => ['_cab_cargo' => 'CEO', '_cab_iniciales' => 'J']];
$T[11]['ca'] = ['title' => 'Juan', 'slug' => 'juan-ca', 'meta' => ['_cab_cargo' => 'CEO', '_cab_iniciales' => 'J']];
$T[12]['en'] = ['title' => 'Aleix', 'slug' => 'aleix-en', 'meta' => ['_cab_cargo' => 'COO', '_cab_iniciales' => 'A']];
$T[12]['ca'] = ['title' => 'Aleix', 'slug' => 'aleix-ca', 'meta' => ['_cab_cargo' => 'COO', '_cab_iniciales' => 'A']];
$T[13]['en'] = ['title' => 'Tomás Martí', 'slug' => 'tomas-marti-en', 'meta' => ['_cab_cargo' => 'Admin & Logistics', '_cab_iniciales' => 'TM']];
$T[13]['ca'] = ['title' => 'Tomás Martí', 'slug' => 'tomas-marti-ca', 'meta' => ['_cab_cargo' => 'Administració i Logística', '_cab_iniciales' => 'TM']];
$T[14]['en'] = ['title' => 'Alfredo Berca', 'slug' => 'alfredo-berca-en', 'meta' => ['_cab_cargo' => 'Production Manager', '_cab_iniciales' => 'AB']];
$T[14]['ca'] = ['title' => 'Alfredo Berca', 'slug' => 'alfredo-berca-ca', 'meta' => ['_cab_cargo' => 'Cap de Producció', '_cab_iniciales' => 'AB']];

// =============================================================
// PROYECTOS (avemaria_proyecto) — ids 15..26 (solo título)
// =============================================================
$T[15]['en'] = ['title' => 'Full-Color DTF — Running T-shirt', 'slug' => 'full-color-dtf-running-tshirt'];
$T[15]['ca'] = ['title' => 'DTF Full Color — Samarreta Running', 'slug' => 'dtf-full-color-samarreta-running'];
$T[16]['en'] = ['title' => '3D TPU Patch — Football Kit', 'slug' => '3d-tpu-patch-football-kit'];
$T[16]['ca'] = ['title' => 'Pegat 3D TPU — Equipament de Futbol', 'slug' => 'pegat-3d-tpu-equipament-futbol'];
$T[17]['en'] = ['title' => 'Integral Labelling — Retail Collection', 'slug' => 'integral-labelling-retail-collection'];
$T[17]['ca'] = ['title' => 'Etiquetatge Integral — Col·lecció Retail', 'slug' => 'etiquetatge-integral-colleccio-retail'];
$T[18]['en'] = ['title' => 'Full Sublimation — Corporate Polo', 'slug' => 'full-sublimation-corporate-polo'];
$T[18]['ca'] = ['title' => 'Sublimació Total — Polo Corporatiu', 'slug' => 'sublimacio-total-polo-corporatiu'];
$T[19]['en'] = ['title' => 'HD Embroidered Patch — Premium Jacket', 'slug' => 'hd-embroidered-patch-premium-jacket'];
$T[19]['ca'] = ['title' => 'Pegat Brodat HD — Jaqueta Premium', 'slug' => 'pegat-brodat-hd-jaqueta-premium'];
$T[20]['en'] = ['title' => 'Transfer Pressing — Limited Series', 'slug' => 'transfer-pressing-limited-series'];
$T[20]['ca'] = ['title' => 'Planxat Transfer — Sèrie Limitada', 'slug' => 'planxat-transfer-serie-limitada'];
$T[21]['en'] = ['title' => 'Anti-migration Transfer — Dark Hoodie', 'slug' => 'anti-migration-transfer-dark-hoodie'];
$T[21]['ca'] = ['title' => 'Transfer Antimigració — Dessuadora Fosca', 'slug' => 'transfer-antimigracio-dessuadora-fosca'];
$T[22]['en'] = ['title' => '3D Silicone Patch — Streetwear Cap', 'slug' => '3d-silicone-patch-streetwear-cap'];
$T[22]['ca'] = ['title' => 'Pegat Silicona 3D — Gorra Streetwear', 'slug' => 'pegat-silicona-3d-gorra-streetwear'];
$T[23]['en'] = ['title' => 'QC Control + Packaging — 5,000-unit Batch', 'slug' => 'qc-control-packaging-5000-batch'];
$T[23]['ca'] = ['title' => 'Control QC + Embalatge — Lot 5.000 uts.', 'slug' => 'control-qc-embalatge-lot-5000-uts'];
$T[24]['en'] = ['title' => 'Reflective Vinyl — Safety Vest', 'slug' => 'reflective-vinyl-safety-vest'];
$T[24]['ca'] = ['title' => 'Vinil Reflectant — Armilla de Seguretat', 'slug' => 'vinil-reflectant-armilla-seguretat'];
$T[25]['en'] = ['title' => 'Premium UV Patch — Outdoor Backpack', 'slug' => 'premium-uv-patch-outdoor-backpack'];
$T[25]['ca'] = ['title' => 'Pegat UV Premium — Motxilla Outdoor', 'slug' => 'pegat-uv-premium-motxilla-outdoor'];
$T[26]['en'] = ['title' => 'Laser Marking — Pro Basketball Kit', 'slug' => 'laser-marking-pro-basketball-kit'];
$T[26]['ca'] = ['title' => 'Marcatge Làser — Equipament Bàsquet Pro', 'slug' => 'marcatge-laser-equipament-basquet-pro'];

/*
|--------------------------------------------------------------------------
| EJECUCIÓN
|--------------------------------------------------------------------------
*/

echo "🟢 Iniciando seed de traducciones EN + CA\n\n";
$count = 0;
foreach ($T as $source_id => $by_lang) {
    $src = get_post($source_id);
    if (!$src) { echo "ID $source_id no existe, omito\n"; continue; }
    echo "📄 [$source_id] ".$src->post_title."\n";
    foreach ($by_lang as $lang => $data) {
        $tr = avemaria_seed_translation($source_id, $lang, $data);
        if ($tr) $count++;
    }
}

// =============================================================
// STRINGS FIJOS DEL TEMA (Polylang String Translations)
// =============================================================
echo "\n🟢 Traduciendo strings fijos del tema\n";
$pll_strings = [
    // Header
    'Solicitar presupuesto' => ['en' => 'Request a quote', 'ca' => 'Sol·licitar pressupost'],
    'Menú'                  => ['en' => 'Menu',             'ca' => 'Menú'],
    'Selector de idioma'    => ['en' => 'Language selector', 'ca' => 'Selector d\'idioma'],

    // Home · STATS section
    'Ave Maria en números'        => ['en' => 'Ave Maria in numbers',   'ca' => 'Ave Maria en xifres'],
    'Datos que <span class="text-green">nos respaldan</span>' => [
        'en' => 'Numbers that <span class="text-green">back us up</span>',
        'ca' => 'Dades que <span class="text-green">ens avalen</span>',
    ],
    'Años de experiencia'   => ['en' => 'Years of experience', 'ca' => 'Anys d\'experiència'],
    'Prendas al día'        => ['en' => 'Garments per day',    'ca' => 'Peces al dia'],
    'Marcas clientes'       => ['en' => 'Client brands',       'ca' => 'Marques clients'],
    'Proyectos realizados'  => ['en' => 'Completed projects',  'ca' => 'Projectes realitzats'],

    // Home · SHOWLOG (Sevilla F.C.) section
    'Caso real · Sevilla F.C.' => ['en' => 'Real case · Sevilla F.C.', 'ca' => 'Cas real · Sevilla F.C.'],
    'Camisetas oficiales<br><span class="text-green">360° de personalización</span>' => [
        'en' => 'Official jerseys<br><span class="text-green">360° of customization</span>',
        'ca' => 'Samarretes oficials<br><span class="text-green">360° de personalització</span>',
    ],
    'Producción de la equipación oficial del Sevilla F.C. — sublimación tintorera de alto detalle, escudos bordados, dorsales con transfer termopegable y etiquetado oficial LaLiga.' => [
        'en' => 'Production of the official Sevilla F.C. kit — high-detail dye sublimation, embroidered crests, numbers with heat-press transfer and official LaLiga labelling.',
        'ca' => 'Producció de l\'equipament oficial del Sevilla F.C. — sublimació tintorera d\'alt detall, escuts brodats, dorsals amb transfer termoadhesiu i etiquetatge oficial LaLiga.',
    ],
    'Sublimación.'          => ['en' => 'Sublimation.',     'ca' => 'Sublimació.'],
    'Colores vivos y duraderos' => ['en' => 'Vivid, lasting colors', 'ca' => 'Colors vius i duradors'],
    'Bordado 3D.'           => ['en' => '3D Embroidery.',   'ca' => 'Brodat 3D.'],
    'Escudo con relieve y volumen' => ['en' => 'Crest with relief and volume', 'ca' => 'Escut amb relleu i volum'],
    'Transfer premium.'     => ['en' => 'Premium transfer.', 'ca' => 'Transfer premium.'],
    'Dorsales y números'    => ['en' => 'Numbers and lettering', 'ca' => 'Dorsals i números'],
    'Etiquetado oficial.'   => ['en' => 'Official labelling.', 'ca' => 'Etiquetatge oficial.'],
    'Compliance LaLiga'     => ['en' => 'LaLiga compliance', 'ca' => 'Compliance LaLiga'],

    // Footer · Tour Virtual
    'Conoce nuestras instalaciones' => ['en' => 'Discover our facilities', 'ca' => 'Coneix les nostres instal·lacions'],
    'Tour Virtual <span class="text-green">360°</span>' => [
        'en' => '<span class="text-green">360°</span> Virtual Tour',
        'ca' => 'Tour Virtual <span class="text-green">360°</span>',
    ],
    'Iniciar tour virtual'  => ['en' => 'Start virtual tour', 'ca' => 'Iniciar tour virtual'],

    // Footer · Marcas del grupo
    'Marcas del grupo' => ['en' => 'Group brands', 'ca' => 'Marques del grup'],

    // Quiénes Somos · Stats + CTA hardcoded
    'Instalaciones'              => ['en' => 'Facilities',                  'ca' => 'Instal·lacions'],
    'Hablemos de tu proyecto'    => ['en' => 'Let\'s talk about your project', 'ca' => 'Parlem del teu projecte'],

    // Soluciones · Sections
    'Qué hacemos'                => ['en' => 'What we do',                  'ca' => 'Què fem'],
    'Scroll'                     => ['en' => 'Scroll',                      'ca' => 'Desplaça'],
    'Por qué Ave Maria'                => ['en' => 'Why Ave Maria',                     'ca' => 'Per què Ave Maria'],
    'Integración completa de <span class="text-green">producción, calidad y entrega</span>' => [
        'en' => 'Full integration of <span class="text-green">production, quality and delivery</span>',
        'ca' => 'Integració completa de <span class="text-green">producció, qualitat i lliurament</span>',
    ],
    'Capacidad industrial'       => ['en' => 'Industrial capacity',         'ca' => 'Capacitat industrial'],
    'Más de 5.000 prendas al día en producción continua con la máxima precisión y control.' => [
        'en' => 'Over 5,000 garments per day in continuous production with maximum precision and control.',
        'ca' => 'Més de 5.000 peces al dia en producció contínua amb la màxima precisió i control.',
    ],
    'Calidad premium'            => ['en' => 'Premium quality',             'ca' => 'Qualitat premium'],
    'Procesos certificados y control de calidad exhaustivo en cada etapa de la cadena.' => [
        'en' => 'Certified processes and exhaustive quality control at every stage of the chain.',
        'ca' => 'Processos certificats i control de qualitat exhaustiu a cada etapa de la cadena.',
    ],
    'Rapidez y flexibilidad'     => ['en' => 'Speed and flexibility',       'ca' => 'Rapidesa i flexibilitat'],
    'Pedidos express, adaptación a picos de demanda y entregas ajustadas a tu calendario.' => [
        'en' => 'Express orders, adaptation to demand peaks and deliveries tailored to your schedule.',
        'ca' => 'Comandes express, adaptació a pics de demanda i lliuraments ajustats al teu calendari.',
    ],
    'Escala global'              => ['en' => 'Global scale',                'ca' => 'Escala global'],
    'Trabajamos con marcas y clubes en más de 20 países con logística integrada.' => [
        'en' => 'We work with brands and clubs in over 20 countries with integrated logistics.',
        'ca' => 'Treballem amb marques i clubs en més de 20 països amb logística integrada.',
    ],
    'Casos reales'               => ['en' => 'Real cases',                  'ca' => 'Casos reals'],

    // Soluciones · Bullets
    'Clubes · federaciones · marcas'        => ['en' => 'Clubs · federations · brands',                'ca' => 'Clubs · federacions · marques'],
    'Calidad técnica certificada'           => ['en' => 'Certified technical quality',                 'ca' => 'Qualitat tècnica certificada'],
    'Acabados resistentes al uso intensivo' => ['en' => 'Finishes resistant to heavy use',             'ca' => 'Acabats resistents a l\'ús intensiu'],
    'Líneas completas de producto'          => ['en' => 'Full product lines',                          'ca' => 'Línies completes de producte'],
    'Diseño alineado a tu marca'            => ['en' => 'Design aligned with your brand',              'ca' => 'Disseny alineat amb la teva marca'],
    'Producción flexible y escalable'       => ['en' => 'Flexible and scalable production',            'ca' => 'Producció flexible i escalable'],
    'Uniformes oficina · campo · industria' => ['en' => 'Office · field · industry uniforms',          'ca' => 'Uniformes oficina · camp · indústria'],
    'Tejidos técnicos y normativa EPI'      => ['en' => 'Technical fabrics and PPE compliance',        'ca' => 'Teixits tècnics i normativa EPI'],
    'Personalización con bordado y transfer'=> ['en' => 'Customization with embroidery and transfer', 'ca' => 'Personalització amb brodat i transfer'],
    'Parches tejidos · bordados · transfer' => ['en' => 'Woven · embroidered · transfer patches',      'ca' => 'Pegats teixits · brodats · transfer'],
    'Combinaciones de técnicas'             => ['en' => 'Technique combinations',                      'ca' => 'Combinacions de tècniques'],
    'Compliance oficial deportivo'          => ['en' => 'Official sports compliance',                  'ca' => 'Compliance oficial esportiu'],

    // Contacto · Form + info
    'Contacto'                              => ['en' => 'Contact',                        'ca' => 'Contacte'],
    'Escríbenos'                            => ['en' => 'Write to us',                    'ca' => 'Escriu-nos'],
    'Cuéntanos qué necesitas'               => ['en' => 'Tell us what you need',          'ca' => 'Explica\'ns què necessites'],
    'Nombre'                                => ['en' => 'Name',                           'ca' => 'Nom'],
    'Empresa'                               => ['en' => 'Company',                        'ca' => 'Empresa'],
    'Email'                                 => ['en' => 'Email',                          'ca' => 'Correu'],
    'Teléfono'                              => ['en' => 'Phone',                          'ca' => 'Telèfon'],
    'Mensaje'                               => ['en' => 'Message',                        'ca' => 'Missatge'],
    'Tu nombre completo'                    => ['en' => 'Your full name',                 'ca' => 'El teu nom complet'],
    'Nombre de tu empresa'                  => ['en' => 'Your company name',              'ca' => 'Nom de la teva empresa'],
    'Cuéntanos sobre tu proyecto, volumen estimado, plazos…' => [
        'en' => 'Tell us about your project, estimated volume, deadlines…',
        'ca' => 'Explica\'ns el teu projecte, volum estimat, terminis…',
    ],
    'Dirección'                             => ['en' => 'Address',                        'ca' => 'Adreça'],
    'Contacto directo'                      => ['en' => 'Direct contact',                 'ca' => 'Contacte directe'],
    'Horario'                               => ['en' => 'Hours',                          'ca' => 'Horari'],
    'Lunes a Jueves · 8:30 – 18:00'         => ['en' => 'Monday to Thursday · 8:30 – 18:00', 'ca' => 'Dilluns a Dijous · 8:30 – 18:00'],
    'Viernes · 8:30 – 14:30'                => ['en' => 'Friday · 8:30 – 14:30',          'ca' => 'Divendres · 8:30 – 14:30'],
    'Encuéntranos'                          => ['en' => 'Find us',                        'ca' => 'Troba\'ns'],
    'Carrer Pujades 77<br><span class="text-green">Barcelona</span>' => [
        'en' => 'Carrer Pujades 77<br><span class="text-green">Barcelona</span>',
        'ca' => 'Carrer Pujades 77<br><span class="text-green">Barcelona</span>',
    ],
    'Nuestro taller central está en el corazón del 22@ de Barcelona, a 5 min del metro Llacuna (L4).' => [
        'en' => 'Our main workshop is in the heart of Barcelona\'s 22@ district, 5 minutes from Llacuna (L4) metro.',
        'ca' => 'El nostre taller central és al cor del 22@ de Barcelona, a 5 min del metro Llacuna (L4).',
    ],
    'Mapa de Fundació Ave Maria · Carrer Pujades 77, Barcelona' => [
        'en' => 'Fundació Ave Maria map · Carrer Pujades 77, Barcelona',
        'ca' => 'Mapa de Fundació Ave Maria · Carrer Pujades 77, Barcelona',
    ],

    // Servicios defaults
    'Planchado técnico'                                              => ['en' => 'Technical pressing',  'ca' => 'Planxat tècnic'],
    'Capacidad de procesar hasta 5.000 prendas diarias, garantizando uniformidad en la fijación y precisión en la colocación.' => [
        'en' => 'Capacity to process up to 5,000 garments per day, guaranteeing uniform fixing and precise placement.',
        'ca' => 'Capacitat de processar fins a 5.000 peces diàries, garantint uniformitat en la fixació i precisió en la col·locació.',
    ],
    'Escalabilidad'                                                  => ['en' => 'Scalability',         'ca' => 'Escalabilitat'],
    'Estructura operativa diseñada para adaptarse a picos de demanda y campañas de alto volumen, ampliando capacidad productiva.' => [
        'en' => 'Operational structure designed to adapt to demand peaks and high-volume campaigns, expanding production capacity.',
        'ca' => 'Estructura operativa dissenyada per adaptar-se a pics de demanda i campanyes d\'alt volum, ampliant capacitat productiva.',
    ],

    // CTA Final defaults + logos
    'Empecemos a construir<br>tu <span class="text-green">próximo proyecto</span>' => [
        'en' => 'Let\'s start building<br>your <span class="text-green">next project</span>',
        'ca' => 'Comencem a construir<br>el teu <span class="text-green">pròxim projecte</span>',
    ],
    'Cuéntanos tu idea y te proponemos la mejor solución de personalización textil para tu marca.' => [
        'en' => 'Tell us your idea and we\'ll propose the best textile customization solution for your brand.',
        'ca' => 'Explica\'ns la teva idea i et proposem la millor solució de personalització tèxtil per a la teva marca.',
    ],
    'Llamar ahora — 932 50 06 38'                                    => ['en' => 'Call now — +34 932 50 06 38', 'ca' => 'Truca ara — 932 50 06 38'],
    'Clientes Fundació Ave Maria'                                            => ['en' => 'Fundació Ave Maria clients',          'ca' => 'Clients Fundació Ave Maria'],

    // Procesos · Hero
    'Nuestra metodología'                       => ['en' => 'Our methodology',                              'ca' => 'La nostra metodologia'],
    'Procesos'                                  => ['en' => 'Processes',                                    'ca' => 'Processos'],
    'Siete procesos consecutivos diseñados para garantizar control total, eficiencia operativa y consistencia en cada proyecto de personalización.' => [
        'en' => 'Seven consecutive processes designed to guarantee total control, operational efficiency and consistency in every customization project.',
        'ca' => 'Set processos consecutius dissenyats per garantir control total, eficiència operativa i consistència en cada projecte de personalització.',
    ],

    // Procesos · Bullets
    'Reunión técnica con briefing'              => ['en' => 'Technical meeting with briefing',              'ca' => 'Reunió tècnica amb briefing'],
    'Revisión de volúmenes y calendario'        => ['en' => 'Volume and timeline review',                   'ca' => 'Revisió de volums i calendari'],
    'Planificación a medida'                    => ['en' => 'Tailored planning',                            'ca' => 'Planificació a mida'],
    'Propuestas visuales'                       => ['en' => 'Visual proposals',                             'ca' => 'Propostes visuals'],
    'Previsualización digital'                  => ['en' => 'Digital preview',                              'ca' => 'Previsualització digital'],
    'Prototipos y ajustes'                      => ['en' => 'Prototypes and adjustments',                   'ca' => 'Prototips i ajustaments'],
    'Análisis técnico detallado'                => ['en' => 'Detailed technical analysis',                  'ca' => 'Anàlisi tècnica detallada'],
    'Selección de maquinaria'                   => ['en' => 'Machinery selection',                          'ca' => 'Selecció de maquinària'],
    'Optimización de costes'                    => ['en' => 'Cost optimization',                            'ca' => 'Optimització de costos'],
    'Soportes certificados'                     => ['en' => 'Certified supports',                           'ca' => 'Suports certificats'],
    'Colores Pantone exactos'                   => ['en' => 'Exact Pantone colors',                         'ca' => 'Colors Pantone exactes'],
    'Proveedores premium'                       => ['en' => 'Premium suppliers',                            'ca' => 'Proveïdors premium'],
    '+5.000 prendas/día'                        => ['en' => '+5,000 garments/day',                          'ca' => '+5.000 peces/dia'],
    'Maquinaria industrial'                     => ['en' => 'Industrial machinery',                         'ca' => 'Maquinària industrial'],
    'Procesos controlados'                      => ['en' => 'Controlled processes',                         'ca' => 'Processos controlats'],
    'Inspección por lote'                       => ['en' => 'Per-batch inspection',                         'ca' => 'Inspecció per lot'],
    'Trazabilidad completa'                     => ['en' => 'Full traceability',                            'ca' => 'Traçabilitat completa'],
    'Corrección en tiempo real'                 => ['en' => 'Real-time correction',                         'ca' => 'Correcció en temps real'],
    'Almacenaje y picking'                      => ['en' => 'Storage and picking',                          'ca' => 'Emmagatzematge i picking'],
    'Distribución global'                       => ['en' => 'Global distribution',                          'ca' => 'Distribució global'],
    'Entregas express'                          => ['en' => 'Express deliveries',                           'ca' => 'Lliuraments express'],

    // Servicios · Pilares
    'Creatividad <span class="text-green">& técnica</span>' => [
        'en' => 'Creativity <span class="text-green">& technique</span>',
        'ca' => 'Creativitat <span class="text-green">i tècnica</span>',
    ],
    '<span class="text-green">Excelencia</span> en cada prenda' => [
        'en' => '<span class="text-green">Excellence</span> in every garment',
        'ca' => '<span class="text-green">Excel·lència</span> en cada peça',
    ],
    '<span class="text-green">Innovación</span> continua' => [
        'en' => 'Continuous <span class="text-green">innovation</span>',
        'ca' => '<span class="text-green">Innovació</span> contínua',
    ],

    // Footer Services menu
    'Impresión'         => ['en' => 'Printing',           'ca' => 'Impressió'],
    'Transfer y Parches'=> ['en' => 'Transfers & Patches','ca' => 'Transfers i Pegats'],
    'Marcado en Prenda' => ['en' => 'Garment Marking',    'ca' => 'Marcatge de Peces'],
    'Logística'         => ['en' => 'Logistics',          'ca' => 'Logística'],

    // Soluciones hero defaults + cases labels
    'Nuestro'           => ['en' => 'Our',                'ca' => 'El nostre'],
    'Ecosistema'        => ['en' => 'Ecosystem',          'ca' => 'Ecosistema'],
    'Soluciones integrales de personalización textil industrial — del diseño a la distribución, en una sola casa.' => [
        'en' => 'Integral solutions in industrial textile customization — from design to distribution, under one roof.',
        'ca' => 'Solucions integrals de personalització tèxtil industrial — del disseny a la distribució, en una sola casa.',
    ],
    'Solución'          => ['en' => 'Solution',           'ca' => 'Solució'],
    'Resultado'         => ['en' => 'Result',             'ca' => 'Resultat'],

    // Portfolio aria-label
    'Filtros de portfolio' => ['en' => 'Portfolio filters', 'ca' => 'Filtres de portfoli'],

    // Home hero alt
    'Customización deportiva' => ['en' => 'Sports customization', 'ca' => 'Personalització esportiva'],

    // Soluciones cases hardcoded title
    'Proyectos que <span class="text-green">hablan por nosotros</span>' => [
        'en' => 'Projects that <span class="text-green">speak for us</span>',
        'ca' => 'Projectes que <span class="text-green">parlen per nosaltres</span>',
    ],
];

if (function_exists('pll_register_string')) {
    foreach ($pll_strings as $original => $trs) {
        foreach ($trs as $lang => $val) {
            // Polylang almacena en option 'polylang_mo_<term_id>'
            $lang_obj = PLL()->model->get_language($lang);
            if (!$lang_obj) continue;
            $mo_option = 'polylang_mo_' . $lang_obj->term_id;
            $mo = get_option($mo_option, null);
            if (!$mo || !is_object($mo)) {
                if (class_exists('PLL_MO')) {
                    $mo = new PLL_MO();
                    $mo->import_from_db($lang_obj);
                } else {
                    continue;
                }
            }
            $mo->add_entry($mo->make_entry($original, $val));
            $mo->export_to_db($lang_obj);
            echo "  $lang: '$original' → '$val'\n";
        }
    }
}

// =============================================================
// MENÚS POR IDIOMA (primary, footer, services)
// =============================================================
echo "\n🟢 Creando menús por idioma\n";

$menu_specs = [
    'primary' => [
        'name_base' => 'Menú Principal',
        // [slug ES => label ES] (los traduciremos)
        'items' => [
            'home'          => 'Home',
            'quienes-somos' => 'Quiénes Somos',
            'servicios'     => 'Servicios',
            'soluciones'    => 'Soluciones',
            'procesos'      => 'Procesos',
            'contacto'      => 'Contacto',
        ],
        'labels' => [
            'es' => ['home'=>'Home','quienes-somos'=>'Quiénes Somos','servicios'=>'Servicios','soluciones'=>'Soluciones','procesos'=>'Procesos','contacto'=>'Contacto'],
            'en' => ['home'=>'Home','quienes-somos'=>'About Us','servicios'=>'Services','soluciones'=>'Solutions','procesos'=>'Processes','contacto'=>'Contact'],
            'ca' => ['home'=>'Inici','quienes-somos'=>'Qui Som','servicios'=>'Serveis','soluciones'=>'Solucions','procesos'=>'Processos','contacto'=>'Contacte'],
        ],
    ],
    'footer' => [
        'name_base' => 'Menú Footer',
        'items' => [
            'quienes-somos' => 'Quiénes Somos',
            'servicios'     => 'Servicios',
            'soluciones'    => 'Soluciones',
            'portfolio'     => 'Portfolio',
            'procesos'      => 'Procesos',
        ],
        'labels' => [
            'es' => ['quienes-somos'=>'Quiénes Somos','servicios'=>'Servicios','soluciones'=>'Soluciones','portfolio'=>'Portfolio','procesos'=>'Procesos'],
            'en' => ['quienes-somos'=>'About Us','servicios'=>'Services','soluciones'=>'Solutions','portfolio'=>'Portfolio','procesos'=>'Processes'],
            'ca' => ['quienes-somos'=>'Qui Som','servicios'=>'Serveis','soluciones'=>'Solucions','portfolio'=>'Portfoli','procesos'=>'Processos'],
        ],
    ],
];

$locations = get_theme_mod('nav_menu_locations', []);
$pll_options = get_option('polylang');
$theme_slug = get_stylesheet();
if (!isset($pll_options['nav_menus'][$theme_slug])) $pll_options['nav_menus'][$theme_slug] = [];

foreach ($menu_specs as $location => $spec) {
    foreach (['es','en','ca'] as $lang) {
        $menu_name = $spec['name_base'] . ' (' . strtoupper($lang) . ')';
        $menu = wp_get_nav_menu_object($menu_name);
        if (!$menu) {
            $menu_id = wp_create_nav_menu($menu_name);
            $menu = wp_get_nav_menu_object($menu_id);
            echo "  Creado menú: $menu_name (id $menu_id)\n";
        } else {
            $menu_id = $menu->term_id;
            // Vaciar items para regenerar
            $items = wp_get_nav_menu_items($menu_id);
            if ($items) foreach ($items as $it) wp_delete_post($it->ID, true);
            echo "  Recreando menú: $menu_name (id $menu_id)\n";
        }
        foreach ($spec['items'] as $slug => $_) {
            $es_page = get_page_by_path($slug);
            if (!$es_page) continue;
            $target_id = (int) $es_page->ID;
            if ($lang !== 'es') {
                $tr = pll_get_post($es_page->ID, $lang);
                if ($tr) $target_id = (int) $tr;
            }
            $label = $spec['labels'][$lang][$slug] ?? $es_page->post_title;
            wp_update_nav_menu_item($menu_id, 0, [
                'menu-item-title'     => $label,
                'menu-item-object'    => 'page',
                'menu-item-object-id' => $target_id,
                'menu-item-type'      => 'post_type',
                'menu-item-status'    => 'publish',
            ]);
        }
        // Asignar este menú al theme_location para este idioma vía Polylang
        // Polylang almacena nav_menus[<theme>][<location>][<lang>] => menu_id
        $pll_options['nav_menus'][$theme_slug][$location][$lang] = $menu_id;
        // Para el idioma por defecto (ES), también el theme_location estándar
        if ($lang === 'es') {
            $locations[$location] = $menu_id;
        }
    }
}
set_theme_mod('nav_menu_locations', $locations);
update_option('polylang', $pll_options);
echo "  Menús asignados a locations vía Polylang\n";

// Flush cache + rewrite
flush_rewrite_rules();
wp_cache_flush();

echo "\n✅ Listo. $count traducciones creadas/actualizadas.\n";
