<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "nairobi_commuters");

if (!$conn) {  
    echo "<script type='text/javascript'>alert('Database connection failed');</script>";
    die('Could not connect: ' . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $age = $_POST['age'];
    $mob = $_POST['mob'];
    $gender = $_POST['gender'];
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // Sanitize email input
    $pw = $_POST['pw'];
    $cpw = $_POST['cpw'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format!";
    } else {
        // Check if passwords match
        if ($pw !== $cpw) {
            $message = "Passwords do not match!";
        } else {
            // Check if email already exists
            $stmt = $conn->prepare("SELECT * FROM passengers WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $message = "Email already registered!";
            } else {
                // Hash password before storing
                $hashed_pw = password_hash($pw, PASSWORD_DEFAULT);

                // Insert user data into the database
                $stmt = $conn->prepare("INSERT INTO passengers (p_fname, p_lname, p_age, p_contact, p_gender, email, password) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssissss", $fname, $lname, $age, $mob, $gender, $email, $hashed_pw);
                
                if ($stmt->execute()) {  
                    $message = "You have been successfully registered.";
                } else {  
                    error_log("SQL Error: " . mysqli_error($conn));  // Log error for debugging
                    $message = "Could not insert record. Please try again.";
                }
            }
        }
    }

    // Display message on the page using JavaScript
    echo "<script type='text/javascript'>alert('$message');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register on Nairobi Commuters</title>
    <style>
        /* Your CSS styles */
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        #register_form {
            width: 90%;
            max-width: 400px; /* Restrict max width to fit smaller screens */
            margin: 20px auto;
            border: 2px ;
            border-radius: 10px;
            padding: 15px;
            background-color: rgba(0, 0, 0, 0.5);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        caption {
            margin-bottom: 10px;
            font-size: 1.2rem;
        }
        table {
            width: 100%;
        }
        td {
            padding: 8px;
        }
        input[type="text"], input[type="password"], input[type="number"] {
            width: 100%;
            padding: 6px;
            margin: 5px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 0.9rem;
        }
        input[type="radio"] {
            margin-right: 5px;
        }
        .button {
            background-color: #00bfff;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
        }
        .button:hover {
            background-color: darkorange;
        }
        hr {
            margin: 15px auto;
            border: 1px solid green;
        }
        #logintext {
            margin-top: 15px;
        }

        #logintext input {
            width: 100%;
            padding: 10px;
            background-color: #00bfff;
            color: white;
            font-size: 0.9rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #backToLogin {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 15px;
            background-color: #00bfff;
            color: white;
            font-size: 1rem;
            border-radius: 5px;
            text-decoration: none;
        }

        #backToLogin:hover {
            background-color: darkorange;
        }

        @media (max-width: 400px) {
            caption {
                font-size: 1rem;
            }
            .button, #logintext input {
                padding: 6px 10px;
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <div id="register_form" align="center">
        <form name="register" method="post" action="register.php" onsubmit="return validate()">
            <table>
                <caption>Enter your details:</caption>
                <tr>
                    <td><label for="fname">First Name:</label></td>
                    <td><input name="fname" type="text" maxlength="30" id="fname" required></td>
                </tr>
                <tr>
                    <td><label for="lname">Last Name:</label></td>
                    <td><input name="lname" type="text" maxlength="30" id="lname" required></td>
                </tr>
                <tr>
                    <td><label for="age">Age:</label></td>
                    <td><input name="age" type="number" min="1" max="120" id="age" required></td>
                </tr>
                <tr>
                    <td><label for="mob">Mobile:</label></td>
                    <td><input name="mob" type="number" maxlength="10" id="mob" required></td>
                </tr>
                <tr>
                    <td>Gender:</td>
                    <td>
                        <input type="radio" name="gender" value="Male" required> Male
                        <input type="radio" name="gender" value="Female" required> Female
                    </td>
                </tr>
                <tr>
                    <td><label for="email">E-Mail:</label></td>
                    <td><input name="email" type="text" maxlength="50" id="email" required></td>
                </tr>
                <tr>
                    <td><label for="pw">Password:</label></td>
                    <td><input name="pw" type="password" maxlength="30" id="pw" required></td>
                </tr>
                <tr>
                    <td><label for="cpw">Confirm Password:</label></td>
                    <td><input name="cpw" type="password" maxlength="30" id="cpw" required></td>
                </tr>
            </table>
            <p>
                <input type="submit" value="Submit" name="submit" class="button">
                <input type="reset" value="Reset" class="button">
            </p>
        </form>

        <!-- Link to login page -->
        <a href="login.php" id="backToLogin">Click Here to Login</a>
    </div>
</body>
</html>
