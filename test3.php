<?php

$stack = array("orange", "banana");
array_push($stack, "apple", "raspberry");
// print_r($stack);

$a = array('a', 'b', 'c');
$b = array('b', 'd', 'd');

// $result = array_intersect($a, $b); 
$x = array_diff($b, $a);
$y = array_diff($a, $b);

$result = array_merge($x, $y);

foreach($result as $value)
{
	echo $value."<br>";
}


?>