$(document).ready(function() {
    $('#techlist').click(function() {
        var prj = $('.prj').attr('id');

        $.ajaxSetup({
            async: false
        });

        $.getJSON(
            BaseUrl + '/ajax/default/gettech/?prj='+prj,
            function(data) {
                var response = data.result

                var html="";

                for(var i in response) {
                    var obj = response[i];

                    if(response[i].checked == 1) {
                        html += "<input type=\"checkbox\" name=\"assigned\" class=\"assigned\" value=\""+response[i].id+"\" checked />"+response[i].name+"<br />";
                    } else {
                        html += "<input type=\"checkbox\" name=\"assigned\" class=\"assigned\" value=\""+response[i].id+"\" />"+response[i].name+"<br />";
                    }
                }

                html += "<br /><a href=\"Javascript:void[0]\" id=\"savebutton\" class=\"button orange\">Add to signs list</a>"

                $('#usrs').html(html);

                $('#techlist').hide();
            }
        );
    });

    $('#sign_that').click(function() {
        $('#approveModal').arcticmodal();
    });

    $('#cancel').click(function() {
        $('#cancelModal').arcticmodal();
    });

    $('#ask').click(function() {
        $('#askModal').arcticmodal();
    });
});

$(document).on('click', '#approve-comment', function() {
    var task = $(this).siblings('input').val();
    var type = 'approve';

    if($(this).siblings('textarea').val().length <= 1) {
        $(this).siblings('textarea').css('background-color', 'lemonchiffon');
        var err = "<span class=\"error\">You must fill this form before submit!</span>";
        $(this).siblings('.comment-error').html(err);
    } else {
        var comment = $(this).siblings('textarea').val();
        $.post(BaseUrl+"/ajax/default/savecomment",
            {'comment': comment,
             'prj': task,
             'type': type},
            function(result){

            }
        );
    }

    $.ajaxSetup({
        async: false
    });

    $.getJSON(
        BaseUrl+'/ajax/default/setsign/?task_id='+task+'&action=approve',
        function(data) {
            $(location).attr('href',BaseUrl+'/manager/projects/details/?task_id='+task);
        }
    );
});

$(document).on('click', '#ask-comment', function() {
    var task = $(this).siblings('input').val();
    var type = 'ask';

    if($(this).siblings('textarea').val().length <= 1) {
        $(this).siblings('textarea').css('background-color', 'lemonchiffon');
        var err = "<span class=\"error\">You must fill this form before submit!</span>";
        $(this).siblings('.comment-error').html(err);
    } else {
        var comment = $(this).siblings('textarea').val();
        $.post(BaseUrl+"/ajax/default/savecomment",
            {'comment': comment,
             'prj': task,
             'type': type},
            function(result){
                $(location).attr('href',BaseUrl+'/manager/projects/details/?task_id='+task);
            }
        );
    }
});

$(document).on('click', '#cancel-comment', function() {
    var task = $(this).siblings('input').val();
    var type = 'cancel';

    if($(this).siblings('textarea').val().length <= 1) {
        $(this).siblings('textarea').css('background-color', 'lemonchiffon');
        var err = "<span class=\"error\">You must fill this form before submit!</span>";
        $(this).siblings('.comment-error').html(err);
    } else {
        var comment = $(this).siblings('textarea').val();
        $.post(BaseUrl+"/ajax/default/savecomment",
            {'comment': comment,
                'prj': task,
                'type': type},
            function(result){
                $.ajaxSetup({
                    async: false
                });

                $.getJSON(
                    BaseUrl+'/ajax/default/setsign/?task_id='+task+'&action=cancel',
                    function(data) {
                        $(location).attr('href',BaseUrl+'/manager/projects/details/?task_id='+task);
                    }
                );
            }
        );
    }
});


$(document).on('click', '#savebutton', function() {
    var task = $('.prj').attr('id');
    var rls = Array();

    $.ajaxSetup({
        async: false
    });

    $('.assigned').each(function(){
        var chk = $(this).is(':checked');
        var id = $(this).val();
        var arr = Array();
        var state;

        if(chk == true) {
            state = 1;
        } else {
            state = 0;
        }

        arr = {'id' : id, 'state' : state};

        rls.push(arr);
    });

    $.post(BaseUrl+"/ajax/default/savetech",
        {'roles': rls,
         'prj': task},
        function(result){
            $(location).attr('href',BaseUrl+'/manager/projects/details/?task_id='+task);
        }
    );
});