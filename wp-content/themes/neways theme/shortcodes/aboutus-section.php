<?php
/**
 * About Us Section Shortcode
 *
 * Usage:
 * [about_us 
 *   title="Work with us" 
 *   content="Anim aute id magna aliqua ad ad non deserunt sunt..."
 *   image="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=2830&h=1500&q=80"
 *   link1_text="Open roles" link1_url="/roles"
 *   link2_text="Internship program" link2_url="/internship"
 *   link3_text="Our values" link3_url="/values"
 *   link4_text="Meet our leadership" link4_url="/leadership"
 *   stat1_label="Offices worldwide" stat1_value="12"
 *   stat2_label="Full-time colleagues" stat2_value="300+"
 *   stat3_label="Hours per week" stat3_value="40"
 *   stat4_label="Paid time off" stat4_value="Unlimited"
 * ]
 */

if (!defined('ABSPATH')) {
    exit;
}

function custom_about_us_shortcode($atts) {
    $atts = shortcode_atts(array(
        'title'        => 'Work with us',
        'content'      => 'Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat veniam occaecat fugiat.',
        'image'        => 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=2830&h=1500&q=80',

        'link1_text'   => 'Open roles',       'link1_url' => '#',
        'link2_text'   => 'Internship program','link2_url' => '#',
        'link3_text'   => 'Our values',       'link3_url' => '#',
        'link4_text'   => 'Meet our leadership','link4_url' => '#',

        'stat1_label'  => 'Offices worldwide','stat1_value' => '12',
        'stat2_label'  => 'Full-time colleagues','stat2_value' => '300+',
        'stat3_label'  => 'Hours per week','stat3_value' => '40',
        'stat4_label'  => 'Paid time off','stat4_value' => 'Unlimited',
    ), $atts, 'about_us');

    ob_start();
    ?>
    <div class="relative isolate overflow-hidden bg-white py-24 sm:py-32">
      <img src="<?php echo esc_url($atts['image']); ?>" 
           alt="" 
           class="absolute inset-0 -z-10 size-full object-cover object-right opacity-10 md:object-center" />

      <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl lg:mx-0">
          <h2 class="text-5xl font-semibold tracking-tight text-gray-900 sm:text-7xl">
            <?php echo esc_html($atts['title']); ?>
          </h2>
          <p class="mt-8 text-lg font-medium text-pretty text-gray-700 sm:text-xl/8">
            <?php echo esc_html($atts['content']); ?>
          </p>
        </div>

        <div class="mx-auto mt-10 max-w-2xl lg:mx-0 lg:max-w-none">
          <div class="grid grid-cols-1 gap-x-8 gap-y-6 text-base/7 font-semibold text-gray-900 sm:grid-cols-2 md:flex lg:gap-x-10">
            <a href="<?php echo esc_url($atts['link1_url']); ?>"><?php echo esc_html($atts['link1_text']); ?> <span aria-hidden="true">&rarr;</span></a>
            <a href="<?php echo esc_url($atts['link2_url']); ?>"><?php echo esc_html($atts['link2_text']); ?> <span aria-hidden="true">&rarr;</span></a>
            <a href="<?php echo esc_url($atts['link3_url']); ?>"><?php echo esc_html($atts['link3_text']); ?> <span aria-hidden="true">&rarr;</span></a>
            <a href="<?php echo esc_url($atts['link4_url']); ?>"><?php echo esc_html($atts['link4_text']); ?> <span aria-hidden="true">&rarr;</span></a>
          </div>

          <dl class="mt-16 grid grid-cols-1 gap-8 sm:mt-20 sm:grid-cols-2 lg:grid-cols-4">
            <div class="flex flex-col-reverse gap-1">
              <dt class="text-base/7 text-gray-700"><?php echo esc_html($atts['stat1_label']); ?></dt>
              <dd class="text-4xl font-semibold tracking-tight text-gray-900"><?php echo esc_html($atts['stat1_value']); ?></dd>
            </div>
            <div class="flex flex-col-reverse gap-1">
              <dt class="text-base/7 text-gray-700"><?php echo esc_html($atts['stat2_label']); ?></dt>
              <dd class="text-4xl font-semibold tracking-tight text-gray-900"><?php echo esc_html($atts['stat2_value']); ?></dd>
            </div>
            <div class="flex flex-col-reverse gap-1">
              <dt class="text-base/7 text-gray-700"><?php echo esc_html($atts['stat3_label']); ?></dt>
              <dd class="text-4xl font-semibold tracking-tight text-gray-900"><?php echo esc_html($atts['stat3_value']); ?></dd>
            </div>
            <div class="flex flex-col-reverse gap-1">
              <dt class="text-base/7 text-gray-700"><?php echo esc_html($atts['stat4_label']); ?></dt>
              <dd class="text-4xl font-semibold tracking-tight text-gray-900"><?php echo esc_html($atts['stat4_value']); ?></dd>
            </div>
          </dl>
        </div>
      </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('about_us', 'custom_about_us_shortcode');
