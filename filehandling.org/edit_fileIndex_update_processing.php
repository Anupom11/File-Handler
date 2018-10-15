<?php
	//start the session
	SESSION_START();
?>
<html>
	<head>
		<title>File Index Edit Server Response</title>
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
			// get the old and new file index value
			if(isset($_POST['currentFileIndex']) && isset($_POST['newFileIndex']))
			{
				$currentFileIndex 	= $_POST['currentFileIndex'];
				$newFileIndex		= $_POST['newFileIndex'];
			}
			
			if($currentFileIndex!= null && $newFileIndex!= null)
			{				
				// ***********************now modify the following file index value**********************************************
				// create connection with the database
				// connecting to the database
				$conn 	= mysql_connect('127.0.0.1', 'root', 'admin') or die("Can not connect with the server.");
				$db		= mysql_select_db('office_file_handling', $conn) or die("Can not select the database.");
				
				$update_query = "update document_details set file_index='$newFileIndex' where file_index='$currentFileIndex'";
				$updateResult = mysql_query($update_query) or die(mysql_error());
				
				// if successfully deleted then redirect to the dashboard page else show error message 
				if($updateResult)
				{
					echo "Update successfully!";
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