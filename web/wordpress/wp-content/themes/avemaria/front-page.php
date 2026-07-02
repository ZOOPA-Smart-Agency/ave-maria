<?php
/**
 * Front page — Ave Maria
 *
 * Sirve la maqueta SPA completa. Todo el HTML del body está en inc/mockup-body.html
 * (HTML puro, sin PHP embedido) y se sirve con readfile.
 */
get_header();
echo '<div id="avemaria-app">';
$mockup = get_template_directory() . '/inc/mockup-body.html';
if ( file_exists( $mockup ) ) {
    readfile( $mockup );
} else {
    echo '<p style="padding:40px">Fitxer de maqueta no trobat.</p>';
}
echo '</div>';
get_footer();
