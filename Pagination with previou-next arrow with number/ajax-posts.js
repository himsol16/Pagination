jQuery(document).ready(function($) {
    function loadPosts(page) {
        $.ajax({
            url: ajax_posts_params.ajax_url,
            type: 'POST',
            data: {
                action: 'load_box_posts',
                paged: page
            },
            beforeSend: function() {
                $('#post-container').addClass('loading');
            },
            success: function(response) {
                $('#post-container').html(response.html);
                $('#post-container').attr('data-page', response.page);

                // Arrow visibility
                $('.arrow-prev').toggle(response.has_prev);
                $('.arrow-next').toggle(response.has_next);

                // Pagination numbers
                const pagination = $('.pagination-numbers');
                pagination.empty();

                for (let i = 1; i <= response.max_pages; i++) {
                    const btn = $('<button class="page-number"></button>').text(i);
                    if (i === response.page) {
                        btn.addClass('active');
                    }
                    btn.data('page', i);
                    pagination.append(btn);
                }
            },
            complete: function() {
                $('#post-container').removeClass('loading');
            }
        });
    }

    // Arrows
    $(document).on('click', '.arrow-prev, .arrow-next', function(e) {
        e.preventDefault();
        const currentPage = parseInt($('#post-container').attr('data-page'));
        const newPage = $(this).hasClass('arrow-next') ? currentPage + 1 : currentPage - 1;
        loadPosts(newPage);
    });

    // Page number click
    $(document).on('click', '.page-number', function(e) {
        e.preventDefault();
        const page = $(this).data('page');
        loadPosts(page);
    });

    // Initial Load
    loadPosts(1);
});
