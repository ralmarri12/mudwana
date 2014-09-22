<?php
	
	// Database host: ==========================================
	$db_host	 = 'localhost';

	// Database name: ==========================================
	$db_name 	 = 'activity';

	// Database username: ======================================
	$db_username = 'root';

	// Database password: ======================================
	$db_password = '';



	$connection = null;

	try{
		$connection = new PDO("mysql:host={$db_host};dbname={$db_name}", $db_username, $db_password);
	}catch(PDOException $e){
		die($e->getMessage());
	}



	// Includes: ==============================================
	spl_autoload_register(function($class){
		require_once('classes/'.$class.'.php');
	});

	require_once('usefulFunctions.php');



	
?>