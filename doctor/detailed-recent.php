<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin.css">
    <?php include("../patient/config.php"); ?>
    <title>Consultancy</title>
    <style>
        .dashbord-tables {
            animation: transitionIn-Y-over 0.5s;
        }

        .filter-container {
            animation: transitionIn-Y-bottom 0.5s;
        }

        .sub-table,
        .anime {
            animation: transitionIn-Y-bottom 0.5s;
        }

        w {
            font-family: 'Montserrat', sans-serif;
            font-size: 14px;
            color: #006dd3;
            font-weight: 500;
        }

        .form-label {
            font-size: 14px;
            letter-spacing: 1px;
        }

        .add-doc-form-container {
            width: 35vw !important;
        }

        .login-btn {
            margin-top: 2vh;
        }
    </style>


</head>

<body>
    <?php
    #rasa run --enable-api --cors "*"
    #rasa run actions

    session_start();
    error_reporting(0);
    if (isset($_SESSION["user"])) {
        if (($_SESSION["user"]) == "" or $_SESSION['usertype'] != 'd') {
            header("location: ../login.php");
        } else {
            $useremail = $_SESSION["user"];
        }
    } else {
        header("location: ../login.php");
    }


    //import database
    include("../connection.php");

    $sqlmain = "select * from doctor where docemail=?";
    $stmt = $database->prepare($sqlmain);
    $stmt->bind_param("s", $useremail);
    $stmt->execute();
    $userrow = $stmt->get_result();
    $userfetch = $userrow->fetch_assoc();

    $userid = $userfetch["docid"];
    $username = $userfetch["docname"];



    //echo $userid;
    //echo $username;

    ?>
    <div class="container">
        <div class="menu">
            <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container" style="padding-top: 4vh">
                            <tr>
                                <td width="30%" style="padding-left:20px">
                                    <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title"><?php echo substr($username, 0, 13)  ?>..</p>
                                    <p class="profile-subtitle"><?php echo substr($useremail, 0, 22)  ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="../logout.php"><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-dashbord">
                        <a href="index.php" class="non-style-link-menu ">
                            <div>
                                <p class="menu-text">Dashboard</p>
                            </div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu">
                            <div>
                                <p class="menu-text">My Appointments</p>
                            </div>
                        </a>
                    </td>
                </tr>

                <tr class="menu-row">
                    <td class="menu-btn menu-icon-session">
                        <a href="schedule.php" class="non-style-link-menu">
                            <div>
                                <p class="menu-text">My Sessions</p>
                            </div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-patient menu-active menu-icon-patient-active">
                        <a href="patient.php" class="non-style-link-menu  non-style-link-menu-active">
                            <div>
                                <p class="menu-text">My Patients</p>
                            </div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-settings   ">
                        <a href="settings.php" class="non-style-link-menu">
                            <div>
                                <p class="menu-text">Settings</p>
                            </div>
                        </a>
                    </td>
                </tr>
            </table>
        </div>
        <div class="dash-body">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
                <tr>
                    <td width="13%">
                        <a href="patient.php"><button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                                <font class="tn-in-text"><?php echo $lang['ddback'] ?></font>
                            </button></a>
                    </td>
                    <td>
                        <p style="font-size: 23px;padding-left:12px;font-weight: 600;"><?php echo $lang['recentconsultancy'] ?></p>

                    </td>
                    <td width="15%">
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                            <?php echo $lang['tddate'] ?>
                        </p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            <?php

                            date_default_timezone_set('Asia/Kolkata');

                            $today = date('Y-m-d');
                            echo $today;
                            ?>
                        </p>
                    </td>
                    <td width="10%">
                        <button class="btn-label" style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                    </td>
                </tr>
            </table>
            <tr>
                <td colspan="4">
                    <center>
                        <div class="abc scroll">
                            <table width="93%" class="sub-table scrolldown" border="0">
                                <thead>
                                    <tr>
                                        <th class="table-headin">
                                            Patient name
                                        </th>
                                        <th class="table-headin">

                                            <?php echo $lang['apno'] ?>

                                        </th>

                                        <th class="table-headin">

                                            <?php echo $lang['sessiontitle'] ?>

                                        </th>

                                        <th class="table-headin">

                                            <?php echo $lang['sdt'] ?>

                                        </th>

                                        <th class="table-headin">

                                            <?php echo $lang['apd'] ?>

                                        </th>
                                </thead>
                                <tbody>

                                    <?php
                                    $appoid = $_GET["id"];
                                    $appodate = $_GET["appodate"];
                                    $title = $_GET["session"];
                                    $apponum = $_GET["apponum"];
                                    $pname = $_GET["pname"];
                                    $scheduletime = $_GET["scheduletime"];
                                    $twentyfourHourtime = $_GET["scheduletime"];
                                    $scheduletime = date("h:i A", strtotime($twentyfourHourtime));
                                    $scheduledate = $_GET["scheduledate"];
                                    $scheduleid = $_GET["scheduleid"];
                                    $pid = $_GET["pid"];

                                    echo '<tr >
                                        <td style="font-weight:600; text-align: center;"> &nbsp;' .

                                        substr($pname, 0, 25)
                                        . '</td >
                                        <td style="text-align:center;font-size:23px;font-weight:500; color: var(--btnnicetext);">
                                        ' . $apponum . '
                                        
                                        </td>
                                        <td>
                                        ' . substr($lang[$title], 0, 15) . '
                                        </td>
                                        <td style="text-align:center;;">
                                            ' . substr($scheduledate, 0, 10) . ' @' . substr($scheduletime, 0, 8) . '
                                        </td>
                                        
                                        <td style="text-align:center;">
                                            ' . $appodate . '
                                        </td>
                                    </tr>';
                                    ?>
                                </tbody>
                            </table>
                            <?php
                            $sqlmain = "SELECT * from appointment inner join schedule on schedule.scheduleid = appointment.scheduleid inner join patient on patient.pid = appointment.pid inner join metrices on metrices.appoid=appointment.appoid WHERE appointment.pid = '$pid' and appointment.scheduleid='$scheduleid'";
                            $result = $database->query($sqlmain);
                            $row = $result->fetch_assoc();
                            $pname = $row['pname'];
                            $pid = $row['pid'];
                            $weight = $row['weight'];
                            $height = $row['height'];
                            $sugar = $row['sugar'];
                            $bp = $row['bp'];
                            $temp = $row['temp'];
                            $allergy = $row['allergy'];
                            $reason = $row['reason'];
                            $appoid = $row['appoid'];
                            $uid = $row['uid']; ?>
                            <div class="flex-row">
                                <div class="sub-table scrolldown add-doc-form-container" border="0">
                                    <table>
                                        <tr>
                                            <td>
                                                <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;text-align:center;"><?php echo $lang['pdet'] ?></p><br><br>
                                            </td>
                                        </tr>
                                        <div>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <label for="pid" class="form-label">
                                                        <w><?php echo $lang['pd'] ?></w><?php echo $pid ?>
                                                    </label>
                                                    <label for="name" class="form-label" style="margin-left: 8.5vw;">
                                                        <w><?php echo $lang['ne'] ?></w><?php echo $pname ?>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <label for="pid" class="form-label">
                                                        <w><?php echo $lang['hg'] ?></w><?php echo $height  . ' cm' ?>
                                                    </label>
                                                    <label for="name" class="form-label" style="margin-left: 7.4vw;">
                                                        <w><?php echo $lang['wg'] ?></w><?php echo $weight . ' kg' ?>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <label for="pid" class="form-label">
                                                        <w><?php echo $lang['sr'] ?></w><?php echo $sugar  . ' mM' ?>
                                                    </label>
                                                    <label for="name" class="form-label" style="margin-left: 8vw;">
                                                        <w><?php echo $lang['bp'] ?></w><?php echo $bp  . ' mmHg' ?>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <label for="pid" class="form-label">
                                                        <w><?php echo $lang['tem'] ?>: </w><?php echo $temp  . ' °F' ?>
                                                    </label>
                                                    <label for="name" class="form-label" style="margin-left: 4.3vw;">
                                                        <w><?php echo $lang['alg'] ?>: </w><?php echo $allergy ?>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-td" colspan="2">
                                                    <label for="name" class="form-label">
                                                        <w><?php echo $lang['re'] ?></w><?php echo $reason ?>
                                                    </label>
                                                </td>
                                            </tr>
                                        </div>
                                    </table>
                                </div>
                                <div width="30%" class="sub-table scrolldown add-doc-form-container" border="0">
                                    <?php
                                    $sql = "SELECT * from report WHERE pid = '$pid' and appoid = '$appoid' and scheduleid = '$scheduleid'";
                                    $result = $database->query($sql);
                                    $row = $result->fetch_assoc();
                                    $prescription = $row['prescription'];
                                    $report = $row['report'];
                                    ?>
                                    <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;text-align:center;"><?php echo $lang['prre'] ?></p><br><br>
                                    <?php if ($prescription != null) { ?>
                                        <a href="./view-file.php?prescription-view=<?php echo $prescription; ?>"><button class=" login-btn btn-primary-soft btn"><?php echo $lang['vpre'] ?></button></a><br />
                                    <?php }
                                    if ($report != null) { ?>
                                        <a href="./view-file.php?report-view=<?php echo $report; ?>"><button class="login-btn btn-primary-soft btn"><?php echo $lang['vr'] ?></button></a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </center>
                </td>
            </tr>
        </div>
</body>

</html>