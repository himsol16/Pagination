<?php function custom_post_type_grid_shortcode($atts) {
    $atts = shortcode_atts(
        [
            'post_type' => 'post',
            'posts_per_page' => 12,
        ],
        $atts,
        'custom_post_grid'
    );

    $paged = get_query_var('paged') ? get_query_var('paged') : 1;

    // WP Query to fetch posts
    $query = new WP_Query([
        'post_type' => $atts['post_type'],
        'posts_per_page' => $atts['posts_per_page'],
        'paged' => $paged,
    ]);

    ob_start();

    if ($query->have_posts()) {
        echo '<div class="elementor-row articleslist" id="articleslist">';

        while ($query->have_posts()) {
            $query->the_post();

            $post_link = get_field('post_link');
            $target_link = $post_link ? esc_url($post_link) : get_permalink();

            echo '<div class="elementor-column elementor-col-33 elementor-top-column">';
            echo '<div class="elementor-widget-wrap">';

            if (has_post_thumbnail()) {
                echo '<div class="elementor-widget">';
                echo '<div class="elementor-widget-container">';
                echo '<a target="_blank" href="' . $target_link . '">' . get_the_post_thumbnail(get_the_ID(), 'medium') . '</a>';
                echo '</div>';
                echo '</div>';
            }

            $categories = get_the_category();
            if (!empty($categories)) {
                echo '<div class="elementor-widget">';
                echo '<div class="elementor-widget-container">';
                echo '<span>' . esc_html($categories[0]->name) . '</span>';
                echo '</div>';
                echo '</div>';
            }

            echo '<div class="elementor-widget">';
            echo '<div class="elementor-widget-container">';
            echo '<h3><a href="' . $target_link . '">' . get_the_title() . '</a></h3>';
            echo '</div>';
            echo '</div>';

            echo '</div>';
            echo '</div>';
        }

        echo '</div>'; // Close articleslist

        // Load More Button
        if ($query->max_num_pages > 1) {
            echo '<div class="load-more-container">';
            echo '<button id="load-more" data-page="1" data-max="' . $query->max_num_pages . '" data-post-type="' . esc_attr($atts['post_type']) . '" data-posts-per-page="' . $atts['posts_per_page'] . '">Load More</button>';
            echo '</div>';
        }
    } else {
        echo '<p>No posts found.</p>';
    }

    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode('custom_post_grid', 'custom_post_type_grid_shortcode');


function load_more_posts_ajax_handler() {
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $post_type = isset($_POST['post_type']) ? sanitize_text_field($_POST['post_type']) : 'post';
    $posts_per_page = isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : 12;

    $query = new WP_Query([
        'post_type' => $post_type,
        'posts_per_page' => $posts_per_page,
        'paged' => $page,
    ]);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            $post_link = get_field('post_link');
            $target_link = $post_link ? esc_url($post_link) : get_permalink();

            echo '<div class="elementor-column elementor-col-33 elementor-top-column">';
            echo '<div class="elementor-widget-wrap">';

            if (has_post_thumbnail()) {
                echo '<div class="elementor-widget">';
                echo '<div class="elementor-widget-container">';
                echo '<a target="_blank" href="' . $target_link . '">' . get_the_post_thumbnail(get_the_ID(), 'medium') . '</a>';
                echo '</div>';
                echo '</div>';
            }

            echo '<div class="elementor-widget">';
            echo '<div class="elementor-widget-container">';
            echo '<h3><a href="' . $target_link . '">' . get_the_title() . '</a></h3>';
            echo '</div>';
            echo '</div>';

            echo '</div>';
            echo '</div>';
        }
    }

    wp_reset_postdata();
    wp_die();
}
add_action('wp_ajax_load_more_posts', 'load_more_posts_ajax_handler');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts_ajax_handler');


  wp_enqueue_script( 'custom-scripts', get_template_directory_uri() . '/assets/js/custom.js', null, $version );
  wp_localize_script( 'custom-scripts', 'frontajax', array(
        'ajaxurl'                   => admin_url( 'admin-ajax.php', ( is_ssl() ? 'https' : 'http' ) )
    ));
  