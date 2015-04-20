/**
 * Created by bay_oz on 4/19/15.
 */
$(document).ready(function(){
    $('.gallery-container:not(.active)').click(function(ev){
        var this_ = $(ev.currentTarget);
        this_.find('.gallery').html('<i class="fa fa-spin fa-spinner fa-pulse fa-5x fa-inverse"></i>');
        var container_ = this_.parent();
        $.ajax({
            type: "POST",
            url: '/product/set-cover?id=' + container_.data('product'),
            data: {
                imageUrl: container_.data('url')
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
    });
    $('.product-gallery .btn-danger').click(function(ev){
        //confirmed?
        if ( ! confirm('Are you sure to delete this item?')) return false;

        var this_ = $(ev.currentTarget);
        var container_ = this_.parent();

        container_.find('.gallery').html('<i class="fa fa-spin fa-spinner fa-pulse fa-5x fa-inverse"></i>');
        $.ajax({
            type: "POST",
            url: '/product/delete-product-attribute?id=' + container_.data('id'),
            success: (function () {
                container_.remove();
            }),
            error: (function () {
                container_.find('.gallery .fa').remove();
            })
        });
        return false;
    })
});