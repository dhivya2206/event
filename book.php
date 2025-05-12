<?php
// book.php

// 1) Connect and fetch events
$conn = new mysqli("localhost", "root", "", "event_ticketing_system");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT event_id, name, front_price, middle_price, back_price FROM events";
$result = $conn->query($sql);

$events = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
} else {
    // No events at all? Halt early with a message.
    die("⚠️ No events found. Please create an event first.");
}

// 2) If form was submitted, process booking
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get POST data
    $username   = $_POST['username'];
    $email      = $_POST['email'];
    $phone      = $_POST['phone'];
    $event_id   = $_POST['event_id'];
    $seating    = $_POST['seating'];
    $tickets    = (int)$_POST['tickets'];
    $requests   = $_POST['requests'];

    // Look up the event's price for this seating
    $pricePerTicket = 0;
    foreach ($events as $e) {
        if ($e['event_id'] == $event_id) {
            $key = strtolower($seating) . "_price"; // "front_price"/"middle_price"/"back_price"
            $pricePerTicket = isset($e[$key]) ? (float)$e[$key] : 0;
            break;
        }
    }
    $totalPrice = $pricePerTicket * $tickets;

    // Insert into bookings
    $stmt = $conn->prepare(
      "INSERT INTO bookings 
         (username, email, phone, event_id, seating, tickets, requests, total_price)
       VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param(
      "sssssiis",
      $username,
      $email,
      $phone,
      $event_id,
      $seating,
      $tickets,
      $requests,
      $totalPrice
    );

    if ($stmt->execute()) {
        // On success, pop up an alert
        echo "<script>
                alert('🎉 Tickets booked successfully!\\nTotal Price: ₹{$totalPrice}');
              </script>";
    } else {
        echo "<script>
                alert('❌ Booking failed: " . addslashes($stmt->error) . "');
              </script>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Book Tickets</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f0f2f5; margin:0; padding:0; }
    header { background:#2c3e50; color:#fff; padding:20px; text-align:center; }
    nav ul { list-style:none; margin:10px 0 0; padding:0; display:flex; justify-content:center; }
    nav li { margin:0 15px; }
    nav a { color:#fff; text-decoration:none; font-weight:bold; }
    section { max-width:650px; background:#fff; margin:30px auto; padding:25px; border-radius:10px;
              box-shadow:0 4px 10px rgba(0,0,0,0.1); }
    label { display:block; margin-top:15px; font-weight:bold; }
    input, select, textarea {
      width:100%; padding:10px; margin-top:5px; border:1px solid #ccc; border-radius:5px;
    }
    .submit-btn {
      margin-top:20px; padding:12px 20px; background:#27ae60; color:#fff; border:none;
      border-radius:5px; cursor:pointer; font-size:17px;
    }
    .submit-btn:hover { background:#1e8449; }
    .price { margin-top:15px; font-weight:bold; }
  </style>
</head>
<body>
  <header>
    <h1>Book Tickets</h1>
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

  <section>
    <form action="book.php" method="post">
      <label>Your Name:</label>
      <input type="text" name="username" required>

      <label>Email Address:</label>
      <input type="email" name="email" required>

      <label>Phone Number:</label>
      <input type="tel" name="phone" pattern="[0-9]{10}" placeholder="10-digit number" required>

      <label>Select Event:</label>
      <select name="event_id" id="eventSelect" required>
        <option value="">-- Choose Event --</option>
        <?php foreach ($events as $e): ?>
          <option
            value="<?php echo $e['event_id']; ?>"
            data-front-price="<?php echo (float)$e['front_price']; ?>"
            data-middle-price="<?php echo (float)$e['middle_price']; ?>"
            data-back-price="<?php echo (float)$e['back_price']; ?>"
          >
            <?php echo htmlspecialchars($e['name'], ENT_QUOTES); ?>
          </option>
        <?php endforeach; ?>
      </select>

      <label>Preferred Seating:</label>
      <select name="seating" id="seating" required>
        <option value="">-- Select Seating --</option>
        <option value="Front">Front</option>
        <option value="Middle">Middle</option>
        <option value="Back">Back</option>
      </select>

      <label>Number of Tickets:</label>
      <input type="number" name="tickets" id="tickets" min="1" value="1" required>

      <div class="price">
        <label>Total Price (₹):</label>
        <input type="text" id="totalPrice" value="0" readonly>
      </div>

      <label>Special Requests:</label>
      <textarea name="requests" placeholder="Mention if any..."></textarea>

      <input type="submit" value="Book Now" class="submit-btn">
    </form>
  </section>

  <script>
    const eventSelect    = document.getElementById('eventSelect');
    const seatingSelect  = document.getElementById('seating');
    const ticketsInput   = document.getElementById('tickets');
    const totalPriceInput= document.getElementById('totalPrice');

    function calculateTotalPrice() {
      const opt = eventSelect.selectedOptions[0];
      if (!opt || !opt.value) {
        totalPriceInput.value = 0;
        return;
      }
      const seatKey = seatingSelect.value.toLowerCase() + "-price";   // "front-price", "middle-price", "back-price"
      const unit   = parseFloat(opt.dataset[seatKey]) || 0;
      const qty    = parseInt(ticketsInput.value) || 0;
      totalPriceInput.value = (unit * qty).toFixed(2);
    }

    // Trigger the calculation on change or input events
    eventSelect.addEventListener('change', calculateTotalPrice);
    seatingSelect.addEventListener('change', calculateTotalPrice);
    ticketsInput.addEventListener('input', calculateTotalPrice);

    // Trigger the calculation once on page load
    window.addEventListener('load', calculateTotalPrice);
  </script>
</body>
</html>