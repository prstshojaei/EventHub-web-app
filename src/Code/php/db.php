<?php
// Database settings
$server   = 'db';
$username = 'root';
$password = 'csym019';
$schema   = 'Internet_programming';

// Connect to the database using PDO
try {
    // PDO connection - Reference: PHP Group (2024) https://www.php.net/manual/en/book.pdo.php
    $pdo = new PDO(
        'mysql:dbname=' . $schema . ';host=' . $server,
        $username,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    // Show error if connection fails
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $e->getMessage()]));
}
?>