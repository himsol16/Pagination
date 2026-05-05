/*blog CPT ajax pagination start*/
jQuery(document).on('click','.blog-load-more',function(){
    var that = jQuery(this)
    var page = that.data('page');
    var newpage = page + 1;
    var ajaxurl = that.data('url');
    var post_count = jQuery('.blog-list').data('count');
    jQuery('#loading-image').show();
    jQuery.ajax({
        type: 'POST',
        url : iwtAjax.ajaxurl,
        data : {
            page : page,
            action : 'blog_load_more'
        },
        error : function(response){
            console.log(response);

        },
        success : function(response){
            that.data('page',newpage);
            jQuery('.blog-posts-container').append(response);
            if(post_count == newpage){
                jQuery('.blog-load-more').hide();
            }
        },
        complete: function(){
        jQuery('#loading-image').hide();
      }
    });
    
});
/*blog CPT ajax pagination End*/