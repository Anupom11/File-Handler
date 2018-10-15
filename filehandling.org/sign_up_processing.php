<html>
	
	<body>
		<?php

		function sign_up()
		{
			// doing admin sign up operation

			$response = array();
				
			// take the user name and password coming from the user request.
			$user_name 	= $_POST['user_name'];
			$uid		= $_POST['user_id'];
			$pwd		= $_POST['passwd'];
			/*
			print $user_name;
			print $uid;
			print $pwd;
			*/
			//$uname ="Anupom";
			//$pwd ="helloworld";
			
			// do the connection with the server and with the database.
			$conn 	= mysql_connect('127.0.0.1', 'root', 'admin') or die("Can not connect with the server.");
			$db		= mysql_select_db('office_file_handling', $conn) or die("Can not select the database.");
				
			$query = "insert into admin_account values('$user_name', '$pwd', '$uid')";
			$result	= mysql_query($query);

			if($result){
				//echo "Successfully created";
				return true;
			}else{
				//echo "Something went wrong.";
				return false;
			}
				
			// echo the response.
			echo json_encode($response);
		}

		if(sign_up())
		{
			?>
			<h3>Admin Sign up is completed.</h3>
			Please remember your user id and password.
			<br/>
			<br/>
			Please <a href="index.php">go back </a>to the log in page. </h3>
			<?php
		}
		else
		{
			?>
			<h3 align="center">Sign up failed. Please <a href="sign_up.php">sign up </a> again. </h3>
			<?php
		}

		?>
	</body>
</html>