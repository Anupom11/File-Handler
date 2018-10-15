<html>
	<head>
		<title>Sign Up </title>
	</head>
	
	<script type= "text/javascript" language= "javascript">
		function check_input()
		{
			if(document.input_form.user_name.value=="")
			{	
				alert('Please enter the details');
				return false;
			}
			else if(document.input_form.user_id.value=="")
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
	
	<body>
		<form ENCTYPE="multipart/form-data" id="input_form" name="input_form" method= "POST" action="sign_up_processing.php" onsubmit="return check_input(document.input_form);" >
	
		<table border="0" width="100%" align="center">
			<td>
				<tr>
					<a href="index.php">Back <br></a>
				</tr>
			</td>
		</table>
		<div align="center">
			&nbsp;<table border="0" width="100%">
				<tr>
					<td>
						<p align="center"><u><b><font size="5">Sign up</font></b></u></p>
					</td>
				</tr>
			</table>
			<table border="0" width="41%" cellspacing="5" cellpadding="5" bgcolor="#77AAFF">
				<tr>
					<td><font color="#FFFFFF"><b>User Name:</b></font></td>
					<td width="287"><input type="text" name="user_name" size="30"></input></td>
				</tr>
				<tr>
					<td><font color="#FFFFFF"><b>User ID:</b></font></td>
					<td width="287"><input type="text" name="user_id" size="30"></input></td>
				</tr>
				
				<tr>
					<td><font color="#FFFFFF"><b>Password:</b></font></td>
					<td width="287"><input type="password" name="passwd" size="30" ></input></td>
				</tr>
				
				<tr>
					<td>
					<p align="right">
					<input type="submit" value="Sign up" name="B1" /></td>
					<td width="287"><input type="reset" value="Clear" name="B2" /></td>
				</tr>
			</table>
		</div>
		</form>
		<?php
			
		?>
		<p align="center">&nbsp;</p>
				
	</body>
</html>