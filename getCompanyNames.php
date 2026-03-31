<?php
require_once('Model/DBconnect.php');

// Perform a query to retrieve company names from the database
$query = "SELECT DISTINCT company_name FROM naitei";
$result = mysqli_query($conn, $query);

// Fetch the results into an array
$companyNames = [];
while ($row = mysqli_fetch_assoc($result)) {
  $companyNames[] = $row['company_name'];
}

// Return the company names as a JSON response
echo json_encode($companyNames);
