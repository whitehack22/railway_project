<?php
session_start();

if (isset($_POST['submit'])) {
    // Include database connection
    include('includes/db.php');  // assuming you have a separate db.php file

    $email = $_POST['email'];
    $pw = $_POST['pw'];

    // Prepare and execute the query to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM passengers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Check if user exists and verify password
    if ($user && password_verify($pw, $user['password'])) {
        // Store user details in session
        $_SESSION['user_info'] = $user['email']; // Store email in session
        $_SESSION['p_id'] = $user['p_id'];        // Store passenger ID in session

        $message = 'Logged in successfully!';
        header("Location: index.php");  // Redirect to a dashboard or main page after login
        exit();
    } else {
        $message = 'Wrong email or password.';
    }
    echo "<script type='text/javascript'>alert('$message');</script>";
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Nairobi Commuters Railway Login</title>
    <script type="text/javascript">
    function validate() {
        var EmailId = document.getElementById("email");
        var atpos = EmailId.value.indexOf("@");
        var dotpos = EmailId.value.lastIndexOf(".");
        var pw = document.getElementById("pw");
        if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= EmailId.value.length) {
            alert("Enter a valid email address");
            EmailId.focus();
            return false;
        }
        if (pw.value.length < 8) {
            alert("Password must consist of at least 8 characters");
            pw.focus();
            return false;
        }
        return true;
    }
    </script>
    <style type="text/css">
        /* Your CSS styles */
        #loginarea {
        background-color: white;
        width: 30%;
        margin: auto;
        border-radius: 25px;
        border: 2px solid #4CAF50;
        margin-top: 100px;
        background-color: rgba(0, 0, 0, 0.5);
        box-shadow: inset -2px -2px rgba(0, 0, 0, 0.5);
        padding: 40px;
        font-family: sans-serif;
        font-size: 20px;
        color: white;
    }


    html {
        background: url(img/bg7.webp) no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
    }
   
    #submit {
    border-radius: 5px;
    background-color: #00bfff; 
    padding: 7px;
    box-shadow: inset -1px -1px rgba(0, 0, 0, 0.5);
    font-family: "Comic Sans MS", cursive, sans-serif;
    font-size: 17px;
    margin: auto;
    margin-top: 20px;
    display: block;
    color: white;
    cursor: pointer;
    border: none; 
}

    #logintext {
        text-align: center;
    }
    .data {
        color: white;
    }
    </style>
</head>
<body>
    <?php include("header.php") ?>
    <div id="loginarea">
        <form id="login" action="login.php" onsubmit="return validate()" method="post" name="login">
            <div id="logintext">Login to Nairobi Commuters Railway!</div><br/><br/>
            <table>
                <tr>
                    <td><div class="data">Enter E-Mail ID:</div></td>
                    <td><input type="text" id="email" size="30" maxlength="50" name="email" required/></td>
                </tr>
                <tr>
                    <td><div class="data">Enter Password:</div></td>
                    <td><input type="password" id="pw" size="30" maxlength="64" name="pw" required/></td>
                </tr>
            </table>
            <input type="submit" value="Submit" name="submit" id="submit" class="button">
        </form>
    </div>
</body>
</html>
