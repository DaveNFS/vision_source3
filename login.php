<html>
<head> 
<meta charset="utf-8">
  <title>Vision Source</title>


  <!-- Mobile Specific Metas
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

  <link rel="stylesheet" href="Skeleton/css/normalize.css">
  <link rel="stylesheet" href="Skeleton/css/skeleton.css">



</head>


<body style="margin:25px">
<?php

//error_reporting(E_ERROR | E_PARSE);
	
	// show next button or not
	$show_button = true; 
	
	// TODO: make config file to remove credentials from code
	$mysqli=mysqli_connect('localhost','root','','vision_source') or die("Database Error");

	$email = $_POST["email"];
	$password = $_POST["password"];
	$check_box = $_POST["check_box"];



	// check if user exists in database
	$is_present = false; 

	$sql_user_email="SELECT email FROM login WHERE email="."'$email'";
	$user_email_result = mysqli_query($mysqli,$sql_user_email) or die(mysqli_error($mysqli));

	while($row=mysqli_fetch_array($user_email_result))
	{
		if($email == $row['email'])
			{
				$is_present = true; 
			}
	}

	// echo $check_box;




	if($check_box == "2")
		{

			if($is_present)
			{
				 $sql_overwrite_password = "UPDATE login SET password="."'$password'"." WHERE email="."'$email'";
				 $update_result = mysqli_query($mysqli,$sql_overwrite_password) or die(mysqli_error($mysqli));
				 if($update_result)
				 {
				 	echo '<font face="Trebuchet MS" size="8" color="brown"><strong>'
				 		.'Overwriten password for '.$email
				 		.'</strong></font><br>';

				 }	

			}
			else
			{
				$show_button = false; 
				echo '<font face="Trebuchet MS" size="8" color="red"><strong>'
				 	.'Cannot overwrite- User not present! '.$email
				 	.'</strong></font><br>';
			}


		}

	if($check_box == "1")
     {
     	 if($is_present)
     	 {
     	 		$show_button = false; 
     	 		echo '<font face="Trebuchet MS" size="8" color="red"><strong>'
				 	.'Cannot create- User already present! '.$email
				 	.'</strong></font><br>';
     	 }
     	 else
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
				$show_button = false; 
				echo '<font face="Trebuchet MS" size="8" color="red"><strong>'
				 	.'No user found with email:  '.$email
				 	.'</strong></font><br>';
			}

		}






echo "<br><br><br>&nbsp&nbsp";


if($show_button)
{
	echo '<form action="question.php?q=1" method="post">'
		.'<input class="button-primary" type="submit" value="GET STARTED"></input></form>';
}



		
?>



 

</body>


</html>
