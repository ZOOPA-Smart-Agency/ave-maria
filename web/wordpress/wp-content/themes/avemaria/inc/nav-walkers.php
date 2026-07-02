<?php
/**
 * Nav Walker — outputs links with header__link class
 *
 * @package Ave_Maria
 */

class Avemaria_Nav_Walker extends Walker_Nav_Menu {
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = in_array('current-menu-item', $item->classes) ? ' active' : '';
        $output .= '<a href="' . esc_url($item->url) . '" class="header__link' . $classes . '">' . esc_html($item->title) . '</a>';
    }

    public function end_el(&$output, $item, $depth = 0, $args = null) {}
    public function start_lvl(&$output, $depth = 0, $args = null) {}
    public function end_lvl(&$output, $depth = 0, $args = null) {}
}

class Avemaria_Footer_Walker extends Walker_Nav_Menu {
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $output .= '<a href="' . esc_url($item->url) . '" class="footer__link">' . esc_html($item->title) . '</a>';
    }

    public function end_el(&$output, $item, $depth = 0, $args = null) {}
    public function start_lvl(&$output, $depth = 0, $args = null) {}
    public function end_lvl(&$output, $depth = 0, $args = null) {}
}

// Fallback menus when no menu is assigned
function avemaria_fallback_menu() {
    echo '<nav class="header__nav" id="nav">';
    echo '<a href="' . esc_url(home_url('/')) . '" class="header__link">Home</a>';
    $pages = ['quienes-somos' => 'Quiénes Somos', 'servicios' => 'Servicios', 'soluciones' => 'Soluciones', 'portfolio' => 'Portfolio', 'procesos' => 'Procesos', 'contacto' => 'Contacto'];
    foreach ($pages as $slug => $name) {
        $page = get_page_by_path($slug);
        $url  = $page ? get_permalink($page) : home_url('/' . $slug . '/');
        echo '<a href="' . esc_url($url) . '" class="header__link">' . esc_html($name) . '</a>';
    }
    echo '</nav>';
}

function avemaria_fallback_footer_menu() {
    $pages = ['quienes-somos' => 'Quiénes Somos', 'servicios' => 'Servicios', 'soluciones' => 'Soluciones', 'portfolio' => 'Portfolio', 'procesos' => 'Procesos'];
    foreach ($pages as $slug => $name) {
        $page = get_page_by_path($slug);
        $url  = $page ? get_permalink($page) : home_url('/' . $slug . '/');
        echo '<a href="' . esc_url($url) . '" class="footer__link">' . esc_html($name) . '</a>';
    }
}

function avemaria_fallback_services_menu() {
    $servicios_url = function_exists('avemaria_page_url') ? avemaria_page_url('servicios', '/servicios/') : home_url('/servicios/');
    $t = function ($s) { return function_exists('avemaria_t') ? avemaria_t($s) : $s; };
    echo '<a href="' . esc_url($servicios_url . '#impresion') . '" class="footer__link">' . esc_html($t('Impresión')) . '</a>';
    echo '<a href="' . esc_url($servicios_url . '#transfer')  . '" class="footer__link">' . esc_html($t('Transfer y Parches')) . '</a>';
    echo '<a href="' . esc_url($servicios_url . '#marcado')   . '" class="footer__link">' . esc_html($t('Marcado en Prenda')) . '</a>';
    echo '<a href="' . esc_url($servicios_url . '#logistica') . '" class="footer__link">' . esc_html($t('Logística')) . '</a>';
}
