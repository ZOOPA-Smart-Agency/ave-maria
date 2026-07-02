<?php
/**
 * Template Name: Soluciones
 *
 * Estructura editorial inspirada en id-unlimited-group.com/ecosystem
 * Integrada con el sistema dark-first dinámico de la home.
 *
 * @package Ave_Maria
 */

get_header();
$pid = get_the_ID();
$contact_url = avemaria_page_url('contacto', '/contacto/');

// --- Hero con imagen de fondo -------------------------------------
$hero_bg = avemaria_field('sol_hero_bg', $pid) ?: avemaria_asset('img/HOME_5.jpg');
$hero_title_line1 = avemaria_field('sol_hero_title_line1', $pid, avemaria_t('Nuestro'));
$hero_title_green = avemaria_field('sol_hero_title_green', $pid, avemaria_t('Ecosistema'));
$hero_subtitle = avemaria_field('sol_hero_subtitle', $pid, avemaria_t('Soluciones integrales de personalización textil industrial — del diseño a la distribución, en una sola casa.'));

// --- "Por qué elegir Ave Maria" · 4 razones ------------------------------
$why_items = [
    [
        'icon'  => 'factory',
        'title' => avemaria_field('sol_why1_title', $pid, avemaria_t('Capacidad industrial')),
        'text'  => avemaria_field('sol_why1_text',  $pid, avemaria_t('Más de 5.000 prendas al día en producción continua con la máxima precisión y control.')),
    ],
    [
        'icon'  => 'award',
        'title' => avemaria_field('sol_why2_title', $pid, avemaria_t('Calidad premium')),
        'text'  => avemaria_field('sol_why2_text',  $pid, avemaria_t('Procesos certificados y control de calidad exhaustivo en cada etapa de la cadena.')),
    ],
    [
        'icon'  => 'bolt',
        'title' => avemaria_field('sol_why3_title', $pid, avemaria_t('Rapidez y flexibilidad')),
        'text'  => avemaria_field('sol_why3_text',  $pid, avemaria_t('Pedidos express, adaptación a picos de demanda y entregas ajustadas a tu calendario.')),
    ],
    [
        'icon'  => 'globe',
        'title' => avemaria_field('sol_why4_title', $pid, avemaria_t('Escala global')),
        'text'  => avemaria_field('sol_why4_text',  $pid, avemaria_t('Trabajamos con marcas y clubes en más de 20 países con logística integrada.')),
    ],
];

// --- 4 soluciones (filas zig-zag con número gigante) · TEXTOS CLIENTE ---
$solutions = [
    1 => [
        'num'    => '01',
        'label'  => avemaria_field('sol_r1_label', $pid, 'Rendimiento técnico'),
        'title'  => avemaria_field('sol_r1_title', $pid, 'Equipaciones deportivas <span class="text-green">personalizadas</span>'),
        'p1'     => avemaria_field('sol_r1_p1',    $pid, 'Personalizamos equipaciones para clubes, federaciones y marcas deportivas, combinando calidad técnica y acabados duraderos.'),
        'p2'     => avemaria_field('sol_r1_p2',    $pid, 'Trabajamos con los materiales y técnicas más exigentes del mercado para garantizar resistencia, ligereza y comodidad en el juego.'),
        'bullets'=> [avemaria_t('Clubes · federaciones · marcas'), avemaria_t('Calidad técnica certificada'), avemaria_t('Acabados resistentes al uso intensivo')],
        'img'    => avemaria_field('sol_r1_img',   $pid) ?: avemaria_asset('img/servicio-impresion.jpg'),
        'reverse'=> false,
    ],
    2 => [
        'num'    => '02',
        'label'  => avemaria_field('sol_r2_label', $pid, 'Identidad aplicada'),
        'title'  => avemaria_field('sol_r2_title', $pid, 'Merchandising para <span class="text-green">marcas y entidades</span>'),
        'p1'     => avemaria_field('sol_r2_p1',    $pid, 'Desarrollamos líneas de merchandising textil alineadas con la identidad de tu marca: del diseño a la producción final.'),
        'p2'     => avemaria_field('sol_r2_p2',    $pid, 'Camisetas, sudaderas, gorras y accesorios listos para tu tienda física, online o eventos corporativos.'),
        'bullets'=> [avemaria_t('Líneas completas de producto'), avemaria_t('Diseño alineado a tu marca'), avemaria_t('Producción flexible y escalable')],
        'img'    => avemaria_field('sol_r2_img',   $pid) ?: avemaria_asset('img/servicio-transfer.jpg'),
        'reverse'=> true,
    ],
    3 => [
        'num'    => '03',
        'label'  => avemaria_field('sol_r3_label', $pid, 'Imagen profesional'),
        'title'  => avemaria_field('sol_r3_title', $pid, 'Ropa corporativa y <span class="text-green">vestuario laboral</span>'),
        'p1'     => avemaria_field('sol_r3_p1',    $pid, 'Uniformidad y confort para equipos en oficina, campo o industria. Una imagen profesional que une al equipo y proyecta marca.'),
        'p2'     => avemaria_field('sol_r3_p2',    $pid, 'Adaptación a cualquier sector con tejidos técnicos, normativa EPI y personalización corporativa completa.'),
        'bullets'=> [avemaria_t('Uniformes oficina · campo · industria'), avemaria_t('Tejidos técnicos y normativa EPI'), avemaria_t('Personalización con bordado y transfer')],
        'img'    => avemaria_field('sol_r3_img',   $pid) ?: avemaria_asset('img/servicio-marcado.jpg'),
        'reverse'=> false,
    ],
    4 => [
        'num'    => '04',
        'label'  => avemaria_field('sol_r4_label', $pid, 'Acabados con diferenciación'),
        'title'  => avemaria_field('sol_r4_title', $pid, 'Parches y <span class="text-green">aplicaciones especiales</span>'),
        'p1'     => avemaria_field('sol_r4_p1',    $pid, 'Parches tejidos, bordados, transfer y combinaciones de técnicas que añaden carácter y diferenciación a cualquier prenda.'),
        'p2'     => avemaria_field('sol_r4_p2',    $pid, 'Acabados premium con compliance oficial deportivo (LaLiga, UEFA, Euroleague) y certificación textil industrial.'),
        'bullets'=> [avemaria_t('Parches tejidos · bordados · transfer'), avemaria_t('Combinaciones de técnicas'), avemaria_t('Compliance oficial deportivo')],
        'img'    => avemaria_field('sol_r4_img',   $pid) ?: avemaria_asset('img/TEC_5.jpg'),
        'reverse'=> true,
    ],
];

// --- SVGs iconos monoline del Why --------------------------------
$icons = [
    'factory' => '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 42V22l10 6V22l10 6V22l10 6v14z"/><path d="M6 42h36"/><rect x="14" y="34" width="4" height="8"/><rect x="22" y="34" width="4" height="8"/><rect x="30" y="34" width="4" height="8"/></svg>',
    'award'   => '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="24" cy="20" r="12"/><path d="M17 30l-4 14 11-6 11 6-4-14"/><path d="M19 20l4 4 6-8"/></svg>',
    'bolt'    => '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M26 4L10 26h10l-2 18 16-22H24z"/></svg>',
    'globe'   => '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="24" cy="24" r="20"/><path d="M4 24h40"/><path d="M24 4a30 30 0 010 40M24 4a30 30 0 000 40"/></svg>',
];
?>

    <!-- ====== HERO SOLUCIONES · full-bleed con imagen ================ -->
    <section class="sol-hero" data-bg="#000000">
        <div class="sol-hero__bg">
            <img src="<?php echo esc_url($hero_bg); ?>" alt="" class="sol-hero__bg-img">
            <div class="sol-hero__overlay" aria-hidden="true"></div>
        </div>
        <div class="sol-hero__container" data-animate="fadeInUp">
            <p class="section-label section-label--center"><?php echo esc_html(avemaria_t('Qué hacemos')); ?></p>
            <h1 class="sol-hero__title">
                <?php echo esc_html($hero_title_line1); ?>
                <span class="text-green"><?php echo esc_html($hero_title_green); ?></span>
            </h1>
            <p class="sol-hero__subtitle"><?php echo esc_html($hero_subtitle); ?></p>
            <div class="sol-hero__scroll" aria-hidden="true">
                <span><?php echo esc_html(avemaria_t('Scroll')); ?></span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <polyline points="19 12 12 19 5 12"></polyline>
                </svg>
            </div>
        </div>
    </section>


    <!-- ====== WHY Ave Maria · 4 razones ==================================== -->
    <section class="sol-why" data-bg="#0B1829">
        <div class="sol-why__container">
            <div class="sol-why__header" data-animate="fadeInUp">
                <p class="section-label"><?php echo esc_html(avemaria_t('Por qué Ave Maria')); ?></p>
                <h2 class="sol-why__title"><?php echo wp_kses_post(avemaria_t('Integración completa de <span class="text-green">producción, calidad y entrega</span>')); ?></h2>
            </div>
            <div class="sol-why__grid">
                <?php foreach ($why_items as $i => $w) : ?>
                <div class="sol-why__card" data-animate="fadeInUp" data-delay="<?php echo $i + 1; ?>">
                    <div class="sol-why__icon"><?php echo $icons[$w['icon']] ?? ''; ?></div>
                    <h3 class="sol-why__card-title"><?php echo esc_html($w['title']); ?></h3>
                    <p class="sol-why__card-text"><?php echo esc_html($w['text']); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>


    <!-- ====== 4 SOLUCIONES con STACK DE TÍTULOS ===================
         Las barras de título se van apilando arriba al hacer scroll.
         Cada barra aparece con fade cuando el sol-item correspondiente
         entra en viewport. Las secciones fluyen normalmente debajo. -->
    <div class="sol-items-wrap">

        <!-- Stack de barras fijas (position:fixed) que aparecen con fade.
             Cada barra hereda el color de su sol-item (blanco o negro). -->
        <div class="sol-stack" aria-hidden="true">
            <?php foreach ($solutions as $n => $sol) :
                $title_plain = trim(strip_tags($sol['title']));
                $bar_theme = ($n % 2 === 1) ? 'sol-stack__bar--light' : 'sol-stack__bar--dark';
                ?>
                <header class="sol-stack__bar <?php echo esc_attr($bar_theme); ?>" style="--i: <?php echo (int) $n; ?>" data-sol="<?php echo (int) $n; ?>">
                    <div class="sol-stack__bar-inner">
                        <span class="sol-stack__bar-num"><?php echo esc_html($sol['num']); ?></span>
                        <span class="sol-stack__bar-title"><?php echo esc_html($title_plain); ?></span>
                    </div>
                </header>
            <?php endforeach; ?>
        </div>

        <?php foreach ($solutions as $n => $sol) :
            $is_reverse = $sol['reverse'];
            $is_light = ($n % 2 === 1);
            $bg = $is_light ? '#ffffff' : '#000000';
            $theme = $is_light ? 'sol-item--light' : 'sol-item--dark';
            $classes = 'sol-item ' . $theme . ($is_reverse ? ' sol-item--reverse' : '');
            ?>
            <section class="<?php echo esc_attr($classes); ?>" data-bg="<?php echo esc_attr($bg); ?>" data-sol="<?php echo (int) $n; ?>" style="--i: <?php echo (int) $n; ?>">
                <div class="sol-item__container">
                    <div class="sol-item__visual">
                        <span class="sol-item__num" aria-hidden="true"><?php echo esc_html($sol['num']); ?></span>
                        <div class="sol-item__img-wrap">
                            <img src="<?php echo esc_url($sol['img']); ?>" alt="" class="sol-item__img">
                        </div>
                    </div>
                    <div class="sol-item__content">
                        <p class="section-label"><?php echo esc_html($sol['label']); ?></p>
                        <h2 class="sol-item__title"><?php echo wp_kses_post($sol['title']); ?></h2>
                        <p class="sol-item__text"><?php echo esc_html($sol['p1']); ?></p>
                        <p class="sol-item__text"><?php echo esc_html($sol['p2']); ?></p>
                        <?php if (!empty($sol['bullets'])) : ?>
                        <ul class="sol-item__bullets">
                            <?php foreach ($sol['bullets'] as $b) : ?>
                                <li><?php echo esc_html($b); ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <?php endif; ?>
                        <a href="<?php echo esc_url($contact_url); ?>" class="btn btn--primary"><?php echo esc_html(avemaria_t('Solicitar presupuesto')); ?></a>
                    </div>
                </div>
            </section>
        <?php endforeach; ?>
    </div>


    <!-- ====== CASES · 3 tarjetas con numeral gigante ================ -->
    <section class="sol-cases" data-bg="#0B1829">
        <div class="sol-cases__container">
            <div class="sol-cases__header" data-animate="fadeInUp">
                <p class="section-label section-label--center"><?php echo esc_html(avemaria_t('Casos reales')); ?></p>
                <h2 class="sol-cases__title"><?php echo wp_kses_post(avemaria_t('Proyectos que <span class="text-green">hablan por nosotros</span>')); ?></h2>
            </div>
            <div class="sol-cases__grid">
                <?php for ($i = 1; $i <= 3; $i++) : ?>
                <article class="sol-cases__card" data-animate="fadeInUp" data-delay="<?php echo $i; ?>">
                    <h3 class="sol-cases__card-title"><?php echo esc_html(avemaria_field("sol_case{$i}_title", $pid, 'Caso ' . $i)); ?></h3>
                    <p class="sol-cases__sub-label"><?php echo esc_html(avemaria_t('Solución')); ?></p>
                    <p class="sol-cases__sub-text"><?php echo esc_html(avemaria_field("sol_case{$i}_sol", $pid, '')); ?></p>
                    <p class="sol-cases__sub-label"><?php echo esc_html(avemaria_t('Resultado')); ?></p>
                    <p class="sol-cases__sub-text"><?php echo esc_html(avemaria_field("sol_case{$i}_res", $pid, '')); ?></p>
                </article>
                <?php endfor; ?>
            </div>
        </div>
    </section>


    <?php avemaria_cta_final(); ?>

<?php get_footer(); ?>
