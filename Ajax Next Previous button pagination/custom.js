jQuery(document).ready(function($) {
   
 var currentPage = 1;
 var maxPage = 1; // Initialize maxPage

// Function to load content via AJAX
function loadContent(page) {
    $.ajax({
        url: frontajax.ajax_url,
        type: 'post',
        data: {
            action: 'load_content',
            page: page
        },
        success: function(response) {
            $('#post-container').html(response);
            maxPage = $('#next-btn').data('total'); // Update maxPage after loading content
            hideNavigationButtons(maxPage); // Call to update navigation buttons visibility with maxPage
        }
    });
}

// Load initial content
loadContent(currentPage);

// Previous button click handler
$('#prev-btn').click(function() {
    if (currentPage > 1) {
        currentPage--;
        loadContent(currentPage);
    }
});

// Next button click handler
$('#next-btn').click(function() {
    if (currentPage < maxPage) {
        currentPage++;
        loadContent(currentPage);
    }
});

// Function to hide navigation buttons when not needed
function hideNavigationButtons(maxPage) {
    if (currentPage == 1) {
        $('#prev-btn').hide();
    } else {
        $('#prev-btn').show();
    }
    if (currentPage == maxPage) {
        $('#next-btn').hide();
    } else {
        $('#next-btn').show();
    }
}
});