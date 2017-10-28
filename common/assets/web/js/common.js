$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover({trigger: "hover"});
    $(".show-cart").click(function () {
        $(".cart-pop").load("/transaction/cart");
    });
    function hide_notifications() {
        $(".top-notification .alert").each(function () {
            $(this).delay(5000).slideUp();
        });
    }

    hide_notifications();
    var product_form = $('form#product-search');
    if (product_form.length > 0){
        product_form.find('select').change(function(){
            product_form.submit();
        });
    }
});
$(document).on("change", "[data-dynamic='true']", function (ev) {
    var this_ = $(ev.currentTarget);
    var target_ = $("#" + this_.data("target"));
    var url_ = this_.data("url");
    var val_ = this_.val();
    if (target_.length > 0 && url_ != "" && val_ != "") {
        $.ajax({
            url: url_, data: {id: val_}, success: function (data) {
                if (data) {
                    var dropdown_ = $(data);
                    target_.html(dropdown_.html());
                }
            }
        });
    }
    $('[data-toggle="checkbox"]').click(function(ev){
        var _this = $(ev.currentTarget);
        var _target = _this.attr('data-container-target');
        var _value = (_this.attr('data-value') === 'true');
        if (_target){
            $(_target).find(':checkbox').prop('checked', !_value);
            _this.attr('data-value', !_value);
        }
    });

});