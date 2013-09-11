$(document).on('click', '.sprite', function() {
    var prj = $(this).parent().attr('id');
    var grp = $(this).attr('id');
    var html = "";
    var cont = $(this).parent().siblings('.track_content');
    $.getJSON(
        BaseUrl + '/ajax/default/getsignsprj/?prj='+prj+'&grp='+grp,
        function(data) {
            if(data.code == "Ok") {
                var response = data.response
                for(var i in response) {
                    if(response[i].sign == 0) {
                        html += "<div class=\"sprite notsigned\" style=\"z-index: 1\">"+response[i].brand+" "+response[i].role+"</div><br />";
                    }

                    if(response[i].sign == 1) {
                        html += "<div class=\"sprite signed\" style=\"z-index: 1\">"+response[i].brand+" "+response[i].role+"</div><br />";
                    }

                    if(response[i].sign == 2) {
                        html += "<div class=\"sprite cancel\" style=\"z-index: 1\">"+response[i].brand+" "+response[i].role+"</div><br />";
                    }

                    if(response[i].sign == 6) {
                        html += "<div class=\"sprite inactive\" style=\"z-index: 1\">"+response[i].brand+" "+response[i].role+"</div><br />";
                    }
                }

                console.log(cont);

                cont.html(html);
            }
        }
    );
});