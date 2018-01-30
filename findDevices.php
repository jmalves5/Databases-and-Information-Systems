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
		 	$PatientNumber = $_GET['PatientNumber'];
		 	$StartOld = $_GET["StartOld"];
		 	$EndOld = $_GET["EndOld"];
			$SnumOld = $_GET["SnumOld"];
			$ManufOld = $_GET["ManufOld"];

			$_SESSION["EndOld"] = $EndOld;
		 	$_SESSION["StartOld"] = $StartOld;
		 	$_SESSION["PatientNumber"] = $PatientNumber;
		 	$_SESSION["SnumOld"] = $SnumOld;
		 	$_SESSION["ManufOld"] = $ManufOld;
		 	$now=date('Y-m-d H:i:s');

			require_once __DIR__ . '/PDO_connection.php';
			
			$query= "SELECT * from Device where not exists (Select *  from Wears where Wears.manuf=Device.manufacturer AND Wears.snum=Device.serialnum AND Wears.start<'$now' AND Wears.end>'$now') AND Device.manufacturer='$ManufOld' ";

			$result = $connection->query($query);
			if($result==FALSE)
			{
				$info = $connection->errorInfo();
				echo("<p>Error: {$info[0]} {$info[1]} {$info[2]}</p>");
				exit();
			}else{
				echo("<table border=\"3\">");
				echo("<tr><td>serialnum</td><td>manufacturer</td><td>Model</td></tr>");
				foreach($result as $row)
				{
					echo("<tr><td>");
					echo($row['serialnum']);
					echo("</td><td>");
					echo($row['manufacturer']);
					echo("</td><td>");
					echo($row['model']);
					echo("</td><td>");
					echo('<a href="http://web.ist.utl.pt/'.$user.'/replaceDevices.php?&SnumNew='.$row['serialnum'].'&ManufNew='.$row['manufacturer'].'"> Replace </a>');
					echo("</td></tr>");
				}
				echo("</table>");
			}
			$connection = NULL;
		?>
​ ​​ ​​ ​​ ​</body>
</html>