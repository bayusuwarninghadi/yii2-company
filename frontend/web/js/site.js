/**
 * Created by bay_oz on 4/17/15.
 */
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover({trigger: "hover"});
    $('.show-cart').click(function(){
        $('.cart-pop').load('/checkout/cart');
    })
});