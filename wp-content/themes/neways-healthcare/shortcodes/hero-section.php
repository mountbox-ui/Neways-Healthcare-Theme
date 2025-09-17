<?php
/**
 * Hero Section Shortcode
 * Usage example:
 * [hero_section title="Data to enrich your online business" 
 *               subtitle="Announcing our next round of funding." 
 *               content="Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat veniam occaecat." 
 *               button_text="Get started" 
 *               button_url="/get-started" 
 *               secondary_text="Learn more →" 
 *               secondary_url="/learn-more" 
 *               background="white"]
 */

if (!defined('ABSPATH')) {
    exit;
}

function custom_hero_section_shortcode($atts) {
    $atts = shortcode_atts(array(
        'title'         => 'Data to enrich your online business',
        'subtitle'      => 'Announcing our next round of funding.',
        'subtitle_link' => '#',
        'content'       => 'Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat veniam occaecat.',
        'button_text'   => 'Get started',
        'button_url'    => '#',
        'secondary_text'=> 'Learn more →',
        'secondary_url' => '#',
        'background'    => 'white',
        'image'         => '',
        'image_position'=> 'center center', // e.g., 'top center', 'center
    ), $atts, 'hero_section');

    // Build background style
    $background_class = 'bg-' . esc_attr($atts['background']);
    $background_style = '';
    if (!empty($atts['image'])) {
        $background_class = ''; // override Tailwind color if image exists
        $background_style = 'style="background-image:url(' . esc_url($atts['image']) . '); background-size:cover; background-position:' . esc_attr($atts['image_position']) . ';"';
    }

    ob_start();
    ?>
    <!-- Hero Section -->
    <div class="bg-<?php echo esc_attr($atts['background']); ?>">
      <header class="absolute inset-x-0 top-0 z-50">
        <!-- <nav aria-label="Global" class="flex items-center justify-between p-6 lg:px-8">
          <div class="flex lg:flex-1">
            <a href="/" class="-m-1.5 p-1.5">
              <span class="sr-only"><?php bloginfo('name'); ?></span>
              <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600" alt="<?php bloginfo('name'); ?>" class="h-8 w-auto" />
            </a>
          </div>
          <div class="flex lg:hidden">
            <button type="button" command="show-modal" commandfor="mobile-menu" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
              <span class="sr-only">Open main menu</span>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true" class="size-6">
                <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </button>
          </div>
          <div class="hidden lg:flex lg:gap-x-12">
            <a href="#" class="text-sm/6 font-semibold text-gray-900">Product</a>
            <a href="#" class="text-sm/6 font-semibold text-gray-900">Features</a>
            <a href="#" class="text-sm/6 font-semibold text-gray-900">Marketplace</a>
            <a href="#" class="text-sm/6 font-semibold text-gray-900">Company</a>
          </div>
          <div class="hidden lg:flex lg:flex-1 lg:justify-end">
            <a href="#" class="text-sm/6 font-semibold text-gray-900">Log in <span aria-hidden="true">&rarr;</span></a>
          </div>
        </nav> -->
      </header>

      <div class="relative isolate px-6 pt-14 lg:px-8">
        <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
          <?php if (!empty($atts['subtitle'])) : ?>
          <div class="hidden sm:mb-8 sm:flex sm:justify-center">
            <div class="relative rounded-full px-3 py-1 text-sm/6 text-gray-600 ring-1 ring-gray-900/10 hover:ring-gray-900/20">
              <?php echo esc_html($atts['subtitle']); ?>
              <?php if (!empty($atts['subtitle_link'])) : ?>
              <a href="<?php echo esc_url($atts['subtitle_link']); ?>" class="font-semibold text-indigo-600">
                <span aria-hidden="true" class="absolute inset-0"></span>Read more <span aria-hidden="true">&rarr;</span>
              </a>
              <?php endif; ?>
            </div>
          </div>
          <?php endif; ?>

          <div class="text-center">
            <h1 class="text-5xl font-semibold tracking-tight text-balance text-gray-900 sm:text-7xl">
              <?php echo esc_html($atts['title']); ?>
            </h1>
            <p class="mt-8 text-lg font-medium text-pretty text-gray-500 sm:text-xl/8">
              <?php echo esc_html($atts['content']); ?>
            </p>
            <div class="mt-10 flex items-center justify-center gap-x-6">
              <?php if (!empty($atts['button_text'])) : ?>
              <a href="<?php echo esc_url($atts['button_url']); ?>" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                <?php echo esc_html($atts['button_text']); ?>
              </a>
              <?php endif; ?>
              <?php if (!empty($atts['secondary_text'])) : ?>
              <a href="<?php echo esc_url($atts['secondary_url']); ?>" class="text-sm/6 font-semibold text-gray-900">
                <?php echo esc_html($atts['secondary_text']); ?>
              </a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('hero_section', 'custom_hero_section_shortcode');
