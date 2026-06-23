<?php
/**
 * Capçalera del lloc.
 *
 * @package avemaria
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site">
	<div class="inner">
		<div class="brand">
			<?php avm_branding(); ?>
		</div>
		<div class="spacer"></div>

		<?php if ( has_nav_menu( 'primary' ) ) : ?>
			<nav class="main" aria-label="<?php esc_attr_e( 'Menú principal', 'avemaria' ); ?>">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'menu',
					'depth'          => 1,
				) );
				?>
			</nav>
		<?php else : ?>
			<nav class="main" aria-label="<?php esc_attr_e( 'Menú principal', 'avemaria' ); ?>">
				<ul class="menu">
					<li><a href="<?php echo esc_url( home_url( '/qui-som/' ) ); ?>">Qui Som</a></li>
					<li><a href="<?php echo esc_url( home_url( '/serveis/' ) ); ?>">Serveis</a></li>
					<li><a href="<?php echo esc_url( home_url( '/collabora/' ) ); ?>">Col·labora</a></li>
					<li><a href="<?php echo esc_url( home_url( '/actualitat/' ) ); ?>">Actualitat</a></li>
					<li><a href="<?php echo esc_url( home_url( '/contacte/' ) ); ?>">Contacte</a></li>
				</ul>
			</nav>
		<?php endif; ?>

		<div class="lang"><button class="on" type="button">CA</button><span>/</span><button type="button">ES</button></div>

		<a href="<?php echo esc_url( avm_mod( 'header_cta_url', '#' ) ); ?>" class="cta"><?php echo esc_html( avm_mod( 'header_cta_text', 'Fes un donatiu' ) ); ?></a>

		<button class="menu-btn" type="button" aria-label="<?php esc_attr_e( 'Menú', 'avemaria' ); ?>">Menú</button>
	</div>
</header>
