<?php
session_start();
include('conf/config.php');

// Initialize error and success messages
$err = "";
$success = "";

// Register new account
if (isset($_POST['create_account'])) {
    // Check if all required fields are set
    $name = $_POST['name'] ?? null;
    $national_id = $_POST['nationalid'] ?? null;
    $client_number = $_POST['clientnumber'] ?? null;
    $phone = $_POST['phonenumber'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);
    $address = $_POST['address'] ?? null;

    // Validate required fields
    if ($name && $national_id && $client_number && $phone && $email && $address) {
        // Insert Captured information to a database table
        $query = "INSERT INTO clients (name, nationalid, clientnumber, phonenumber, email, password, address) VALUES (?,?,?,?,?,?,?)";
        $stmt = $mysqli->prepare($query);

        if ($stmt) {
            // Bind parameters
            $stmt->bind_param('sssssss', $name, $national_id, $client_number, $phone, $email, $password, $address);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $success = "Account Created Successfully!";
                } else {
                    $err = "Please Try Again Or Try Later.";
                }
            } else {
                $err = "Execution failed: " . $stmt->error;
            }
        } else {
            $err = "Failed to prepare statement: " . $mysqli->error;
        }
    } else {
        $err = "Please fill in all required fields.";
    }
}

// Fetch System Settings
$ret = "SELECT * FROM `iB_SystemSettings` ";
$stmt = $mysqli->prepare($ret);
$stmt->execute();
$res = $stmt->get_result();
while ($auth = $res->fetch_object()) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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
        .signup-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .signup-card h2 {
            color: #4CAF50; /* Colorful heading */
            text-align: center;
            margin-bottom: 20px;
        }
        .signup-card input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .signup-card button {
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
        .message {
            color: red; /* Error message color */
            text-align: center;
        }
        .success {
            color: green; /* Success message color */
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="signup-card">
        <h2>Sign Up To Get Started</h2>
        <?php if ($err): ?>
            <div class="message"><?php echo htmlspecialchars($err); ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="text" name="nationalid" placeholder="National ID Number" required>
            <input type="text" name="clientnumber" placeholder="Client Number" required>
            <input type="tel" name="phonenumber" placeholder="Phone Number" required>
            <input type="text" name="address" placeholder="Address" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="create_account">Sign Up</button>
        </form>
        <h5>Already have an Account? Logins</h5>
        <a href="clientlogin.php"><button type="button" class="login">Login</button></a>
    </div>
</body>
</html>
<?php
} ?>
