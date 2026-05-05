jQuery(document).ready(function($) {
jQuery(document).on('click', '#cat-load-more-button', function() {
    var that = jQuery(this);
    var page = that.data('page');
    var termId = that.data('term-id'); // Fetch the term ID from the button's data attribute
    var newpage = page + 1;    
    var post_count = jQuery('.blog-list').data('count');
    jQuery('#loading-image').show();
    jQuery.ajax({
    type: 'POST',
    url: frontajax.ajax_url,
    data: {
        page: newpage, // Pass the next page number
        term_id: termId, // Pass the term ID to the server
        action: 'category_load_posts'
    },
    error: function(response) {
        console.log(response);
    },
    success: function(response) {
        that.data('page', newpage);
        jQuery('.blog-posts-container').append(response);
        if (post_count == newpage) {
            jQuery('.blog-load-more').hide();
        }
    },
    complete: function() {
        jQuery('#loading-image').hide();
    }
});
});
});