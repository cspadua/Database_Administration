<?php
include 'connect.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    $query = "SELECT username FROM users WHERE user_info_id = '$user_id'";
    $result = executeQuery($query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $current_username = $user['username'];
    } else {
        echo "User not found.";
        exit;
    }
} else {
    echo "No user ID provided.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_username = $_POST['username'];

    $update_query = "UPDATE users SET username = '$new_username' WHERE user_info_id = '$user_id'";
    if (executeQuery($update_query)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error updating username.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit︱<?php echo $user['username']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ffffff;
            color: rgb(0, 0, 0);
            font-family: 'Poppins', sans-serif;
        }

        .navbar {
            background-color: #ffffff;
            border-bottom: 1px solid #878787;
        }

        .form-control {
            width: 90%;
        }

        .rounded-custom {
            border-radius: 100px;
        }

        .btn-wide {
            width: 45%;
            background-color: #3b3b3a;
            color: white;
            border-radius: 90px;
            padding: 15px;
            box-sizing: border-box;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .btn-wide:hover {
            background-color: #5a5a59;
            color: #fff;
        }

        /* Animation for going up */
        @keyframes slideUp {
            0% {
                transform: translateY(1000px);
                opacity: 0;
            }

            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .animated-section {
            animation: slideUp 1s ease-out forwards;
            opacity: 0;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg shadow-sm">
        <div class="container d-flex justify-content-center">
            <a class="navbar-brand">
                <img id="logo" src="images/logo-dark-name.png" alt="logo" width="120" height="auto">
            </a>
        </div>
    </nav>

    <section class="container my-5 rounded-3 shadow animated-section" style="background-color: white; color: #000;">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="product-image text-center">
                    <img src="images/s.jpg" class="img-fluid" style="width: 400px; height: auto;">
                </div>
            </div>

            <div class="col-md-6 p-5 shadow-lg rounded-3" style="color: grey;">
                <h2 class="mb-4" style="color: black;">Edit your account</h2>
                <form method="post" action="">
                    <div class="mb-3">
                        <label for="username" class="form-label">New Username</label>
                        <input type="text" name="username" id="username" class="form-control"
                        value="<?php echo $current_username; ?>" required>
                    </div>

                    <div class="d-flex align-items-center mx-5 gap-2 mb-3">
                        <button type="submit" class="btn btn-wide">
                            Confirm
                        </button>
                        <a href="index.php" class="btn shadow btn-wide">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>