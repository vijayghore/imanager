<?php
session_start();
$showAlert = false;
$showError = false;

// Check if user is logged in or not
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: index.php");
    exit;
} else {

    // Add the record to the database
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include 'partials/_dbconnect.php';
        
        $name = $_POST['name'];
        $website = $_POST['website'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $country = $_POST['country'];
        $industrylist = $_POST['industrylist'];
        $username = $_SESSION['username'];

        $sql = "INSERT INTO `companies` (`cname`, `cwebsite`, `cphone`, `caddress`, `ccity`, `cstate`, `ccountry`, `industry_list`, `username`) VALUES ('$name', '$website', '$phone', '$address', '$city', '$state', '$country', '$industrylist', '$username');";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            $showAlert = true;
        } else {
            $showError = " Not able to process the data. Please try again later.";
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

    <title>Add Company - iManager</title>

    <style>
        body {
            background-image: url("images/addcompany.jpg");
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
            <strong>Success!</strong> Company data added successfully !!
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

    <div class="container">

        <h1 class="my-3 text-center text-light">Add company details here</h1>

        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-8 col-sm-12">
                <form action="/imanager/addcompany.php" method="post" class="justify-content-center row g-3 my-2" name="companydetails">
                    <div class="col-12">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Company Name" max="200" required>
                    </div>
                    <div class="col-12">
                        <input type="url" class="form-control" name="website" id="website" placeholder="Company's Website" required>
                    </div>
                    <div class="col-12">
                        <input type="tel" class="form-control" name="phone" id="phone" placeholder="Phone Number" pattern="[0-9]{10}" required>
                    </div>
                    <div class="col-12">
                        <textarea type="text" class="form-control" name="address" id="address" placeholder="Address" required></textarea>
                    </div>
                    <div class="col-12">
                        <input type="text" class="form-control" name="city" id="city" placeholder="City" required>
                    </div>
                    <div class="col-12">
                        <input type="text" class="form-control" name="state" id="state" placeholder="State" required>
                    </div>
                    <div class="col-12">
                        <input type="text" class="form-control" name="country" id="country" placeholder="Country" required>
                    </div>

                    <div class="col-12">
                        <select id="industrylist" name="industrylist" class="form-select" required>
                            <option value="" selected>-----Industry List-----</option>
                            <option value="Accounts">Accounts</option>
                            <option value="IT">IT</option>
                            <option value="Sales">Sales</option>
                            <option value="Health Care">Health Care</option>
                        </select>
                    </div>

                    <div class="row my-2">
                        <button type="submit" class="col btn btn-secondary mx-2">Add Company</button>
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