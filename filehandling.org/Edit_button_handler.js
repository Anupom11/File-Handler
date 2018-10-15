
/*
* File contains functions that handle different Edit/Delete buttons in the dashboard
* Date of creation 07/10/2018, by Anupom Chakrabarty
*/

//*****************************************************************************************
// Below function to handle the operations of the file index values
/*
function edit_fileIndex()
{
	var indexName = arguments[0];
	alert(indexName);
}
*/
function delete_fileIndex()
{
	var indexName = arguments[0];
	//alert(indexName);
	
	// now redirect to the delete handler page for file indexes
	var redirect_fileIndexdeletePage 	= "delete_file_index.php?fileIndex="+indexName;
	window.location 					= redirect_fileIndexdeletePage; 
}

//******************************************************************************************

//******************************************************************************************
// Below functions to handle the operations on the matter values
function edit_Matters()
{
	var sl_no 	= arguments[0];
	//alert(sl_no);
	
	// redirect to the editing page i.e. edit_matter.php
	var redirect_matterEditPage = "edit_matter.php?number="+sl_no;
	window.location				= redirect_matterEditPage;
}

function delete_Matters()
{
	var sl_no 	= arguments[0];
	//alert(sl_no);
	
	// now redirect to the delete handler page for matters
	var redirect_matterdeletePage 	= "delete_matter_details.php?number="+sl_no;
	window.location 				= redirect_matterdeletePage;
}

//************************************************************************
