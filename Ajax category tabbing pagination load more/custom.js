jQuery(document).ready(function($) {
    $(".load-more").click(function() {
        var button = $(this),
            page = button.data('page'),
            term = button.data('term'),
            postsPerPage = button.closest('.tab-content').find('.blog-list').data('count'); // Get posts count for current tab
            jQuery('#loading-image').show();
        $.ajax({
            url: frontajax.ajax_url,
            type: 'POST',
            data: {
                action: 'load_posts_by_ajax',
                page: page,
                term: term
            },
            error: function(response) {
                console.log(response);
            },
            success: function(response) {
                if (response) {
                    button.data('page', page + 1); // Increment page number
                    button.prev().append(response);
                }
                if (response.length < postsPerPage) {
                    button.hide(); // Hide the button when all posts are loaded
                }

            },
             complete: function() {
                jQuery('#loading-image').hide();
            }
        });
    });

    // Show/hide Load More button when tabs are clicked
    $('.tab-link').click(function() {
        $('.load-more').hide(); // Hide all Load More buttons
        var currentTab = $(this).attr('data-tab');
        $('#' + currentTab).find('.load-more').show(); // Show Load More button for current tab
    });
});