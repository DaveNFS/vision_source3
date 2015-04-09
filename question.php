<html>
<head>
	<title> Vision Source </title>
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
			$('<p><input type="text" id="answer" class="moreOption" size="40" name="selection_' + i +'" value="" placeholder="Add answer..." /><a href="#" id="remNew">Remove</a> </p>').appendTo(addDiv);
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


<body>

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


	echo "current question"; 
	echo $current_question;
	echo "<br>";

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

		echo "acutal answer";
		var_dump($actual_answers);
		echo "<br>";
	}


	// get your answers to previous question: 
	foreach($_POST as $key => $value)
	{
		if(startsWith($key, "selection_"))
		{
			echo "selection: ".$value."<br>";

			// get all the id from 'conditions' table:
			$sql_name_answers = "SELECT id FROM conditions WHERE code_and_name="."'$value'";
			$sql_name_answers_result = mysqli_query($mysqli,$sql_name_answers) or die(mysqli_error($mysqli));
			while($row=mysqli_fetch_array($sql_answers_results))
			{
				array_push($your_answers, $row['id']);
			}
		}

	}

	echo "your answer";
	var_dump($your_answers);
	echo "<br>";

	// populate correct answer: 





?>

<div id="result">

</div>


<div id="question">

</div>


<br><br><br> 


<form action="question.php?q=<?php echo $next_question; ?>" method="post">
	<div id="addinput">
		<input type="text" id="answer" size="40" name="selection_0" value="" placeholder="Your choice" /><a href="#" id="addNew">Add</a>	
	</div>
	<input type="submit" vlaue="submit"> Next Question </input>
</form>


</body>



</html>
