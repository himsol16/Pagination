<?php // Custom Query for Load More

function wpdocs_theme_name_scripts() {
    
    //Proper way to enqueue script

    wp_enqueue_script( 'ajax-js', get_template_directory_uri() . '/assets/js/custom.js', array(), '1.0.0', true );
      wp_localize_script( 'ajax-js', 'frontajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'wp_enqueue_scripts', 'wpdocs_theme_name_scripts' );


function load_content() {
    $page = $_POST['page'];
    $posts_per_page = 3;
    $offset = ($page - 1) * $posts_per_page;

    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => $posts_per_page,
        'offset'         => $offset,
    );
    $query = new WP_Query($args);

    ob_start();

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            ?>
	                <h2><?php the_title(); ?></h2>
            <?php
        endwhile;
    endif;

    wp_reset_postdata();

    $output = ob_get_clean();

    echo $output;

    wp_die();
}

add_action('wp_ajax_load_content', 'load_content');
add_action('wp_ajax_nopriv_load_content', 'load_content');