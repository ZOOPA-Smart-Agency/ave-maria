<?php
/**
 * Peu del lloc.
 *
 * @package avemaria
 */
?>

<footer class="site" id="contacte">
	<div class="wrap">
		<div class="fgrid">

			<div class="fbrand">
				<div class="iso"><?php echo avm_logo_svg(); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
				<p><?php echo esc_html( avm_mod( 'foot_about', 'Des del 1987 oferint atenció especialitzada a persones adultes amb discapacitat intel·lectual a Sitges.' ) ); ?></p>
			</div>

			<div>
				<h4><?php echo esc_html( avm_mod( 'foot_col1_title', 'Serveis' ) ); ?></h4>
				<?php if ( has_nav_menu( 'footer-1' ) ) : ?>
					<?php wp_nav_menu( array( 'theme_location' => 'footer-1', 'container' => false, 'depth' => 1 ) ); ?>
				<?php else : ?>
					<ul>
						<li><a href="#">Campus Residencial</a></li>
						<li><a href="#">Llars amb Suport</a></li>
						<li><a href="#">Atenció Domiciliària</a></li>
						<li><a href="#">Suport a Famílies</a></li>
						<li><a href="#">Inclusió Laboral</a></li>
					</ul>
				<?php endif; ?>
			</div>

			<div>
				<h4><?php echo esc_html( avm_mod( 'foot_col2_title', 'Col·labora' ) ); ?></h4>
				<?php if ( has_nav_menu( 'footer-2' ) ) : ?>
					<?php wp_nav_menu( array( 'theme_location' => 'footer-2', 'container' => false, 'depth' => 1 ) ); ?>
				<?php else : ?>
					<ul>
						<li><a href="#">Fes un donatiu</a></li>
						<li><a href="#">Voluntariat</a></li>
						<li><a href="#">Empreses i RSC</a></li>
						<li><a href="#">Llegats</a></li>
						<li><a href="#">Botiga solidària</a></li>
					</ul>
				<?php endif; ?>
			</div>

			<div>
				<h4><?php echo esc_html( avm_mod( 'foot_contact_title', 'Contacte' ) ); ?></h4>
				<ul>
					<?php
					$contact = avm_mod( 'foot_contact', "Av. Artur Carbonell, 11, 08870 Sitges (Barcelona)\n938 94 86 46\ninfo@avemariafundacio.org" );
					foreach ( preg_split( '/\r\n|\r|\n/', $contact ) as $line ) {
						$line = trim( $line );
						if ( $line ) {
							echo '<li><a href="#">' . esc_html( $line ) . '</a></li>';
						}
					}
					?>
				</ul>
			</div>

		</div>

		<div class="foot">
			<span><?php echo esc_html( avm_mod( 'foot_copy', '© 2026 Fundació Ave Maria de Sitges' ) ); ?></span>
			<?php if ( has_nav_menu( 'legal' ) ) : ?>
				<div class="legal"><?php wp_nav_menu( array( 'theme_location' => 'legal', 'container' => false, 'depth' => 1, 'items_wrap' => '%3$s' ) ); ?></div>
			<?php else : ?>
				<div class="legal"><a href="#">Avís legal</a><a href="#">Privacitat</a><a href="#">Cookies</a></div>
			<?php endif; ?>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
