<html>
<head>
<title> PPDW Report 8-3 </title>
</head>

<body>

<h1> Report 8: Membership Trends </h1>

<?php
$year = $_GET["year"];
?>

<h2> Memberships Sold at Store Level in <?php echo $year; ?></h2>

<a href = "report8_2.php?year=<?php echo $year ?>"> Return to Report 8-2 - View Top/Bottom 25 Cities </br></a>
<a href = "report8.php"> Return to Report 8 - Membership Trends by Year </br></a>
<a href = "index.php"> Return to Main Menu </a>
<h></br></h>

<?php

// build connection by including external php file
include "lib/db_connect.php";

// get keywords from hyperlink
$city = $_GET["city"];
$state = $_GET["state"];

// getting data from database (Actual versus Predicted Revenue for GPS Units)
$sql_membership_store = $conn->prepare("SELECT A.store_number, A.street_address, A.memberCount, A.city_name, A.state_name
FROM
(SELECT Store.store_number, Store.street_address, Store.city_name, Store.state_name, COUNT(Membership.memberID) AS memberCount
FROM Membership
INNER JOIN Store ON Membership.store_number = Store.store_number
WHERE YEAR(Membership.signup_date) = ?
AND Store.city_name = ?
AND Store.state_name = ?
GROUP BY Store.store_number) AS A
CROSS JOIN
(SELECT COUNT(*) as storeCountByCity
FROM Store
WHERE Store.city_name = ? AND Store.state_name = ?) AS B
WHERE storeCountByCity > 1
ORDER BY A.store_number ASC");

$sql_membership_store->bind_param("sssss", $year, $city, $state, $city, $state);
$sql_membership_store->execute();
$result_membership_store = $sql_membership_store->get_result();


// display result (Actual versus Predicted Revenue for GPS Units)
if ($result_membership_store->num_rows > 0) {
	echo "<table>
	            <tr><th>store_number</th> 
	             <th>address</th> 
				 <th>city</th> 
				 <th>state</th>
                 <th>membership_sold</th> 				 
				</tr>";
	// output data for each row
	while($row = $result_membership_store->fetch_assoc()){
		echo "<tr><td>".$row["store_number"]. "</td>
		          <td>" .$row["street_address"]. "</td>
				  <td>" . $row["city_name"]. "</td>
				  <td>" . $row["state_name"] ."</td>
				  <td>". $row["memberCount"]. "</td>
		      </tr>";
	}
	echo "</table>";
	
	echo "(" .$result_membership_store->num_rows. "  results in total) </br>";
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