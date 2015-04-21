/**
 * Created by bay_oz on 4/21/15.
 */

$('.change-status').click(function(){
    var status = $(this).data('status');
    var id = $(this).data('id');
    location.href = '/transaction/change-status?id=' + id + '&status=' + status;
});