<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            padding: 20px;
            background-color: #b00; /* Light red background */
            color: white;
            border-radius: 8px;
            margin: 30px auto;
            max-width: 800px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }
        h1 {
            text-align: center;
            color: #fff;
        }
        p {
            line-height: 1.6;
            color: #e0e0e0;
        }
        footer {
            text-align: center;
            padding: 10px 0;
            background-color: #444;
            color: #fff;
        }
        footer a {
            color: #0af;
            text-decoration: none;
            margin: 0 10px;
        }
        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php include("header.php"); ?>

    <div class="container">
        <h1>About Us</h1>
        <p>
            Welcome to the Nairobi Commuters Railway System! We aim to provide a seamless and efficient railway ticketing experience. 
            Our goal is to revolutionize urban transportation with innovative technology, making daily commutes easier for everyone.
        </p>
        <p>
            Designed and developed by Gordon Amos, our system is tailored to meet the needs of Nairobi's commuters, 
            ensuring fast bookings, secure payments, and real-time updates.
        </p>
        <p>
            Thank you for choosing us as your travel companion.
        </p>
    </div>

    <footer>
        <p>© 2024 Nairobi Commuters Railway System. All Rights Reserved.<br>
           Designed by Gordon Amos | 
           <a href="about.php">About Us</a> | 
           <a href="contact.php">Contact</a> | 
           <a href="privacy-policy.php">Privacy Policy</a>
        </p>
    </footer>
</body>
</html>
