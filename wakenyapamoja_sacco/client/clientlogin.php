<?php
session_start();
include('conf/config.php'); // Get configuration file

// Fetch System Settings
$ret = "SELECT * FROM `iB_SystemSettings`";
$stmt = $mysqli->prepare($ret);
$stmt->execute();
$res = $stmt->get_result();
$auth = $res->fetch_object(); // Fetch the first object

$err = ""; // Initialize the error variable

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password']; // Get the plain password

    // SQL to log in user
    $stmt = $mysqli->prepare("SELECT email, password, clientnumber FROM clients WHERE email=?");
    $stmt->bind_param('s', $email); // Bind fetched parameters
    $stmt->execute(); // Execute bind
    $stmt->bind_result($db_email, $db_password, $id); // Bind result
    $stmt->fetch(); // Fetch results

    // Check if login is successful
    if ($db_email && password_verify($password, $db_password)) {
        $_SESSION['id'] = $id; // Assign session to client id
        header("location:clientdashboard.php"); // Redirect to dashboard
        exit(); // Ensure no further code is executed
    } else {
        $err = "Access Denied. Please Check Your Credentials."; // Set error message
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .signin-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .signin-card h2 {
            color: #4CAF50; /* Colorful heading */
            text-align: center;
            margin-bottom: 20px;
        }
        .signin-card input {
            width: 100%;
            padding: 12px; /* Increased padding for margin */
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box; /* Ensures padding doesn't affect width */
        }
        .signin-card a {
            text-decoration: none; /* Remove underline */
        }
        .signin-card button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            background-color: #4CAF50; /* Signup button color */
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        .signin-card button.login {
            background-color: #007BFF; /* Login button color */
        }
        .error-message {
            color: red; /* Style for error message */
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="signin-card">
        <h2>Log Into Your Account</h2>
        <?php if ($err): ?>
            <div class="error-message"><?php echo $err; ?></div> <!-- Display error message -->
        <?php endif; ?>
        <form method="POST" action=""> <!-- Action points to the same file -->
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Log In</button>
        </form>
        <p>Don't have an Account?</p>
        <a href="clientsignup.php"><button type="button" class="login">Sign Up</button></a>
    </div>
</body>
</html>
