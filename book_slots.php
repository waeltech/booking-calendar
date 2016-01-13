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
<?php
include 'calendar/connect.php';

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
$username = $user->name;
$userid = $user->id;


$name = $username;
//$slots_booked = $_POST['slots_booked'];
if(isset($_POST['slots_booked']))
{
	$slots_booked = mysqli_real_escape_string($link, $_POST['slots_booked']);
}
//
//if(isset($_POST['name'])) $name = mysqli_real_escape_string($link, $_POST['name']);
//if(isset($_POST['email'])) $email = mysqli_real_escape_string($link, $_POST['email']);
//if(isset($_POST['phone'])) $phone = mysqli_real_escape_string($link, $_POST['phone']);
//if(isset($_POST['booking_date'])) $booking_date = mysqli_real_escape_string($link, $_POST['booking_date']);
//if(isset($_POST['cost_per_slot'])) $cost_per_slot = mysqli_real_escape_string($link, $_POST['cost_per_slot']);

//if (!defined('_JEXEC')) {
//    define( '_JEXEC', 1 );
//    define('JPATH_BASE', realpath(dirname(__FILE__)));
//    require_once ( JPATH_BASE .'/includes/defines.php' );
//    require_once ( JPATH_BASE .'/includes/framework.php' );
//}
//defined('DS') or define('DS', DIRECTORY_SEPARATOR);
$booking_array = array(
	//"slots_booked" => $slots_booked,	
	"booking_date" => $slots_booked,
	//"cost_per_slot" => number_format($cost_per_slot, 2),
	"name" => $name,
);

$explode = explode('|', $slots_booked);

foreach($explode as $slot) {

	if(strlen($slot) > 0) {
		
		
		$query = "INSERT INTO bookings (date, name) VALUES ('$slot', '$name')"; 
		$result = mysqli_query($link, $query); //or die(mysqli_error($link)); 
		if ($result) {
		    echo "<h1>This date : $slot has been booked for you.</h1>";
		}
		elseif (!$result)
		{
		    echo "<p class='red'>Look like you booked: $slot before.<p>";
		}
		
	} // Close if
	header('Refresh: 2; URL=calendar.php');

} // Close foreach

if(isset($_POST['booking_date']))
{
	echo "booking date";
}

?>

