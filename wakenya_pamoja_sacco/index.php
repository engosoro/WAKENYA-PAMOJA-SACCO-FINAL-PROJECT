<?php
// Include database configuration file
include("conf/config.php");


// Persist system settings from the database
$ret = "SELECT * FROM `ib_Systemsettings` ";
$stmt = $mysqli->prepare($ret);
$stmt->execute(); // Execute the query
$res = $stmt->get_result(); // Fetch results
while ($sys = $res->fetch_object()) { // Loop through the settings
?>
    <!DOCTYPE html>
    <html lang="en">
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Wakenya Pamoja Sacco - <?php echo $sys->sys_tagline; ?></title>
        <link href="css/style.css" rel="stylesheet">
        <style>
            /* General styling for the body */
            body {
                background-color: #f4f4f9;
                color: #333;
                margin: 0;
                padding: 0;
            }
            /* Navbar styling */
            .navbar {
                background-color: #006400;
                padding: 15px;
                position: fixed;
                top: 0;
                width: 100%;
                z-index: 1000;
            }
            body {
                padding-top: 60px; /* Prevents content from being hidden behind navbar */
            }
            .navbar-brand, .nav-link {
                color: #fff !important;
                font-weight: bold;
            }
            /* Button styling */
            .btn-danger {
                background-color: #ff4500;
                border-color: #ff4500;
                margin-left: 15px; /* Adjusting spacing */
                padding: 10px 20px; /* Ensuring proper size */
            }
            .btn-success {
                background-color: #28a745;
                border-color: #28a745;
            }
            /* Hero section styling */
            .intro {
                background: linear-gradient(rgba(0, 100, 0, 0.7), rgba(0, 100, 0, 0.7)), url('images/bg.webp');
                background-size: cover;
                background-position: center;
                min-height: 100vh; /* Ensures full viewport height */
                display: flex;
                align-items: center;
                justify-content: center;
                text-align: center;
                position: relative;
            }
            .intro::before {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5); /* Darker overlay for better readability */
                z-index: 1;
            }
            .intro-content {
                position: relative;
                z-index: 2;
                opacity: 0;
                transform: translateY(20px);
                animation: fadeInUp 1s ease-out forwards;
            }
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            .btn {
                margin: 10px 10px; /* Adjusted spacing for buttons */
                padding: 12px 20px;
            }
            .navbar-nav {
                display: flex;
                align-items: center;
            }
            .nav-item {
                margin-right: 15px;
            }
        </style>
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="index.php">Wakenya Pamoja Sacco</a>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" target="_blank" href="clientlogin.php">Client Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" target="_blank" href="stafflogin.php">Staff Login</a>
                        </li>
                                                <li>
                            <a class="btn btn-danger" href="clientsignup.php" target="_blank">Join Us</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
<!-- Hero Section -->
<div class="intro text-white">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12 col-sm-10 col-md-8 col-lg-6 mx-auto intro-content">
                        <h1 class="my-3 display-4">Wakenya Pamoja Sacco</h1>
                        <p class="lead mb-3">
                            <?php echo $sys->sys_tagline; ?>
                        </p>
                        <a class="btn btn-success btn-lg my-1" target="_blank" href="aboutus.html" role="button">About Us</a>
                    </div>
                </div>
            </div>
        </div>
        <footer class="text-center p-3" style="background:#006400; color:white;">
            <p>&copy; <?php echo date('Y'); ?> Wakenya Pamoja Sacco | All Rights Reserved</p>
            <p><a href="mailto:support@wakenyapamoja.com" style="color: #ffcc00;">Contact Support</a></p>
        </footer>
        <script src="wakenyapamoja_sacco/dist/js/bundle.js"></script>
    </body>
    </html>
<?php
} ?>
