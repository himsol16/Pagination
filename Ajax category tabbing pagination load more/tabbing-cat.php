<?php
   /*
   Template Name: Custom Posts Template
   */
   
   get_header(); ?>
<div class="container">
   <ul class="tabs">
      <?php 
         // Define arguments for fetching categories
         $wsubargs = array(
             'hierarchical' => 1,
             'hide_empty' => 1, // Only show categories with posts
             'taxonomy' => 'category',
             'orderby' => 'slug'
         );
         
         // Get categories based on arguments
         $wsubcats = get_categories($wsubargs);
         
         // Counter for tab index
         $i = 1;
         
         // Loop through the categories
         foreach ($wsubcats as $wsc):
             // Skip 'Uncategorized' category
             if ($wsc->name == 'Uncategorized') {
                 continue;
             }
         
             // Get the term ID
             $term_id = $wsc->term_id;
         ?>
      <li class="tab-link <?php if($i==1){ echo 'current'; } ?>" data-tab="tab-<?php echo $i; ?>"><?php echo $wsc->name; ?></li>
      <?php $i++; endforeach; wp_reset_query(); ?>
   </ul>
   <?php 
      $j=1;
      $terms_cat = array(
      'hierarchical' => 1,
      'show_option_none' => '',
      'hide_empty' => 0,                                   
      'taxonomy' => 'category',                                  
      'orderby' => 'slug'
      );
      $terms = get_categories($terms_cat);
      
      
            foreach( $terms as $term){ 
                      $posts_per_page = 2;
                      $args = array('post_type' => 'post',
                        'post_status' => 'publish',
                        'posts_per_page' => $posts_per_page,                                 
                        'order' => 'DESC',
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'category',
                                'field' => 'slug',
                                'terms' => $term->slug
                            ),                                                  
                        )
                    );
                    $query = new WP_Query($args);
                                
                           
                  ?>
   <div id="tab-<?php echo $j; ?>" class="tab-content <?php if($j==1){ echo 'current'; } ?>">
      <div class="row">
         <?php 
            while ($query->have_posts()): $query->the_post();                                  
                  $term_id = $term->term_id;
                  $max_pages_latest = $query->max_num_pages;
                  
            ?>  
         <div class="blog-list col-md-4 <?= $term->slug; ?>" data-count="<?php echo ceil($query->found_posts/$posts_per_page); ?>">
            <div class="htext">
               <a href="<?php the_permalink(); ?>"><h4><?php the_title(); ?></h4></a>
            </div>
         </div>
         <?php  endwhile; wp_reset_query(); ?> 
      </div>
      <?php if($max_pages_latest > 1){ ?>
       <button class="load-more" data-page="2" data-term="<?php echo $term->slug; ?>">Load More</button>
       <?php } ?>
   </div>
   <?php $j++; } wp_reset_query(); ?>

   <div style="display: none;" id="loading-image">
         <img src="<?php echo get_template_directory_uri(); ?>/assets/images/giphy.gif" width="100" height="100">
      </div>
</div>
<!-- container -->
<style type="text/css">
   body{
   margin-top: 100px;
   font-family: 'Trebuchet MS', serif;
   line-height: 1.6
   }
   .container{
   width: 800px;
   margin: 0 auto;
   }
   ul.tabs{
   margin: 0px;
   padding: 0px;
   list-style: none;
   }
   ul.tabs li{
   background: none;
   color: #222;
   display: inline-block;
   padding: 10px 15px;
   cursor: pointer;
   }
   ul.tabs li.current{
   background: #ededed;
   color: #222;
   }
   .tab-content{
   display: none;
   background: #ededed;
   padding: 15px;
   }
   .tab-content.current{
   display: inherit;
   }
   .htext h4 {margin-bottom: 10px;}
   
</style>
<script type="text/javascript">
   jQuery(document).ready(function($){
   
   jQuery('ul.tabs li').click(function(){
     var tab_id = jQuery(this).attr('data-tab');
   
     jQuery('ul.tabs li').removeClass('current');
     jQuery('.tab-content').removeClass('current');
   
     jQuery(this).addClass('current');
     jQuery("#"+tab_id).addClass('current');
   })
   
   })
</script>

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
<?php
get_footer();