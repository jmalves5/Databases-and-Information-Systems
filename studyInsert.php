<html>
	<head>
		<meta charset="utf-8" />
	</head>
	<body>
		<?php

	$StudyRequest_number=$_POST["request_number"];	
	$StudyDescription=$_POST["description"];
	$StudyDoctor_id=$_POST["doctor_id_study"];
	$RequestDoctor_id=$_POST["doctor_id_request"];
	$Patient_id=$_POST["patient_id"];
	$StudyManufacturer=$_POST["manufacturer"];
	$StudySerial_number=$_POST["serial_number"];

	$StudyDate=date("Y-m-d h:i:s");

	$TableRequest="Request";
	$TableStudy="Study";
	$TableSeries="Series";	
	$dateStr="date";
	$numberStr="number";

	require_once __DIR__ . '/PDO_connection.php';

	$sql = "SELECT series_id FROM Series ORDER BY series_id desc";

	$result=$connection->query($sql);
		if ($result == FALSE)
		{
			$info = $connection->errorInfo();
			echo("<p>Error: {$info[2]}</p>");
			echo("<br><br>");
			echo("Study Not Created");
			exit();
		}

		$counter=0;
		$NewSeries_id=2;

			foreach($result as $row)
			{
				if($counter == 0){
					$NewSeries_id=$row['series_id']+1;
				}
				$counter=$counter+1;
			}


	$connection->beginTransaction();

	$result =$connection->prepare( "INSERT INTO $TableRequest($numberStr,patient_id,doctor_id,$dateStr) values(?,?,?,?)");
	$result->bindParam(1, $StudyRequest_number, PDO::PARAM_INT);
	$result->bindParam(2, $Patient_id, PDO::PARAM_INT);
	$result->bindParam(3, $RequestDoctor_id, PDO::PARAM_STR, 30);
	$result->bindParam(4, $StudyDate, PDO::PARAM_STR, 30);
		
	$test=$result->execute();

	if ($test == FALSE)
		{
			$info = $connection->errorInfo();
			echo("<p>Error: {$info[2]}</p>");
			echo("<br><br>");
			echo("Study Not Created");
			exit();
		}

	

	$result =$connection->prepare( "INSERT INTO $TableStudy(request_number,description,$dateStr,doctor_id,manufacturer,serial_number) values(?,?,?,?,?,?)");
	$result->bindParam(1, $StudyRequest_number, PDO::PARAM_INT);
	$result->bindParam(2, $StudyDescription, PDO::PARAM_STR, 60);
	$result->bindParam(3, $StudyDate, PDO::PARAM_STR, 30);
	$result->bindParam(4, $StudyDoctor_id, PDO::PARAM_INT);
	$result->bindParam(5, $StudyManufacturer, PDO::PARAM_STR, 30);
	$result->bindParam(6, $StudySerial_number, PDO::PARAM_INT);
		
	$test=$result->execute();

		if ($test == FALSE)
		{
			$info = $connection->errorInfo();
			echo("<p>Error: {$info[2]}</p>");
			echo("<br><br>");
			echo("Study Not Created");
			exit();
		}

	$BaseURL="web.ist.utl.pt/".$user."/series/".$NewSeries_id;
	$result =$connection->prepare( "INSERT INTO $TableSeries(series_id,name,base_url,request_number,description) values(?,?,?,?,?)");
	$result->bindParam(1, $NewSeries_id, PDO::PARAM_INT);
	$result->bindParam(2, $StudyDescription, PDO::PARAM_STR, 60);
	$result->bindParam(3, $BaseURL, PDO::PARAM_STR, 30);
	$result->bindParam(4, $StudyRequest_number, PDO::PARAM_INT);
	$result->bindParam(5, $StudyDescription, PDO::PARAM_STR, 30);

	$test=$result->execute();
		if ($test == FALSE)
		{
			$info = $connection->errorInfo();
			echo("<p>Error: {$info[2]}</p>");
			echo("<br><br>");
			echo("Study Not Created");
			exit();
		}

	$connection->commit();
	echo("<br><br>");
	echo("Study Created");

	$connection = null;

	?><br>
</body>
</html>