<?php 

function wpdocs_theme_name_scripts() {
    
    //Proper way to enqueue script

    wp_enqueue_script( 'ajax-js', get_template_directory_uri() . '/assets/js/custom.js', array(), '1.0.0', true );
      wp_localize_script( 'ajax-js', 'frontajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'wp_enqueue_scripts', 'wpdocs_theme_name_scripts' );


add_action('wp_ajax_my_custom_pagination', 'my_custom_pagination');
add_action('wp_ajax_nopriv_my_custom_pagination', 'my_custom_pagination');

function my_custom_pagination() {
    $paged = $_POST['page'];
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 3, // Adjust this based on your needs
        'paged' => $paged
    );
    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            // Display your post content here
            echo '<h2>' . get_the_title() . '</h2>';            
        endwhile;
    else :
        echo 'No posts found';
    endif;

    wp_die(); // Always end AJAX functions with this
}

?>