<?php 


function wpdocs_theme_name_scripts() {
	wp_register_script( 'jQuery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js', true );
wp_enqueue_script('jQuery');

	wp_enqueue_script( 'ajax-filter', get_template_directory_uri() . '/assets/js/custom.js', array(), '1.0.0', true );

	wp_localize_script( 'ajax-filter', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'wp_enqueue_scripts', 'wpdocs_theme_name_scripts' );

add_action('wp_ajax_nopriv_get_next_page_data','get_next_page_data');
add_action('wp_ajax_get_next_page_data','get_next_page_data');

function get_next_page_data()
	{	
		$page = $_POST['page'];
        
		$args = array(  
	        'post_type' => 'post',
	        'posts_per_page' => 3, 
		   	'paged' => $page, 
	    );

		if (!empty($_POST['term'])  ) 
	  	{	$taxonomyName = 'category';
	  		$term = get_term_by('slug', $_POST['term'], $taxonomyName);

	    	$args['tax_query'] = array(
			    array(
			    	'taxonomy' => $taxonomyName,
			    	'field' => 'term_id',
			    	'terms' => $term->term_id
			    )
			);
		}

		$loop = new WP_Query( $args ); 
	    
	    while ( $loop->have_posts() ) : $loop->the_post();

	    	echo get_the_post_thumbnail($post->ID, array(150, 150), array('class' => 'post-thumbnails')); echo "<br>";
                the_title();                 
                the_excerpt(); 
	    endwhile;
	    die();
	}

?>