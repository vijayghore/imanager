<?php
$showAlert = false;
$showError = false;

// Signup on Post submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'partials/_dbconnect.php';
    $name = $_POST['name'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];

    // Check user is already register with or already taken the username
    $existsql = "SELECT * FROM `user` WHERE username='$username' OR email='$email'";
    $existsresult = mysqli_query($conn, $existsql);
    $numExistRows = mysqli_num_rows($existsresult);
    if ($numExistRows > 0) {
        $showError = " Email already registered or Username already taken.";
    } else {
        // Check if both passwords are same or not
        if (($password == $cpassword)) {

            // Creating password hash
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO `user` (`uname`, `email`, `dob`, `username`, `password`, `dt`) VALUES ('$name', '$email', '$dob', '$username', '$hash', current_timestamp());";

            $result = mysqli_query($conn, $sql);

            if ($result) {
                $showAlert = true;
            }else{
                $showError = " Couldnt allow this time, please try later";
            }
        } else {
            $showError = " Passwords does not match.";
        }
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

    <title>Signup - iManager</title>

    <style>
        body {
            background-image: url("images/signup.jpg");
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
    </style>
</head>

<body>
    <?php require 'partials/_nav.php' ?>

    <?php
    if ($showAlert) {
        echo '<div class="text-center alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Account has been created and now you can login
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
    if ($showError) {
        echo '<div class="text-center alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Ops!</strong>' . $showError . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
    ?>

    <div class="container mt-5">
        <h1 class="text-center text-light my-5">Signup for the iManager</h1>

        <div class="row justify-content-center m-3">
            <div class="col-lg-6 col-md-9 col-sm-12">
                <form action="/imanager/signup.php" method="POST" class="justify-content-center">
                    <div class="mb-3">
                        <input type="text" class="form-control" maxlength="50" id="name" name="name" placeholder="Your name" required>
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" maxlength="50" id="email" name="email" placeholder="email@example.com" required>
                    </div>

                    <div class="mb-3">
                        <label for="dob" class="form-label">DOB </label>
                        <input type="date" class="form-control" max="<?php echo date('Y-m-d') ?>" id="dob" name="dob" placeholder="Date of Birth" required>
                    </div>

                    <div class="mb-3">
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" aria-describedby="userNameHelp" maxlength="30" required>
                        <div id="userNameHelp" class="form-text">Choose your username</div>
                    </div>

                    <div class="mb-3">
                        <input type="password" class="form-control" maxlength="20" id="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Confirm Password" maxlength="20" aria-describedby="passHelp" required>
                        <div id="passHelp" class="form-text">Make sure to use both password same.</div>
                    </div>
                    <div class="mb-3 row justify-content-center">
                        <button type="submit" class="col btn btn-secondary mx-2">Signup</button>
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