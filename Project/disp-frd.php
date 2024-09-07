<?php
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

$aboutStmt = $con->prepare("SELECT content FROM user_about WHERE user_id = ?");
$aboutStmt->bind_param("i", $id);
$aboutStmt->execute();
$aboutResult = $aboutStmt->get_result();
$aboutContent = $aboutResult->num_rows > 0 ? $aboutResult->fetch_assoc()['content'] : 'No information available.';
$aboutStmt->close();

// Fetch uploaded media
$mediaStmt = $con->prepare("SELECT * FROM user_posts WHERE user_id = ? ORDER BY created_at DESC");
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
    <title>Friend's Profile</title>
    <link rel="stylesheet" href="./css/disp-frd.css">
</head>
<body>
    <div class="container">
        <div class="row col-md-8 border rounded mx-auto mt-5 shadow-lg p-2">
            <div class="col-md-3 text-center">
                <?php
                $profilePicUrl = $row['profile_picture'] ? './uploads/' . htmlspecialchars($row['profile_picture']) : './images/default-profile-pic.png';
                ?>
                <img src="<?php echo $profilePicUrl; ?>" alt="User Image" id="img" class="img-fluid rounded">
            </div>
            <div class="col-md-9">
                <div class="h2 d-flex justify-content-center">Friend's Details</div>
                <table class="table table-striped">
                    <tr><th>Username</th><td><?php echo htmlspecialchars($row['unm']); ?></td></tr>
                    <tr><th>Mobile No</th><td><?php echo htmlspecialchars($row['no']); ?></td></tr>
                    <tr><th>Age</th><td><?php echo htmlspecialchars($row['age']); ?></td></tr>
                    <tr><th>Gender</th><td><?php echo htmlspecialchars($row['rd1']); ?></td></tr>
                </table>

                <!-- About Section -->
                <div class="mt-3">
                    <h4>About</h4>
                    <p><?php echo nl2br(htmlspecialchars($aboutContent)); ?></p>
                </div>

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
                                <span class="upload-time">
                                    <?php echo date('M d, Y H:i', strtotime($media['created_at'])); ?>
                                </span>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>