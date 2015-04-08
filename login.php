<html>
<head> 
	<title>Vision Source</title>
</head>


<body>
<?php

//error_reporting(E_ERROR | E_PARSE);


	// TODO: make config file to remove credentials from code
	$mysqli=mysqli_connect('localhost','root','','vision_source') or die("Database Error");

	$email = $_POST["email"];
	$password = $_POST["password"];
	$check_box = $_POST["check_box"];
	

	if($check_box == "2")
		{
			// first see if the user exists
			$sql_get_email="SELECT email FROM login WHERE email="."'$email'";
			$result = mysqli_query($mysqli,$sql_get_email) or die(mysqli_error($mysqli));

			// then overwrite password
			if($result)
			{
				$overwrite_email = '';
				while($row=mysqli_fetch_array($result))
				{
					$overwrite_email = $row['email'];
				}
				 $sql_overwrite_password = "UPDATE login SET password="."'$password'"." WHERE email="."'$overwrite_email'";
				 $update_result = mysqli_query($mysqli,$sql_overwrite_password) or die(mysqli_error($mysqli));
				 if($update_result)
				 {
				 	echo '<font face="Trebuchet MS" size="8" color="brown"><strong>'
				 		.'Overwriten password for '.$overwrite_email
				 		.'</strong></font><br>';

				 }
			}
			else
			{
				echo '<font face="Trebuchet MS" size="8" color="brown"><strong>'
				 	.'Cannot overwrite for: '.$email
				 	.'</strong></font><br>';
			}


		}

	if($check_box == "1")
     {
     	// create user
     	$sql_create_user = "INSERT INTO login (email, password) VALUES ("."'$email','$password'".")";
     	$create_result = mysqli_query($mysqli,$sql_create_user) or die(mysqli_error($mysqli));

     	if($create_result)
     	{
     		echo '<font face="Trebuchet MS" size="8" color="green"><strong>'
     		.'Created new user with email:  '.$email
     		.'</strong></font><br>';

     	}

     }

	if($check_box == "0")
		{
			$sql_get_password="SELECT password FROM login WHERE email="."'$email'";
			$result = mysqli_query($mysqli,$sql_get_password) or die(mysqli_error($mysqli));
			$user_present = false;

			if($result)
			{
				while($row=mysqli_fetch_array($result))
				{
					if($row["password"] == $password)
					{
				 	echo '<font face="Trebuchet MS" size="8" color="green"><strong>'
				 		.'You are now logged in with email:  '.$email
				 		.'</strong></font><br>';
						$user_present = true;
						break;
					}

				}
			}

			if(!$user_present)
			{
				echo '<font face="Trebuchet MS" size="8" color="red"><strong>'
				 	.'No user found with email:  '.$email
				 	.'</strong></font><br>';
			}

		}








		
?>


<?php
	session_start();
	if (!isset($_SESSION['count']))
	{
	  $_SESSION['count'] = 0;
	} else 
	{
	  $_SESSION['count']++;
	}
?>
<form action="question.php?q=1" method="post">
	<input type="submit" vlaue="submit"> Next Question </input>
</form> 

</body>


</html>
