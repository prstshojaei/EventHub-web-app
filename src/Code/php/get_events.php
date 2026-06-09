<?php
// Get events from the database and return as JSON

header('Content-Type: application/json');

// Include database connection
require 'db.php';

// Get search, category and location values from the request
$search   = isset($_GET['search']) ? $_GET['search'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';
$location = isset($_GET['location']) ? $_GET['location'] : '';

// Build query based on filters
$query = 'SELECT * FROM events WHERE 1=1';
$params = [];

// Add search filter
if ($search !== '') {
    $query .= ' AND title LIKE :search';
    $params['search'] = '%' . $search . '%';
}

// Add category filter
if ($category !== '') {
    $query .= ' AND category = :category';
    $params['category'] = $category;
}

// Add location filter
if ($location !== '') {
    $query .= ' AND location = :location';
    $params['location'] = $location;
}

$query .= ' ORDER BY date ASC';

// Run the query using prepared statement
$stmt = $pdo->prepare($query);
$stmt->execute($params);

// Return results as JSON
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($events);
?>