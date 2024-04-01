<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Include your database connection or any other necessary files here
include 'dbh.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_payment'])) {
    // Process payment logic here
    // For demonstration purposes, let's just display a success message
    $payment_amount = 0;
    $sub_plan = $_POST['sub_plan'];
    // Fetch user's balance
    $sql_fetch_balance = "SELECT balance FROM b_account_details WHERE u_id = ?";
    $stmt_fetch_balance = $conn->prepare($sql_fetch_balance);
    $stmt_fetch_balance->bind_param("s", $_SESSION['id']);
    $stmt_fetch_balance->execute();
    $stmt_fetch_balance->bind_result($balance);
    $stmt_fetch_balance->fetch();
    $stmt_fetch_balance->close();


    // Fetch subscription plan amount from pricing_plan table
    $sql_fetch_plan_amount = "SELECT p_amount FROM pricing_plan WHERE p_id = ?";
    $stmt = $conn->prepare($sql_fetch_plan_amount);
    $stmt->bind_param("s", $sub_plan);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $payment_amount = $row['p_amount'];
    }
    $stmt->close();

    if ($balance < $payment_amount) {
        echo "<script>alert('Payment is not possible. Insufficient balance.')</script>";
    } else {

        // Insert subscription record into the subscription table
        $sub_date = date("Y-m-d");
        $exp_date = date("Y-m-d", strtotime("+30 days"));
        $u_id = $_SESSION['id'];
        $sql_insert_subscription = "INSERT INTO subscription (u_id, sub_date, exp_date,sub_plan) VALUES (?, ?, ?, ?)";
        $stmt_insert_subscription = $conn->prepare($sql_insert_subscription);
        $stmt_insert_subscription->bind_param("ssss", $u_id, $sub_date, $exp_date, $sub_plan);
        if ($stmt_insert_subscription->execute()) {
            // Subscription record inserted successfully
        } else {
            echo "Error: " . $sql_insert_subscription . "<br>" . $conn->error;
        }
        $stmt_insert_subscription->close();

        // Deduct payment amount from user's bank account balance
        $sql_deduct_balance = "UPDATE b_account_details SET balance = balance - ? WHERE u_id = ?";
        $stmt_deduct_balance = $conn->prepare($sql_deduct_balance);
        $stmt_deduct_balance->bind_param("ss", $payment_amount, $u_id);
        if ($stmt_deduct_balance->execute()) {
            // Balance deducted successfully
        } else {
            echo "Error: " . $sql_deduct_balance . "<br>" . $conn->error;
        }
        $stmt_deduct_balance->close();

        echo "<script>
    alert('Payment of $payment_amount processed successfully!')
</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Subscription Payment</title>

    <link rel="stylesheet" href="payment.css" type="text/css"> <!-- You can create payment.css for styling -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>

<body>
    <header>
        <!-- Navigation Bar -->
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <a href="#" class="navbar-brand"> <img src="images/logo.png" alt=""> </a>
            <span class="navbar-text">CINEMATICA</span>
        <ul class="navbar-nav">
        <li class="nav-item active"> <a href="homepage.php" class="nav-link">Home</a> </li>
        </ul>
      </nav>
    </header>

    <section>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Monthly Subscription
                        </div>
                        <div class="card-body">
                            <p>Subscribe to NeonFlix for unlimited streaming of movies and TV shows.</p>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                                <div class="form-group">
                                    <label for="payment_amount">Subscription Plan:</label>
                                    <select name="sub_plan" id="sub_plan" class="form-control" required>
                                    <option value="1">Monthly- $99.99/month</option>
                                        <option value="2">Yearly - $299.99/month</option>
                                    </select>
                                </div>
                                <button type="submit" name="submit_payment" class="btn btn-primary">Subscribe Now</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="page-footer font-small blue">
        <div class="footer-copyright text-center py-3">© <?php echo date("Y"); ?> Copyright:
            <a href="">Your Company</a>
        </div>
    </footer>
</body>

</html>
