<html>
<head></head>

<body>
<?php

echo $_GET["q"];

$var = $_GET["q"] + 1;




?>
<form action="test2.php?q=<?php echo $var ?>" method="post">
	<input type="submit" value="submit"/>

</form>

</body>

</html>