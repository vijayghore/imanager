<?php
$login = false;
$showError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'partials/_dbconnect.php';
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Check username and password from database
    $sql = "SELECT * FROM user WHERE username='$username'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);

    // On successful login redirects to welcome.php 
    if ($num == 1) {

        while($row=mysqli_fetch_assoc($result)){
            // Verify the password entered by user from database
            if (password_verify($password, $row['password'])){ 
                $login = true;
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                header("location: welcome.php");
            } 
            else{
                $showError = " Invalid Credentials";
            }
        }
    } else {
        $showError = " Invalid Credentials";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Login - iManager</title>
    <style>
        body {
            background-image: url("images/login.jpg");
            /* The image used */
            background-color: #cccccc;
            /* Used if the image is unavailable */
            height: 100vh;
            /* You must set a specified height */
            background-position: center;
            /* Center the image */
            background-repeat: no-repeat;
            /* Do not repeat the image */
            background-size: cover;
        }
        .centerscreen{
            margin-top: 25vh;
        }
    </style>
</head>

<body>
    <?php require 'partials/_nav.php' ?>

    <?php
    // Show message on successful login
    if ($login) {
        echo '<div class="alert alert-success alert-dismissible fade show text-center" role="alert">
            <strong>Success! </strong> You are logged in.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
    if ($showError) {
        echo '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
            <strong>Ops! </strong>' . $showError . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
    ?>
    <div class="container centerscreen">
        <h1 class="text-center text-light">Login to iManager</h1>

        <div class="row m-3 justify-content-center align-items-center">
            <div class="col-lg-6 col-md-9 col-sm-12">
                <form action="/imanager/index.php" method="POST" class="justify-content-center row">
                    <div class="col-12 mb-3">
                        <input type="text" class="form-control" maxlength="25" id="username" name="username" placeholder="Username" aria-describedby="emailHelp" autocomplete="username">
                    </div>
                    <div class="col-12 mb-3">
                        <input type="password" class="form-control" maxlength="20" id="password" name="password" placeholder="Password" autocomplete="current-password">
                    </div>
                    <div class="row mb-3">
                        <button type="submit" class="col btn btn-secondary mx-2">Submit</button>
                        <button type="reset" class="col btn btn-secondary mx-2">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>