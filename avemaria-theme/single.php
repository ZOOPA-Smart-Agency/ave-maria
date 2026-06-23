<?php
/**
 * Article individual (notícia).
 *
 * @package avemaria
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<main id="top">
		<header class="page-head wrap">
			<p class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Inici</a> / <span><?php echo esc_html( get_the_date() ); ?></span></p>
			<h1><?php the_title(); ?></h1>
		</header>

		<div class="section" style="padding-top:48px">
			<div class="wrap">
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="wrap" style="max-width:760px;padding:0;margin:0 auto 8px">
						<div class="photo" style="aspect-ratio:16/9;position:relative">
							<?php the_post_thumbnail( 'large' ); ?>
						</div>
					</div>
				<?php endif; ?>

				<article class="entry">
					<?php
					the_content();
					wp_link_pages();
					?>
				</article>

				<div class="wrap" style="max-width:760px;padding:0;margin:40px auto 0">
					<a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ? get_post_type_archive_link( 'post' ) : home_url( '/' ) ); ?>" class="link-arrow">← Totes les notícies</a>
				</div>
			</div>
		</div>
	</main>
	<?php
endwhile;

get_footer();
