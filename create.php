<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>
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

        section {
            max-width: 600px;
            background-color: white;
            margin: 30px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        form label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"],
        input[type="time"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        textarea {
            resize: vertical;
        }

        .submit-btn {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #2980b9;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .submit-btn:hover {
            background-color: #1c5980;
        }
    </style>
</head>
<body>
    <header>
        <h1>Create New Event</h1>
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
        <form action="insert.php" method="post">
            <label>Event Name:</label>
            <input type="text" name="name" required>

            <label>Description:</label>
            <textarea name="description" required></textarea>

            <label>Date:</label>
            <input type="date" name="event_date" required>

            <label>Time:</label>
            <input type="time" name="event_time" required>

            <label>Location:</label>
            <input type="text" name="location" required>

            <label>Category:</label>
            <select name="category" required>
                <option value="Concert">Concert</option>
                <option value="Conference">Conference</option>
                <option value="Workshop">Workshop</option>
                <option value="Seminar">Seminar</option>
                <option value="Festival">Festival</option>
                <option value="Theatre">Theatre</option>
                <option value="Sports">Sports</option>
            </select>

            <label>Price (₹) for Front Row:</label>
            <input type="number" name="front_price" step="0.01" required>

            <label>Price (₹) for Middle Row:</label>
            <input type="number" name="middle_price" step="0.01" required>

            <label>Price (₹) for Back Row:</label>
            <input type="number" name="back_price" step="0.01" required>

            <input type="submit" value="Create Event" class="submit-btn">
        </form>
    </section>
</body>
</html>