<?php
session_start();
include('conf/config.php'); // Include database configuration file

// Register new account
if (isset($_POST['create_account'])) {
    // Capture user inputs from the form
    $name = trim($_POST['name']);
    $national_id = trim($_POST['national_id']);
    
    // Generate a random client number
    $client_number = "iBank-CLIENT-" . substr(str_shuffle('0123456789'), 1, 4);
    
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    
    // Hash the password for security
    $password = sha1(md5($_POST['password']));
    $address  = trim($_POST['address']);

    // Insert captured information into the database
    $query = "INSERT INTO iB_clients (name, national_id, client_number, phone, email, password, address) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('sssssss', $name, $national_id, $client_number, $phone, $email, $password, $address);
    $stmt->execute();

    // Provide feedback to the user
    $success = $stmt ? "Account Created Successfully!" : "Error! Please Try Again Later.";
}

// Retrieve system settings
$ret = "SELECT * FROM `iB_SystemSettings`";
$stmt = $mysqli->prepare($ret);
$stmt->execute();
$res = $stmt->get_result();
while ($auth = $res->fetch_object()) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("clientdist/partials/head.php"); ?> <!-- Include HTML head section -->
    <link href="css/style.css" rel="stylesheet">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <h2><?php echo $auth->sys_name; ?> - Sign Up</h2>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Create an account to access our Online Banking Services</p>
                
                <!-- Registration Form -->
                <form method="post" action="clientlogin.php">
                    <div class="form-group">
                        <input type="text" name="name" required class="form-control" placeholder="Full Name">
                    </div>
                    <div class="form-group">
                        <input type="text" name="national_id" required class="form-control" placeholder="National ID Number">
                    </div>
                    <div class="form-group">
                        <input type="text" name="phone" required class="form-control" placeholder="Phone Number">
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" required class="form-control" placeholder="Email Address">
                    </div>
                    <div class="form-group">
                        <input type="text" name="address" required class="form-control" placeholder="Physical Address">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" required class="form-control" placeholder="Password">
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" name="create_account" class="btn btn-success btn-block">Sign Up</button>
                        </div>
                    </div>
                </form>
                
                <!-- Link to Login Page -->
                <p class="mt-3 text-center">
                    <a href="clientlogin.php">Already have an account? Login</a>
                </p>
            </div>
        </div>
    </div>
    
    <!-- Include necessary JavaScript files -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>
</body>
</html>
<?php
} ?>
