<?php
include 'config.php'; // Include database configuration
include 'imp.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form inputs
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $query = mysqli_real_escape_string($con, $_POST['query']);
    $about = mysqli_real_escape_string($con, $_POST['about']);
    $concern = mysqli_real_escape_string($con, $_POST['concern']);

    // SQL query to insert data into the user_queries table
    $sql = "INSERT INTO user_queries (email, query, about, concern) VALUES ('$email', '$query', '$about', '$concern')";

    // Execute the query
    if (mysqli_query($con, $sql)) {
        echo "<script>alert('Your query has been submitted successfully!\\nwe will try to reach back to you with a solution as soon as possible...\\nThank you for reaching out to us..!\\n♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ ♥ '); window.location.href = 'contact.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }

    // Close the database connection
    mysqli_close($con);
} else {
    echo "Invalid request method.";
}
?>