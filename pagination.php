==============================================================================
Pagination in Wordpress using AJAX
----------------------------

PAGE CODE
/////////////
<div class="nos-relationship-item realisation-pagination"> <!-- do not remove "" class -->
    <?php } 
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args = array(
        'post_type'=> 'realisation',
        'order'    => 'ASC',
        'orderby'  => 'date',
        'posts_per_page'=> '4',
        'paged'=> $paged
    );              
    $the_query = new WP_Query( $args );
    
    $postPerPage = $the_query->post_count;
    $half = $postPerPage/2 ;
    $numberPages = $the_query->max_num_pages;
    $i= 1;
    if($the_query->have_posts() ) {
        while ($the_query->have_posts()) {
            $the_query->the_post(); 
            // Setup this post for WP functions (variable must be named $post).
            setup_postdata($the_query); ?>
                <div class="nox-service-item-box">
                    <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(),'full'); ?>" alt="service-relationship-1">
                    <a href="<?php the_permalink(); ?>" class="nos-card-link"><?php the_title(); ?></a>
                </div>
        <?php  } ?>
    <?php } ?>
</div>
<ul>
    <?php
    for ($i = 1; $i <= $numberPages; $i++) {
        echo '<li><a name="page" href="#" class="pagination" value="' . $i . '" data-totalpage="' . $i . '" data-currpage="' . $i . '">'. $i . '</a></li>';
    }
    ?>
</ul>


JS CODE
/////////////
jQuery(document).ready(function(){
    var firstPage = jQuery('[data-currpage="1"]');
  firstPage.addClass("active");
    jQuery('li a.pagination').on('click', function () {
        var pageNumbrClicked = jQuery(this).text();
     
  
        console.log(custom_ajax_object.ajax_url);
        alert(pageNumbrClicked);
        jQuery.ajax({
            url: custom_ajax_object.ajax_url,
            type: 'post', 
            dataType: 'JSON',
            data: { 
                action: 'pagination_data_fetch', 
                paged: pageNumbrClicked
            },
            success: function(data) {
              console.log(data);
                jQuery('div.realisation-pagination').html(data.html);
                var firstPage = jQuery('[data-currpage="1"]');
        firstPage.removeClass("active");
                var currentPage = jQuery('[data-currpage="' + pageNumbrClicked + '"]');
                currentPage.addClass("active");
            },
            error: function(error) {
                console.log('failed');
            }
        });
    });
});

FUNCTIONS.PHP CODE
/////////////

/**
 * Enqueue scripts and styles.
 */
function xfive_scripts() {
  $version = time();
  // pagination js
  wp_enqueue_script( 'pagination', get_template_directory_uri() . '/js/pagination.js', null, $version, true);
  wp_localize_script('pagination', 'custom_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action( 'wp_enqueue_scripts', 'xfive_scripts' );
// Pagination AJAX function
add_action('wp_ajax_pagination_data_fetch' , 'pagination_data_fetch');
add_action('wp_ajax_nopriv_pagination_data_fetch','pagination_data_fetch');
function pagination_data_fetch(){
  // print_r($_POST); 
  $query_args = array(
    'post_type'=> 'realisation',
      'order'    => 'ASC',
      'posts_per_page'=> '4',
      'paged'=> $_POST['paged']
  );
  $the_query = new WP_Query($query_args);

    
    $numberPages = $the_query->max_num_pages;
    if($the_query->have_posts() ) {
      ob_start();
      while ($the_query->have_posts()) {
      $the_query->the_post(); 
      // Setup this post for WP functions (variable must be named $post).
          setup_postdata($the_query); 
           ?>
          <div>
                <a href="<?php the_permalink(); ?>">
                    <div class="">
                        <div>
                            <picture>
                                <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(),'full'); ?>" alt="" loading="eager" alt="Packaging design" class="project-thumbnail"/>
                            </picture>
                            <h5><?php the_title(); ?></h5>
                            <div class="case-overlay"></div>
                        </div>
                    </div>
                </a>
            </div>
      <?php } ?>
    <?php $output = ob_get_contents();
    ob_end_clean();
  } else { 
    $response = '';
  }
  $result = [
    // 'post'=> $ajaxposts, 
    'max' => $max_pages,
    'html' => $output,
  ];

  
  
  echo json_encode($result);  
    die();
}

