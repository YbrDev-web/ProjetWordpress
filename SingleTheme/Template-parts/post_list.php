<?php
// Envoi d'une requete wp grâce à la fonction get_posts($args)
$args = [
    'post_type' => 'post', // valeur par défaut
];
$posts = get_posts($args); // Récupération de tous les résultats
// echo '<pre>';
// var_dump($posts);
?>
<div>
    <ul class="post_list">
        <?php foreach ($posts as $post) { ?>
            <li>
                <a href="<?= get_permalink($post) ?>"><?= $post->post_title ?> <time><?= wp_date('j F Y', strtotime($post->post_date)) ?></time> </a>
            </li>
        <?php } ?>
    </ul>
</div>