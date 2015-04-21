/**
 * Created by bay_oz on 4/17/15.
 */
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover({trigger: "hover"});
    $('.show-cart').click(function(){
        $('.cart-pop').load('/transaction/cart');
    });
    $('.thumbnail .favorite').click(function(ev){
        var this_ = $(ev.currentTarget);
        this_.toggleClass('btn-success btn-default').find('.fa').toggleClass('fa-truck fa-spin fa-spinner fa-pulse');
        $.ajax({
            url: this_.attr('href'),
            success: function(){
                this_.find('.fa').toggleClass('fa-truck fa-spin fa-spinner fa-pulse');
            },
            error: function(){
                this_.find('.fa').toggleClass('fa-truck fa-spin fa-spinner fa-pulse');
            }
        });
        return false;
    })
});
