<html>
<body>

<p> Method get</p>
	
<?php	print_r ($_GET) ; ?>

	 Welcome <?php echo $_GET ["login"] ; ?> 
	Your password is <?php echo $_GET ["password"] ; ?>
	
	
	
<p> Method post</p>	
	Welcome <?php echo $_POST ["login"] ; ?>
	Your password is <?php echo $_POST ["password"] ; ?>
</body>
</html>

<html>
<body>

	Welcome <?php echo $_POST ["name"]?>
	
	Your password is <?php echo $_POST ["password"] ?>

</body>
</html>