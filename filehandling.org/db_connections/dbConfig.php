<?php
	
	$hostName 	= 'localhost';				// put your db host address here
	$dbName		= 'office_file_handling';	// database name here
	$dbUser		= 'root';					// mysql user name
	$dbPassword	= 'admin';					// mysql password
	
	try {
		$pdo = new PDO ('mysql:host='.$hostName.'; dbname='.$dbName, $dbUser, $dbPassword);
	} catch(PDOException $e) 
	{
		exit('Error in connecting with the database!');
	}
	
?>