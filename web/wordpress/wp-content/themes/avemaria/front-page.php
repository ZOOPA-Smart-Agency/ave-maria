<?php
get_header();
echo '<div id="avemaria-app">';
$mockup = get_template_directory() . '/inc/mockup-body.html';
if ( file_exists( $mockup ) ) {
    $html = file_get_contents( $mockup );
    // Aplicar bloques dinámicos ANTES de textos/imágenes para que sus placeholders también se procesen
    if ( function_exists( 'avemaria_apply_blocks_to_html' ) ) $html = avemaria_apply_blocks_to_html( $html );
    $edit = function_exists( 'avemaria_is_edit_mode' ) && avemaria_is_edit_mode();
    if ( $edit ) {
        $html = avemaria_apply_texts_editmode( $html );
        $html = avemaria_apply_images_editmode( $html );
    } else {
        if ( function_exists( 'avemaria_apply_texts_to_html' ) ) $html = avemaria_apply_texts_to_html( $html );
        if ( function_exists( 'avemaria_apply_images_to_html' ) ) $html = avemaria_apply_images_to_html( $html );
    }
    echo $html;
}
echo '</div>';
get_footer();
