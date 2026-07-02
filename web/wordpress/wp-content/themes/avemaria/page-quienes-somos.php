<?php
/**
 * Template Name: Quiénes Somos
 * Rediseño con patrones premium: scroll-color sync, números gigantes,
 * cards spotlight, galería editorial.
 *
 * @package Ave_Maria
 */

get_header();
$pid = get_the_ID();
$contact_url = avemaria_page_url('contacto', '/contacto/');

$exp_img     = avemaria_field('qs_exp_img', $pid)     ?: avemaria_asset('img/HOME_1.jpg');
$taller_img1 = avemaria_field('qs_taller_img1', $pid) ?: avemaria_asset('img/HOME_1.jpg');
$taller_img2 = avemaria_field('qs_taller_img2', $pid) ?: avemaria_asset('img/HOME_2.jpg');
$taller_img3 = avemaria_field('qs_taller_img3', $pid) ?: avemaria_asset('img/HOME_3.jpg');
$prov_img    = avemaria_field('qs_prov_img', $pid)    ?: avemaria_asset('img/HOME_41.jpg');
?>

    <?php avemaria_page_hero(get_the_title(), ['green_word' => 'Somos']); ?>

    <!-- ====== 01 · HISTORIA / EXPERIENCIA (blanco) ====== -->
    <section class="qs-story" data-bg="#ffffff">
        <div class="qs-story__container">
            <div class="qs-story__meta" data-animate="fadeInLeft">
                <span class="qs-story__num">01</span>
                <p class="section-label"><?php echo esc_html(avemaria_field('qs_exp_label', $pid, 'Trayectoria comprobada')); ?></p>
            </div>
            <div class="qs-story__content" data-animate="fadeInLeft">
                <h2 class="qs-story__title"><?php echo wp_kses_post(avemaria_field('qs_exp_title', $pid, 'Experiencia y especialización al servicio de <span class="text-green">cada proyecto</span>')); ?></h2>
                <div class="qs-story__body">
                    <p><?php echo esc_html(avemaria_field('qs_exp_p1', $pid, 'Más de dos décadas trabajando con marcas líderes en personalización textil industrial de alto volumen.')); ?></p>
                    <p><?php echo esc_html(avemaria_field('qs_exp_p2', $pid, 'Nuestro equipo combina oficio artesanal y tecnología de última generación para entregar resultados de excelencia.')); ?></p>
                    <p><?php echo esc_html(avemaria_field('qs_exp_p3', $pid, 'Somos partners de clubes profesionales, cadenas de retail y marcas internacionales.')); ?></p>
                </div>
            </div>
            <div class="qs-story__visual" data-animate="fadeInRight">
                <img src="<?php echo esc_url($exp_img); ?>" alt="">
            </div>
        </div>
    </section>

    <!-- ====== 02 · EN NÚMEROS (negro · stats gigantes) ====== -->
    <section class="qs-stats" data-bg="#000000">
        <div class="qs-stats__container">
            <div class="qs-stats__header">
                <span class="qs-stats__num">02</span>
                <p class="section-label"><?php echo esc_html(avemaria_field('qs_stats_label', $pid, 'Ave Maria en números')); ?></p>
                <h2 class="qs-stats__title"><?php echo wp_kses_post(avemaria_field('qs_stats_title', $pid, 'Escala industrial, atención <span class="text-green">artesanal</span>')); ?></h2>
            </div>
            <div class="qs-stats__grid">
                <div class="qs-stats__item" data-animate="fadeInUp" data-delay="1">
                    <span class="qs-stats__value">
                        <span class="qs-stats__plus">+</span><span data-count="20">0</span>
                    </span>
                    <span class="qs-stats__label"><?php echo esc_html(avemaria_t('Años de experiencia')); ?></span>
                </div>
                <div class="qs-stats__item" data-animate="fadeInUp" data-delay="2">
                    <span class="qs-stats__value">
                        <span class="qs-stats__plus">+</span><span data-count="5000">0</span>
                    </span>
                    <span class="qs-stats__label"><?php echo esc_html(avemaria_t('Prendas al día')); ?></span>
                </div>
                <div class="qs-stats__item" data-animate="fadeInUp" data-delay="3">
                    <span class="qs-stats__value">
                        <span class="qs-stats__plus">+</span><span data-count="2000">0</span><span class="qs-stats__unit">m²</span>
                    </span>
                    <span class="qs-stats__label"><?php echo esc_html(avemaria_t('Instalaciones')); ?></span>
                </div>
                <div class="qs-stats__item" data-animate="fadeInUp" data-delay="4">
                    <span class="qs-stats__value">
                        <span class="qs-stats__plus">+</span><span data-count="40">0</span>
                    </span>
                    <span class="qs-stats__label"><?php echo esc_html(avemaria_t('Marcas clientes')); ?></span>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== 03 · ESTRUCTURA (blanco) ====== -->
    <section class="qs-struct" data-bg="#ffffff">
        <div class="qs-struct__container">
            <div class="qs-struct__meta" data-animate="fadeInUp">
                <span class="qs-struct__num">03</span>
                <p class="section-label"><?php echo esc_html(avemaria_field('qs_est_label', $pid, 'Capacidad operativa')); ?></p>
            </div>
            <div class="qs-struct__content" data-animate="fadeInUp">
                <h2 class="qs-struct__title"><?php echo wp_kses_post(avemaria_field('qs_est_title', $pid, 'Una estructura preparada para <span class="text-green">crecer</span> con nuestros clientes')); ?></h2>
                <div class="qs-struct__body">
                    <p><?php echo esc_html(avemaria_field('qs_est_p1', $pid, 'Departamentos especializados que cubren todo el ciclo: diseño, producción, control de calidad y logística.')); ?></p>
                    <p><?php echo esc_html(avemaria_field('qs_est_p2', $pid, 'Flexibilidad para adaptarnos desde proyectos pequeños y exclusivos hasta producciones industriales de alto volumen.')); ?></p>
                    <p><?php echo esc_html(avemaria_field('qs_est_p3', $pid, 'Procesos validados que garantizan plazos de entrega y consistencia en todas las tiradas.')); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== 04 · EQUIPO (negro · cards spotlight) ====== -->
    <section class="qs-team" data-bg="#000000">
        <div class="qs-team__container">
            <div class="qs-team__header" data-animate="fadeInUp">
                <span class="qs-team__num">04</span>
                <p class="section-label"><?php echo esc_html(avemaria_field('qs_team_label', $pid, 'Liderazgo')); ?></p>
                <h2 class="qs-team__title"><?php echo wp_kses_post(avemaria_field('qs_team_title', $pid, 'Nuestro <span class="text-green">equipo</span>')); ?></h2>
                <p class="qs-team__subtitle"><?php echo esc_html(avemaria_field('qs_team_subtitle', $pid, 'Un equipo multidisciplinar con décadas de experiencia combinada en personalización textil industrial.')); ?></p>
            </div>
            <div class="qs-team__grid">
                <?php
                $miembros = new WP_Query([
                    'post_type'      => 'avemaria_miembro',
                    'posts_per_page' => 12,
                    'orderby'        => 'menu_order',
                    'order'          => 'ASC',
                ]);

                $render_card = function ($iniciales, $nombre, $cargo, $delay) {
                    ?>
                    <div class="qs-team__card" data-animate="fadeInUp" data-delay="<?php echo esc_attr($delay); ?>">
                        <div class="qs-team__initials" aria-hidden="true"><?php echo esc_html($iniciales); ?></div>
                        <div class="qs-team__info">
                            <h3 class="qs-team__name"><?php echo esc_html($nombre); ?></h3>
                            <?php if ($cargo): ?>
                                <p class="qs-team__role"><?php echo esc_html($cargo); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php
                };

                if ($miembros->have_posts()) :
                    $delay = 0;
                    while ($miembros->have_posts()) : $miembros->the_post();
                        $delay++;
                        $iniciales = get_post_meta(get_the_ID(), '_cab_iniciales', true) ?: mb_substr(get_the_title(), 0, 1);
                        $cargo     = get_post_meta(get_the_ID(), '_cab_cargo', true);
                        $render_card($iniciales, get_the_title(), $cargo, $delay);
                    endwhile;
                    wp_reset_postdata();
                else :
                    $team = [
                        ['J',  'Juan',          'CEO'],
                        ['A',  'Aleix',         'COO'],
                        ['TM', 'Tomás Martí',   'Admin y Logística'],
                        ['AB', 'Alfredo Berca', 'Production Manager'],
                    ];
                    foreach ($team as $i => $m) {
                        $render_card($m[0], $m[1], $m[2], $i + 1);
                    }
                endif;
                ?>
            </div>
        </div>
    </section>

    <!-- ====== 05 · TALLER (negro · galería editorial) ====== -->
    <section class="qs-shop" data-bg="#000000">
        <div class="qs-shop__container">
            <div class="qs-shop__header" data-animate="fadeInUp">
                <span class="qs-shop__num">05</span>
                <p class="section-label"><?php echo esc_html(avemaria_field('qs_taller_label', $pid, 'Centro operativo')); ?></p>
                <h2 class="qs-shop__title"><?php echo wp_kses_post(avemaria_field('qs_taller_title', $pid, 'Nuestro <span class="text-green">taller</span>')); ?></h2>
            </div>
            <div class="qs-shop__gallery">
                <div class="qs-shop__img qs-shop__img--big" data-animate="fadeInUp" data-delay="1">
                    <img src="<?php echo esc_url($taller_img1); ?>" alt="">
                </div>
                <div class="qs-shop__img qs-shop__img--sm" data-animate="fadeInUp" data-delay="2">
                    <img src="<?php echo esc_url($taller_img2); ?>" alt="">
                </div>
                <div class="qs-shop__img qs-shop__img--sm" data-animate="fadeInUp" data-delay="3">
                    <img src="<?php echo esc_url($taller_img3); ?>" alt="">
                </div>
            </div>
            <div class="qs-shop__desc" data-animate="fadeInUp">
                <p><?php echo esc_html(avemaria_field('qs_taller_p1', $pid, 'Instalaciones diseñadas para compaginar producción industrial de alto volumen con proyectos exclusivos de gama premium.')); ?></p>
                <p><?php echo esc_html(avemaria_field('qs_taller_p2', $pid, 'Maquinaria de última generación, salas técnicas separadas y un equipo que controla cada paso del proceso.')); ?></p>
            </div>
        </div>
    </section>

    <!-- ====== 06 · MÁS QUE UN PROVEEDOR (blanco · manifiesto) ====== -->
    <section class="qs-manifest" data-bg="#ffffff">
        <div class="qs-manifest__container">
            <div class="qs-manifest__content" data-animate="fadeInLeft">
                <span class="qs-manifest__num">06</span>
                <p class="section-label"><?php echo esc_html(avemaria_field('qs_prov_label', $pid, 'Socio estratégico')); ?></p>
                <h2 class="qs-manifest__title"><?php echo wp_kses_post(avemaria_field('qs_prov_title', $pid, 'Más que un <span class="text-green">proveedor</span>')); ?></h2>
                <div class="qs-manifest__body">
                    <p><?php echo esc_html(avemaria_field('qs_prov_p1', $pid, 'Somos partner estratégico de cada proyecto. Acompañamos desde la idea hasta la entrega.')); ?></p>
                    <p><?php echo esc_html(avemaria_field('qs_prov_p2', $pid, 'Personalización textil industrial es nuestro oficio; excelencia operativa y trato cercano son nuestros pilares.')); ?></p>
                </div>
                <h3 class="qs-manifest__sub"><?php echo esc_html(avemaria_field('qs_prov_sub', $pid, 'Orientados a la excelencia')); ?></h3>
                <p class="qs-manifest__text"><?php echo esc_html(avemaria_field('qs_prov_p3', $pid, 'Cada prenda que sale de nuestro taller ha pasado por un control exigente. Ese es nuestro compromiso.')); ?></p>
                <a href="<?php echo esc_url($contact_url); ?>" class="btn btn--primary qs-manifest__cta"><?php echo esc_html(avemaria_t('Hablemos de tu proyecto')); ?></a>
            </div>
            <div class="qs-manifest__visual" data-animate="fadeInRight">
                <img src="<?php echo esc_url($prov_img); ?>" alt="">
            </div>
        </div>
    </section>

    <?php avemaria_cta_final(); ?>

<?php get_footer(); ?>
