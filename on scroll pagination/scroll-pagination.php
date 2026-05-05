<?php 
    /*Template name: Scroll Pagination*/


     get_header();

?>

<div class="entry-content">
    <?php
    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 5,
        'paged' => 1,
    );
    $my_posts = new WP_Query( $args );
    ?>
 
    <?php if ( $my_posts->have_posts() ) : ?>
        <div class="my-posts">
            <?php while ( $my_posts->have_posts() ) : $my_posts->the_post(); ?>
                <h2><?php the_title(); ?></h2>
                <?php the_excerpt(); ?>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        </div>        
    <?php endif; ?>
     <div style="display: none;" id="LoadingImage">
    <img  src="<?php echo get_template_directory_uri(); ?>/assets/images/download.png"/>
</div>
</div><!-- .entry-content -->

<style type="text/css">
    #LoadingImage {
    /*height: 100%;
    width: 100%;*/
    position: fixed;
    z-index: 1;
    left: 40%;
    top: 40%;
    overflow-x: hidden;
    /*background: rgba(0,0,0,0.6);*/
    display: none;
}
</style>
<?php get_footer(); ?>
