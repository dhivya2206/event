<?php
// 1. Connect to the database
$conn = new mysqli("localhost", "root", "", "event_ticketing_system");

// 2. Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// 3. Get form values
$name = $_POST['name'];
$description = $_POST['description'];
$event_date = $_POST['event_date'];
$event_time = $_POST['event_time'];
$location = $_POST['location'];
$category = $_POST['category'];
$front_price = $_POST['front_price'];
$middle_price = $_POST['middle_price'];
$back_price = $_POST['back_price'];

// 4. Prepare SQL statement
$sql = "INSERT INTO events (name, description, event_date, event_time, location, category, front_price, middle_price, back_price)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

// 5. Check if prepare() failed
if (!$stmt) {
    die("❌ Prepare failed: " . $conn->error);
}

// 6. Bind parameters
$stmt->bind_param("ssssssddd", $name, $description, $event_date, $event_time, $location, $category, $front_price, $middle_price, $back_price);

// 7. Execute the statement
if ($stmt->execute()) {
    // 8. Show popup message on success
    echo "<script>alert('🎉 Event created successfully!'); window.location.href = 'view.php';</script>";
} else {
    echo "❌ Error: " . $stmt->error;
}

// 9. Close everything
$stmt->close();
$conn->close();
?>