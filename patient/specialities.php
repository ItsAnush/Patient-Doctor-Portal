<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>Sessions</title>
    <style>
        .popup {
            animation: transitionIn-Y-bottom 0.5s;
        }

        .sub-table {
            animation: transitionIn-Y-bottom 0.5s;
        }

        .disabled-link {
            cursor: not-allowed;
            pointer-events: none;
            opacity: 0.5;
        }

        .enabled-link {
            cursor: pointer;
            pointer-events: all;
            opacity: 1;
        }

        .image-display,
        .image-display a {
            display: flex;
            flex-direction: row;
            text-decoration: none;

        }

        .special-box {
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin: 15px;
            width: 370px;
            text-align: left;
            display: flex;
            flex-direction: row;
            align-items: center;
            color: #000;
        }

        .special-box img {
            margin: 0 20px 0 5px;
        }

        .special-box:hover {
            border: 1px solid #4c4c4c;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <?php

    //learn from w3schools.com

    session_start();
    error_reporting(0);

    if (isset($_SESSION["user"])) {
        if (($_SESSION["user"]) == "" or $_SESSION['usertype'] != 'p') {
            header("location: ../login.php");
        } else {
            $useremail = $_SESSION["user"];
        }
    } else {
        header("location: ../login.php");
    }


    //import database
    include("../connection.php");
    $sqlmain = "SELECT * FROM patient WHERE pemail=?";
    $stmt = $database->prepare($sqlmain);
    $stmt->bind_param("s", $useremail);  // Bind the variable $useremail as a string parameter
    $stmt->execute();
    $result = $stmt->get_result();
    $userrow = $result->fetch_assoc();  // Use $result instead of $userrow
    $userid = $userrow["pid"];
    $username = $userrow["pname"];


    //echo $userid;
    //echo $username;

    date_default_timezone_set('Asia/Kolkata');

    $today = date('Y-m-d');


    //echo $userid;
    ?>
    <div class="container">
        <div class="menu">
            <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
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
                    <td class="menu-btn menu-icon-home ">
                        <a href="index.php" class="non-style-link-menu ">
                            <div>
                                <p class="menu-text">Home</p>
                        </a>
        </div></a>
        </td>
        </tr>
        <tr class="menu-row">
            <td class="menu-btn menu-icon-doctor">
                <a href="doctors.php" class="non-style-link-menu">
                    <div>
                        <p class="menu-text">All Doctors</p>
                </a>
    </div>
    </td>
    </tr>

    <tr class="menu-row">
        <td class="menu-btn menu-icon-session menu-active menu-icon-session-active">
            <a href="specialities.php" class="non-style-link-menu non-style-link-menu-active">
                <div>
                    <p class="menu-text">Book Appointment</p>
                </div>
            </a>
        </td>
    </tr>
    <tr class="menu-row">
        <td class="menu-btn menu-icon-appoinment">
            <a href="appointment.php" class="non-style-link-menu">
                <div>
                    <p class="menu-text">My Bookings</p>
            </a></div>
        </td>
    </tr>
    <tr class="menu-row">
        <td class="menu-btn menu-icon-recent">
            <a href="recent.php" class="non-style-link-menu">
                <div>
                    <p class="menu-text">Recent Consultancy</p>
                </div>
            </a>
        </td>
    </tr>
    <tr class="menu-row">
        <td class="menu-btn menu-icon-assistant">
            <a href="assistant.php" class="non-style-link-menu">
                <div>
                    <p class="menu-text">Assistant</p>
            </a></div>
        </td>
    </tr>
    <tr class="menu-row">
        <td class="menu-btn menu-icon-settings">
            <a href="settings.php" class="non-style-link-menu">
                <div>
                    <p class="menu-text">Settings</p>
            </a></div>
        </td>
    </tr>
    </table>
    </div>
    <?php

    $sqlmain = "SELECT * from specialties";
    $sqlpt1 = "";
    $insertkey = "";
    $q = '';
    $searchtype = "All";
    if ($_POST) {
        //print_r($_POST);

        if (!empty($_POST["search"])) {
            /*TODO: make and understand */
            $keyword = $_POST["search"];
            $sqlmain = "select * from specialties where (sname='$keyword' or sname like '$keyword%' or sname like '%$keyword' or sname like '%$keyword%') order by sname asc";
            #echo $sqlmain;
            $insertkey = $keyword;
            $searchtype = "Search Result : ";
            $q = '"';
        }
    }

    $stmt = $database->prepare($sqlmain);
    $stmt->execute();
    $result = $stmt->get_result();


    ?>

    <div class="dash-body">
        <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
            <tr>
                <td width="13%">
                    <a href="index.php"><button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                            <font class="tn-in-text">Back</font>
                        </button></a>
                </td>
                <td>
                    <form action="" method="post" class="header-search">

                        <input type="search" name="search" class="input-text header-searchbar" placeholder="Search Specialities" list="doctors" value="<?php echo $insertkey ?>">&nbsp;&nbsp;

                        <?php
                        echo '<datalist id="doctors">';
                        $list11 = $database->query("select DISTINCT * from  doctor;");
                        $list12 = $database->query("select DISTINCT * from  schedule GROUP BY title;");

                        for ($y = 0; $y < $list11->num_rows; $y++) {
                            $row00 = $list11->fetch_assoc();
                            $d = $row00["docname"];

                            echo "<option value='$d'><br/>";
                        };


                        for ($y = 0; $y < $list12->num_rows; $y++) {
                            $row00 = $list12->fetch_assoc();
                            $d = $row00["title"];

                            echo "<option value='$d'><br/>";
                        };

                        echo ' </datalist>';
                        ?>


                        <input type="Submit" value="Search" class="login-btn btn-primary btn" style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">
                    </form>
                </td>
                <td width="15%">
                    <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                        Today's Date
                    </p>
                    <p class="heading-sub12" style="padding: 0;margin: 0;">
                        <?php


                        echo $today;



                        ?>
                    </p>
                </td>
                <td width="10%">
                    <button class="btn-label" style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                </td>


            </tr>


            <tr>
                <td colspan="4" style="padding-top:10px;width: 100%;">
                    <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)"><?php echo $searchtype . " Sessions" . "(" . $result->num_rows . ")"; ?> </p>
                    <p class="heading-main12" style="margin-left: 45px;font-size:22px;color:rgb(49, 49, 49)"><?php echo $q . $insertkey . $q; ?> </p>
                </td>

            </tr>



            <tr>
                <td colspan="4">
                    <center>
                        <div class="abc scroll">
                            <table width="100%" class="sub-table scrolldown" border="0" style="padding: 50px;border:none">

                                <tbody>
                                    <tr>
                                        <?php

                                        $a = 0;
                                        while ($userrow = $result->fetch_assoc()) {
                                            $sname = $userrow['sname'];
                                            $imgname = $userrow['imgname'];
                                            $sid = $userrow['id'];
                                            if ($a % 3 == 0) {
                                        ?> <div class="image-display">
                                                    <a href="schedule.php?id=<?php echo $sid ?>">
                                                        <div class="special-box"><img src="<?php echo $imgname ?>" alt="image" width="35px" height="35px">
                                                            <p><?php echo $sname; ?></p>
                                                        </div>
                                                    </a>
                                                <?php } else if ($a % 3 == 1) { ?>
                                                    <a href="schedule.php?id=<?php echo $sid ?>">
                                                        <div class="special-box"><img src="<?php echo $imgname ?>" alt="image" width="35px" height="35px">
                                                            <p><?php echo $sname; ?></p>
                                                        </div>
                                                    </a>
                                                <?php } else { ?>
                                                    <a href="schedule.php?id=<?php echo $sid ?>">
                                                        <div class="special-box"><img src="<?php echo $imgname ?>" alt="image" width="35px" height="35px">
                                                            <p><?php echo $sname; ?></p>
                                                        </div>
                                                    </a>
                                                </div>
                                        <?php    }
                                            $a++;
                                        }
                                        ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </center>
                </td>
            </tr>
        </table>
    </div>


</body>
<script>
    var seatleft = <?php echo $seatleft ?>;
    var bookingLink = document.getElementById("bookingLink");

    if (seatleft === 0) {
        bookingLink.classList.add("disabled-link");
    }
</script>

</html>