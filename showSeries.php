<html>
<head> 
	<meta charset="UTF-8">
</head>
​ ​​ ​​ ​​ ​<body>
		<?php
			require_once __DIR__ . '/PDO_connection.php';

			$query= "SELECT * from Series";

			$result = $connection->query($query);

			if($result==FALSE)
			{
				$info = $connection->errorInfo();
				echo("<p>Error: {$info[0]} {$info[1]} {$info[2]}</p>");
				exit();
			}else{
				echo("<table border=\"3\">");
				echo("<tr><td>series_id</td><td>name</td><td>base_url</td><td>request_number</td><td>description</td></tr>");
				foreach($result as $row)
				{
					echo("<tr><td>");
					echo('<a href="http://web.ist.utl.pt/'.$user.'/showElements.php?series_id='.$row[series_id].'">'.$row[series_id].'</a>');
					echo("</td><td>");
					echo($row['name']);
					echo("</td><td>");
					echo($row['base_url']);
					echo("</td><td>");
					echo($row['request_number']);
					echo("</td><td>");
					echo($row['description']);
					echo("</td></tr>");
				}
			}
			echo("</table>");
			$connection = NULL;
		?>
​ ​​ ​​ ​​ ​</body>
</html>