<?php 
function wpdocs_theme_name_scripts() {
    
    //Proper way to enqueue script

    wp_enqueue_script( 'ajax-js', get_template_directory_uri() . '/assets/js/custom.js', array(), '1.0.0', true );
      wp_localize_script( 'ajax-js', 'frontajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'wp_enqueue_scripts', 'wpdocs_theme_name_scripts' ); ?>


<?php 
add_action('wp_ajax_category_load_posts', 'category_load_posts');
add_action('wp_ajax_nopriv_category_load_posts', 'category_load_posts');

function category_load_posts() {
    $term_id = $_POST['term_id'];
    $page = $_POST['page'];

    $args = array(
        'post_type' => 'news',
        'post_status' => 'publish',
        'posts_per_page' => 4,
        'paged' => $page,
        'tax_query' => array(
            array(
                'taxonomy' => 'newscategory', // Specify the taxonomy (e.g., category)
                'field'    => 'term_id',
                'terms'    => $term_id,
                'operator' => 'IN',
            ),
        )        
    );

    $news_posts = new WP_Query($args);

    if ($news_posts->have_posts()) :
        while ($news_posts->have_posts()) :
            $news_posts->the_post();
            $id = get_the_id();
            $products_feat_image = wp_get_attachment_url(get_post_thumbnail_id($id));
            ?>
            <div class="list-box">
                <?php if ($products_feat_image) { ?>
                    <img src="<?php echo $products_feat_image; ?>" alt="<?php echo $alt; ?>" title="<?php echo $title; ?>">
                <?php } ?>
                <p class="text"><?php echo get_the_title(); ?></p>
            </div>
        <?php endwhile;
    endif;

    wp_die();
}