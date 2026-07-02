<?php
/**
 * ACF Field Group — CPT Servei
 *
 * @package Ave_Maria
 */

defined( 'ABSPATH' ) || exit;

acf_add_local_field_group( [
    'key'      => 'group_avemaria_servei',
    'title'    => 'Servei — Contingut',
    'location' => [ [ [ 'param' => 'post_type', 'operator' => '==', 'value' => 'servei' ] ] ],
    'fields'   => [

        // --- Identificació ---
        [ 'key' => 'field_servei_titol_ca', 'label' => 'Títol (CA)', 'name' => 'titol_ca', 'type' => 'text' ],
        [ 'key' => 'field_servei_titol_es', 'label' => 'Título (ES)', 'name' => 'titol_es', 'type' => 'text' ],
        [ 'key' => 'field_servei_subtitol_ca', 'label' => 'Subtítol (CA)', 'name' => 'subtitol_ca', 'type' => 'text' ],
        [ 'key' => 'field_servei_subtitol_es', 'label' => 'Subtítulo (ES)', 'name' => 'subtitol_es', 'type' => 'text' ],
        [ 'key' => 'field_servei_numero', 'label' => 'Número (01, 02…)', 'name' => 'numero', 'type' => 'text' ],
        [ 'key' => 'field_servei_color', 'label' => 'Color d\'accent', 'name' => 'color', 'type' => 'select',
            'choices' => [ 'taronja' => 'Taronja', 'verd' => 'Verd', 'blau' => 'Blau', 'groc' => 'Groc', 'rosa' => 'Rosa', 'coral' => 'Coral' ],
            'default_value' => 'taronja',
        ],
        [ 'key' => 'field_servei_imatge_hero', 'label' => 'Imatge hero', 'name' => 'imatge_hero', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium' ],

        // --- Intro editorial ---
        [ 'key' => 'field_servei_intro_eyebrow_ca', 'label' => 'Intro eyebrow (CA)', 'name' => 'intro_eyebrow_ca', 'type' => 'text' ],
        [ 'key' => 'field_servei_intro_eyebrow_es', 'label' => 'Intro eyebrow (ES)', 'name' => 'intro_eyebrow_es', 'type' => 'text' ],
        [ 'key' => 'field_servei_intro_titol_ca', 'label' => 'Intro títol (CA)', 'name' => 'intro_titol_ca', 'type' => 'text' ],
        [ 'key' => 'field_servei_intro_titol_es', 'label' => 'Intro título (ES)', 'name' => 'intro_titol_es', 'type' => 'text' ],
        [ 'key' => 'field_servei_intro_lede_ca', 'label' => 'Intro lede (CA)', 'name' => 'intro_lede_ca', 'type' => 'textarea', 'rows' => 3 ],
        [ 'key' => 'field_servei_intro_lede_es', 'label' => 'Intro lede (ES)', 'name' => 'intro_lede_es', 'type' => 'textarea', 'rows' => 3 ],
        [ 'key' => 'field_servei_intro_text_ca', 'label' => 'Intro text (CA)', 'name' => 'intro_text_ca', 'type' => 'wysiwyg', 'tabs' => 'visual', 'toolbar' => 'basic', 'media_upload' => 0 ],
        [ 'key' => 'field_servei_intro_text_es', 'label' => 'Intro texto (ES)', 'name' => 'intro_text_es', 'type' => 'wysiwyg', 'tabs' => 'visual', 'toolbar' => 'basic', 'media_upload' => 0 ],

        // --- Cita ---
        [ 'key' => 'field_servei_cita_ca', 'label' => 'Cita destacada (CA)', 'name' => 'cita_destacada_ca', 'type' => 'textarea', 'rows' => 3 ],
        [ 'key' => 'field_servei_cita_es', 'label' => 'Cita destacada (ES)', 'name' => 'cita_destacada_es', 'type' => 'textarea', 'rows' => 3 ],

        // --- Què oferim ---
        [ 'key' => 'field_servei_que_oferim_titol_ca', 'label' => 'Què oferim — títol (CA)', 'name' => 'que_oferim_titol_ca', 'type' => 'text' ],
        [ 'key' => 'field_servei_que_oferim_titol_es', 'label' => 'Qué ofrecemos — título (ES)', 'name' => 'que_oferim_titol_es', 'type' => 'text' ],

        // --- Per a qui ---
        [ 'key' => 'field_servei_per_qui_titol_ca', 'label' => 'Per a qui — títol (CA)', 'name' => 'per_qui_titol_ca', 'type' => 'text' ],
        [ 'key' => 'field_servei_per_qui_titol_es', 'label' => 'Para quién — título (ES)', 'name' => 'per_qui_titol_es', 'type' => 'text' ],

        // --- Stats ---
        [ 'key' => 'field_servei_stats_titol_ca', 'label' => 'Stats — títol (CA)', 'name' => 'stats_titol_ca', 'type' => 'text' ],
        [ 'key' => 'field_servei_stats_titol_es', 'label' => 'Stats — título (ES)', 'name' => 'stats_titol_es', 'type' => 'text' ],
        [ 'key' => 'field_servei_stat_1_numero', 'label' => 'Stat 1 — número', 'name' => 'stat_1_numero', 'type' => 'text' ],
        [ 'key' => 'field_servei_stat_1_label_ca', 'label' => 'Stat 1 — label (CA)', 'name' => 'stat_1_label_ca', 'type' => 'text' ],
        [ 'key' => 'field_servei_stat_1_label_es', 'label' => 'Stat 1 — label (ES)', 'name' => 'stat_1_label_es', 'type' => 'text' ],
        [ 'key' => 'field_servei_stat_2_numero', 'label' => 'Stat 2 — número', 'name' => 'stat_2_numero', 'type' => 'text' ],
        [ 'key' => 'field_servei_stat_2_label_ca', 'label' => 'Stat 2 — label (CA)', 'name' => 'stat_2_label_ca', 'type' => 'text' ],
        [ 'key' => 'field_servei_stat_2_label_es', 'label' => 'Stat 2 — label (ES)', 'name' => 'stat_2_label_es', 'type' => 'text' ],
        [ 'key' => 'field_servei_stat_3_numero', 'label' => 'Stat 3 — número', 'name' => 'stat_3_numero', 'type' => 'text' ],
        [ 'key' => 'field_servei_stat_3_label_ca', 'label' => 'Stat 3 — label (CA)', 'name' => 'stat_3_label_ca', 'type' => 'text' ],
        [ 'key' => 'field_servei_stat_3_label_es', 'label' => 'Stat 3 — label (ES)', 'name' => 'stat_3_label_es', 'type' => 'text' ],

        // --- CTA ---
        [ 'key' => 'field_servei_cta_boto_ca', 'label' => 'CTA botó (CA)', 'name' => 'cta_boto_ca', 'type' => 'text' ],
        [ 'key' => 'field_servei_cta_boto_es', 'label' => 'CTA botón (ES)', 'name' => 'cta_boto_es', 'type' => 'text' ],
        [ 'key' => 'field_servei_cta_url', 'label' => 'CTA URL', 'name' => 'cta_url', 'type' => 'url' ],

        // --- Scroller card (home) ---
        [ 'key' => 'field_servei_descripcio_scroller_ca', 'label' => 'Descripció scroller (CA)', 'name' => 'descripcio_scroller_ca', 'type' => 'textarea', 'rows' => 3 ],
        [ 'key' => 'field_servei_descripcio_scroller_es', 'label' => 'Descripción scroller (ES)', 'name' => 'descripcio_scroller_es', 'type' => 'textarea', 'rows' => 3 ],
    ],
] );
