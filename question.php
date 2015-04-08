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
	
	$current_question = $_GET["q"];
	$previous_question = $current_question - 1; 
	$next_question = $current_question + 1; 


	echo $current_question;

	foreach($_POST as $key => $value)
	{
		if(startsWith($key, "selection_"))
		{

		}

	}





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
