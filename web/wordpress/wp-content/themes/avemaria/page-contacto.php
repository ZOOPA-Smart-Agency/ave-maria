<?php
/**
 * Template Name: Contacto
 *
 * @package Ave_Maria
 */

get_header();
$pid = get_the_ID();
$maps_url = avemaria_field('cont_map_url', $pid, 'https://www.google.com/maps/search/?api=1&query=Carrer+de+Pujades+77+08005+Barcelona');
$tel_raw  = avemaria_field('cont_tel_raw', $pid, '932500638');
$tel_disp = avemaria_field('cont_tel_display', $pid, '932 50 06 38');
$email    = avemaria_field('cont_email', $pid, 'info@cabglobal.es');
?>

    <!-- ====== HERO CONTACTO ====== -->
    <section class="ct-hero" data-bg="#000000">
        <div class="ct-hero__container">
            <p class="section-label"><?php echo esc_html(avemaria_t('Contacto')); ?></p>
            <h1 class="ct-hero__title">
                <?php echo esc_html(avemaria_field('cont_form_title_l1', $pid, 'Hablemos de')); ?>
                <span class="text-green"><?php echo esc_html(avemaria_field('cont_form_title_l2', $pid, 'tu proyecto')); ?></span>
            </h1>
            <p class="ct-hero__subtitle"><?php echo esc_html(avemaria_field('cont_form_desc', $pid, 'Cuéntanos tu idea y te proponemos la mejor solución de personalización textil para tu marca.')); ?></p>
        </div>
    </section>

    <!-- ====== FORM + INFO (split blanco) ====== -->
    <section class="ct-main" data-bg="#ffffff">
        <div class="ct-main__container">
            <div class="ct-main__grid">

                <!-- LEFT: Formulario -->
                <div class="ct-form-wrap" data-animate="fadeInUp">
                    <p class="section-label"><?php echo esc_html(avemaria_t('Escríbenos')); ?></p>
                    <h2 class="ct-form__heading"><?php echo esc_html(avemaria_t('Cuéntanos qué necesitas')); ?></h2>

                    <form method="post" action="<?php echo esc_url(get_permalink()); ?>" class="ct-form">
                        <?php wp_nonce_field('avemaria_contact_form', 'avemaria_contact_nonce'); ?>

                        <div class="ct-form__row">
                            <div class="ct-form__group">
                                <label for="avemaria-contact-name"><?php echo esc_html(avemaria_t('Nombre')); ?> *</label>
                                <input type="text" id="avemaria-contact-name" name="avemaria_nombre" autocomplete="name" placeholder="<?php echo esc_attr(avemaria_t('Tu nombre completo')); ?>" required>
                            </div>
                            <div class="ct-form__group">
                                <label for="avemaria-contact-empresa"><?php echo esc_html(avemaria_t('Empresa')); ?></label>
                                <input type="text" id="avemaria-contact-empresa" name="avemaria_empresa" autocomplete="organization" placeholder="<?php echo esc_attr(avemaria_t('Nombre de tu empresa')); ?>">
                            </div>
                        </div>

                        <div class="ct-form__row">
                            <div class="ct-form__group">
                                <label for="avemaria-contact-email"><?php echo esc_html(avemaria_t('Email')); ?> *</label>
                                <input type="email" id="avemaria-contact-email" name="avemaria_email" autocomplete="email" placeholder="tu@email.com" required>
                            </div>
                            <div class="ct-form__group">
                                <label for="avemaria-contact-tel"><?php echo esc_html(avemaria_t('Teléfono')); ?></label>
                                <input type="tel" id="avemaria-contact-tel" name="avemaria_telefono" autocomplete="tel" placeholder="+34 600 000 000">
                            </div>
                        </div>

                        <div class="ct-form__group">
                            <label for="avemaria-contact-msg"><?php echo esc_html(avemaria_t('Mensaje')); ?> *</label>
                            <textarea id="avemaria-contact-msg" name="avemaria_mensaje" placeholder="<?php echo esc_attr(avemaria_t('Cuéntanos sobre tu proyecto, volumen estimado, plazos…')); ?>" required></textarea>
                        </div>

                        <button type="submit" class="btn btn--primary btn--lg ct-form__submit">
                            <?php echo esc_html(avemaria_field('cont_form_submit', $pid, 'Enviar mensaje')); ?>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </button>
                    </form>
                </div>

                <!-- RIGHT: Info (3 tarjetas apiladas verticales) -->
                <aside class="ct-info" data-animate="fadeInUp" data-delay="2">
                    <div class="ct-info__card">
                        <div class="ct-info__icon" aria-hidden="true">
                            <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M24 4C16.27 4 10 10.27 10 18c0 11 14 26 14 26s14-15 14-26c0-7.73-6.27-14-14-14z"/><circle cx="24" cy="18" r="5"/></svg>
                        </div>
                        <h3 class="ct-info__title"><?php echo esc_html(avemaria_t('Dirección')); ?></h3>
                        <p class="ct-info__text">
                            <?php echo esc_html(avemaria_field('cont_addr_line1', $pid, 'Carrer Pujades 77, 1C')); ?><br>
                            <?php echo esc_html(avemaria_field('cont_addr_line2', $pid, '08005 Barcelona')); ?>
                        </p>
                    </div>

                    <div class="ct-info__card">
                        <div class="ct-info__icon" aria-hidden="true">
                            <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M44 34.6v5.4a3.6 3.6 0 01-3.93 3.6A35.64 35.64 0 014.4 7.93 3.6 3.6 0 018 4h5.4a3.6 3.6 0 013.6 3.09 23.13 23.13 0 001.26 5.06 3.6 3.6 0 01-.81 3.8l-2.29 2.29a28.8 28.8 0 0013.58 13.58l2.29-2.29a3.6 3.6 0 013.8-.81 23.13 23.13 0 005.06 1.26A3.6 3.6 0 0144 34.6z"/></svg>
                        </div>
                        <h3 class="ct-info__title"><?php echo esc_html(avemaria_t('Contacto directo')); ?></h3>
                        <p class="ct-info__text">
                            <a href="tel:<?php echo esc_attr($tel_raw); ?>"><?php echo esc_html($tel_disp); ?></a><br>
                            <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                        </p>
                    </div>

                    <div class="ct-info__card">
                        <div class="ct-info__icon" aria-hidden="true">
                            <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="24" cy="24" r="20"/><path d="M24 12v12l8 4"/></svg>
                        </div>
                        <h3 class="ct-info__title"><?php echo esc_html(avemaria_t('Horario')); ?></h3>
                        <p class="ct-info__text">
                            <?php echo esc_html(avemaria_t('Lunes a Jueves · 8:30 – 18:00')); ?><br>
                            <?php echo esc_html(avemaria_t('Viernes · 8:30 – 14:30')); ?>
                        </p>
                    </div>
                </aside>

            </div>
        </div>
    </section>

    <!-- ====== MAPA FULL-WIDTH + CARD OVERLAY ====== -->
    <section class="ct-location" data-bg="#000000">
        <!-- Mapa ocupando todo el ancho. El pin queda desplazado a la derecha
             (centro del mapa movido al oeste con el parámetro ll=). -->
        <div class="ct-location__map">
            <iframe
                src="https://www.google.com/maps?q=Carrer+Pujades+77,+08005+Barcelona&ll=41.402576,2.187&z=16&output=embed"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                title="<?php echo esc_attr(avemaria_t('Mapa de Fundació Ave Maria · Carrer Pujades 77, Barcelona')); ?>"
                allowfullscreen></iframe>
        </div>
        <!-- Halo verde encima del mapa para darle tono navy sutil -->
        <div class="ct-location__halo" aria-hidden="true"></div>
        <!-- Overlay con contenido textual flotante -->
        <div class="ct-location__overlay">
            <div class="ct-location__card" data-animate="fadeInLeft">
                <p class="section-label"><?php echo esc_html(avemaria_t('Encuéntranos')); ?></p>
                <h2 class="ct-location__title">
                    <?php echo wp_kses_post(avemaria_t('Carrer Pujades 77<br><span class="text-green">Barcelona</span>')); ?>
                </h2>
                <p class="ct-location__text">
                    <?php echo esc_html(avemaria_t('Nuestro taller central está en el corazón del 22@ de Barcelona, a 5 min del metro Llacuna (L4).')); ?>
                </p>
                <a href="<?php echo esc_url($maps_url); ?>" class="btn btn--primary" target="_blank" rel="noopener noreferrer">
                    <?php echo esc_html(avemaria_field('cont_map_link_text', $pid, 'Ver en Google Maps')); ?>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                </a>
            </div>
        </div>
    </section>

<?php get_footer(); ?>
