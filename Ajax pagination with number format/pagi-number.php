<?php 
/*Template Name: PagiNUM*/
get_header(); ?> 

<div id="post-container">
  <?php 
    // Initialize the pagination with the first page of posts
    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => 3,
        'post_status'    => 'publish',
        'order'          => 'DESC',
        'paged'          => 1 // Specify the page to load initially
    );
    $loop = new WP_Query( $args );
    while ( $loop->have_posts() ) : $loop->the_post(); 
        $total_pages = $loop->max_num_pages;
  ?>
   <div class="post">
      <h2><?php the_title(); ?></h2>                
   </div>
<?php endwhile; ?>
</div>

<div class="pagination">
    <a href="#" class="prev-page disabled" data-total="<?php echo $total_pages; ?>">Previous</a>
    <?php 
    for ($i = 1; $i <= $total_pages; $i++) {
        echo '<a href="#" class="page-link' . ($i === 1 ? ' active' : '') . '" data-page="' . $i . '">' . $i . '</a>';
    }
    ?>
    <a href="#" class="next-page" data-total="<?php echo $total_pages; ?>">Next</a>
</div>
<div style="display: none;" id="loading-image">
   <img src="<?php echo get_template_directory_uri(); ?>/assets/images/giphy.gif" width="100" height="100">
</div>
<style type="text/css">
      .page-link{margin-right: 10px;border-style: solid;border-radius: 50%;padding: 10px;border: 3px solid #000;}

      .disabled {
    opacity: 0.5;
    pointer-events: none;
}
</style>
<?php get_footer(); ?>