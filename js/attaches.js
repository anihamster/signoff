function addPictureForms()
    {
        var number = Math.floor($('#mainFilesForm table tr').length);

        var html = "<tr><td></td>";
        html += "<td><input id='ytAttach_"+number+"_attach_file' type='hidden' name='Attach["+number+"][attach_file]' value='' /><input id='Attach_"+number+"_attach_file' type='file' name='Attach["+number+"][attach_file]'></td>";
        html += "<td></td></tr>";
        $('#mainFilesForm table tr:last').after(html);
    }
