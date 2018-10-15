<?php
	SESSION_START();
?>

<html>
	<head>
		<title>Upload Server Response</title>
	</head>
	
	<body>
	
		<?php

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
			
				// now store the data in the database
				// checking for the entry of file names for the uploaded files - note sheet and corrospondant note sheet files
				if($note_sheet_file_name!= null && $corr_note_sheet_file_name!= null)
				{
					// checking for file index name
					// if user entered add name feature then add the new name 
					$str_name= "add_new";	// name of the string to compare
					if(strcmp($file_index_val, $str_name)==0)
						$file_index_val = $new_file_index;
					
					// taking the file name path.
					// for note sheet
					$target_path_ns = "note_sheet/";
					$target_path_ns = $target_path_ns.basename($_FILES['note_sheet']['name']);
					// for corresponding note sheet
					$target_path_cns = "correspondent_note_sheet/";
					$target_path_cns = $target_path_cns.basename($_FILES['corr_note_sheet']['name']);
					
					//echo $file_index_val." ".$date_val." ".$matters." ".$note_sheet_file_name;
													
					$conn 	= mysql_connect('127.0.0.1', 'root', 'admin')	or die('Could not connect to database server');
					$db		= mysql_select_db('office_file_handling', $conn) or die('Could not connect to the database');
				
					if(isset($_POST['matters']))	// checking for any entry.
					{	
						$qryInsert= "INSERT INTO document_details(file_index, date_val, matters, note_sheet, corr_note_sheet, nst_file_address, cnst_file_address) VALUES ('$file_index_val', '$date_val', '$matters', '$note_sheet_file_name', '$corr_note_sheet_file_name', '$target_path_ns', '$target_path_cns')";
						$rsInsert= mysql_query($qryInsert) or die(mysql_error());
						
						if($rsInsert == true)
						{
							if(move_uploaded_file($_FILES['note_sheet']['tmp_name'], $target_path_ns) && move_uploaded_file($_FILES['corr_note_sheet']['tmp_name'], $target_path_cns))
							{
								echo "Successfully uploaded all details";
								?>
								<br/>
								<a href="upload.php">Go Back</a>
								<?php
								//header('location:upload.php');
							}else
							{
								echo "Sorry! some error occurs in saving the file";
								header('location:upload.php');
							}
						}
						else
						{
							echo "Sorry! some error occurs";
						}
					}
				}
			}
		?>
	</body>
</html>