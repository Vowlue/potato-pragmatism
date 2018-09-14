<?php
	$conn = new PDO("mysql:hostname=localhost;dbname=raytato","root","");
	function getDBResults($cmd, $arrayType = PDO::FETCH_NUM)
	{
		global $conn;
		$result = $conn->prepare($cmd);
		$result->execute();		
		return $result->fetchAll($arrayType);
	}
	$something = $_GET['javiy'];
	$joeys = getDBResults("SELECT `message` FROM `messages` WHERE `virtue` = ".$something);
	echo json_encode($joeys[mt_rand(0, count($joeys)-1)]);
?>