<?php
/**
 * Template part for displaying pagination
 */

$pagination = paginate_links(array(
    'mid_size'  => 2,
    'prev_text' => '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>' . esc_html__('Previous', 'tov-theme'),
    'next_text' => esc_html__('Next', 'tov-theme') . '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>',
    'type'      => 'array',
));

if (!empty($pagination)) : ?>
    <nav class="pagination-wrapper mt-12" role="navigation" aria-label="<?php esc_attr_e('Posts navigation', 'tov-theme'); ?>">
        <div class="flex items-center justify-center space-x-1">
            <?php foreach ($pagination as $link) : ?>
                <?php
                // Add Tailwind classes to pagination links
                $link = str_replace('page-numbers', 'inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 hover:bg-gray-50 hover:text-gray-700 transition-colors duration-200', $link);
                $link = str_replace('current', 'inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-primary-600 border border-primary-600', $link);
                $link = str_replace('prev page-numbers', 'inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 hover:bg-gray-50 hover:text-gray-700 transition-colors duration-200', $link);
                $link = str_replace('next page-numbers', 'inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 hover:bg-gray-50 hover:text-gray-700 transition-colors duration-200', $link);
                echo $link;
                ?>
            <?php endforeach; ?>
        </div>
    </nav>
<?php endif; ?>
