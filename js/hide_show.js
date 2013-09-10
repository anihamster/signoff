$(document).on('click', '.closed', function() {
        $(this).parent().siblings('.project_details').show();
        $(this).attr('class', 'opened');
});
$(document).on('click', '.opened', function() {
        $(this).parent().siblings('.project_details').hide();
        $(this).attr('class', 'closed');
});
$(document).on('click', '.show', function() {
    $(this).siblings('.prj').show();
    $(this).attr('class', 'hide');
});
$(document).on('click', '.hide', function() {
    $(this).siblings('.prj').hide();
    $(this).attr('class', 'show');
});