<?php  /*Template name: Number Pagination*/


	 get_header();

$post_type = get_theme_mod( 'twentytwentyone','any' );
     ?>
<form role="search" method="get" class="searchform search-form" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">    
    <input type="text" name="s" id="searchInput" onkeyup="fetchResults()" class="search-field" placeholder="Search..." value="<?php echo get_search_query(); ?>">
    <?php if('any' != $post_type){ ?>
        <input type="hidden" name="post_type" value="<?php echo esc_attr($post_type); ?>">
    <?php } ?><br>    
    
</form>

     <?php 
         
    	$args = array(  
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => 3,            
            'order' => 'DESC',
    	   	'paged' => 1, 
        );

        $loop = new WP_Query( $args ); ?>
        <div class="entry-content" id="datafetch">
        <div class="my-posts">

        	<?php 
            while ( $loop->have_posts() ) : $loop->the_post();
            	the_post_thumbnail($post->ID, array(150, 150), array('class' => 'post-thumbnails')); echo "<br>";
                the_title();                 
                the_excerpt();               
                
            endwhile;
            wp_reset_postdata();
	            
            ?>            
        </div>               
        </div> 
        
            
        <div class='pagin_btns'>
            <div style="display: none;" id="LoadingImage">
    <img width="200px" src="<?php echo get_template_directory_uri(); ?>/assets/images/Loading_icon.gif"/>
</div>
        
        <button style='display: none;' data-totpost='<?php echo $totalpost; ?>' data-totpage='<?php echo $totalpage; ?>' data-currpage='1' class='btn btn-pagin btn-previous'> << Privious</button>&nbsp;
        <?php

        $totalpost = $loop->found_posts;
        $totalpage = $loop->max_num_pages;
        if($totalpage > 1){ ?>

        	&nbsp;<button data-totpost='<?php echo $totalpost; ?>' data-totpage='<?php echo $totalpage; ?>' data-currpage='1' class='btn btn-pagin btn-next' > Next >></button>
		<?php 
	        }    
	     ?>   
	 </div>

<?php get_footer(); ?>
