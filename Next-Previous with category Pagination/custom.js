jQuery( document ).ready(function($) {
jQuery(".btn-pagin").on('click',(function(e) {
    //alert('hh');
        
        var tpage = parseInt(jQuery(this).attr('data-totpage'));
        var currpage = parseInt(jQuery(this).attr('data-currpage'));
        var term =  jQuery(this).attr('data-term');     
        
        var ispre = jQuery(this).hasClass('btn-previous');
        var isnext = jQuery(this).hasClass('btn-next');
        var nextpage = 1;
        

        if (isnext) { nextpage = currpage + 1; }
        if (ispre)  { nextpage = currpage - 1; }        
        
        var btnpre = jQuery('.btn-previous');
        var btnnext = jQuery('.btn-next');        
        btnnext.attr('data-currpage', nextpage);
        btnpre.attr('data-currpage', nextpage);
        
        if (nextpage == tpage) { btnnext.hide(); }else{ btnnext.show(); }
        if (nextpage > 1) { btnpre.show(); }else{ btnpre.hide(); }

        jQuery.ajax({
            url:ajax_object.ajax_url,
            type: "POST",
            data: {page : nextpage, action: 'get_next_page_data', term : term},
            beforeSend : function()
            {              
                jQuery("#LoadingImage").fadeIn(1000);
            },
            success: function(data)
            {   
                

                    jQuery(".my-posts").html('');
                    //var parsed_data = JSON.parse(data);
                    jQuery(".my-posts").append(data);                    
                    
                
            },  
            complete: function(){
                jQuery("#LoadingImage").fadeOut(1000);
            },         
            error: function(e){}          
        });
    }));
});