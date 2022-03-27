<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: index.php");
    exit;
} else {
    $showAlert = false;
    $showError = false;
    include 'partials/_dbconnect.php';
    $username = $_SESSION['username'];

    // Deleting the record
    if (isset($_GET['delete'])) {
        $srno = $_GET['delete'];
        $delete = true;
        $sql = "DELETE FROM `companies` WHERE `cid` = $srno";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $showAlert = " Record Deleted.";
        } else {
            $showError = " Unable to delete. Please try later.";
        }
    }

    // Editing the Record
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $srno = $_POST['srnoEdit'];
        $name = $_POST['nameEdit'];
        $website = $_POST['websiteEdit'];
        $phone = $_POST['phoneEdit'];
        $address = $_POST['addressEdit'];
        $city = $_POST['cityEdit'];
        $state = $_POST['stateEdit'];
        $country = $_POST['countryEdit'];
        $industry_list = $_POST['industry_listEdit'];

        // Update query
        $sql = "UPDATE `companies` SET `cname` = '$name', `cwebsite` = '$website', `cphone` = '$phone', `caddress` = '$address', `ccity` = '$city', `cstate` = '$state', `ccountry` = '$country', `industry_list` = '$industry_list' WHERE `companies`.`cid` = $srno";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $showAlert = " Your record updated";
        } else {
            $showError = " Unable to update the record this time";
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

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    <script>
        $(document).ready(function() {
            $('#companiesrecords').DataTable();
        });
    </script>

    <title>Welcome <?php echo $username ?></title>
    <style>
        body {
            background-image: url("/imanager/images/welcome.jpg");
            background-color: #cccccc;
            height: 100vh;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        table {
            table-layout: auto;
            width: 100%;
        }
    </style>
</head>

<body>

    <?php require './partials/_nav.php' ?>

    <?php
    if ($showAlert) {
        echo '<div class="text-center alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong>' . $showAlert . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        $showAlert = false;
    }
    if ($showError) {
        echo '<div class="text-center alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Ops! </strong>' . $showError . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        $showError = false;
    }
    ?>

    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit company details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/imanager/welcome.php" method="POST" class="row g-2">
                        <input type="hidden" name="srnoEdit" id="srnoEdit">
                        <div class="row">
                            <label for="nameEdit" class="col-4">Company Name</label>
                            <input type="text" name="nameEdit" id="nameEdit" class="col-8">
                        </div>
                        <div class="row">
                            <label for="websiteEdit" class="col-4">Website</label>
                            <input type="url" name="websiteEdit" id="websiteEdit" class="col-8">
                        </div>
                        <div class="row">
                            <label for="phoneEdit" class="col-4">Phone</label>
                            <input type="tel" name="phoneEdit" id="phoneEdit" class="col-8">
                        </div>
                        <div class="row">
                            <label for="addressEdit" class="col-4">Address</label>
                            <input type="text" name="addressEdit" id="addressEdit" class="col-8">
                        </div>
                        <div class="row">
                            <label for="cityEdit" class="col-4">City</label>
                            <input type="text" name="cityEdit" id="cityEdit" class="col-8">
                        </div>
                        <div class="row">
                            <label for="stateEdit" class="col-4">State</label>
                            <input type="text" name="stateEdit" id="stateEdit" class="col-8">
                        </div>
                        <div class="row">
                            <label for="countryEdit" class="col-4">Country</label>
                            <input type="text" name="countryEdit" id="countryEdit" class="col-8">
                        </div>
                        <div class="row">
                            <label for="industry_listEdit" class="col-4">Industry List</label>
                            <input type="text" name="industry_listEdit" id="industry_listEdit" class="col-8">
                        </div>
                        <div class="modal-footer mx-auto">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Update Details</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <h1 class="text-center my-3">Welcome <?php echo $username ?></h1>

    <div class="table-responsive p-3">
        <table class="table table-dark table-striped p-2" id="companiesrecords">
            <thead>
                <tr>
                    <th>SrNo.</th>
                    <th>Name</th>
                    <th>Website</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Country</th>
                    <th>Industry List</th>
                    <th scope="col"> Choose Operation </th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetching and displaying companies information from the database into the table
                $sql = "SELECT * FROM companies WHERE username='$username'";
                $result = mysqli_query($conn, $sql);
                $num = mysqli_num_rows($result);

                if ($num > 0) {
                    $srno = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>
                            <td scope="col">' . $srno . '</td>
                            <td scope="col">' . $row['cname'] . '</td>
                            <td scope="col">' . $row['cwebsite'] . '</td>
                            <td scope="col">' . $row['cphone'] . '</td>
                            <td scope="col">' . $row['caddress'] . '</td>
                            <td scope="col">' . $row['ccity'] . '</td>
                            <td scope="col">' . $row['cstate'] . '</td>
                            <td scope="col">' . $row['ccountry'] . '</td>
                            <td scope="col">' . $row['industry_list'] . '</td>
                            <td scope="col"> <button class="edit btn btn-success" id="' . $row['cid'] . '">Edit</button> <button class="delete btn btn-sm btn-danger p-2" id=d"' . $row['cid'] . '">Delete</button></td>
                        </tr>';
                        $srno++;
                    }
                } else {
                    echo '
                    <td colspan="10"> <h3 class="text-center">No Data to show here </h3></td>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="/imanager/js/index.js"></script>
</body>

</html>