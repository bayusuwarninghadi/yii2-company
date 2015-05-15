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
            url: '/product/delete-product-attribute?id=' + container_.data('id'),
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
        var detail = prompt("Enter Detail Attribute\nSize, Ram size, Resolution etc");

        if (detail == null) {
            return false;
        }

        $('.custom-detail').append('' +
        '<div class="form-group field-product-productDetail-' + detail + '">' +
        '<div class="input-group">' +
        '<span class="input-group-addon">' +
        '<label class="control-label" for="product-productDetail-' + detail + '">' + detail + '</label>' +
        '</span>' +
        '<input type="text" id="product-productDetail-' + detail + '" class="form-control" name="Product[productDetail][' + detail + ']">' +
        '<span class="input-group-btn">' +
        '<a class="btn btn-danger btn-remove-detail"><i class="fa fa-trash-o"></i></a>' +
        '</span>' +
        '</div>' +
        '</div>');
        return false;
    });
    $('.custom-detail').on('click', '.btn-remove-detail', function () {
        $(this).closest('.form-group').remove();
        return false
    });
});