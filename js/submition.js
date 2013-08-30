$(document).ready(function() {

    var catprop = Object();
    var roles = Object();
    var brands = Object();
    var deps = Object();
    var html = "";
    var cat;

    $('#category').change(function(){
        $.ajaxSetup({
            async: false
        });

        cat = $('#category').val();

        $.getJSON(
            BaseUrl + '/ajax/relations/getcatprop/?cat_id='+cat,
            function(data) {
                if(data.status == 'failed') {
                    alert(data.message);
                } else {
                    var resp = data.response;
                    if(resp.spec == '0') {
                        catprop.title = 'Not brand-specified category';
                    }
                    if(resp.spec == '1') {
                        catprop.title = 'Brand-specified category';
                    }
                    catprop.type = resp.spec;

                    setrel(catprop);
                }
            }
        );
    });

    $('#relations2').click(function() {
        var role = $('#role').val();

        var name = $('#grp_name').val();
        var grp = Array();

        var i = 0;

        $("input:checkbox:checked").each(function()
        {
            grp[i] = $(this).attr('name');
            i++
        });

        console.log(role, cat, grp);

        $.post(BaseUrl+"/ajax/default/saverelations",
            {'grp[]': grp,
             'role': role,
             'cat': cat,
             'name': name},
            function(result){
		$(location).attr('href',BaseUrl+'/admin/relations');
            }
        );
    });

    function setrel(catprop) {
        if(catprop.type == '1') {
            gettypicalroles();
            getenv();
            draw_spec();
        }
        if(catprop.type == '0') {
            $('#relation_html').html('');
            gettypicalroles();
            getenv();
            draw_not_spec();
        }
    }

    function settitle() {
        html += "<br /><strong>"+catprop.title+" relations:</strong><br /><br />";
    }

    function gettypicalroles() {
        $.ajaxSetup({
            async: false
        });

        $.getJSON(
            BaseUrl + '/ajax/relations/gettypicalroles/',
            function(data) {
                if(data.status == 'failed') {
                    alert(data.message);
                } else {
                    roles = data.response;
                }
            }
        );
    }

    function getenv() {
        $.ajaxSetup({
            async: false
        });

        $.getJSON(
            BaseUrl + '/ajax/relations/getenv/',
            function(data) {
                if(data.status == 'failed') {
                    alert(data.message);
                } else {
                    brands = data.response.brands;
                    deps = data.response.deps;
                }
            }
        );
    }

    function draw_not_spec() {
        html = "";
        settitle();
        html += "<em>Select general users for submition:</em><br />"
        for(var i in deps) {
            var obj = deps[i];
            html += "<div style=\"width: 33%; float: left;\" class=\"general\"><input type=\"checkbox\" value=\""+obj.id+"\" name=\""+obj.name+"\" /> <label for=\""+obj.name+"\">"+obj.name+"</label></div>"
        }
        html += "<div class=\"clear\"></div>";
        html += "<br />";
        html += "<em>Select roles for submition:</em><br />"
        for(var i in brands) {
            var obj = brands[i];
            html += "<div id=\""+obj.id+"\" class=\"brand\">"
            html += "<span>"+obj.name+"</span><br />";

            for(var i in roles) {
                var rls = roles[i];
                html += "<div style=\"width: 33%; float: left;\" class=\"role\"><input type=\"checkbox\" value=\""+rls.id+"\" name=\""+rls.name+"\" /> <label for=\""+rls.name+"\">"+rls.name+"</label></div>"
            }
            html += "<div class=\"clear\"></div>";
            html += "</div>"
            html += "<br />";
        }
        html += "<div class=\"clear\"></div>";
        html += "<br />";
        html += "<a href=\"#\" onclick=\"return false;\" class=\"button orange\" id=\"relations2\">Save relation</a>"
        $('#relation_html').html(html);
    }

    function draw_spec() {
        html = "";
        settitle();
        html += "<em>Select general users for submition:</em><br />"
        for(var i in deps) {
            var obj = deps[i];
            html += "<div style=\"width: 33%; float: left;\" class=\"general\"><input type=\"checkbox\" value=\""+obj.id+"\" name=\""+obj.name+"\" /> <label for=\""+obj.name+"\">"+obj.name+"</label></div>"
        }
        html += "<div class=\"clear\"></div>";
        html += "<br />";
        html += "<em>Select typical roles for this category (assigned only for brand):</em><br />";
        for(var i in roles) {
            var obj = roles[i];
            html += "<div class=\"role\" style=\"width: 33%; float: left;\"><input type=\"checkbox\" value=\""+obj.id+"\" name=\""+obj.name+"\" /> <label for=\""+obj.name+"\">"+obj.name+"</label></div>"
        }
        html += "<div class=\"clear\"></div>";
        html += "<br />";
        html += "<a href=\"#\" onclick=\"return false;\" class=\"button orange\" id=\"relations1\">Save relation</a>"
        $('#relation_html').html(html);
    }
});

$(document).on('click', '#relations1', function() {
    var chkd = Array();
    var gnrl = Array();
    var name = $('#grp_name').val();
    var cat = $('#category').val();

    $('.general').each(function() {
        var id = $(this).children("input").val();
        var chk = $(this).children("input").is(':checked');
        var arr = Array();
        var state;

        if(chk == true) {
            state = 1;
        } else {
            state = 0;
        }

        arr = {'id' : id, 'state' : state};

        gnrl.push(arr);
    });

    $('.role').each(function() {
        var id = $(this).children("input").val();
        var chk = $(this).children("input").is(':checked');
        var arr = Array();
        var state;

        if(chk == true) {
            state = 1;
        } else {
            state = 0;
        }

        arr = {'id' : id, 'state' : state};

        chkd.push(arr);
    });

    $.post(BaseUrl+"/ajax/relations/savegeneralrelations",
        {'rel': chkd,
         'general': gnrl,
         'name': name,
         'cat' : cat},
        function(result){
            $(location).attr('href',BaseUrl+'/admin/relations');
        }
    );
});

$(document).on('click', '#relations2', function() {
    var gnrl = Array();
    var brnds = Array();
    var name = $('#grp_name').val();
    var cat = $('#category').val();

    $('.general').each(function() {
        var id = $(this).children("input").val();
        var chk = $(this).children("input").is(':checked');
        var arr = Array();
        var state;

        if(chk == true) {
            state = 1;
        } else {
            state = 0;
        }

        arr = {'id' : id, 'state' : state};

        gnrl.push(arr);
    });

    $('.brand').each(function() {
        var bid = $(this).attr('id');
        var id = $(this).children("input").val();
        var chk = $(this).children("input").is(':checked');
        var arr1 = Array();
        var arr2 = Array();

        console.log(bid);

        $(this).children('.role').each(function() {
            var rid = $(this).children("input").val();
            var chk2 = $(this).children("input").is(':checked');
            var tmp = Array();
            var state;

            if(chk2 == true) {
                state = 1;
            } else {
                state = 0;
            }

            tmp = {'id' : rid, 'state' : state};

            arr2.push(tmp);
        });

        arr1 = {'brand' : bid, 'selection' : arr2};

        brnds.push(arr1);
    });

    $.post(BaseUrl+"/ajax/relations/savenongeneralrelations",
        {'brands': brnds,
         'general' :gnrl,
         'name': name,
         'cat' : cat},
        function(result){
            $(location).attr('href',BaseUrl+'/admin/relations');
        }
    );
});