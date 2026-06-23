<?php
/**
 * Portada (pàgina d'inici).
 *
 * @package avemaria
 */

get_header();
?>

<main id="top">

	<?php /* ============ HERO ============ */ ?>
	<section class="hero">
		<div class="wrap">
			<div class="top">
				<div class="reveal">
					<span class="eyebrow"><?php
						$eyebrow = esc_html( avm_mod( 'hero_eyebrow', 'Fundació Ave Maria · Sitges, des de 1987' ) );
						echo str_replace( ' · ', ' <span class="ac">·</span> ', $eyebrow );
					?></span>
					<h1><?php echo esc_html( avm_mod( 'hero_title', "Donant suport a l'autonomia personal." ) ); ?></h1>
				</div>
				<div class="reveal" data-d="1">
					<p class="lede"><?php echo esc_html( avm_mod( 'hero_lede' ) ); ?></p>
					<div class="hero-cta">
						<a href="<?php echo esc_url( avm_mod( 'hero_btn1_url', '#donar' ) ); ?>" class="btn btn-primary"><?php echo esc_html( avm_mod( 'hero_btn1_text', 'Col·labora →' ) ); ?></a>
						<a href="<?php echo esc_url( avm_mod( 'hero_btn2_url', '#serveis' ) ); ?>" class="btn btn-ghost"><?php echo esc_html( avm_mod( 'hero_btn2_text', 'Els nostres serveis' ) ); ?></a>
					</div>
				</div>
			</div>

			<?php $hero_img = avm_mod( 'hero_image' ); ?>
			<div class="stage photo reveal<?php echo $hero_img ? '' : ' empty'; ?>" data-d="2"<?php echo $hero_img ? '' : ' data-label="Imatge principal"'; ?>>
				<?php if ( $hero_img ) : ?><img src="<?php echo esc_url( $hero_img ); ?>" alt=""><?php endif; ?>
			</div>

			<div class="meta reveal">
				<?php for ( $i = 1; $i <= 4; $i++ ) :
					$k = avm_mod( "hero_meta{$i}_k" );
					$v = avm_mod( "hero_meta{$i}_v" );
					if ( $k || $v ) : ?>
						<div><span class="k"><?php echo esc_html( $k ); ?></span><span class="v"><?php echo esc_html( $v ); ?></span></div>
				<?php endif; endfor; ?>
			</div>
		</div>
	</section>

	<?php /* ============ IMPACTE ============ */ ?>
	<section class="section" id="impacte">
		<div class="wrap">
			<div class="sec-head reveal">
				<span class="num">01</span>
				<h2><?php echo esc_html( avm_mod( 'imp_title', 'El nostre impacte' ) ); ?></h2>
				<?php if ( avm_mod( 'imp_desc' ) ) : ?><p class="desc"><?php echo esc_html( avm_mod( 'imp_desc' ) ); ?></p><?php endif; ?>
			</div>
			<div class="stats">
				<?php for ( $i = 1; $i <= 6; $i++ ) :
					$val = avm_mod( "stat{$i}_value" );
					$lab = avm_mod( "stat{$i}_label" );
					if ( ! $val && ! $lab ) { continue; }
					// Separa un possible prefix "+" perquè surti en verd.
					$pre = '';
					if ( '' !== $val && '+' === substr( $val, 0, 1 ) ) {
						$pre = '+';
						$val = substr( $val, 1 );
					}
					$d = ( $i % 3 );
					?>
					<div class="stat reveal"<?php echo $d ? ' data-d="' . esc_attr( $d ) . '"' : ''; ?>>
						<div class="num"><?php if ( $pre ) : ?><span class="s"><?php echo esc_html( $pre ); ?></span><?php endif; ?><?php echo esc_html( $val ); ?></div>
						<p><?php echo esc_html( $lab ); ?></p>
					</div>
				<?php endfor; ?>
			</div>
		</div>
	</section>

	<?php /* ============ SERVEIS ============ */ ?>
	<section class="section" id="serveis">
		<div class="wrap">
			<div class="sec-head reveal">
				<span class="num">02</span>
				<h2><?php echo esc_html( avm_mod( 'ser_title', 'Els nostres serveis' ) ); ?></h2>
				<?php if ( avm_mod( 'ser_desc' ) ) : ?><p class="desc"><?php echo esc_html( avm_mod( 'ser_desc' ) ); ?></p><?php endif; ?>
			</div>
			<div class="serveis-grid">
				<?php for ( $i = 1; $i <= 6; $i++ ) :
					$title = avm_mod( "servei{$i}_title" );
					if ( ! $title ) { continue; }
					$d = ( $i % 3 ); ?>
					<article class="servei reveal"<?php echo $d ? ' data-d="' . esc_attr( $d ) . '"' : ''; ?>>
						<?php avm_photo( avm_mod( "servei{$i}_img" ), '', 'Foto' ); ?>
						<span class="n"><?php echo esc_html( avm_mod( "servei{$i}_num" ) ); ?></span>
						<h3><?php echo esc_html( $title ); ?></h3>
						<p><?php echo esc_html( avm_mod( "servei{$i}_text" ) ); ?></p>
						<a href="<?php echo esc_url( avm_mod( "servei{$i}_link", '#' ) ); ?>" class="link-arrow">Més informació →</a>
					</article>
				<?php endfor; ?>
			</div>
		</div>
	</section>

	<?php /* ============ TRAJECTÒRIA ============ */ ?>
	<section class="section" id="trajectoria">
		<div class="wrap">
			<div class="sec-head reveal">
				<span class="num">03</span>
				<h2><?php echo esc_html( avm_mod( 'traj_title', 'Història i trajectòria' ) ); ?></h2>
				<?php if ( avm_mod( 'traj_desc' ) ) : ?><p class="desc"><?php echo esc_html( avm_mod( 'traj_desc' ) ); ?></p><?php endif; ?>
			</div>
			<div class="traj">
				<?php for ( $i = 1; $i <= 3; $i++ ) :
					$year = avm_mod( "traj{$i}_year" );
					if ( ! $year ) { continue; }
					$d = ( $i - 1 ); ?>
					<div class="card reveal"<?php echo $d ? ' data-d="' . esc_attr( $d ) . '"' : ''; ?>>
						<span class="yr"><?php echo esc_html( $year ); ?></span>
						<span class="org"><?php echo esc_html( avm_mod( "traj{$i}_org" ) ); ?></span>
						<h3><?php echo esc_html( avm_mod( "traj{$i}_title" ) ); ?></h3>
						<p><?php echo esc_html( avm_mod( "traj{$i}_text" ) ); ?></p>
					</div>
				<?php endfor; ?>
			</div>
		</div>
	</section>

	<?php /* ============ CITA ============ */ ?>
	<?php if ( avm_mod( 'quote_text' ) ) : ?>
	<section class="section quote">
		<div class="wrap">
			<div class="inner reveal">
				<span class="mark">&ldquo;</span>
				<div>
					<blockquote><?php echo esc_html( avm_mod( 'quote_text' ) ); ?></blockquote>
					<div class="who">
						<?php avm_photo( avm_mod( 'quote_img' ), 'av', '' ); ?>
						<div><b><?php echo esc_html( avm_mod( 'quote_author' ) ); ?></b><span><?php echo esc_html( avm_mod( 'quote_role' ) ); ?></span></div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<?php /* ============ DONACIÓ ============ */ ?>
	<section class="section cta-don" id="donar">
		<div class="wrap">
			<div class="inner reveal">
				<div>
					<h2><?php echo esc_html( avm_mod( 'don_title', 'Amb la teva ajuda, tot és possible' ) ); ?></h2>
					<p><?php echo esc_html( avm_mod( 'don_text' ) ); ?></p>
				</div>
				<div class="right">
					<a href="<?php echo esc_url( avm_mod( 'don_btn_url', '#' ) ); ?>" class="btn btn-primary"><?php echo esc_html( avm_mod( 'don_btn_text', 'Vull fer un donatiu →' ) ); ?></a>
					<?php if ( avm_mod( 'don_nota' ) ) : ?><p class="nota"><?php echo esc_html( avm_mod( 'don_nota' ) ); ?></p><?php endif; ?>
				</div>
			</div>
		</div>
	</section>

	<?php /* ============ TESTIMONIS ============ */ ?>
	<section class="section">
		<div class="wrap">
			<div class="sec-head reveal">
				<span class="num">04</span>
				<h2><?php echo esc_html( avm_mod( 'testi_title', 'Històries reals' ) ); ?></h2>
				<?php if ( avm_mod( 'testi_desc' ) ) : ?><p class="desc"><?php echo esc_html( avm_mod( 'testi_desc' ) ); ?></p><?php endif; ?>
			</div>
			<div class="testi-grid">
				<?php for ( $i = 1; $i <= 3; $i++ ) :
					$text = avm_mod( "testi{$i}_text" );
					if ( ! $text ) { continue; }
					$d = ( $i - 1 ); ?>
					<div class="testi reveal"<?php echo $d ? ' data-d="' . esc_attr( $d ) . '"' : ''; ?>>
						<p>&ldquo;<?php echo esc_html( $text ); ?>&rdquo;</p>
						<div class="who"><b><?php echo esc_html( avm_mod( "testi{$i}_name" ) ); ?></b><span><?php echo esc_html( avm_mod( "testi{$i}_role" ) ); ?></span></div>
					</div>
				<?php endfor; ?>
			</div>
		</div>
	</section>

	<?php /* ============ NOTÍCIES ============ */ ?>
	<section class="section" id="actualitat">
		<div class="wrap">
			<div class="sec-head reveal">
				<span class="num">05</span>
				<h2><?php echo esc_html( avm_mod( 'news_title', 'Últimes notícies' ) ); ?></h2>
				<?php if ( avm_mod( 'news_desc' ) ) : ?><p class="desc"><?php echo esc_html( avm_mod( 'news_desc' ) ); ?></p><?php endif; ?>
			</div>
			<div class="news-grid">
				<?php
				$count = (int) avm_mod( 'news_count', 3 );
				$count = $count > 0 ? $count : 3;
				$q = new WP_Query( array(
					'post_type'           => 'post',
					'posts_per_page'      => $count,
					'ignore_sticky_posts' => true,
				) );
				if ( $q->have_posts() ) :
					$d = 0;
					while ( $q->have_posts() ) : $q->the_post(); ?>
						<article class="news reveal"<?php echo $d ? ' data-d="' . esc_attr( $d ) . '"' : ''; ?>>
							<a href="<?php the_permalink(); ?>">
								<?php avm_photo( get_the_post_thumbnail_url( get_the_ID(), 'avm-card' ), '', 'Foto notícia' ); ?>
								<span class="date"><?php echo esc_html( get_the_date() ); ?></span>
								<h3><?php the_title(); ?></h3>
							</a>
						</article>
					<?php $d = ( $d + 1 ) % 3;
					endwhile;
					wp_reset_postdata();
				else :
					// Exemple quan encara no hi ha notícies publicades.
					$demo = array(
						array( '20 gener 2026', "La Fundació posa en marxa el nou Servei d'Atenció Domiciliària" ),
						array( '18 desembre 2025', "Dues obres dels germans Grangel s'incorporen al Fons d'Art" ),
						array( '9 desembre 2025', "L'Ajuntament de Vilanova impulsa el projecte Benviure" ),
					);
					foreach ( $demo as $idx => $n ) : ?>
						<article class="news reveal"<?php echo $idx ? ' data-d="' . esc_attr( $idx ) . '"' : ''; ?>>
							<div class="photo empty" data-label="Foto notícia"></div>
							<span class="date"><?php echo esc_html( $n[0] ); ?></span>
							<h3><?php echo esc_html( $n[1] ); ?></h3>
						</article>
					<?php endforeach;
				endif; ?>
			</div>
			<?php if ( avm_mod( 'news_link_text' ) ) : ?>
				<div style="margin-top:44px"><a href="<?php echo esc_url( avm_mod( 'news_link_url', '#' ) ); ?>" class="link-arrow"><?php echo esc_html( avm_mod( 'news_link_text' ) ); ?></a></div>
			<?php endif; ?>
		</div>
	</section>

</main>

<?php get_footer(); ?>
