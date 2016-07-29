<html>
<body>

<h3> Register</h3> <!--FormValidation-->
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
		/***** FormValidation******/
		$name = $surname = $email = $comment = $gender = $username = $password = "";

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
		   $name = test_input($_POST["name"]);
		   $surname = test_input ($_POST ["surname"]);
		   $email = test_input($_POST["email"]);
		   $comment = test_input($_POST["comment"]);
		   $gender = test_input($_POST["gender"]);
		   $username = test_input($_POST["username"]);
		   $password = test_input ( $_POST ["password"]);
		}

		function test_input($data) {
		   $data = trim($data);
		   $data = stripslashes($data);
		   $data = htmlspecialchars($data);
		   return $data;
		} ?>

<?php
	echo "<h4>Your Input:</h4>";
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

		<!-- Form Required -->

<h3> Form Required</h3>

<p><span class="error">*required field</span></p>

	<form action="<?php echo htmlspecialchars( $_SERVER["PHP_SELF"]); ?>" method='post'>

		Name:
		<input type='text' name="name">
		<span class="error">*<?php echo $nameError;?></span>
		<br><br>

		Surname:
		<input type='text' name="surname">
		<span class="error">*<?php echo $surnameError;?></span>
		<br><br>

		Email Address:
		<input type='text' name="email">
		<span class="error">*<?php echo $emailError;?></span>
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
	   <span class="error">*<?php echo $usernameError;?></span>
		<br><br>

		Password:
		<input type='text' name="password">
		<span class="error">*<?php echo $passwordError;?></span>
		<br><br>

		<input type='submit' name='Submit' value='Submit' />
		<br><br>


	</form>

		<?php
		$nameError = $surnameError = $emailError = $usernameError = $passwordError = "";
		$name = $surname = $email = $comment = $gender = $username = $password = "";

		if ($_SERVER ["REQUEST_METHOD"] =="POST") {
			 if (empty($_POST["name"])) { $nameError = "Name is required";
				  } else {
					$name = test_input($_POST["name"]);
				  }

			if (empty ($_POST["surname"])) { $surnameError ="Surname is required";
				} else {
				$surname = test_input($_POST ["surname"]);
				}

			if (empty ($_POST["email"])) {$emailError = "Email is required";
				} else {
					$email = test_input ($_POST["email"]);
				}

			if (empty($_POST["username"])) {$usernameError = "Username is required";
			} else {
				$username = test_input ($_POST ["username"]);
			}

			if (empty($_POST["password"])) { $passwordError = " Password is required";

			} else { $password = test_input ($_POST ["password"]);
			}
		}

		?>

<?php
	echo "<h4>Your Input:</h4>";
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
