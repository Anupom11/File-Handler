<?php
	// start the session
	SESSION_START();
?>

<html>
	<head>
		<title>Edit Matter Details </title>
		
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
			// now collect the value send in the url.
			if(isset($_GET['number']))
			{
				$slNumber = $_GET['number'];
				// put the serial number in a hidden html field so that it can be used in the later section
			}
			else
			{
				echo "Error in url!";
				return;
			}
			
			// code section added on 07/10/2018, by Anupom Chakrabarty
			// now collect the further details from the DB according to the serial number
			
			$conn 	= mysql_connect('127.0.0.1', 'root', 'admin') or die("Can not connect with the server.");
			$db		= mysql_select_db('office_file_handling', $conn) or die("Can not select the database.");
			
			// getting the file index value for selector
			$fileIndexQuery		= "select distinct file_index from document_details";
			$fileIndexResult	= mysql_query($fileIndexQuery) or die(mysql_error());
			$numFileIndex 		= mysql_num_rows($fileIndexResult);
			
			$query	= "select file_index, date_val, matters, note_sheet, corr_note_sheet, nst_file_address, 
															cnst_file_address from document_details where sl_no='$slNumber'";
			$result		= mysql_query($query) or die(mysql_error());
			$resultRow 	= mysql_fetch_array($result);
			$numRow 	= mysql_num_rows($result);	// no of rows in the result
		
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
				<form ENCTYPE="multipart/form-data" id="upload_form" name="input_form" method= "POST" action="edit_matter_update_processing.php" onsubmit="return check_input(document.input_form);" >
				<!------------------------------------------------------------------------------------------------------------------->
				<!-- Code section to add the hidden field contains serial number of the record that needs to be modified.
					 Code added on 07/10/2018, by Anupom Charabarty.		-->
				
				<input type="hidden" name="sl_no_val" id="sl_name_val" value='<?php echo $slNumber ?>' />
				<!------------------------------------------------------------------------------------------------------------------->				
				<div align="center">
					&nbsp;<table border="0" width="100%">
						<tr>
							<td>
								<a href="dashboard.php" align="left"><font size="4">Cancel</font></p>
						
							<td>
								<p align="center"><u><b><font size="5">Please update the following details</font></b></u></p>
							</td>
						</tr>
					</table>
					<table border="0" width="70%" cellspacing="5" cellpadding="5" bgcolor="#77AAFF">
						<tr>
							<td><font color="#FFFFFF"><b>File Index:</b></font></td>
							<td >
							<select size="1" name="file_index" id="file_index" onchange="new_file_index_check();" >
								<option value="add_new">Add New</option>
								<?php
									//echo $numRow;
									if($numFileIndex!=0)
									{
										while($row = mysql_fetch_array($fileIndexResult))
										{
											//echo $numRow;
											// checking for default select value
											$fileIndexValue = $resultRow["file_index"];	// value already given to the record
											$getFileIndex 	= $row["file_index"];		// file index value list
											if(strcasecmp($fileIndexValue, $getFileIndex)==0)
											{
											?>
												<option value="<?php echo $row["file_index"]; ?>" onload="new_file_index_check();" selected> <?php echo $row["file_index"]; ?> </option>
											<?php
											}
											else
											{
											?>
												<option value="<?php echo $row["file_index"]; ?>"> <?php echo $row["file_index"]; ?> </option>
											<?php
											}
										}
									}
								?>
							</select>
							</td>
							<td><input type="text" name="new_file_index" id="new_file_index" size="30"></input></td>
						</tr>
						<?php
							if($numRow!=0)
							{
						?>		
							<tr>
								<td><font color="#FFFFFF"><b>Date:</b></font></td>
								<td width="218"><input type="date" name="date_val" size="30" value='<?php echo $resultRow["date_val"] ?>'></input></td>
							</tr>
						
							<tr>
								<td><font color="#FFFFFF"><b>Matters:</b></font></td>
								<td width="218"><input type="text" name="matters" size="30" value='<?php echo $resultRow["matters"] ?>'></input></td>
							</tr>
							
							<tr>
								<td><font color="#FFFFFF"><b>Note Sheet:</b></font></td>
								<td><input type="text" name="note_sheet_file_name" size="30" value='<?php echo $resultRow["note_sheet"] ?>'></input></td>
								<td width="422">
									<input type="text" name="uploaded_ns_fileName" readonly="readonly" value='<?php echo $resultRow["nst_file_address"] ?>' size="30"> </input>
								</td>
								<td width="422">
								<input type="file" name="note_sheet" size="21" /></td>
							</tr>
							
							<tr>
								<td><font color="#FFFFFF"><b>Correspondent Note Sheet:</b></font></td>
								<td><input type="text" name="corr_note_sheet_file_name" size="30" value='<?php echo $resultRow["corr_note_sheet"] ?>'></input></td>
								<td width="422">
									<input type="text" name="uploaded_cns_fileName" readonly="readonly" value='<?php echo $resultRow["cnst_file_address"] ?>' size="29"> </input>
								</td>
								<td width="422">
								<input type="file" name="corr_note_sheet" size="20" /></td>
							</tr>
						<?php
							}
						?>
												
						<tr>
							<td>
							<p align="right">
							<input type="submit" value="Update" name="B1" /></td>
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