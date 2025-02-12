<?php
session_start();
include('conf/config.php');
$client_id = $_SESSION['client_id'];

// Fetch account balance dynamically
$result = "SELECT SUM(transaction_amt) FROM ib_transactions WHERE client_id = ?";
$stmt = $mysqli->prepare($result);
$stmt->bind_param('i', $client_id);
$stmt->execute();
$stmt->bind_result($account_balance);
$stmt->fetch();
$stmt->close();

echo number_format($account_balance, 2);
?>
