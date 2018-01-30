<?php
// Start the session
session_start();
?>
<html>
<head> 
	<meta charset="UTF-8">
</head>
​ ​​ ​​ ​​ ​<body>
		<?php
			$startold =$_SESSION["StartOld"];
			$endold =$_SESSION["EndOld"];
			$PatientNumber =$_SESSION["PatientNumber"];
			$SnumNew = $_GET['SnumNew'];
			$ManufNew = $_GET['ManufNew'];
			$SnumOld = $_SESSION["SnumOld"];
		 	$ManufOld = $_SESSION["ManufOld"];
			

			echo("<br>");
			
			require_once __DIR__ . '/PDO_connection.php';

			$now=date('Y-m-d H:i:s');
			$result=$connection->prepare("INSERT INTO Period values(?, '2020-01-13 10:50:23')");
			$result->bindParam(1, $now, PDO::PARAM_STR, 30);
			$result->execute();
			echo("Inserted in period");

			if($result==FALSE)
			{
				$info = $connection->errorInfo();
			 	echo("<p>Error: {$info[0]} {$info[1]} {$info[2]}</p>");
			 	exit();
			}else{
			 	echo("Inserted in period");
			}
			
			$result2=$connection->prepare("DELETE FROM Wears WHERE (Wears.start=? AND Wears.end=? AND Wears.patient=?)");
			$result2->bindParam(1, $startold, PDO::PARAM_STR, 30);
			$result2->bindParam(2, $endold, PDO::PARAM_STR, 30);
			$result2->bindParam(3, $PatientNumber, PDO::PARAM_INT);
			$result2->execute();


			if($result2==FALSE)
			{
				$info = $connection->errorInfo();
			 	echo("<p>Error: {$info[0]} {$info[1]} {$info[2]}</p>");
			 	exit();
			}else{
			 	echo("Deleted old");
			}


			$result3=$connection->prepare("INSERT INTO Wears (`start`, `end`, `patient`, `snum`, `manuf`) values(?, '2020-01-13 10:50:23', ?, ?, ?)");
			$result3->bindParam(1, $now, PDO::PARAM_STR, 30);
			$result3->bindParam(2, $PatientNumber, PDO::PARAM_INT);
			$result3->bindParam(3, $SnumNew, PDO::PARAM_INT);
			$result3->bindParam(4, $ManufNew, PDO::PARAM_STR, 30);
			$result3->execute();

			if($result3==FALSE)
			{
				$info = $connection->errorInfo();
			 	echo("<p>Error: {$info[0]} {$info[1]} {$info[2]}</p>");
			 	exit();
			}else{
			 	echo("Inserted in table new");
			}

			$query4="INSERT INTO Period values('$startold', '$now')";
			$result4 = $connection->query($query4);
			if($result4==FALSE)
			{
				$info = $connection->errorInfo();
			 	echo("<p>Error: {$info[0]} {$info[1]} {$info[2]}</p>");
			 	exit();
			}else{
			 	echo("Inserted in table period oldstart new end");
			}
			
			
			$query5="INSERT INTO Wears (`start`, `end`, `patient`, `snum`, `manuf`) values ('$startold', '$now', $PatientNumber, $SnumOld, '$ManufOld')";
			$result5 = $connection->query($query5);
			if($result5==FALSE)
			{
				$info = $connection->errorInfo();
			 	echo("<p>Error: {$info[0]} {$info[1]} {$info[2]}</p>");
			 	exit();
			}else{
			 	echo("Inserted in table old");
			}
			
			$connection = NULL;
			header("Location: searchDevices.php?clicked=".$PatientNumber);
		?>
​ ​​ ​​ ​​ ​</body>
</html>