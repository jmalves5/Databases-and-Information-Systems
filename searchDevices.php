<html>
<head> 
	<meta charset="UTF-8">
</head>
​ ​​ ​​ ​​ ​<body>
		<?php
			if(isset($_GET['clicked'])){	    	
				$clicked = $_GET['clicked'];
			}

			require_once __DIR__ . '/PDO_connection.php';
			
			$result=$connection->prepare("SELECT Wears.snum, Wears.manuf, Wears.start, Wears.end FROM Wears, Patient WHERE Wears.patient=Patient.number AND Patient.number=? AND Wears.start<=? AND Wears.end>? ORDER BY Wears.start ASC");
			$now=date('Y-m-d H:i:s');
			$result->bindParam(1, $clicked, PDO::PARAM_INT);
			$result->bindParam(2, $now, PDO::PARAM_STR, 30);
			$result->bindParam(3, $now, PDO::PARAM_STR, 30);
			$result->execute();
			

			if($result==FALSE)
			{
				$info = $connection->errorInfo();
				echo("<p>Error: {$info[0]} {$info[1]} {$info[2]}</p>");
				exit();
			}else{
				echo("<table border=\"3\">");
				echo("<tr><td>snum</td><td>manuf</td><td>start</td><td>end</td><td>replace</td></tr>");
				foreach($result as $row)
				{
					echo("<tr><td><mark>");
					echo($row['snum']);
					echo("</mark></td><td><mark>");
					echo($row['manuf']);
					echo("</mark></td><td><mark>");
					echo($row['start']);
					echo("</mark></td><td><mark>");
					echo($row['end']);
					echo("</mark></td><td><mark>");
					echo('<a href="http://web.ist.utl.pt/'.$user.'/findDevices.php?PatientNumber='.$clicked.'&StartOld='.$row[start].'&EndOld='.$row[end].'&SnumOld='.$row[snum].'&ManufOld='.$row[manuf].'"> Replace </a>');
					echo("</mark></td></tr>");
				}
			}

			$result2=$connection->prepare("SELECT Wears.snum, Wears.manuf, Wears.start, Wears.end FROM Wears, Patient WHERE Wears.patient=Patient.number AND Patient.number=? AND NOT(Wears.start<=? AND Wears.end>?) ORDER BY Wears.start ASC");

			$result2->bindParam(1, $clicked, PDO::PARAM_INT);
			$result2->bindParam(2, $now, PDO::PARAM_STR, 30);
			$result2->bindParam(3, $now, PDO::PARAM_STR, 30);
			$result2->execute();
			
			if($result2==FALSE)
			{
				$info2 = $connection->errorInfo();
				echo("<p>Error: {$info[0]} {$info[1]} {$info[2]}</p>");
			}else{
				foreach($result2 as $row2)
				{
					echo("<tr><td>");
					echo($row2['snum']);
					echo("</td><td>");
					echo($row2['manuf']);
					echo("</td><td>");
					echo($row2['start']);
					echo("</td><td>");
					echo($row2['end']);
					echo("</td></tr>");
				}
			}
			echo("</table>");
			echo('<a href="http://web.ist.utl.pt/'.$user.'/patientSearchForm.html">Voltar ao inicio</a>');
			$connection = NULL;
		?>
​ ​​ ​​ ​​ ​</body>
</html>