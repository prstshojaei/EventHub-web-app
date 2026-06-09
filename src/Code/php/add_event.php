<?php
session_start();
header('Content-Type: application/json');
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title       = isset($_POST['title']) ? trim($_POST['title']) : '';
    $date        = isset($_POST['date']) ? trim($_POST['date']) : '';
    $time        = isset($_POST['time']) ? trim($_POST['time']) : '09:00';
    $location    = isset($_POST['location']) ? trim($_POST['location']) : '';
    $category    = isset($_POST['category']) ? trim($_POST['category']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';

    // Make sure all fields are filled in
    if (empty($title) || empty($date) || empty($location) || empty($category) || empty($description)) {
        echo json_encode(array('success' => false, 'message' => 'All fields are required'));
        exit;
    }

    // Save the event to the database using prepared statement
    $stmt = $pdo->prepare('INSERT INTO events (title, date, time, location, category, description) 
                           VALUES (:title, :date, :time, :location, :category, :description)');
    $stmt->execute(array(
        'title'       => $title,
        'date'        => $date,
        'time'        => $time,
        'location'    => $location,
        'category'    => $category,
        'description' => $description
    ));

    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('success' => false, 'message' => 'Invalid request'));
}
?>