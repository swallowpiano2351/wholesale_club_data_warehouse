<html>
<head>
<title> PPDW Report 4 </title>
</head>

<body>

<h1> Report 4: Store Revenue by Year by State </h1>
<a href = "index.php"> Return to Main Menu </a>

<?php

// build connection by including external php file
include "lib/db_connect.php";

// getting data from database (state names)
$sql_state_name = "SELECT DISTINCT (state_name) FROM Store ORDER BY state_name";
$result_state_name = $conn -> query($sql_state_name);

// create drop-down box(state names)

echo "<form action = '#' method = 'post'>
      Select a State: 
      <select id = 'state_option' name='state_option'>";
echo "<option value=''>-- select --</option>";

while ($row = $result_state_name->fetch_assoc()) {
    echo "<option value='" . $row['state_name'] ."'";
    if (isset($_POST['state_option']) && $_POST['state_option'] == $row['state_name']){
		echo "selected";
	}	
	echo ">" . $row['state_name'] ."</option>";
}
echo "</select>
      <input type = 'submit' name = 'submit' value = 'Submit'/> </form>";

if(isset($_POST['state_option'])){
    $selected_state = $_POST['state_option'];  // Storing Selected Value In Variable
	echo "<h2> Store Revenue by Year in  ". $selected_state . "</br> </h2>";
}


// getting data from database (revenue by year for selected state)
$sql_revenue_by_year = $conn->prepare("SELECT store.store_number, street_address, city_name, YEAR(sold_date) AS year, sum(quantity * retail_price * (1 - COALESCE (discount, 0))) AS revenue
FROM Store
INNER JOIN Sold ON Store.store_number = Sold.store_number
INNER JOIN Product ON Sold.PID = Product.PID
LEFT JOIN OnSale
ON Sold.PID = OnSale.PID AND Sold.sold_date = OnSale.on_sale_date
WHERE state_name = ?
GROUP BY store_number, YEAR(sold_date)
ORDER BY year ASC, revenue DESC");

$sql_revenue_by_year->bind_param("s", $selected_state);
$sql_revenue_by_year->execute();
$result_revenue_by_year = $sql_revenue_by_year->get_result();

// display result (revenue by year by state)
if ($result_revenue_by_year->num_rows > 0) {
	echo "<table>
	        <tr>
			  <th>Store_Number</th> 
			  <th>Address</th> 
			  <th>City</th> 
			  <th>Year</th> 
			  <th>Revenue</th> 
			</tr>";
	// output data for each row
	while($row = $result_revenue_by_year->fetch_assoc()){
		echo "<tr><td>".$row["store_number"]. "</td><td>" .$row["street_address"]. "</td><td>". $row["city_name"]. "</td><td>" . $row["year"]. "</td><td>" . $row["revenue"]  . "</td></tr>";
	}
	echo "</table>";
	
	echo "(" .$result_revenue_by_year->num_rows. "  results in total) </br>";
}

// close database
$conn->close();

?>

</body>
</html>