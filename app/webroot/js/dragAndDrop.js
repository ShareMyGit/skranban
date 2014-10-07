$(init);
 
function init() {	
	$(".droppable > div").sortable({
		connectWith: ".connectable > div",
		cursor: 'move',
	    stop: function(event, ui) {
	        		ticket = ui.item;
					ticketId = $(ticket).attr('id').replace("ticket", "");
					
					state = ui.item.parent().parent();
					stateId = $(state).attr('id').replace("state", "");
					
					var isGateLimitExceeded = $.ajax({
						url: "admin/tickets/isGateLimitExceeded/" + stateId,
						type: "post",
						dataType: 'text',
						cache: false,
						beforeSend: function(xhr) {
							xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			            },
						success: function(data){
							return data;
						},
						error: function() {
							alert("The ticket cannot be updated.");
							return false;
						}
					});
					
					isGateLimitExceeded.done(function(result) {
						if(result == 'true') {
							var moveTicket = $.ajax({
								url: "admin/tickets/ajaxEdit/" + ticketId + "/" + stateId,
								type: "post",
								cache: false,
								beforeSend: function(xhr) {
									xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
					            },
								success: function(){
									//alert(request.responseText);
								},
								error: function() {
									alert("The ticket cannot be updated.");
								}
							});
						}else{
							alert(result);
						}
					});
	    		},
		placeholder: 'placeholder'
	});
}