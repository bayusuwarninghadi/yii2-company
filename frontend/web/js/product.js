/**
 * Created by bay_oz on 4/18/15.
 */
$(document).ready(function(){
    var comment_container = $(".comment-container");
    comment_container.load('/user-comment/index?key=product&id=' + comment_container.data('id'));
    $('.toggle-preview').click(function(){
        var gallery_modal = $('#gallery-modal');
        var gallery_modal_body = gallery_modal.find('.modal-body');
        gallery_modal.modal();
        if (gallery_modal_body.find('.loading').length > 0) {
            gallery_modal_body.load('/product/gallery?id=' + gallery_modal.data('id'), function(){
                gallery_modal_body.find('.carousel').carousel();
            })
        }
    });
    var related_container = $('.related-product');
    related_container.find('.row').load('/product/related?id=' + related_container.data('id'));
});