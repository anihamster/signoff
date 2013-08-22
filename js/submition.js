$(document).ready(function() {
    $('#relations').click(function() {
        var role = $('#role').val();
        var cat = $('#category').val();
        var name = $('#grp_name').val();
        var grp = Array();

        var i = 0;

        $("input:checkbox:checked").each(function()
        {
            grp[i] = $(this).attr('name');
            i++
        });

        console.log(role, cat, grp);

        $.post("/ajax/default/saverelations",
            {'grp[]': grp,
             'role': role,
             'cat': cat,
             'name': name},
            function(result){

            }
        );
    });
});
