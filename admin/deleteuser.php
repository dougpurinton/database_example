<?php
header('Content-Type: text/plain');
include_once '../includes/dbh.inc.php';

if ($conn)
{
 $dbStr = implode(",", json_decode($_POST['postStr']));
 $dbStr = trim(mysqli_real_escape_string($conn, $dbStr));

	if (@mysqli_query($conn, "DELETE FROM users WHERE user_id IN ($dbStr)"))
	{
	 echo "Record deleted successfully";
	}
	else
	{
	 echo "Error deleting record: " . mysqli_error($conn);
	}
}
else
{
 echo "Error connecting to database";
}

 exit();
?>