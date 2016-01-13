<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
include('calendar/connect.php'); 
include('calendar/classes/class_calendar.php');
 
$username = "wael";
$userid = "1";



?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>My Booking</title>
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
echo '<a class="logout_lnk" target="_self" title="Logout" href="/joomla/calendar.php"> Back to Calendar</a></p>';
//echo '<a class="logout_lnk" target="_self" title="Logout" href="index.php?option=com_users&task=user.logout&' . $userToken . '=1"> Logout</a></p>';
echo "<br>";
echo "<div> my booking </div>";
// ******************** get the booking day for the current user
$query = "SELECT * FROM bookings WHERE name = '$username'"; 
		$result1 = mysqli_query($link, $query); 
	       if (mysqli_num_rows($result1) > 0 ) {
		  echo "<table> <th> user </th> <th> Booking Date </th> <th> confirmed </th>";
		while ($row = mysqli_fetch_array($result1)) {
			    
			$status1 = $row['confirmed'];
			if ($status1 == 0)
			{
			   $status = "No";
			}
			else{
			   $status = "Yes";
			}
			
			echo '<tr>
			<td >'.$username.'</td>
			<td >'.$row['date'].'</td>
			<td>'.$status.'</td>

			<td>
			<form action="" method="POST">
			<button name="delete" value='.$row['date'].'>Delete</button>
			</form></td>
		      </tr>';
		      
		    } // Close loop
		    		  echo "</table>";
				 
	       } //end if mysqli row
	       else
	       {
		     echo "<p> no result found</p>";
	       }    
		    
	      
			
// if (isset($groups[6])) echo " - User is an Manager <Br/>";
// }else{
//     echo '<h1>Please Login First.</h1><Br/>';
// }

 $test =0;
			if($_SERVER['REQUEST_METHOD'] == 'POST') {
			 if (isset($_POST['delete']))
			{
			   $datetodelete = $_POST['delete'];
			   $sqlrem = "DELETE FROM bookings WHERE name ='$username' AND date='$datetodelete'";
			   mysqli_query ($link,$sqlrem);
			   header("Refresh:0");
			   echo " The $datetodelete has been deleted";

			}
			}
?>


</body>

</html>
