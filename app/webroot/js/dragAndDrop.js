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
					
					var request = $.ajax({
						url: "admin/tickets/ajaxEdit/" + ticketId + "/" + stateId,
						type: "post",
						data: "",
						success: function(){
							//alert(request.responseText);
						}
					});
	    		},
		placeholder: 'placeholder'
	});
}