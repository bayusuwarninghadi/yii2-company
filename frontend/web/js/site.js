$(document).on("click", ".user-action a", function (ev) {
    var this_ = $(ev.currentTarget);
    this_.toggleClass("btn-primary btn-default").find(".fa").toggleClass("fa-truck fa-spin fa-spinner fa-pulse");
    $.ajax({
        url: this_.attr("href"), success: function () {
            this_.find(".fa").toggleClass("fa-truck fa-spin fa-spinner fa-pulse");
        }, error: function () {
            this_.find(".fa").toggleClass("fa-truck fa-spin fa-spinner fa-pulse");
        }
    });
    return false;
});
$(document).ready(function () {
    $(".toggle-view").click(function (ev) {
        var this_ = $(ev.currentTarget);
        $(".product-container").toggleClass("list", this_.hasClass("list"));
    });
    var comment_container = $(".comment-container");
    comment_container.load("/user-comment/index?key=" + comment_container.data("key") + "&id=" + comment_container.data("id"));
    $(".toggle-preview").click(function () {
        var gallery_modal = $("#gallery-modal");
        var gallery_modal_body = gallery_modal.find(".modal-body");
        gallery_modal.modal();
        if (gallery_modal_body.find(".loading").length > 0) {
            gallery_modal_body.load("/product/gallery?id=" + gallery_modal.data("id"), function () {
                gallery_modal_body.find(".carousel").carousel();
            });
        }
    });

    var related_container = $(".related-container");
    if (related_container.length > 0) {
        related_container.load(related_container.data('url'));
    }

    var masonry_grid = $('.grid');
    if (masonry_grid.length > 0) {
        masonry_grid.imagesLoaded(function () {
            masonry_grid.masonry({
                itemSelector: '.grid-item', // use a separate class for itemSelector, other than .col-
                percentPosition: true
            })
        });
    }
});