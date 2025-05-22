<?php
/**
 * Plugin Name: SinglePlugin
 * Description: Ajoute un lien "Dupliquer" dans la liste des articles.
 * Version: 1.0
 * Author: Ybr
 */

add_filter('post_row_actions', 'SinglePlugin_displayDuplicateLink', 10, 2);
add_filter('page_row_actions', 'SinglePlugin_displayDuplicateLink', 10, 2);

function SinglePlugin_displayDuplicateLink($actions, $post) {
    if (current_user_can('edit_posts')) {
        $url = wp_nonce_url(
            add_query_arg([
                'action' => 'SinglePlugin_duplicate_post',
                'post' => $post->ID,
            ], 'admin.php'),
            basename(__FILE__)
        );

        $actions['duplicate'] = '<a href="' . esc_url($url) . '">Dupliquer</a>';
    }
    return $actions;
}

add_action('admin_action_SinglePlugin_duplicate_post', 'Single_duplicate_post');

function SinglePlugin_duplicate_post() {
    if (!isset($_GET['post']) || !isset($_GET['_wpnonce'])) {
        wp_die('Paramètres manquants.');
    }

    $post_id = absint($_GET['post']);

    check_admin_referer(basename(__FILE__));

    $post = get_post($post_id);
    if (!$post) {
        wp_die('Article non trouvé.');
    }

    $new_post = [
        'post_title'    => $post->post_title . ' (copie)',
        'post_content'  => $post->post_content,
        'post_status'   => 'draft',
        'post_type'     => $post->post_type,
        'post_author'   => get_current_user_id(),
    ];

    $new_post_id = wp_insert_post($new_post);

    // Copier les taxonomies
    $taxonomies = get_object_taxonomies($post->post_type);
    foreach ($taxonomies as $taxonomy) {
        $terms = wp_get_object_terms($post_id, $taxonomy, ['fields' => 'ids']);
        wp_set_object_terms($new_post_id, $terms, $taxonomy);
    }

    // Copier les métadonnées
    $meta = get_post_meta($post_id);
    foreach ($meta as $key => $values) {
        foreach ($values as $value) {
            update_post_meta($new_post_id, $key, maybe_unserialize($value));
        }
    }

    // Redirection vers la liste des articles avec un paramètre
    wp_safe_redirect(add_query_arg([
        'post_type' => $post->post_type,
        'saved' => 'SinglePlugin_duplicate',
    ], admin_url('edit.php')));
    exit;
}

add_action('admin_notices', 'SinglePlugin_duplicate_notice');

function SinglePlugin_duplicate_notice() {
    if (isset($_GET['saved']) && $_GET['saved'] === 'SinglePlugin_duplicate') {
        echo '<div class="notice notice-success is-dismissible"><p>Article dupliqué avec succès !</p></div>';
    }
}