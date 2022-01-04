<html>
<head>
<title> PPDW Report 8 </title>
</head>

<body>

<h1> Report 8: Membership Trends </h1>
<a href = "index.php"> Return to Main Menu </a>

<?php

// build connection by including external php file
include "lib/db_connect.php";

// getting data from database (membership sold by year)
echo "<h4> Total Memberships Sold by Year: </h4>";

$sql_membership_sold = "SELECT YEAR(Membership.signup_date) AS mem_year, COUNT(Membership.memberID) AS totalMembership
FROM Membership
GROUP BY YEAR(Membership.signup_date)
ORDER BY YEAR(Membership.signup_date) DESC";
$result_membership_sold = $conn -> query($sql_membership_sold);

// display result (membership sold by year)
if ($result_membership_sold->num_rows > 0) {
	echo "<table><tr><th>Year</th> <th>Membership_Sold</th> <th>Details</th> </tr>";
	// output data for each row
	while($row = $result_membership_sold->fetch_assoc()){
		$link_address = "report8_2.php?year=" .$row["mem_year"];
		echo "<tr><td>".$row["mem_year"]. "</td>
		          <td>" .$row["totalMembership"]. "</td> 
				  <td> <td> <a href='" .$link_address. "'> View Top/Bottom 25 Cities </a> </td></td>
			  </tr>";
	}
	echo "</table>";
	
	echo "(" .$result_membership_sold->num_rows. "  results in total) </br>";
}


// close database
$conn->close();


// abandoned code for creating button with link and variable
//<td> <form action = 'report8_2.php'> <input type = 'submit' name = 'year' value = '". $row["mem_year"] ."'> </form> </td>

?>

</body>
</html>