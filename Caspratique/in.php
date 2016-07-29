<html>
<body>

<?php
$txt = "wwww";
echo "PHP Script" . $txt ;
echo "<br>";
?>


<?php
$x = 2;
$z = 5;

echo $x+$z;
echo "<br>";
?>

<?php
function myTest() {
$x = 3;
echo " variable x inside function is : $x <br>" ;
}

myTest();
echo " variable x outsides function is : $x <br>";


?>

<?php
$x = 5;
$y = 10;

function myTes() {
	global $x, $y;
	$y = $x + $y;
	}

myTes();
echo $y;
echo "<br>";
?>

<?php
$x = 5;
$y = 10;

function myTesting() {
$GLOBALS ['y'] = $GLOBALS ['x'] + $GLOBALS ['y'];
}

myTesting();
echo $y;
echo "<br>";
echo "<br>";
?>

<?php
function myTe() {
 static $x = 1;
 echo $x;
 $x++;}

myTe() ;
echo "<br>";
myTe();
echo "<br>";
myTe();
echo "<br>";

?>

</body>
</html>
