<?php
function database_connect()
{
	$server = "localhost";
	$dbname = "project1";
	$user = "root";
	$password = "bharath1997";

	$connect = mysqli_connect($server, $user, $password, $dbname);
	if (!$connect)
	{
		apologize("Can't establish connection(error): ");
		die();
	}
		
	return $connect;
}

function query($conn, $query)
{
	$result = mysqli_query($conn, $query);
	return $result;
}

function apologize($msg){
	render("apology.php",["msg"=>$msg]);
	
}
function render($view,$values=[]){
	if(file_exists("../views/{$view}")){
		extract($values);
		require("../views/header.php");
		require("../views/{$view}");
		require("../views/footer.php");
		exit ;
	}
	else{
		trigger_error("invalid view {$view}",	E_USER_ERROR);
	}
}

function redirect($location)
{
    if (headers_sent($file, $line))
    {
         trigger_error("HTTP headers already sent at {$file}:{$line}", E_USER_ERROR);
    }
    header("Location: {$location}");
    exit;
}
?>	
