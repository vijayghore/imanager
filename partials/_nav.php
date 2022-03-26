<?php

// check whether user is logged in or not
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
  $loggedin = true;
} else {
  $loggedin = false;
}
echo '
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/imanager/welcome.php">iManager</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/imanager/welcome.php">Home</a>
        </li>';

if (!$loggedin) {
  echo '
    <li class="nav-item">
    <a class="nav-link" aria-current="page" href="/imanager/addcompany.php">AddCompany</a>
    </li>';
}

echo '
  </ul>';

if ($loggedin) {
  echo '
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
            <a class="nav-link" href="/imanager/index.php">Login</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="/imanager/signup.php">Signup</a>
        </li>
      </ul>';
}


if (!$loggedin) {
  echo '
    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item ml-auto">
            <a class="nav-link" href="/imanager/logout.php">Logout</a>
        </li>
    </ul>
    ';
}
echo '</div>
  </div> 
</nav>';
