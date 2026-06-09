<?php
// Connect to the database
require 'php/db.php';

// Get all events from the database
$stmt = $pdo->query('SELECT * FROM events ORDER BY date ASC');
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Count events per category for aside
$categoryCounts = [];
foreach ($events as $event) {
    $cat = $event['category'];
    $categoryCounts[$cat] = isset($categoryCounts[$cat]) ? $categoryCounts[$cat] + 1 : 1;
}

// Count events per location for aside
$locationCounts = [];
foreach ($events as $event) {
    $loc = $event['location'];
    $locationCounts[$loc] = isset($locationCounts[$loc]) ? $locationCounts[$loc] + 1 : 1;
}

// Check if event is coming soon (within 7 days)
function isComingSoon($date) {
    $eventDate = new DateTime($date);
    $today = new DateTime();
    $diff = $today->diff($eventDate)->days;
    return $diff <= 7 && $eventDate >= $today;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>EventHub</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
</head>

<body>

    <header>
        <h1>Event<span>Hub</span></h1>
        <p>Upcoming workshops and community activities</p>
    </header>

    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="admin.php">Admin</a></li>
        </ul>
    </nav>

    <main>

        <!-- Hero section -->
        <div class="hero">
            <h2>Discover Local Events</h2>
            <p>Find and join workshops, seminars and community activities near you</p>
        </div>

        <h2>Upcoming Events</h2>

        <!-- Search and category filter section -->
        <div id="search-section">
            <input type="text" id="search-input" placeholder="Search events...">
            <select id="category-filter">
                <option value="">All Categories</option>
                <option value="IoT">IoT</option>
                <option value="AI">AI</option>
                <option value="Cybersecurity">Cybersecurity</option>
                <option value="Web Development">Web Development</option>
                <option value="Data Science">Data Science</option>
                <option value="Cloud">Cloud</option>
            </select>
        </div>

        <!-- Events load here (used by AJAX too) -->
        <div id="events-container">
            <?php foreach ($events as $event): ?>
                <div class="event">
                    <?php if (isComingSoon($event['date'])): ?>
                        <span class="coming-soon-badge">Coming Soon!</span>
                    <?php endif; ?>
                    <h3><?php echo htmlspecialchars($event['title']); ?></h3>
                    <p><strong>Date:</strong> <?php echo date('F j, Y', strtotime($event['date'])); ?></p>
                    <p><strong>Time:</strong> <?php echo date('g:i A', strtotime($event['time'])); ?></p>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($event['location']); ?></p>
                    <span class="badge badge-<?php echo strtolower(str_replace(' ', '-', htmlspecialchars($event['category']))); ?>">
                        <?php echo htmlspecialchars($event['category']); ?>
                    </span>
                    <p><?php echo htmlspecialchars($event['description']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>

    </main>

    <aside>
        <h2>Categories</h2>
        <ul>
            <li class="category-item" data-category="">
                All Events
                <span class="count-badge"><?php echo count($events); ?></span>
            </li>
            <?php
            $categories = ['IoT', 'AI', 'Cybersecurity', 'Web Development', 'Data Science', 'Cloud'];
            foreach ($categories as $cat):
                $count = isset($categoryCounts[$cat]) ? $categoryCounts[$cat] : 0;
            ?>
            <li class="category-item" data-category="<?php echo $cat; ?>">
                <?php echo $cat; ?>
                <span class="count-badge"><?php echo $count; ?></span>
            </li>
            <?php endforeach; ?>
        </ul>

        <h2>Locations</h2>
        <ul>
            <li class="location-item" data-location="">
                All Locations
                <span class="count-badge"><?php echo count($events); ?></span>
            </li>
            <?php foreach ($locationCounts as $loc => $count): ?>
            <li class="location-item" data-location="<?php echo htmlspecialchars($loc); ?>">
                <?php echo htmlspecialchars($loc); ?>
                <span class="count-badge"><?php echo $count; ?></span>
            </li>
            <?php endforeach; ?>
        </ul>

        <h2>Contact</h2>
        <p>Email: parastoo.shojaeisarcheshm25@my.northampton.ac.uk</p>
    </aside>

    <footer>
        <p>&copy; 2026 EventHub</p>
        <p class="creator">Created by: Parastoo Shojaei</p>
    </footer>

    <!-- Back to top button -->
    <button id="back-to-top" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">↑</button>

</body>

</html>