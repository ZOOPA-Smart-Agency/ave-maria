<?php
/**
 * Header base — Ave Maria
 * Todo el <head> se genera aquí. El <body> con el contenido SPA lo sirve front-page.php.
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php wp_title(''); ?> — <?php bloginfo('name'); ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;500;600;700;900&display=swap">
<?php wp_head(); ?>
</head>
<body <?php body_class('lang-ca'); ?>>
