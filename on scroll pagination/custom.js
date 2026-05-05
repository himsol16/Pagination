jQuery(function($) {
    var page = 1;
    var loading = false;
    var finished = false;
    var noMorePostsMsg = 'No more posts to load';

    $(window).scroll(function() {
        if ($(window).scrollTop() + $(window).height() > $(document).height() - 100 && !loading && !finished) {
            loading = true;
            page++;
            $("#LoadingImage").fadeIn(1000);
            $.ajax({
                url: frontajax.ajax_url,
                type: 'post',
                data: {
                    action: 'scroll_more_posts',
                    offset: (page - 1) * 5 // 5 is the number of posts per page
                },
                success: function(response) {
                    if (response) {
                        $("#LoadingImage").fadeOut(1000);
                        $('.my-posts').append(response);
                        loading = false;
                    } else {
                        finished = true;
                        // Display message when no more posts
                        $('.my-posts').append('<p>' + noMorePostsMsg + '</p>');
                        $("#LoadingImage").fadeOut(1000);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    // Handle error, maybe display an error message to the user
                }
            });
        }
    });
});