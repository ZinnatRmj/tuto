<html>
<body>


<?php

/*
x = 5;
$y = 10;

echo $x + $y;
************************/

/*$x = 10; //global variable

echo " <p> The variable x : $x </p>"
************************/

/*function MyFunction () { //local variable
$z = 2;
echo " My variable z is : $z";
}

Myfunction ();
***********************/

/*$x = 2; //global used from within function
$y = 3;

function Myfunction () { 

global $x, $y ; 
$y = $x + $y;
}

Myfunction ();

echo $y ;
**********************/

/*$x = 2;
$z = 6;

function Myfunction () {
	
$GLOBALS ['x'] = $GLOBALS ['x'] + $GLOBALS ['z']; // $GLOBALS is an array used to update global variable directly
}

Myfunction();

echo $x;
**************************/

/*function Mytest () {
static $x = 0;
echo $x;
$x++;

}

Mytest ();
Mytest ();
Mytest ();
Mytest ();
Mytest ();

***************************/ 

/*echo " <h1> echo command </h1>";
echo " <h2> echo command </h2>";

******************************/ 

/*$text = "Php"; // echo statement
$x = 8;

echo " Learning $text";
echo " The value of x is : $x";

***********************************/

/*print " <h3> Print command </h3>";

**********************************/

/*$x = 10;
$y = 20;

print $x*$y; //print statement

************************************/

/*class Car {
	function Car () {
		 $this->model = "Toyota";
	}
}

$allcar = new Car;

echo $allcar->model;

*************************************/

/*define ("GREETING", "Welcome"); //case sensitive constant

echo GREETING;

**************************************/

/*define ("GREETING", true); //case insensitive constant

echo greeting; 

***************************************/

/*define ( "GREETING", "Hey", true); //global constant

function myFunction () {
	
	echo greeting;
}

myFunction ();

***************************************/


$a = 1000;

while ( $a < 1000) {
	$a = $a+100;
	echo $a ." <br> \n " ;
};

echo 'ok';
// die() ;

echo " <br> ";

$a = 1000;

do {	
	$a = $a+100;
	echo $a ." <br> \n " ;
}while ( $a < 1000) ;


/*
for ( $a = 0; $a <1000; $a = $a+100 ) {	

	echo $a ." <br> \n " ;
};
*/

/*
$a = 0;

for ($i = 1; $i <=10; $i++) { 

$a = $a + 100;

echo $a ." <br> \n " ;
}

********************************/

$chocolate = array (
	array ("Kinder", 3 , 5, 9),
	array ( "Nestle", 8, 10, 6),
	array ( "Ferrero", 15, 46, 12),
	array ( "Kitkat", 12, 16, 13),
);

/*
echo $chocolate[0][0].": In stock: ".$chocolate[0][1].", sold: ".$chocolate[0][2].", bought : ".$chocolate[0][3]. " <br> \n " ;
echo $chocolate[1][0].": In stock: ".$chocolate[1][1].", sold: ".$chocolate[1][2].", bought : ".$chocolate[1][3]. " <br> \n " ;
echo $chocolate[2][0].": In stock: ".$chocolate[2][1].", sold: ".$chocolate[2][2].", bought : ".$chocolate[2][3].  " <br> \n " ;
echo $chocolate[3][0].": In stock: ".$chocolate[3][1].", sold: ".$chocolate[3][2].", bought : ".$chocolate[3][3]. " <br> \n " ;

***************************************/

for ($row = 0; $row < 4; $row++) {
  echo "<p><b>Row number $row</b></p>";
  
	  for ($col = 0; $col < 4; $col++) {
		echo $chocolate[$row][$col] . " </br> " ;
	  }
  
}

</body>
</html>