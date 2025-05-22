<?php

add_action('after_setup_theme', 'ProjetOpenclassroom_register_nav_menu', 0);
function ProjetOpenclassroom_register_nav_menu()
{
    register_nav_menus(array(
        'primary_menu' => __('Primary Menu', 'ProjetOpenclassroom'),
        'footer_menu' => __('Footer Menu', 'ProjetOpenclassroom'),
    ));
}

add_action('after_setup_theme', 'ProjetOpenclassroom_add_theme_support', 0);
function ProjetOpenclassroom_add_theme_support()
{
    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails');
}

add_action('wp_enqueue_scripts', 'ProjetOpenclassroom_enqueue_assets');
function ProjetOpenclassroom_enqueue_assets()
{
    wp_enqueue_style('main', get_stylesheet_uri());
}

// Customisation de l'affichage des titres
//add_filter('the_title', 'esgi_customTitle', 10, 1);
function ProjetOpenclassroom_customTitle($title)
{
    return strtoupper($title);
}