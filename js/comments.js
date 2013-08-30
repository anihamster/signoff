$(document).ready(function(){
	$('.progress').click(function(){
		$.ajaxSetup({
	        async: false
	    });
		
		var dept = $(this).attr('id');
		var task = $('.progress_bar').attr('id');
		var html="";
		
		$.getJSON(
				BaseUrl + '/ajax/default/getcomments/?dept_id='+dept+'&task_id='+task,
				function(data) {
			        if(data.status == "Ok") {	        	
			        	var response = data.result;
			        	
			        	html += "<table>";
			        	
			        	for(var i in response) {
			        		var obj = response[i];
			        		html += "<tr>";
			        		html += "<td>";
			        		html += "#"+obj.id;
			        		html += "</td>";
			        		html += "<td>";
			        		html += "<div align=\"right\">";
			        		html += obj.name+" "+obj.surname+" posted on "+obj.created;
			        		html += "</div>";
			        		html += "</td>";
			        		html += "</tr>";
			        		html += "<tr>";
			        		html += "<td colspan=\"2\">";
			        		html += obj.comment_text;
			        		html += "</td>";
			        		html += "</tr>";
			        	} 
			        	html += "</table>";
			        }
			        if(data.status == "Failed") {
			        	html += "<b>"+data.result+"</b>";
			        }
			    }
			); 
		
		$('#comment_area').html(html);
		$('#comment_area').show();
	});
});