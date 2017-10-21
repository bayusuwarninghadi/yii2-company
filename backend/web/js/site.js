$(function () {
    $('.category-index-tree>ul').metisMenu();
});
$('.change-status').click(function () {
    var status = $(this).data('status');
    var id = $(this).data('id');
    location.href = '/transaction/change-status?id=' + id + '&status=' + status;
});
$(document).ready(function () {
    $('.gallery-container').click(function (ev) {
        var this_ = $(ev.currentTarget);
        if (this_.hasClass('active')){
            return false;
        }
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
    $('.product-gallery .btn-danger').click(function (ev) {
        //confirmed?
        if (!confirm('Are you sure to delete this item?')) return false;

        var this_ = $(ev.currentTarget);
        var container_ = this_.parent();

        container_.find('.gallery').html('<i class="fa fa-spin fa-spinner fa-pulse fa-5x fa-inverse"></i>');
        $.ajax({
            type: "POST",
            url: this_.attr('href'),
            success: (function () {
                container_.remove();
            }),
            error: (function () {
                container_.find('.gallery .fa').remove();
            })
        });
        return false;
    });
    $('.add-detail').click(function () {
        var detail = prompt("Enter Detail Attribute\nSize, Color, Resolution etc");

        if (detail == null) {
            return false;
        }

        $('.custom-detail').append('' +
        '<div class="form-group field-product-detailValue-' + detail + '">' +
        '<div class="input-group">' +
        '<span class="input-group-addon">' +
        '<label class="control-label" for="product-detailValue-' + detail + '">' + detail + '</label>' +
        '</span>' +
        '<input type="text" id="product-detailValue-' + detail + '" class="form-control" name="Pages[detail][' + detail + ']">' +
        '<span class="input-group-btn">' +
        '<a class="btn btn-danger btn-remove-detail"><i class="fa fa-trash-o"></i></a>' +
        '</span>' +
        '</div>' +
        '</div>');
        $('#product-detailValue-' + detail).focus();
        return false;
    });
    $('.custom-detail').on('click', '.btn-remove-detail', function () {
        $(this).closest('.form-group').remove();
        return false
    });

    $('.toggle-search').click(function(){
        $('.product-wrapper').toggleClass('show-sidebar');
        return false;
    });

    $("#selectorModal button").click(function () {
        var _icon = $(this).find("i").attr("class").split(" ")[2];
        var target_input = $(this).data('target-input');
        if (target_input){
            $(target_input).val(_icon);
        }

        var target_icon = $(this).data('target-icon');
        if (target_icon){
            $(target_icon).removeClass($(target_icon).data("current")).addClass(_icon).data("current", _icon);
        }

        $("#selectorModal").modal("hide");
        return false;
    });

    $('#icon-search input[name="icon-search"]').keyup(function (ev) {
        var this_ = $(ev.currentTarget);
        var val_ = this_.val();
        var container_ = this_.closest("#icon-search").find(".icon-container");
        container_.find(".icon").hide().find('.icon-text:contains("' + val_ + '")').closest(".icon").show();
    });
});
