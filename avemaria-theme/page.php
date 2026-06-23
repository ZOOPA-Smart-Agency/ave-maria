<?php
/**
 * Pàgina estàtica genèrica.
 *
 * @package avemaria
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<main id="top">
		<header class="page-head wrap">
			<p class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Inici</a> / <?php the_title(); ?></p>
			<h1><?php the_title(); ?></h1>
		</header>

		<div class="section" style="padding-top:0">
			<div class="wrap">
				<article class="entry">
					<?php
					the_content();
					wp_link_pages();
					?>
				</article>
			</div>
		</div>
	</main>
	<?php
endwhile;

get_footer();
