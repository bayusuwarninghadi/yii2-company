/**
 * Created by bay_oz on 4/19/15.
 */
$(document).ready(function(){
    $('.gallery-container:not(.active)').click(function(ev){
        var this_ = $(ev.currentTarget);
        this_.find('.gallery').html('<i class="fa fa-spin fa-spinner fa-pulse fa-5x fa-inverse"></i>');
        $.ajax({
            type: "POST",
            url: '/product/set-cover?id=' + this_.data('product'),
            data: {
                imageUrl: this_.data('url')
            },
            success: (function () {
                $('.product-gallery .gallery-container').removeClass('active');
                this_.addClass('active');
                this_.find('.gallery .fa').remove();
            }),
            error: (function () {
                this_.find('.gallery .fa').remove();
            })
        });
        return false;
    })
});