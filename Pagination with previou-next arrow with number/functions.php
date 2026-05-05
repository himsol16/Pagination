<?php function enqueue_ajax_posts_script() {
    wp_enqueue_script('ajax-posts-script', get_template_directory_uri() . '/assets/js/ajax-posts.js', ['jquery'], null, true);
    wp_localize_script('ajax-posts-script', 'ajax_posts_params', [
        'ajax_url' => admin_url('admin-ajax.php'),
    ]);
}
add_action('wp_enqueue_scripts', 'enqueue_ajax_posts_script');

function load_box_posts_ajax() {
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
    $posts_per_page = 4;

    $query = new WP_Query([
        'post_type'      => 'post',
        'posts_per_page' => $posts_per_page,
        'paged'          => $paged,
    ]);

    ob_start();
    if ($query->have_posts()):
        echo '<div class="grid-box-posts">';
        while ($query->have_posts()): $query->the_post(); ?>
            <div class="box-post">
                <h2><?php the_title(); ?></h2>
                <div><?php the_excerpt(); ?></div>
            </div>
        <?php endwhile;
        echo '</div>';
    else:
        echo '<p>No posts found.</p>';
    endif;

    $max_pages = $query->max_num_pages;
    wp_reset_postdata();

    wp_send_json([
        'html'       => ob_get_clean(),
        'page'       => $paged,
        'max_pages'  => $max_pages,
        'has_next'   => $paged < $max_pages,
        'has_prev'   => $paged > 1
    ]);
}

add_action('wp_ajax_load_box_posts', 'load_box_posts_ajax');
add_action('wp_ajax_nopriv_load_box_posts', 'load_box_posts_ajax');


function ajax_box_posts_shortcode() {
    ob_start(); ?>
    <div class="ajax-post-wrapper">
        <div id="post-container" data-page="1"></div>
        <div class="pagination-buttons">
            <button class="arrow-prev" style="display: none;">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brown-arrw.svg" alt="Previous" style="transform: scaleX(-1);" />
            </button>

            <div class="pagination-numbers"></div> <!-- 👈 Pagination numbers -->

            <button class="arrow-next" style="display: none;">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/brown-arrw.svg" alt="Next">
            </button>
        </div>
    </div>
    <?php return ob_get_clean();
}


add_shortcode('ajax_box_posts', 'ajax_box_posts_shortcode');