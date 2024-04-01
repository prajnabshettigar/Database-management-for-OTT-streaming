<?php
session_start();

// Check if form is submitted
if(isset($_POST['sub'])) {
    // Your form processing logic here
    // For example, you can get form data like this:
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $phn = $_POST['phn'];
    $mail = $_POST['mail'];
    $pass = $_POST['pass'];
    $date = $_POST['date'];
    $month = $_POST['month'];
    $year = $_POST['year'];

    // After processing the form data, you can redirect to option.php or perform any other action as needed
    header("Location: option.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="user.css" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
    <header>
        <div class="container-fluid">
            <nav class="navbar navbar-expand-md navbar-dark bg-dark">
                <a href="login.php" class="navbar-brand"> <img src="images/logo.png" alt=""> </a>
                <span class="navbar-text">CINEMATICA</span>
                <ul class="navbar-nav">
                    <li class="nav-item"> <a href="user-login.php" class="nav-link"> SignIn</a> </li>
                </ul>
            </nav>
            <div class="container">
                <div class="jumbotron">
                    <h1>Create an account</h1>
                    <p>It's free and always will be.</p> <br>
                    <form class="" action="option.php" method="POST">
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control" placeholder="First Name" name="fname" value="">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Last Name" name="lname" value="">
                            </div>
                        </div> <br>
                        <input type="text" class="form-control" placeholder="Mobile Number" name="phn" value="">
                        <br>
                        <input type="email" class="form-control" placeholder="Email Address" name="mail" value="">
                        <br>
                        <input type="password" class="form-control" placeholder="Password" name="pass" value="">
                        <div class="form-group col-md-8">
                            <label for="dob"> <br> Birthday </label>
                            <div class="row">
                                <div class="col">
                                    <select class="form-control" name='date'>
                                        <option selected>Date..</option>
                                        <?php for($i = 1; $i <= 31; $i++) { ?>
                                            <option value='<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>'><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="form-control" name='month'>
                                        <option selected>month...</option>
                                        <?php for($m = 1; $m <= 12; $m++) { ?>
                                            <option value='<?php echo str_pad($m, 2, "0", STR_PAD_LEFT); ?>'><?php echo date("M", mktime(0, 0, 0, $m, 1)); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="form-control" name='year'>
                                        <option selected>year...</option>
                                        <?php for($y = date("Y") - 18; $y >= 1950; $y--) { ?>
                                            <option value='<?php echo $y; ?>'><?php echo $y; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="signupbutton">
                            <br><br>
                            <button type="submit" class="btn btn-success btn-lg" name="sub" value="submit">Sign Up</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </header>
    <footer class="page-footer font-small blue">
        <div class="footer-copyright text-center py-3">© 2024 Copyright:
            <a href="">sonali@gmail.com</a>
            <a href="">prajna@gmail.com</a>
            <a href="">anshah@gmail.com</a>
        </div>
    </footer>
</body>
</html>
