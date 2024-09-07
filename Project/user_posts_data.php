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
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- Theme style -->
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

    .btn-go-back {
      float: right;
    }
    
    .modal-content {
            max-width: 90vw;
            max-height: 90vh;
        }
        .modal-body {
            overflow: auto;
        }
        .modal-content img, .modal-content video {
            max-width: 100vh;
            max-height: 70vh;
            object-fit: cover;
        }
  </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link active">Home</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
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
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="images/logo.png" alt="Logo" id="logo1" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Connect Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="./images/adminlogo.png" class="img-circle elevation-6 mt-2" alt="User Image">
        </div>
        <div class="info" id="adminName">
          <a href="#" class="d-block">Hello, Administrator<br><?php echo $adminName; ?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="#" class="nav-link active">
              <i class="bi bi-house-heart-fill"></i>
              <p>Home</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h3 class="mt-2 text-left">User Data</h3>
          <a href="indexadmin.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Go Back
          </a>
        </div>

        <?php
          include "config.php";
          // Fetch user data from the loginsystem table
          $sql = "SELECT id, user_id, file_path, created_at FROM user_posts";
          $result = $con->query($sql);

          if ($result && $result->num_rows > 0) {
            echo "<table class='table table-bordered table-striped'>";
            echo "<thead class='thead-dark'><tr>";
            echo "<th>ID</th>";
            echo "<th>User ID</th>";
            echo "<th>Posts</th>";
            echo "<th>Created At</th>";
            echo "<th>Actions</th>";
            echo "</tr></thead><tbody>";

            while($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($row['id']) . "</td>";
              echo "<td>" . htmlspecialchars($row['user_id']) . "</td>";
              echo "<td>" . htmlspecialchars($row['file_path']) . "</td>";
              echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
              
              echo "<td class='text-center'>";
              echo "<button class='btn btn-primary btn-sm col-12' data-bs-toggle='modal' data-bs-target='#postModal' data-id='" . htmlspecialchars($row['id']) . "'>View</button><br>";
              echo "</td>";
              
              echo "</tr>";
            }

            echo "</tbody></table>";
          } else {
            echo "<div class='alert alert-info'>No users found.</div>";
          }

          $con->close();
        ?>
      </div>
    </section>
  </div>
 
  <!-- Modal -->
  <div class="modal fade" id="postModal" tabindex="-1" aria-labelledby="postModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="postModalLabel">Post Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-body">
          <div id="modalContent"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <div class="p-3">
      <h5>Additional Settings</h5>
      <p>Sidebar content</p>
    </div>
  </aside>

  <!-- Main Footer -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-inline">
      <a href="#" style="float:right;">Back to top</a>
    </div>
    <strong>&copy; 2024-2025 <a href="https://adminlte.io">Connect.Inc</a>.</strong> All rights reserved.
  </footer>
</div>

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="css/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="css/adminlte.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  var postModal = document.getElementById('postModal');
  postModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var postId = button.getAttribute('data-id');
    var modalContent = document.getElementById('modalContent');
    
    fetch('get_post.php?id=' + postId)
      .then(response => response.json())
      .then(data => {
        if (data.file_path) {
          var fileExtension = data.file_path.split('.').pop().toLowerCase();
          if (['jpg', 'jpeg', 'png'].includes(fileExtension)) {
            modalContent.innerHTML = '<img src="' + data.file_path + '" alt="Post Image">';
          } else if (['mp4', 'webm', 'ogg'].includes(fileExtension)) {
            modalContent.innerHTML = '<video controls><source src="' + data.file_path + '" type="video/' + fileExtension + '">Your browser does not support the video tag.</video>';
          } else {
            modalContent.innerHTML = '<p>Unsupported file type.</p>';
          }
        } else {
          modalContent.innerHTML = '<p>No content available.</p>';
        }
      })
      .catch(error => {
        console.error('Error fetching post:', error);
        modalContent.innerHTML = '<p>Error loading content.</p>';
      });
  });
});
</script>

</body>
</html>
