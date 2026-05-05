<?php 

function wpdocs_theme_name_scripts() {
    
    //Proper way to enqueue script

    wp_enqueue_script( 'ajax-js', get_template_directory_uri() . '/assets/js/custom.js', array(), '1.0.0', true );
      wp_localize_script( 'ajax-js', 'frontajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'wp_enqueue_scripts', 'wpdocs_theme_name_scripts' );


add_action('wp_ajax_load_posts_by_ajax', 'load_posts_by_ajax_callback');
add_action('wp_ajax_nopriv_load_posts_by_ajax', 'load_posts_by_ajax_callback');

function load_posts_by_ajax_callback() {
    $paged = $_POST['page'];
    $term = $_POST['term'];
    $posts_per_page = 2; // Adjust posts per page as needed

    // Calculate offset based on current page and posts per page
    $offset = ($paged - 1) * $posts_per_page;

    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => $posts_per_page,
        'paged' => $paged,
        'offset' => $offset, // Include the offset
        'order' => 'DESC',
        'tax_query' => array(
            array(
                'taxonomy' => 'category',
                'field' => 'slug',
                'terms' => $term,
                'operator' => 'IN',
            )
        )
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            // Your post display code goes here
            ?>
            <div class="col-md-4 <?= $term; ?>">
                <div class="htext">
                    <a href="<?php the_permalink(); ?>"><h4><?php the_title(); ?></h4></a>
                </div>
            </div>
            <?php
        endwhile;
        wp_reset_query();
    endif;

    wp_die();
}
?>