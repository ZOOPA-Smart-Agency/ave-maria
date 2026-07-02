<?php
/**
 * ACF Field Group — Home (front-page)
 *
 * Se muestra sólo en la página marcada como "Página de inicio" en Ajustes → Lectura.
 *
 * @package Ave_Maria
 */

defined( 'ABSPATH' ) || exit;

acf_add_local_field_group( [
    'key'      => 'group_avemaria_home',
    'title'    => 'Home — Contingut',
    'location' => [ [ [ 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ] ] ],
    'fields'   => [

        // ===== HERO =====
        [ 'key' => 'field_home_tab_hero', 'label' => 'Hero', 'type' => 'tab' ],
        [ 'key' => 'field_home_hero_titol_ca', 'label' => 'Hero — títol (CA)', 'name' => 'hero_titol_ca', 'type' => 'text' ],
        [ 'key' => 'field_home_hero_titol_es', 'label' => 'Hero — título (ES)', 'name' => 'hero_titol_es', 'type' => 'text' ],
        [ 'key' => 'field_home_hero_subtitol_ca', 'label' => 'Hero — subtítol (CA)', 'name' => 'hero_subtitol_ca', 'type' => 'text' ],
        [ 'key' => 'field_home_hero_subtitol_es', 'label' => 'Hero — subtítulo (ES)', 'name' => 'hero_subtitol_es', 'type' => 'text' ],
        [ 'key' => 'field_home_hero_descripcio_ca', 'label' => 'Hero — descripció (CA)', 'name' => 'hero_descripcio_ca', 'type' => 'wysiwyg', 'tabs' => 'visual', 'toolbar' => 'basic', 'media_upload' => 0 ],
        [ 'key' => 'field_home_hero_descripcio_es', 'label' => 'Hero — descripción (ES)', 'name' => 'hero_descripcio_es', 'type' => 'wysiwyg', 'tabs' => 'visual', 'toolbar' => 'basic', 'media_upload' => 0 ],
        [ 'key' => 'field_home_hero_imatge', 'label' => 'Hero — imatge', 'name' => 'hero_imatge', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium' ],
        [ 'key' => 'field_home_hero_boto_serveis_ca', 'label' => 'Botó "Serveis" (CA)', 'name' => 'hero_boto_serveis_ca', 'type' => 'text' ],
        [ 'key' => 'field_home_hero_boto_serveis_es', 'label' => 'Botón "Servicios" (ES)', 'name' => 'hero_boto_serveis_es', 'type' => 'text' ],
        [ 'key' => 'field_home_hero_boto_serveis_url', 'label' => 'Botó serveis — URL', 'name' => 'hero_boto_serveis_url', 'type' => 'url' ],
        [ 'key' => 'field_home_hero_card_text_ca', 'label' => 'Card flotant — text (CA)', 'name' => 'hero_card_text_ca', 'type' => 'text' ],
        [ 'key' => 'field_home_hero_card_text_es', 'label' => 'Card flotante — texto (ES)', 'name' => 'hero_card_text_es', 'type' => 'text' ],
        [ 'key' => 'field_home_hero_card_boto_ca', 'label' => 'Card flotant — botó (CA)', 'name' => 'hero_card_boto_ca', 'type' => 'text' ],
        [ 'key' => 'field_home_hero_card_boto_es', 'label' => 'Card flotante — botón (ES)', 'name' => 'hero_card_boto_es', 'type' => 'text' ],
        [ 'key' => 'field_home_hero_card_boto_url', 'label' => 'Card flotant — URL', 'name' => 'hero_card_boto_url', 'type' => 'url' ],

        // ===== TICKER =====
        [ 'key' => 'field_home_tab_ticker', 'label' => 'Ticker', 'type' => 'tab' ],
        [ 'key' => 'field_home_ticker_ca', 'label' => 'Frase ticker (CA)', 'name' => 'ticker_frase_ca', 'type' => 'textarea', 'rows' => 2 ],
        [ 'key' => 'field_home_ticker_es', 'label' => 'Frase ticker (ES)', 'name' => 'ticker_frase_es', 'type' => 'textarea', 'rows' => 2 ],

        // ===== IMPACTE =====
        [ 'key' => 'field_home_tab_impacte', 'label' => 'Impacte', 'type' => 'tab' ],
        [ 'key' => 'field_home_impacte_eyebrow_ca', 'label' => 'Eyebrow (CA)', 'name' => 'impacte_eyebrow_ca', 'type' => 'text' ],
        [ 'key' => 'field_home_impacte_eyebrow_es', 'label' => 'Eyebrow (ES)', 'name' => 'impacte_eyebrow_es', 'type' => 'text' ],
        [ 'key' => 'field_home_impacte_titol_ca', 'label' => 'Títol (CA)', 'name' => 'impacte_titol_ca', 'type' => 'text' ],
        [ 'key' => 'field_home_impacte_titol_es', 'label' => 'Título (ES)', 'name' => 'impacte_titol_es', 'type' => 'text' ],

        // ===== SERVEIS =====
        [ 'key' => 'field_home_tab_serveis', 'label' => 'Serveis', 'type' => 'tab' ],
        [ 'key' => 'field_home_serveis_eyebrow_ca', 'label' => 'Eyebrow (CA)', 'name' => 'serveis_eyebrow_ca', 'type' => 'text' ],
        [ 'key' => 'field_home_serveis_eyebrow_es', 'label' => 'Eyebrow (ES)', 'name' => 'serveis_eyebrow_es', 'type' => 'text' ],
        [ 'key' => 'field_home_serveis_titol_ca', 'label' => 'Títol (CA)', 'name' => 'serveis_titol_ca', 'type' => 'text' ],
        [ 'key' => 'field_home_serveis_titol_es', 'label' => 'Título (ES)', 'name' => 'serveis_titol_es', 'type' => 'text' ],
        [ 'key' => 'field_home_serveis_descripcio_ca', 'label' => 'Descripció (CA)', 'name' => 'serveis_descripcio_ca', 'type' => 'wysiwyg', 'tabs' => 'visual', 'toolbar' => 'basic', 'media_upload' => 0 ],
        [ 'key' => 'field_home_serveis_descripcio_es', 'label' => 'Descripción (ES)', 'name' => 'serveis_descripcio_es', 'type' => 'wysiwyg', 'tabs' => 'visual', 'toolbar' => 'basic', 'media_upload' => 0 ],

        // ===== HISTÒRIA =====
        [ 'key' => 'field_home_tab_historia', 'label' => 'Història', 'type' => 'tab' ],
        [ 'key' => 'field_home_historia_eyebrow_ca', 'label' => 'Eyebrow (CA)', 'name' => 'historia_eyebrow_ca', 'type' => 'text' ],
        [ 'key' => 'field_home_historia_eyebrow_es', 'label' => 'Eyebrow (ES)', 'name' => 'historia_eyebrow_es', 'type' => 'text' ],
        [ 'key' => 'field_home_historia_titol_ca', 'label' => 'Títol (CA)', 'name' => 'historia_titol_ca', 'type' => 'text' ],
        [ 'key' => 'field_home_historia_titol_es', 'label' => 'Título (ES)', 'name' => 'historia_titol_es', 'type' => 'text' ],

        // ===== MANIFEST =====
        [ 'key' => 'field_home_tab_manifest', 'label' => 'Manifest', 'type' => 'tab' ],
        [ 'key' => 'field_home_manifest_titol_ca', 'label' => 'Manifest (CA)', 'name' => 'manifest_titol_ca', 'type' => 'wysiwyg', 'tabs' => 'visual', 'toolbar' => 'basic', 'media_upload' => 0 ],
        [ 'key' => 'field_home_manifest_titol_es', 'label' => 'Manifest (ES)', 'name' => 'manifest_titol_es', 'type' => 'wysiwyg', 'tabs' => 'visual', 'toolbar' => 'basic', 'media_upload' => 0 ],

        // ===== CTA DONACIÓ =====
        [ 'key' => 'field_home_tab_cta', 'label' => 'CTA Donació', 'type' => 'tab' ],
        [ 'key' => 'field_home_cta_titol_ca', 'label' => 'Títol (CA)', 'name' => 'cta_donacio_titol_ca', 'type' => 'text' ],
        [ 'key' => 'field_home_cta_titol_es', 'label' => 'Título (ES)', 'name' => 'cta_donacio_titol_es', 'type' => 'text' ],
        [ 'key' => 'field_home_cta_text_ca', 'label' => 'Text (CA)', 'name' => 'cta_donacio_text_ca', 'type' => 'wysiwyg', 'tabs' => 'visual', 'toolbar' => 'basic', 'media_upload' => 0 ],
        [ 'key' => 'field_home_cta_text_es', 'label' => 'Texto (ES)', 'name' => 'cta_donacio_text_es', 'type' => 'wysiwyg', 'tabs' => 'visual', 'toolbar' => 'basic', 'media_upload' => 0 ],
        [ 'key' => 'field_home_cta_boto_ca', 'label' => 'Botó (CA)', 'name' => 'cta_donacio_boto_ca', 'type' => 'text' ],
        [ 'key' => 'field_home_cta_boto_es', 'label' => 'Botón (ES)', 'name' => 'cta_donacio_boto_es', 'type' => 'text' ],
        [ 'key' => 'field_home_cta_url', 'label' => 'CTA URL', 'name' => 'cta_donacio_url', 'type' => 'url' ],

        // ===== VEUS (testimonis) =====
        [ 'key' => 'field_home_tab_veus', 'label' => 'Veus', 'type' => 'tab' ],
        [ 'key' => 'field_home_veus_eyebrow_ca', 'label' => 'Eyebrow (CA)', 'name' => 'veus_eyebrow_ca', 'type' => 'text' ],
        [ 'key' => 'field_home_veus_eyebrow_es', 'label' => 'Eyebrow (ES)', 'name' => 'veus_eyebrow_es', 'type' => 'text' ],
        [ 'key' => 'field_home_veus_titol_ca', 'label' => 'Títol (CA)', 'name' => 'veus_titol_ca', 'type' => 'text' ],
        [ 'key' => 'field_home_veus_titol_es', 'label' => 'Título (ES)', 'name' => 'veus_titol_es', 'type' => 'text' ],

        // ===== ACTUALITAT =====
        [ 'key' => 'field_home_tab_actualitat', 'label' => 'Actualitat', 'type' => 'tab' ],
        [ 'key' => 'field_home_actualitat_eyebrow_ca', 'label' => 'Eyebrow (CA)', 'name' => 'actualitat_eyebrow_ca', 'type' => 'text' ],
        [ 'key' => 'field_home_actualitat_eyebrow_es', 'label' => 'Eyebrow (ES)', 'name' => 'actualitat_eyebrow_es', 'type' => 'text' ],
        [ 'key' => 'field_home_actualitat_titol_ca', 'label' => 'Títol (CA)', 'name' => 'actualitat_titol_ca', 'type' => 'text' ],
        [ 'key' => 'field_home_actualitat_titol_es', 'label' => 'Título (ES)', 'name' => 'actualitat_titol_es', 'type' => 'text' ],
        [ 'key' => 'field_home_actualitat_descripcio_ca', 'label' => 'Descripció (CA)', 'name' => 'actualitat_descripcio_ca', 'type' => 'text' ],
        [ 'key' => 'field_home_actualitat_descripcio_es', 'label' => 'Descripción (ES)', 'name' => 'actualitat_descripcio_es', 'type' => 'text' ],

        // ===== ALIANCES =====
        [ 'key' => 'field_home_tab_aliances', 'label' => 'Aliances', 'type' => 'tab' ],
        [ 'key' => 'field_home_aliances_eyebrow_ca', 'label' => 'Eyebrow (CA)', 'name' => 'aliances_eyebrow_ca', 'type' => 'text' ],
        [ 'key' => 'field_home_aliances_eyebrow_es', 'label' => 'Eyebrow (ES)', 'name' => 'aliances_eyebrow_es', 'type' => 'text' ],
        [ 'key' => 'field_home_aliances_titol_ca', 'label' => 'Títol (CA)', 'name' => 'aliances_titol_ca', 'type' => 'text' ],
        [ 'key' => 'field_home_aliances_titol_es', 'label' => 'Título (ES)', 'name' => 'aliances_titol_es', 'type' => 'text' ],
    ],
] );
