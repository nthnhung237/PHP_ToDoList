
<?php require('site/views/commons/header.php'); ?>
	
<!-- Gọi Navbar -->
<?php require('site/views/commons/navbar.php'); ?>

<!--Index Content -->
<script type="text/javascript">

	var events = [];
	$(document).ready(function() {
		// init value

		var listEvent = <?php echo json_encode($list) ?>;

		if (listEvent != null) {

			for (var i = 0; i < listEvent.length; i++) {

				var Color = "#3a87ad";
				if (listEvent[i]["Status_ID"] == 3) {
					Color = "#30a286";
				} else if (listEvent[i]["Status_ID"] == 1) {
					Color = "#fed330";
				}

				var item = {
					id : listEvent[i]["List_ID"],
					title: listEvent[i]["Name"],
					start: listEvent[i]["Start_Day"],
					end: listEvent[i]["End_Day"],
					backgroundColor: Color,
					status : listEvent[i]["Status_ID"]
				};

				events.push(item);
			}

		}

		
	    $('#calendar').fullCalendar({
		    header: {
		        left: 'prev,next today',
		        center: 'title',
		        right: 'month,agendaWeek,agendaDay,listWeek'
		     },

	      	defaultDate: new Date(),
	     	navLinks: true, // can click day/week names to navigate views
	      	editable: true,
	      	eventLimit: true, // allow "more" link when too many events
	      	events: events,

		    dayClick: function(date, jsEvent, view, $el) {

		    	$('.popover').remove();

		    	var contentHtml = 	'<div class="div_popover"><p class="title_popover">Name</p><input id="title_list" class="input_popover" type="text"></div>';
		    	contentHtml 	+= 	'<div class="div_popover"><p class="title_popover">End Day</p><input id="end_day" class="input_popover" type="date" min="'+date.format()+'"></div>';
		    	contentHtml		+= 	'<div class="div_popover"><p class="title_popover">Status</p><select id="status" class="input_popover">';
		    	contentHtml		+=	'<option selected value="1">Planning</option>';
		    	contentHtml		+=	'<option value="2">Doing</option>';
		    	contentHtml		+=	'<option value="3">Complete</option>';
		    	contentHtml		+=	'</select></div>';
		    	contentHtml		+=	'<div class="gr_btn" ><button class="btn_popover" onclick="cancelAction()">Cancel</button><button class="btn_popover" onclick="addNewItem(\''+date.format()+'\')">Add</button></div>';

		    	$(this).popover({

		          title: 'Enter to add event on '+ date.format(),
		          content: contentHtml,
		          placement: 'top',
		          container: 'body',
		          html: true

		        });

		        $(this).show();
	        },

            eventRender: function(eventObj, $el) {

		        $el.popover({

		          title: '<button class="btn" onclick="editItem('+eventObj.id+',\''+eventObj.title+'\','+eventObj.status+')"> Edit</button>',
		          content: '<button class="btn" onclick="removeItem('+eventObj.id+')">Remove</button>',
		          placement: 'top',
		          container: 'body',
		          html: true

		        });

		        $el.show();
			}

	    });

	 });

	function addNewItem(date) {

		var title = $('#title_list').val();
		var end_date = $('#end_day').val();
		var status = $('#status').val();

		console.log(date);

		if ( title == '' || status == '') {
			alert('Khong the them list');
		} else {

			var url = "http://localhost/ToDoListEx/ajax/add_list";

			$.ajax({
				url: url,
				type:"post",
				dataType: 'json',
				data: {
					'name' : title ,
					'start_day': date,
					'end_day' : end_date,
					'status_id' : status
				},
				success:function(data){
					console.log("success");
					console.log(data);

					var Color = "#3a87ad";
					if (status == 3) {
						Color = "#30a286";
					} else if (status == 1) {
						Color = "#fed330";
					}

					// $('#calendar').fullCalendar('renderEvent', {
					// 	id: data["id"],
		   //              title: title,
		   //              start: date,
		   //              end: end_date,
		   //              backgroundColor: Color,
		   //              status : status
		   //          });

		   //          $('.popover').remove();

		   			location.reload();
				},
				error: function(data){
					console.log("err");
		        	console.log(data);
		           // alert('Can\'t update because network error! Please try again');
	        	}
			});
		}

	}

	function editItem(id, title, status) {

		$('.popover').remove();

		var item = events.find(x => x.id == id);

    	var contentHtml = 	'<div class="div_popover"><p class="title_popover">Name</p><input id="title_list" class="input_popover" type="text" value ="'+title+'"></div>';
    	contentHtml 	+= 	'<div class="div_popover"><p class="title_popover">Start Day</p><input id="start_day" class="input_popover" type="date" value="'+item["start"]+'"></div>';
    	contentHtml 	+= 	'<div class="div_popover"><p class="title_popover">End Day</p><input id="end_day" class="input_popover" type="date" value="'+item["end"]+'" min = "'+item["start"]+'"></div>';
    	contentHtml		+= 	'<div class="div_popover"><p class="title_popover">Status</p><select id="status" class="input_popover">';
    	
    	var select1, select2, select3 = '';
    	if (status == 1) {
    		select1 = 'selected';
    	} else if (status == 2) {
    		select2 = 'selected';
    	} else {
    		select3 = 'selected';
    	}

    	contentHtml		+=	'<option '+ select1 +' value="1">Planning</option>';
    	contentHtml		+=	'<option '+ select2 +' value="2">Doing</option>';
    	contentHtml		+=	'<option '+ select3 +' value="3">Complete</option>';
    	contentHtml		+=	'</select></div>';
    	contentHtml		+=	'<div class="gr_btn" ><button class="btn_popover" onclick="cancelAction()">Cancel</button><button class="btn_popover" onclick="editItemUpdate(\''+id+'\')">Save</button></div>';

		var popup = document.createElement('div');
	    popup.className = 'popup';

	    var message = document.createElement('span');
	    message.innerHTML = "Edit Event";
	    popup.appendChild(message);
	    popup.innerHTML = contentHtml;
	    document.body.appendChild(popup);

	}

	function editItemUpdate(id) {

		var title = $('#title_list').val();
		var end_date = $('#end_day').val();
		var start_date = $('#start_day').val();
		var status = $('#status').val();

		var url = "http://localhost/ToDoListEx/ajax/update_list";

		$.ajax({
			url: url,
			type:"post",
			dataType: 'json',
			data: {
				'id': id,
				'name' : title ,
				'start_day': start_date,
				'end_day' : end_date,
				'status_id' : status
			},
			success:function(data){
				console.log("success");
				console.log(data);

				var Color = "#3a87ad";
				if (status == 3) {
					Color = "#30a286";
				} else if (status == 1) {
					Color = "#fed330";
				}

				$('#calendar').fullCalendar('renderEvent', {
					id: data["id"],
	                title: title,
	                start: start_date,
	                end: end_date,
	                backgroundColor: Color
	            });

	            $('.popup').remove();
			},
			error: function(data){
				console.log("err");
	        	console.log(data);
	           // alert('Can\'t update because network error! Please try again');
        	}
		});
	}

	function removeItem(id) {

		var url = "http://localhost/ToDoListEx/ajax/delete_list";

		$.ajax({
			url: url,
			type:"post",
			dataType: 'json',
			data: {'list_id' : id },
			success:function(){
				console.log("success");
				console.log(data);

				$('#calendar').fullCalendar('removeEvents',event._id);

				$('.popover').remove();

				popup.parentNode.removeChild(popup);
				
				// window.location.reload();
			},
			error: function(data){
				console.log("err");
	        	console.log(data);
	           // alert('Can\'t update because network error! Please try again');
        	}
		});

	}

	function cancelAction() {
		$('.popover').remove();
		$('.popup').remove();
	}


</script>

<body>
	<section style="margin-top: 100px;">
		<div class="row">
			<div class="calendar" id='calendar'></div>
		</div>
	</section>
</body>
</html>