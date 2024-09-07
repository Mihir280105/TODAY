<?php
include "config.php";

if (isset($_GET['id'])) {
    $id = $con->real_escape_string($_GET['id']);
    $sql = "SELECT file_path FROM user_posts WHERE id='$id'";
    $result = $con->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode(['file_path' => null]);
    }
} else {
    echo json_encode(['file_path' => null]);
}

$con->close();
?>