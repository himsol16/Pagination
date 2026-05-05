<?php 
/*Template Name:CPT*/
get_header(); ?> 

<div id="post-container">
  <?php 
        $args = array(
             'post_type' => 'post',
             'posts_per_page' => 3,
             'post_status'=>'publish',
             'order' => 'DESC',
             'paged' => $paged
        );
        $loop = new WP_Query( $args );
          while ( $loop->have_posts() ) : $loop->the_post(); 

            $total_pages = $loop->max_num_pages;
            ?>
            
          
                <h2><?php the_title(); ?></h2>
                
          
          
           <?php endwhile; 
  ?>
</div>

<button id="prev-btn" data-total="<?php echo $total_pages; ?>">&larr; Previous</button>
<button id="next-btn" data-total="<?php echo $total_pages; ?>">Next &rarr;</button>

<?php get_footer(); ?>