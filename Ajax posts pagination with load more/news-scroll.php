<?php 
    /*Template Name: News Scroll*/

    get_header();

?>
<div class="iwt-blog-list">
         <?php 
             $posts_per_page = 7; // Number of posts per page
             $publications = new WP_Query([
               'post_type' => 'blog',
               'posts_per_page' => $posts_per_page,                  
               'order' => 'DESC',
               'post_status'=>'publish',
               'paged' => 1
             ]);
             ?>
             <?php if($publications->have_posts()): 
               $max_pages_latest = $publications->max_num_pages;
               
               ?>
            <div class="blog-list blog-posts-container" data-count="<?php echo ceil($publications->found_posts/$posts_per_page); ?>">
               <?php
               while ( $publications->have_posts() ) : $publications->the_post(); 
               $date = get_the_date('d M y');?>
                  <div class="grid-x iwt-recent-post aos-init aos-animate">
                     <div class="cell large-12">
                        <div class="iwt-recpost-content">
                        <div class="post-date">
                           <span><?php echo $date; ?></span>
                        </div>
                        <a href="<?php echo get_the_permalink(); ?>">
                           <h4><?php echo get_the_title(); ?> </h4>
                           <span class="link-row">
                              <span class="link-text"><?php echo __("Lire l’article"); ?></span>
                              <span class="link-arrow"><img src="<?php echo $theme_path; ?>/assets/images/blog-arrow.svg"></span>
                           </span>
                           </a>
                        </div>
                     </div>
                  </div>
               <?php endwhile;?>
            </div>
        <?php endif; ?>
         <?php wp_reset_postdata(); ?>
          <?php if($max_pages_latest > 1){ ?>
         <div class="btn__wrapper">
            <p>
               <a class="btn btn__default blog-load-more" data-page="1">
                  <span class="sunset-icon sunset-loading load-text"><?php echo __("Load more"); ?></span>
                  <span class="load-arrow">
                     <img src="<?php echo $theme_path; ?>/assets/images/yellow-arrow.svg"> 
                  </span>
               </a>
            </p>
            <div style="display: none;" id="loading-image">
               <img src="<?php echo get_template_directory_uri(); ?>/assets/images/loading-icon-animated-gif-19-1.gif"/>
            </div>
         </div>
          <?php } ?>
         <span class="no-more-post"></span>
      </div>
<?php get_footer(); ?>