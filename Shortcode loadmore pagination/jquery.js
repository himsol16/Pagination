jQuery(document).ready(function ($) {
    $('#load-more').on('click', function () {
        let button = $(this);
        let page = parseInt(button.attr('data-page')) + 1;
        let maxPages = parseInt(button.attr('data-max'));
        let postType = button.attr('data-post-type');
        let postsPerPage = button.attr('data-posts-per-page');

        if (page <= maxPages) {
            $.ajax({
                url : frontajax.ajaxurl,
                type: 'POST',
                data: {
                    action: 'load_more_posts',
                    page: page,
                    post_type: postType,
                    posts_per_page: postsPerPage,
                },
                beforeSend: function () {
                    button.text('Loading...');
                },
                success: function (response) {
                    if (response) {
                        $('#articleslist').append(response);
                        button.attr('data-page', page);
                        button.text('Load More');
                        if (page == maxPages) {
                            button.remove();
                        }
                    } else {
                        button.remove();
                    }
                },
            });
        }
    });
});
