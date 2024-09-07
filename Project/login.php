<?php
function els(){
    echo '<p class="color">Error: Invalid Credentials...! Please Try Again</p>';        
}

require "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $unm = $_POST["unm"];
    $pwd = $_POST["pwd"];

    $sql = "SELECT * FROM loginsystem WHERE unm='$unm' AND pwd='$pwd'";
    $result = mysqli_query($con, $sql);
    $num = mysqli_num_rows($result);
    $row = mysqli_fetch_assoc($result);

    if ($num >= 1) {
        $login = true;
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['unm'] = $unm;
        $_SESSION['id'] = $row['id']; // Store user ID in the session

        if ($row["role"] == "admin") {
            header("location:./indexadmin.php");
        } else {
            header("location:welcome.php"); // Redirect to welcome page
        }
    } else {
        els();
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Login</title>
    <link rel="stylesheet" href="./css/login.css">
    <script>
    $(document).ready(function() {
        $("#showPassword").click(function() {
            const passwordInput = $("#pwd");
            // Toggle the password visibility
            if ($(this).is(":checked")) {
                passwordInput.attr("type", "text"); // Show password
            } else {
                passwordInput.attr("type", "password"); // Hide password
            }
        });
    });
</script>
  </head>
  <body>
    <div class="container-fluid d-flex justify-content-center mb-2 mb-sm-0 mb-md-0">
    <form class="form" method="post">
      <h4 class="text-center">Login</h4>
        <div class="mb-3 mt-5">
            <label for="unm" class="form-label">Username:</label>
            <input type="text" class="form-control" id="unm" name="unm" required>
        </div>
        <div class="mb-1">
            <label for="pwd" class="form-label">Password</label>
            <input type="password" class="form-control" id="pwd" name="pwd" required>
        </div> 
        <div class="form-check mb-3" style="float:right;">
            <input type="checkbox" class="form-check-input" id="showPassword">
            <label class="form-check-label" for="showPassword">Show Password</label>
        </div>
            <button type="submit" class="btn btn-primary mt-4 p-2" id="btn1">Login</button>
            <button type="reset" class="btn btn-secondary mt-3 p-2">Clear</button>

            <div class="footer-container mt-3 d-flex justify-content-center">
                Don't have an account?
            </div>
            <div class="link d-flex justify-content-center">
                <a class="a-default" style="text-decoration: none;" href="register.php"> Register</a>
            </div>
          
    </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>