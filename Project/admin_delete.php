<?php
// delete-acc.php
include "config.php";

// Get the user ID from the URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Start a transaction
    $con->begin_transaction();

    try {
        // Delete related records from user_about table
        $sql_about = "DELETE FROM user_about WHERE user_id = ?";
        $stmt_about = $con->prepare($sql_about);
        $stmt_about->bind_param("i", $id);
        $stmt_about->execute();

        // Delete related records from user_post table
        $sql_posts = "DELETE FROM user_posts WHERE user_id = ?";
        $stmt_posts = $con->prepare($sql_posts);
        $stmt_posts->bind_param("i", $id);
        $stmt_posts->execute();

        // Delete related records from user_queries table
        $sql_queries = "DELETE FROM user_queries WHERE id = ?";
        $stmt_queries = $con->prepare($sql_queries);
        $stmt_queries->bind_param("i", $id);
        $stmt_queries->execute();

        // Now delete the user from the loginsystem table
        $sql_user = "DELETE FROM loginsystem WHERE id = ?";
        $stmt_user = $con->prepare($sql_user);
        $stmt_user->bind_param("i", $id);
        $stmt_user->execute();

        // Commit the transaction
        $con->commit();

        // Redirect back to the main page
        header("Location: loginsystem_data.php");
        exit();
    } catch (Exception $e) {
        // If an error occurs, rollback the transaction
        $con->rollback();
        echo "Error deleting user: " . $e->getMessage();
    }

    // Close the statements
    $stmt_about->close();
    $stmt_posts->close();
    $stmt_queries->close();
    $stmt_user->close();
}

// Close the database connection
$con->close();
?>
