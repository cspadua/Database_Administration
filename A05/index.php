<?php
include("connect.php");

$query = "SELECT 
    `addresses`.`address_id`, 
    `cities`.`city_name`, 
    `provinces`.`province_name`, 
    `user_info`.`user_info_id`, 
    `user_info`.`first_name`, 
    `user_info`.`last_name`, 
    `user_info`.`birthday`, 
    `users`.`username`, 
    `users`.`password`, 
    `users`.`email`, 
    `users`.`phone_number`, 
    `users`.`will_remember` 
FROM 
    `users` 
LEFT JOIN 
    `user_info` ON `users`.`user_info_id` = `user_info`.`user_info_id` 
LEFT JOIN 
    `addresses` ON `users`.`user_info_id` = `addresses`.`user_info_id` 
LEFT JOIN 
    `cities` ON `addresses`.`city_id` = `cities`.`city_id` 
LEFT JOIN 
    `provinces` ON `addresses`.`province_id` = `provinces`.`province_id`;";

$result = executeQuery($query);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chttr's</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Text&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="images/icon.png">
</head>

<body data-bs-theme="dark" id="body">
    <nav class="navbar navbar-expand-lg" style="background-color: #FDE374; border-bottom: 1px solid #000;">
        <div class="container d-flex justify-content-center">
            <a class="navbar-brand">
                <img id="logo" src="images/logo-dark-name.png" alt="logo" width="120" height="auto">
            </a>
        </div>
    </nav>

    <section>
        <h1 class="welcome-section">WELCOME</h1>
        <h3 class="to-chttr-users-section">to chttr’s, users</h3>
    </section>

    <div>
        <h1 class="users-list">users &lt;li&gt;</h1>
    </div>

    <div class="container">
        <div class="row">
            <?php
            if (mysqli_num_rows($result)) {
                while ($user = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                        <div class="card rounded-4 shadow my-3 mx-2 user-card" style="background-color: #9CD08E; color: black;">
                            <div class="card-img-top text-center mt-3">
                                <img src="images/user.png" alt="User Logo"
                                    style="width: 100px; height: 100px; object-fit: cover;" class="rounded-circle">
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title">
                                    <?php echo "Username: @" . (!empty($user["username"]) ? $user["username"] : "Unknown"); ?>
                                </h5>
                                <h6 class="card-subtitle mb-2">
                                    <?php echo (!empty($user["first_name"]) ? $user["first_name"] : "Unknown") . " " . (!empty($user["last_name"]) ? $user["last_name"] : "Unknown"); ?>
                                </h6>
                                <div class="card-details">
                                    <p class="card-text">
                                        <?php echo "Email: " . (!empty($user["email"]) ? $user["email"] : "Unknown"); ?>
                                    </p>
                                    <p class="card-text">
                                        <?php echo "Phone Number: " . (!empty($user["phone_number"]) ? $user["phone_number"] : "Unknown"); ?>
                                    </p>
                                    <p class="card-text">
                                        <?php echo "Address: " . (!empty($user["city_name"]) ? $user["city_name"] : "Unknown") . " City, " . (!empty($user["province_name"]) ? $user["province_name"] : "Unknown"); ?>
                                    </p>
                                    <p class="card-text">
                                        <?php echo "Birthday: " . (!empty($user["birthday"]) ? $user["birthday"] : "Unknown"); ?>
                                    </p>
                                </div>
                                <div class="card-remember">
                                    <img src="images/<?php echo isset($user['will_remember']) && $user['will_remember'] == 'Yes' ? 'check.png' : 'x.png'; ?>"
                                        alt="Remember Status" class="remember-icon">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<div class='col-12'><p>No users found.</p></div>";
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <div class="container">
        <footer class="py-3 my-4">
            <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Home</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Features</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Pricing</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">FAQs</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">About</a></li>
            </ul>
            <p class="text-center text-muted">© 2024 Chttr's, Inc</p>
        </footer>
    </div>
</body>

</html>