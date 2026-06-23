<?php
/**
 * Valors per defecte de la portada (font única de veritat).
 *
 * Aquests valors els fan servir alhora:
 *  - la portada (front-page.php), perquè es vegi plena en una instal·lació nova;
 *  - el Customizer (inc/customizer.php), com a valor inicial de cada camp.
 *
 * @package avemaria
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Retorna l'array pla de valors per defecte (id => valor).
 */
function avm_defaults() {
	static $d = null;
	if ( null !== $d ) { return $d; }

	$d = array(
		// Capçalera.
		'header_cta_text' => 'Fes un donatiu',
		'header_cta_url'  => '#',

		// Hero.
		'hero_eyebrow'   => 'Fundació Ave Maria · Sitges, des de 1987',
		'hero_title'     => "Donant suport a l'autonomia personal.",
		'hero_lede'      => "Cuidem, acompanyem i impulsem projectes de vida de persones amb discapacitat intel·lectual i en situació de dependència. Oferim serveis residencials, atenció domiciliària, suport a les famílies i inclusió laboral, amb un model centrat en la persona.",
		'hero_btn1_text' => 'Col·labora →',
		'hero_btn1_url'  => '#donar',
		'hero_btn2_text' => 'Els nostres serveis',
		'hero_btn2_url'  => '#serveis',
		'hero_meta1_k'   => 'Ubicació',     'hero_meta1_v' => 'Sitges, Barcelona',
		'hero_meta2_k'   => 'Des de',       'hero_meta2_v' => '1987',
		'hero_meta3_k'   => 'Model',        'hero_meta3_v' => 'Atenció centrada en la persona',
		'hero_meta4_k'   => 'Qualitat',     'hero_meta4_v' => 'ISO 9001:2015',

		// Impacte.
		'imp_title' => 'El nostre impacte',
		'imp_desc'  => 'Gairebé quatre dècades al costat de les persones en situació de dependència.',
		'stat1_value' => '+39',      'stat1_label' => "Anys d'experiència",
		'stat2_value' => '+800',     'stat2_label' => 'Persones beneficiàries',
		'stat3_value' => '+200',     'stat3_label' => 'Entitats col·laboradores',
		'stat4_value' => '+110.000', 'stat4_label' => "Hores anuals d'atenció",
		'stat5_value' => '+95',      'stat5_label' => 'Professionals',
		'stat6_value' => 'ISO',      'stat6_label' => 'Certificació 9001:2015',

		// Serveis.
		'ser_title' => 'Els nostres serveis',
		'ser_desc'  => "Un model d'atenció integral i personalitzat, adaptat a les necessitats de cada persona.",
		'servei1_num' => '01', 'servei1_title' => 'Campus Residencial',           'servei1_link' => '#', 'servei1_text' => "Centre residencial al cor de Sitges, amb més de 3.000 m². Atenció integral i continuada les 24 hores, en un entorn segur i adaptat a cada persona.",
		'servei2_num' => '02', 'servei2_title' => 'Llars amb Suport',             'servei2_link' => '#', 'servei2_text' => "Xarxa d'habitatges integrats a la comunitat per a persones adultes que requereixen suports intermitents per a la seva vida autònoma.",
		'servei3_num' => '03', 'servei3_title' => 'Atenció Domiciliària',         'servei3_link' => '#', 'servei3_text' => "Suport a la llar per a persones grans i en situació de dependència: assistència en les activitats de la vida diària i acompanyament personal.",
		'servei4_num' => '04', 'servei4_title' => 'Centres de Dia',               'servei4_link' => '#', 'servei4_text' => "Serveis per a persones amb discapacitat intel·lectual lleu i persones grans, orientats a promoure l'autonomia personal i la participació social.",
		'servei5_num' => '05', 'servei5_title' => 'Famílies i Inclusió Laboral',  'servei5_link' => '#', 'servei5_text' => "Orientació, acompanyament i suport a famílies, i iniciatives de capacitació i inserció laboral en entorns ordinaris.",
		'servei6_num' => '06', 'servei6_title' => 'Recerca i Innovació',          'servei6_link' => '#', 'servei6_text' => "Projectes de recerca aplicada i solucions tecnològiques per millorar la qualitat de vida i l'atenció a persones en situació de dependència.",

		// Trajectòria.
		'traj_title' => 'Història i trajectòria',
		'traj_desc'  => "Entitats vinculades que impulsen projectes amb impacte social des de l'experiència en gestió.",
		'traj1_year' => '1987', 'traj1_org' => 'Fundació Ave Maria', 'traj1_title' => 'Creació de la Fundació Ave Maria',              'traj1_text' => "Inici de l'activitat assistencial orientada a l'atenció de persones amb discapacitat intel·lectual i en situació de dependència.",
		'traj2_year' => '2001', 'traj2_org' => 'Tu-i-Nos',          'traj2_title' => 'Fundació Tutelar del Garraf',                   'traj2_text' => "Entitat orientada al suport i acompanyament en l'exercici de la capacitat jurídica de persones amb discapacitat.",
		'traj3_year' => '2015', 'traj3_org' => 'iRD',               'traj3_title' => 'Institut de Robòtica per a la Dependència',      'traj3_text' => "Centre de recerca i innovació social especialitzat en solucions tecnològiques aplicades a l'àmbit de la dependència.",

		// Cita.
		'quote_text'   => 'Treballem per garantir una gestió responsable, transparent i orientada a generar un impacte social real en la vida de les persones que acompanyem.',
		'quote_author' => 'Jaume Cladellas',
		'quote_role'   => 'President del Patronat',

		// Donació.
		'don_title'    => 'Amb la teva ajuda, tot és possible',
		'don_text'     => 'Amb només 20€ al mes, una persona amb discapacitat intel·lectual pot participar en activitats de lleure i teràpies que milloren la seva qualitat de vida.',
		'don_btn_text' => 'Vull fer un donatiu →',
		'don_btn_url'  => '#',
		'don_nota'     => 'Desgrava fins al 80% a la renda',

		// Testimonis.
		'testi_title' => 'Històries reals',
		'testi_desc'  => 'Veus de les persones que formen part de la fundació.',
		'testi1_text' => "El meu fill ha trobat a l'Ave Maria una segona família. Després de 10 anys, veig com cada dia és més feliç i autònom.", 'testi1_name' => 'Maria López',     'testi1_role' => "Mare d'usuari",
		'testi2_text' => "Quan vaig arribar no coneixia ningú. Ara tinc molts amics i fem moltes coses junts. M'agrada anar a la piscina i fer teatre.", 'testi2_name' => 'Pere',             'testi2_role' => 'Usuari del Campus Residencial',
		'testi3_text' => "Com a voluntària, he rebut molt més del que he donat. Les persones de l'Ave Maria t'ensenyen a veure la vida d'una altra manera.", 'testi3_name' => 'Laia Martínez',    'testi3_role' => 'Voluntària',

		// Notícies.
		'news_title'     => 'Últimes notícies',
		'news_desc'      => "L'actualitat i el dia a dia de la Fundació Ave Maria.",
		'news_count'     => 3,
		'news_link_text' => 'Totes les notícies →',
		'news_link_url'  => '#',

		// Peu.
		'foot_about'         => 'Des del 1987 oferint atenció especialitzada a persones adultes amb discapacitat intel·lectual a Sitges.',
		'foot_col1_title'    => 'Serveis',
		'foot_col2_title'    => 'Col·labora',
		'foot_contact_title' => 'Contacte',
		'foot_contact'       => "Av. Artur Carbonell, 11, 08870 Sitges (Barcelona)\n938 94 86 46\ninfo@avemariafundacio.org",
		'foot_copy'          => '© 2026 Fundació Ave Maria de Sitges',
	);

	return $d;
}

/**
 * Valor per defecte d'un camp concret.
 */
function avm_def( $id ) {
	$d = avm_defaults();
	return isset( $d[ $id ] ) ? $d[ $id ] : '';
}
