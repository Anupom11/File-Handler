<?php
// This file is written to check the login status.
//start the session
SESSION_START();
$user_name = null;	// variable to get the user name

function login()
{
	$response = array();
	
	// take the user name and password coming from the user request.
	$uid	= $_POST['user_id'];
	$pwd	= $_POST['passwd'];
	
	//$uname ="Anupom";
	//$pwd ="helloworld";
	
	// do the connection with the server and with the database.
	$conn 	= mysql_connect('127.0.0.1', 'root', 'admin') or die("Can not connect with the server.");
	$db		= mysql_select_db('office_file_handling', $conn) or die("Can not select the database.");
		
	// we need to look in two table for verification. The user may be admin or normal user
	// get data from the user account
	$query	= "select * from user_account where user_id= '$uid' and password= '$pwd'";
	$result	= mysql_query($query);
	
	// get data from admin table
	$adminQuery  = "select * from admin_account";
	$adminResult = mysql_query($adminQuery);

	if($result || $adminResult){
		//-------------------------------------------------------------------------------
		// retrieve information from the user account table
		$row 			= mysql_fetch_array($result);	
		$user_name		= $row["user_name"];	// set the user name in session variable
		$returned_name	= $row["user_id"];
		$returned_pwd	= $row["password"];
		//--------------------------------------------------------------------------------
		
		//--------------------------------------------------------------------------------
		// retrieve information from the admin account table
		$rowAdmin 	= mysql_fetch_array($adminResult);
		$adminName 	= $rowAdmin["admin_name"];
		$adminID	= $rowAdmin["admin_id"];
		$adminPWD	= $rowAdmin["password"];
		//--------------------------------------------------------------------------------
		
		if($returned_name == $uid && $returned_pwd == $pwd)
		{
			//*********************************************************************
			// adding the user name in the session.
			$_SESSION['user_name'] 	= $user_name ;
			//*********************************************************************
			$response["msg"] = true;
			print "successfull";
			return true;
		}	
		else if($adminID == $uid && $adminPWD == $pwd)
		{
			//*********************************************************************
			// adding the user name in the session.
			$_SESSION['user_name'] 	= $adminName ;
			//*********************************************************************
			$response["msg"] = true;
			print "successfull";
			return true;
		}
		else
		{
			$response["msg"] = false;
		//	print "Failed";
			return false;
		}
			
	}else{
		echo "Something went wrong.";
	}
	
	// echo the response.
	echo json_encode($response);
	
}

if(login())
{
	// succesfully login.
	// This session value will be used as a key for session verification 
	$_SESSION['sID'] 	= "login_success";
	
	// redirect to dashboard page
	header('location:dashboard.php');
}
else
{
	?>
	<h3>Login failed! Please <a href="index.php">Log in </a>again</h3>
	<?php
}

?>