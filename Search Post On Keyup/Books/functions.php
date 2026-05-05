<?php // Register Custom Post Type
function custom_post_type_books() {
    $labels = array(
        'name'                  => _x( 'Books', 'Post Type General Name', 'text_domain' ),
        'singular_name'         => _x( 'Book', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'             => __( 'Books', 'text_domain' ),
        'archives'              => __( 'Book Archives', 'text_domain' ),
        'attributes'            => __( 'Book Attributes', 'text_domain' ),
        'parent_item_colon'     => __( 'Parent Book:', 'text_domain' ),
        'all_items'             => __( 'All Books', 'text_domain' ),
        'add_new_item'          => __( 'Add New Book', 'text_domain' ),
        'add_new'               => __( 'Add New', 'text_domain' ),
        'new_item'              => __( 'New Book', 'text_domain' ),
        'edit_item'             => __( 'Edit Book', 'text_domain' ),
        'update_item'           => __( 'Update Book', 'text_domain' ),
        'view_item'             => __( 'View Book', 'text_domain' ),
        'view_items'            => __( 'View Books', 'text_domain' ),
        'search_items'          => __( 'Search Books', 'text_domain' ),
        'not_found'             => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
        'featured_image'        => __( 'Featured Image', 'text_domain' ),
        'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
        'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
        'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
        'insert_into_item'      => __( 'Insert into Book', 'text_domain' ),
        'uploaded_to_this_item' => __( 'Uploaded to this Book', 'text_domain' ),
        'items_list'            => __( 'Books list', 'text_domain' ),
        'items_list_navigation' => __( 'Books list navigation', 'text_domain' ),
        'filter_items_list'     => __( 'Filter Books list', 'text_domain' ),
    );
    $args = array(
        'label'                 => __( 'Book', 'text_domain' ),
        'description'           => __( 'Books', 'text_domain' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-book-alt',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'rewrite'               => array( 'slug' => 'books' ),
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
    );
    register_post_type( 'book', $args );
}
add_action( 'init', 'custom_post_type_books', 0 );


add_action('wp_ajax_search_books', 'search_books');
add_action('wp_ajax_nopriv_search_books', 'search_books');

function search_books() {
    $search_value = $_POST['search_value'];

    $args = array(
        'post_type' => 'book',
        'posts_per_page' => -1,
        's' => $search_value,
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post(); ?>

            <div class="book-item">
                <h2><?php the_title(); ?></h2>
                <div class="book-content"><?php the_excerpt(); ?></div>
            </div>

        <?php endwhile;
        wp_reset_postdata();
    else :
        echo '<p>No books found</p>';
    endif;

    die();
}
