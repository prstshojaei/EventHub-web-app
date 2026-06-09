<?php
session_start();

// Only logged in admins can edit events
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

require 'db.php';

// Get the event ID from the URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// If form was submitted, update the event
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id          = (int)$_POST['id'];
    $title       = $_POST['title'];
    $date        = $_POST['date'];
    $time        = $_POST['time'];
    $location    = $_POST['location'];
    $category    = $_POST['category'];
    $description = $_POST['description'];

    // Make sure all fields are filled in
    if (empty($title) || empty($date) || empty($location) || empty($category) || empty($description)) {
        $error = 'All fields are required';
    } else {
        // Update the event in the database
        $stmt = $pdo->prepare('UPDATE events SET title = :title, date = :date, time = :time,
                               location = :location, category = :category, description = :description 
                               WHERE id = :id');
        $stmt->execute([
            'title'       => $title,
            'date'        => $date,
            'time'        => $time,
            'location'    => $location,
            'category'    => $category,
            'description' => $description,
            'id'          => $id
        ]);

        // Go back to admin panel after saving
        header('Location: ../admin.php');
        exit;
    }
}

// Get the event details to fill the form
$stmt = $pdo->prepare('SELECT * FROM events WHERE id = :id');
$stmt->execute(['id' => $id]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

// If event not found go back to admin
if (!$event) {
    header('Location: ../admin.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Event - EventHub</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">
</head>
<body>

    <header>
        <h1>Event<span>Hub</span> Admin</h1>
        <p>Edit Event</p>
    </header>

    <nav>
        <ul>
            <li><a href="../index.php">Public Site</a></li>
            <li><a href="../admin.php">Dashboard</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <main>
        <h2>Edit Event</h2>

        <?php if (isset($error)): ?>
            <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $event['id']; ?>">

            <label for="title">Event Title:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($event['title']); ?>" required>

            <label for="date">Event Date:</label>
            <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($event['date']); ?>" required>

            <label for="time">Event Time:</label>
            <input type="time" id="time" name="time" value="<?php echo htmlspecialchars($event['time']); ?>" required>

            <label for="location">Event Location:</label>
            <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($event['location']); ?>" required>

            <label for="category">Event Category:</label>
            <select id="category" name="category" required>
                <option value="IoT" <?php echo $event['category'] === 'IoT' ? 'selected' : ''; ?>>IoT</option>
                <option value="AI" <?php echo $event['category'] === 'AI' ? 'selected' : ''; ?>>AI</option>
                <option value="Cybersecurity" <?php echo $event['category'] === 'Cybersecurity' ? 'selected' : ''; ?>>Cybersecurity</option>
                <option value="Web Development" <?php echo $event['category'] === 'Web Development' ? 'selected' : ''; ?>>Web Development</option>
                <option value="Data Science" <?php echo $event['category'] === 'Data Science' ? 'selected' : ''; ?>>Data Science</option>
                <option value="Cloud" <?php echo $event['category'] === 'Cloud' ? 'selected' : ''; ?>>Cloud</option>
            </select>

            <label for="description">Event Description:</label>
            <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($event['description']); ?></textarea>

            <input type="submit" value="Save Changes">
            <a href="../admin.php" class="btn-cancel">Cancel</a>
        </form>
    </main>

    <footer>
        <p>&copy; 2026 EventHub</p>
    </footer>

</body>
</html>