$(document).ready(function() {
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