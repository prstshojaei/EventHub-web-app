<?php
session_start();

// Only logged in admins can delete events
if (!isset($_SESSION['admin'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

header('Content-Type: application/json');
require 'db.php';

// Get the event ID from the request
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

// Make sure the ID is valid
if ($id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid event ID']);
    exit;
}

// Delete the event from the database
$stmt = $pdo->prepare('DELETE FROM events WHERE id = :id LIMIT 1');
$stmt->execute(['id' => $id]);

echo json_encode(['success' => true]);
?>