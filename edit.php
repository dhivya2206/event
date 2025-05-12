<?php
// edit.php

// DB connection (update with your DB credentials)
$conn = new mysqli("localhost", "root", "", "event_ticketing_system");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the event details
if (isset($_GET['id'])) {
    $event_id = $_GET['id'];
    $sql = "SELECT * FROM events WHERE event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $event = $result->fetch_assoc();
    $stmt->close();
}

// Handle the form submission for updating the event
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $location = $_POST['location'];
    $category = $_POST['category'];
    $front_price = $_POST['front_price'];
    $middle_price = $_POST['middle_price'];
    $back_price = $_POST['back_price'];

    $update_sql = "UPDATE events SET name = ?, description = ?, event_date = ?, event_time = ?, location = ?, category = ?, front_price = ?, middle_price = ?, back_price = ? WHERE event_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssssssdddi", $name, $description, $event_date, $event_time, $location, $category, $front_price, $middle_price, $back_price, $event_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Event updated successfully!'); window.location.href = 'view.php';</script>";
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
    <title>Edit Event</title>
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

        h2 {
            text-align: center;
            margin-top: 30px;
        }

        .container {
            width: 90%;
            max-width: 600px;
            margin: 20px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        input, select {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #2ecc71;
            color: white;
            border: none;
        }

        input[type="submit"]:hover {
            background-color: #27ae60;
        }
    </style>
</head>
<body>

<header>
    <h1>Edit Event</h1>
</header>

<div class="container">
    <h2>Update Event Details</h2>
    <form action="edit.php?id=<?= $event['event_id'] ?>" method="POST">
        <label for="name">Event Name:</label>
        <input type="text" id="name" name="name" value="<?= $event['name'] ?>" required>

        <label for="description">Description:</label>
        <input type="text" id="description" name="description" value="<?= $event['description'] ?>" required>

        <label for="event_date">Event Date:</label>
        <input type="date" id="event_date" name="event_date" value="<?= $event['event_date'] ?>" required>

        <label for="event_time">Event Time:</label>
        <input type="time" id="event_time" name="event_time" value="<?= $event['event_time'] ?>" required>

        <label for="location">Location:</label>
        <input type="text" id="location" name="location" value="<?= $event['location'] ?>" required>

        <label for="category">Category:</label>
        <input type="text" id="category" name="category" value="<?= $event['category'] ?>" required>

        <label for="front_price">Front Seat Price (₹):</label>
        <input type="number" id="front_price" name="front_price" value="<?= $event['front_price'] ?>" required>

        <label for="middle_price">Middle Seat Price (₹):</label>
        <input type="number" id="middle_price" name="middle_price" value="<?= $event['middle_price'] ?>" required>

        <label for="back_price">Back Seat Price (₹):</label>
        <input type="number" id="back_price" name="back_price" value="<?= $event['back_price'] ?>" required>

        <input type="submit" value="Update Event">
    </form>
</div>

</body>
</html>

<?php $conn->close(); ?>