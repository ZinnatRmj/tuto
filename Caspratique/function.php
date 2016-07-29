<?php
/*
function setHeight($minheight = 50) {
     echo "The height is : $minheight <br>";
}
setHeight(350);
setHeight();
setHeight(135);
setHeight(80);
*/
?>
<?php
function sum($x, $y) {
	echo " top " ;
	return "toto" ;
    $z = $x + $y;
    return $z;
}

//echo sum(5, 10) ;

 echo ( "5 + 10 = " . sum(5, 10)  . sum(5, 10) . "<br>" ) ;
/*
echo "7 + 13 = " . sum(7, 13) . "<br>";
echo "2 + 4 = " . sum(2, 4);
*/


$flower = array ( "Sunflower" "2", "Hio" = "5");

echo "Number of Sunflower :" .$flower [ 'Sunflower'];



?>


<?php
$a = array("a" => "apple", "b" => "banana");
$b = array("a" => "pear", "b" => "strawberry", "c" => "cherry");

$c = $a + $b; // Union of $a and $b
echo "Union of \$a and \$b: \n";
var_dump($c);

?>
