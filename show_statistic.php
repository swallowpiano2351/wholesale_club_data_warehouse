<?php

// getting data from database (store_count)
$sql_store_count = "SELECT COUNT(store_number) FROM Store";
$result_store_count = $conn -> query($sql_store_count);

// display result (store_count)
if ($result_store_count->num_rows > 0) {
	// output data for each row
	while($row = $result_store_count->fetch_assoc()){
		echo "Store Count: " . $row["COUNT(store_number)"]. "<br>";
	}
}
else{
	echo "0 results";
}

?>