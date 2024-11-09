<?php
include("connect.php");

$registrationSuccess = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $birthday = $_POST['birthday'];
    $password = $_POST['password'];
    $will_remember = isset($_POST['will_remember']) ? 'Yes' : 'No';
    $city_id = $_POST['city_id'];
    $province_id = $_POST['province_id'];


    $addressQuery = "INSERT INTO addresses (city_id, province_id) VALUES ('$city_id', '$province_id')";
    if (executeQuery($addressQuery)) {
        $address_id = mysqli_insert_id($conn);


        $userInfoQuery = "INSERT INTO user_info (first_name, last_name, birthday, address_id) 
                          VALUES ('$first_name', '$last_name', '$birthday', '$address_id')";
        if (executeQuery($userInfoQuery)) {
            $user_info_id = mysqli_insert_id($conn);


            $usersQuery = "INSERT INTO users (username, email, phone_number, password, will_remember, user_info_id) 
                           VALUES ('$username', '$email', '$phone_number', '$password', '$will_remember', '$user_info_id')";
            if (executeQuery($usersQuery)) {
                $registrationSuccess = true;
            } else {
                echo "<p>Error: " . mysqli_error($conn) . "</p>";
            }
        } else {
            echo "<p>Error: " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p>Error: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up for Chttr's</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Text&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="images/icon.png">
</head>

<body id="body">
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
                    <img src="images/1.gif" class="img-fluid" style="width: 1000px; height: auto;">
                </div>
            </div>

            <div class="col-md-6 p-5 shadow-lg rounded-3" style="color: grey;">
                <h2 class="mb-4" style="color: black;">Create an account</h2>
                <form method="post" action="">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                    </div>
                    <div class="mb-3">
                        <label for="birthday" class="form-label">Birthday</label>
                        <input type="date" class="form-control" id="birthday" name="birthday" required>
                    </div>

                    <div class="mb-3">
                        <label for="city_id" class="form-label">City</label>
                        <select class="form-control" id="city_id" name="city_id" required>
                            <?php
                            $cityQuery = "SELECT city_id, city_name FROM cities";
                            $result = mysqli_query($conn, $cityQuery);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='{$row['city_id']}'>{$row['city_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="province_id" class="form-label">Province</label>
                        <select class="form-control" id="province_id" name="province_id" required>
                            <?php
                            $provinceQuery = "SELECT province_id, province_name FROM provinces";
                            $result = mysqli_query($conn, $provinceQuery);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='{$row['province_id']}'>{$row['province_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="will_remember" name="will_remember">
                        <label for="will_remember" class="form-check-label" style="color: black;">Will remember</label>
                    </div>

                    <div class="d-flex align-items-center mb-3">
                        <button type="submit" class="btn shadow btn-wide">
                            Create an account
                        </button>
                        <svg class="bi flex-shrink-0 ms-2" role="img" aria-label="Success:"
                            style="width: 20px; height: 20px; display: none;" id="success-message">
                            <use xlink:href="#check-circle-fill"></use>
                        </svg>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <div class="container">
        <footer class="row row-cols-1 row-cols-sm-2 row-cols-md-5 py-5 my-5 border-top">
            <div class="col mb-3">
                <img src="images/logo-dark-name.png" width="30%">
                <p class="text-body-secondary">© 2024</p>
            </div>

            <div class="col mb-3">

            </div>

            <div class="col mb-3">
                <h5>Policies</h5>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a href="" class="nav-link p-0 text-body-secondary">Help
                            Center</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Jobs</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Term of Use</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Contact
                            Us</a></li>
                </ul>
            </div>

            <div class="col mb-3">
                <h5>Services</h5>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Account</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Redeem Gift Cards</a>
                    </li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Privacy</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Speed Test</a>
                    </li>
                </ul>
            </div>

            <div class="col mb-3">
                <h5>Purchases</h5>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Media
                            Center</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Buy Gift Cards</a>
                    </li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Cookie
                            Preferences</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Legal Notices</a>
                    </li>
                </ul>
            </div>
        </footer>
    </div>

    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
        <symbol id="check-circle-fill" viewBox="0 0 16 16">
            <path
                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z">
            </path>
        </symbol>
        <symbol id="info-fill" viewBox="0 0 16 16">
            <path
                d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z">
            </path>
        </symbol>
        <symbol id="exclamation-triangle-fill" viewBox="0 0 16 16">
            <path
                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z">
            </path>
        </symbol>
    </svg>

    <script>
        document.getElementById('success-message').style.display = 'block';
        setTimeout(function () {
            document.getElementById('success-message').style.display = 'none';
        }, 3000);
    </script>
</body>

</html>