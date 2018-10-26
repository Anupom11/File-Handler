<?php
	// start the session
	SESSION_START();
?>

<html>
	<head>
		<title>Manage Account </title>
		<script type="text/javascript" language="javascript">
		
			//--------------------------------------------------------------------------------
			// Function required for operating the editing user account details 
			function openEditingForm() {
				var userName 	= arguments[0];
				var password 	= arguments[1];
				var userId		= arguments[2];
				
				document.getElementById("currentUserName").value 	= userName;
				document.getElementById("currentPassword").value 	= password;
				document.getElementById("currentUserID").value 		= userId;				
				
				document.getElementById("editUserDetails").style.display = "block";
			}

			function closeForm() {
				document.getElementById("editUserDetails").style.display = "none";
			}
			//---------------------------------------------------------------------------------
			
			//---------------------------------------------------------------------------------
			// function to add new user account
			function add_UserAccount() {
				document.getElementById("add_newAccount").style.display = "block";
			}
			
			function closeAddUserForm() {
				document.getElementById("add_newAccount").style.display = "none";
			}
			//---------------------------------------------------------------------------------
			
			//---------------------------------------------------------------------------------
			// Function to edit the admin account. Added on 14/10/2018 by Anupom Chakrabarty
			function openEditAdminAccountPanel() {
				document.getElementById("editAdminAccount").style.display = "block";
			}
			
			function closeEditAdminAccountPanel() {
				document.getElementById("editAdminAccount").style.display = "none";
			}
			//---------------------------------------------------------------------------------				
			
		</script>
		
		<link rel="stylesheet" href="style_sheet1.css">
		<link rel="stylesheet" href="style_sheet2.css">
		<link rel="stylesheet" href="popUpMenuStyle.css">
	</head>
	
	<body>
		<?php	
		
		//******************************************************************************
		require_once 'C:\wamp\www\filehandling.org\db_connections\dbConfig.php';
		require_once 'C:\wamp\www\filehandling.org\db_connections\dbAdapter.php';	
		
		$dbConnect = new fileHandlerDB($pdo);	// creating db class object
		//*******************************************************************************
		
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
			// collecting the file index data from the database
		//	$conn 	= mysql_connect('127.0.0.1', 'root', 'admin') or die("Can not connect with the server.");
		//	$db		= mysql_select_db('office_file_handling', $conn) or die("Can not select the database.");
		//	$query	= "select * from user_account";
		//	$result	= mysql_query($query) or die(mysql_error());
		//	$numRow = mysql_num_rows($result);	// no of rows in the result
		
			$userDetails	= $dbConnect->user_details();
			$count 			= 0;
			foreach($userDetails as $details) {
				$users_name[$count]	= $details[0];
				$passWRD[$count]	= $details[1];
				$user_id[$count]	= $details[2];
				$count++;
			}
			$numRow = $count;	// set the number of rows in user account DB
			
		?>
			<div>
				<table width="1327">
					<tr>
						<td>
							<p> <font size="5" color="green">Welcome <?php echo $user_name ?></font></p>
						</td>
						<td width="100">
							<a href="log_out.php" align=right name="log_out">Log out </a>	
						</td>
					</tr>
				</table>	
			</div>
			<hr>
			<table width="1327">
				<tr>
					<td>
						<a href="dashboard.php" align="left"><font size="4">Cancel</font></a>
					<td width="100">
						<input type="button" class="addUser_button" value="Add New User" onclick="add_UserAccount();" />
					</td>
					<td width="100">
						<input type="button" class="addUser_button" value="Edit admin account" onclick="openEditAdminAccountPanel();" />
					</td>
				</tr>
			</table>
			<p align="left"><u><b><font size="4">List of Users</font></b></u></p>
			
		<?php
			
			if($numRow!=0)
			{
				$i=0;	// initializing the variable
			?>	
				<div align="center">
					<table border="0" height="50" width="1000">
					<tr style="background-color:#4CAF50; color: white" height="40">
						<td width="300">
							<p>User Name</p>
						</td>
						<td width="300">
							<p>Password</p>
						</td>
						<td width="300">
							<p>User ID</p>
						</td>
						<td></td>
						<td></td>
					</tr>
				<?php
					//while($row = mysql_fetch_array($result))
					for($i=0; $i<$numRow; $i++)
					{	
						/*
						$userName	= $row["user_name"];
						$password	= $row["password"];
						$user_id	= $row["user_id"];
						*/
						$userName 	= $users_name[$i];
						$password 	= $passWRD[$i];
						$userId		= $user_id[$i];
					?>
						<tr class="file_index_style" >
						<!------------------------------------------------------------------------------------------------------>
							<td width="250">
								<h3><?php echo $userName; ?>
							</td>
							<td width="250">
								<h3><?php echo $password; ?>
							</td>
							<td width="250">
								<h3><?php echo $userId; ?>
							</td>
							<td width="125" align="center">
								<button type="button" onclick="openEditingForm('<?php echo $userName ?>', '<?php echo $password ?>', '<?php echo $userId ?>');"><img src="icon\ic_action_edit.png" alt="EDIT" height="25" /></button>
							</td>
							<td width="125" align="center">
								<!------------------------------------------------------------------------------------------------
								-- Form method to submit the user details to be deleted	------------------------------------------>
								<form method="post" action="delete_user_account.php" >
									<input type="hidden" id="userNameDelete" name="userNameDelete" value='<?php echo $userName ?>' />
									<input type="hidden" id="passwordDelete" name="passwordDelete" value='<?php echo $password ?>' /> 
									<input type="hidden" id="userIdDelete" name="userIdDelete" value='<?php echo $userId ?>' />
									<button type="submit"> <img src="icon\ic_action_discard.png" alt="DELETE" height="25"/></button>
								</form>
							</td>			
							<!--------------------------------------------------------------------------------------------------------->
						</tr>
			<?php
					}
				?>
				</table>
			</div>
		<?php
			}
		}else
			echo "Something went wrong!";
		?>
		
		<!--------- Code section to handle the user detials editing form -----------------------------------------------------------------
		----------- code added by Anupom Chakrabarty, date 26/10/2018 --------------------------->
		<div class="form-popup" id="editUserDetails" >
			<form method="post" action="edit_user_details.php" class="form-container">
				<h2 align="center">Edit User Details</h2>
				<table>
					<tr>
						<td>
							<label for="currentUserName"><b>Current User Name</b></label>
							<input type="text" placeholder="User Name" id="currentUserName" name="currentUserName" required readonly>
						</td>
						<td>
							<label for="newUserName"><b>New User Name</b></label>
							<input type="text" placeholder="User Name" id="newUserName" name="updateUserName" required>
						</td>
					</tr>
					<tr>
						<td>
							<label for="currentPassword"><b>Current Password</b></label>
							<input type="text" placeholder="Password" id="currentPassword" name="currentPassword" required readonly>
						</td>
						<td>
							<label for="newPassword"><b>New Password</b></label>
							<input type="password" placeholder="Password" id="newPassword" name="updatePassword" required>
						</td>
					</tr>
					<tr>
						<td>
							<label for="currentUserID"><b>Current User ID</b></label>
							<input type="text" placeholder="User ID" id="currentUserID" name="currentUserID" required readonly>
						</td>
						<td>
							<label for="newUserID"><b>New User ID</b></label>
							<input type="text" placeholder="User ID" id="newUserID" name="updateUserID" required >
						</td>
					</tr>
				</table>
				
				<input type="submit" class="btn" value="Update"/>
				<input type="button" class="btn cancel" value="Cancel" onclick="closeForm()" />
			</form>
		</div>
		<!------------------------------------------------------------------------------------------------------------------------------------->
		
		<!-------------------------------------------------------------------------------------------------------------------------------------
		-- Code section to add new user account ---------------------------------------------------------------------------------------------
		-- by Anupom Chakrabarty, date 26/10/2018	------------------------------------------------------------------------------------------>
		<div class="form-popup" id="add_newAccount" >
			<form method="post" action="add_new_account.php" class="form-container">
				<h2 align="center">Enter account details</h2>
				<table>
					<tr>
						<td>
							<label for="newUserName"><b>User Name</b></label>
							<input type="text" placeholder="User Name" id="newUserName" name="newUserName" required >
						</td>
					</tr>
					<tr>
						<td>
							<label for="newPassword"><b>Password</b></label>
							<input type="password" placeholder="Password" id="newPassword" name="newPassword" required >
						</td>
					</tr>
					<tr>
						<td>
							<label for="newUserID"><b>User ID</b></label>
							<input type="text" placeholder="User ID" id="newUserID" name="newUserID" required >
						</td>
					</tr>
				</table>
				
				<input type="submit" class="btn" value="Add User"/>
				<input type="button" class="btn cancel" value="Cancel" onclick="closeAddUserForm()" />
			</form>
		</div>
		<!--------------------------------------------------------------------------------------------------------------------------------->
		
		<!-- Code Section to show the edit admin account panel ------------------------------------------------------------
		------ Added on 14/10/2018 by Anupom Chakrabarty  last edited on 26/10/2018 --------------------------------------->
		<?php
			// connect to the database to retrieve admin account information 
			//$conn 	 = mysql_connect('127.0.0.1', 'root', 'admin') or die("Can not connect with the server.");
			//$db		 = mysql_select_db('office_file_handling', $conn) or die("Can not select the database.");
			//$query	 = "select * from admin_account";
			//$result	 = mysql_query($query) or die(mysql_error());
			//$noAdmin = mysql_num_rows($result);
			
			$result		= $dbConnect->getDataAdminAccount();
			$counter	= 0;
			foreach($result as $adminData) {
				$adminName[$counter] = $adminData[0];
				$adminPass[$counter] = $adminData[1];
				$adminID[$counter]   = $adminData[2];
				$counter++;
			}
			$noAdmin = $counter;	// set the number of admins available
			
			if($noAdmin!=0)
			{
				//$rowValue = mysql_fetch_array($result);
				for($i=0; $i<$noAdmin; $i++)
				{
		?>
				<div class="form-popup" id="editAdminAccount" >
					<form method="post" action="edit_admin_account.php" class="form-container">
						<h2 align="center">Edit admin account</h2>
						<table>
							<tr>
								<td>
									<label for="adminName"><b>Admin Name</b></label>
									<input type="text" placeholder="Admin Name" id="adminName" name="adminName" value=<?php echo $adminName[$i]; //echo $rowValue["admin_name"] ?> required >
									<input type="text" name="currentAdminName" value=<?php echo $adminName[$i]; //echo $rowValue["admin_name"] ?> hidden />
								</td>
							</tr>
							<tr>
								<td>
									<label for="adminPassword"><b>Password</b></label>
									<input type="password" placeholder="Password" id="adminPassword" name="adminPassword" required >
								</td>
							</tr>
							<tr>
								<td>
									<label for="adminID"><b>User ID</b></label>
									<input type="text" placeholder="Admin ID" id="adminID" name="adminID"  value=<?php echo $adminID[$i]; //echo $rowValue["admin_id"] ?> required >
								</td>
							</tr>
						</table>
						<input type="submit" class="btn" value="Update"/>
						<input type="button" class="btn cancel" value="Cancel" onclick="closeEditAdminAccountPanel()" />
					</form>
				</div>
		<?php
				}
			}
		?>
		<!-------------------------------------------------------------------------------------------------------------------->
		
	</body>
	
</html>

