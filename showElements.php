<html>
<head> 
	<meta charset="UTF-8">
</head>
​ ​​ ​​ ​​ ​<body>
		<?php
			if(isset($_GET['series_id'])){	    	
				$series_id = $_GET['series_id'];
			}
			require_once __DIR__ . '/PDO_connection.php';

			$query= "SELECT * from Element WHERE Element.series_id='$series_id'";

			$result = $connection->query($query);

			if($result==FALSE)
			{
				$info = $connection->errorInfo();
				echo("<p>Error: {$info[0]} {$info[1]} {$info[2]}</p>");
				exit();
			}else{
				echo("<table border=\"3\">");
				echo("<tr><td>series_id</td><td>elem_index</td></tr>");
				foreach($result as $row)
				{
					echo("<tr><td>");
					echo($row['series_id']);
					echo("</td><td>");
					echo('<a href="http://web.ist.utl.pt/'.$user.'/showRegion.php?series_id='.$series_id.'&elem_index='.$row[elem_index].'">'.$row[elem_index].'</a>');
					echo("</td></tr>");
				}
			}
			echo("</table>");
			$connection = NULL;
		?>
​ ​​ ​​ ​​ ​</body>
</html>