<?php
	// take the user id and pass on the clicked page
	SESSION_START();	
?>

<html>
	<head>
		<title>Dashboard</title>
	
		<script type= "text/javascript" language= "javascript">
		
			// function to toggling the view of the matters and file details
			// the function has two arguments, one is for the identification of file index and another is for the number of matters
			function showDetails()
			{
				var file_index_id 	= arguments[0];
				var no_matters		= arguments[1];
				
				for(var i=0; i<no_matters; i++)
				{
					var matterDivID 		= 'matter_details'+file_index_id+i;
					//var fileDetailsDivID 	= 'file_details'+file_index_id+i;
					
					var matterName 	= document.getElementById(matterDivID);
					//var fileName	= document.getElementById(fileDetailsDivID);
					
					if(matterName.style.display == 'none')
					{
						matterName.style.display 	= 'block';
					}
					else
					{
						matterName.style.display 	= 'none';
						//fileName.style.display 		= 'none';
					}
				}
			}
			
			// function to handle the onclick operation on the matters details
			function showFileDetails()
			{				
				var matterIndex			= arguments[0];
				var fileDetailsDivID 	= 'file_details'+matterIndex;
				var fileDetailsDiv		= document.getElementById(fileDetailsDivID);
				if(fileDetailsDiv.style.display == 'none')
				{
					fileDetailsDiv.style.display = 'block';
				}
				else
				{
					fileDetailsDiv.style.display = 'none';
				}
			}
			
			// function to hide the details on load of the page
			function hide_details()
			{
				var no_values= arguments[0];
				
				for(var i=0; i<no_values; i++)
				{
					// hide the matters details
					var hideDivName 		= 'matter_details'+i;
					var hide_div			= document.getElementById(hideDivName);
					hide_div.style.display 	= 'none';
					
					// hide the file detials
					var hidefileDivName 		= 'file_details'+i;
					var hide_filediv			= document.getElementById(hidefileDivName);
					hide_filediv.style.display 	= 'none';
				}
			}
			
			// function to do the searching operation
			// we handle the search keyword using the url of this page
			function search_operation()
			{
				var searchKeyword = document.getElementById("doc_search_key").value;
				if(searchKeyword=="")
					alert("Please enter a search keyword");
				else
				{
					//redirect to this page with proper url.
					var redirect_url = "dashboard.php?search="+searchKeyword;
					window.location= redirect_url;
				}
			}
			
			// function to handle the click on matters.
			// At first check the id of the matters and then redirect to the docView file
			// date of addition this code section on 25/09/2018
			function view_doc()
			{
				var arg = arguments[0];
				//alert(arg);
				
				var nsVal	= "ns"+arg;
				var cnsVal 	= "cns"+arg; 
				//alert(nsVal);
				var nsFileAdd  = document.getElementById(nsVal).innerHTML;
				var cnsFileAdd = document.getElementById(cnsVal).innerHTML; 
				
				var redirectOpenFiles = "docView.php?ns="+nsFileAdd+"&cns="+cnsFileAdd;
				//window.location = redirectOpenFiles;
				window.open(redirectOpenFiles, '_blank');
			}
			
			/*****************************************************************
			* Code section to control the working of pop up menu button
			* added by Anupom Chakrabarty, date 10/10/2018
			*/
			function openForm() {
				var fileIndexName = arguments[0];
				document.getElementById("currentFileIndex").value = fileIndexName;
				
				document.getElementById("myForm").style.display = "block";
			}

			function closeForm() {
				document.getElementById("myForm").style.display = "none";
			}
			//****************************************************************
			
		</script>
		
		<script type="text/javascript" src="Edit_button_handler.js"></script>
		
		<link rel="stylesheet" href="style_sheet2.css">
		<link rel="stylesheet" href="edit_buttons_style_sheet.css">
		<link rel="stylesheet" href="popUpMenuStyle.css">
		
	</head>
	
	<body onload="hide_details(10);">
	
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
			// now check for whether it is admin or other user login
			// connecting to the database
			//$conn 	= mysql_connect('127.0.0.1', 'root', 'admin') or die("Can not connect with the server.");
			//$db		= mysql_select_db('office_file_handling', $conn) or die("Can not select the database.");
			
			// retrieve information from the admin_account table
			/*
			$admin_query		= "select admin_name from admin_account";
			$admin_result		= mysql_query($admin_query) or die(mysql_error);
			$admin_result_array = mysql_fetch_array($admin_result);
			$admin_name			= $admin_result_array["admin_name"];
			*/
			$adminName= $dbConnect->getAdminName();
			foreach($adminName as $aName) 
				$admin_name = $aName[0];
				
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
				<table width="1326">
					<tr>
						<td>	
							<input type="text" placeholder="Search..."	id="doc_search_key" name="doc_search_key" class="doc_search_textbox" />
							<input type="button" name="submit_docSearch" value="Search" class="doc_search_button" onclick="search_operation();" />
						</td>
					<?php
						//**********************************************************************************************
						// if log in user is admin then show the buttons else do not show the buttons
						// added on 15/10/2018 by Anupom Chakrabarty
						if(strcmp($admin_name, $user_name)==0) {
					?>
							<td width="200">
								<form action="upload.php">
									<input type="Submit" class="upload_button" Value="Upload New Document" />
								</form>
							</td>
							<td>
								<form action="manage_account.php">
									<input type="Submit" class="addUser_button" Value="Manage Users" />
								</form>
							</td>
					<?php
						}
						//***********************************************************************************************
					?>
					</tr>
				</table>
				<table width="601">
					<tr>
						<td width="137">	
							<p><font size="4">Document List-</font></p>
						</td>
						<td>
							<p><font size="4"><a href="dashboard.php">All list</a></font></p>
						</td>
					</tr>
				</table>		
			</div>	
			
			<?php
				// php section at on 24/10/2018 for testing user search input
				$searchKeywordFlag = false;
				if(isset($_GET['search']))
				{
					// make the search keyword true
					$searchKeywordFlag = true;
					
					$searchKeyword = $_GET['search'];	// get the search keyword
					//echo $searchKeyword;
					//$query_FI = "select distinct file_index from document_details where file_index like '%$searchKeyword%' union select distinct file_index
					//				from document_details where matters like '%$searchKeyword%'";
					//$result_FileIndex = mysql_query($query_FI) or die(mysql_error());
					
					$searchResult = $dbConnect->getSearchResult($searchKeyword);
					
					$count=0;
					foreach($searchResult as $rslt) {
						//echo $rslt[0];
						$result_FileIndex[$count] = $rslt[0];
						$count++;
					}
				}		
				else
				{
					// retrieving the file index values from the table.				
					//$query			= "select distinct file_index from document_details";
					//$result_FileIndex	= mysql_query($query) or die(mysql_error());	
					$getFileIndex = $dbConnect->getAllDistinctFileIndex();
					
					$count				=0;
					$result_FileIndex 	= array();
					foreach($getFileIndex as $fileIndex) {
						//echo " ".$fileIndex[0];
						$result_FileIndex[$count] = $fileIndex[0];
						$count++;
					}					
				}
				
				// **************************show the details here*************************************
				$numRow = sizeof($result_FileIndex);
				if($numRow!=0)
				{
					$i=0;	// initializing the variable
					
					//while($row = mysql_fetch_array($result_FileIndex))
					for($sl=0; $sl<count($result_FileIndex); $sl++)
					{
						$index_variable = "file_index$i";		// id values for file index field
						
						// get the matters and file details against the file index
						//$file_index_val 	= $row["file_index"];	// getting the index value
						$file_index_val = $result_FileIndex[$sl];	// <----getting the index value here---->
						//echo $file_index_val." ";						
						//$mttr_flDtls_query 	= "select date_val, matters, note_sheet, corr_note_sheet, nst_file_address, cnst_file_address, 
						//							sl_no from document_details where file_index='$file_index_val'";
						//$mttr_flDtls_result 	= mysql_query($mttr_flDtls_query) or die(mysql_error());
						//$noRows 				= mysql_num_rows($mttr_flDtls_result);	// getting the number of rows
						
						$mttr_flDtls_result = $dbConnect->getDocumentDetails($file_index_val);
						
						$counter			= 0;
						$mattrAllDetails	= array();	// initialize array to hold the file index matter details
						
						foreach($mttr_flDtls_result as $mttrFlDtlResult) {
							
							$dateVal		= $mttrFlDtlResult[0];
							$matterValue	= $mttrFlDtlResult[1];
							$nsVal			= $mttrFlDtlResult[2];
							$cnsVal			= $mttrFlDtlResult[3];
							$nsFileAddr 	= $mttrFlDtlResult[4];
							$cnsFileAddr	= $mttrFlDtlResult[5];
							$slNo			= $mttrFlDtlResult[6];
							
							// put the details in to a multi dimension array
							$mattrAllDetails[$counter] = array($dateVal, $matterValue, $nsVal, $cnsVal, $nsFileAddr, $cnsFileAddr, $slNo);
							$counter++;	// increment the counter
						}
						
						// get the number of rows in matter details array
						$noRows = count($mattrAllDetails);
						//echo " ".$file_index_val." ".$noRows;
					?>
						<div>
							<table border="0" height="50" width="600">
								<tr id=<?php echo $index_variable;?> class="file_index_style">
									<td onclick="showDetails('<?php echo $i?>', '<?php echo $noRows ?>');" > <b> <?php echo $file_index_val; //echo $row["file_index"]; ?> </b> </td>
								<!--	<td span=4 width="250" align="center"><?php //echo $row["date_val"]; ?></td>	-->
								<!-- Add the buttons to control the editing of file index record -->
								<!------------------------------------------------------------------------------------------------------>
							<?php
								//**********************************************************************************************
								// if log in user is admin then show the file index edit and delete buttons else do not show the buttons
								// added on 15/10/2018 by Anupom Chakrabarty
								if(strcmp($admin_name, $user_name)==0) {
							?>
									<td span=4 width="150" align="center">
										<div class="file_index_edit_buttons">
											<table>
												<tr>
													<td>
														<button type="button" onclick="openForm('<?php echo $file_index_val; //echo $row["file_index"] ?>');"><img src="icon\ic_action_edit.png" alt="EDIT" height="25" /></button>
													</td>
													<td>
														<button type="button" onclick="delete_fileIndex('<?php echo $file_index_val; //echo $row["file_index"] ?>');"><img src="icon\ic_action_discard.png" alt="DELETE" height="25" /></button>
													</td>
												</tr>
											</table>
										</div>										
									</td>
							<?php
								}
							?>
								<!--------------------------------------------------------------------------------------------------------->
								</tr>
							</table>
								 
					<?php
						if($noRows!= 0) 
						{
							// initializing count variable
							$count = 0;
							//while($detailsRows = mysql_fetch_array($mttr_flDtls_result))
							for($pos=0; $pos<count($mattrAllDetails); $pos++)
							{
								//************************************************
								// get the details of a matter
								$date 			= $mattrAllDetails[$pos][0];
								$matter			= $mattrAllDetails[$pos][1];
								$nsVal			= $mattrAllDetails[$pos][2];
								$cnsVal			= $mattrAllDetails[$pos][3];
								$nsFileAddr 	= $mattrAllDetails[$pos][4];
								$cnsFileAddr	= $mattrAllDetails[$pos][5];
								$slNo			= $mattrAllDetails[$pos][6];
								//************************************************
								
								$index_matter_details 	= "matter_details$i$count";
								$index_file_details		= "file_details$i$count";
								// variable to hold the id for showFileDetails() method
								$showFileDetailsID		= "$i$count";
					?>
							<!-- ---------------------------Details of an index--------------------------------------------------------------- -->
							<!--	<div id=<?php //echo $index_matter_details?> onclick="showFileDetails('<?php //echo $showFileDetailsID ?>');" style="display: none;"> -->
								<div id=<?php echo $index_matter_details?> style="display: none;">
									<table width="600">
										<tr>
											<td class="matter_style0" width="78%">
												<div style="width: 350px; float:left;" onclick="view_doc('<?php echo $index_matter_details?>');" >
													<?php echo $matter; //echo $detailsRows["matters"]; ?>
												</div>
											<!-------------------------------------------------------------------------------------------------------------------->
											<!-- div section to show the edit button for matters	-->
										<?php
											//**********************************************************************************************
											// if log in user is admin then show the matters edit and delete buttons else do not show the buttons
											// added on 15/10/2018 by Anupom Chakrabarty
											if(strcmp($admin_name, $user_name)==0) {
										?>
												<div class="file_index_edit_buttons" >
													<table>
														<tr>
															<td>
																<button type="button" onclick="edit_Matters('<?php echo $slNo; //echo $detailsRows["sl_no"] ?>');"><img src="icon\ic_action_edit.png" alt="EDIT" height="25" /></button>
															</td>
															<td>
																<button type="button" onclick="delete_Matters('<?php echo $slNo; //echo $detailsRows["sl_no"] ?>');"><img src="icon\ic_action_discard.png" alt="DELETE" height="25" /></button>
															</td>
														</tr>
													</table>
												</div>
										<?php
											}
										?>
											<!-------------------------------------------------------------------------------------------------------------------->
											</td>
											<td class="date_style" span=4 width="6%" align="center"><?php echo $date; //echo $detailsRows["date_val"]; ?></td>
										</tr>
									</table>
								</div>
								<!-------- the below part should be visible when user click the matter section	---------------->
								<!----  Right now it is invisible to the user. When user click the matters then the files are open in new table --->
								<div style="display:none;">
									<?php
										$nfs	= "ns$index_matter_details";
										$cnfs	= "cns$index_matter_details";
									?>
									<p id=<?php echo $nfs?>><?php echo $nsFileAddr; //echo $detailsRows["nst_file_address"]; ?>  </p>
									<p id=<?php echo $cnfs ?>><?php echo $cnsFileAddr; //echo $detailsRows["cnst_file_address"]; ?>	</p>
								</div>
								<?php
								/*
								<div id=<?php echo $index_file_details?> style="display: none;">
									<table>
										<tr>
											<table width="600">
												<tr class="file_names_style">
													<td><a href=<?php echo $detailsRows["nst_file_address"]?>><?php echo $detailsRows["note_sheet"]; ?></a></td>
												</tr>
												</tr>
												<tr class="file_names_style">
													<td><a href=<?php echo $detailsRows["cnst_file_address"]?>><?php echo $detailsRows["corr_note_sheet"]; ?></a></td>
											</table>
										</tr>
									</table>
								</div>
								*/
								?>
						<!------------------------------------------------------------------------------------------------->
						<!-- --------------------------------------------------------------------------------------------------------- -->
						<?php
							$count++;	// increment the count variable
							}
						}
							
						?>
							<hr align="left" width="500"/>
						</div>
					<?php
						// increment the counter 
						$i++;
					}
				}
		}
		else
			echo "Something went wrong!";
		?>
		
		<!--------- Code section to handle the file index editing form ---------------------------
		----------- code added by Anupom Chakrabarty, date 11/10/2018 --------------------------->
		<div class="form-popup" id="myForm" >
			<form method="post" action="edit_fileIndex_update_processing.php" class="form-container">
				<h2 align="center">Edit File Index</h2>

				<label for="currentFileIndex"><b>Current File Index</b></label>
				<input type="text" placeholder="File Index" id="currentFileIndex" name="currentFileIndex" required readonly>

				<label for="newFileIndex"><b>New File Index</b></label>
				<input type="text" placeholder="File Index" id="newFileIndex" name="newFileIndex" required>

				<input type="submit" class="btn" value="Update"/>
				<input type="button" class="btn cancel" value="Cancel" onclick="closeForm()" />
			</form>
		</div>
		<!---------------------------------------------------------------------------------------->
		
	</body>
</html>

