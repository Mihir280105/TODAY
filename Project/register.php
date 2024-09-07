<?php
    $success=0;
    $user=0;
    $invalid=0; 
    if($_SERVER['REQUEST_METHOD']=='POST'){
      require "config.php";
      $unm=$_POST["unm"];
      $pwd=$_POST["pwd"];
      $cpwd=$_POST["cpwd"];
      $no=$_POST['no'];
      $age=$_POST['age'];
      $rd1 =$_POST['rd1'];
      
      $sql="select * from loginsystem where unm='$unm'";
      $result=mysqli_query($con,$sql);
      if($result){
        $num=mysqli_num_rows($result);
        if($num>0){
          $user=1;
        }
        else{
          if($pwd===$cpwd){
            $insert="INSERT INTO `loginsystem`(`unm`,`pwd`,`cpwd`,`no`,`age`,`rd1`)VALUES('$unm','$pwd','$cpwd','$no','$age','$rd1')";
            $result=mysqli_query($con,$insert);
            if($result){
              $success=1;
              header("location:login.php"); 
            }
          } else {
              $invalid=1;
          }
        }
      }
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Register</title>
    <link rel="stylesheet" href="css/register.css">
    <script>
        $(document).ready(function() {
            // Function to enable or disable the register button
            function toggleRegisterButton() {
                if($('#terms').is(':checked') && $('#privacy').is(':checked')) {
                    $('#btnreg').prop('disabled', false);
                } else {
                    $('#btnreg').prop('disabled', true);
                }
            }

            // Event listeners for the checkboxes
            $('#terms, #privacy').change(function() {
                toggleRegisterButton();
            });

            // Initial check in case the page is loaded with checkboxes already checked
            toggleRegisterButton();

            // Show Password Checkbox Functionality
            $('#showPassword').change(function() {
                var type = $(this).is(':checked') ? 'text' : 'password';
                $('#pwd, #cpwd').attr('type', type);
            });
        });
    </script>
  </head>
  <body>
    <?php
    if($user){
      echo '<div class="alert alert-light text-primary alert-dismissible fade show" role="alert">
      <strong>Ohh No Sorry..!</strong> User Already Exists.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
    }
    ?>
    <?php
    if($invalid){
      echo '<div class="alert alert-light text-danger alert-dismissible fade show" role="alert">
      <strong>Error..!</strong> Passwords did not match
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
    }
    ?>
    <div class="container-fluid d-flex justify-content-center mb-1 mb-sm-0 mb-md-0">
      <form action="register.php" method="post" class="form">
          <h4 class="text-center mt-0">Register</h4>
          <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="unm" name="unm" required>
          </div>
          
          <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="pwd" name="pwd" required>
          </div>
          
          <div class="form-group">
            <label for="confirm-password">Confirm Password:</label>
            <input type="password" class="form-control" id="cpwd" name="cpwd" placeholder="Enter same password as above..." required>
          </div>

          <!-- Show Password Checkbox aligned to the right -->
          <div class="form-group d-flex justify-content-between align-items-center">
            <div></div> <!-- Empty div to push the checkbox to the right -->
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="showPassword">
              <label class="form-check-label" for="showPassword">Show Passwords</label>
            </div>
          </div>
          
          <div class="form-group">
            <label for="mobile-no">Mobile No:</label>
            <input type="tel" class="form-control" id="no" name="no" required maxlength="10" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
          </div>
          
          <div class="form-group">
            <label for="age">Age:</label>
            <input type="text" class="form-control" min="0" id="age" name="age" maxlength="2" required onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
          </div>
          
          <div class="form-group mt-1">
            <label for="gender">Gender:</label>
            <div class="form-check form-check-inline">
              <input type="radio" class="form-check-input" id="male" name="rd1" value="male">
              <label class="form-check-label" for="male">Male</label>
            </div>
            <div class="form-check form-check-inline">
              <input type="radio" class="form-check-input" id="female" name="rd1" value="female">
              <label class="form-check-label" for="female">Female</label>
            </div>
          </div>

          <div class="form-check">
              <input type="checkbox" class="form-check-input" id="terms" name="terms">
              <label class="form-check-label" for="terms">I agree to the <a href="terms.php" data-toggle="modal" target="_blank" data-target="#terms-modal">Terms and Conditions</a></label>
          </div>
          <div class="form-check">
              <input type="checkbox" class="form-check-input" id="privacy" name="privacy">
              <label class="form-check-label" for="privacy">I have read the <a href="policy.php" data-toggle="modal" target="_blank" data-target="#privacy-modal">Privacy Policy</a></label>
          </div>
          
          <button type="submit" class="btn btn-primary mt-3" id="btnreg">Register</button>
          <button type="reset" class="btn btn-secondary mt-2">Clear</button>

          <div class="footer-container mt-3 d-flex justify-content-center">
              Already a member?  
          </div>
          <div class="link d-flex justify-content-center">
              <a class="a-default" style="text-decoration: none;" href="login.php"> Login</a>
          </div>
        </form>    
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
