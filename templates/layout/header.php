<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" sizes="180x180" href="<?= DOT_THEME_PATH ?>/assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= DOT_THEME_PATH ?>/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= DOT_THEME_PATH ?>/assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?= DOT_THEME_PATH ?>/assets/favicon/site.webmanifest">
    <link rel="mask-icon" href="<?= DOT_THEME_PATH ?>/assets/favicon/safari-pinned-tab.svg" color="#ed302e">
    <link rel="shortcut icon" href="<?= DOT_THEME_PATH ?>/assets/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#000000">
    <meta name="msapplication-config" content="<?= DOT_THEME_PATH ?>/assets/img/favicon/browserconfig.xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <?php wp_head(); ?>
</head>

<body <?php body_class() ?>>
    <?php wp_body_open() ?>
    <?php get_template_part('templates/layout/menu'); ?>

    <div id="main">
