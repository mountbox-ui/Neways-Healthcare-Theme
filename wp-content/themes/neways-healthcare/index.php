<?php
/**
 * The main template file
 */

get_header(); ?>

<main class="container-custom py-8">
    <div class="max-w-4xl mx-auto">
            <?php if (is_search()) : global $wp_query; ?>
                <header class="mb-8">
                    <h1 class="text-3xl lg:text-4xl font-bold text-white">
                        <?php printf(esc_html__('Search results for “%s”', 'tov-theme'), get_search_query()); ?>
                    </h1>
                    <p class="text-navy-300 mt-2">
                        <?php echo esc_html($wp_query->found_posts); ?> <?php echo esc_html($wp_query->found_posts === 1 ? __('result', 'tov-theme') : __('results', 'tov-theme')); ?>
                    </p>
                </header>
            <?php endif; ?>
            <?php if (have_posts()) : ?>
                <div class="space-y-8">
                    <?php while (have_posts()) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('card'); ?>>
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="aspect-w-16 aspect-h-9">
                                    <?php the_post_thumbnail('large', array('class' => 'w-full h-64 object-cover')); ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="p-6">
                                <header class="mb-4">
                                    <div class="flex items-center text-sm text-navy-300 mb-2">
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
                                        <a href="<?php the_permalink(); ?>" class="text-white hover:text-navy-200 transition-colors duration-200">
                                            <?php the_title(); ?>
                                        </a>
                                    </h2>
                                </header>
                                
                                <div class="prose prose-invert max-w-none mb-4 text-navy-100">
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
