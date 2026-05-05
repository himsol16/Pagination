<?php 
    get_header();
    
    $category_id = get_queried_object_id();
   
?>
<div class="container" id="main">
   <div class="row">
      <div class="category-header" style="background-image: url('<?php echo $backgroundImageUrl; ?>');">
         <h1><?php single_cat_title(); ?></h1>
         <?php
            // Display category description
            $category_description = category_description();
            if ( ! empty( $category_description ) ) {
                echo '<div class="category-description">' . $category_description . '</div>';
            }
         ?>
      </div>

      <?php
        $queried_object = get_queried_object();
        $term_id = $queried_object->term_id;
        $posts_per_page = 4; // Number of posts per page
        $args = array(    
            'post_type' => 'news',
            'post_status' => 'publish',
            'posts_per_page' => $posts_per_page,
            'tax_query' => array(
                array(
                    'taxonomy' => 'newscategory', // Specify the taxonomy (e.g., category)
                    'field'    => 'term_id',
                    'terms'    => $term_id,
                    'operator' => 'IN',
                ),
            ),
        );
        $news_posts = new WP_Query( $args );

        if ( $news_posts->have_posts() ) :
            $max_pages_latest = $news_posts->max_num_pages;
      ?>
        <div class="blog-list blog-posts-container" data-count="<?php echo ceil($news_posts->found_posts/$posts_per_page); ?>">
            <?php while ( $news_posts->have_posts() ) : $news_posts->the_post(); ?>
                <?php
                    $id = get_the_id();       
                    $products_feat_image = wp_get_attachment_url(get_post_thumbnail_id($id));
                ?>
                <div class="list-box">
                    <?php if($products_feat_image) { ?>
                        <img src="<?php echo $products_feat_image; ?>" alt="<?php echo $alt; ?>" title="<?php echo $title; ?>">
                    <?php } ?>
                    <p class="text"><?php echo get_the_title(); ?></p>
                </div>
            <?php endwhile; ?>
        </div>
      <?php endif; ?>

      <?php if($max_pages_latest > 1){ ?>
        <div id="btn-load-more" class="blog-load-more">
            <button id="cat-load-more-button" class="load-more" data-page="1" data-term-id="<?php echo $term_id; ?>"><?php _e( 'Load More') ?></button>
        </div>
      <?php } ?>

      <div style="display: none;" id="loading-image">
         <img src="<?php echo get_template_directory_uri(); ?>/assets/images/giphy.gif" width="100" height="100">
      </div>
      <!-- End Pagination -->
   </div>
</div>
<style type="text/css">
  .loader-container {
  position: relative;
  width: 100px; /* Adjust width as needed */
  height: 100px; /* Adjust height as needed */
}

#loading-image {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

</style>
<?php get_footer(); ?>
