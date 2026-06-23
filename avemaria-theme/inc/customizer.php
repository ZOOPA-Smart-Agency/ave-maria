<?php
/**
 * Camps editables de la portada (Personalitza).
 * Els valors per defecte vénen de inc/defaults.php (font única de veritat).
 *
 * @package avemaria
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ----- Funcions d'ajuda per registrar camps de manera curta ----- */

/**
 * Registra un camp de text. El valor per defecte s'agafa de avm_def( $id ).
 */
function avm_cz_text( $wp, $section, $id, $label, $type = 'text' ) {
	$sanitize = 'sanitize_text_field';
	$ctrl     = 'text';
	if ( 'textarea' === $type ) { $sanitize = 'wp_kses_post'; $ctrl = 'textarea'; }
	if ( 'url' === $type )      { $sanitize = 'esc_url_raw';   $ctrl = 'url'; }
	if ( 'number' === $type )   { $sanitize = 'absint';        $ctrl = 'number'; }

	$wp->add_setting( $id, array(
		'default'           => avm_def( $id ),
		'sanitize_callback' => $sanitize,
		'transport'         => 'refresh',
	) );
	$wp->add_control( $id, array(
		'label'   => $label,
		'section' => $section,
		'type'    => $ctrl,
	) );
}

function avm_cz_image( $wp, $section, $id, $label ) {
	$wp->add_setting( $id, array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp->add_control( new WP_Customize_Image_Control( $wp, $id, array(
		'label'   => $label,
		'section' => $section,
	) ) );
}

/* ----- Registre del panell i seccions ----- */

function avm_customize_register( $wp ) {

	$wp->add_panel( 'avm_home', array(
		'title'       => __( 'Inici · Ave Maria', 'avemaria' ),
		'description' => __( "Edita els textos i les imatges de la pàgina d'inici.", 'avemaria' ),
		'priority'    => 20,
	) );

	$S = function( $id, $title ) use ( $wp ) {
		$wp->add_section( $id, array( 'title' => $title, 'panel' => 'avm_home' ) );
	};

	/* ---------- CAPÇALERA ---------- */
	$S( 'avm_header', __( 'Capçalera', 'avemaria' ) );
	avm_cz_text( $wp, 'avm_header', 'header_cta_text', __( 'Botó (text)', 'avemaria' ) );
	avm_cz_text( $wp, 'avm_header', 'header_cta_url', __( 'Botó (enllaç)', 'avemaria' ), 'url' );

	/* ---------- HERO ---------- */
	$S( 'avm_hero', __( 'Hero (portada superior)', 'avemaria' ) );
	avm_cz_text( $wp, 'avm_hero', 'hero_eyebrow', __( 'Etiqueta superior', 'avemaria' ) );
	avm_cz_text( $wp, 'avm_hero', 'hero_title', __( 'Títol gran', 'avemaria' ) );
	avm_cz_text( $wp, 'avm_hero', 'hero_lede', __( 'Paràgraf', 'avemaria' ), 'textarea' );
	avm_cz_text( $wp, 'avm_hero', 'hero_btn1_text', __( 'Botó 1 (text)', 'avemaria' ) );
	avm_cz_text( $wp, 'avm_hero', 'hero_btn1_url', __( 'Botó 1 (enllaç)', 'avemaria' ), 'url' );
	avm_cz_text( $wp, 'avm_hero', 'hero_btn2_text', __( 'Botó 2 (text)', 'avemaria' ) );
	avm_cz_text( $wp, 'avm_hero', 'hero_btn2_url', __( 'Botó 2 (enllaç)', 'avemaria' ), 'url' );
	avm_cz_image( $wp, 'avm_hero', 'hero_image', __( 'Imatge principal', 'avemaria' ) );
	for ( $i = 1; $i <= 4; $i++ ) {
		avm_cz_text( $wp, 'avm_hero', "hero_meta{$i}_k", sprintf( __( 'Dada %d — etiqueta', 'avemaria' ), $i ) );
		avm_cz_text( $wp, 'avm_hero', "hero_meta{$i}_v", sprintf( __( 'Dada %d — valor', 'avemaria' ), $i ) );
	}

	/* ---------- IMPACTE ---------- */
	$S( 'avm_impacte', __( 'Impacte (xifres)', 'avemaria' ) );
	avm_cz_text( $wp, 'avm_impacte', 'imp_title', __( 'Títol', 'avemaria' ) );
	avm_cz_text( $wp, 'avm_impacte', 'imp_desc', __( 'Descripció', 'avemaria' ), 'textarea' );
	for ( $i = 1; $i <= 6; $i++ ) {
		avm_cz_text( $wp, 'avm_impacte', "stat{$i}_value", sprintf( __( 'Xifra %d — número', 'avemaria' ), $i ) );
		avm_cz_text( $wp, 'avm_impacte', "stat{$i}_label", sprintf( __( 'Xifra %d — text', 'avemaria' ), $i ) );
	}

	/* ---------- SERVEIS ---------- */
	$S( 'avm_serveis', __( 'Serveis', 'avemaria' ) );
	avm_cz_text( $wp, 'avm_serveis', 'ser_title', __( 'Títol', 'avemaria' ) );
	avm_cz_text( $wp, 'avm_serveis', 'ser_desc', __( 'Descripció', 'avemaria' ), 'textarea' );
	for ( $i = 1; $i <= 6; $i++ ) {
		avm_cz_text( $wp, 'avm_serveis', "servei{$i}_num", sprintf( __( 'Servei %d — número', 'avemaria' ), $i ) );
		avm_cz_text( $wp, 'avm_serveis', "servei{$i}_title", sprintf( __( 'Servei %d — títol', 'avemaria' ), $i ) );
		avm_cz_text( $wp, 'avm_serveis', "servei{$i}_text", sprintf( __( 'Servei %d — text', 'avemaria' ), $i ), 'textarea' );
		avm_cz_text( $wp, 'avm_serveis', "servei{$i}_link", sprintf( __( 'Servei %d — enllaç', 'avemaria' ), $i ), 'url' );
		avm_cz_image( $wp, 'avm_serveis', "servei{$i}_img", sprintf( __( 'Servei %d — foto', 'avemaria' ), $i ) );
	}

	/* ---------- TRAJECTÒRIA ---------- */
	$S( 'avm_traj', __( 'Història i trajectòria', 'avemaria' ) );
	avm_cz_text( $wp, 'avm_traj', 'traj_title', __( 'Títol', 'avemaria' ) );
	avm_cz_text( $wp, 'avm_traj', 'traj_desc', __( 'Descripció', 'avemaria' ), 'textarea' );
	for ( $i = 1; $i <= 3; $i++ ) {
		avm_cz_text( $wp, 'avm_traj', "traj{$i}_year", sprintf( __( 'Fita %d — any', 'avemaria' ), $i ) );
		avm_cz_text( $wp, 'avm_traj', "traj{$i}_org", sprintf( __( 'Fita %d — entitat', 'avemaria' ), $i ) );
		avm_cz_text( $wp, 'avm_traj', "traj{$i}_title", sprintf( __( 'Fita %d — títol', 'avemaria' ), $i ) );
		avm_cz_text( $wp, 'avm_traj', "traj{$i}_text", sprintf( __( 'Fita %d — text', 'avemaria' ), $i ), 'textarea' );
	}

	/* ---------- CITA ---------- */
	$S( 'avm_quote', __( 'Cita (Transparència)', 'avemaria' ) );
	avm_cz_text( $wp, 'avm_quote', 'quote_text', __( 'Cita', 'avemaria' ), 'textarea' );
	avm_cz_text( $wp, 'avm_quote', 'quote_author', __( 'Nom', 'avemaria' ) );
	avm_cz_text( $wp, 'avm_quote', 'quote_role', __( 'Càrrec', 'avemaria' ) );
	avm_cz_image( $wp, 'avm_quote', 'quote_img', __( 'Foto', 'avemaria' ) );

	/* ---------- DONACIÓ ---------- */
	$S( 'avm_don', __( 'Crida a donar', 'avemaria' ) );
	avm_cz_text( $wp, 'avm_don', 'don_title', __( 'Títol', 'avemaria' ) );
	avm_cz_text( $wp, 'avm_don', 'don_text', __( 'Text', 'avemaria' ), 'textarea' );
	avm_cz_text( $wp, 'avm_don', 'don_btn_text', __( 'Botó (text)', 'avemaria' ) );
	avm_cz_text( $wp, 'avm_don', 'don_btn_url', __( 'Botó (enllaç)', 'avemaria' ), 'url' );
	avm_cz_text( $wp, 'avm_don', 'don_nota', __( 'Nota', 'avemaria' ) );

	/* ---------- TESTIMONIS ---------- */
	$S( 'avm_testi', __( 'Testimonis', 'avemaria' ) );
	avm_cz_text( $wp, 'avm_testi', 'testi_title', __( 'Títol', 'avemaria' ) );
	avm_cz_text( $wp, 'avm_testi', 'testi_desc', __( 'Descripció', 'avemaria' ), 'textarea' );
	for ( $i = 1; $i <= 3; $i++ ) {
		avm_cz_text( $wp, 'avm_testi', "testi{$i}_text", sprintf( __( 'Testimoni %d — text', 'avemaria' ), $i ), 'textarea' );
		avm_cz_text( $wp, 'avm_testi', "testi{$i}_name", sprintf( __( 'Testimoni %d — nom', 'avemaria' ), $i ) );
		avm_cz_text( $wp, 'avm_testi', "testi{$i}_role", sprintf( __( 'Testimoni %d — càrrec', 'avemaria' ), $i ) );
	}

	/* ---------- NOTÍCIES ---------- */
	$S( 'avm_news', __( 'Notícies', 'avemaria' ) );
	avm_cz_text( $wp, 'avm_news', 'news_title', __( 'Títol', 'avemaria' ) );
	avm_cz_text( $wp, 'avm_news', 'news_desc', __( 'Descripció', 'avemaria' ), 'textarea' );
	avm_cz_text( $wp, 'avm_news', 'news_count', __( 'Quantes notícies mostrar', 'avemaria' ), 'number' );
	avm_cz_text( $wp, 'avm_news', 'news_link_text', __( 'Enllaç inferior (text)', 'avemaria' ) );
	avm_cz_text( $wp, 'avm_news', 'news_link_url', __( 'Enllaç inferior (URL)', 'avemaria' ), 'url' );

	/* ---------- PEU ---------- */
	$S( 'avm_footer', __( 'Peu de pàgina', 'avemaria' ) );
	avm_cz_text( $wp, 'avm_footer', 'foot_about', __( 'Text de marca', 'avemaria' ), 'textarea' );
	avm_cz_text( $wp, 'avm_footer', 'foot_col1_title', __( 'Columna 1 — títol', 'avemaria' ) );
	avm_cz_text( $wp, 'avm_footer', 'foot_col2_title', __( 'Columna 2 — títol', 'avemaria' ) );
	avm_cz_text( $wp, 'avm_footer', 'foot_contact_title', __( 'Columna 3 — títol', 'avemaria' ) );
	avm_cz_text( $wp, 'avm_footer', 'foot_contact', __( 'Contacte (una dada per línia)', 'avemaria' ), 'textarea' );
	avm_cz_text( $wp, 'avm_footer', 'foot_copy', __( 'Copyright', 'avemaria' ) );
}
add_action( 'customize_register', 'avm_customize_register' );
