jQuery( document ).on( 'click', '.pt-like-it', function() {
    var post_id = jQuery(this).find('.like-button').attr('data-id'),
        nonce = jQuery(this).find('.like-button').attr("data-nonce");

    jQuery.ajax({
        url : likeit.ajax_url,
        type : 'post',
        data : {
            action : 'pt_like_it',
            post_id : post_id,
            nonce : nonce
        },
        success : function( response ) {
            jQuery('#like-count-'+post_id).html( response );
        }
    });

    return false;
})