<?php
/**
 * The template for displaying 404 pages (not found)
 */

get_header(); ?>

<main class="container-custom py-16">
    <div class="max-w-2xl mx-auto text-center">
        <div class="mb-8">
            <div class="text-9xl font-bold text-primary-200 mb-4">404</div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                <?php esc_html_e('Oops! Page Not Found', 'tov-theme'); ?>
            </h1>
            <p class="text-xl text-gray-600 mb-8">
                <?php esc_html_e('The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'tov-theme'); ?>
            </p>
        </div>
        
        <div class="space-y-6">
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <?php esc_html_e('Back to Home', 'tov-theme'); ?>
                </a>
                <button onclick="history.back()" class="btn btn-secondary">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <?php esc_html_e('Go Back', 'tov-theme'); ?>
                </button>
            </div>
            
            <?php // Search block removed intentionally ?>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                <div class="card p-6">
                    <h3 class="text-lg font-semibold mb-4"><?php esc_html_e('Recent Posts', 'tov-theme'); ?></h3>
                    <?php
                    $recent_posts = wp_get_recent_posts(array(
                        'numberposts' => 5,
                        'post_status' => 'publish'
                    ));
                    
                    if ($recent_posts) : ?>
                        <ul class="space-y-2">
                            <?php foreach ($recent_posts as $post) : ?>
                                <li>
                                    <a href="<?php echo get_permalink($post['ID']); ?>" class="text-primary-600 hover:text-primary-700 text-sm">
                                        <?php echo esc_html($post['post_title']); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else : ?>
                        <p class="text-gray-600 text-sm"><?php esc_html_e('No recent posts found.', 'tov-theme'); ?></p>
                    <?php endif; ?>
                </div>
                
                <div class="card p-6">
                    <h3 class="text-lg font-semibold mb-4"><?php esc_html_e('Categories', 'tov-theme'); ?></h3>
                    <?php
                    $categories = get_categories(array(
                        'orderby' => 'count',
                        'order'   => 'DESC',
                        'number'  => 5
                    ));
                    
                    if ($categories) : ?>
                        <ul class="space-y-2">
                            <?php foreach ($categories as $category) : ?>
                                <li>
                                    <a href="<?php echo get_category_link($category->term_id); ?>" class="text-primary-600 hover:text-primary-700 text-sm">
                                        <?php echo esc_html($category->name); ?> (<?php echo $category->count; ?>)
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else : ?>
                        <p class="text-gray-600 text-sm"><?php esc_html_e('No categories found.', 'tov-theme'); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
