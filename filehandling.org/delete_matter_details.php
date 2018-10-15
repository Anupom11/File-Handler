<?php
	// start the session
	SESSION_START();
?>

<html>
	<head>
		<title>Delete Matter Details</title>
	</head>
	<body>
	
	<?php	
		if(isset($_SESSION['user_name']) && isset($_SESSION['sID']))
		{
			$user_name = $_SESSION['user_name'];
			$sessionID = $_SESSION['sID'];
		}
		else
		{
	?>
			<h3>Something went wrong! Please <a href="index.php">Log in </a></h3>
	<?php
			return;
		}
	
		// checking for the session id
		if($sessionID == "login_success")
		{
			if(isset($_GET['number']))
			{
				$slNumber = $_GET['number'];
								
				// ***********************now delete the following file index value**********************************************
				// create connection with the database
				// connecting to the database
				$conn 	= mysql_connect('127.0.0.1', 'root', 'admin') or die("Can not connect with the server.");
				$db		= mysql_select_db('office_file_handling', $conn) or die("Can not select the database.");
				
				$delete_query = "delete from document_details where sl_no='$slNumber'";
				$deleteResult = mysql_query($delete_query) or die(mysql_error());
				
				// if successfully deleted then redirect to the dashboard page else show error message 
				if($deleteResult)
				{
					echo "Deleted successfully!";
					header('location:dashboard.php');
				}
			}
			else
				echo "Something went wrong!";
		}
		else
		{
			echo "Session expire!";
		}
	?>
	
	</body>
</html>