<?php
/**
 * Fundació Ave Maria — Theme Functions
 *
 * @package Ave_Maria
 */

defined('ABSPATH') || exit;

define('AVEMARIA_VERSION', '1.0.0');
define('AVEMARIA_DIR', get_template_directory());
define('AVEMARIA_URI', get_template_directory_uri());

require_once AVEMARIA_DIR . '/inc/theme-setup.php';
require_once AVEMARIA_DIR . '/inc/custom-post-types.php';
require_once AVEMARIA_DIR . '/inc/custom-fields.php';
require_once AVEMARIA_DIR . '/inc/acf-fields.php';
require_once AVEMARIA_DIR . '/inc/admin-ui.php';
require_once AVEMARIA_DIR . '/inc/enqueue.php';
require_once AVEMARIA_DIR . '/inc/nav-walkers.php';
require_once AVEMARIA_DIR . '/inc/helpers.php';
require_once AVEMARIA_DIR . '/inc/polylang.php';
require_once AVEMARIA_DIR . '/inc/import-content.php';
