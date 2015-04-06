<html>
<head> 
	<title>Vision Source</title>
</head>


<body>
<?php

	// TODO: make config file to remove credentials from code
	$mysqli=mysqli_connect('localhost','root','','vision_source') or die("Database Error");

	$email = $_POST["email"];
	$password = $_POST["password"];
	$check_box = $_POST["check_box"];
	

	if($check_box == "1")
		{

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
						echo "You're now logged in";
						$user_present = true;
						break;
					}

				}
			}

			if(!$user_present)
			{
				echo "Sorry, no match found";
			}

		}

?>


</body>


</html>
