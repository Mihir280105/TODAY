<?php
include "imp.php";
require "config.php";

// Get user ID from query string
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id === 0) {
    echo "No user found.";
    exit();
}

// Fetch user details
$stmt = $con->prepare("SELECT * FROM loginsystem WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) {
    echo "No user found.";
    exit();
}
$row = $res->fetch_assoc();
$stmt->close();

// Handle post submission
$alertMessage = "";
$alertClass = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['post_content'])) {
    $postContent = trim($_POST['post_content']);
    if (!empty($postContent)) {
        $stmt = $con->prepare("INSERT INTO user_about (user_id, content) VALUES (?, ?)");
        $stmt->bind_param("is", $id, $postContent);
        if ($stmt->execute()) {
            $alertMessage = "Shared successfully!";
            $alertClass = "alert-success";
        } else {
            $alertMessage = "Error while sharing.";
            $alertClass = "alert-danger";
        }
        $stmt->close();
    } else {
        $alertMessage = "Content cannot be empty.";
        $alertClass = "alert-warning";
    }
}

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['media_file'])) {
    $file = $_FILES['media_file'];
    if ($file['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($file['name']);
        if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
            $stmt = $con->prepare("INSERT INTO user_posts (user_id, file_path) VALUES (?, ?)");
            $stmt->bind_param("is", $id, $uploadFile);
            if ($stmt->execute()) {
                $alertMessage = "Post uploaded successfully!";
                $alertClass = "alert-success";
            } else {
                $alertMessage = "Error while uploading post";
                $alertClass = "alert-danger";
            }
            $stmt->close();
        } else {
            $alertMessage = "File upload error.";
            $alertClass = "alert-danger";
        }
    } else {
        $alertMessage = "File upload error: " . $file['error'];
        $alertClass = "alert-danger";
    }
}

// Fetch uploaded media
$mediaStmt = $con->prepare("SELECT * FROM user_posts WHERE user_id = ?");
$mediaStmt->bind_param("i", $id);
$mediaStmt->execute();
$mediaRes = $mediaStmt->get_result();
$mediaItems = $mediaRes->fetch_all(MYSQLI_ASSOC);
$mediaStmt->close();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" integrity="sha384-dpuaG1suU0eT09tx5plTaGMLBsfDLzUCCUXOY2j/LSvXYuG6Bqs43ALlhIqAJVRb" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Profile</title>
    <link rel="stylesheet" href="css/welcome.css">
    <style>
        #img {
            width: 225px;
            height: 180px;
            object-fit: cover;
        }
        .alert-container {
            margin: 1rem 0;
        }
        .media-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 1rem;
        }
        .media-item {
            position: relative;
        }
        .media-item img,
        .media-item video {
            width: 100%;
            height: auto;
            border-radius: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-sm navbar-dark bg-dark" aria-label="Third navbar example">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="images/logo.png" alt="Logo" width="30" height="30" id="logo" class="d-inline-block align-text-top rounded-pill">
                    Connect
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarsExample03">
                    <ul class="navbar-nav me-auto mb-2 mb-sm-0 mb-md-0">
                        <li class="nav-item active">
                            <a class="nav-link text-light" href="welcome.php"><i class="fa fa-fw fa-home"></i> Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="contact.php"><i class="fa fa-fw fa-phone"></i> Contact Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="about.php"><i class="fa fa-fw fa-info"></i> About us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark bg-info" href="profile.php?id=<?php echo $id; ?>"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                    </ul>
                    <a href="logout.php"><button class="btn btn-outline-light my-2 my-sm-0 rounded-pill px-3"><i class="fa fa-fw fa-sign-out"></i> Logout</button></a>
                </div>
            </div>
        </nav>
    </div>
    <div class="container">
        <div class="row col-md-8 border rounded mx-auto mt-5 shadow-lg p-2">
            <div class="col-md-3 text-center">
                <?php
                // Determine the profile picture URL
                $profilePicUrl = $row['profile_picture'] ? './uploads/' . htmlspecialchars($row['profile_picture']) : './images/default-profile-pic.png';
                ?>
                <img src="<?php echo $profilePicUrl; ?>" alt="User Image" id="img" class="img-fluid rounded">
                <div class="d-grid gap-2">
                    <!-- Pass ID to edit-profile.php -->
                    <a href="edit-profile.php?id=<?php echo $id; ?>" class="col-12">
                        <button class="btn col-12 btn-primary mt-2" type="button">Edit</button>
                    </a>
                    <!-- Pass ID to delete-acc.php -->
                    <a href="delete-acc.php?id=<?php echo $id; ?>" class="col-12">
                        <button class="btn col-12 btn-danger mb-2" type="button">Delete</button>
                    </a>
                    <!-- File Upload Form -->
                    <form action="" method="post" enctype="multipart/form-data" class="mt-2">
                        <div class="mb-3">
                        <label for="file_upload" class="form-label">Upload Picture or Video</label>
                            <input type="file" name="media_file" class="form-control" accept="image/*,video/*" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Upload</button>
                    </form>
                </div>
            </div>
            <div class="col-md-9">
                <div class="h2 d-flex justify-content-center">Details</div>
                <table class="table table-striped">
                    <tr><th>Username</th><td><?php echo htmlspecialchars($row['unm']); ?></td></tr>
                    <tr><th>Mobile No</th><td><?php echo htmlspecialchars($row['no']); ?></td></tr>
                    <tr><th>Age</th><td><?php echo htmlspecialchars($row['age']); ?></td></tr>
                    <tr><th>Gender</th><td><?php echo htmlspecialchars($row['rd1']); ?></td></tr>
                </table>

                <!-- Post Upload Form -->
                <form action="" method="post">
                    <div class="mb-1">
                        <textarea id="post_content" name="post_content" class="form-control" rows="2" placeholder="Tell us about yourself here..." required></textarea>
                    </div>

                    

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Share It</button>
                        <button type="reset" class="btn btn-secondary">Clear</button>
                    </div>

                    <!-- Alerts positioned between buttons -->
                    <div class="alert-container">
                        <?php if (!empty($alertMessage)) { ?>
                            <div class="alert <?php echo $alertClass; ?>" role="alert">
                                <?php echo htmlspecialchars($alertMessage); ?>
                            </div>
                        <?php } ?>
                    </div>
                </form>

                <!-- Media Grid -->
                <div class="mt-5">
                    <h3 class="text-center">Uploaded Media</h3>
                    <div class="media-grid">
                        <?php foreach ($mediaItems as $media) { ?>
                            <div class="media-item">
                                <?php if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $media['file_path'])) { ?>
                                    <img src="<?php echo htmlspecialchars($media['file_path']); ?>" alt="User Media">
                                <?php } elseif (preg_match('/\.(mp4|webm|ogg)$/i', $media['file_path'])) { ?>
                                    <video controls>
                                        <source src="<?php echo htmlspecialchars($media['file_path']); ?>" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
