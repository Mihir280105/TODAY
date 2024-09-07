<?php 
include "imp.php"; 
include "config.php";

// Assuming you have a session variable or some way to identify the logged-in admin
$id = $_SESSION['id']; // or however you get the admin's ID

// Fetch admin details
$sql = "SELECT unm FROM loginsystem WHERE id='$id'";
$result = $con->query($sql);

$adminName = "";
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $adminName = htmlspecialchars($row['unm']);
}

// Manually fetch specific table names
$table1Result = $con->query("SHOW TABLES LIKE 'loginsystem'");
$table2Result = $con->query("SHOW TABLES LIKE 'user_about'");
$table3Result = $con->query("SHOW TABLES LIKE 'user_posts'");
$table4Result = $con->query("SHOW TABLES LIKE 'user_queries'");


$table1Name = $table2Name = $table3Name = "";

// Process each table result individually
if ($table1Result && $table1Result->num_rows > 0) {
    $table1Row = $table1Result->fetch_array();
    $table1Name = $table1Row[0];
}

if ($table2Result && $table2Result->num_rows > 0) {
    $table2Row = $table2Result->fetch_array();
    $table2Name = $table2Row[0];
}

if ($table3Result && $table3Result->num_rows > 0) {
    $table3Row = $table3Result->fetch_array();
    $table3Name = $table3Row[0];
}
if ($table4Result && $table4Result->num_rows > 0) {
    $table4Row = $table4Result->fetch_array();
    $table4Name = $table4Row[0];
}

// Close the connection if not needed anymore
$con->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | User Management</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="css/adminlte.min.css">
  <style>
      #logo1 {
      animation: spin 7s infinite linear;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    .profile-img {
      width: 50px;
      height: 50px;
      object-fit: cover;
      border-radius: 50%;
    }
    
    /* Add some styling for the table list */
    .table-list {
      margin-top: 20px;
      padding-left: 0;
      list-style-type: none; /* Remove default list style */
    }
    
    .table-list li {
      padding: 10px;
      margin-bottom: 10px;
      background-color: #f8f9fa;
      border: 1px solid #dee2e6;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }

    .table-list li:hover {
      background-color: #e9ecef;
    }

    .table-list li a {
      text-decoration: none;
      color: #007bff;
      font-weight: bold;
      font-size: 18px;
      display: block;
      padding: 5px 10px;
    }

    .table-list li a:hover {
      text-decoration: underline;
      color: #0056b3;
    }

  </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link active">Home</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
      <img src="images/logo.png" alt="Logo" id="logo1" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Connect Admin</span>
    </a>
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="./images/adminlogo.png" class="img-circle elevation-6 mt-2" alt="User Image">
        </div>
        <div class="info" id="adminName">
          <a href="#" class="d-block">Hello, Administrator<br><?php echo $adminName; ?></a>
        </div>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline ml-2 mr-2">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <nav class="mt-2 ml-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="#" class="nav-link active">
            <i class="bi bi-house-heart-fill"></i>
            <p>Home</p>
          </a>
        </li>
      </ul>
    </nav>
  </aside>

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 d-flex justify-content-left"><u><i class="fa-solid fa-forward"></i> Welcome Admin  <i class="fa-solid fa-user-tie"></i></u></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <h2 class="text-center">Database Tables</h2>
        <ul class="table-list">
          <?php 
          // Display each table name if it exists
          if ($table1Name) echo "<li><a href='loginsystem_data.php?table=$table1Name'><ol>$table1Name</ol></a></li>";
          if ($table2Name) echo "<li><a href='user_about_data.php?table=$table2Name'><ol>$table2Name</ol></a></li>";
          if ($table3Name) echo "<li><a href='user_posts_data.php?table=$table3Name'><ol>$table3Name</ol></a></li>";
          if ($table4Name) echo "<li><a href='user_queries_data.php?table=$table4Name'><ol>$table4Name</ol></a></li>";
          ?>
        </ul>
      </div>
    </section>
  </div>

  <footer class="main-footer">
    <div class="float-right d-none d-sm-inline">
      <a href="#" style="float:right;">Back to top</a>
    </div>
    <strong>&copy; 2024-2025 <a href="https://adminlte.io">Connect.Inc</a>.</strong> All rights reserved.
  </footer>
</div>

<script src="css/jquery.min.js"></script>
<script src="css/bootstrap.bundle.min.js"></script>
<script src="css/adminlte.min.js"></script>
</body>
</html>
