get_header(); ?>

<main class="service-page-content">
    <?php while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('service-page'); ?>>
            <header class="page-header">
                <h1 class="page-title"><?php the_title(); ?></h1>
            </header>
        </article>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>