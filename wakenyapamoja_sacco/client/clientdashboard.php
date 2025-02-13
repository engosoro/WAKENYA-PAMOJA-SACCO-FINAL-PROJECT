<?php
session_start();
include('conf/config.php'); // Get configuration file

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header("location:client/clientlogin.php"); // Redirect to login if not logged in
    exit();
}

// Fetch client details from the database
$id = $_SESSION['id'];

// Prepare the statement to fetch client details
$stmt = $mysqli->prepare("SELECT name, clientnumber, email, phonenumber, balance FROM clients WHERE id=?");
$stmt->bind_param('s', $id);
$stmt->execute();
$stmt->bind_result($name, $clientnumber, $email, $phonenumber, $balance);
$stmt->fetch();
$stmt->close();

// Check if variables are set, otherwise assign default values
if (!isset($name)) {
    $name = "Guest"; // Default value if name is not found
}
if (!isset($clientnumber)) {
    $clientnumber = "N/A"; // Default value if client number is not found
}
if (!isset($email)) {
    $email = "N/A"; // Default value if email is not found
}
if (!isset($phonenumber)) {
    $phonenumber = "N/A"; // Default value if phone number is not found
}
if (!isset($balance)) {
    $balance = 0; // Default value if balance is not found
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .dashboard {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #4CAF50;
        }
        .client-info {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background: #f9f9f9;
        }
        .client-info p {
            margin: 5px 0;
        }
        .section {
            margin: 20px 0;
        }
        .section h2 {
            color: #007BFF;
        }
        .actions {
            display: flex;
            justify-content: space-between;
        }
        .actions button {
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
            font-size: 16px;
        }
        .deposit {
            background-color: #28a745; /* Green for deposit */
        }
        .withdraw {
            background-color: #dc3545; /* Red for withdraw */
        }
        .loans {
            background-color: #17a2b8; /* Cyan for loans */
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <h1>Welcome, <?php echo htmlspecialchars($name); ?>!</h1>
        <div class="client-info">
            <p><strong>Client Number:</strong> <?php echo htmlspecialchars($clientnumber); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($phonenumber); ?></p>
            <p><strong>Account Balance:</strong> $<?php echo number_format($balance, 2); ?></p>
        </div>

        <div class="section">
            <h2>Account Actions</h2>
            <div class="actions">
                <button class="deposit" onclick="alert('Deposit functionality to be implemented!')">Deposit</button>
                <button class="withdraw" onclick="alert('Withdraw functionality to be implemented!')">Withdraw</button>
                <button class="loans" onclick="alert('Loan functionality to be implemented!')">Loans</button>
            </div>
        </div>
    </div>
</body>
</html>
