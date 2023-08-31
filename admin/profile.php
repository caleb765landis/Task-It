<?php session_start(); //this must be the very first line on the php page, to register this page to use session variables


	//if this is a page that requires login always perform this session verification
	require_once "../inc/sessionVerify.php";
	require_once "../dbconnect.php";

    if (isset($_POST['delete_account'])) {
        $deactivateStmt = $con->prepare("UPDATE USER SET Active = 0 WHERE UserID = ?;");
        $deactivateStmt->execute(array($_SESSION['uid']));
        $deactivateStmt->closeCursor();

        Header ("Location:logout.php");
    }

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Profile</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/Edit-Form.css">
    <link rel="stylesheet" href="assets/css/taskit.css">
</head>

<body id="page-top">
  <?php
    $username = "";
    $email = "";
    $password = "";
    $position = "";
    $fn = "";
    $ln = "";
    $address = "";
    $city = "";
    $state = "";

    $stmt = $con->prepare("SELECT * FROM USER WHERE Username = ?");
    $stmt->execute(array($_SESSION['username']));

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $username = $row["Username"];
    $email = $row["Email"];
    $password = $row["Password"];
    $position = $row["Position"];
    $fn = $row["FirstName"];
    $ln = $row["LastName"];

    if ($row["Address"] != NULL) {
      $address = $row["Address"];
    } else {
      $address = "Sunset Blvd, 38";
    }
    if ($row["Address"] != NULL) {
      $city = $row["City"];
    } else {
      $city = "Los Angeles";
    }
    if ($row["Address"] != NULL) {
      $state = $row["State"];
    } else {
      $state = "California";
    }

    $stmt->closeCursor();

    if (isset($_POST["enter_user"])) {
      if ($_POST["username"] != "") {
        $username = $_POST["username"];
      }
      if ($_POST["email"] != "") {
        $email = $_POST["email"];
      }
      if ($_POST["password"] != "") {
        $password = $_POST["password"];
      }
      if ($_POST["position"] != "") {
        $position = $_POST["position"];
      }
      if ($_POST["fn"] != "") {
        $fn = $_POST["fn"];
      }
      if ($_POST["ln"] != "") {
        $ln = $_POST["ln"];
      }

      $userStmt = $con->prepare("UPDATE USER SET Username = ?, Email = ?, Password = ?, Position = ?, FirstName = ?, LastName = ? WHERE Username = ?");
      $userStmt->execute(array($username, $email, $password, $position, $fn, $ln, $_SESSION["username"]));
      $userStmt->closeCursor();

      $_SESSION["username"] = $username;
    }

    if (isset($_POST["enter_address"])) {
      if ($_POST["address"] != "") {
        $address = $_POST["address"];
      }
      if ($_POST["city"] != "") {
        $city = $_POST["city"];
      }
      if ($_POST["state"] != "") {
        $state = $_POST["state"];
      }

      $addrStmt = $con->prepare("UPDATE USER SET Address = ?, City = ?, State = ? WHERE Username = ?");
      $addrStmt->execute(array($address, $city, $state, $_SESSION["username"]));
      $addrStmt->closeCursor();
    }
  ?>
  <div id="wrapper">
      <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0" style="--bs-success-rgb: 28,200,138;background: var(--bs-green);--bs-primary: #4e73df;--bs-primary-rgb: 78,115,223;color: var(--bs-white);">
          <div class="container-fluid d-flex flex-column p-0"><a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                  <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-exclamation"></i></div>
                  <div class="sidebar-brand-text mx-3"><span>Task-!t</span></div>
              </a>
              <hr class="sidebar-divider my-0">
              <ul class="navbar-nav text-light" id="accordionSidebar">
                  <li class="nav-item"><a class="nav-link" href="dashboard.php" style="color: var(--bs-accordion-bg);"><i class="fas fa-tachometer-alt" style="color: var(--bs-accordion-bg);"></i><span>Dashboard</span></a></li>
                  <li class="nav-item"><a class="nav-link" href="messages.html" style="color: var(--bs-accordion-bg);"><i class="fas fa-envelope" style="color: var(--bs-accordion-bg);"></i><span style="color: var(--bs-accordion-bg);">Messages</span></a></li>
                  <li class="nav-item"><a class="nav-link" href="team.html"><i class="fas fa-people-carry" style="color: var(--bs-accordion-bg);"></i><span style="color: var(--bs-accordion-bg);">Team Members</span></a>
                  <a class="nav-link active" href="profile.php" style="color: var(--bs-accordion-bg);"><i class="fas fa-user" style="color: var(--bs-accordion-bg);"></i><span style="color: var(--bs-accordion-bg);">Profile</span></a></li>
              </ul>
              <div class="text-center d-none d-md-inline"><button class="btn d-xxl-flex justify-content-xxl-center align-items-xxl-center rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
          </div>
      </nav>
      <div class="d-flex flex-column" id="content-wrapper">
          <div id="content">
              <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                  <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                      <h3 class="text-dark mb-1">Profile</h3>
                      <ul class="navbar-nav flex-nowrap ms-auto">
                          <li class="nav-item dropdown d-sm-none no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"></a>
                              <div class="dropdown-menu dropdown-menu-end p-3 animated--grow-in" aria-labelledby="searchDropdown">
                                  <form class="me-auto navbar-search w-100">
                                      <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for ...">
                                          <div class="input-group-append"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                                      </div>
                                  </form>
                              </div>
                          </li>
                          <li class="nav-item dropdown no-arrow mx-1">
                              <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">
                                      <div class="d-none d-sm-block topbar-divider"></div><span class="badge bg-danger badge-counter">3+</span><i class="fas fa-bell fa-fw"></i>
                                  </a>
                                  <div class="dropdown-menu dropdown-menu-end dropdown-list animated--grow-in">
                                      <h6 class="dropdown-header">alerts center</h6><a class="dropdown-item d-flex align-items-center" href="#">
                                          <div class="me-3">
                                              <div class="bg-primary icon-circle"><i class="fas fa-file-alt text-white"></i></div>
                                          </div>
                                          <div><span class="small text-gray-500">December 12, 2019</span>
                                              <p>A new monthly report is ready to download!</p>
                                          </div>
                                      </a><a class="dropdown-item d-flex align-items-center" href="#">
                                          <div class="me-3">
                                              <div class="bg-success icon-circle"><i class="fas fa-donate text-white"></i></div>
                                          </div>
                                          <div><span class="small text-gray-500">December 7, 2019</span>
                                              <p>$290.29 has been deposited into your account!</p>
                                          </div>
                                      </a><a class="dropdown-item d-flex align-items-center" href="#">
                                          <div class="me-3">
                                              <div class="bg-warning icon-circle"><i class="fas fa-exclamation-triangle text-white"></i></div>
                                          </div>
                                          <div><span class="small text-gray-500">December 2, 2019</span>
                                              <p>Spending Alert: We've noticed unusually high spending for your account.</p>
                                          </div>
                                      </a><a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                                  </div>
                              </div>
                          </li>
                          <li class="nav-item dropdown no-arrow mx-1">
                              <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="badge bg-danger badge-counter">7</span><i class="fas fa-envelope fa-fw"></i></a>
                                  <div class="dropdown-menu dropdown-menu-end dropdown-list animated--grow-in">
                                      <h6 class="dropdown-header">alerts center</h6><a class="dropdown-item d-flex align-items-center" href="#">
                                          <div class="dropdown-list-image me-3"><img class="rounded-circle" src="assets/img/avatars/avatar4.jpeg">
                                              <div class="bg-success status-indicator"></div>
                                          </div>
                                          <div class="fw-bold">
                                              <div class="text-truncate"><span>Hi there! I am wondering if you can help me with a problem I've been having.</span></div>
                                              <p class="small text-gray-500 mb-0">Emily Fowler - 58m</p>
                                          </div>
                                      </a><a class="dropdown-item d-flex align-items-center" href="#">
                                          <div class="dropdown-list-image me-3"><img class="rounded-circle" src="assets/img/avatars/avatar2.jpeg">
                                              <div class="status-indicator"></div>
                                          </div>
                                          <div class="fw-bold">
                                              <div class="text-truncate"><span>I have the photos that you ordered last month!</span></div>
                                              <p class="small text-gray-500 mb-0">Jae Chun - 1d</p>
                                          </div>
                                      </a><a class="dropdown-item d-flex align-items-center" href="#">
                                          <div class="dropdown-list-image me-3"><img class="rounded-circle" src="assets/img/avatars/avatar3.jpeg">
                                              <div class="bg-warning status-indicator"></div>
                                          </div>
                                          <div class="fw-bold">
                                              <div class="text-truncate"><span>Last month's report looks great, I am very happy with the progress so far, keep up the good work!</span></div>
                                              <p class="small text-gray-500 mb-0">Morgan Alvarez - 2d</p>
                                          </div>
                                      </a><a class="dropdown-item d-flex align-items-center" href="#">
                                          <div class="dropdown-list-image me-3"><img class="rounded-circle" src="assets/img/avatars/avatar5.jpeg">
                                              <div class="bg-success status-indicator"></div>
                                          </div>
                                          <div class="fw-bold">
                                              <div class="text-truncate"><span>Am I a good boy? The reason I ask is because someone told me that people say this to all dogs, even if they aren't good...</span></div>
                                              <p class="small text-gray-500 mb-0">Chicken the Dog · 2w</p>
                                          </div>
                                      </a><a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                                  </div>
                              </div>
                              <div class="shadow dropdown-list dropdown-menu dropdown-menu-end" aria-labelledby="alertsDropdown"></div>
                          </li>
                          <li class="nav-item dropdown no-arrow">
                              <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="d-none d-lg-inline me-2 text-gray-600 small"><?php print $fn." ".$ln ?></span><img class="border rounded-circle img-profile" src="assets/img/dogs/image2.jpeg"></a>
                                  <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in"><a class="dropdown-item" href="profile.php"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Profile</a><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a></div>
                              </div>
                          </li>
                      </ul>
                  </div>
              </nav>
              <div class="container-fluid">
                  <h3 class="text-dark mb-4"><?php print $fn." ".$ln ?></h3>
                  <div class="row mb-3">
                      <div class="col-lg-4">
                          <div class="card mb-3">
                              <div class="card-body text-center shadow"><img class="rounded-circle mb-3 mt-4" src="assets/img/dogs/image2.jpeg" width="160" height="160">
                                  <div class="mb-3"><button class="btn btn-primary btn-sm" type="button">Change Photo</button></div>
                              </div>
                          </div>
                      </div>
                      <div class="col-lg-8">
                          <div class="row mb-3 d-none">
                              <div class="col">
                                  <div class="card text-white bg-primary shadow">
                                      <div class="card-body">
                                          <div class="row mb-2">
                                              <div class="col">
                                                  <p class="m-0">Peformance</p>
                                                  <p class="m-0"><strong>65.2%</strong></p>
                                              </div>
                                              <div class="col-auto"><i class="fas fa-rocket fa-2x"></i></div>
                                          </div>
                                          <p class="text-white-50 small m-0"><i class="fas fa-arrow-up"></i>&nbsp;5% since last month</p>
                                      </div>
                                  </div>
                              </div>
                              <div class="col">
                                  <div class="card text-white bg-success shadow">
                                      <div class="card-body">
                                          <div class="row mb-2">
                                              <div class="col">
                                                  <p class="m-0">Peformance</p>
                                                  <p class="m-0"><strong>65.2%</strong></p>
                                              </div>
                                              <div class="col-auto"><i class="fas fa-rocket fa-2x"></i></div>
                                          </div>
                                          <p class="text-white-50 small m-0"><i class="fas fa-arrow-up"></i>&nbsp;5% since last month</p>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col">
                                  <div class="card shadow mb-3">
                                      <div class="card-header py-3">
                                          <p class="text-primary m-0 fw-bold">User Settings</p>
                                      </div>
                                      <div class="card-body">
                                          <!-- user settings form -->
                                          <form action="profile.php" method="post">
                                              <div class="row">
                                                  <div class="col">
                                                      <div class="mb-3"><label class="form-label" for="username"><strong>Username</strong></label><input class="form-control" type="text" id="username" placeholder="<?php print $username ?>" name="username"></div>
                                                  </div>
                                                  <div class="col">
                                                      <div class="mb-3"><label class="form-label" for="email"><strong>Email Address</strong></label><input class="form-control" type="email" id="email" placeholder="<?php print $email ?>" name="email"></div>
                                                  </div>
                                              </div>
                                              <div class="row">
                                                  <div class="col">
                                                      <div class="mb-3"><label class="form-label" for="password"><strong>Password</strong><br></label><input class="form-control" type="password" id="password" name="password"></div>
                                                  </div>
                                                  <div class="col">
                                                      <div class="mb-3"><label class="form-label" for="position"><strong>Position</strong><br></label><input class="form-control" type="text" id="position" placeholder="<?php print $position ?>" name="position"></div>
                                                  </div>
                                              </div>
                                              <div class="row">
                                                  <div class="col">
                                                      <div class="mb-3"><label class="form-label" for="fn"><strong>First Name</strong></label><input class="form-control" type="text" id="fn" placeholder="<?php print $fn ?>" name="fn"></div>
                                                  </div>
                                                  <div class="col">
                                                      <div class="mb-3"><label class="form-label" for="ln"><strong>Last Name</strong></label><input class="form-control" type="text" id="ln" placeholder="<?php print $ln ?>" name="ln"></div>
                                                  </div>
                                              </div>
                                              <div class="mb-3"><button class="btn btn-primary btn-sm" name="enter_user" type="submit">Save Settings</button></div>
                                          </form>
                                      </div>
                                  </div>
                                  <div class="card shadow">
                                      <div class="card-header py-3">
                                          <p class="text-primary m-0 fw-bold">Contact Settings</p>
                                      </div>
                                      <div class="card-body">
                                          <!-- address form -->
                                          <form action="profile.php" method="post">
                                              <div class="mb-3"><label class="form-label" for="address"><strong>Address</strong></label><input class="form-control" type="text" id="address" placeholder="<?php print $address ?>" name="address"></div>
                                              <div class="row">
                                                  <div class="col">
                                                      <div class="mb-3"><label class="form-label" for="city"><strong>City</strong></label><input class="form-control" type="text" id="city" placeholder="<?php print $city ?>" name="city"></div>
                                                  </div>
                                                  <div class="col">
                                                      <div class="mb-3"><label class="form-label" for="state"><strong>State</strong></label><input class="form-control" type="text" id="state" placeholder="<?php print $state ?>" name="state"></div>
                                                  </div>
                                              </div>
                                              <div class="mb-3"><button class="btn btn-primary btn-sm" name="enter_address" type="submit">Save&nbsp;Settings</button></div>
                                          </form>
                                      </div>
                                  </div>
                              </div>
                          </div>

                        <div class="row">
                            <div class="col">
                                <form action="profile.php" method="post">
                                    <div class="mb-3"><button class="btn btn-primary btn-sm float-end" style="background: var(--bs-danger);" name="delete_account" type="submit">Deactivate Account</button></div>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <?php 
                                    if ($_SESSION['uid'] == 1) {
                                        print '
                                        <form action="profile.php" method="post">
                                            <div class="mb-3"><a class="btn btn-primary btn-sm float-end" style="background: var(--bs-success);" name="download_db" href="callandi_db.sql">Download Database</a></div>
                                        </form>';
                                    }
                                ?>
                            </div>
                        </div>
                      </div>
                  </div>
              </div>
          </div>
          <footer class="bg-white sticky-footer">
              <div class="container my-auto">
                  <div class="text-center my-auto copyright"><span>Copyright © Brand 2022</span></div>
              </div>
          </footer>
      </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
  </div>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/js/theme.js"></script>
</body>

</html>
