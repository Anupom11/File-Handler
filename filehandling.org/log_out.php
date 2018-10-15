<?php
	SESSION_START();
?>

<html>
	<head>
		<title> Log out </title>
	</head>
	
	<body>
	
		<?php
			// this is the log out section
			// destroy the session variable
			
			if(session_destroy())
			{
		?>
				<h3>Successfully log out! Please <a href="index.php">Log in </a> again</h3>
		<?php
			}
		?>
	
	</body>
	
</html>