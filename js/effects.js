$(document).on('click', '.sprite', function(){
    if($(this).siblings('.track_content').is(':visible')) {
        $(this).siblings('.track_content').fadeOut();
    } else {
        $(this).siblings('.track_content').fadeIn();
    }
});