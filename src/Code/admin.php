<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header('Location: php/login.php');
    exit;
}

require 'php/db.php';

// Get all events
$stmt = $pdo->query('SELECT * FROM events ORDER BY date ASC');
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get stats for dashboard
$totalEvents = count($events);
$categoryCounts = [];
foreach ($events as $event) {
    $cat = $event['category'];
    $categoryCounts[$cat] = isset($categoryCounts[$cat]) ? $categoryCounts[$cat] + 1 : 1;
}
$iotCount   = isset($categoryCounts['IoT']) ? $categoryCounts['IoT'] : 0;
$aiCount    = isset($categoryCounts['AI']) ? $categoryCounts['AI'] : 0;
$cyberCount = isset($categoryCounts['Cybersecurity']) ? $categoryCounts['Cybersecurity'] : 0;
$webCount   = isset($categoryCounts['Web Development']) ? $categoryCounts['Web Development'] : 0;
$dataCount  = isset($categoryCounts['Data Science']) ? $categoryCounts['Data Science'] : 0;
$cloudCount = isset($categoryCounts['Cloud']) ? $categoryCounts['Cloud'] : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>EventHub - Admin</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
</head>
<body>

    <header>
        <h1>Event<span>Hub</span> Admin</h1>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['admin']); ?></p>
    </header>

    <nav>
        <ul>
            <li><a href="index.php">Public Site</a></li>
            <li><a href="admin.php">Dashboard</a></li>
            <li><a href="php/logout.php">Logout</a></li>
        </ul>
    </nav>

    <main>

        <h2>Dashboard</h2>
        <div class="dashboard-stats">
            <div class="stat-box">
                <h3><?php echo $totalEvents; ?></h3>
                <p>Total Events</p>
            </div>
            <div class="stat-box stat-iot">
                <h3><?php echo $iotCount; ?></h3>
                <p>IoT</p>
            </div>
            <div class="stat-box stat-ai">
                <h3><?php echo $aiCount; ?></h3>
                <p>AI</p>
            </div>
            <div class="stat-box stat-cyber">
                <h3><?php echo $cyberCount; ?></h3>
                <p>Cybersecurity</p>
            </div>
            <div class="stat-box">
                <h3><?php echo $webCount; ?></h3>
                <p>Web Dev</p>
            </div>
            <div class="stat-box">
                <h3><?php echo $dataCount; ?></h3>
                <p>Data Science</p>
            </div>
            <div class="stat-box">
                <h3><?php echo $cloudCount; ?></h3>
                <p>Cloud</p>
            </div>
        </div>

        <h2>Add New Event</h2>

        <p id="success-message" style="display:none;"></p>
        <p id="error-message" style="display:none;"></p>

        <form id="event-form">
            <label for="title">Event Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="date">Event Date:</label>
            <input type="date" id="date" name="date" required>

            <label for="time">Event Time:</label>
            <input type="time" id="time" name="time" required>

            <label for="location">Event Location:</label>
            <input type="text" id="location" name="location" required>

            <label for="category">Event Category:</label>
            <select id="category" name="category" required>
                <option value="IoT">IoT</option>
                <option value="AI">AI</option>
                <option value="Cybersecurity">Cybersecurity</option>
                <option value="Web Development">Web Development</option>
                <option value="Data Science">Data Science</option>
                <option value="Cloud">Cloud</option>
            </select>

            <label for="description">Event Description:</label>
            <textarea id="description" name="description" rows="4" required></textarea>

            <input type="submit" value="Add Event">
        </form>

        <h2>Current Events</h2>

        <div id="events-list">
            <?php foreach ($events as $event): ?>
                <div class="event">
                    <h3><?php echo htmlspecialchars($event['title']); ?></h3>
                    <p><strong>Date:</strong> <?php echo date('F j, Y', strtotime($event['date'])); ?></p>
                    <p><strong>Time:</strong> <?php echo date('g:i A', strtotime($event['time'])); ?></p>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($event['location']); ?></p>
                    <span class="badge badge-<?php echo strtolower(str_replace(' ', '-', htmlspecialchars($event['category']))); ?>">
                        <?php echo htmlspecialchars($event['category']); ?>
                    </span>
                    <p><?php echo htmlspecialchars($event['description']); ?></p>
                    <div class="event-actions">
                        <a href="php/edit_event.php?id=<?php echo $event['id']; ?>" class="btn-edit">Edit</a>
                        <button class="btn-delete" data-id="<?php echo $event['id']; ?>">Delete</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </main>

    <aside>
        <h2>Admin Notes</h2>
        <ul>
            <li>Add new events using the form</li>
            <li>Edit or delete existing events</li>
            <li>Changes appear on the public site immediately</li>
        </ul>

        <h2>Quick Stats</h2>
        <p>Total events: <strong><?php echo $totalEvents; ?></strong></p>
        <p>Categories: <strong>6</strong></p>
    </aside>

    <footer>
        <p>&copy; 2026 EventHub</p>
        <p class="creator">Created by: Parastoo Shojaei</p>
    </footer>

    <button id="back-to-top" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">↑</button>

</body>
</html>