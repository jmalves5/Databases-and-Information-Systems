<html>
	<head>
		<meta charset="utf-8" />
	</head>
	<body>
		<?php

		$PersonID=$_POST["id"];	
		$PersonName=$_POST["name"];
		$PersonBirthday=$_POST["birthday"];
		$PersonAddress=$_POST["address"];

		echo("\nFicheiro abriu\n");

		require_once __DIR__ . '/PDO_connection.php';

		$result = $connection->prepare("Insert INTO Patient(number,name,birthday,address) values(?,?,?,?)");
		$result->bindParam(1, $PersonID, PDO::PARAM_INT);
		$result->bindParam(2, $PersonName, PDO::PARAM_STR, 30);
		$result->bindParam(3, $PersonBirthday, PDO::PARAM_STR, 30);
		$result->bindParam(4, $PersonAddress, PDO::PARAM_STR, 30);
		$result->execute();

		if ($result == FALSE)
		{
			$info = $connection->errorInfo();
			echo("<p>Error: {$info[2]}</p>");
			exit();
		}

		header('Location: patientSearchForm.html');

		
		$connection = null;


	?><br>
	</body>
</html>

