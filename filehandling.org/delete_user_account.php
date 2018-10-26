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
			function delete_user_account()
			{
				//******************************************************************************
				require_once 'C:\wamp\www\filehandling.org\db_connections\dbConfig.php';
				require_once 'C:\wamp\www\filehandling.org\db_connections\dbAdapter.php';	
		
				$dbConnect = new fileHandlerDB($pdo);	// creating db class object
				//*******************************************************************************
				
				// doing deletation operation

				// $response = array();
					
				// take the user name and password coming from the user request.
				$user_name 	= $_POST['userNameDelete'];
				$uid		= $_POST['userIdDelete'];
				$pwd		= $_POST['passwordDelete'];
				
				// echo $user_name." ".$uid." ".$pwd;
				// echo $user_name;
				
				// do the connection with the server and with the database.
				//$conn 	= mysql_connect('127.0.0.1', 'root', 'admin') or die("Can not connect with the server.");
				//$db		= mysql_select_db('office_file_handling', $conn) or die("Can not select the database.");
					
				//$query 	= "delete from user_account where user_name='$user_name' and user_id='$uid' and password='$pwd'";
				//$result	= mysql_query($query);
				
				$result = $dbConnect->deleteUserAccount($user_name, $uid, $pwd);
				
				if($result>0) {
					//echo "Successfully deleted";
					return true;
				}
				else if($result == 0) {
					echo "Delete operation failed!";
					return false;
				}
				else {
					//echo "Something went wrong.";
					return false;
				}
					
				// echo the response.
				// echo json_encode($response);
			}

			if(delete_user_account())
			{
				header('location:manage_account.php');
			}
			else
			{
				?>
				<h3 align="center">Delete operation failed. Please <a href="manage_account.php">go back </a></h3>
				<?php
			}
		}
		else
			echo "Incorrect session ID";

		?>
	</body>
</html>
