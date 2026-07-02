<?php
$pid = get_queried_object_id();
?>
<!-- Process section for home page · horizontal scroll pinned -->
<section class="process" id="proceso">
    <!-- Stop de color al INICIO (5%) para que el fondo cambie a blanco
         justo cuando la sección llega al viewport, no durante la animación horizontal -->
    <div class="process__stop" data-bg="#ffffff" style="top: 5%;"></div>
    <div class="process__sticky">
        <div class="process__header" data-animate="fadeInUp">
            <p class="section-label"><?php echo esc_html(avemaria_field('home_process_label', $pid, 'Nuestra metodología')); ?></p>
            <h2 class="section-title section-title--light"><?php echo wp_kses_post(avemaria_field('home_process_title', $pid, 'Proceso de trabajo<br><span class="text-green">en 7 pasos</span>')); ?></h2>
        </div>
        <div class="process__viewport">
            <div class="process__track">
                <?php
                $steps_defaults = [
                    ['01', 'Análisis',    'Evaluación de necesidades y planificación del proyecto.'],
                    ['02', 'Diseño',      'Propuestas visuales alineadas con tu identidad de marca.'],
                    ['03', 'Solución',    'Definición de la técnica de personalización óptima.'],
                    ['04', 'Materiales',  'Preparación y ajustes de formatos, colores y soportes.'],
                    ['05', 'Producción',  'Ejecución industrial con procesos controlados.'],
                    ['06', 'Control QC',  'Revisión sistemática antes de cada entrega.'],
                    ['07', 'Logística',   'Almacenaje, picking y distribución completa.'],
                ];
                foreach ($steps_defaults as $i => $d) :
                    $n = $i + 1;
                    $title = avemaria_field("home_step{$n}_title", $pid, $d[1]);
                    $text  = avemaria_field("home_step{$n}_text",  $pid, $d[2]);
                    ?>
                    <div class="process__step">
                        <span class="process__step-number"><?php echo esc_html($d[0]); ?></span>
                        <h3 class="process__step-title"><?php echo esc_html($title); ?></h3>
                        <p class="process__step-text"><?php echo esc_html($text); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
