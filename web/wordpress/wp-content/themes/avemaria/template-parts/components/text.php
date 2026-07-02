<?php
/**
 * Componente: Texto / Heading
 * ---------------------------------------------------
 * Sistema de 3 niveles: display | title | body
 *
 * Uso:
 *   get_template_part('template-parts/components/text', null, [
 *       'contenido'   => 'Título principal',
 *       'nivel'       => 'display',     // display | title | body
 *       'elemento'    => 'h1',          // h1..h6 | p | span | small | div
 *       'peso'        => 'bold',        // light | regular | semibold | bold | black
 *       'color'       => 'white',       // white green dark muted
 *       'alineacion'  => 'left',        // left | center | right
 *       'italic'      => false,
 *       'label'       => false,         // true → aplica estilo de label (uppercase + verde + tracking)
 *       'clase_extra' => '',
 *   ]);
 * ---------------------------------------------------
 *
 * @package Ave_Maria
 */

defined('ABSPATH') || exit;

// Props con valores por defecto
$contenido   = $args['contenido']   ?? '';
$nivel       = $args['nivel']       ?? 'body';
$elemento    = $args['elemento']    ?? null;
$peso        = $args['peso']        ?? null;
$color       = $args['color']       ?? 'white';
$alineacion  = $args['alineacion']  ?? 'left';
$italic      = $args['italic']      ?? false;
$label       = $args['label']       ?? false;
$clase_extra = $args['clase_extra'] ?? '';

// Listas válidas
$niveles_validos      = ['display', 'title', 'body'];
$elementos_validos    = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'span', 'small', 'div'];
$pesos_validos        = ['light', 'regular', 'semibold', 'bold', 'black'];
$colores_validos      = ['white', 'green', 'dark', 'muted'];
$alineaciones_validas = ['left', 'center', 'right'];

if (!in_array($nivel, $niveles_validos, true))          $nivel = 'body';
if (!in_array($color, $colores_validos, true))          $color = 'white';
if (!in_array($alineacion, $alineaciones_validas, true)) $alineacion = 'left';

// Defaults inteligentes por nivel
$defaults = [
    'display' => ['elemento' => 'h2', 'peso' => 'bold'],
    'title'   => ['elemento' => 'h3', 'peso' => 'bold'],
    'body'    => ['elemento' => 'p',  'peso' => 'regular'],
];
if (!$elemento) $elemento = $defaults[$nivel]['elemento'];
if (!$peso)     $peso     = $defaults[$nivel]['peso'];

if (!in_array($elemento, $elementos_validos, true)) $elemento = $defaults[$nivel]['elemento'];
if (!in_array($peso, $pesos_validos, true))         $peso     = $defaults[$nivel]['peso'];

// Construir clases
$clases = [
    'txt',
    'txt--' . $nivel,
    'txt--w-' . $peso,
    'txt--c-' . $color,
    'txt--a-' . $alineacion,
];
if ($italic) $clases[] = 'txt--italic';
if ($label)  $clases[] = 'txt--label';
if ($clase_extra) $clases[] = $clase_extra;

$clases_str = implode(' ', array_map('sanitize_html_class', $clases));
$tag = sanitize_html_class($elemento) ?: 'p';
?>
<<?php echo esc_attr($tag); ?> class="<?php echo esc_attr($clases_str); ?>">
    <?php echo wp_kses_post($contenido); ?>
</<?php echo esc_attr($tag); ?>>
