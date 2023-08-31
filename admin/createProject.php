<?php session_start(); //this must be the very first line on the php page, to register this page to use session variables

	//if this is a page that requires login always perform this session verification
	//require_once "../inc/sessionVerify.php";
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
    <title>Create Project</title>
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
		$memberMsg = "";
		$memberUsername = "";
		$name = "";
		$version = "";
		$color = "";

		echo $_SESSION['uid'];

		if (isset($_POST['enter_member'])) {
			$memberUsername = $_POST['memberUsername'];

			if ($memberUsername != "") {
				$memberStmt = $con->prepare("SELECT COUNT(Username) AS c FROM USER WHERE Username = ?");
				$memberStmt->execute(array($memberUsername));
				$countRow = $memberStmt->fetch(PDO::FETCH_OBJ);
				$count = $countRow->c;
				$memberStmt->closeCursor();

				if ($count == 1) {
					if (!in_array($memberUsername, $_SESSION['memberArr'])) {
						array_push($_SESSION['memberArr'], $memberUsername);
					} else {
						$memberMsg = "That user is already a part of this project.<br/>";
					} // end if in array
				} else {
					$memberMsg = "Username not found.<br/>";
				}
			} // end if memberUsername
		} // end if enter_member

        // create instance of project in the database
        // includes beginning release instance and beginning 3 stack instances
		if (isset($_POST['enter_project'])) {
			$name = $_POST['name'];
			$version = $_POST['version'];
			$version = strval($version);
			if (isset($_POST['color'])) {
				$color = $_POST['color'];
			}
			$startDate = "".date('Y-m-d');

			// add project to server
			$projectStmt = $con->prepare("insert into PROJECT values (null, ?, ?, ?, ?, 1);");
			$projectStmt->execute(array($name, $version, $color, $startDate));
            $projectStmt->closeCursor();

			// get project id of project we just created
			$lastStmt = $con->prepare("SELECT @@IDENTITY AS project_id FROM PROJECT;");
			$lastStmt->execute();
			$lastRow = $lastStmt->fetch(PDO::FETCH_OBJ);
            $lastStmt->closeCursor();
			$projectID = $lastRow->project_id;

			// give all users in memberArr access NOT AS ADMIN
			foreach($_SESSION['memberArr'] as $currentMember) {
				$arrStmt = $con->prepare("SELECT * FROM USER WHERE Username = ?;");
				$arrStmt->execute(array($currentMember));
				$arrRow = $arrStmt->fetch(PDO::FETCH_OBJ);

				$memberID = $arrRow->UserID;

				$accessStmt = $con->prepare("insert into PROJECT_ACCESS values (null, ?, ?, ?);");
				$accessStmt->execute(array($memberID, $projectID, 0));
			}
            $arrStmt->closeCursor();

			// give current user project access AS ADMIN
			$accessStmt = $con->prepare("UPDATE PROJECT_ACCESS SET AdminPrivilege = 1 WHERE UserID = ?;");
			$accessStmt->execute(array($_SESSION['uid']));
            $accessStmt->closeCursor();

            $releaseStmt = $con->prepare("INSERT into RELEASE_CONTAINER values (null, ?, ?, ?, ?, 1);");
            $releaseName = "Current Release - ".$version;
            $releaseStmt->execute(array($releaseName, $version, $projectID, $startDate));
            $releaseStmt->closeCursor();

            // get project id of project we just created
			$lastReleaseStmt = $con->prepare("SELECT @@IDENTITY AS release_id FROM RELEASE_CONTAINER;");
			$lastReleaseStmt->execute();
			$lastReleaseRow = $lastReleaseStmt->fetch(PDO::FETCH_OBJ);
            $lastReleaseStmt->closeCursor();
			$releaseID = $lastReleaseRow->release_id;

            $stackStmt = $con->prepare("INSERT into STACK values (null, 'Blocked', ?, 1);");
            $stackStmt->execute(array($releaseID));
            
            $stackStmt = $con->prepare("INSERT into STACK values (null, 'In Progress', ?, 1);");
            $stackStmt->execute(array($releaseID));

            $stackStmt = $con->prepare("INSERT into STACK values (null, 'Done', ?, 1);");
            $stackStmt->execute(array($releaseID));
            
            $stackStmt->closeCursor();

            $_SESSION['memberArr'] = [];

			Header ("Location:dashboard.php");
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
                    <li class="nav-item"><a class="nav-link" href="team.html"><i class="fas fa-people-carry" style="color: var(--bs-accordion-bg);"></i><span style="color: var(--bs-accordion-bg);">Team Members</span></a><a class="nav-link" href="profile.php" style="color: var(--bs-accordion-bg);"><i class="fas fa-user" style="color: var(--bs-accordion-bg);"></i><span style="color: var(--bs-accordion-bg);">Profile</span></a></li>
                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn d-xxl-flex justify-content-xxl-center align-items-xxl-center rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <h3 class="text-dark mb-1">Create Project</h3>
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
                                    <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in"><a class="dropdown-item" href="profile.php"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Profile</a><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="container">
                    <div class="col">
                        <div class="row">

						<!-- set project settings -->
                        <div class="col">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3" style="background: var(--bs-gray-200);">
                                    <h6 class="text-primary m-0 fw-bold">Create a Project</h6>
                                </div>
                            <div class="card-body" style="background: var(--bs-gray-100);">
                                <form class="d-xxl-flex justify-content-xxl-center" action="createProject.php" method="post">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col"><label class="col-form-label fs-6">Project Name<input class="form-control" type="text" name="name" value="Project"></label></div>
                                        </div>
                                        <div class="row">
                                            <div class="col"><label class="col-form-label fs-6">Current Version<input class="form-control" type="number" name="version" value="1.0" min="0" step=".1"></label></div>
                                        </div>
                                        <div class="row">
                                            <div class="col"><label class="col-form-label fs-6">Card Color<br><input type="color" name="color" value="#4e73e0"></label></div>
                                        </div>


										<div class="row">
	                                  	    <div class="col d-xxl-flex justify-content-xxl-end">
											    <a class="btn btn-primary" style="background: var(--bs-gray-dark);border-color: var(--bs-border-color);" href="dashboard.php">Cancel</a><input class="btn btn-primary" type="submit" name="enter_project" value="Create" role="button" style="background: var(--bs-success);margin-left: 15px;border-color: var(--bs-border-color);"></input>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
                        </div>
							<!-- add team member -->
                            <div class="col">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3" style="background: var(--bs-gray-200);">
                                        <h6 class="text-primary m-0 fw-bold">Add a Member to this Project</h6>
                                    </div>
                                    <div class="card-body" style="background: var(--bs-gray-100); height: 305px;">
                                        <div class="row">
                                            <div class="col">
                                                <div style="height: 72px;"></div>
                                            </div>
                                        </div>
                                        <form class="d-xxl-flex justify-content-xxl-center" action="createProject.php" method="post">
                                            <div class="col">
                                                <div class="row">
                                                    <div class="col d-xxl-flex" style="height: 72px;"><label class="col-form-label fs-6 text-start d-xxl-flex justify-content-xxl-center align-items-xxl-center">Username<input class="form-control" type="text" name="memberUsername" placeholder="dougPug" style="margin: 12px;"></label></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div style="height: 72px;">
														    <?php echo $memberMsg; ?>
													    </div>
                                                    </div>
                                                </div>

                                                <div class = "row">
                                                    <div class="col">
                                                        <div style="height: 72px;">
                                                            <div class="col d-xxl-flex justify-content-xxl-end">
                                                                <input class="btn btn-primary" role="button" type="submit" name="enter_member" style="background: var(--bs-success);margin-left: 15px;border-color: var(--bs-border-color);" value="Add"></input></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
										    </div>
                                        </form>
									    <div class="row"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="card shadow" style="padding-bottom: 0px;margin-bottom: 20px;">
                                    <div class="card-header py-3">
                                        <p class="text-primary m-0 fw-bold">Team Members Assigned to This Project</p>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive table mt-2" id="dataTable-1" role="grid" aria-describedby="dataTable_info">
                                            <table class="table my-0" id="dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Position</th>
                                                        <th>Username</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
													<?php
														foreach($_SESSION['memberArr'] as $currentMember) {
															$listStmt = $con->prepare("SELECT * FROM USER WHERE Username = ?");
															$listStmt->execute(array($currentMember));
															$listRow = $listStmt->fetch(PDO::FETCH_ASSOC);
															print '<tr><td><img class="rounded-circle me-2" width="30" height="30" src="assets/img/dogs/image2.jpeg">'.$listRow['FirstName']." ".$listRow['LastName']."</td>";
															print '<td>'.$listRow['Position'].'</td>';
															print '<td>'.$listRow['Username'].'</td></tr>';
														}
														$listStmt->closeCursor();
													?>
                                                    <tr>
                                                        <td><img class="rounded-circle me-2" width="30" height="30" src="assets/img/dogs/image2.jpeg">Doug Pug</td>
                                                        <td>Good Boi</td>
                                                        <td>dougTheDoggo</td>
                                                    </tr>
                                                    <tr></tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td><strong>Name</strong></td>
                                                        <td><strong>Position</strong></td>
                                                        <td><strong>Username</strong></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
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
            </div>
					</div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © Brand 2022</span></div>
                </div>
            </footer>
        <a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>
