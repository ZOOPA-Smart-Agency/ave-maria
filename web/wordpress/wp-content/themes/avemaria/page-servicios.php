<?php
/* Template Name: Servicios */
get_header();
$pid = get_the_ID();

$tab_svgs = [
    'imp' => [
        '<svg viewBox="0 0 52 52" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="8" y="20" width="36" height="24" rx="3"/><path d="M16 20V10h20v10"/><path d="M16 34h20"/><circle cx="36" cy="26" r="2" fill="currentColor" stroke="none"/></svg>',
        '<svg viewBox="0 0 52 52" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="26" cy="26" r="18"/><path d="M26 14v24M14 26h24"/><circle cx="26" cy="26" r="8"/></svg>',
        '<svg viewBox="0 0 52 52" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M8 40l10-28h4l10 28"/><path d="M12 32h16"/><path d="M34 16h10v24"/><path d="M34 28h10"/></svg>',
        '<svg viewBox="0 0 52 52" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="6" y="6" width="40" height="40" rx="4"/><path d="M6 18h40"/><path d="M20 18v28"/><path d="M26 30l8-8M26 38l14-14"/></svg>',
    ],
    'tra' => [
        '<svg viewBox="0 0 52 52" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="8" y="8" width="36" height="36" rx="4"/><path d="M8 20h36"/><path d="M20 20v24"/><path d="M14 14h6M32 14h6"/></svg>',
        '<svg viewBox="0 0 52 52" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M26 8c-10 0-18 8-18 18s8 18 18 18"/><path d="M26 8c10 0 18 8 18 18s-8 18-18 18"/><path d="M14 16c4 4 8 6 12 6s8-2 12-6"/><path d="M14 36c4-4 8-6 12-6s8 2 12 6"/><line x1="26" y1="8" x2="26" y2="44"/></svg>',
        '<svg viewBox="0 0 52 52" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M10 42V18l16-10 16 10v24L26 52 10 42z"/><path d="M10 18l16 10 16-10"/><path d="M26 28v24"/></svg>',
        '<svg viewBox="0 0 52 52" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="6" y="12" width="40" height="28" rx="4"/><path d="M6 22h40"/><circle cx="26" cy="32" r="5"/><path d="M12 16v-4h28v4"/></svg>',
    ],
    'mar' => [
        '<svg viewBox="0 0 52 52" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="10" y="22" width="32" height="6" rx="2"/><path d="M14 22v-8a12 12 0 0124 0v8"/><path d="M10 28v10h32V28"/><line x1="26" y1="32" x2="26" y2="36"/></svg>',
        '<svg viewBox="0 0 52 52" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="12" y="6" width="28" height="40" rx="3"/><path d="M12 14h28"/><path d="M20 22h12M20 28h12M20 34h8"/><circle cx="16" cy="10" r="1.5" fill="currentColor" stroke="none"/></svg>',
        '<svg viewBox="0 0 52 52" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M10 44h32"/><path d="M14 44V16l12-8 12 8v28"/><rect x="22" y="30" width="8" height="14"/><rect x="18" y="20" width="6" height="6" rx="1"/><rect x="28" y="20" width="6" height="6" rx="1"/></svg>',
        '<svg viewBox="0 0 52 52" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M26 4l6 12h14l-11 8 4 14-13-9-13 9 4-14L6 16h14z"/></svg>',
    ],
    'log' => [
        '<svg viewBox="0 0 52 52" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="6" y="10" width="40" height="32" rx="3"/><path d="M6 22h40M6 34h40"/><path d="M22 10v32M36 10v32"/></svg>',
        '<svg viewBox="0 0 52 52" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M10 44V14l16-8 16 8v30"/><path d="M10 14l16 8 16-8"/><rect x="20" y="28" width="12" height="16" rx="2"/><path d="M26 36v4"/></svg>',
        '<svg viewBox="0 0 52 52" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="4" y="18" width="30" height="22" rx="3"/><path d="M34 24h10l6 10v6h-16"/><circle cx="14" cy="42" r="5"/><circle cx="40" cy="42" r="5"/><path d="M19 40h16"/></svg>',
        '<svg viewBox="0 0 52 52" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 40V26h8v14"/><path d="M22 40V18h8v22"/><path d="M32 40V12h8v28"/><path d="M8 44h36"/><path d="M10 10l8 4 8-6 8 2 8-4" stroke-dasharray="2 2"/></svg>',
    ],
];

$tab_defaults = [
    'imp' => ['img' => avemaria_asset('img/TEC_1.jpg'), 'intro' => 'Soluciones de impresión industrial adaptadas a distintos materiales y aplicaciones, garantizando calidad y durabilidad.'],
    'tra' => ['img' => avemaria_asset('img/TEC_3.jpg'), 'intro' => 'Soluciones de transfer y parches para todo tipo de prendas y acabados de alta calidad.'],
    'mar' => ['img' => avemaria_asset('img/TEC_4.jpg'), 'intro' => 'Servicios de marcado y manipulación de prendas a escala industrial con control exhaustivo.'],
    'log' => ['img' => avemaria_asset('img/TEC_5.jpg'), 'intro' => 'Servicios de almacenamiento y gestión logística integral para proyectos de cualquier volumen.'],
];

// Defaults de las 16 sub-cards (4 por tab) · textos originales de la web
$card_defaults = [
    'imp' => [
        1 => ['DTF',            'Trabajamos con impresión DTF para producciones personalizadas con acabados resistentes, flexibles y de alta fidelidad.'],
        2 => ['Impresión UV',   'Acabados precisos sobre superficies rígidas o flexibles y relieves 3D para máximo impacto visual.'],
        3 => ['Sublimación',    'Diseño permanente en el tejido, con libertad de colores vibrantes y detalle, sin tacto adicional.'],
        4 => ['Vinilo Textil',  'Versátil, resistente y preciso, perfecto para logos, números o diseños con relieve profesional.'],
    ],
    'tra' => [
        1 => ['Transfer serigráficos', 'Acabado profesional, resistente al uso y al lavado, con propiedades antimigración.'],
        2 => ['Bordado',               'Aplicación para prendas corporativas y deportivas, que puede realizarse directamente sobre la prenda o mediante parches.'],
        3 => ['Escudos 3D UV/TPU',     'Tecnología que genera volumen y texturas definidas, creando relieves precisos con un acabado visual potente.'],
        4 => ['Parches híbridos',      'Parches desarrollados a medida, diseñados para ajustarse a cada marca, integrando diferentes materiales y acabados.'],
    ],
    'mar' => [
        1 => ['Planchado técnico',  'Capacidad de procesar hasta 5.000 prendas diarias, garantizando uniformidad en la fijación y precisión en la colocación.'],
        2 => ['Etiquetado',         'Integración de etiquetas técnicas y de marca según especificaciones del cliente, gestionando miles de unidades por jornada.'],
        3 => ['Embolsado',          'Embolsado y organización de grandes volúmenes de producto, manteniendo orden, limpieza y protección durante la manipulación.'],
        4 => ['Control de calidad', 'Supervisión constante durante el proceso productivo y revisión final antes del envío para cumplir estándares.'],
    ],
    'log' => [
        1 => ['Almacenaje',         'Gestión organizada del stock en instalaciones preparadas para manipular grandes volúmenes, manteniendo trazabilidad y control.'],
        2 => ['Picking',            'Preparación de pedidos adaptada a distintos canales de distribución: retail, eventos o distribución directa.'],
        3 => ['Gestión de envíos',  'Coordinación logística para envíos nacionales e internacionales, asegurando correcta preparación e identificación de pedidos.'],
        4 => ['Escalabilidad',      'Estructura operativa diseñada para adaptarse a picos de demanda y campañas de alto volumen, ampliando capacidad productiva.'],
    ],
];
?>

    <?php avemaria_page_hero(get_the_title(), ['green_word' => 'Servicios']); ?>

    <section class="srv-intro">
        <!-- Stop al INICIO (5%) — el body cambia a blanco justo al entrar,
             no en el centro (evita franja gris visible como en la home .process). -->
        <div class="srv-intro__stop" data-bg="#ffffff" style="position:absolute; left:0; top:5%; width:1px; height:1px; opacity:0; pointer-events:none;"></div>
        <div class="srv-intro__container">

            <!-- Franja de STATS (3 números animados) -->
            <div class="srv-stats" data-animate="fadeInUp">
                <div class="srv-stats__item">
                    <span class="srv-stats__num"><span class="srv-stats__plus">+</span><span data-count="<?php echo esc_attr(avemaria_field('srv_stat1_num', $pid, '8')); ?>">0</span></span>
                    <span class="srv-stats__desc"><?php echo esc_html(avemaria_field('srv_stat1_desc', $pid, 'Técnicas disponibles')); ?></span>
                </div>
                <div class="srv-stats__item">
                    <span class="srv-stats__num"><span class="srv-stats__plus">+</span><span data-count="<?php echo esc_attr(avemaria_field('srv_stat2_num', $pid, '5000')); ?>">0</span></span>
                    <span class="srv-stats__desc"><?php echo esc_html(avemaria_field('srv_stat2_desc', $pid, 'Prendas al día')); ?></span>
                </div>
                <div class="srv-stats__item">
                    <span class="srv-stats__num"><span class="srv-stats__plus">+</span><span data-count="<?php echo esc_attr(avemaria_field('srv_stat3_num', $pid, '20')); ?>">0</span></span>
                    <span class="srv-stats__desc"><?php echo esc_html(avemaria_field('srv_stat3_desc', $pid, 'Años de experiencia')); ?></span>
                </div>
            </div>

            <!-- 3 PILARES (los 3 párrafos viejos resumidos como cards) -->
            <div class="srv-pilars">
                <div class="srv-pilar" data-animate="fadeInUp" data-delay="1">
                    <div class="srv-pilar__icon" aria-hidden="true">
                        <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M24 4l6 12h14l-11 8 4 14-13-9-13 9 4-14L6 16h14z"/>
                        </svg>
                    </div>
                    <h3 class="srv-pilar__title"><?php echo wp_kses_post(avemaria_t('Creatividad <span class="text-green">& técnica</span>')); ?></h3>
                    <p class="srv-pilar__text"><?php echo esc_html(avemaria_field('srv_pilar1_text', $pid, 'Capacidad técnica y creatividad para transformar cualquier idea en prendas únicas de alta calidad.')); ?></p>
                </div>
                <div class="srv-pilar" data-animate="fadeInUp" data-delay="2">
                    <div class="srv-pilar__icon" aria-hidden="true">
                        <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M24 4l16 6v12c0 10-8 18-16 22-8-4-16-12-16-22V10z"/>
                            <path d="M16 24l6 6 12-12"/>
                        </svg>
                    </div>
                    <h3 class="srv-pilar__title"><?php echo wp_kses_post(avemaria_t('<span class="text-green">Excelencia</span> en cada prenda')); ?></h3>
                    <p class="srv-pilar__text"><?php echo esc_html(avemaria_field('srv_pilar2_text', $pid, 'Compromiso con la excelencia y atención al detalle en cada prenda, entregando resultados confiables proyecto tras proyecto.')); ?></p>
                </div>
                <div class="srv-pilar" data-animate="fadeInUp" data-delay="3">
                    <div class="srv-pilar__icon" aria-hidden="true">
                        <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M26 4L8 26h12l-4 18 20-26H24z"/>
                        </svg>
                    </div>
                    <h3 class="srv-pilar__title"><?php echo wp_kses_post(avemaria_t('<span class="text-green">Innovación</span> continua')); ?></h3>
                    <p class="srv-pilar__text"><?php echo esc_html(avemaria_field('srv_pilar3_text', $pid, 'Nuevas técnicas, maquinaria de última generación y logística eficiente aseguran entrega sin margen de error.')); ?></p>
                </div>
            </div>

        </div>
    </section>

    <section class="srv-tabs" id="servicios" data-bg="#ffffff">
        <div class="srv-tabs__container">
            <div class="srv-tabs__header" data-animate="fadeInUp">
                <p class="section-label section-label--center"><?php echo esc_html(avemaria_field('srv_tabs_label', $pid, 'Nuestros servicios')); ?></p>
                <h2 class="section-title section-title--light" style="text-align:center;"><?php echo wp_kses_post(avemaria_field('srv_tabs_title', $pid, 'Soluciones de <span class="text-green">customización</span> integral')); ?></h2>
            </div>

            <div class="srv-tabs__nav" data-animate="fadeInUp">
                <button type="button" class="srv-tab-btn active" data-tab="impresion"><?php echo esc_html(avemaria_field('srv_tab1_btn', $pid, 'Impresión')); ?></button>
                <button type="button" class="srv-tab-btn" data-tab="transfer"><?php echo esc_html(avemaria_field('srv_tab2_btn', $pid, 'Transfer y Parches')); ?></button>
                <button type="button" class="srv-tab-btn" data-tab="marcado"><?php echo esc_html(avemaria_field('srv_tab3_btn', $pid, 'Marcado en Prenda')); ?></button>
                <button type="button" class="srv-tab-btn" data-tab="logistica"><?php echo esc_html(avemaria_field('srv_tab4_btn', $pid, 'Logística')); ?></button>
            </div>

            <?php
            $panels = [
                ['id' => 'impresion', 'slug' => 'imp', 'active' => true],
                ['id' => 'transfer',  'slug' => 'tra', 'active' => false],
                ['id' => 'marcado',   'slug' => 'mar', 'active' => false],
                ['id' => 'logistica', 'slug' => 'log', 'active' => false],
            ];
            foreach ($panels as $panel) :
                $slug   = $panel['slug'];
                $img    = avemaria_field("srv_{$slug}_img", $pid) ?: $tab_defaults[$slug]['img'];
                $intro  = avemaria_field("srv_{$slug}_intro", $pid, $tab_defaults[$slug]['intro']);
                $active = $panel['active'] ? ' active' : '';
                ?>
                <div class="srv-tab-panel<?php echo $active; ?>" id="<?php echo esc_attr($panel['id']); ?>">
                    <p class="srv-tab-panel__intro"><?php echo esc_html($intro); ?></p>
                    <div class="srv-grid">
                        <?php for ($i = 1; $i <= 4; $i++) :
                            $t = avemaria_field("srv_{$slug}_c{$i}_t", $pid, $card_defaults[$slug][$i][0] ?? '');
                            $x = avemaria_field("srv_{$slug}_c{$i}_x", $pid, $card_defaults[$slug][$i][1] ?? '');
                            if (!$t && !$x) continue;
                            ?>
                            <div class="srv-card" data-animate="fadeInUp" data-delay="<?php echo $i; ?>">
                                <div class="srv-card__icon" aria-hidden="true"><?php echo $tab_svgs[$slug][$i - 1]; ?></div>
                                <h3 class="srv-card__title"><?php echo esc_html($t); ?></h3>
                                <p class="srv-card__text"><?php echo esc_html($x); ?></p>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <?php avemaria_cta_final(); ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.srv-tab-btn');
    const tabPanels = document.querySelectorAll('.srv-tab-panel');

    function activateTab(tabId) {
        tabButtons.forEach(function(btn) { btn.classList.remove('active'); });
        tabPanels.forEach(function(panel) { panel.classList.remove('active'); });
        const targetBtn = document.querySelector('.srv-tab-btn[data-tab="' + tabId + '"]');
        const targetPanel = document.getElementById(tabId);
        if (targetBtn) targetBtn.classList.add('active');
        if (targetPanel) targetPanel.classList.add('active');
    }

    tabButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            activateTab(this.getAttribute('data-tab'));
        });
    });

    if (window.location.hash) {
        var hash = window.location.hash.substring(1);
        var validTabs = ['impresion', 'transfer', 'marcado', 'logistica'];
        if (validTabs.indexOf(hash) !== -1) {
            activateTab(hash);
            setTimeout(function() {
                var el = document.getElementById('servicios');
                if (el) el.scrollIntoView({ behavior: 'smooth' });
            }, 100);
        }
    }
});
</script>

<?php get_footer(); ?>
