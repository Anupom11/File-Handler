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
			function update_user_account()
			{
				//******************************************************************************
				require_once 'C:\wamp\www\filehandling.org\db_connections\dbConfig.php';
				require_once 'C:\wamp\www\filehandling.org\db_connections\dbAdapter.php';	
		
				$dbConnect = new fileHandlerDB($pdo);	// creating db class object
				//*******************************************************************************
				
				// doing deletation operation

				// $response = array();
					
				// take the previous user account details
				$current_user_name 	= $_POST['currentUserName'];
				$current_pwd		= $_POST['currentPassword'];
				$current_uid		= $_POST['currentUserID'];
				
				// new user account details
				$update_user_name 	= $_POST['updateUserName'];
				$update_pwd			= $_POST['updatePassword'];
				$update_uid			= $_POST['updateUserID'];
				
				//echo $current_user_name." ".$current_pwd." ".$current_uid."+".$update_user_name." ".$update_pwd." ".$update_uid;
				
				
				// do the connection with the server and with the database.
				//$conn 	= mysql_connect('127.0.0.1', 'root', 'admin') or die("Can not connect with the server.");
				//$db		= mysql_select_db('office_file_handling', $conn) or die("Can not select the database.");
					
				//$query 	= "update user_account set user_name='$update_user_name', password='$update_pwd', user_id='$update_uid' 
				//				where user_name='$current_user_name' and password='$current_pwd' and user_id='$current_uid'";
				//$result	= mysql_query($query);

				$result = $dbConnect->editUserAccount($update_user_name, $update_pwd, $update_uid, $current_user_name, $current_pwd, $current_uid);
				
				if($result>0){
					//echo "Successfully added";
					return true;
				}else{
					//echo "Something went wrong.";
					return false;
				}
					
				// echo the response.
				// echo json_encode($response);
			}

			if(update_user_account())
			{
				header('location:manage_account.php');
			}
			else
			{
				?>
				<h3 align="center">Account update operation failed. Please <a href="manage_account.php">go back </a></h3>
				<?php
			}
		}
		else
			echo "Incorrect session ID";
		?>
	
	</body>
</html>
