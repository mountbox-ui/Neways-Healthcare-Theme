<?php
/**
 * Template part for displaying post navigation
 */

$prev_post = get_previous_post();
$next_post = get_next_post();

if ($prev_post || $next_post) : ?>
    <nav class="post-navigation mt-8 pt-8 border-t border-gray-200" role="navigation" aria-label="<?php esc_attr_e('Post navigation', 'tov-theme'); ?>">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php if ($prev_post) : ?>
                <div class="nav-previous">
                    <a href="<?php echo get_permalink($prev_post); ?>" class="group block p-4 border border-gray-200 rounded-lg hover:border-primary-300 hover:shadow-md transition-all duration-200">
                        <div class="flex items-center text-sm text-gray-500 mb-2">
                            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            <?php esc_html_e('Previous Post', 'tov-theme'); ?>
                        </div>
                        <h4 class="font-semibold text-gray-900 group-hover:text-primary-600 transition-colors duration-200">
                            <?php echo get_the_title($prev_post); ?>
                        </h4>
                    </a>
                </div>
            <?php endif; ?>
            
            <?php if ($next_post) : ?>
                <div class="nav-next <?php echo !$prev_post ? 'md:col-start-2' : ''; ?>">
                    <a href="<?php echo get_permalink($next_post); ?>" class="group block p-4 border border-gray-200 rounded-lg hover:border-primary-300 hover:shadow-md transition-all duration-200">
                        <div class="flex items-center justify-end text-sm text-gray-500 mb-2">
                            <?php esc_html_e('Next Post', 'tov-theme'); ?>
                            <svg class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-900 group-hover:text-primary-600 transition-colors duration-200 text-right">
                            <?php echo get_the_title($next_post); ?>
                        </h4>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </nav>
<?php endif; ?>
