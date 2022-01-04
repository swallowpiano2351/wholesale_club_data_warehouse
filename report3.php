<html>
<head>
<title> PPDW Report 3 </title>
</head>

<body>

<h1> Report 3: Actual versus Predicted Revenue for GPS Units </h1>
<a href = "index.php"> Return to Main Menu </a>

<?php

// build connection by including external php file
include "lib/db_connect.php";

// getting data from database (Actual versus Predicted Revenue for GPS Units)
$sql_revenue_difference = "SELECT GpsOnSale.PID, GpsOnSale.product_name, GpsOnSale.retail_price,
UnitSold.unit_sold, GpsOnSale.unit_sold_at_discount, GpsOnSale.difference
FROM
(SELECT BelongTo.PID, category_name, product_name, retail_price,
sum(quantity) AS unit_sold_at_discount,
sum(retail_price*(1-discount)*quantity) - sum(retail_price*quantity*0.75) AS
difference
FROM BelongTo
INNER JOIN OnSale ON BelongTo.PID = OnSale.PID
INNER JOIN Product ON OnSale.PID = Product.PID
INNER JOIN Sold
ON Sold.PID = OnSale.PID, category_name
AND Sold.sold_date = OnSale.on_sale_date
GROUP BY BelongTo.PID
HAVING category_name = 'GPS') AS GpsOnSale
INNER JOIN
(SELECT BelongTo.PID, category_name, sum(quantity) AS unit_sold
FROM BelongTo
INNER JOIN Sold ON BelongTo.PID = Sold.PID
GROUP BY BelongTo.PID, category_name
HAVING category_name = 'GPS') AS UnitSold
ON UnitSold.PID = GpsOnSale.PID
WHERE difference > 5000 OR difference < -5000
ORDER BY difference DESC";

$result_revenue_difference = $conn -> query($sql_revenue_difference);

// display result (Actual versus Predicted Revenue for GPS Units)
if ($result_revenue_difference->num_rows > 0) {
	echo "<table>
	            <tr><th>PID</th> 
	             <th>Product_Name</th> 
				 <th>Retail_Price</th> 
				 <th>Unit_Sold</th> 
				 <th>Unit_Sold_at_Discount</th> 
				 <th>Revenue_Difference</th> 
				</tr>";
	// output data for each row
	while($row = $result_revenue_difference->fetch_assoc()){
		echo "<tr><td>".$row["PID"]. "</td>
		          <td>" .$row["product_name"]. "</td>
				  <td>". $row["retail_price"]. "</td>
				  <td>" . $row["unit_sold"]. "</td>
				  <td>" . $row["unit_sold_at_discount"] ."</td>
				  <td>" . $row["difference"]  . "</td>
		      </tr>";
	}
	echo "</table>";
	
	echo "(" .$result_revenue_difference->num_rows. "  results in total) </br>";
}

else{
	echo "</br>";
	echo "0 results";
}

// close database
$conn->close();

?>

</body>
</html>