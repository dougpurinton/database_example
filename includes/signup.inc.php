<?php

if (isset($_POST['submit']))
{

	include_once 'dbh.inc.php';
	include_once '../generate_new_code.php';

	// Error handlers
	if (!$conn)
	{
	 header("Location: ../index.php?login=database");
	 exit();
	}
	else
	{
	 $first = trim(mysqli_real_escape_string($conn, $_POST['first']));
	 $last = trim(mysqli_real_escape_string($conn, $_POST['last']));
	 $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
	 $uid = trim(mysqli_real_escape_string($conn, $_POST['uid']));
	 $pwd = trim(mysqli_real_escape_string($conn, $_POST['pwd']));
	 $repwd = trim(mysqli_real_escape_string($conn, $_POST['repwd']));
	 $signupcode = trim(mysqli_real_escape_string($conn, $_POST['signupcode']));
	 // Check for empty fields
		if (empty($first) || empty($last) || empty($email) || empty($uid) || empty($pwd) || empty($repwd) || empty($signupcode))
		{
		 header("Location: ../signup.php?signup=empty");
		 exit();
		}
		else
		{
		 // Check if input characters are valid
			if (!preg_match("/^[a-zA-Z]*$/", $first) || !preg_match("/^[a-zA-Z]*$/", $last))
			{
			 header("Location: ../signup.php?signup=invalid");
			 exit();
			}
			else
			{
			 //Check if email is valid
				if (!filter_var($email, FILTER_VALIDATE_EMAIL))
				{
				 header("Location: ../signup.php?signup=email");
				 exit();
				}
				else
				{
				 $sql = "SELECT * FROM users WHERE user_uid='$uid'";
				 $result = mysqli_query($conn, $sql);
				 $resultCheckUID = mysqli_num_rows($result);
					
				 $sql = "SELECT * FROM users WHERE user_email='$email'";
				 $result = mysqli_query($conn, $sql);
				 $resultCheckEmail = mysqli_num_rows($result);
					
					if ($resultCheckUID > 0)
					{
					 header("Location: ../signup.php?signup=usertaken");
					 exit();
					}
					elseif ($resultCheckEmail > 0)
					{
					 header("Location: ../signup.php?signup=emailtaken");
					 exit();						
					}
					else
					{
					 file_put_contents("../code.txt", getToken(5));
					 //Hashing the password
					 $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
					 // Insert the user into the database
					 $sql = "INSERT INTO users (user_first, user_last, user_email, user_uid, user_pwd, user_code) VALUES ('$first', '$last', '$email', '$uid', '$hashedPwd', '$signupcode');";
					 mysqli_query($conn, $sql);
					 header("Location: ../signup.php?signup=success");
					 exit();
					}
				}
			}
		}
	}
}
else
{
 header("Location: ../signup.php");
 exit();
}