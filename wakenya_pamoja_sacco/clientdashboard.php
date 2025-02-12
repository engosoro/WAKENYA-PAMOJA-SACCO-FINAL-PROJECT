<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');

// Fetch account balance dynamically
$result = "SELECT SUM(transaction_amt) FROM ib_transactions WHERE client_id = ?";
$stmt = $mysqli->prepare($result);
$stmt->bind_param('i', $client_id);
$stmt->execute();
$stmt->bind_result($account_balance);
$stmt->fetch();
$stmt->close();

// Fetch recent loan information (if applicable)
//$loan_query = "SELECT * FROM loans WHERE client_id = ? ORDER BY application_date DESC LIMIT 1";
//$stmt = $mysqli->prepare($loan_query);
//$stmt->bind_param('i', $client_id);
//$stmt->execute();
//$loan_result = $stmt->get_result();
//$loan_details = $loan_result->fetch_object();
//$stmt->close();
//?>

<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<?php include("clientdist/partials/head.php"); ?>
<link href="css/style.css" rel="stylesheet">

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">

  <div class="wrapper">
    <?php include("clientdist/partials/nav.php"); ?>
    <?php include("clientdist/partials/sidebar.php"); ?>
    <div class="row justify-content-center">
      <h1 >Client Dashboard</h1>
      </div>

            <!-- Check Balance Button -->
            <div class="row justify-content-center">
            <div class="col-12 col-md-4">
              <div class="card">
                <div class="card-header bg-info text-white">
                  <h5>Check Balance</h5>
                </div>
                <div class="card-body">
                  <button class="btn btn-info btn-block" id="check_balance_button" onclick="window.location.href = 'accountbalance.php'">Check Balance</button>
                </div>
              </div>
            </div>
            </div>

          </div>

          <!-- Send Money Section -->
          <div class="row justify-content-center">
            <div class="col-12 col-md-4">
              <div class="card">
                <div class="card-header bg-primary text-white">
                  <h5>Send Money</h5>
                </div>
                <div class="card-body">
                  <form method="POST" action="send_money.php">
                    <div class="form-group">
                      <label for="account_number">Recipient's Account Number</label>
                      <input type="text" class="form-control" id="account_number" name="account_number" required>
                    </div>
                    <div class="form-group">
                      <label for="amount">Amount (sh.)</label>
                      <input type="number" class="form-control" id="amount" name="amount" required>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Send Money</button>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <!-- Withdraw Cash Section -->
          <div class="row justify-content-center">
            <div class="col-12 col-md-4">
              <div class="card">
                <div class="card-header bg-danger text-white">
                  <h5>Withdraw Cash</h5>
                </div>
                <div class="card-body">
                  <form method="POST" action="withdraw_cash.php">
                    <div class="form-group">
                      <label for="withdraw_amount">Amount to Withdraw (sh.)</label>
                      <input type="number" class="form-control" id="withdraw_amount" name="withdraw_amount" required>
                    </div>
                    <button type="submit" class="btn btn-danger btn-block">Withdraw</button>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <!-- Loan Application Section -->
          <div class="row justify-content-center">
            <div class="col-12 col-md-4">
              <div class="card">
                <div class="card-header bg-warning text-dark">
                  <h5>Loan Application</h5>
                </div>
                <div class="card-body">
                  <form method="POST" action="apply_loan.php">
                    <div class="form-group">
                      <label for="loan_amount">Loan Amount (sh.)</label>
                      <input type="number" class="form-control" id="loan_amount" name="loan_amount" required>
                    </div>
                    <div class="form-group">
                      <label for="loan_term">Loan Term (months)</label>
                      <input type="number" class="form-control" id="loan_term" name="loan_term" required>
                    </div>
                    <button type="submit" class="btn btn-warning btn-block">Apply for Loan</button>
                  </form>
                </div>
              </div>
            </div>
          </div>

        </div>
      </section>
    </div>
    <!-- End of Main content -->

    <footer class="text-center p-3" style="background:#006400; color:white;">
      <p>&copy; <?php echo date('Y'); ?> Wakenya Pamoja Sacco | All Rights Reserved</p>
      <p><a href="mailto:support@wakenyapamoja.com" style="color: #ffcc00;">Contact Support</a></p>
    </footer>

  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <script src="dist/js/adminlte.js"></script>

  <script>
    $(document).ready(function() {
      $('#check_balance_button').click(function() {
        // Fetch the balance dynamically using AJAX
        $.ajax({
          url: 'fetch_balance.php',
          type: 'GET',
          success: function(data) {
            $('#account_balance').text("sh. " + data);
          }
        });
      });
    });
  </script>

</body>
</html>
