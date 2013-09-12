$(document).on('click', '.sprite', function(){
    var ch = $(this).siblings('.track_content');
    var pr = $(this).parent().parent();

    if(ch.is(':visible')) {
        pr.children('div').children('.track_content').each(function() {$(this).fadeOut();});
    } else {
        pr.children('div').children('.track_content').each(function() {$(this).fadeIn();});
    }
});