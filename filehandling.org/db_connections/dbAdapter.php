<?php
	// class contains all the function to retrieve information from the tables of the database
	// by Anupom Chakrabarty, date 26/10/2018
	
	class fileHandlerDB {
		
		function __construct($pdo){
			$this->pdo = $pdo;
		}
		//*************************************************************************************************************
		// functions to be used in login operations
		// function to retrieve all information from admin_account table
		function getDataAdminAccount() {
			$query = $this->pdo->prepare('select * from admin_account');
			$query->execute();
			return $query->fetchAll();
		}
		
		// function to check login details in user_account table
		function checkLoginUserAccount($id, $pwd) {
			$query = $this->pdo->prepare('select * from user_account where user_id=? and password=?');
			$param = array($id, $pwd);
			$query->execute($param);
			return $query->fetchAll();
		}
		//**************************************************************************************************************
		
		//****************************************************************************************************************
		// function to retrieve admin name from admin_account table
		function getAdminName() {
			$query = $this->pdo->prepare('select admin_name from admin_account');
			$query->execute();
			return $query->fetchAll();
		}
		
		//****************************************************************************************************************
		// function to get information from the DB according to the search query
		function getSearchResult($searchKeyword) {
			$query_search 	= "select distinct file_index from document_details where file_index like ? union select distinct file_index
								from document_details where matters like ? ";
			
			$query 			= $this->pdo->prepare($query_search);
			
			$searchWord		= '%'.$searchKeyword.'%';
			$searchPar		= array($searchWord, $searchWord);
			
			$query->execute($searchPar);
			
			return $query->fetchAll();
		}
		
		// function to give all the file index values
		function getAllDistinctFileIndex() {
			$query = $this->pdo->prepare('select distinct file_index from document_details');
			$query->execute();
			return $query->fetchAll();
		}
		
		// function to get all kind of documents details for records according to file index value
		function getDocumentDetails($fileIndexVal) {
			$queryDetails	= "select date_val, matters, note_sheet, corr_note_sheet, nst_file_address, cnst_file_address, sl_no from document_details 
								where file_index=?";
			$query			= $this->pdo->prepare($queryDetails);
			$fileIndexName	= array($fileIndexVal);
			$query->execute($fileIndexName);
			return $query->fetchAll();
		}
		
		// ***function to update the file index value in the dashboard***
		function updateFileIndexVal($newFileIndex, $oldFileIndex) {
			$update_query	= "update document_details set file_index=? where file_index=?";
			$query			= $this->pdo->prepare($update_query);
			
			$fileIndexVal	= array($newFileIndex, $oldFileIndex);
			$query->execute($fileIndexVal);
			
			$rowUpdated		= $query->rowCount();	// get the number of rows updated	
			return $rowUpdated;
		}
		
		// ***function to do the delete file index operation***
		function deleteFileIndex($fileIndex) {
			$delFileIndexQuery 	= "delete from document_details where file_index=?";
			$query				= $this->pdo->prepare($delFileIndexQuery);
			
			$fileIndexVal 		= array($fileIndex);
			$query->execute($fileIndexVal);
			
			$rowDeleted			= $query->rowCount();	// get the number of rows deleted
			return $rowDeleted;
		}
		
		// function to get the matter details according to a particular serial number
		function getMatterDetailsBySlNo($sl) {
			$matterDetailQuery 	= "select file_index, date_val, matters, note_sheet, corr_note_sheet, nst_file_address, 
									cnst_file_address from document_details where sl_no=?";
			$query				= $this->pdo->prepare($matterDetailQuery);
			$slNo				= array($sl);
			$query->execute($slNo);
			return $query->fetchAll();
		}
		
		// function to update the current matter details record in DB
		function updateMatterRecord($fileIndexVal, $dateVal, $matterVal, $nsFileName, $cnsFileName, $nsFileAddr, $cnsFileAddr, $slNumber) {
			$updateQuery 	= "update document_details set file_index=?, date_val=? , matters=?, note_sheet=?, corr_note_sheet=?, 
								nst_file_address=?, cnst_file_address=? where sl_no=?";
									
			$query		 	= $this->pdo->prepare($updateQuery);
			$matterDetails	= array($fileIndexVal, $dateVal, $matterVal, $nsFileName, $cnsFileName, $nsFileAddr, $cnsFileAddr, $slNumber);
			$query->execute($matterDetails);
			
			$rowUpdated 	= $query->rowCount(); // count the number of rows get updated
			return $rowUpdated;
		}
		
		/* function to delete matter details
		 * serial number is taken into account to delete a particular matter details
		*/
		function deleteMatterDetails($slNo) {
			$delQuery 	= "delete from document_details where sl_no=?";
			$query		= $this->pdo->prepare($delQuery);
			$sl			= array($slNo);
			$query->execute($sl);
			
			$rowDel 	= $query->rowCount();	// count the number of rows get deleted
			return $rowDel;
		}
		
		// function to insert new document details in DB
		function uploadNewDoc($file_index_val, $date_val, $matters, $note_sheet_file_name, $corr_note_sheet_file_name, $target_path_ns, $target_path_cns) {
			$qryInsert	= "INSERT INTO document_details(file_index, date_val, matters, note_sheet, corr_note_sheet, nst_file_address, cnst_file_address) VALUES (?, ?, ?, ?, ?, ?, ?)";
			$query		= $this->pdo->prepare($qryInsert);
			$docDetails	= array($file_index_val, $date_val, $matters, $note_sheet_file_name, $corr_note_sheet_file_name, $target_path_ns, $target_path_cns);
			$query->execute($docDetails);
			
			$rowInsert	= $query->rowCount();
			return $rowInsert;
		}
		
		// function to return all user details
		function user_details() {
			$query = $this->pdo->prepare("select * from user_account");
			$query->execute();
			return $query->fetchAll();
		}
		
		// function to delete user account details
		function deleteUserAccount($user_name, $uid, $pwd) {
			$delQuery 	= "delete from user_account where user_name=? and user_id=? and password=?";
			$query		= $this->pdo->prepare($delQuery);
			$userInfo	= array($user_name, $uid, $pwd);
			$query->execute($userInfo);
			
			$rowUserDel = $query->rowCount();
			return $rowUserDel;
		}
		
		// function to update user account details 
		function editUserAccount($update_user_name, $update_pwd, $update_uid, $current_user_name, $current_pwd, $current_uid) {
			$editQuery 		= "update user_account set user_name=?, password=?, user_id=? where user_name=? and password=? and user_id=?";
			
			$query			= $this->pdo->prepare($editQuery);
			$editDetails	= array($update_user_name, $update_pwd, $update_uid, $current_user_name, $current_pwd, $current_uid);
			
			$query->execute($editDetails);
			
			$rowUserEdited	= $query->rowCount();
			return $rowUserEdited;
		}
		
		// function to add new user account
		function addNewUserAccount($user_name, $uid, $pwd) {
			$addUserQuery 	= "insert into user_account(user_name, user_id, password) values (?, ?, ?)";
			$query			= $this->pdo->prepare($addUserQuery);
			$userDetails	= array($user_name, $uid, $pwd);
			$query->execute($userDetails);
			
			$rowUserAdd		= $query->rowCount();
			return $rowUserAdd;
		}
		
	}
?>