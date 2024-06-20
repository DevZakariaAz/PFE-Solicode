<?php
/*
header('Content-Type: application/json');

include "connection.php";

// Get the search query from the URL
$query = isset($_GET['q']) ? $conn->real_escape_string($_GET['q']) : '';

// Prepare the SQL statement to prevent SQL injection
$stmt = $conn->prepare("SELECT title FROM destinations WHERE title LIKE ?");
$searchTerm = "%$query%";
$stmt->bind_param('s', $searchTerm);

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

// Fetch results as an associative array
$destinations = [];
while ($row = $result->fetch_assoc()) {
    $destinations[] = $row;
}

// Output the results as JSON
echo json_encode($destinations);

// Close connections
$stmt->close();
$conn->close();*/
?>
