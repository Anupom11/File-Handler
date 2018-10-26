<?php
	SESSION_START();
?>

<html>
	<head>
		<title>Update Server Response</title>
	</head>
	
	<body>
	
		<?php

			//******************************************************************************
			require_once 'C:\wamp\www\filehandling.org\db_connections\dbConfig.php';
			require_once 'C:\wamp\www\filehandling.org\db_connections\dbAdapter.php';	
		
			$dbConnect = new fileHandlerDB($pdo);	// creating db class object
			//*******************************************************************************
		
			// checking for session data
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
				if(isset($_POST['sl_no_val']))
				{
					$sl_number = $_POST['sl_no_val'];
				}
				if(isset($_POST['file_index']))
				{
					$file_index_val	= $_POST['file_index'];
				}
				if(isset($_POST['new_file_index']))
				{
					$new_file_index = $_POST['new_file_index'];
				}
				if(isset($_POST['date_val']))
				{
					$date_val = $_POST['date_val'];
				}
				if(isset($_POST['matters']))
				{
					$matters = $_POST['matters'];
				}
				if(isset($_POST['note_sheet_file_name']))
				{
					$note_sheet_file_name = $_POST['note_sheet_file_name'];
				}
				if(isset($_POST['corr_note_sheet_file_name']))
				{
					$corr_note_sheet_file_name = $_POST['corr_note_sheet_file_name'];
				}
				if(isset($_POST['uploaded_ns_fileName']))
				{
					$uploadedNSFileName = $_POST['uploaded_ns_fileName'];	// contains the uploaded ns file name
				}
				if(isset($_POST['uploaded_cns_fileName']))
				{
					$uploadedCNSFileName = $_POST['uploaded_cns_fileName'];	// contains the uploaded cns file name
				}
			
				// now store the data in the database
				// checking for the entry of file names for the uploaded files - note sheet and corrospondant note sheet files
				if($note_sheet_file_name!= null && $corr_note_sheet_file_name!= null)
				{
					// checking for file index name
					// if user entered add name feature then add the new name 
					$str_name= "add_new";	// name of the string to compare
					if(strcmp($file_index_val, $str_name)==0)
						$file_index_val = $new_file_index;
					
					//********************************************************************************************************************
					// taking the file name path.
					$target_path_ns = "note_sheet/";
					$target_path_cns = "correspondent_note_sheet/";
					// checking for user file input, if user does not add the any of the files then take the previous file name.
					// code section added on 09/10/2018, by Anupom Chakrabarty
					$userAddNoteSheetFileName 		= basename($_FILES['note_sheet']['name']);
					$userAddCorrNoteSheetFileName 	= basename($_FILES['corr_note_sheet']['name']);
					
					//----------------------------------------------------------------------------------------
					$userNSFileAddFlag	= false;	// flag variable for user file input operation. True if user add the file else false
					$userCNSFileAddFlag = false;
					// for note sheet
					if($userAddNoteSheetFileName!= null)
					{
						$target_path_ns		= $target_path_ns.basename($_FILES['note_sheet']['name']);				
						$userNSFileAddFlag	= true;
					}
					else
						$target_path_ns = $target_path_ns.$uploadedNSFileName;
					
					// for corresponding note sheet
					if($userAddCorrNoteSheetFileName!=null)
					{
						$target_path_cns 	= $target_path_cns.basename($_FILES['corr_note_sheet']['name']);
						$userCNSFileAddFlag = true;
					}
					else
						$target_path_cns = $target_path_cns.$uploadedCNSFileName;
					//-----------------------------------------------------------------------------------------
					
					//echo $file_index_val." ".$date_val." ".$matters." ".$note_sheet_file_name;
					//*******************************************************************************************************************
													
					//$conn 	= mysql_connect('127.0.0.1', 'root', 'admin')	or die('Could not connect to database server');
					//$db		= mysql_select_db('office_file_handling', $conn) or die('Could not connect to the database');
				
					if(isset($_POST['matters']))	// checking for any entry.
					{	
						//$qryInsert= "INSERT INTO document_details(file_index, date_val, matters, note_sheet, corr_note_sheet, nst_file_address, cnst_file_address) VALUES ('$file_index_val', '$date_val', '$matters', '$note_sheet_file_name', '$corr_note_sheet_file_name', '$target_path_ns', '$target_path_cns')";
						//$qryInsert= "update document_details set file_index='$file_index_val', date_val='$date_val' , 
						//				matters='$matters', note_sheet='$note_sheet_file_name', corr_note_sheet='$corr_note_sheet_file_name', 
						//					nst_file_address='$target_path_ns', cnst_file_address='$target_path_cns' where sl_no='$sl_number'";
						//$rsInsert= mysql_query($qryInsert) or die(mysql_error());
						
						// **********update the current record in DB**************
						$updateReturn = $dbConnect->updateMatterRecord($file_index_val, $date_val, $matters, $note_sheet_file_name, 
																			$corr_note_sheet_file_name, $target_path_ns, $target_path_cns, $sl_number);
						
						//if($rsInsert == true)
						if($updateReturn>0)
						{
							if($userNSFileAddFlag == true && $userCNSFileAddFlag == true)
							{
								if(move_uploaded_file($_FILES['note_sheet']['tmp_name'], $target_path_ns) && move_uploaded_file($_FILES['corr_note_sheet']['tmp_name'], $target_path_cns))
									$update_operation_status = true;
								else
									$update_operation_status = false;
							}
							else if($userNSFileAddFlag == false && $userCNSFileAddFlag == false)
								$update_operation_status = true;
							else
							{
								// if Note sheet file is not uploaded, upload the corrospondant NS file
								if($userNSFileAddFlag == false)
								{
									if(move_uploaded_file($_FILES['corr_note_sheet']['tmp_name'], $target_path_cns))
										$update_operation_status = true;
									else
										$update_operation_status = false;
								}
								else if($userCNSFileAddFlag == false)
								{
									// move the Note sheet file only
									if(move_uploaded_file($_FILES['note_sheet']['tmp_name'], $target_path_ns))
										$update_operation_status = true;
									else
										$update_operation_status = false;
								}
							}
							
							// give reply to the page according to the status of the update operation
							if($update_operation_status == true)
							{
								echo "Successfully uploaded all details";
								?>
								<br/>
								<a href="dashboard.php">Go Back</a>
								<?php
								//header('location:dashboard.php');
							}
							else
							{
								echo "Sorry! some error occurs in saving the file";
								header('location:dashboard.php');
							}
						}
						else if($updateReturn == 0) {
							echo "Update operation failed!";
						}
						else {
							echo "Sorry! some error occurs";
						}
					}
				}
			}
		?>
	</body>
</html>
