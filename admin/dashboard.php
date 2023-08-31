<?php  session_start(); //this must be the very first line on the php page, to register this page to use session variables
	$_SESSION['timeout'] = time(); //record the time at the user login

	require_once "../dbconnect.php";

  $_SESSION['memberArr'] = array($_SESSION['username']);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Dashboard</title>
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
        $fn = "";
        $ln = "";
    
        $stmt = $con->prepare("SELECT * FROM USER WHERE Username = ?");
        $stmt->execute(array($_SESSION['username']));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $fn = $row["FirstName"];
        $ln = $row["LastName"];
    
        $stmt->closeCursor();

        $taskStmt = $con->prepare("SELECT COUNT(*) AS c FROM ASSIGNMENT WHERE UserID = ?");
		$taskStmt->execute(array($_SESSION['uid']));
		$countRow = $taskStmt->fetch(PDO::FETCH_OBJ);
		$taskCount = $countRow->c;
		$taskStmt->closeCursor();

        $projectStmt = $con->prepare("SELECT COUNT(*) AS c FROM PROJECT_ACCESS WHERE UserID = ?");
		$projectStmt->execute(array($_SESSION['uid']));
		$countRow = $projectStmt->fetch(PDO::FETCH_OBJ);
		$projectCount = $countRow->c;
		$projectStmt->closeCursor();

        $teamStmt = $con->prepare("SELECT COUNT(*) AS c FROM USER");
		$teamStmt->execute();
		$countRow = $teamStmt->fetch(PDO::FETCH_OBJ);
		$teamCount = $countRow->c;
		$teamStmt->closeCursor();
    ?>



    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0" style="--bs-success-rgb: 28,200,138;background: var(--bs-green);--bs-primary: #4e73df;--bs-primary-rgb: 78,115,223;color: var(--bs-white);">
            <div class="container-fluid d-flex flex-column p-0"><a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                    <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-exclamation"></i></div>
                    <div class="sidebar-brand-text mx-3"><span>Task-!t</span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link active" href="dashboard.php" style="color: var(--bs-accordion-bg);"><i class="fas fa-tachometer-alt" style="color: var(--bs-accordion-bg);"></i><span>Dashboard</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="messages.html" style="color: var(--bs-accordion-bg);"><i class="fas fa-envelope" style="color: var(--bs-accordion-bg);"></i><span style="color: var(--bs-accordion-bg);">Messages</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="team.html"><i class="fas fa-people-carry" style="color: var(--bs-accordion-bg);"></i><span style="color: var(--bs-accordion-bg);">Team Members</span></a>
                    <a class="nav-link" href="profile.php" style="color: var(--bs-accordion-bg);"><i class="fas fa-user" style="color: var(--bs-accordion-bg);"></i><span style="color: var(--bs-accordion-bg);">Profile</span></a></li>
                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn d-xxl-flex justify-content-xxl-center align-items-xxl-center rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <h3 class="text-dark mb-1">Dashboard</h3>
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
                                    <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in"><a class="dropdown-item" href="profile.php"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Profile</a>
                                        <div class="dropdown-divider"></div><a class="dropdown-item" href="../login.php"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-info py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-info fw-bold text-xs mb-1"><span>Tasks</span></div>
                                            <div class="row g-0 align-items-center">
                                                <div class="col-auto">
                                                    <div class="text-dark fw-bold h5 mb-0 me-3"><span><?php print $taskCount ?></span></div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm">
                                                        <div class="progress-bar bg-info" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;"><span class="visually-hidden">50%</span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-clipboard-list fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-primary py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span>Projects</span></div>
                                            <div class="text-dark fw-bold h5 mb-0"><span><?php print $projectCount ?></span></div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-calendar fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-success py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-success fw-bold text-xs mb-1"><span>Team Members</span></div>
                                            <div class="text-dark fw-bold h5 mb-0"><span><?php print $teamCount ?></span></div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-people-carry fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-warning py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-warning fw-bold text-xs mb-1"><span>Pending Requests</span></div>
                                            <div class="text-dark fw-bold h5 mb-0"><span>18</span></div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-comments fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- your projects -->
                    <div class="row">
                        <div class="col">
                            <div class="card shadow mb-4" style="overflow: scroll; min-height: 254px">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="text-primary fw-bold m-0">Your Projects</h6>
                                    <div class="dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" type="button"><i class="fas fa-ellipsis-v text-gray-400"></i></button>
                                        <div class="dropdown-menu dropdown-menu-end shadow animated--fade-in">
                                            <h6 class="dropdown-header text-center"><strong>project options:</strong></h6><a class="dropdown-item" href="createProject.php">&nbsp;Create Project</a><a class="dropdown-item" href="endProject.php">&nbsp;End Project</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" style="display: inline-flex;">
                                    <!-- 
                                    <div class="card text-break" style="background: var(--bs-yellow);color: var(--bs-card-bg);margin-bottom: 10px;margin-right: 15px;min-width: 153px;">
                                        <div class="card-body" style="display: inline;width: 153px;">
                                            <h4 class="card-title" style="font-size: 20px;">Task-!t</h4>
                                            <h6 class="text-muted card-subtitle mb-2"></h6>
                                            <p class="card-text"></p>
                                        </div><a href="project.php" style="color: var(--bs-white);"><i class="fas fa-tasks text-end d-md-flex d-lg-flex d-xl-flex d-xxl-flex justify-content-md-end justify-content-lg-end justify-content-xl-end justify-content-xxl-end" style="font-size: 25px;position: sticky;margin-right: 14px;margin-bottom: 15px;"></i></a>
                                    </div>
                                    <div class="card text-break" style="background: var(--bs-green);color: var(--bs-card-bg);margin-bottom: 10px;margin-right: 15px;min-width: 153px;">
                                        <div class="card-body" style="display: inline;min-width: 153px;">
                                            <h4 class="card-title" style="font-size: 20px;">Presentation One</h4>
                                            <h6 class="text-muted card-subtitle mb-2"></h6>
                                            <p class="card-text"></p>
                                        </div><a href="project.php" style="color: var(--bs-white);"><i class="fas fa-tasks text-end d-md-flex d-lg-flex d-xl-flex d-xxl-flex justify-content-md-end justify-content-lg-end justify-content-xl-end justify-content-xxl-end" style="font-size: 25px;position: sticky;margin-right: 14px;margin-bottom: 15px;"></i></a>
                                    </div>
                                    <div class="card text-break" style="background: var(--bs-blue);color: var(--bs-card-bg);margin-bottom: 10px;margin-right: 15px;min-width: 153px;">
                                        <div class="card-body" style="width: 153px;display: inline;">
                                            <h4 class="card-title" style="font-size: 20px;">Peer Grading</h4>
                                            <h6 class="text-muted card-subtitle mb-2"></h6>
                                            <p class="card-text"></p>
                                        </div><a href="project.php" style="color: var(--bs-white);"><i class="fas fa-tasks text-end d-md-flex d-lg-flex d-xl-flex d-xxl-flex justify-content-md-end justify-content-lg-end justify-content-xl-end justify-content-xxl-end" style="font-size: 25px;position: sticky;margin-right: 14px;margin-bottom: 15px;"></i></a>
                                    </div>
                                    -->
                                    <?php
                                    $stmt = $con->prepare("select * from PROJECT, PROJECT_ACCESS where PROJECT_ACCESS.UserID = ? AND PROJECT.ProjectID = PROJECT_ACCESS.ProjectID AND PROJECT.Active = 1");
                                    $stmt->execute(array($_SESSION['uid']));

                                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                      print '<div class="card text-break" style="background:'.$row['Color'].';color: var(--bs-card-bg);margin-bottom: 10px;margin-right: 15px;min-width: 153px;">';
                                      print '<div class="card-body" style="width: 153px;display: inline;"><h4 class="card-title" style="font-size: 20px;">'.$row['Name'].'</h4>';
                                      print '<h6 class="text-muted card-subtitle mb-2"></h6><p class="card-text"></p></div><a href="project.php?name='.$row['Name'].'&id='.$row['ProjectID'].'" style="color: var(--bs-white);"><i class="fas fa-tasks text-end d-md-flex d-lg-flex d-xl-flex d-xxl-flex justify-content-md-end justify-content-lg-end justify-content-xl-end justify-content-xxl-end" style="font-size: 25px;position: sticky;margin-right: 14px;margin-bottom: 15px;"></i></a></div>';
                                    }

                                    $stmt->closeCursor();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="text-primary fw-bold m-0">To Do List<a class="float-end" href="#" style="padding-right: 7px;"><i class="far fa-plus-square float-end" style="font-size: 20px;"></i></a></h6>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <div class="row align-items-center no-gutters">
                                            <div class="col me-2">
                                                <h6 class="mb-0"><strong>Lunch meeting</strong></h6>
                                            </div>
                                            <div class="col-auto">
                                                <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-1"><label class="form-check-label" for="formCheck-1"></label></div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="row align-items-center no-gutters">
                                            <div class="col me-2">
                                                <h6 class="mb-0"><strong>Post-Lunch Meeting</strong></h6>
                                            </div>
                                            <div class="col-auto">
                                                <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-2"><label class="form-check-label" for="formCheck-2"></label></div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="row align-items-center no-gutters">
                                            <div class="col me-2">
                                                <h6 class="mb-0"><strong>Post-Post-Lunch meeting</strong></h6>
                                            </div>
                                            <div class="col-auto">
                                                <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-3"><label class="form-check-label" for="formCheck-3"></label></div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="text-primary fw-bold m-0">Project Completion</h6>
                                </div>
                                <div class="card-body">
                                    <h4 class="small fw-bold">Server migration<span class="float-end">20%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-danger" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%;"><span class="visually-hidden">20%</span></div>
                                    </div>
                                    <h4 class="small fw-bold">Sales tracking<span class="float-end">40%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-warning" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%;"><span class="visually-hidden">40%</span></div>
                                    </div>
                                    <h4 class="small fw-bold">Customer Database<span class="float-end">60%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-primary" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"><span class="visually-hidden">60%</span></div>
                                    </div>
                                    <h4 class="small fw-bold">Payout Details<span class="float-end">80%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-info" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%;"><span class="visually-hidden">80%</span></div>
                                    </div>
                                    <h4 class="small fw-bold">Account setup<span class="float-end">Complete!</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-success" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"><span class="visually-hidden">100%</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="col" style="margin-top: 0px;margin-bottom: 10px;"><span style="font-size: 25px;padding-top: 0px;">Task Organization Colors</span></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-4">
                                    <div class="card text-white bg-primary shadow">
                                        <div class="card-body">
                                            <p class="m-0">Primary</p>
                                            <p class="text-white-50 small m-0">#4e73df</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card text-white bg-success shadow">
                                        <div class="card-body">
                                            <p class="m-0">Success</p>
                                            <p class="text-white-50 small m-0">#1cc88a</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card text-white bg-info shadow">
                                        <div class="card-body">
                                            <p class="m-0">Info</p>
                                            <p class="text-white-50 small m-0">#36b9cc</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card text-white bg-warning shadow">
                                        <div class="card-body">
                                            <p class="m-0">Warning</p>
                                            <p class="text-white-50 small m-0">#f6c23e</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card text-white bg-danger shadow">
                                        <div class="card-body">
                                            <p class="m-0">Danger</p>
                                            <p class="text-white-50 small m-0">#e74a3b</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card text-white bg-secondary shadow">
                                        <div class="card-body">
                                            <p class="m-0">Secondary</p>
                                            <p class="text-white-50 small m-0">#858796</p>
                                        </div>
                                    </div>
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
