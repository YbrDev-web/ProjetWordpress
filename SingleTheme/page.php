<?php
// Template pour afficher les pages seules
// Par défaut WP crée une variable $post qui corresond au post courant : utilisons la...
get_header();
?>

<main class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h1><?php the_title() ?></h1>
                <div>
                    <?= the_content() ?>
                </div>
            </div>
        </div>
    </div>
</main>


<?php get_footer() ?>