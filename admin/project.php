<?php  session_start(); //this must be the very first line on the php page, to register this page to use session variables
	$_SESSION['timeout'] = time(); //record the time at the user login

	require_once "../dbconnect.php";

    if (isset($_GET['name'])) {
        $_SESSION['projectName'] = $_GET['name'];
        $_SESSION['projectID'] = $_GET['id'];
    }
    //$stmt = $con->prepare("select * from PROJECT, PROJECT_ACCESS where PROJECT_ACCESS.UserID = ? AND PROJECT.ProjectID = PROJECT_ACCESS.ProjectID");
    //$stmt->execute(array($_SESSION['uid']));

    $fn = "";
    $ln = "";

    $stmt = $con->prepare("SELECT * FROM USER WHERE Username = ?");
    $stmt->execute(array($_SESSION['username']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $fn = $row["FirstName"];
    $ln = $row["LastName"];

    $stmt->closeCursor();

    if (isset($_POST["release"])) {
            Header ("Location:createRelease.php");
    }

    $releaseStmt = $con->prepare("SELECT RELEASE_CONTAINER.* FROM PROJECT, RELEASE_CONTAINER WHERE PROJECT.ProjectID = ? AND PROJECT.ProjectID = RELEASE_CONTAINER.ProjectID");
    $releaseStmt->execute(array($_SESSION['projectID']));
    while ($releaseRow = $releaseStmt->fetch(PDO::FETCH_ASSOC)) {
        $currentReleaseName = $releaseRow['Name'];
        $currentReleaseID = $releaseRow['ReleaseID'];
        $currentReleaseActive = $releaseRow['Active'];

        if (isset($_POST[$currentReleaseID])) {
                if ($currentReleaseID == $_GET['releaseID']) {
                    $_SESSION['currentReleaseID'] = $_GET['releaseID'];
                    Header ("Location:createStack.php");
                }
            }

        $stackStmt = $con->prepare("SELECT STACK.* FROM RELEASE_CONTAINER, STACK WHERE RELEASE_CONTAINER.ReleaseID = ? AND RELEASE_CONTAINER.ReleaseID = STACK.ReleaseContainerID");
        $stackStmt->execute(array($currentReleaseID));
        while ($stackRow = $stackStmt->fetch(PDO::FETCH_ASSOC)){
            $currentStackName = $stackRow['StackName'];
            $currentStackID = $stackRow['StackID'];
            $currentStackActive = $stackRow['Active'];

            if (isset($_POST[$currentStackID])) {
                if ($currentStackID == $_GET['stackID']) {
                    $_SESSION['currentStackID'] = $_GET['stackID'];
                    Header ("Location:createCard.php");
                }
            }

            $cardStmt = $con->prepare("SELECT CARD.* FROM CARD, STACK WHERE STACK.StackID = ? AND STACK.StackID = CARD.StackID");
            $cardStmt->execute(array($currentStackID));
            while ($cardRow = $cardStmt->fetch(PDO::FETCH_ASSOC)){
                $currentCardName = $cardRow['CardName'];
                $currentCardID = $cardRow['CardID'];
                $currentCardActive = $cardRow['Active'];

                if (isset($_POST[$currentCardID])) {
                    if ($currentCardID == $_GET['cardID']) {
                        $_SESSION['currentCardID'] = $_GET['cardID'];
                        $_SESSION['currentCardName'] = $currentCardName;
                        Header ("Location:task.php");
                    }
                }
            }
            $cardStmt->closeCursor();
        }
        $stackStmt->closeCursor();
    }
    $releaseStmt->closeCursor();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Project</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/Edit-Form.css">
    <link rel="stylesheet" href="assets/css/taskit.css">
</head>

<body id="page-top">
    <div id="wrapper">

        <!-- left navigational panel -->
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
                    <li class="nav-item"><a class="nav-link" href="profile.php" style="color: var(--bs-accordion-bg);"><i class="fas fa-user" style="color: var(--bs-accordion-bg);"></i><span style="color: var(--bs-accordion-bg);">Profile</span></a></li>
                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn d-xxl-flex justify-content-xxl-center align-items-xxl-center rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>

        <!-- content -->
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content" style="--bs-success: #1cc88a;--bs-success-rgb: 28,200,138;position: relative;display: inline-block;">

                <!-- top nav bar -->
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <h3 class="text-dark mb-1"><?php print $_SESSION['projectName'] ?></h3>
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
                            
                            <!-- notifications -->
                            <li class="nav-item dropdown no-arrow mx-1">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="d-none d-lg-inline me-2 text-gray-600 small">People:&nbsp;</span><img class="border rounded-circle img-profile" src="assets/img/avatars/avatar3.jpeg" style="margin-right: 5px;"><img class="border rounded-circle img-profile" src="assets/img/avatars/avatar2.jpeg" style="margin-right: 5px;">
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
                                    <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in"><a class="dropdown-item" href="profile.php"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Profile</a><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>

                <!-- project workspace -->
                <div class="container-fluid text-nowrap" style="display: inline-flex;overflow: auto;height: 90%;">

                    <?php

                        $releaseStmt = $con->prepare("SELECT RELEASE_CONTAINER.* FROM PROJECT, RELEASE_CONTAINER WHERE PROJECT.ProjectID = ? AND PROJECT.ProjectID = RELEASE_CONTAINER.ProjectID");
                        $releaseStmt->execute(array($_SESSION['projectID']));

                        while ($releaseRow = $releaseStmt->fetch(PDO::FETCH_ASSOC)) {
                            $currentReleaseName = $releaseRow['Name'];
                            $currentReleaseID = $releaseRow['ReleaseID'];
                            $currentReleaseActive = $releaseRow['Active'];

                            if ($currentReleaseActive == 1) {
                                print '

                                <!-- releases -->
                                <div class="card d-xxl-flex align-items-xxl-start" style="max-height: 100%; margin-right: 15px;display: inline-flex;min-width: 265px;overflow: auto;">
                                    <div class="card-header" style="background: var(--bs-gray-200); width: 100%;">
                                        <h5 class="mb-0">'.$currentReleaseName.'</h5>

                                        <form method="post" action="project.php?releaseID='.$currentReleaseID.'">
                                            <button type="submit" name="'.$currentReleaseID.'" class="btn float-end">
                                                <i class="fas fa-plus-square d-xxl-flex justify-content-xxl-end"></i>
                                            </button>
                                        </form>

                                    </div>

                                    <!-- stacks -->
                                    ';
                                    $stackStmt = $con->prepare("SELECT STACK.* FROM RELEASE_CONTAINER, STACK WHERE RELEASE_CONTAINER.ReleaseID = ? AND RELEASE_CONTAINER.ReleaseID = STACK.ReleaseContainerID");
                                    $stackStmt->execute(array($currentReleaseID));
                                    
                                    while ($stackRow = $stackStmt->fetch(PDO::FETCH_ASSOC)){
                                        $currentStackName = $stackRow['StackName'];
                                        $currentStackID = $stackRow['StackID'];
                                        $currentStackActive = $stackRow['Active'];
                                        
                                        if ($currentStackActive == 1) {
                                            print '
                                                <div class="card-body d-xxl-flex align-items-xxl-start">
                                                <div class="card" style="min-height: 100%;display: inline-block;background: rgb(248,249,252);width: 230px;margin-right: 15px;min-width: 230px;">
                                                    <div class="card-header" style="height: 90px;">
                                                        <h5 class="mb-0">'.$currentStackName.'</h5>

                                                        <form method="post" action="project.php?releaseID='.$currentReleaseID.'&stackID='.$currentStackID.'">
                                                            <button  type="submit" name = "'.$currentStackID.'" class="btn float-end">
                                                                <i class="far fa-plus-square d-xxl-flex justify-content-xxl-end"></i>
                                                            </button>
                                                        </form>

                                                    </div>';

                                                    $cardStmt = $con->prepare("SELECT CARD.* FROM STACK, CARD WHERE STACK.StackID = ? AND STACK.StackID = CARD.StackID;");
                                                    $cardStmt->execute(array($currentStackID));
                                    
                                                    while ($cardRow = $cardStmt->fetch(PDO::FETCH_ASSOC)){
                                                        $currentCardName = $cardRow['CardName'];
                                                        $currentCardID = $cardRow['CardID'];
                                                        $currentCardColor = $cardRow['Color'];
                                                        $currentCardActive = $cardRow['Active'];
                                                        
                                                        if ($currentCardActive == 1) {
                                                            print '
                                                            <!-- cards -->
                                                            <div class="card-body" style="background: rgb(248,249,252);">
                                                                <div class="card text-break" style="background: '.$currentCardColor.';color: var(--bs-card-bg);margin-bottom: 10px;">
                                                                    <div class="card-body" style="width: 153px;">
                                                                        <h4 class="card-title" style="font-size: 20px;">'.$currentCardName.'</h4>
                                                                        <h6 class="text-muted card-subtitle mb-2"></h6>
                                                                        <p class="card-text"></p>
                                                                    </div>
                                                                    <form method="post" action="project.php?releaseID='.$currentReleaseID.'&stackID='.$currentStackID.'&cardID='.$currentCardID.'">
                                                                        <button  type="submit" name = "'.$currentCardID.'" class="btn float-end">
                                                                            <i class="far fa-list-alt d-xxl-flex justify-content-xxl-end" style="font-size: 25px;margin-left: 100px;padding-bottom: 15px;margin-bottom: 0px;margin-right: 15px;padding-left: 0px;color: var(--bs-card-bg);"></i>
                                                                        </button>
                                                                    </form>

                                                                    <!--<a href="task.php" style="color: var(--bs-card-bg);"><i class="far fa-list-alt d-xxl-flex justify-content-xxl-end" style="font-size: 25px;margin-left: 100px;padding-bottom: 15px;margin-bottom: 0px;margin-right: 15px;padding-left: 0px;color: var(--bs-card-bg);"></i></a>-->
                                                                </div>
                                                            </div>';
                                                        }
                                                    }
                                                    $cardStmt->closeCursor();
                                                    print '
                                                </div>
                                            </div>'; // end print stack
                                        } // end if
                                    } // end while
                                    $stackStmt->closeCursor();
                                    print '
                                </div>'; // end print release
                            } // end if
                        } // end while
                        $releaseStmt->closeCursor();
                    ?>

                    <!-- add release button -->
                    <div class="d-xxl-flex align-items-xxl-center">
                        <form method="post" action="project.php">
                            <button type="submit" name = "release" class="btn btn-primary btn-lg border rounded-circle d-xxl-flex justify-content-xxl-center align-items-xxl-center" style="height: 57px;background: var(--bs-green);">
                                <i class="fas fa-plus-circle" style="font-size: 23px;"></i>
                            </button>
                        </form>
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
