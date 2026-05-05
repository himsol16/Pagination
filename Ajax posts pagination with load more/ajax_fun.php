<?php 

/*ajax load more function start*/
add_action('wp_ajax_nopriv_blog_load_more','blog_load_more');
add_action('wp_ajax_blog_load_more','blog_load_more');
function blog_load_more(){
    $theme_path = get_template_directory_uri();
    $paged = $_POST["page"] + 1;
    $publications = new WP_Query([
    'post_type' => 'blog',    
    'post_status'=>'publish',
    'order' => 'DESC',                              
    'paged' => $paged
    ]);
if($publications->have_posts()): ?>
    <?php 
        while ($publications->have_posts()): $publications->the_post(); 
        $date = wp_date( 'j M y' );
    ?>
<div class="grid-x iwt-recent-post aos-init aos-animate">
   <div class="cell large-12">
      <div class="iwt-recpost-content">
         <div class="post-date">
            <span><?php echo $date; ?></span>
         </div>
         <a href="<?php echo get_the_permalink(); ?>">
            <h4><?php echo get_the_title(); ?> </h4>
            <span class="link-row">
            <span class="link-text">Lire l’article</span>
            <span class="link-arrow"><img src="<?php echo $theme_path; ?>/assets/images/blog-arrow.svg"></span>
            </span>
         </a>
      </div>
   </div>
</div>
<?php endwhile; ?>      
<?php endif; ?>
<?php wp_reset_postdata(); die();
}
 /*ajax load more function end*/


 /*Load JS*/

 wp_enqueue_script( 'customjs', $theme_path.'/assets/js/custom.js', null, $version, true );
    wp_localize_script( 'customjs', 'iwtAjax', array(
        'ajaxurl'                   => admin_url( 'admin-ajax.php', ( is_ssl() ? 'https' : 'http' ) )
    ));