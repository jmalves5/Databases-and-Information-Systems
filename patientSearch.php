<html>
<head> 
	<meta charset="UTF-8">
</head>
	<body>
		<?php

		$PersonName=$_POST["name"];
		$pname="%".$PersonName."%";
		require_once __DIR__ . '/PDO_connection.php';

		$result = $connection->prepare("SELECT * FROM Patient where Patient.name like ?");
		$result->bindParam(1, $pname, PDO::PARAM_STR, 30);
		$result->execute();
		
		if ($result == FALSE)
		{
			$info = $connection->errorInfo();
			echo("<p>Error: {$info[2]}</p>");
			exit();
		}
		
		$nrows = $result->rowCount();

		if($nrows == 0){
			$connection = null;
			
			header('Location: patientInsert.html');
		}

		else{
			echo("<table border=\"1\">");
			echo("<tr><td>number</td><td>name</td><td>birthday</td><td>address</td></tr>");

			foreach($result as $row)
			{
				echo("<tr><td>");
				echo($row['number']);
				echo("</td><td>");
				echo('<a href="http://web.ist.utl.pt/'.$user.'/searchDevices.php?clicked='.$row[number].'">'.$row['name'].'</a>');
				echo("</td><td>");
				echo($row['birthday']);
				echo("</td><td>");
				echo($row['address']);
				echo("</td>");
			}
			echo("</table>");
		
		}
		
		$connection = null;


	?><br>
	</body>
</html>