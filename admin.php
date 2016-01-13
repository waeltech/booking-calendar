<link href="style.css" rel="stylesheet" type="text/css">

<link href="http://fonts.googleapis.com/css?family=Droid+Serif" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Droid+Sans" rel="stylesheet" type="text/css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<style>
table, th, td {
     border: 1px solid black;
}
</style>
<?php
include('calendar/connect.php');

if (!defined('_JEXEC')) {
    define( '_JEXEC', 1 );
    define('JPATH_BASE', realpath(dirname(__FILE__)));
    require_once ( JPATH_BASE .'/includes/defines.php' );
    require_once ( JPATH_BASE .'/includes/framework.php' );
}
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
$app = JFactory::getApplication('site');
$user = JFactory::getUser();
$groups = $user->groups;
   
if($user->id) {


    if (isset($groups[8]))
    {
echo '<h2> here you can view all your user bookings. </h2>';
$query = "SELECT * FROM bookings ORDER BY date";
echo " <table>
        <tr>
        <th> Name </th> <th> Date </th> <th> Confirmed </th> <th> Action </th>
        </tr>";
		$result12 = mysqli_query($link, $query) or die(mysqli_error($link)); 
                if ($result12 ->num_rows > 0)
                {
		while ($row = mysqli_fetch_assoc($result12)) {
		    $date12 = $row["date"];
		    $username12 = $row["name"];
		     echo "<form action='' method='POST'>
		     <tr><td>".$row["name"]."</td><td>".$row["date"]."</td><td>"." ".$row["confirmed"]."</td> <td>
		     
		     
<button name='confirm' value='$date12,$username12'>Confirm</button> 
<button name='delete' value='$date12,$username12'>Delete</button> </td></tr>";

		    
		    } // Close loop
                }
                else
                {
                    echo "<tr> <td> no </td> <td> record </td> <td> found </td></tr>"; 
                }
echo "</table>";

echo  "<h1> Setting for the calendar </h1>";
$sett = "SELECT * FROM setting";
$result15 = mysqli_query($link, $sett);
while ($row1 = mysqli_fetch_assoc($result15)) {
		     $settings =  $row1["booking_no"];
		    } // Close loop
//echo $result15;
echo "what is your number of booking for each day ?
<form action='' method='POST'>
<input type='text' name='bookingnumber' value='$settings'>
<button name='submit'>Update</button>
</form>
";
if (isset($_POST['submit']))
{
     $valuetoset = $_POST['bookingnumber'];
     $sett = "UPDATE setting SET booking_no = '$valuetoset'";
     mysqli_query($link, $sett);
     header("Refresh:0");

}
if (isset($_POST['confirm']))
{
     $confr = $_POST['confirm'];
     $myArray = explode(',', $confr);
     $usrdate = $myArray[0];
     $usrname = $myArray[1];
     //echo $usrname;
     $sett = "UPDATE bookings SET confirmed = '1' WHERE name='$usrname' AND date='$usrdate'";
     mysqli_query($link, $sett);
     header("Refresh:0");

}
if (isset($_POST['delete']))
{
     $confr = $_POST['delete'];
     $myArray = explode(',', $confr);
     $usrdate = $myArray[0];
     $usrname = $myArray[1];
     //echo $usrname;
     $delete = "DELETE FROM bookings WHERE name='$usrname' AND date='$usrdate'";
     mysqli_query($link, $delete);
     header("Refresh:0");

}
    }
    else {
        echo "<h1>only admin can access this page </h1>";
    }
}
 else {
        echo "<h1>only admin can access this page </h1>";
    }
?>

    
