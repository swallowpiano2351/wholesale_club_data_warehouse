<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {box-sizing: border-box}
body {font-family: "Lato", sans-serif;}
/* Style the tab */
.tab {
  float: left;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
  width: 28%;
  height: 100%;
  min-height: 950px;
}
/* Style the buttons inside the tab */
.tab button {
  display: block;
  background-color: inherit;
  color: black;
  padding: 22px 16px;
  width: 100%;
  border: none;
  outline: none;
  text-align: left;
  cursor: pointer;
  transition: 0.3s;
  font-size: 15px;
  font-weight: bold;
}
/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}
/* Create an active/current "tab button" class */
.tab button.active {
  background-color: #ccc;
}
/* Style the tab content */
.tabcontent {
  float: left;
  padding: 0px 12px;
  border: 1px solid #ccc;
  width: 72%;
  border-left: none;
  height: 100%;
  min-height: 950px
}
</style>
</head>

<body  style= "background-color: #F5F5F5">
<div style = "background-color:#B3A369; color:black;">
	<h1 style="text-align: center; padding: 50px; box-shadow: 5px 5px 3px grey;">Welcome to PricePalace Data Warehouse!</h1>
</div>

<div style = "padding-left: 60px; padding-right: 60px; box-shadow: 15px 15px 10px grey;">
<div class="tab">
	<form action="index.php" method="get">
	  <button type="submit" style = "background-color: #ddd">Main Menu / View Statistics</button>
	</form>
	<form action="edit_population.php" method="get">
	  <button type="submit">View and Edit Population</button>
	</form>
	<form action="add_holiday.php" method="get">
	  <button type="submit">View and Add Holiday</button>
	</form>
	<form action="report1.php" method="get">
	  <button type="submit">Report1: Manufacturer's Product Report</button>
	</form>
	<form action="report2.php" method="get">
	  <button type="submit">Report2: Category Report</button>
	</form>
	<form action="report3.php" method="get">
	  <button type="submit">Report3: Actural Versus Predicted Revenue for GPS Units</button>
	</form>
	<form action="report4.php" method="get">
	  <button type="submit">Report4: Store Revenue by Year by State</button>
	</form>
	<form action="report5.php" method="get">
	  <button type="submit">Report5: Air Conditioners Sales on Groundhog Day</button>
	</form>
	<form action="report6.php" method="get">
	  <button type="submit">Report6: State with Highest Volume for Each Category</button>
	</form>
	<form action="report7.php" method="get">
	  <button type="submit">Report7: Revenue by Population</button>
	</form>
	<form action="report8.php" method="get">
	  <button type="submit">Report8: Membership Trend</button>
	</form>
</div>

<div class="tabcontent">
	<div style = "padding:10px; font-size: 20px;">
	<h2> Show Statistics </h2>
	<br>
	<?php
	// build connection by including external php file
	include "lib/db_connect.php";
	// show statistic
	include "show_statistic.php";
	// close database
	$conn->close();
	?>
	</div>
</div>

</div>
</body>

</html>