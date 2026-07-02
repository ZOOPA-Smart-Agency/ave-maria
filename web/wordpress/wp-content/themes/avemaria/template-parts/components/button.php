<?php
/**
 * Componente: Botón
 * ---------------------------------------------------
 * Uso:
 *   get_template_part('template-parts/components/button', null, [
 *       'texto'       => 'Contáctanos',
 *       'enlace'      => '/contacto',
 *       'variante'    => 'primary',   // primary | secondary | ghost
 *       'tamano'      => 'md',        // sm | md | lg
 *       'icono'       => true,        // true | false
 *       'tipo'        => 'a',         // a | button | submit
 *       'disabled'    => false,
 *       'clase_extra' => '',
 *       'atributos'   => [],          // ej: ['target' => '_blank']
 *   ]);
 * ---------------------------------------------------
 *
 * @package Ave_Maria
 */

defined('ABSPATH') || exit;

// Props con valores por defecto
$texto       = $args['texto']       ?? 'Botón';
$enlace      = $args['enlace']      ?? '#';
$variante    = $args['variante']    ?? 'primary';
$tamano      = $args['tamano']      ?? 'md';
$icono       = $args['icono']       ?? false;
$tipo        = $args['tipo']        ?? 'a';
$disabled    = $args['disabled']    ?? false;
$clase_extra = $args['clase_extra'] ?? '';
$atributos   = $args['atributos']   ?? [];

// Validar variante y tamaño (fallback seguro)
$variantes_validas = ['primary', 'secondary', 'ghost'];
$tamanos_validos   = ['sm', 'md', 'lg'];
$tipos_validos     = ['a', 'button', 'submit'];

if (!in_array($variante, $variantes_validas, true)) {
    $variante = 'primary';
}
if (!in_array($tamano, $tamanos_validos, true)) {
    $tamano = 'md';
}
if (!in_array($tipo, $tipos_validos, true)) {
    $tipo = 'a';
}

// Construir clases
$clases = [
    'btn',
    'btn--' . $variante,
    'btn--' . $tamano,
];
if ($icono) {
    $clases[] = 'btn--has-icon';
}
if ($clase_extra) {
    $clases[] = $clase_extra;
}
$clases_str = implode(' ', array_map('sanitize_html_class', $clases));

// Construir atributos extra
$attrs_str = '';
foreach ($atributos as $key => $value) {
    $attrs_str .= ' ' . esc_attr($key) . '="' . esc_attr($value) . '"';
}

// Icono (flecha a la derecha)
$icono_svg = '';
if ($icono) {
    $icono_svg = '<svg class="btn__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>';
}

// Render según el tipo
if ($tipo === 'a') : ?>
    <a
        href="<?php echo esc_url($enlace); ?>"
        class="<?php echo esc_attr($clases_str); ?>"
        <?php echo $disabled ? 'aria-disabled="true" tabindex="-1"' : ''; ?>
        <?php echo $attrs_str; ?>
    >
        <span class="btn__label"><?php echo esc_html($texto); ?></span>
        <?php echo $icono_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — SVG estático controlado ?>
    </a>
<?php else : ?>
    <button
        type="<?php echo esc_attr($tipo); ?>"
        class="<?php echo esc_attr($clases_str); ?>"
        <?php echo $disabled ? 'disabled' : ''; ?>
        <?php echo $attrs_str; ?>
    >
        <span class="btn__label"><?php echo esc_html($texto); ?></span>
        <?php echo $icono_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — SVG estático controlado ?>
    </button>
<?php endif; ?>
