<?php
header('Content-Type: text/plain');
include_once '../includes/dbh.inc.php';

$dbArray = json_decode($_POST['postStr']);

$dbStr = implode(",", $dbArray);

if (mysqli_query($conn, "DELETE FROM users WHERE user_id IN ($dbStr)"))
{
 echo "Record deleted successfully";
}
else
{
 echo "Error deleting record: " . mysqli_error($conn);
}

exit();
?>