<?php
	// start the session
	SESSION_START();
?>

<html>
	<head>
		<title>Upload </title>
		
		<script type= "text/javascript" language= "javascript">
			function check_input()
			{
				if(document.upload_form.file_index.value == "")
				{
					alert('Please enter the details');
					return false;
				}
				else if(document.upload_form.date_val.value=="")
				{
					alert('Please enter the details');
					return false;
				}
				else if(document.upload_form.matters.value=="")
				{
					alert('Please enter the details');
					return false;
				}
				else if(document.upload_form.note_sheet_file_name=="")
				{
					alert('Please enter the details');
					return false;
				}
				else if(document.upload_form.corr_note_sheet_file_name=="")
				{
					alert('Please enter the details');
					return false;
				}
			}
			
			function new_file_index_check()
			{
				var val	= document.getElementById('file_index').value;
				//alert(val);
				if (val =='add_new')
				{
					document.getElementById('new_file_index').style.visibility='visible';
				}
				else 
				{
					document.getElementById('new_file_index').style.visibility='hidden';
				}
			}
		</script>
		
		<link rel="stylesheet" href="style_sheet1.css">
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
			//$conn 	= mysql_connect('127.0.0.1', 'root', 'admin') or die("Can not connect with the server.");
			//$db		= mysql_select_db('office_file_handling', $conn) or die("Can not select the database.");
			//$query	= "select distinct file_index from document_details";
			//$result	= mysql_query($query) or die(mysql_error());
			//$numRow = mysql_num_rows($result);	// no of rows in the result
			
			$returnedfileIndex	= $dbConnect->getAllDistinctFileIndex();
			$counter 			= 0;
			$fileIndexArr 		= array();
			foreach($returnedfileIndex as $index) {
				$fileIndexArr[$counter] = $index[0];
				$counter++;
			}
			$numRow = count($fileIndexArr);
		
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
			<div>
				<form ENCTYPE="multipart/form-data" id="upload_form" name="input_form" method= "POST" action="upload_processing.php" onsubmit="return check_input(document.input_form);" >
				<div align="center">
					&nbsp;<table border="0" width="100%">
						<tr>
							<td>
								<a href="dashboard.php" align="left"><font size="4">Cancel</font></p>
						
							<td>
								<p align="center"><u><b><font size="5">Please enter the following details</font></b></u></p>
							</td>
						</tr>
					</table>
					<table border="0" width="70%" cellspacing="5" cellpadding="5" bgcolor="#77AAFF">
						<tr>
							<td><font color="#FFFFFF"><b>File Index:</b></font></td>
							<td >
							<select size="1" name="file_index" id="file_index" onchange="new_file_index_check();">
								<option value="add_new">Add New</option>
								<?php
									//echo $numRow;
									if($numRow!=0)
									{
										//while($row = mysql_fetch_array($result))
										for($i=0; $i<$numRow; $i++)
										{
											//echo $numRow;
											?>
											<option value="<?php echo $fileIndexArr[$i]; //echo $row["file_index"]; ?>"> <?php echo $fileIndexArr[$i]; //echo $row["file_index"]; ?> </option> 
											<?php
										}
									}
								?>
							</select>
							</td>
							<td><input type="text" name="new_file_index" id="new_file_index" size="30"></input></td>
						</tr>
						
						<tr>
							<td><font color="#FFFFFF"><b>Date:</b></font></td>
							<td width="218"><input type="date" name="date_val" size="30"></input></td>
						</tr>
						
						<tr>
							<td><font color="#FFFFFF"><b>Matters:</b></font></td>
							<td width="218"><input type="text" name="matters" size="30"></input></td>
						</tr>
						
						<tr>
							<td><font color="#FFFFFF"><b>Note Sheet:</b></font></td>
							<td><input type="text" name="note_sheet_file_name" size="30"></input></td>
							<td width="422"><input type="file" name="note_sheet" size="10"/></td>
						</tr>
						
						<tr>
							<td><font color="#FFFFFF"><b>Correspondent Note Sheet:</b></font></td>
							<td><input type="text" name="corr_note_sheet_file_name" size="30"></input></td>
							<td width="422"><input type="file" name="corr_note_sheet" size="10"/></td>
						</tr>
						
						<tr>
							<td>
							<p align="right">
							<input type="submit" value="Save" name="B1" /></td>
							<td width="218"><input type="reset" value="Clear" name="B2" /></td>
						</tr>
					</table>
				</div>
				</form>
			</div>
		<?php
		}else
			echo "Something went wrong!";
		?>
	</body>
	
</html>
