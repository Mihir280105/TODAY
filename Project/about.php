<?php
include "imp.php";
require "config.php";
$id = $_SESSION['id']; // Get user ID from the session
$sql = "SELECT * FROM loginsystem WHERE id='$id'";
$res = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($res);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" integrity="sha384-dpuaG1suU0eT09tx5plTaGMLBsfDLzUCCUXOY2j/LSvXYuG6Bqs43ALlhIqAJVRb" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>About Us</title>
    <link rel="stylesheet" href="./css/about.css">
    <script>
        $(document).ready(function(){
            $(".content").hide().slideDown(2000);
        });
    </script>
</head>
<body>
<div class="container-fluid">
  <nav class="navbar navbar-expand-sm navbar-dark bg-dark" aria-label="Third navbar example">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
      <img src="images/logo.png" alt="Connect Logo" width="33" height="30" id="logo" class="d-inline-block align-text-top rounded-pill">
      Connect</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarsExample03">
        <ul class="navbar-nav me-auto mb-2 mb-sm-0 mb-md-0 ">
          <li class="nav-item ">
            <a class="nav-link text-light" href="welcome.php"><i class="fa fa-fw fa-home"></i> Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light" href="contact.php"><i class="fa fa-fw fa-phone"></i> Contact Us</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link text-dark bg-info" href="about.php"><i class="fa fa-fw fa-info"></i> About Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light" href="profile.php?id=<?php echo $id; ?>"><i class="fa fa-fw fa-user"></i> Profile</a>
          </li>
        </ul>
        <a href="logout.php"><button class="btn btn-outline-light my-2 my-sm-0 rounded-pill px-3"><i class="fa fa-fw fa-sign-out"></i> Logout</button></a>
      </div>
    </div>
  </nav>
</div>

<div class="container my-4 ms-3 content"> <!-- Added 'content' class -->
    <div class="row featurette d-flex justify-content-center align-items-center">
        <div class="col-md-6">
            <h2 class="featurette-heading">Welcome to Connect! <span class="text-muted">Your social hub.</span></h2>
            <p class="lead">Connect brings people together like never before. Stay in touch with friends, family, and communities. Share your thoughts, photos, and experiences in a vibrant social environment.</p>
        </div>
        <div class="col-md-6">
            <img class="img-fluid" style="transform: scaleX(-1);" src="images/about2.jpg" alt="Connect Community">
        </div>
    </div>
    <div class="row featurette d-flex align-items-center">
        <div class="col-md-5 order-md-2">
            <h2 class="featurette-heading">Our Journey <span class="text-muted">Started in 2023</span></h2>
            <p class="lead">Founded in 2023, Connect was created to revolutionize the way we interact online. We believe in fostering meaningful relationships and creating a positive online community.</p>
        </div>
        <div class="col-md-5 order-md-1">
            <img class="img-fluid" src="images/about-1.jpg" alt="Our Journey">
        </div>
    </div>
    <div class="row featurette d-flex justify-content-center align-items-center">
        <div class="col-md-6">
            <h2 class="featurette-heading">Features that Matter <span class="text-muted">Stay connected!</span></h2>
            <p class="lead">From instant messaging to photo sharing, Connect offers a wide range of features designed to enhance your social experience. Join groups, create events, and connect with like-minded individuals!</p>
        </div>
        <div class="col-md-6">
            <img class="img-fluid" src="images/about-3.jpg" alt="Connect Features">
        </div>
    </div>
</div>

<footer class="container">
    <div class="row">
        <p>© 2024-2025 Connect, Inc. · <a href="policy.php">Privacy Policy</a> · <a href="terms.php">Terms of Service</a> <a href="#" style="float:right;">Back to top</a></p>
    </div>  
</footer>
</body>
</html>
