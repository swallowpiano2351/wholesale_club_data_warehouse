<html>
<head>
<title> PPDW Report 8-2 </title>
</head>

<body>

<h1> Report 8: Membership Trends </h1>
<h2> View Top/Bottom 25 Cities </h2>
<a href = "report8.php"> Return to Report 8 - Membership Trends by Year </br></a>
<a href = "index.php"> Return to Main Menu </a>

<?php

// build connection by including external php file
include "lib/db_connect.php";

// get year from click action in the parent report
$selected_year = $_GET["year"];

// getting data from database (top 25 cities for selected year)
$sql_top_cities = $conn->prepare("SELECT topMember.city_name as top25_city, topMember.state_name as top25_state, topMember.membership_sold
FROM 
(SELECT COUNT(memberID) AS memberCount, city_name, state_name, COUNT(*) as membership_sold
FROM Membership
INNER JOIN Store ON Membership.store_number = Store.store_number
WHERE YEAR(Membership.signup_date) = ?
GROUP BY city_name, state_name
ORDER BY memberCount DESC LIMIT 25) AS topMember");

$sql_top_cities->bind_param("s", $selected_year);
$sql_top_cities->execute();
$result_top_cities = $sql_top_cities->get_result();

// get color highlight
function get_color($count){
	if ($count >= 250){
		return "red";
	}
	
	if ($count <= 30){
		return "yellow";
	}
}

// get store number in a city
function get_store_count($conn, $city, $state){
    $sql_store_count = $conn->prepare("SELECT COUNT(*) as count FROM Store WHERE Store.city_name = ? AND Store.state_name = ?");
    $sql_store_count->bind_param("ss", $city, $state);
    $sql_store_count->execute();
    $result_store_count = $sql_store_count->get_result();
    $row = $result_store_count->fetch_assoc();
	return $row["count"];

}

// display result (top 25 cities for selected year)
echo "<h3> Top 25 cities that sold the most memberships in  " .$selected_year. " </h3>";
if ($result_top_cities->num_rows > 0) {
	echo "<table>
	        <tr>
			  <th>City</th> 
			  <th>State</th>
              <th>Membership_Sold</th>
              <th>Details</th> 				  
			</tr>";
	// output data for each row
	while($row = $result_top_cities->fetch_assoc()){
		$link_address = "report8_3.php?year=" .$selected_year. "&city=" .$row["top25_city"]. "&state=" .$row["top25_state"];
		echo "<tr><td>".$row["top25_city"]. "</td>
		          <td>" .$row["top25_state"]. "</td>
		          <td style='background-color:" .get_color($row["membership_sold"]). "'>" .$row["membership_sold"]."</td>";
				  if (get_store_count($conn, $row["top25_city"], $row["top25_state"]) > 1){ 
				  echo "<td> <a href='" .$link_address. "'> View Stores </a> </td>";
				  }
				  else{
					  echo "<td> </td>";
				  }
			 echo "</tr>";
	}
	echo "</table>";
}


// getting data from database (bottom 25 cities for selected year)
$sql_bottom_cities = $conn->prepare("SELECT bottomMember.city_name as bottom25_city, bottomMember.state_name as bottom25_state , bottomMember.membership_sold
FROM 
(SELECT COUNT(memberID) AS memberCount, city_name, state_name, COUNT(*) as membership_sold
FROM Membership
INNER JOIN Store ON Membership.store_number = Store.store_number
WHERE YEAR(Membership.signup_date) = ?
GROUP BY city_name, state_name
ORDER BY memberCount ASC LIMIT 25) AS bottomMember");

$sql_bottom_cities->bind_param("s", $selected_year);
$sql_bottom_cities->execute();
$result_bottom_cities = $sql_bottom_cities->get_result();

// display result (bottom 25 cities for selected year)
echo "<h3> Bottom 25 cities that sold the least memberships in  " .$selected_year. " </h3>";
if ($result_bottom_cities->num_rows > 0) {
	echo "<table>
	        <tr>
			  <th>City</th> 
			  <th>State</th>
              <th>Membership_Sold</th>
              <th>Details</th>  			  
			</tr>";
	// output data for each row
	while($row = $result_bottom_cities->fetch_assoc()){
		$link_address = "report8_3.php?year=" .$selected_year. "&city=" .$row["bottom25_city"]. "&state=" .$row["bottom25_state"];
		echo "<tr><td>".$row["bottom25_city"]. "</td>
		          <td>" .$row["bottom25_state"]. "</td>
		          <td style='background-color:" .get_color($row["membership_sold"]). "'>" .$row["membership_sold"]. "</td>
				  <td> <a href='" .$link_address. "'> View Stores </a> </td>
			</tr>";
	}
	echo "</table>";
}


// close database
$conn->close();

?>

</body>
</html>