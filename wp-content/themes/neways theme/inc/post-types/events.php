<?php
/**
 * Register Events Custom Post Type
 */

if (!defined('ABSPATH')) exit;

function neways_register_events_post_type() {
    $labels = array(
        'name'               => _x('Events', 'post type general name', 'neways'),
        'singular_name'      => _x('Event', 'post type singular name', 'neways'),
        'menu_name'          => _x('Events', 'admin menu', 'neways'),
        'name_admin_bar'     => _x('Event', 'add new on admin bar', 'neways'),
        'add_new'           => _x('Add New', 'event', 'neways'),
        'add_new_item'      => __('Add New Event', 'neways'),
        'new_item'          => __('New Event', 'neways'),
        'edit_item'         => __('Edit Event', 'neways'),
        'view_item'         => __('View Event', 'neways'),
        'all_items'         => __('All Events', 'neways'),
        'search_items'      => __('Search Events', 'neways'),
        'not_found'         => __('No events found.', 'neways'),
        'not_found_in_trash'=> __('No events found in Trash.', 'neways'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'           => true,
        'show_in_menu'      => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'events'),
        'capability_type'   => 'post',
        'has_archive'       => true,
        'hierarchical'      => false,
        'menu_position'     => 5,
        'menu_icon'         => 'dashicons-calendar-alt',
        'supports'          => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest'      => true,
    );

    register_post_type('event', $args);

    // Register Event Category Taxonomy
    $cat_labels = array(
        'name'              => _x('Event Categories', 'taxonomy general name', 'neways'),
        'singular_name'     => _x('Event Category', 'taxonomy singular name', 'neways'),
        'search_items'      => __('Search Event Categories', 'neways'),
        'all_items'         => __('All Event Categories', 'neways'),
        'parent_item'       => __('Parent Event Category', 'neways'),
        'parent_item_colon' => __('Parent Event Category:', 'neways'),
        'edit_item'         => __('Edit Event Category', 'neways'),
        'update_item'       => __('Update Event Category', 'neways'),
        'add_new_item'      => __('Add New Event Category', 'neways'),
        'new_item_name'     => __('New Event Category Name', 'neways'),
        'menu_name'         => __('Categories', 'neways'),
    );

    register_taxonomy('event_category', array('event'), array(
        'hierarchical'      => true,
        'labels'           => $cat_labels,
        'show_ui'          => true,
        'show_admin_column'=> true,
        'query_var'        => true,
        'rewrite'          => array('slug' => 'event-category'),
        'show_in_rest'     => true,
    ));
}
add_action('init', 'neways_register_events_post_type');

// Add custom meta boxes for event details
function neways_add_event_meta_boxes() {
    add_meta_box(
        'event_details',
        __('Event Details', 'neways'),
        'neways_event_details_meta_box',
        'event',
        'normal',
        'high'
    );
}
add_action('admin_head-post-new.php', 'neways_event_admin_style');
add_action('admin_head-post.php', 'neways_event_admin_style');

function neways_event_admin_style() {
    global $post_type;
    if ($post_type == 'event') {
        ?>
        <style>
            #event_details {
                margin-top: 20px;
            }
            #event_details .inside {
                padding: 0;
                margin: 0;
            }
            .event-meta-fields {
                background: #f8fafc;
                border: 1px solid #e2e4e7;
                border-radius: 4px;
                padding: 15px;
            }
        </style>
        <?php
    }
}
add_action('add_meta_boxes', 'neways_add_event_meta_boxes');

function neways_event_details_meta_box($post) {
    wp_nonce_field('neways_event_details', 'neways_event_details_nonce');

    $event_date = get_post_meta($post->ID, '_event_date', true);
    $event_end_date = get_post_meta($post->ID, '_event_end_date', true);
    $event_time = get_post_meta($post->ID, '_event_time', true);
    $event_location = get_post_meta($post->ID, '_event_location', true);
    ?>
    <style>
        .event-meta-fields {
            padding: 10px;
            background: #fff;
            border: 1px solid #e2e4e7;
            border-radius: 4px;
        }
        .event-meta-fields p {
            margin: 1em 0;
        }
        .event-meta-fields label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .event-meta-fields input[type="date"],
        .event-meta-fields input[type="time"] {
            width: 200px;
        }
        .event-meta-fields input[type="text"] {
            width: 100%;
        }
    </style>
    <div class="event-meta-fields">
        <p>
            <label for="event_date"><?php _e('Event Start Date:', 'neways'); ?></label>
            <input type="date" 
                   id="event_date" 
                   name="event_date" 
                   value="<?php echo esc_attr($event_date); ?>"
                   required>
        </p>
        <p>
            <label for="event_end_date"><?php _e('Event End Date (optional):', 'neways'); ?></label>
            <input type="date" 
                   id="event_end_date" 
                   name="event_end_date" 
                   value="<?php echo esc_attr($event_end_date); ?>">
        </p>
        <p>
            <label for="event_time"><?php _e('Event Time:', 'neways'); ?></label>
            <input type="time" 
                   id="event_time" 
                   name="event_time" 
                   value="<?php echo esc_attr($event_time); ?>">
        </p>
        <p>
            <label for="event_location"><?php _e('Location / Venue:', 'neways'); ?></label>
            <input type="text" 
                   id="event_location" 
                   name="event_location" 
                   value="<?php echo esc_attr($event_location); ?>" 
                   class="widefat"
                   placeholder="Enter event location">
        </p>
    </div>
    <?php
}

function neways_save_event_meta($post_id) {
    if (!isset($_POST['neways_event_details_nonce'])) {
        return;
    }
    if (!wp_verify_nonce($_POST['neways_event_details_nonce'], 'neways_event_details')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save event date
    if (isset($_POST['event_date'])) {
        update_post_meta($post_id, '_event_date', sanitize_text_field($_POST['event_date']));
    }

    // Save event end date
    if (isset($_POST['event_end_date'])) {
        update_post_meta($post_id, '_event_end_date', sanitize_text_field($_POST['event_end_date']));
    }
    
    // Save event time
    if (isset($_POST['event_time'])) {
        update_post_meta($post_id, '_event_time', sanitize_text_field($_POST['event_time']));
    }
    
    // Save event location
    if (isset($_POST['event_location'])) {
        update_post_meta($post_id, '_event_location', sanitize_text_field($_POST['event_location']));
    }
}
add_action('save_post', 'neways_save_event_meta');
