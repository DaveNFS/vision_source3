<?php
	$mysqli=mysqli_connect('localhost','root','','vision_source') or die("Database Error");
	$q=$_GET['q'];
	$my_data=mysql_real_escape_string($q);

	$sql="SELECT code_and_name FROM conditions WHERE code_and_name LIKE '%$my_data%' ORDER BY code_and_name";
	$result = mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));

	if($result)
	{
		while($row=mysqli_fetch_array($result))
		{
			echo $row['code_and_name']."\n";
		}
	}
?>
