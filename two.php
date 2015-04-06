<html>

<body>

	<div> <font color="red">
	<h3> Your Answer: </h3>
	
	<table>
		
		<?php 


		foreach ($_POST as $key => $value) 
		{
			
			echo "<tr>";
			echo "<td>";
			echo $key;
			echo "</td>";
			echo "<td>";
			echo $value;
			echo "</td>";
			echo "</tr>";
			
		}


		?>
		
	</table>
	
	</font></div>
	<br><br>

	<!-- TODO: Implement logic for correct answer -->
	<h3> Correct Answer: </h3> 
	<?php
	
	 $mysqli=mysqli_connect('localhost','root','','vision_source') or die("Database Error");

	 $sql="SELECT id, code_and_name FROM conditions ORDER BY id";
	 $result = mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));

	 if($result)
	 {
	  while($row=mysqli_fetch_array($result))
	  {
	   echo $row['id']."&nbsp";
	   echo $row['code_and_name']."<br>";
	  }
	 }
	?>

</body>

</html>