<?php
/**
 * Editor de imágenes Ave Maria — versión completa
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function avemaria_default_images() {
    static $c = null; if ( $c !== null ) return $c;
    $p = get_template_directory() . '/inc/images-defaults.json';
    $c = file_exists( $p ) ? json_decode( file_get_contents( $p ), true ) : [];
    return is_array( $c ) ? $c : [];
}

function avemaria_get_images() {
    $d = avemaria_default_images();
    $o = get_option( 'avemaria_images', [] );
    if ( ! is_array( $o ) ) $o = [];
    $theme = get_template_directory_uri() . '/assets/img/';
    $out = [];
    foreach ( $d as $k => $data ) {
        $url = is_array( $data ) ? ( $data['url'] ?? '' ) : (string) $data;
        // absoluta ya (contiene //) o relativa al theme
        if ( ! preg_match( '~^https?://|^/wp-content/~', $url ) ) {
            $url = $theme . ltrim( $url, '/' );
        } elseif ( strpos( $url, '/wp-content/' ) === 0 ) {
            $url = home_url( $url );
        }
        $out[ $k ] = ! empty( $o[ $k ] ) ? $o[ $k ] : $url;
    }
    return $out;
}

add_action( 'admin_enqueue_scripts', function( $hook ) {
    if ( strpos( (string) $hook, 'avemaria-images' ) === false ) return;
    wp_enqueue_media();
} );

add_action( 'admin_init', function() {
    if ( ! isset( $_POST['avemaria_save_images'] ) ) return;
    if ( ! current_user_can( 'edit_theme_options' ) ) return;
    check_admin_referer( 'avemaria_save_images' );
    $o = [];
    foreach ( ( $_POST['img'] ?? [] ) as $k => $url ) {
        $url = esc_url_raw( $url );
        if ( ! empty( $url ) ) $o[ $k ] = $url;
    }
    update_option( 'avemaria_images', $o );
    wp_redirect( add_query_arg( 'saved', '1', admin_url( 'admin.php?page=avemaria-images' ) ) );
    exit;
} );

function avemaria_render_image_editor() {
    $d = avemaria_default_images();
    $o = get_option( 'avemaria_images', [] );
    if ( ! is_array( $o ) ) $o = [];
    $theme = get_template_directory_uri() . '/assets/img/';
    ?>
    <div class="wrap">
        <h1>🖼️ Editor d'imatges</h1>
        <?php if ( ! empty( $_GET['saved'] ) ): ?><div class="notice notice-success is-dismissible"><p><strong>Canvis guardats.</strong></p></div><?php endif; ?>
        <p style="max-width:820px"><?php echo count( $d ); ?> imatges de la web. Deixa el camp buit per restaurar l'original.</p>

        <form method="post" id="avemaria-img-form">
            <?php wp_nonce_field( 'avemaria_save_images' ); ?>
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:14px;margin-top:20px">
            <?php foreach ( $d as $k => $data ):
                $raw = is_array( $data ) ? ( $data['url'] ?? '' ) : (string) $data;
                $default_url = $raw;
                if ( ! preg_match( '~^https?://|^/wp-content/~', $default_url ) ) {
                    $default_url = $theme . ltrim( $default_url, '/' );
                } elseif ( strpos( $default_url, '/wp-content/' ) === 0 ) {
                    $default_url = home_url( $default_url );
                }
                $current = ! empty( $o[ $k ] ) ? $o[ $k ] : $default_url;
                $overridden = ! empty( $o[ $k ] );
                $filename = basename( $raw );
                $kind = is_array( $data ) ? ( $data['kind'] ?? '' ) : '';
            ?>
                <div style="background:#fff;border:1px solid #dcdcde;border-radius:6px;padding:10px" data-slot="<?php echo esc_attr( $k ); ?>">
                    <div class="preview" style="aspect-ratio:16/9;background:#f0f0f1 url('<?php echo esc_url( $current ); ?>') center/cover no-repeat;border-radius:4px;margin-bottom:8px"></div>
                    <div style="font-size:11px;color:#666;margin-bottom:3px"><strong><?php echo esc_html( $k ); ?></strong> · <?php echo esc_html( $filename ); ?><?php if ( $kind ) echo ' <span style="color:#999">('.esc_html($kind).')</span>'; ?></div>
                    <input type="hidden" name="img[<?php echo esc_attr( $k ); ?>]" value="<?php echo $overridden ? esc_url( $current ) : ''; ?>" class="url">
                    <button type="button" class="button button-small btn-pick" style="width:100%">Canviar</button>
                    <?php if ( $overridden ): ?><button type="button" class="button-link btn-reset" style="display:block;margin-top:4px;font-size:11px;color:#a00">↩️ Restaurar</button><?php endif; ?>
                </div>
            <?php endforeach; ?>
            </div>
            <div style="position:sticky;bottom:20px;background:#fff;padding:14px;border:2px solid #2271b1;border-radius:6px;text-align:right;margin-top:20px"><button type="submit" name="avemaria_save_images" class="button button-primary button-hero">💾 Guardar</button></div>
        </form>
        <script>
        (function(){
            const defaults = <?php
                $mp = [];
                foreach ( $d as $k => $data ) {
                    $raw = is_array( $data ) ? ( $data['url'] ?? '' ) : (string) $data;
                    if ( ! preg_match( '~^https?://|^/wp-content/~', $raw ) ) $raw = $theme . ltrim( $raw, '/' );
                    elseif ( strpos( $raw, '/wp-content/' ) === 0 ) $raw = home_url( $raw );
                    $mp[ $k ] = $raw;
                }
                echo wp_json_encode( $mp );
            ?>;
            document.querySelectorAll('.btn-pick').forEach(b=>b.addEventListener('click',function(){
                const s=this.closest('[data-slot]');
                const f=wp.media({title:'Selecciona imatge',multiple:false,library:{type:'image'}});
                f.on('select',()=>{const a=f.state().get('selection').first().toJSON();s.querySelector('.url').value=a.url;s.querySelector('.preview').style.backgroundImage="url('"+a.url+"')";});
                f.open();
            }));
            document.querySelectorAll('.btn-reset').forEach(b=>b.addEventListener('click',function(){
                const s=this.closest('[data-slot]');const k=s.dataset.slot;
                s.querySelector('.url').value='';s.querySelector('.preview').style.backgroundImage="url('"+defaults[k]+"')";
                this.style.display='none';
            }));
        })();
        </script>
    </div>
    <?php
}

function avemaria_apply_images_to_html( $html ) {
    $r = [];
    foreach ( avemaria_get_images() as $k => $url ) {
        $r[ '{{' . $k . '}}' ] = $url;
    }
    return strtr( $html, $r );
}
