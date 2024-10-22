


function getNotifications() {
    var html="";
    $('#notifiDetails').html("");
    $.ajax({
        type: 'GET',
        url: "/GetNotifications/",
        dataType: 'json',
        success: function (data) {
            $('.count_notifications').html(data.count);
            $.each(data.notificaciones, function(index, element) {
                html+="<div class='dropdown-divider'></div>"
                html+="<a href='#' class='dropdown-item' style='overflow: hidden;'>"
                html+="<i class='"+getNotifiIcon(element.data.status)+" mr-2'></i>"+element.data.msg
                html+="<span class='float-right text-muted text-sm'><small><i class='far fa-clock  mr-0'>"+moment.utc(element.created_at).fromNow()+"</i></small></span>"
                html+="</a>"
            });
            $('#notifiDetails').html(html);

        }
    });
};


function getNotifiIcon(type){
    switch(type) {
      case 'OK':
            return "text-info fas fa-check-circle";
        break;
      case 'Alert':
            return "text-warning fas fa-exclamation-triangle";
        break;
      case 'Error':
            return "text-danger fas fa-exclamation-circle";
        break;
      default:
            return "";
        break;
    }
}

