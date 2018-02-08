<?php

if (isset($_POST['submit']))
{
 session_start();
 session_unset();
 session_destroy();
	if ($conn)
	{
	 mysqli_close($conn);	
	}
 header("Location: ../index.php");
 exit();
}