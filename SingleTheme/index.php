<?php get_header(); ?>

<main>
    <?php include('Template-parts/identity_card.php'); ?>

    <?php if (!is_front_page()) {
        include('Template-parts/post-list.php');
    }
    ?>
</main>


<?php get_footer() ?>