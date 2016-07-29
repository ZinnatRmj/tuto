<html>
<body>

<h3> Register</h3>

<form action="<?php echo htmlspecialchars( $_SERVER["PHP_SELF"]); ?>" method='post'>

		Name:
		<input type='text' name="name">
		<br><br>

		Surname:
		<input type='text' name="surname">
		<br><br>

		Email Address:
		<input type='text' name="email">
		<br><br>

		Comment:
		<textarea name="comment" rows="5" cols="40"></textarea>
		<br><br>

	   Gender:
	   <input type="radio" name="gender" value="female">Female
	   <input type="radio" name="gender" value="male">Male
	   <br><br>

	   UserName:
	   <input type='text' name="username">
		<br><br>

		Password:
		<input type='text' name="password">
		<br><br>

		<input type='submit' name='Submit' value='Submit' />
		<br><br>


	</form>

		<?php

		$name = $surname = $email = $comment = $gender = $username = $password = "";

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
		   $name = ($_POST["name"]);
		   $surname = ($_POST ["surname"]);
		   $email = ($_POST["email"]);
		   $comment = ($_POST["comment"]);
		   $gender = ($_POST["gender"]);
		   $username = ($_POST["username"]);
		   $password = ( $_POST ["password"]);
		}

		/*function test_input($data) {
		  $data = trim($data);
		   $data = stripslashes($data);
		   $data = htmlspecialchars($data);
		   return $data;
		}*/

	?>

<?php
	echo $name;
	echo "<br>";
	echo $surname;
	echo "<br>";
	echo $email;
	echo "<br>";
	echo $comment;
	echo "<br>";
	echo $gender;
	echo "<br>";
	echo $username;
	echo "<br>";
	echo $password;
?>


</body>
</html>
