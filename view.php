<?php
// view.php

// DB connection (update with your DB credentials)
$conn = new mysqli("localhost", "root", "", "event_ticketing_system");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all events
$sql = "SELECT * FROM events ORDER BY event_date ASC";
$result = $conn->query($sql);

// Handle delete action
if (isset($_GET['delete'])) {
    $event_id = $_GET['delete'];
    $delete_sql = "DELETE FROM events WHERE event_id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $event_id);
    if ($stmt->execute()) {
        echo "<script>alert('Event deleted successfully!'); window.location.href = 'view.php';</script>";
    } else {
        echo "❌ Error: " . $stmt->error;
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Events</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #34495e;
            color: white;
            padding: 20px;
            text-align: center;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 10px 0 0 0;
            display: flex;
            justify-content: center;
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            text-decoration: none;
            color: white;
            font-weight: bold;
        }

        nav ul li a:hover {
            text-decoration: underline;
        }

        h2 {
            text-align: center;
            margin-top: 30px;
        }

        .container {
            width: 90%;
            max-width: 1100px;
            margin: 20px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #2ecc71;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #e1f7e7;
        }

        .action-btns {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .action-btns a {
            padding: 6px 12px;
            background-color: #2980b9;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            width: 48%;
            text-align: center;
        }

        .action-btns a:hover {
            background-color: #1c5980;
        }

        .delete-btn {
            background-color: #e74c3c;
        }

        .delete-btn:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>

<header>
    <h1>All Upcoming Events</h1>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="create.php">Create Event</a></li>
            <li><a href="view.php">View Events</a></li>
            <li><a href="book.php">Book Tickets</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </nav>
</header>

<div class="container">
    <h2>Event Listings</h2>
    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Date</th>
                <th>Time</th>
                <th>Location</th>
                <th>Category</th>
                <th>Price (₹)</th>
                <th>Actions</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row["name"] ?></td>
                    <td><?= $row["description"] ?></td>
                    <td><?= $row["event_date"] ?></td>
                    <td><?= $row["event_time"] ?></td>
                    <td><?= $row["location"] ?></td>
                    <td><?= $row["category"] ?></td>
                    <td>Front: ₹<?= $row["front_price"] ?>, Middle: ₹<?= $row["middle_price"] ?>, Back: ₹<?= $row["back_price"] ?></td>
                    <td class="action-btns">
                        <a href="edit.php?id=<?= $row['event_id'] ?>">Edit</a>
                        <a href="?delete=<?= $row['event_id'] ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this event?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p style="text-align:center;">No events found.</p>
    <?php endif; ?>
</div>

</body>
</html>

<?php $conn->close(); ?>
