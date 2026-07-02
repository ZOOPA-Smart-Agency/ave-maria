<?php
/**
 * Template Name: Procesos
 *
 * Scroll horizontal PINNED: una sección sticky donde los banners verticales
 * quedan fijos a la izquierda (texto rotado 90°) y el contenido de cada
 * proceso se desliza de DERECHA a IZQUIERDA con el scroll vertical.
 * El banner del proceso activo se resalta.
 *
 * @package Ave_Maria
 */

get_header();
$pid = get_the_ID();
$contact_url = avemaria_page_url('contacto', '/contacto/');

$default_imgs = [
    1 => avemaria_asset('img/TEC_1.jpg'),
    2 => avemaria_asset('img/TEC_3.jpg'),
    3 => avemaria_asset('img/TEC_4.jpg'),
    4 => avemaria_asset('img/TEC_5.jpg'),
    5 => avemaria_asset('img/HOME_1.jpg'),
    6 => avemaria_asset('img/HOME_2.jpg'),
    7 => avemaria_asset('img/HOME_5.jpg'),
];

// 7 procesos
$processes = [
    1 => [
        'num'    => '01',
        'label'  => avemaria_field('proc_1_label', $pid, 'Análisis'),
        'title'  => avemaria_field('proc_1_title', $pid, 'Análisis <span class="text-green">del proyecto</span>'),
        'p1'     => avemaria_field('proc_1_p1',    $pid, 'Evaluamos tus necesidades, calendario y objetivos de producción para diseñar un plan a medida. Entendemos volúmenes, técnicas necesarias y normativas aplicables.'),
        'p2'     => avemaria_field('proc_1_p2',    $pid, 'Nuestro equipo técnico revisa prototipos, identifica puntos críticos y propone la mejor estrategia antes de pasar a ejecución.'),
        'bullets'=> [avemaria_t('Reunión técnica con briefing'), avemaria_t('Revisión de volúmenes y calendario'), avemaria_t('Planificación a medida')],
        'img'    => avemaria_field('proc_1_img',   $pid) ?: $default_imgs[1],
    ],
    2 => [
        'num'    => '02',
        'label'  => avemaria_field('proc_2_label', $pid, 'Diseño'),
        'title'  => avemaria_field('proc_2_title', $pid, 'Diseño <span class="text-green">a medida</span>'),
        'p1'     => avemaria_field('proc_2_p1',    $pid, 'Propuestas visuales alineadas con tu identidad de marca, respetando las normativas oficiales y los requisitos del cliente final.'),
        'p2'     => avemaria_field('proc_2_p2',    $pid, 'Previsualizaciones digitales, prototipos físicos y ajustes iterativos hasta obtener el resultado perfecto antes de producir.'),
        'bullets'=> [avemaria_t('Propuestas visuales'), avemaria_t('Previsualización digital'), avemaria_t('Prototipos y ajustes')],
        'img'    => avemaria_field('proc_2_img',   $pid) ?: $default_imgs[2],
    ],
    3 => [
        'num'    => '03',
        'label'  => avemaria_field('proc_3_label', $pid, 'Solución'),
        'title'  => avemaria_field('proc_3_title', $pid, 'Solución <span class="text-green">técnica</span>'),
        'p1'     => avemaria_field('proc_3_p1',    $pid, 'Seleccionamos la técnica óptima — sublimación, transfer, bordado o combinación — según el soporte, volumen y calidad objetivo.'),
        'p2'     => avemaria_field('proc_3_p2',    $pid, 'Planificamos maquinaria, tintas y soportes para obtener la máxima calidad al mejor coste sin comprometer los plazos.'),
        'bullets'=> [avemaria_t('Análisis técnico detallado'), avemaria_t('Selección de maquinaria'), avemaria_t('Optimización de costes')],
        'img'    => avemaria_field('proc_3_img',   $pid) ?: $default_imgs[3],
    ],
    4 => [
        'num'    => '04',
        'label'  => avemaria_field('proc_4_label', $pid, 'Materiales'),
        'title'  => avemaria_field('proc_4_title', $pid, 'Materiales <span class="text-green">premium</span>'),
        'p1'     => avemaria_field('proc_4_p1',    $pid, 'Preparación y ajuste de formatos, colores Pantone exactos y soportes certificados con estándares industriales.'),
        'p2'     => avemaria_field('proc_4_p2',    $pid, 'Trabajamos con proveedores certificados y materiales de primera calidad — tejidos técnicos, tintas y consumibles premium.'),
        'bullets'=> [avemaria_t('Soportes certificados'), avemaria_t('Colores Pantone exactos'), avemaria_t('Proveedores premium')],
        'img'    => avemaria_field('proc_4_img',   $pid) ?: $default_imgs[4],
    ],
    5 => [
        'num'    => '05',
        'label'  => avemaria_field('proc_5_label', $pid, 'Producción'),
        'title'  => avemaria_field('proc_5_title', $pid, 'Producción <span class="text-green">industrial</span>'),
        'p1'     => avemaria_field('proc_5_p1',    $pid, 'Ejecución en nuestra planta con procesos controlados y capacidad para más de 5.000 prendas al día sin perder calidad.'),
        'p2'     => avemaria_field('proc_5_p2',    $pid, 'Maquinaria de última generación y equipo especializado para garantizar consistencia en cada prenda, lote tras lote.'),
        'bullets'=> [avemaria_t('+5.000 prendas/día'), avemaria_t('Maquinaria industrial'), avemaria_t('Procesos controlados')],
        'img'    => avemaria_field('proc_5_img',   $pid) ?: $default_imgs[5],
    ],
    6 => [
        'num'    => '06',
        'label'  => avemaria_field('proc_6_label', $pid, 'Control QC'),
        'title'  => avemaria_field('proc_6_title', $pid, 'Control <span class="text-green">de calidad</span>'),
        'p1'     => avemaria_field('proc_6_p1',    $pid, 'Revisión sistemática antes de cada entrega: colores, detalles, costuras, acabados y adherencia de transfers.'),
        'p2'     => avemaria_field('proc_6_p2',    $pid, 'Nuestro equipo QC inspecciona cada lote y aplica correcciones cuando son necesarias, garantizando la calidad acordada.'),
        'bullets'=> [avemaria_t('Inspección por lote'), avemaria_t('Trazabilidad completa'), avemaria_t('Corrección en tiempo real')],
        'img'    => avemaria_field('proc_6_img',   $pid) ?: $default_imgs[6],
    ],
    7 => [
        'num'    => '07',
        'label'  => avemaria_field('proc_7_label', $pid, 'Logística'),
        'title'  => avemaria_field('proc_7_title', $pid, 'Logística <span class="text-green">y entrega</span>'),
        'p1'     => avemaria_field('proc_7_p1',    $pid, 'Almacenaje, picking, embalaje y distribución con cobertura nacional e internacional adaptada a tu calendario.'),
        'p2'     => avemaria_field('proc_7_p2',    $pid, 'Gestión logística flexible: express, programada o just-in-time, con seguimiento y trazabilidad en todo momento.'),
        'bullets'=> [avemaria_t('Almacenaje y picking'), avemaria_t('Distribución global'), avemaria_t('Entregas express')],
        'img'    => avemaria_field('proc_7_img',   $pid) ?: $default_imgs[7],
    ],
];
$total = count($processes);
?>

    <!-- ====== HERO-INFOGRAFÍA · Entrada principal de la página ============
         Sustituye al page-hero genérico por una sección 100vh donde el título
         de la página se integra con la infografía timeline. Todo entra con
         animación escalonada cuando la página carga. -->
    <section class="proc-timeline proc-timeline--hero" data-bg="#000000">
        <div class="proc-timeline__container">
            <div class="proc-timeline__header">
                <p class="section-label section-label--center proc-timeline__label-top js-anim" style="--d: 0ms"><?php echo esc_html(avemaria_t('Nuestra metodología')); ?></p>
                <h1 class="proc-timeline__title js-anim" style="--d: 150ms">
                    <span class="text-green"><?php echo esc_html(avemaria_t('Procesos')); ?></span>
                </h1>
                <p class="proc-timeline__subtitle js-anim" style="--d: 280ms"><?php echo esc_html(avemaria_t('Siete procesos consecutivos diseñados para garantizar control total, eficiencia operativa y consistencia en cada proyecto de personalización.')); ?></p>
            </div>

            <div class="proc-timeline__track js-anim" style="--d: 420ms">
                <!-- Línea base gris (fondo del progreso) -->
                <div class="proc-timeline__line-bg"></div>
                <!-- Línea verde que se "dibuja" al entrar en viewport -->
                <div class="proc-timeline__line-fill"></div>

                <?php foreach ($processes as $n => $p) :
                    $step_name = trim(strip_tags($p['title']));
                    ?>
                    <div class="proc-timeline__step" style="--i: <?php echo (int) $n; ?>">
                        <div class="proc-timeline__node">
                            <span class="proc-timeline__num"><?php echo esc_html($p['num']); ?></span>
                        </div>
                        <p class="proc-timeline__label"><?php echo esc_html($step_name); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Scroll hint · indica al usuario que debe seguir scrolleando -->
        <div class="proc-timeline__scroll-hint js-anim" style="--d: 900ms" aria-hidden="true">
            <span class="proc-timeline__scroll-text"><?php echo esc_html(avemaria_t('Scroll')); ?></span>
            <svg class="proc-timeline__scroll-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <polyline points="19 12 12 19 5 12"></polyline>
            </svg>
        </div>
    </section>


    <!-- ====== SCROLL HORIZONTAL PINNED =================================
         · Los banners verticales quedan fijos a la izquierda.
         · El track (con 7 paneles) se desplaza de DERECHA a IZQUIERDA
           según el scroll vertical.
         · El banner del proceso activo se resalta en verde. -->
    <section class="proc-pinned" data-bg="#000000" data-total="<?php echo $total; ?>">
        <div class="proc-pinned__sticky">

            <!-- Banners verticales (texto rotado) · apilados horizontalmente · fijos a la izquierda
                 El título de la barra es el nombre completo del proceso (extraído del title). -->
            <aside class="proc-vbars" aria-hidden="true">
                <?php foreach ($processes as $n => $p) :
                    // Usamos el title completo (sin HTML) como nombre del proceso en la barra
                    $bar_title = trim(strip_tags($p['title']));
                    ?>
                    <div class="proc-vbar" data-i="<?php echo (int) $n; ?>" style="--i: <?php echo (int) $n; ?>">
                        <span class="proc-vbar__inner">
                            <span class="proc-vbar__num"><?php echo esc_html($p['num']); ?></span>
                            <span class="proc-vbar__title"><?php echo esc_html($bar_title); ?></span>
                        </span>
                    </div>
                <?php endforeach; ?>
            </aside>

            <!-- Track horizontal con un panel por proceso · se desplaza con scroll vertical.
                 Cada panel alterna tema light/dark igual que su franja lateral:
                 impar (1,3,5,7) = blanco · par (2,4,6) = negro. -->
            <div class="proc-track-wrap">
                <div class="proc-track" data-total="<?php echo $total; ?>">
                    <?php foreach ($processes as $n => $p) :
                        $is_light = ($n % 2 === 1);
                        $theme_cls = $is_light ? 'proc-panel--light' : 'proc-panel--dark';
                        ?>
                        <article class="proc-panel <?php echo esc_attr($theme_cls); ?>" data-i="<?php echo (int) $n; ?>">
                            <div class="proc-panel__visual">
                                <span class="proc-panel__num-bg"><?php echo esc_html($p['num']); ?></span>
                                <div class="proc-panel__img-wrap">
                                    <img src="<?php echo esc_url($p['img']); ?>" alt="" class="proc-panel__img">
                                </div>
                            </div>
                            <div class="proc-panel__content">
                                <h2 class="proc-panel__title"><?php echo wp_kses_post($p['title']); ?></h2>
                                <p class="proc-panel__text"><?php echo esc_html($p['p1']); ?></p>
                                <p class="proc-panel__text"><?php echo esc_html($p['p2']); ?></p>
                                <?php if (!empty($p['bullets'])) : ?>
                                <ul class="proc-panel__bullets">
                                    <?php foreach ($p['bullets'] as $b) : ?>
                                        <li><?php echo esc_html($b); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>


    <?php avemaria_cta_final(); ?>

<?php get_footer(); ?>
