/**
 * Created by bay_oz on 4/17/15.
 */
$(document).ready(function(){
    $('.show-cart').click(function(){
        $('.cart-pop').load('/checkout/cart');
    })
});