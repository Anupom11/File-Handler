
<html>
	<head>
		<title>File Handling </title>
		
		<script type= "text/javascript" language= "javascript">
			function check_input()
			{
				if(document.input_form.user_id.value=="")
				{
					alert('Please enter the details');
					return false;
				}
				else if(document.input_form.passwd.value=="")
				{
					alert('Please enter the details');
					return false;
				}
			}
			
		</script>	
		
	</head>
	
	<body>
	
		<form ENCTYPE="multipart/form-data" id="input_form" name="input_form" method= "POST" action="login_verification.php" onsubmit="return check_input(document.input_form);" >
	
		<div align="center">
			&nbsp;<table border="0" width="100%">
				<tr>
					<td>
						<p align="center"><u><b><font size="5">Log in</font></b></u></p>
					</td>
				</tr>
			</table>
			<table border="0" width="50%" cellspacing="5" cellpadding="5" bgcolor="#77AAFF">
				<tr>
					<td><font color="#FFFFFF"><b>User ID:</b></font></td>
					<td width="378"><input type="text" name="user_id" size="30"></input></td>
				</tr>
				
				<tr>
					<td><font color="#FFFFFF"><b>Password:</b></font></td>
					<td width="378"><input type="password" name="passwd" size="30"></input></td>
				</tr>
				
				<tr>
					<td>
					<p align="right">
					<input type="submit" value="Log in" name="B1" /></td>
					<td width="378"><input type="reset" value="Clear" name="B2" /></td>
				</tr>
			</table>
						
			<?php 
			/*********************************************************************** 
			* Code section to check admin sign up operation
			* by Anupom Chakrabarty date 15/10/2018
			*/
			$conn	= mysql_connect('127.0.0.1', 'root', 'admin') or die("Can not connect with the server.");
			$db		= mysql_select_db('office_file_handling', $conn) or die("Can not select the database.");
			$query	= "select * from admin_account";
			$result = mysql_query($query);
			$numRow = mysql_num_rows($result);
			if($numRow!=0)
			{
				// do not show the sign up link
			}
			else
			{
				// show the sign up operation
			?>
				<table border="0" width="49%" cellspacing="5" cellpadding="5">
				<tr align="left" width="4">
					<td>
						<ul>
							<li> <p> It seems you are login for the first time. Please sign up as an admin account!</p> <a href="sign_up.php">Sign up <br></a>	</li>
						</ul>
					</td>
				</tr>
				</table>
			<?php 
			}
			//*********************************************************************
			
			?>
			
			
		</div>
		</form>
	</body>
</html>