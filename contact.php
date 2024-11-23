<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1, h3 {
            font-weight: bold;
            margin-bottom: 10px;
        }

        label {
            color: white;
            font-weight: bold;
        }

        .contact-wrapper {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .contact-info, .contact-form {
            flex: 1;
            min-width: 300px;
            margin: 10px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        .contact-info p, .contact-info h3 {
            margin: 10px 0;
        }

        .contact-form form {
            display: flex;
            flex-direction: column;
        }

        .contact-form input, .contact-form textarea, .contact-form button {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .contact-form button {
            background-color: #f68b1e;
            color: white;
            border: none;
            cursor: pointer;
        }

        .contact-form button:hover {
            background-color: #ff6600;
        }
    </style>
</head>
<body>
    <?php include("header.php"); ?>

    <div class="container">
        <h1>Contact Us</h1>
        <p style="color:white">Have questions or feedback? We'd love to hear from you. Reach out to us using the details below:</p>

        <div class="contact-wrapper">
            <!-- Contact Information Section -->
            <div class="contact-info" style="color:white">
                <h3>Contact Information</h3>
                <p>Email: support@nairobi-commuters.com</p>
                <p>Phone: +254-700-123-456</p>
                <p>Address: Nairobi Railway HQ, Nairobi, Kenya</p>
            </div>

            <!-- Contact Form Section -->
            <div class="contact-form" style="color:white">
                <h3>Send Us a Message</h3>
                <form action="send_message.php" method="POST">
                    <label for="name">Your Name:</label>
                    <input type="text" id="name" name="name" required>

                    <label for="email">Your Email:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="message">Your Message:</label>
                    <textarea id="message" name="message" rows="5" required></textarea>

                    <button type="submit">Send Message</button>
                </form>
            </div>
        </div>
    </div>

    <?php include("footer.php"); ?>
</body>
</html>
