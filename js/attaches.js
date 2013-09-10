function addPictureForms()
    {
        var number = Math.floor($('#mainFilesForm table tr').length);

        var html = "<tr><td></td>";
        html += "<td><input id='ytAttaches_"+number+"_ATTACH_FILE' type='hidden' name='Attaches["+number+"][ATTACH_FILE]' value='' /><input id='Attaches_"+number+"_ATTACH_FILE' type='file' name='Attaches["+number+"][ATTACH_FILE]'></td>";
        html += "<td></td></tr>";
        $('#mainFilesForm table tr:last').after(html);
    }
