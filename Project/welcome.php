<?php
    include "imp.php";
    require "config.php";

    // Get user ID from the session
    $id = $_SESSION['id'];

    // Fetch user details
    $sql = "SELECT * FROM loginsystem WHERE id='$id'";
    $res = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($res);

    // Fetch all user posts
    $postSql = "SELECT * FROM user_posts ORDER BY id DESC"; // Fetch all posts in descending order
    $postRes = mysqli_query($con, $postSql);

    // Search functionality
    $searchQuery = '';
    $suggestions = [];
    if (isset($_GET['query'])) {
        $searchQuery = mysqli_real_escape_string($con, $_GET['query']);

        // Fetch search suggestions from the database
        $suggestionsSql = "SELECT id, unm FROM loginsystem WHERE unm LIKE '%$searchQuery%' LIMIT 10";
        $suggestionsRes = mysqli_query($con, $suggestionsSql);

        while ($row = mysqli_fetch_assoc($suggestionsRes)) {
            $suggestions[] = $row;
        }
    }
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" integrity="sha384-dpuaG1suU0eT09tx5plTaGMLBsfDLzUCCUXOY2j/LSvXYuG6Bqs43ALlhIqAJVRb" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Welcome</title>
    <link rel="stylesheet" href="css/welcome.css">
    <style>
        .modal-content {
            max-width: 90vw;
            max-height: 90vh;
        }
        .modal-body {
            overflow: auto;
        }
        .modal-content img, .modal-content video {
            max-width: 80vh;
            max-height: 70vh;
            object-fit: cover;
        }
        .navbar-nav {
            margin-left: auto;
        }
        .search-container {
            position: relative;
            width: 100%;
            max-width: 400px;
        }
        .search-form {
            display: flex;
            align-items: center;
        }
        .search-input {
            flex-grow: 1;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
            border-right: none;
            padding: 0.5rem;
            transition: all 0.3s ease;
            background-color: #f7f8fa;
            border: 1px solid #ced4da;
            color: #495057;
        }
        .search-input:focus {
            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
            border-color: #80bdff;
            background-color: #ffffff;
            color: #495057;
        }
        .search-button {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            padding: 0.5rem 1rem;
            background-color: #007bff;
            border: 1px solid #007bff;
            color: #fff;
            transition: all 0.3s ease;
        }
        .search-button:hover {
            background-color: #0056b3;
            color: #fff;
        }
        .clear-button {
            position: absolute;
            right: 50px; /* Adjust the position based on the button size */
            background: none;
            border: none;
            color: #495057;
            font-size: 1.2rem;
            cursor: pointer;
        }
        .suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background-color: #fff;
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-top: none;
            border-radius: 0 0 0.375rem 0.375rem;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            max-height: 300px;
            overflow-y: auto;
            z-index: 1000;
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
        .suggestions.entering {
            opacity: 0;
            transform: translateY(-10px);
        }
        .suggestions.entered {
            opacity: 1;
            transform: translateY(0);
        }
        .suggestion-item {
            padding: 0.75rem 1.25rem;
            background-color: #ffffff;
            transition: background-color 0.2s ease, color 0.2s ease;
            cursor: pointer;
        }
        .suggestion-item:not(:last-child) {
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }
        .suggestion-item:hover {
            background-color: #007bff;
            color: #fff;
        }
        .suggestion-item a {
            color: inherit;
            text-decoration: none;
            display: block;
            font-weight: 500;
        }
        .suggestion-item a:hover {
            color: #ffffff;
        }
        .suggestion-item:first-child {
            border-radius: 0.375rem 0.375rem 0 0;
        }
        .suggestion-item:last-child {
            border-radius: 0 0 0.375rem 0.375rem;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-sm navbar-dark bg-dark" aria-label="Third navbar example">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="images/logo.png" alt="Logo" width="33" height="30" id="logo" class="d-inline-block align-text-top rounded-pill">
                    Connect
                </a>
                <form class="d-flex ms-2 position-relative col-9 col-lg-3 search-form me-2" method="GET" action="">
                    <input class="form-control search-input" type="search" name="query" placeholder="Search" aria-label="Search" value="<?php echo htmlspecialchars($searchQuery); ?>" oninput="handleInput()">
                    
                    <button class="btn btn-outline-light search-button me-1 col-4" type="submit"><i class="bi bi-search-heart-fill"></i> Search</button>
                    <?php if (!empty($suggestions)): ?>
                        <div class="suggestions">
                            <?php foreach ($suggestions as $suggestion): ?>
                                <div class="suggestion-item">
                                    <a href="disp-frd.php?id=<?php echo $suggestion['id']; ?>"><?php echo htmlspecialchars($suggestion['unm']); ?></a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </form>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarsExample03">
                    <ul class="navbar-nav me-auto mb-2 mb-sm-0 mb-md-0 ">
                        <li class="nav-item active">
                            <a class="nav-link text-dark bg-info" href="welcome.php"><i class="fa fa-fw fa-home"></i> Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="contact.php"><i class="fa fa-fw fa-phone"></i> Contact Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="about.php"><i class="fa fa-fw fa-info"></i> About us</a>
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

    <div class="container-fluid">
        <div id="carouselExampleIndicators" class="carousel slide">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="images/1.jpg" class="d-block w-100" height="400px" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="images/2.jpg" class="d-block w-100" height="400px" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="images/3.jpg" class="d-block w-100" height="400px" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <div class="container my-3">
        <h2 class="text-center">Posts you Might Like</h2>
        <div class="row mt-3">
            <?php 
            $colCount = 0; // Initialize column counter
            while ($postRow = mysqli_fetch_assoc($postRes)) { 
                if ($colCount % 6 === 0 && $colCount !== 0) {
                    echo '</div><div class="row">'; // Start a new row after 6 columns
                }
                ?>
                <div class="col-md-2 mb-4">
                    <div class="card h-100" data-bs-toggle="modal" data-bs-target="#postModal<?php echo $postRow['id']; ?>">
                        <div class="card-body">
                            <!-- Display the post content -->
                            <?php if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $postRow['file_path'])) { ?>
                                <img src="<?php echo htmlspecialchars($postRow['file_path']); ?>" class="img-fluid" alt="User Media">
                            <?php } elseif (preg_match('/\.(mp4|webm|ogg)$/i', $postRow['file_path'])) { ?>
                                <video controls class="img-fluid">
                                    <source src="<?php echo htmlspecialchars($postRow['file_path']); ?>" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <!-- Modal for this post -->
                <div class="modal fade" id="postModal<?php echo $postRow['id']; ?>" tabindex="-1" aria-labelledby="postModalLabel<?php echo $postRow['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="postModalLabel<?php echo $postRow['id']; ?>">Post Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Display the post content in full screen -->
                                <?php if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $postRow['file_path'])) { ?>
                                    <img src="<?php echo htmlspecialchars($postRow['file_path']); ?>" class="img-fluid" alt="User Media">
                                <?php } elseif (preg_match('/\.(mp4|webm|ogg)$/i', $postRow['file_path'])) { ?>
                                    <video controls class="img-fluid">
                                        <source src="<?php echo htmlspecialchars($postRow['file_path']); ?>" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php 
                $colCount++; // Increment column counter
            } 
            ?>
        </div>
    </div>

    <footer class="container">
        <div class="row">
            <p>© 2024-2025 Connect, Inc. · <a href="policy.php">Privacy</a> · <a href="terms.php">Terms</a> <a href="#" style="float:right;">Back to top</a></p>
        </div>  
    </footer>
    <script>
        function handleInput() {
            const input = document.querySelector('.search-input').value;
            const suggestionsBox = document.querySelector('.suggestions');
            if (input.length > 0) {
                suggestionsBox.style.display = 'block';
            } else {
                suggestionsBox.style.display = 'none';
            }
        }

        function clearSearch() {
            const input = document.querySelector('.search-input');
            const suggestionsBox = document.querySelector('.suggestions');
            
            // Clear the input field
            input.value = '';
            
            // Hide the suggestions box
            suggestionsBox.style.display = 'none';
        }

        // Hide suggestions if the user clicks outside the search box or suggestions
        document.addEventListener('click', function(event) {
            const searchContainer = document.querySelector('.search-container');
            const suggestionsBox = document.querySelector('.suggestions');
            if (!searchContainer.contains(event.target)) {
                suggestionsBox.style.display = 'none';
            }
        });
    </script>
</body>
</html>
