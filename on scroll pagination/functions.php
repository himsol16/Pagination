<?php 

function wpdocs_theme_name_scripts() {
    
    //Proper way to enqueue script

    wp_enqueue_script( 'ajax-js', get_template_directory_uri() . '/assets/js/custom.js', array(), '1.0.0', true );
      wp_localize_script( 'ajax-js', 'frontajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'wp_enqueue_scripts', 'wpdocs_theme_name_scripts' );


function scroll_more_posts() {
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 5,
        'offset' => $_POST['offset']
    );

    $posts = new WP_Query($args);

    if ($posts->have_posts()) :
        while ( $posts->have_posts() ) : $posts->the_post(); ?>
                <h2><?php the_title(); ?></h2>
                <?php the_excerpt(); ?>
            <?php endwhile;
    endif;

    wp_reset_postdata();

    die();
}
add_action('wp_ajax_scroll_more_posts', 'scroll_more_posts');
add_action('wp_ajax_nopriv_scroll_more_posts', 'scroll_more_posts');