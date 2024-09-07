<?php
   include "imp.php";
   require "config.php";
    $id = $_SESSION['id']; // Get user ID from the session
    $sql = "SELECT * FROM loginsystem WHERE id='$id'";
    $res = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($res);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" integrity="sha384-dpuaG1suU0eT09tx5plTaGMLBsfDLzUCCUXOY2j/LSvXYuG6Bqs43ALlhIqAJVRb" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
    <title>Contact Us</title>
    <link rel="stylesheet" href="css/contact.css">
    <script>
        $(document).ready(function(){
            // Initially hide the form
            $(".contact-form").hide();
            // Fade in the form on page load
            $(".contact-form").fadeIn(3000); // Fade in over 1 second
        });
    </script>
</head>
<body class="bg-dark text-light">
<div class="container-fluid">
  <nav class="navbar navbar-expand-sm navbar-dark bg-dark" aria-label="Third navbar example">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
      <img src="images/logo.png" alt="Logo" width="33" height="30" id="logo" class="d-inline-block align-text-top rounded-pill">
      Connect</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarsExample03">
        <ul class="navbar-nav me-auto mb-2 mb-sm-0 mb-md-0 ">
        <li class="nav-item ">
          <a class="nav-link text-light" href="welcome.php "><i class="fa fa-fw fa-home"></i> Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark bg-info" href="contact.php"><i class="fa fa-fw fa-phone"></i> Contact Us</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link text-light" href="about.php"><i class="fa fa-fw fa-info"></i> About us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light" href="profile.php?id=<?php echo $id; ?>"><i class="fa fa-fw fa-user"></i> Profile</a>
        </li>
        </ul>
        <a href="logout.php"><button class="btn btn-outline-light my-2 my-sm-0 rounded-pill px-3"><i class="fa fa-fw fa-sign-out"></i>Logout</button></a>
      </div>
    </div>
  </nav>
</div>

<div class="container my-4 contact-form"> <!-- Added 'contact-form' class -->
    <h2 align="center">Contact Us</h2>
    <form action="submit_contact.php" method="POST" id="contactForm">
        <div class="form-group">
            <label for="exampleFormControlInput1">Email address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
        </div>
        <div class="form-group my-3">
            <label for="exampleFormControlSelect1">Select your Query</label>
            <select class="form-control" id="query" name="query">
                <option>Account Issues</option>
                <option>Content Moderation</option>
                <option>Privacy and Security</option>
                <option>Feature Requests</option>
            </select>
        </div>
        <div class="form-group my-3">
            <label for="exampleFormControlTextarea1">Tell us about yourself</label>
            <textarea class="form-control" id="about" name="about" rows="3"></textarea>
        </div>
        <div class="form-group my-3">
            <label for="exampleFormControlTextarea2">Elaborate Your Concern</label>
            <textarea class="form-control" id="concern" name="concern" rows="3"></textarea>
        </div>
        <div class="d-grid gap-3 ">
            <button class="btn btn-primary" type="submit" value="submit">Submit</button>
            <button class="btn btn-secondary" type="reset" value="clear">Clear</button>
        </div>
    </form>
</div>

<footer class="container">
    <div class="row">
        <p>© 2024-2025 Connect, Inc. · <a href="policy.php">Privacy</a> · <a href="terms.php">Terms</a> <a href="#" style="float:right;">Back to top</a></p>
    </div>  
</footer>
</body>
</html>