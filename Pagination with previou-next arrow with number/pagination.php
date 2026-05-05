<?php 
/* Template Name: Pagination */
get_header();

echo do_shortcode('[ajax_box_posts]');
?>

<style type="text/css">
  .grid-box-posts {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}
.box-post {
    border: 1px solid #ccc;
    padding: 15px;
    border-radius: 8px;
    background: #f9f9f9;
}
.pagination-buttons {
    margin-top: 20px;
    display: flex;
    justify-content: space-between;
}
button.arrow-prev, button.arrow-next {
    padding: 10px 20px;
    background: #0073aa;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
button.arrow-prev:hover, button.arrow-next:hover {
    background: #005177;
}

.pagination-numbers {
    display: flex;
    gap: 6px;
    margin: 0 10px;
}

.pagination-numbers .page-number {
    background: #eee;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
    border-radius: 4px;
}

.pagination-numbers .page-number.active {
    background: #0073aa;
    color: #fff;
}


</style>
<?php 
get_footer();
?>
