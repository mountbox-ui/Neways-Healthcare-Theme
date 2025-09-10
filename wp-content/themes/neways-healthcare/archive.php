<?php
/**
 * The template for displaying archive pages
 */

get_header(); ?>

<main class="container-custom py-8">
    <div class="max-w-4xl mx-auto">
            <header class="page-header mb-8">
                <?php
                the_archive_title('<h1 class="page-title text-3xl font-bold text-gray-900">', '</h1>');
                the_archive_description('<div class="archive-description text-gray-600 mt-2 prose max-w-none">', '</div>');
                ?>
            </header>

            <?php if (have_posts()) : ?>
                <div class="space-y-8">
                    <?php while (have_posts()) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('card'); ?>>
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="aspect-w-16 aspect-h-9">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('large', array('class' => 'w-full h-64 object-cover hover:opacity-90 transition-opacity duration-200')); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <div class="p-6">
                                <header class="mb-4">
                                    <div class="flex items-center text-sm text-gray-500 mb-2">
                                        <time datetime="<?php echo get_the_date('c'); ?>">
                                            <?php echo get_the_date(); ?>
                                        </time>
                                        <span class="mx-2">•</span>
                                        <span><?php the_author(); ?></span>
                                        <?php if (get_the_category()) : ?>
                                            <span class="mx-2">•</span>
                                            <?php the_category(', '); ?>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <h2 class="text-2xl font-bold mb-2">
                                        <a href="<?php the_permalink(); ?>" class="text-gray-900 hover:text-primary-600 transition-colors duration-200">
                                            <?php the_title(); ?>
                                        </a>
                                    </h2>
                                </header>
                                
                                <div class="prose max-w-none mb-4">
                                    <?php the_excerpt(); ?>
                                </div>
                                
                                <footer class="flex items-center justify-between">
                                    <a href="<?php the_permalink(); ?>" class="btn btn-primary text-sm">
                                        <?php esc_html_e('Read More', 'tov-theme'); ?>
                                    </a>
                                    
                                    <?php if (get_the_tags()) : ?>
                                        <div class="flex flex-wrap gap-2">
                                            <?php the_tags('<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800">', '</span><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800">', '</span>'); ?>
                                        </div>
                                    <?php endif; ?>
                                </footer>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>
                
                <?php get_template_part('template-parts/pagination'); ?>
                
            <?php else : ?>
                <?php get_template_part('template-parts/content', 'none'); ?>
            <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
