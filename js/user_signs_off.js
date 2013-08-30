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
        var task = $(this).siblings('input').val();

        $.ajaxSetup({
            async: false
        });

        $.getJSON(
            '/ajax/default/setsign/?task_id='+task,
            function(data) {
                alert(data.result);
                $('#sign_that').hide();
            }
        );
    });
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