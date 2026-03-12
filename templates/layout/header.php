<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-TVJCD4D3');</script>
    <!-- End Google Tag Manager -->

    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" sizes="180x180" href="<?= DOT_THEME_PATH ?>/assets/favicon/apple-touch-icon-v2.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= DOT_THEME_PATH ?>/assets/favicon/favicon-32x32-v2.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= DOT_THEME_PATH ?>/assets/favicon/favicon-16x16-v2.png">
    <link rel="mask-icon" href="<?= DOT_THEME_PATH ?>/assets/favicon/safari-pinned-tab-v2.svg" color="#ed302e">
    <link rel="shortcut icon" href="<?= DOT_THEME_PATH ?>/assets/favicon/favicon-v2.ico">
    <meta name="msapplication-TileColor" content="#000000">
    <meta name="msapplication-config" content="<?= DOT_THEME_PATH ?>/assets/favicon/browserconfig.xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <?php wp_head(); ?>
</head>

<body <?php body_class() ?>>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TVJCD4D3"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <?php wp_body_open() ?>
    <?php get_template_part('templates/layout/menu'); ?>

    <div id="main">
