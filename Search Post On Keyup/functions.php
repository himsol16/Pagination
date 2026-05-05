// the ajax function
<?php add_action('wp_ajax_data_fetch' , 'data_fetch');
add_action('wp_ajax_nopriv_data_fetch','data_fetch');
function data_fetch(){
         
    	$args = array(  
            'post_type' => 'post',
            's' => esc_attr( $_POST['keyword'] ),
            'posts_per_page' => 3,            
            'order' => 'DESC',
    	   	'paged' => 1, 
        );

        $loop = new WP_Query( $args ); ?>
        <div class="entry-content" id="datafetch">
        <div class="my-posts">

        	<?php 
        	if( $loop->have_posts() ) :
            while ( $loop->have_posts() ) : $loop->the_post();
            	the_post_thumbnail($post->ID, array(150, 150), array('class' => 'post-thumbnails')); echo "<br>";
                the_title();                 
                the_excerpt();               
                
            endwhile;
            wp_reset_postdata();
	            
            ?>            
        </div>               
        </div>  
	<?php else: 
		echo '<h3>No Results Found</h3>';
    endif;

    die();
}
// add the ajax fetch js
add_action( 'wp_footer', 'ajax_fetch' );
function ajax_fetch() {
?>
<script type="text/javascript">
function fetchResults(){
	var keyword = jQuery('#searchInput').val();
	if(keyword == ""){
		jQuery('#datafetch').html("");
	} else {
		jQuery.ajax({
			url: '<?php echo admin_url('admin-ajax.php'); ?>',
			type: 'post',
			data: { action: 'data_fetch', keyword: keyword  },
			success: function(data) {
				jQuery('#datafetch').html( data );
			}
		});
	}
    

}
</script>

<?php
}