<?php

add_action('after_setup_theme', 'SingleTheme_register_nav_menu', 0);
function SingleTheme_register_nav_menu()
{
    register_nav_menus(array(
        'primary_menu' => __('Primary Menu', 'ProjetOpenclassroom'),
        'primary_menu' => __('Footer Menu', 'ProjetOpenclassroom'),
    ));

    add_action('after_setup_theme', 'SingleTheme_add_theme_support', 0);
    function SingleTheme_add_theme_support()
    {
        add_theme_support('custom-logo');
        add_theme_support('post-thumbnails');
    }
}