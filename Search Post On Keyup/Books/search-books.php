<?php
/*
Template Name: Book Search
*/
?>

<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <div id="books-search">
            <input type="text" id="search-books-input" placeholder="Search Books">
            <div id="search-results"></div>
        </div>

    </main><!-- #main -->
</div><!-- #primary -->

<script>
    jQuery(document).ready(function ($) {
        $('#search-books-input').keyup(function () {
            var searchValue = $(this).val();

            if (searchValue.trim() === '') {
                $('#search-results').hide(); // If input is empty, hide search results
                return;
            }

            $.ajax({
                type: 'POST',
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                data: {
                    action: 'search_books',
                    search_value: searchValue,
                },
                success: function (response) {
                    $('#search-results').html(response).show(); // Show search results when there's content
                }
            });
        });

        // Hide search results when input field is empty
        $('#search-books-input').blur(function () {
            if ($(this).val().trim() === '') {
                $('#search-results').hide();
            }
        });
    });
</script>

<?php get_footer(); ?>


<style type="text/css">
    #books-search {
    margin-bottom: 20px;
}

#search-results {
    /*display: flex;*/
    flex-wrap: wrap;
}

.book-item {
    width: calc(33.33% - 20px);
    margin: 0 10px 20px;
    padding: 15px;
    border: 1px solid #ddd;
}

.book-item h2 {
    margin-top: 0;
}

@media (max-width: 767px) {
    .book-item {
        width: calc(50% - 20px);
    }
}

@media (max-width: 479px) {
    .book-item {
        width: 100%;
    }
}

</style>


