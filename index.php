<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Ticketing System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #2c3e50;
            color: white;
            padding: 30px 0;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        header h1 {
            margin: 0;
            font-size: 36px;
            letter-spacing: 1px;
        }

        .container {
            max-width: 700px;
            background-color: white;
            margin: 50px auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .welcome-text h2 {
            font-size: 32px;
            font-weight: bold;
            color: #333;
        }

        .highlight {
            background: linear-gradient(90deg, #2c3e50, #4e657a);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
        }

        .welcome-text p {
            font-size: 18px;
            color: #666;
            margin-top: 15px;
        }

        .button-container {
            margin-top: 40px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .action-btn {
            padding: 18px 40px;
            font-size: 20px;
            color: white;
            text-decoration: none;
            background: linear-gradient(45deg, #2c3e50, #4e657a);
            border-radius: 50px;
            box-shadow: 0 6px 15px rgba(44, 62, 80, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .action-btn:hover {
            transform: scale(1.08);
            box-shadow: 0 8px 20px rgba(44, 62, 80, 0.5);
        }
    </style>
</head>
<body>

<header>
    <h1>Event Ticketing System</h1>
</header>

<div class="container">
    <div class="welcome-text">
        <h2>Welcome to Your <span class="highlight">Event World</span>!</h2>
        <p>Plan, Book & Enjoy Your Events Effortlessly</p>
        <div class="button-container">
            <a href="create.php" class="action-btn">Create Event</a>
            <a href="view.php" class="action-btn">View Events</a>
            <a href="book.php" class="action-btn">Book Tickets</a>
            <a href="view_bookings.php" class="action-btn">View Bookings</a>
            <a href="contact.php" class="action-btn">Contact</a>
        </div>
    </div>
</div>

</body>
</html>