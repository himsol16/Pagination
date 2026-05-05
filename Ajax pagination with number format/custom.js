jQuery(document).ready(function($) {
    // Load posts for the initial page
    loadPosts(1);

    $('.pagination').on('click', '.page-link', function(e) {
        e.preventDefault();
        var page = parseInt($(this).text());
        loadPosts(page);
    });

    $('.prev-page').on('click', function(e) {
        e.preventDefault();
        var currentPage = parseInt($('.page-link.active').text());
        if (currentPage > 1) {
            loadPosts(currentPage - 1);
        }
    });

    $('.next-page').on('click', function(e) {
        e.preventDefault();
        var currentPage = parseInt($('.page-link.active').text());
        var totalPages = parseInt($('.next-page').data('total'));
        if (currentPage < totalPages) {
            loadPosts(currentPage + 1);
        }
    });

    function loadPosts(page) {
        $('#loading-image').show();
        $.ajax({
            url: frontajax.ajax_url,
            type: 'POST',
            data: {
                action: 'my_custom_pagination',
                page: page
            },
            success: function(response) {
                $('#post-container').html(response);
                $('.page-link').removeClass('active');
                // Update page links dynamically based on total pages
                updatePageLinks(page);
                // Set current page as active
                $('.page-link[data-page="' + page + '"]').addClass('active');
                // Enable/disable previous and next buttons
                $('.prev-page').toggleClass('disabled', page === 1);
                $('.next-page').toggleClass('disabled', page === parseInt($('.next-page').data('total')));
            },
            complete: function() {
                $('#loading-image').hide();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    function updatePageLinks(currentPage) {
        var totalPages = parseInt($('.next-page').data('total'));
        var pageLinks = $('.pagination').find('.page-link');
        pageLinks.remove();
        var startPage = Math.max(1, currentPage - 1);
        var endPage = Math.min(totalPages, currentPage + 1);
        for (var i = startPage; i <= endPage; i++) {
            $('.next-page').before('<a href="#" class="page-link' + (i === currentPage ? ' active' : '') + '" data-page="' + i + '">' + i + '</a>');
        }
    }
});