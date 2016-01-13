<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
include('calendar/connect.php'); 
include('calendar/classes/class_calendar.php');
if($_SERVER['REQUEST_METHOD'] == 'POST') {
   $calendar->after_post($month, $day, $year);  
}   

$username ="user";
$userid = "userid";


	// get the setting from
$query = "SELECT * FROM setting "; 
		$result1 = mysqli_query($link, $query) or die(mysqli_error($link)); 
	    
		while ($row = mysqli_fetch_array($result1)) {
			    
			$noofbooking = $row['booking_no'];
		    
		    } // Close loop
		    
$calendar = new booking_diary($link,$noofbooking,$username);


if(isset($_GET['month'])) $month = $_GET['month']; else $month = date("m");
if(isset($_GET['year'])) $year = $_GET['year']; else $year = date("Y");
if(isset($_GET['day'])) $day = $_GET['day']; else $day = 0;

// Unix Timestamp of the date a user has clicked on
$selected_date = mktime(0, 0, 0, $month, 01, $year); 

// Unix Timestamp of the previous month which is used to give the back arrow the correct month and year 
$back = strtotime("-1 month", $selected_date); 

// Unix Timestamp of the next month which is used to give the forward arrow the correct month and year 
$forward = strtotime("+1 month", $selected_date);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Calendar</title>
<link href="calendar/style.css" rel="stylesheet" type="text/css">

<link href="http://fonts.googleapis.com/css?family=Droid+Serif" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Droid+Sans" rel="stylesheet" type="text/css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.js"></script>





</head>
<body>

<?php     
        



        
// if($user->id) {
// 	$userToken = JSession::getFormToken();

//     if (isset($groups[2]) || isset($groups[8]))
// Call calendar function
echo "<h1> Welcome $username </h1>";
echo '<a class="logout_lnk" target="_self" title="Logout" href="mybooking.php"> My Booking</a></p>';
//echo '<a class="logout_lnk" target="_self" title="Logout" href="index.php?option=com_users&task=user.logout&' . $userToken . '=1"> Logout</a></p>';
echo "<br>";
$calendar->make_calendar($selected_date, $back, $forward, $day, $month, $year);
// if (isset($groups[6])) echo " - User is an Manager <Br/>";
// }else{
//     echo '<h1>Please Login First.</h1><Br/>';
// }


?>
<div id='outer_basket'>
	
	<h2>Selected Slots</h2>
		
		<div id='selected_slots'></div>		
	
			<div id='basket_details'>
			
				<form method='post' action='book_slots.php'>
				
					<!-- <label>Name</label>
					<input name='name' id='name' type='text' class='text_box'>
					
					<label>Email</label>
					<input name='email' id='email' type='text' class='text_box'>	
					
					<label>Phone</label>
					<input name='phone' id='phone' type='text' class='text_box'>	-->

					<input type='hidden' name='slots_booked' id='slots_booked'>
					<input type='hidden' name='cost_per_slot' id='cost_per_slot' value=''>
					
					<input type='submit' class='classname' value='Make Booking'>

				</form>
			
			</div><!-- Close basket_details DIV -->
		
	</div><!-- Close outer_basket DIV -->


</body>
<script type="text/javascript">
var check_array = [];

$(document).ready(function(){

	$(".fields").click(function(){
	
		dataval = $(this).data('val');
		// Show the Selected Slots box if someone selects a slot
		if($("#outer_basket").css("display") == 'none') { 
			$("#outer_basket").css("display", "block");
		}

		if(jQuery.inArray(dataval, check_array) == -1) {
			check_array.push(dataval);
		} else {
			// Remove clicked value from the array
			check_array.splice($.inArray(dataval, check_array) ,1);	
		}
		
		slots=''; hidden=''; basket = 0;
		
		cost_per_slot = $("#cost_per_slot").val();
		//cost_per_slot = parseFloat(cost_per_slot).toFixed(2)

		for (i=0; i< check_array.length; i++) {
			slots += check_array[i] + '\r\n';
			hidden += check_array[i].substring(0, 10) + '|';
			basket = (basket + parseFloat(cost_per_slot));
		}
		
		// Populate the Selected Slots section
		$("#selected_slots").html(slots);
		
		// Update hidden slots_booked form element with booked slots
		$("#slots_booked").val(hidden);		

		// Update basket total box
		basket = basket.toFixed(2);
		$("#total").html(basket);	

		// Hide the basket section if a user un-checks all the slots
		if(check_array.length == 0)
		$("#outer_basket").css("display", "none");
		
	});
	

	// Firefox caches the checkbox state.  This resets all checkboxes on each page load 
	$('input:checkbox').removeAttr('checked');
	
	
});




</script>
</html>
