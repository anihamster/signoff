$(document).ready(function() {
	$('#techlist').click(function() {
		var dept = $(this).siblings('input').val();
		var cont = $('#usrs');
		
		$.ajaxSetup({
	        async: false
	    });	
		
		$.getJSON(
			BaseUrl + '/ajax/default/getusers/?dept_id='+dept,
			function(data) {
		        if(data.status == "Ok") {	        	
		        	var response = data.result		    
		        	
		        	var html="";
		        			        	
		        	for(var i in response) {
		        		var obj = response[i];
		        		if(response[i].signed == '1') {
		        			html += "<input type=\"radio\" name=\"assigned\" value=\""+response[i].user_id+"\" id=\""+response[i].user_id+"\" checked>"+response[i].name+"<br />";
		        		} 

		        		if(response[i].signed == '0') {
		        			html += "<input type=\"radio\" name=\"assigned\" value=\""+response[i].user_id+"\" id=\""+response[i].user_id+"\">"+response[i].name+"<br />";
		        		}
		        	}
		        	
		        	html += "<br /><a href=\"Javascript:void[0]\" id=\"savebutton\" class=\"button orange\">Add user to signs list</a>"
		        	        		
		        	cont.html(html);
		        	
		        	$('#userlist').hide();
		        }
		    }
		); 
	});
	
	$('.deplist').click(function() {
		var dept = $(this).siblings('input').val();
		var cont = $('#usrs');
			
		$.ajaxSetup({
	        async: false
	    });	
		
		$.getJSON(
			BaseUrl + '/ajax/default/getusers/?dept_id='+dept,
			function(data) {
		        if(data.status == "Ok") {	        	
		        	var response = data.result		    
		        	
		        	var html="";
		        			        	
		        	for(var i in response) {
		        		var obj = response[i];
		        		if(response[i].signed == '1') {
		        			html += "<input type=\"radio\" name=\"assigned\" value=\""+response[i].user_id+"\" id=\""+response[i].user_id+"\" checked>"+response[i].name+"<br />";
		        		} 

		        		if(response[i].signed == '0') {
		        			html += "<input type=\"radio\" name=\"assigned\" value=\""+response[i].user_id+"\" id=\""+response[i].user_id+"\">"+response[i].name+"<br />";
		        		}
		        	}
		        	
		        	html += "<br /><a href=\"Javascript:void[0]\" id=\"savebutton\" class=\"button orange\">Add user to signs list</a>"
		        	
		        	cont.html(html);
		        	
		        	$('#userlist').hide();
		        }
		    }
		); 
	});
});

$(document).on('click', '#savebutton', function() {
	var user = $(this).siblings('input[type=radio]:checked').attr('id');
	
	var cont = $('#usrs');
	
	var task = $(this).closest('table').attr('id');
	
	var html = '';
	
	$.ajaxSetup({
        async: false
    });	
	
	$.getJSON(
		BaseUrl + '/ajax/default/signuser/?user_id='+user+'&task_id='+task,
		function(data) {
	        if(data.status == "Ok") {	        	
	        	var response = data.result;	    
	        	
	        	alert(response);    
	        	
	        	cont.html(html);
	        } else {
	        	var response = data.result;
	        	
	        	alert(response);
	        	
	        	cont.html(html);
	        	
	        	$('#userlist').show();
	        }
	    }
	);
})