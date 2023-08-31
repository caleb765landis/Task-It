<?php session_start(); //this must be the very first line on the php page, to register this page to use session variables

	//if this is a page that requires login always perform this session verification
	//require_once "../util/sessionVerify.php";
	require_once "../dbconnect.php";

    $fn = "";
    $ln = "";

    $stmt = $con->prepare("SELECT * FROM USER WHERE Username = ?");
    $stmt->execute(array($_SESSION['username']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $fn = $row["FirstName"];
    $ln = $row["LastName"];

    $stmt->closeCursor();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Task</title>
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
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button><a class="btn btn-primary" role="button" style="margin-right: 15px;background: var(--bs-green);border-color: var(--bs-border-color);" href="project.php"><i class="fas fa-arrow-left"></i>&nbsp; Back to Project</a>
                        <h3 class="text-dark d-xxl-flex mb-1" style="margin-top: 5px;">Task View</h3>
                        <ul class="navbar-nav flex-nowrap ms-auto">
                            <li class="nav-item dropdown d-sm-none no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><i class="fas fa-search"></i></a>
                                <div class="dropdown-menu dropdown-menu-end p-3 animated--grow-in" aria-labelledby="searchDropdown">
                                    <form class="me-auto navbar-search w-100">
                                        <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for ...">
                                            <div class="input-group-append"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                                        </div>
                                    </form>
                                </div>
                            </li>
                            <li class="nav-item dropdown no-arrow mx-1">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="badge bg-danger badge-counter">3+</span><i class="fas fa-bell fa-fw"></i></a>
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
                            <div class="d-none d-sm-block topbar-divider"></div>
                            <li class="nav-item dropdown no-arrow">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="d-none d-lg-inline me-2 text-gray-600 small"><?php print $fn." ".$ln ?></span><img class="border rounded-circle img-profile" src="assets/img/dogs/image2.jpeg"></a>
                                    <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in"><a class="dropdown-item" href="profile.html"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Profile</a><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="container">
                    <div class="col">
                        <div class="row" style="margin-bottom: 20px;">
                            <div class="col">
                                <h3 class="text-dark mb-1" style="margin-bottom: 0px;padding-bottom: 15px;"><?php print $_SESSION['currentCardName']?>&nbsp;
                                <button class="btn btn-primary float-end" type="button" style="background: var(--bs-success);">Save</button><button class="btn btn-primary float-end" type="button" style="margin-right: 15px;background: var(--bs-danger);">Delete</button></h3>
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="text-primary m-0 fw-bold">Card Location</h6>
                                    </div>
                                    <div class="card-body d-xxl-flex justify-content-xxl-center" style="display: inline-flex;"><label class="form-label">Release<select style="margin-left: 10px;margin-right: 20px;">
                                                <optgroup label="Release">
                                                    <option value="13">Documentation</option>
                                                    <option value="12" selected="">Current Release</option>
                                                    <option value="14">Release 1.2</option>
                                                </optgroup>
                                            </select></label><label class="form-label">Stack<select style="margin-left: 10px;margin-right: 20px;">
                                                <optgroup label="Stack">
                                                    <option value="12">Blocked</option>
                                                    <option value="13" selected="">In Progress</option>
                                                    <option value="14">Done</option>
                                                </optgroup>
                                            </select></label><label class="form-label d-xxl-flex align-items-xxl-center">Card Color<input type="color" style="padding-left: 0px;margin-left: 10px;margin-right: 20px;background: var(--bs-border-color-translucent);color: var(--bs-border-color-translucent);" value="#4e73e0"></label></div>
                                </div>
                            </div>
                        </div>

<!--
                        <div class="row">
                            <div class="col" style="margin-bottom: 20px;">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="text-primary fw-bold m-0">To Do List<i class="far fa-plus-square float-end" style="font-size: 20px;margin-right: 7px;"></i></h6>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <div class="row align-items-center no-gutters">
                                                <div class="col me-2">
                                                    <h6 class="mb-0"><strong>Start Task</strong></h6>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-4"><label class="form-check-label" for="formCheck-4"></label></div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row align-items-center no-gutters">
                                                <div class="col me-2">
                                                    <h6 class="mb-0"><strong>Work on Task</strong></h6>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-5"><label class="form-check-label" for="formCheck-5"></label></div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row align-items-center no-gutters">
                                                <div class="col me-2">
                                                    <h6 class="mb-0"><strong>Finish Task</strong></h6>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-6"><label class="form-check-label" for="formCheck-6"></label></div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="position: relative;display: block;">
                            <div class="col-xxl-12">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="text-primary m-0 fw-bold">Discussion</h6>
                                    </div>


  <!-- Chat Box
  <div>
   <div class="px-4 py-5 chat-box bg-white column">
     <!-- Sender Message
     <div class="media w-50 mb-3"><img src="https://bootstrapious.com/i/snippets/sn-chat/avatar.svg" alt="user" width="50" class="rounded-circle">
       <div class="media-body ml-3 row">
         <div class="bg-light rounded py-2 px-3 mb-2">
           <p class="text-small mb-0 text-muted">Test which is a new approach all solutions</p>
         </div>
         <p class="small text-muted">12:00 PM | Aug 13</p>
       </div>
     </div>

     <!-- Reciever Message
     <div class="pull-right w-100">
       <div class="media w-50 ml-auto mb-3 pull-right">
         <div class="media-body">
           <div class="bg-primary rounded py-2 px-3 mb-2">
             <p class="text-small mb-0 text-white">Test which is a new approach to have all solutions</p>
           </div>
           <p class="small text-muted pull-right">12:00 PM | Aug 13</p>
         </div>
       </div>
     </div>

     <!-- Sender Message
     <div class="media w-50 mb-3"><img src="https://bootstrapious.com/i/snippets/sn-chat/avatar.svg" alt="user" width="50" class="rounded-circle">
       <div class="media-body ml-3 row">
         <div class="bg-light rounded py-2 px-3 mb-2">
           <p class="text-small mb-0 text-muted">Test, which is a new approach to have</p>
         </div>
         <p class="small text-muted">12:00 PM | Aug 13</p>
       </div>
     </div>

     <!-- Reciever Message
     <div class="pull-right w-100">
       <div class="media w-50 ml-auto mb-3 pull-right">
         <div class="media-body">
           <div class="bg-primary rounded py-2 px-3 mb-2">
             <p class="text-small mb-0 text-white">Apollo University, Delhi, India Test</p>
           </div>
           <p class="small text-muted pull-right">12:00 PM | Aug 13</p>
         </div>
       </div>
      </div>

     <!-- Sender Message
     <div class="media w-50 mb-3"><img src="https://bootstrapious.com/i/snippets/sn-chat/avatar.svg" alt="user" width="50" class="rounded-circle">
       <div class="media-body ml-3">
         <div class="bg-light rounded py-2 px-3 mb-2">
           <p class="text-small mb-0 text-muted">Test, which is a new approach</p>
         </div>
         <p class="small text-muted">12:00 PM | Aug 13</p>
       </div>
     </div>

     <!-- Reciever Message
     <div class="pull-right w-100">
       <div class="media w-50 ml-auto mb-3 pull-right">
         <div class="media-body">
           <div class="bg-primary rounded py-2 px-3 mb-2">
             <p class="text-small mb-0 text-white">Apollo University, Delhi, India Test</p>
           </div>
           <p class="small text-muted pull-right">12:00 PM | Aug 13</p>
         </div>
       </div>
      </div>

   </div>

   <!-- Typing area
   <form action="#" class="bg-light">
     <div class="input-group">
       <input type="text" placeholder="Type a message" aria-describedby="button-addon2" class="form-control rounded-0 border-0 py-4 bg-light" style="height: 50px">
       <div class="input-group-append">
         <button id="button-addon2" type="submit" class="btn btn-link"> <i class="fa fa-paper-plane"></i></button>
       </div>
     </div>
   </form>
  </div>
</div>
</div>
</div>
-->
                        <div class="row" style="margin-bottom: 20px;">
                            <div class="col">
                                <div class="card shadow">
                                    <div class="card-header py-3">
                                        <p class="text-primary m-0 fw-bold">Team Members Assigned to This Task<i class="far fa-edit float-end" style="font-size: 20px;"></i></p>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 text-nowrap">
                                                <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable"><label class="form-label">Show&nbsp;<select class="d-inline-block form-select form-select-sm">
                                                            <option value="10" selected="">10</option>
                                                            <option value="25">25</option>
                                                            <option value="50">50</option>
                                                            <option value="100">100</option>
                                                        </select>&nbsp;</label></div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="text-md-end dataTables_filter" id="dataTable_filter"><label class="form-label"></label></div>
                                            </div>
                                        </div>
                                        <div class="table-responsive table mt-2" id="dataTable-1" role="grid" aria-describedby="dataTable_info">
                                            <table class="table my-0" id="dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Position</th>
                                                        <th>Office</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        $teamStmt = $con->prepare('SELECT USER.FirstName, USER.LastName, USER.Position, USER.Username FROM USER, ASSIGNMENT WHERE USER.UserID = ASSIGNMENT.UserID AND ASSIGNMENT.CardID = ?;');
                                                        $teamStmt->execute(array($_SESSION['currentCardID']));

                                                        while($listRow = $teamStmt->fetch(PDO::FETCH_ASSOC)) {
                                                            print '<tr><td><img class="rounded-circle me-2" width="30" height="30" src="assets/img/dogs/image2.jpeg">'.$listRow['FirstName']." ".$listRow['LastName']."</td>";
                                                            print '<td>'.$listRow['Position'].'</td>';
                                                            print '<td>'.$listRow['Username'].'</td></tr>';
                                                        }
                                                        $teamStmt->closeCursor();
                                                    ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td><strong>Name</strong></td>
                                                        <td><strong>Position</strong></td>
                                                        <td><strong>Office</strong></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 align-self-center">
                                                <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Showing 1 to 10 of 27</p>
                                            </div>
                                            <div class="col-md-6">
                                                <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                                                    <ul class="pagination">
                                                        <li class="page-item disabled"><a class="page-link" aria-label="Previous" href="#"><span aria-hidden="true">«</span></a></li>
                                                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                                        <li class="page-item"><a class="page-link" aria-label="Next" href="#"><span aria-hidden="true">»</span></a></li>
                                                    </ul>
                                                </nav>
                                            </div>
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