/**
 * Created by bay_oz on 4/18/15.
 */
$(document).ready(function(){
    var comment_container = $(".comment-container");
    comment_container.load('/user-comment/index?key=product&id=' + comment_container.data('id'));
});