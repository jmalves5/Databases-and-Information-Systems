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
			$series_id=$_SESSION["series_id"];
			$elem_index=$_SESSION["elem_index"];

			$x1=$_POST["x1"];
			$y1=$_POST["y1"];
			$x2=$_POST["x2"];
			$y2=$_POST["y2"];
			
			require_once __DIR__ . '/PDO_connection.php';
			$result=$connection->prepare("SELECT region_overlaps_element($series_id, $elem_index, ?, ?, ?, ?) AS var_exists");
			$result->bindParam(1, $x1, PDO::PARAM_INT);
			$result->bindParam(2, $y1, PDO::PARAM_INT);
			$result->bindParam(3, $x2, PDO::PARAM_INT);
			$result->bindParam(4, $y2, PDO::PARAM_INT);
			$result->execute();

			$result2=$connection->prepare("INSERT into Region VALUES ($series_id, $elem_index, ?, ?, ?, ?)");
			$result2->bindParam(1, $x1, PDO::PARAM_INT);
			$result2->bindParam(2, $y1, PDO::PARAM_INT);
			$result2->bindParam(3, $x2, PDO::PARAM_INT);
			$result2->bindParam(4, $y2, PDO::PARAM_INT);
			$result2->execute();
			
			if($result2==FALSE)
			{
				$info = $connection->errorInfo();
				echo("<p>Error1: {$info[0]} {$info[1]} {$info[2]}</p>");
			}else{
				if($result==FALSE)
				{
					$info = $connection->errorInfo();
					echo("<p>Error2: {$info[0]} {$info[1]} {$info[2]}</p>");
				}else{	
					foreach ($result as $row){
						if ($row['var_exists']==0) {
							echo("<p>New Clinical evidence added!</p>");
						}elseif($row['var_exists']==1){
							echo("<p>Region added although it intersects with prior added Regions!</p>");
						}
					}
				}
			}
			
			echo('<a href="http://web.ist.utl.pt/'.$user.'/showRegion.php?series_id='.$series_id.'&elem_index='.$elem_index.'">Go back to Regions</a>');
		
			$connection = NULL;
		?>
​ ​​ ​​ ​​ ​</body>
</html>