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
			if(isset($_GET['series_id'])){	    	
					$series_id = $_GET['series_id'];
				}
			if(isset($_GET['elem_index'])){	    	
					$elem_index = $_GET['elem_index'];
				}

			$_SESSION["series_id"] = $series_id;
			$_SESSION["elem_index"] = $elem_index;


			require_once __DIR__ . '/PDO_connection.php';

			$query= "SELECT * from Region WHERE Region.series_id='$series_id' AND Region.elem_index='$elem_index'";

			$result = $connection->query($query);

			if($result==FALSE)
			{
				$info = $connection->errorInfo();
				echo("<p>Error: {$info[0]} {$info[1]} {$info[2]}</p>");
				exit();
			}else{
				echo("Regions:");
				echo("<table border=\"3\">");
				echo("<tr><td>series_id</td><td>elem_index</td><td>x1</td><td>y1</td><td>x2</td><td>y2</td></tr>");
				foreach($result as $row)
				{
					echo("<tr><td>");
					echo($row['series_id']);
					echo("</td><td>");
					echo($row['elem_index']);
					echo("</td><td>");
					echo($row['x1']);
					echo("</td><td>");
					echo($row['y1']);
					echo("</td><td>");
					echo($row['x2']);
					echo("</td><td>");
					echo($row['y2']);
					echo("</td></tr>");
				}
			}
			echo("</table>");
			
			echo("If you want to add a Region, please fill the boxes below and click 'Add'");
			
			echo "<form action='addRegion.php' method='post'>";
			echo "x1: <input type='text' name='x1'>";
			echo "y1: <input type='text' name='y1'>";
			echo "x2: <input type='text' name='x2'>";
			echo "y2: <input type='text' name='y2'>";
			echo "<input type='submit'>";
			$connection = NULL;
		?>
​ ​​ ​​ ​​ ​</body>
</html>