<?php
	// start the session
	SESSION_START();
?>

<html>
	
	<body>
		<?php
		// checking for session validation
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
		
		if($sessionID == "login_success")
		{
			function edit_admin_account()
			{
				// $response = array();
				
				// take the admin current name and new admin name, id and password
				$admin_name 		= $_POST['adminName'];
				$adminid			= $_POST['adminID'];
				$adminpwd			= $_POST['adminPassword'];
				$adminCurrentName 	= $_POST['currentAdminName'];
								
				// do the connection with the server and with the database.
				$conn 	= mysql_connect('127.0.0.1', 'root', 'admin') or die("Can not connect with the server.");
				$db		= mysql_select_db('office_file_handling', $conn) or die("Can not select the database.");
					
				$query 	= "update admin_account set admin_name='$admin_name', password='$adminpwd', admin_id='$adminid' where admin_name='$adminCurrentName'";
				$result	= mysql_query($query);

				if($result){
					//echo "Successfully deleted";
					return true;
				}else{
					//echo "Something went wrong.";
					return false;
				}
					
				// echo the response.
				// echo json_encode($response);
			}

			if(edit_admin_account())
			{
				header('location:manage_account.php');
			}
			else
			{
				?>
				<h3 align="center">Edit admin account operation failed. Please <a href="manage_account.php">go back </a></h3>
				<?php
			}
		}
		else
			echo "Incorrect session ID";

		?>
	</body>
</html>