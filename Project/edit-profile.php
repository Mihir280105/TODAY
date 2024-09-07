<?php
include "imp.php";
require "config.php";
$user = 0;

// Get user ID from query string
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id === 0) {
    echo "No user found.";
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove_profile_picture'])) {
        // User requested to remove profile picture
        $defaultProfilePic = 'default-profile-pic.png';
        $sql = "UPDATE loginsystem SET profile_picture='$defaultProfilePic' WHERE id='$id'";

        if (mysqli_query($con, $sql)) {
            header("Location: profile.php?id=$id");
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($con);
        }
    } else {
        // Existing logic for updating profile
        $unm = isset($_POST["unm"]) ? $_POST["unm"] : '';

        // Check if the username already exists
        $sql = "SELECT * FROM loginsystem WHERE unm='$unm' AND id != '$id'";
        $result = mysqli_query($con, $sql);

        if ($result) {
            $num = mysqli_num_rows($result);
            if ($num > 0) {
                $user = 1; // User already exists
            }
        }
        if ($user === 0) {
            // Handle form submission
            $unm = mysqli_real_escape_string($con, $_POST['unm']);
            $no = mysqli_real_escape_string($con, $_POST['no']);
            $age = mysqli_real_escape_string($con, $_POST['age']);
            $gender = mysqli_real_escape_string($con, $_POST['gender']);

            // Handle file upload
            $profilePicture = '';
            if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
                $fileName = $_FILES['profile_picture']['name'];
                $fileSize = $_FILES['profile_picture']['size'];
                $fileType = $_FILES['profile_picture']['type'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));

                // Define allowed file extensions and size limit
                $allowedExts = array('jpg', 'jpeg', 'png', 'gif');
                $maxSize = 5 * 1024 * 1024; // 5MB

                if (in_array($fileExtension, $allowedExts) && $fileSize <= $maxSize) {
                    // Define new file name and move file
                    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                    $uploadFileDir = './uploads/';
                    $destFilePath = $uploadFileDir . $newFileName;

                    if (move_uploaded_file($fileTmpPath, $destFilePath)) {
                        $profilePicture = $newFileName;
                    } else {
                        echo "Error uploading the file.";
                        exit();
                    }
                } else {
                    echo "Invalid file type or size.";
                    exit();
                }
            }

            // Update user information in the database
            $sql = "UPDATE loginsystem SET unm='$unm', no='$no', age='$age', rd1='$gender'";
            if ($profilePicture) {
                $sql .= ", profile_picture='$profilePicture'";
            }
            $sql .= " WHERE id='$id'";

            if (mysqli_query($con, $sql)) {
                header("Location: profile.php?id=$id");
                exit();
            } else {
                echo "Error updating record: " . mysqli_error($con);
            }
        } else {
            // User already exists, show an alert
            // echo '<script>alert("Username already exists.\\nPlease,Try again with diffrent username...!");</script>';
        }
    }
}

// Fetch user information for the form
$sql = "SELECT * FROM loginsystem WHERE id='$id'";
$res = mysqli_query($con, $sql);
if (mysqli_num_rows($res) == 0) {
    echo "No user found.";
    exit();
}
$row = mysqli_fetch_assoc($res);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" integrity="sha384-dpuaG1suU0eT09tx5plTaGMLBsfDLzUCCUXOY2j/LSvXYuG6Bqs43ALlhIqAJVRb" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Edit Profile</title>
    <link rel="stylesheet" href="./css/edit-profile.css">
    <style>
        
    </style>
    <script>
        function display_image(file){
            var img = document.querySelector(".js-image");
            img.src = URL.createObjectURL(file);
        }
    </script>
</head>
<body>
<?php
if($user){
    echo '<div class="alert alert-light text-dark alert-dismissible fade show" role="alert">
   <i class="bi bi-exclamation-circle-fill"></i>
    <strong>Ohh No Sorry..!</strong> User Already Exists. Please, Try again with a different username...!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}
?>
<div class="container">
    <div class="row col-md-8 border rounded mx-auto mt-5 shadow-lg p-2">
        <div class="col-md-3 text-center">
            <img src="<?php echo $row['profile_picture'] ? './uploads/' . htmlspecialchars($row['profile_picture']) : './images/default-profile-pic.png'; ?>" alt="Profile Image" id="img" class="js-image img-fluid rounded">
            <form action="" method="post">
                <input type="hidden" name="remove_profile_picture" value="1">
                <button type="submit" class="btn btn-danger mt-3">Remove Picture</button>
            </form>
        </div>
        <div class="col-md-9">
            <div class="h2 d-flex justify-content-center">Edit Profile</div>
            <form action="" method="post" enctype="multipart/form-data">
                <table class="table table-striped">
                    <tr>
                        <th><i class="bi bi-person-circle"></i> Username</th>
                        <td><input type="text" class="form-control" name="unm" value="<?php echo htmlspecialchars($row['unm']); ?>" placeholder="Username" required></td>
                    </tr>
                    <tr>
                        <th><i class="bi bi-telephone-fill"></i> Mobile No</th>
                        <td><input type="text" class="form-control" name="no" value="<?php echo htmlspecialchars($row['no']); ?>" placeholder="Mobile Number" maxlength="10" required onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"></td>
                    </tr>
                    <tr>
                        <th><i class="bi bi-info-circle-fill"></i> Age</th>
                        <td><input type="text" class="form-control" name="age" value="<?php echo htmlspecialchars($row['age']); ?>" placeholder="Your Age" maxlength="2" required onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"></td>
                    </tr>
                    <tr>
                        <th><i class="bi bi-gender-ambiguous"></i> Gender</th>
                        <td>
                            <select class="form-select" name="gender">
                                <option value="" disabled>---select---</option>
                                <option value="Male" <?php echo ($row['rd1'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                <option value="Female" <?php echo ($row['rd1'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <div class="mb-3">
                    <label for="formFile" class="form-label">Choose Your Profile Picture :</label>
                    <input onchange="display_image(this.files[0]);" class="form-control" type="file" name="profile_picture">
                </div>
                <div class="d-grid gap-1 d-md-flex justify-content-md-center">
                        <a href="" class="col-md-6 col-12"><button class="btn col-12 btn-primary me-md-2" id="btnsave" style="border-radius:0px;" type="submit">Save</button></a>
                        <a href="profile.php?id=<?php echo $id; ?>" class="col-md-6 col-12"><button class="btn col-12 btn-secondary " style="border-radius:0px;" type="button">Go Back</button></a>
                    </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
