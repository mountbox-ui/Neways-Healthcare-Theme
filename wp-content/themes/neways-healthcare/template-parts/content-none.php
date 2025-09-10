<?php
/**
 * Template part for displaying a message that posts cannot be found
 */
?>

<section class="no-results not-found card p-6 text-center">
    <header class="page-header mb-6">
        <h1 class="page-title text-2xl font-bold text-gray-900">
            <?php esc_html_e('Nothing here', 'tov-theme'); ?>
        </h1>
    </header>

    <div class="page-content">
        <?php if (is_home() && current_user_can('publish_posts')) : ?>
            <p class="text-gray-600 mb-6">
                <?php
                printf(
                    wp_kses(
                        __('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'tov-theme'),
                        array(
                            'a' => array(
                                'href' => array(),
                            ),
                        )
                    ),
                    esc_url(admin_url('post-new.php'))
                );
                ?>
            </p>
        <?php elseif (is_search()) : ?>
            <p class="text-gray-600 mb-6">
                <?php esc_html_e('Sorry, but nothing matched your search terms.', 'tov-theme'); ?>
            </p>
        <?php else : ?>
            <p class="text-gray-600 mb-6">
                <?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for.', 'tov-theme'); ?>
            </p>
        <?php endif; ?>
    </div>
</section>
