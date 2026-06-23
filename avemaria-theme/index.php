<?php
/**
 * Plantilla de reserva: llistat d'entrades, arxius i cerca.
 *
 * @package avemaria
 */

get_header();

// Títol contextual.
if ( is_home() ) {
	$title = single_post_title( '', false ) ? single_post_title( '', false ) : 'Actualitat';
	$crumb = 'Actualitat';
} elseif ( is_search() ) {
	$title = sprintf( 'Cerca: %s', get_search_query() );
	$crumb = 'Cerca';
} elseif ( is_archive() ) {
	$title = get_the_archive_title();
	$crumb = 'Arxiu';
} else {
	$title = 'Actualitat';
	$crumb = 'Actualitat';
}
?>
<main id="top">
	<header class="page-head wrap">
		<p class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Inici</a> / <?php echo esc_html( $crumb ); ?></p>
		<h1><?php echo wp_kses_post( $title ); ?></h1>
	</header>

	<div class="section" style="padding-top:54px">
		<div class="wrap">
			<?php if ( have_posts() ) : ?>
				<div class="news-grid">
					<?php $d = 0; while ( have_posts() ) : the_post(); ?>
						<article class="news reveal"<?php echo $d ? ' data-d="' . esc_attr( $d ) . '"' : ''; ?>>
							<a href="<?php the_permalink(); ?>">
								<?php avm_photo( get_the_post_thumbnail_url( get_the_ID(), 'avm-card' ), '', 'Foto notícia' ); ?>
								<span class="date"><?php echo esc_html( get_the_date() ); ?></span>
								<h3><?php the_title(); ?></h3>
							</a>
						</article>
					<?php $d = ( $d + 1 ) % 3; endwhile; ?>
				</div>

				<div style="margin-top:54px">
					<?php the_posts_pagination( array( 'mid_size' => 1, 'prev_text' => '← Anteriors', 'next_text' => 'Següents →' ) ); ?>
				</div>
			<?php else : ?>
				<p>No hi ha entrades publicades encara.</p>
			<?php endif; ?>
		</div>
	</div>
</main>
<?php
get_footer();
