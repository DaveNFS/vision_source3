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

	<script  src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>        
	<!--
	// Google's CDN used for jQuery
	// TODO: save a local copy of jQuery
	-->

	<script type="text/javascript" src="jquery.autocomplete.js"></script>
	<link rel="stylesheet" type="text/css" href="jquery.autocomplete.css" />

	<script type="text/javascript">
	$(function() {
		var addDiv = $('#addinput');
		var i = $('#addinput p').size() + 1;

		$('#addNew').live('click', function() {
			$('<p><input type="text" id="answer" class="moreOption" size="40" name="selection_' + i +'" value="" placeholder="Add answer..." /><a href="#" id="remNew"> REMOVE</a> </p>').appendTo(addDiv);
			i++;

			// add the autocomplete functionality to new inputs (like document.ready())
					$(".moreOption").autocomplete("autocomplete.php", {
						selectFirst: true
					});

			return false;
		});

		$('#remNew').live('click', function() {
			if( i > 2 ) {
				$(this).parents('p').remove();
				i--;
			}
			return false;
		});
	});

	</script>


	<script>
	$(document).ready(function(){
		$("#answer").autocomplete("autocomplete.php", {
			selectFirst: true
		});
	});
	</script>



</head>


<body style="margin:25px">

<?php
    // define custom function 
	function startsWith($haystack, $needle)
	{
	    $length = strlen($needle);
	    return (substr($haystack, 0, $length) === $needle);
	}

?>



<?php


	// TODO: make config file to remove credentials from code
	$mysqli=mysqli_connect('localhost','root','','vision_source') or die("Database Error");
	
	$current_question = $_GET["q"];
	$previous_question = $current_question - 1; 
	$next_question = $current_question + 1; 

	 

	// redirecting if current question is greater than last question!
	$sql_last_question = "SELECT MAX(id) FROM questions";
	$sql_last_question_answer = mysqli_query($mysqli,$sql_last_question) or die(mysqli_error($mysqli));
	while($row=mysqli_fetch_array($sql_last_question_answer))
	{
		$last_question = $row['MAX(id)'];
	}	

	if($current_question > $last_question)
	{
		// TODO: Add finishing up code here.
		
		header("Location: done.php");
		exit();
	}

	// debug
	// echo "current question"; 
	// echo $current_question;
	// echo "<br>";

	$actual_answers = array();
	$your_answers = array();
	$correct_answers = array();
	$incorrect_answers = array();

	// get acutal answer to previous question: 
	if($previous_question > 0)
	{
		$sql_answers = "SELECT answers FROM questions WHERE id=".$previous_question;
		$sql_answers_results = mysqli_query($mysqli,$sql_answers) or die(mysqli_error($mysqli));
		while($row=mysqli_fetch_array($sql_answers_results))
		{
			$actual_answers = explode(',', $row['answers']);
		}

		// debug
		// echo "acutal answer";
		// var_dump($actual_answers);
		// echo "<br>";
	}


	// get your answers to previous question: 
	foreach($_POST as $key => $value)
	{
		if(startsWith($key, "selection_"))
		{

			// get all the id from 'conditions' table:
			$sql_name_answers = "SELECT id FROM conditions WHERE code_and_name="."'$value'";
			$sql_name_answers_result = mysqli_query($mysqli,$sql_name_answers) or die(mysqli_error($mysqli));
			while($row=mysqli_fetch_array($sql_name_answers_result))
			{
				array_push($your_answers, $row['id']);
			}
		}

	}

	// debug
	// echo "your answer";
	// var_dump($your_answers);
	// echo "<br>";

	// populate correct answer: 
	$correct_answers = array_intersect($actual_answers, $your_answers);

	// populate incorrect answers: (also includes unanswered)
	$temp_one = array_diff($actual_answers, $your_answers); 
	$temp_two = array_diff($your_answers, $actual_answers);
	$incorrect_answers = array_merge($temp_one, $temp_two);




?>

<div id="correct_result">
<?php
if($previous_question > 0)
{
	echo '<font face="Comic Sans MS" size="5" color="green"><strong>Correct choices: </strong></font>';
}
?>
<br>
<font color="green">
<ul>
<?php
	foreach($correct_answers as $value)
	{
		$sql_get_name = "SELECT code_and_name FROM conditions WHERE id=".$value;
		$sql_get_name_result = mysqli_query($mysqli,$sql_get_name) or die(mysqli_error($mysqli));
		while($row=mysqli_fetch_array($sql_get_name_result))
		{
			echo "<li>";
			echo $row['code_and_name'];
			echo "</li>";

		}
	}

?>
</ul>
</font>
</div>


<div id="incorrect_result">
<?php
if($previous_question > 0)
{
	echo '<font face="Comic Sans MS" size="5" color="red"><strong>Incorrect choices: </strong></font>';
}
?>
<br>
<font color="red">
<ul>
<?php
	foreach($incorrect_answers as $value)
	{
		$sql_get_name = "SELECT code_and_name FROM conditions WHERE id=".$value;
		$sql_get_name_result = mysqli_query($mysqli,$sql_get_name) or die(mysqli_error($mysqli));
		while($row=mysqli_fetch_array($sql_get_name_result))
		{
			echo "<li>";
			echo $row['code_and_name'];
			echo "</li>";

		}
	}

?>
</ul>
</font>
</div>


<br><br><br> 


<div id="next question" background-color="blue">
<font size="5" color="brown"><strong> Question: </strong></font>
<font size="3">
<?php
	$sql_get_current_question = "SELECT question FROM questions WHERE id=".$current_question;
	$sql_get_current_question_result =  mysqli_query($mysqli,$sql_get_current_question) or die(mysqli_error($mysqli));
	while ($row=mysqli_fetch_array($sql_get_current_question_result)) 
	{
		echo $row['question'];
	}
?>
</font>
</div>


<form action="question.php?q=<?php echo $next_question; ?>" method="post">
	<div id="addinput">
		<input type="text" id="answer" size="40" name="selection_0" value="" placeholder="Your choice" /><a href="#" id="addNew"> ADD</a>	
	</div>
	<input type="submit" value="Next Question"></input>
</form>




</body>



</html>
