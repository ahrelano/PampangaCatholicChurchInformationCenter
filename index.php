<?php
session_start();
if(isset($_SESSION['islogin'])){
    $islogin=$_SESSION['islogin'];
    if ($islogin === 2) {
        header('location: admin/index.php');
        exit();
    }    else if  ($islogin === 3) {
        header('location: superadmin/index.php');
        exit();
}}

    if (isset($_SESSION['invalid'])) {
        if (empty($_SESSION['invalid'])) {
        }else{
            ?>
            <script type="text/javascript">
                alert('Invalid input account!');
            </script>
            <?php
        $_SESSION['invalid']="";
        }
    }

    if (isset($_SESSION['active'])) {
        if (empty($_SESSION['active'])) {
        }else{
            ?>
            <script type="text/javascript">
                alert('The admin is already logged in from another browser!');
            </script>
            <?php
        $_SESSION['active']="";
        }
    }
    if (isset($_SESSION['deletepost'])) {
        if (empty($_SESSION['deletepost'])) {
        }else{
            ?>
            <script type="text/javascript">
                alert('Post deleted!');
            </script>
            <?php
        $_SESSION['deletepost'] = "";
        }
    } 

    if (isset($_SESSION['banned'])) {
        if (empty($_SESSION['banned'])) {
        }else{
            ?>
            <script type="text/javascript">
                alert('You have been banned by the admin!');
            </script>
            <?php
        $_SESSION['banned']="";
        }
    }

        if (isset($_SESSION['success_reg'])) {
        if (empty($_SESSION['success_reg'])) {
        }else{
            ?>
            <script type="text/javascript">
                alert('Successfully registered!');
            </script>
            <?php
        $_SESSION['success_reg']="";
        }
    } 

    if (isset($_SESSION['delete-reservation'])) {
        if (empty($_SESSION['delete-reservation'])) {
        }else{
            ?>
            <script type="text/javascript">
                alert('Reservation deleted!');
            </script>
            <?php
        $_SESSION['delete-reservation']="";
        }
    } 
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Pampanga Catholic Churches</title>

    <!-- Bootstrap Core CSS -->
    <link rel="shortcut icon" href="img/untitled_1_BuF_icon.ico" />
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

    <!-- Plugin CSS -->
    <link href="vendor/magnific-popup/magnific-popup.css" rel="stylesheet">

    <!-- Theme CSS -->
    <link href="css/creative.min.css" rel="stylesheet">
    <link href="css/creative.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/loginform.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="page-top">

    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
            <!-- <a class="navbar-brand page-scroll" href="#page-top">Pampanga Churches</a> -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
            </button>      
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <?php 
                    if (isset($_SESSION['islogin'])) {         
                    if (isset($_SESSION['id'])){
                    $usernameid = $_SESSION['id'];
                    include('include/connect_to_db.php'); 
                    $queryusername = $con->query("SELECT username FROM account WHERE id = '$usernameid' LIMIT 1");
                    if ($queryusername->num_rows > 0) {
                        while ($rowusername = $queryusername->fetch_array()) {
                            $_SESSION['username'] = $rowusername['username'];
                            ?>
                    <li>
                        <a class="page-scroll" href="#page-top">Hi <?php echo $rowusername['username']; ?>!</a>
                    </li> 
                    <?php
                    }}}} 
                    ?>  
                    <li>
                        <a class="page-scroll" href="#services">Services</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#galleries">Galleries</a>
                    </li>
                    <li>
                    
                   <!--  <button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     Town
                    <span class="caret"></span>
                    </button> -->
                    <a class="page-scroll" href="" id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Town<span class="caret"></span></a>
                    <ul class="dropdown-menu" aria-labelledby="dLabel">
                       <?php
                       include('include/connect_to_db.php');
                       $querytown = $con->query('SELECT DISTINCT town FROM church ORDER BY town');
                       if ($querytown->num_rows > 0) {
                           while ($numtown = $querytown->fetch_array()) {
                                $town = preg_replace('#[^a-z0-9]#i', '', $numtown['town']);
                               ?>
                               <li><a href="#<?php echo $town; ?>" data-toggle="modal"><?php echo $numtown['town']; ?></a></li>
                               <?php
                           }
                       }
                       ?>
                       <li></li>
                    </ul>
                   
                    </li>
                    <li>
                        <a class="page-scroll" href="#forum">Forum</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#contact">Contact</a>
                    </li>
<?php
if(isset($_SESSION['islogin']) && isset($_SESSION['id'])){
    $id = $_SESSION['id'];
    ?>
<li>
    <a href="include/logout.php?id=<?php echo $id; ?>">Logout</a>
</li>
    <?php
}else{
    ?>
<li>
    <a href="" data-toggle="modal" data-target=".login">Login</a>
</li>
<?php
}
?>
                    
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- Town Churches -->
    <?php
    include('include/connect_to_db.php');
    $querychurch = $con->query('SELECT DISTINCT town FROM church ORDER BY town');
    if ($querychurch->num_rows > 0) {
    while ($numchurch = $querychurch->fetch_array()) {
        $town = preg_replace('#[^a-z0-9]#i', '', $numchurch['town']);
        $churchtown = $numchurch['town'];
    ?>
                             <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="<?php echo $town; ?>" class="modal fade" style="display: none;">
                              <div class="modal-dialog">
                                  <div class="modal-content" style="text-align:center;">
                                      <div class="modal-header">
                                          <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                          <h4 class="modal-title"><?php echo $numchurch['town']; ?></h4>
                                      </div>
                                      <div class="modal-body">
                                    <?php
                                    $church = $con->query("SELECT * FROM church WHERE town = '$churchtown'");
                                    while ($numchurchname = $church->fetch_array()) {
                                    ?>
                                    <a href="church.php?v=<?php echo $numchurchname['coordinate']; ?>"><?php echo $numchurchname['churchname']; ?></a><br>
                                    <?php
                                    }
                                    ?>
                                      </div>
                                  </div><!-- /.modal-content -->
                              </div><!-- /.modal-dialog -->
                          </div><!-- /.modal -->
    <?php
    }
    }
    ?>

    <header style="background-image: url('img/sitelogo.jpg');">
        <div class="header-content">
            <div class="header-content-inner">
                <!-- <h1 id="homeHeading">Pampanga Catholic Churches</h1> -->
                <!-- <hr> -->
                <!-- <p>Start Bootstrap can help you build better websites using the Bootstrap CSS framework! Just download your template and start going, no strings attached!</p> -->
                <!-- <a href="#services" class="btn btn-primary btn-xl page-scroll">Find Out More</a> -->
            </div>
        </div>
    </header>
    <section class="bg-primary" id="history">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <h2 class="section-heading">Welcome to Pampanga Catholic Churches Information!</h2>
                    <hr class="light">
                   <!--  <p class="text-faded">Welcome to Pampanga Catholic Churches Information</p> -->
                    <a href="#services" class="page-scroll btn btn-default btn-xl sr-button">Get Started!</a>
                </div>
            </div>
        </div>
    </section>
<script type="text/javascript">
        function _ (el) {
        return document.getElementById(el);
    }
    function checkusername(){
        var status = document.getElementById("usernamestatus");
        var u = document.getElementById("username").value;
            status.innerHTML = 'checking...';
            var hr = new XMLHttpRequest();
            hr.open("POST", "auth/checkusername.php", true);
            hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            hr.onreadystatechange = function() {
                if(hr.readyState == 4 && hr.status == 200) {
                    status.innerHTML = hr.responseText;
                    if (hr.responseText == "ok") {
                        status.innerHTML = '<span style="color:green;">' + u + " is OK!</span>";
                        //enable submit button here
                        _('signUpBtn').disabled = false;
                    }else {
                        _('signUpBtn').disabled = true;
                    }
                }
            }
            var v = "name2check=" + u;
            hr.send(v);
    }

        function checkemail(){
        var status = document.getElementById("emailstatus");
        var e = document.getElementById("email").value;
            status.innerHTML = 'checking...';
            var hr = new XMLHttpRequest();
            hr.open("POST", "auth/checkemail.php", true);
            hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            hr.onreadystatechange = function() {
                if(hr.readyState == 4 && hr.status == 200) {
                    status.innerHTML = hr.responseText;
                    if (hr.responseText == "ok") {
                        status.innerHTML = '<span style="color:green;">' + e + " is OK!</span>";
                        //enable submit button here
                        _('signUpBtn').disabled = false;
                    }else {
                        _('signUpBtn').disabled = true;
                    }
                }
            }
            var v = "email2check=" + e;
            hr.send(v);
    }
</script>
<!-- Login Form -->
<div class="modal fade login" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
<div class="col-md-4 col-md-offset-4">
<div class="form-body">
    <ul class="nav nav-tabs final-login">
        <li class="active"><a data-toggle="tab" href="#sectionA">Login</a></li>
        <li><a data-toggle="tab" href="#sectionB">Sign Up!</a></li>
    </ul>
    <div class="tab-content">
        <div id="sectionA" class="tab-pane fade in active">
            <div class="innter-form">
                <form class="sa-innate-form" method="post" action="include/checklogin.php">
                    <label>Username</label>
                    <input type="text" name="username" required autofocus>
                    <label>Password</label>
                    <input type="password" name="password" required>
                    <button type="submit">Login</button>
                </form>
            </div>
                <div class="clearfix"></div>
            </div>
            <div id="sectionB" class="tab-pane fade">
                <div class="innter-form">
                <form class="sa-innate-form" method="post" action="include/checkregister.php">
                    <label>Username</label>
                    <input type="text" name="username" id="username" onkeyup="checkusername()" maxlength="16" autofocus required>
                    <span id="usernamestatus" style="color:red;"></span><br>
                    <label>Email</label>
                    <input type="email" name="email" id="email" onkeyup="checkemail()" required>
                    <span id="emailstatus" style="color:red;"></span><br>
                    <label>Password</label>
                    <input type="password" name="password" required>
                    <button type="submit" id="signUpBtn" disabled>Sign Up</button>
                    <span id="usernamestatus" style="color:red;"></span><br>
                </form>
                </div>
            </div>
    </div>
    </div>
    </div>
</div>

                    <?php 
                    if (isset($_SESSION['islogin'])) {         
                    if (isset($_SESSION['id'])){
                        $username = $_SESSION['username'];
                        ?>
                        <section id="services">

<!-- RESERVATION FOR WAKE -->
        <div class="container">
        <!-- PENDING RESERVATION -->
                        <h2><span style="color:red;">Pending Reservation</span></h2> 
            <?php
            $countwake = 0;
            $total = 0;
            $numberwake = 0;
            $five = 5;
            $querywake = $con->query("SELECT * FROM wake WHERE username = '$username' AND approve='no' ORDER BY id DESC");
            if ($querywake->num_rows > 0){
                ?>
        <div id="statuswake">
        <table class="table table-bordered">
        <th colspan="4" style="text-align:center; background-color: black; color: white;"><h3>Wake</h3></th>
<tr>
<th>Until</th>
<th>Submit Date</th>
<th>Approved</th>
<th>Action</th>
</tr>
                <?php
            while ($rowwake = $querywake->fetch_array()) {
              $numberwake = $numberwake + 1;
              if ($numberwake <= 5) {   
              ?>
              <tr>
                  <td><?php echo $rowwake['until']; ?></td>
                  <td><?php echo $rowwake['submitdate']; ?></td>
                  <td><span style="color:red;"><?php echo $rowwake['approve']; ?></span></td>
                  <td>
                      <a href="#viewWake<?php echo $rowwake['id']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>View</a>
                    <a href="auth/cancelwake.php?wakeid=<?php echo $rowwake['id']; ?>&deleteUntil=<?php echo $rowwake['until']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>Cancel Reservation</a>
                  </td>
              </tr>
                     <!-- Modal WAKE -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="viewWake<?php echo $rowwake['id']; ?>" class="modal fade" style="display: none;">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Info</h4>
        </div>
<div class="modal-body">
<form class="form-horizontal">
         <strong>Username: </strong><label><?php echo $rowwake['username']; ?></label><br>
              <strong>Email: </strong><label><?php echo $rowwake['email']; ?></label><br>
              <strong>Contact: </strong><label><?php echo $rowwake['contact']; ?></label><br>
              <strong>Name: </strong><label><?php echo $rowwake['name']; ?></label><br>
              <strong>Age: </strong><label><?php echo $rowwake['age']; ?></label><br>
              <strong>Church: </strong><label><?php echo $rowwake['church']; ?></label><br>
              <strong>Town: </strong><label><?php echo $rowwake['town']; ?></label><br>
              <strong>Date: </strong><label><?php echo $rowwake['date']; ?></label><br>
              <strong>Until: </strong><label><?php echo $rowwake['until']; ?></label><br>
              <strong>Submit Date: </strong><label><?php echo $rowwake['submitdate']; ?></label><br>
              <span style="color:red;"><strong>Approved: </strong><label><?php echo $rowwake['approve']; ?></label></span>
        </form>
                                      </div>
                                  </div><!-- /.modal-content -->
                              </div><!-- /.modal-dialog -->
                          </div><!-- /.modal -->
            </div>
            <?php
            }
            $countwake = $countwake + 1;  
            if ($countwake > $five) {
              $total = $total + 1;
              $five = $five + 5;
            }}
            ?>
            </table>
            </div>
            <?php
            if ($total <> 0) {
              ?>
              <button class="btn btn-danger btn-sm" type="button" onclick="nextwake('0')">1</button>
              <?php
              $a = 1;
              for ($i=1; $i <= $total; $i++) { 
                $a = $a + 1;
              ?>
              <button class="btn btn-danger btn-sm" type="button" onclick="nextwake(<?php echo $i; ?>)"><?php echo $a; ?></button>
              <?php
              }
            }
            ?>
            <?php
        }
            ?>
            <script type="text/javascript">
  function nextwake(number){
    // Create our XMLHttpRequest object
    var hr = new XMLHttpRequest();
    // Create some variables we need to send to our PHP file
    var url = "include/nextwake.php";
    // var ln = document.getElementById("last_name").value;
    var vars = "message="+number;
    hr.open("POST", url, true);
    // Set content type header information for sending url encoded variables in the request
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // Access the onreadystatechange event for the XMLHttpRequest object
    hr.onreadystatechange = function() {
        if(hr.readyState == 4 && hr.status == 200) {
            var return_data = hr.responseText;
            document.getElementById("statuswake").innerHTML = return_data;
        }
    }
    // Send the data to PHP now... and wait for response to update the status div
    hr.send(vars); // Actually execute the request
}

  </script>
 <!-- RESERVATION FOR WEDDING -->           
            <?php
            $querywedding = $con->query("SELECT * FROM wedding WHERE username = '$username' AND approve='no' ORDER BY id DESC");
            if ($querywedding->num_rows > 0){
                ?>
        <table class="table table-bordered">
        <th colspan="4" style="text-align:center; background-color: pink; color: black;"><h3>Wedding</h3></th>
<tr>
<th>Until</th>
<th>Submit Date</th>
<th>Approved</th>
<th>Action</th>
</tr>
                <?php
            while ($rowwedding = $querywedding->fetch_array()) {
              ?>
              <tr>
                  <td><?php echo $rowwedding['until']; ?></td>
                  <td><?php echo $rowwedding['submitdate']; ?></td>
                  <td><span style="color:red;"><?php echo $rowwedding['approve']; ?></span></td>
                  <td> 
                <a href="#viewWedding<?php echo $rowwedding['id']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>View</a>
               <a href="auth/cancelwedding.php?weddingid=<?php echo $rowwedding['id']; ?>&removeUntil=<?php echo $rowwedding['until']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>Cancel Reservation</a>       
                </td>
              </tr>
                               <!-- Modal Wedding -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="viewWedding<?php echo $rowwedding['id']; ?>" class="modal fade" style="display: none;">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Info</h4>
        </div>
<div class="modal-body">
<form class="form-horizontal">
          <strong>Username: </strong><label><?php echo $rowwedding['username']; ?></label><br>
              <strong>Email: </strong><label><?php echo $rowwedding['email']; ?></label><br>
              <strong>Contact: </strong><label><?php echo $rowwedding['contact']; ?></label><br>
              <h4>Groom</h4>
              <strong>Firstname: </strong><label><?php echo $rowwedding['groomfirstname']; ?></label><br>
              <strong>Surname: </strong><label><?php echo $rowwedding['groomsurname']; ?></label><br>
              <strong>Age: </strong><label><?php echo $rowwedding['groomage']; ?></label><br>
              <strong>Occupation: </strong><label><?php echo $rowwedding['goccupation']; ?></label><br>
              <h4>Groom Father</h4>
              <strong>Firstname: </strong><label><?php echo $rowwedding['gffirstname']; ?></label><br>
              <strong>Surname: </strong><label><?php echo $rowwedding['gfsurname']; ?></label><br>
              <strong>Occupation: </strong><label><?php echo $rowwedding['gfoccupation']; ?></label><br>
              <h4>Bride</h4>
              <strong>Firstname: </strong><label><?php echo $rowwedding['bridefirstname']; ?></label><br>
              <strong>Surname: </strong><label><?php echo $rowwedding['bridesurname']; ?></label><br>
              <strong>Age: </strong><label><?php echo $rowwedding['brideage']; ?></label><br>
              <h4>Bride Father</h4>
              <strong>Firstname: </strong><label><?php echo $rowwedding['bffirstname']; ?></label><br>
              <strong>Surname: </strong><label><?php echo $rowwedding['bfsurname']; ?></label><br>
              <strong>Occupation: </strong><label><?php echo $rowwedding['bfoccupation']; ?></label><br>
              <strong>Church: </strong><label><?php echo $rowwedding['church']; ?></label><br>
              <strong>Town: </strong><label><?php echo $rowwedding['town']; ?></label><br>
              <strong>Date: </strong><label><?php echo $rowwedding['date']; ?></label><br>
              <strong>Until: </strong><label><?php echo $rowwedding['until']; ?></label><br>
              <strong>Submit Date: </strong><label><?php echo $rowwedding['submitdate']; ?></label><br>
              <span style="color:red;"><strong>Approved: </strong><label><?php echo $rowwedding['approve']; ?></label></span>
        </form>
                                      </div>
                                  </div><!-- /.modal-content -->
                              </div><!-- /.modal-dialog -->
                          </div><!-- /.modal -->
              <?php
            }
            ?>
                </table>
            <?php
        }
            ?>

<!-- RESERVATION FOR CHRISTENING -->
            <?php
            $querychristening = $con->query("SELECT * FROM christening WHERE username = '$username' AND approve='no' ORDER BY id DESC");
            if ($querychristening->num_rows > 0){
                ?>
        <table class="table table-bordered">
        <th colspan="4" style="text-align:center; background-color: lightblue; color: black;"><h3>Christening</h3></th>
<tr>
<th>Until</th>
<th>Submit Date</th>
<th>Approved</th>
<th>Action</th>
</tr>
                <?php
            while ($rowchristening = $querychristening->fetch_array()) {
              ?>
              <tr>
                  <td><?php echo $rowchristening['until']; ?></td>
                  <td><?php echo $rowchristening['submitdate']; ?></td>
                  <td><span style="color:red;"><?php echo $rowchristening['approve']; ?></span></td>
                  <td>
                <a href="#viewChristening<?php echo $rowchristening['id']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>View</a>
               <a href="auth/cancelchristening.php?christeningid=<?php echo $rowchristening['id']; ?>&banishUntil=<?php echo $rowchristening['until']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>Cancel Reservation</a>
                  </td>
              </tr>
                <!-- Modal Christening -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="viewChristening<?php echo $rowchristening['id']; ?>" class="modal fade" style="display: none;">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Info</h4>
        </div>
<div class="modal-body">
<form class="form-horizontal">
<strong>Username: </strong><label><?php echo $rowchristening['username']; ?></label><br>
              <strong>Email: </strong><label><?php echo $rowchristening['email']; ?></label><br>
              <strong>Contact: </strong><label><?php echo $rowchristening['contact']; ?></label><br>
              <strong>Firstname: </strong><label><?php echo $rowchristening['firstname']; ?></label><br>
              <strong>Surname: </strong><label><?php echo $rowchristening['surname']; ?></label><br>
              <strong>Father's name: </strong><label><?php echo $rowchristening['fname']; ?></label><br>
              <strong>Mother's name: </strong><label><?php echo $rowchristening['mname']; ?></label><br>
              <strong>Father's Occupation: </strong><label><?php echo $rowchristening['foccupation']; ?></label><br>
              <strong>Place of Birth: </strong><label><?php echo $rowchristening['placeofbirth']; ?></label><br>
              <strong>Date of Birth: </strong><label><?php echo $rowchristening['dateofbirth']; ?></label><br>
              <strong>Church: </strong><label><?php echo $rowchristening['church']; ?></label><br>
              <strong>Town: </strong><label><?php echo $rowchristening['town']; ?></label><br>
              <strong>Date: </strong><label><?php echo $rowchristening['date']; ?></label><br>
              <strong>Until: </strong><label><?php echo $rowchristening['until']; ?></label><br>
              <strong>Submit Date: </strong><label><?php echo $rowchristening['submitdate']; ?></label><br>
              <span style="color:red;"><strong>Approved: </strong><label><?php echo $rowchristening['approve']; ?></label></span>
        </form>
                                      </div>
                                  </div><!-- /.modal-content -->
                              </div><!-- /.modal-dialog -->
                          </div><!-- /.modal -->
              <?php
            }
            ?>
                    </table>
            <?php
        }
            ?>
<!-- APPROVED RESERVATION -->
<h2><span style="color:green;">Approved Reservation</span></h2> 
<!-- RESERVATION FOR WAKE -->
        <div class="container">
            <?php
            $querywake = $con->query("SELECT * FROM wake WHERE username = '$username' AND approve='yes' AND `show` ='yes' ORDER BY id DESC");
            if ($querywake->num_rows > 0){
                ?>
        <table class="table table-bordered">
        <th colspan="4" style="text-align:center; background-color: black; color: white;"><h3>Wake</h3></th>
<tr>
<th>Until</th>
<th>Submit Date</th>
<th>Approved</th>
<th>Action</th>
</tr>
                <?php
            while ($rowwake = $querywake->fetch_array()) {
              ?>
              <tr>
                  <td><?php echo $rowwake['until']; ?></td>
                  <td><?php echo $rowwake['submitdate']; ?></td>
                  <td><span style="color:green;"><?php echo $rowwake['approve']; ?></span></td>
                  <td>
                       <a href="#viewWake<?php echo $rowwake['id']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>View</a>
                  </td>
              </tr>
                    <!-- Modal WAKE -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="viewWake<?php echo $rowwake['id']; ?>" class="modal fade" style="display: none;">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Info</h4>
        </div>
<div class="modal-body">
<form class="form-horizontal">
         <strong>Username: </strong><label><?php echo $rowwake['username']; ?></label><br>
              <strong>Email: </strong><label><?php echo $rowwake['email']; ?></label><br>
              <strong>Contact: </strong><label><?php echo $rowwake['contact']; ?></label><br>
              <strong>Name: </strong><label><?php echo $rowwake['name']; ?></label><br>
              <strong>Age: </strong><label><?php echo $rowwake['age']; ?></label><br>
              <strong>Church: </strong><label><?php echo $rowwake['church']; ?></label><br>
              <strong>Town: </strong><label><?php echo $rowwake['town']; ?></label><br>
              <strong>Date: </strong><label><?php echo $rowwake['date']; ?></label><br>
              <strong>Until: </strong><label><?php echo $rowwake['until']; ?></label><br>
              <strong>Submit Date: </strong><label><?php echo $rowwake['submitdate']; ?></label><br>
              <span style="color:green;"><strong>Approved: </strong><label><?php echo $rowwake['approve']; ?></label></span>
        </form>
                                      </div>
                                  </div><!-- /.modal-content -->
                              </div><!-- /.modal-dialog -->
                          </div><!-- /.modal -->
            <?php
            }
            ?>
            </table>
            <?php
        }
            ?>
 <!-- RESERVATION FOR WEDDING -->           
            <?php
            $querywedding = $con->query("SELECT * FROM wedding WHERE username = '$username' AND approve='yes' AND `show` ='yes' ORDER BY id DESC");
            if ($querywedding->num_rows > 0){
                ?>
        <table class="table table-bordered">
        <th colspan="4" style="text-align:center; background-color: pink; color: black;"><h3>Wedding</h3></th>
<tr>
<th>Until</th>
<th>Submit Date</th>
<th>Approved</th>
<th>Action</th>
</tr>
                <?php
            while ($rowwedding = $querywedding->fetch_array()) {
              ?>
              <tr>
                  <td><?php echo $rowwedding['until']; ?></td>
                  <td><?php echo $rowwedding['submitdate']; ?></td>
                  <td><span style="color:green;"><?php echo $rowwedding['approve']; ?></span></td>
                  <td>
                       <a href="#viewWedding<?php echo $rowwedding['id']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>View</a>
                  </td>
              </tr>
                                 <!-- Modal Wedding -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="viewWedding<?php echo $rowwedding['id']; ?>" class="modal fade" style="display: none;">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Info</h4>
        </div>
<div class="modal-body">
<form class="form-horizontal">
          <strong>Username: </strong><label><?php echo $rowwedding['username']; ?></label><br>
              <strong>Email: </strong><label><?php echo $rowwedding['email']; ?></label><br>
              <strong>Contact: </strong><label><?php echo $rowwedding['contact']; ?></label><br>
              <h4>Groom</h4>
              <strong>Firstname: </strong><label><?php echo $rowwedding['groomfirstname']; ?></label><br>
              <strong>Surname: </strong><label><?php echo $rowwedding['groomsurname']; ?></label><br>
              <strong>Age: </strong><label><?php echo $rowwedding['groomage']; ?></label><br>
              <strong>Occupation: </strong><label><?php echo $rowwedding['goccupation']; ?></label><br>
              <h4>Groom Father</h4>
              <strong>Firstname: </strong><label><?php echo $rowwedding['gffirstname']; ?></label><br>
              <strong>Surname: </strong><label><?php echo $rowwedding['gfsurname']; ?></label><br>
              <strong>Occupation: </strong><label><?php echo $rowwedding['gfoccupation']; ?></label><br>
              <h4>Bride</h4>
              <strong>Firstname: </strong><label><?php echo $rowwedding['bridefirstname']; ?></label><br>
              <strong>Surname: </strong><label><?php echo $rowwedding['bridesurname']; ?></label><br>
              <strong>Age: </strong><label><?php echo $rowwedding['brideage']; ?></label><br>
              <h4>Bride Father</h4>
              <strong>Firstname: </strong><label><?php echo $rowwedding['bffirstname']; ?></label><br>
              <strong>Surname: </strong><label><?php echo $rowwedding['bfsurname']; ?></label><br>
              <strong>Occupation: </strong><label><?php echo $rowwedding['bfoccupation']; ?></label><br>
              <strong>Church: </strong><label><?php echo $rowwedding['church']; ?></label><br>
              <strong>Town: </strong><label><?php echo $rowwedding['town']; ?></label><br>
              <strong>Date: </strong><label><?php echo $rowwedding['date']; ?></label><br>
              <strong>Until: </strong><label><?php echo $rowwedding['until']; ?></label><br>
              <strong>Submit Date: </strong><label><?php echo $rowwedding['submitdate']; ?></label><br>
              <span style="color:green;"><strong>Approved: </strong><label><?php echo $rowwedding['approve']; ?></label></span>
        </form>
                                      </div>
                                  </div><!-- /.modal-content -->
                              </div><!-- /.modal-dialog -->
                          </div><!-- /.modal -->
              <?php
            }
            ?>
            </table>
            <?php
        }
            ?>

<!-- RESERVATION FOR CHRISTENING -->
            <?php
            $querychristening = $con->query("SELECT * FROM christening WHERE username = '$username' AND approve='yes' AND `show` ='yes' ORDER BY id DESC");
            if ($querychristening->num_rows > 0){
                ?>
        <table class="table table-bordered">
        <th colspan="4" style="text-align:center; background-color: lightblue; color: black;"><h3>Christening</h3></th>
<tr>
<th>Until</th>
<th>Submit Date</th>
<th>Approved</th>
<th>Action</th>
</tr>
                <?php
            while ($rowchristening = $querychristening->fetch_array()) {
              ?>
              <tr>
                  <td><?php echo $rowchristening['until']; ?></td>
                  <td><?php echo $rowchristening['submitdate']; ?></td>
                  <td><span style="color:green;"><?php echo $rowchristening['approve']; ?></span></td>
                  <td>
                      <a href="#viewChristening<?php echo $rowchristening['id']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>View</a>
                  </td>
              </tr>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="viewChristening<?php echo $rowchristening['id']; ?>" class="modal fade" style="display: none;">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Info</h4>
        </div>
<div class="modal-body">
<form class="form-horizontal">
<strong>Username: </strong><label><?php echo $rowchristening['username']; ?></label><br>
              <strong>Email: </strong><label><?php echo $rowchristening['email']; ?></label><br>
              <strong>Contact: </strong><label><?php echo $rowchristening['contact']; ?></label><br>
              <strong>Firstname: </strong><label><?php echo $rowchristening['firstname']; ?></label><br>
              <strong>Surname: </strong><label><?php echo $rowchristening['surname']; ?></label><br>
              <strong>Father's name: </strong><label><?php echo $rowchristening['fname']; ?></label><br>
              <strong>Mother's name: </strong><label><?php echo $rowchristening['mname']; ?></label><br>
              <strong>Father's Occupation: </strong><label><?php echo $rowchristening['foccupation']; ?></label><br>
              <strong>Place of Birth: </strong><label><?php echo $rowchristening['placeofbirth']; ?></label><br>
              <strong>Date of Birth: </strong><label><?php echo $rowchristening['dateofbirth']; ?></label><br>
              <strong>Church: </strong><label><?php echo $rowchristening['church']; ?></label><br>
              <strong>Town: </strong><label><?php echo $rowchristening['town']; ?></label><br>
              <strong>Date: </strong><label><?php echo $rowchristening['date']; ?></label><br>
              <strong>Until: </strong><label><?php echo $rowchristening['until']; ?></label><br>
              <strong>Submit Date: </strong><label><?php echo $rowchristening['submitdate']; ?></label><br>
              <span style="color:green;"><strong>Approved: </strong><label><?php echo $rowchristening['approve']; ?></label></span>
        </form>
                                      </div>
                                  </div><!-- /.modal-content -->
                              </div><!-- /.modal-dialog -->
                          </div><!-- /.modal -->
              <?php
            }
            ?>
             </table>
            <?php
        }
            ?>
        </div>
</section>
                        <?php
                    }}else{
                        ?>
<section id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Our Services</h2>
                    <hr class="primary">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <img src="img/Wake.png" width="130px" height="130px">
                        <h3>Wake</h3>
                        <!-- <p class="text-muted">Our templates are updated regularly so they don't break.</p>  --> 
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <img src="img/Wedding.png" width="130px" height="130px">
                        <h3>Wedding</h3>
                        <!-- <p class="text-muted">You can use this theme as is, or you can make changes!</p> -->
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <img src="img/Visit.png" width="130px" height="130px">
                        <h3>Tourist Visiting</h3>
                       <!--  <p class="text-muted">We update dependencies to keep things fresh.</p> -->
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <img src="img/Christening.png" width="130px" height="130px">
                        <h3>Christening</h3>
                        <!-- <p class="text-muted">You have to make your websites with love these days!</p> -->
                    </div>
                </div>
            </div>
        </div>
</section>
<?php
}
?>

    <section class="no-padding" id="galleries" class=bg-dark style="text-align:center;">
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">

     <?php
     $countheader = 0;
    include('include/connect_to_db.php');
    $queryheader = $con->query('SELECT * FROM church ORDER BY town');
    if ($queryheader->num_rows > 0) {
        while ($rowheader = $queryheader->fetch_array()) {
            $countheader = $countheader + 1;
            if ($countheader === 1 ) {         
            ?>
                <div class="item active">
                    <a href="church.php?v=<?php echo $rowheader['coordinate']; ?>" class="portfolio-box">
                        <img src="church-gallery/<?php echo $rowheader['img']; ?>" class="img-responsive" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-name">                        
                                 <?php echo $rowheader['churchname']; ?>
                                </div>
                                <div class="project-category text-faded">
                                 <?php echo $rowheader['town']; ?>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php
            }else{
            ?>
            <div class="item">
                    <a href="church.php?v=<?php echo $rowheader['coordinate']; ?>" class="portfolio-box">
                        <img src="church-gallery/<?php echo $rowheader['img']; ?>" class="img-responsive" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-name">
                                  <?php echo $rowheader['churchname']; ?>
                                </div>
                                 <div class="project-category text-faded">
                                    <?php echo $rowheader['town']; ?>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
    <?php
    } } }
 ?> 
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
      <section class=bg-dark>
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
     <?php
    include('include/connect_to_db.php');
    $queryheader = $con->query('SELECT * FROM church ORDER BY town');
    $dot = 0;
    if ($queryheader->num_rows > 0) {
        while ($rowheader = $queryheader->fetch_array()) {
            $dot = $dot + 1;
            ?>
    <li data-target="#carousel-example-generic" data-slide-to="<?php echo $dot; ?>"></li>
    <?php
        }
    }
    ?> 
  </ol>
    </section>
</div>
    </section>

    <section id="forum">
               <div class="container">
            <div class="row text-center">
                <div class="col-lg-10 col-lg-offset-1">
                    <h2>F O R U M S</h2>
<script>
// if user is login
<?php
    if (isset($_SESSION['islogin'])) {         
                    if (isset($_SESSION['id'])){
?>

function ajax_post(){
    // Create our XMLHttpRequest object
    var hr = new XMLHttpRequest();
    // Create some variables we need to send to our PHP file
    var url = "include/my_parse_file.php";
    var fn = document.getElementById("suggest").value;
    var th = document.getElementById("typeThread").value;
    // var ln = document.getElementById("last_name").value;
    var vars = "suggest="+fn+"&thread="+th;
    hr.open("POST", url, true);
    // Set content type header information for sending url encoded variables in the request
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // Access the onreadystatechange event for the XMLHttpRequest object
    hr.onreadystatechange = function() {
        if(hr.readyState == 4 && hr.status == 200) {
            var return_data = hr.responseText;
            document.getElementById("status").innerHTML = return_data;
        }
    }
    // Send the data to PHP now... and wait for response to update the status div
    hr.send(vars); // Actually execute the request
    document.getElementById("status").innerHTML = "processing...";
    document.getElementById("suggest").value = "";
}

function ajax_reply(reply,postid,statusreply){
    // Create our XMLHttpRequest object
    var hr = new XMLHttpRequest();
    // Create some variables we need to send to our PHP file
    var url = "include/reply.php";
    var fn = document.getElementById(reply).value;
    var id  = document.getElementById(postid).value;
    // var ln = document.getElementById("last_name").value;
    var vars = "reply="+fn+"&id="+id;
    hr.open("POST", url, true);
    // Set content type header information for sending url encoded variables in the request
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // Access the onreadystatechange event for the XMLHttpRequest object
    hr.onreadystatechange = function() {
        if(hr.readyState == 4 && hr.status == 200) {
            var return_data = hr.responseText;
            document.getElementById(statusreply).innerHTML = return_data;
        }
    }
    // Send the data to PHP now... and wait for response to update the status div
    hr.send(vars); // Actually execute the request
    document.getElementById(statusreply).innerHTML = "processing...";
    document.getElementById(reply).value = "";
}

function buglist()
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("status").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("POST","include/ajax_buglist.php",true);
xmlhttp.send();
}

function newslist()
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("status").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("POST","include/ajax_newslist.php",true);
xmlhttp.send();
}

function suggestionslist()
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("status").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("POST","include/ajax_suggestionlist.php",true);
xmlhttp.send();
}

function faqlist()
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("status").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("POST","include/ajax_faqlist.php",true);
xmlhttp.send();
}

// if not login
<?php
}}else{
?>

function buglist()
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("status").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("POST","include/ajax_buglist_index.php",true);
xmlhttp.send();
}

function newslist()
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("status").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("POST","include/ajax_newslist_index.php",true);
xmlhttp.send();
}

function suggestionslist()
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("status").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("POST","include/ajax_suggestionlist_index.php",true);
xmlhttp.send();
}

function faqlist()
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("status").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("POST","include/ajax_faqlist_index.php",true);
xmlhttp.send();
}

<?php
}
?>
</script>

<!-- Threads -->    
<div style="background-color: white; padding: 5vh;">

    <div class="row">
        <div class="col-sm-3 col-md-2">
            <ul id="mailboxes-desktop" class="hidden-xs hidden-sm nav nav-pills nav-stacked">
                <li><button class="btn btn-danger btn-sm btn-block"  type="button" onclick="newslist()">News</button></li>
                <li><button class="btn btn-danger btn-sm btn-block" type="button" onclick="buglist()">Bug Report</button></li>
                <li><button class="btn btn-danger btn-sm btn-block" type="button" onclick="suggestionslist()">Suggestions</button></li>
                <li><button class="btn btn-danger btn-sm btn-block" type="button" onclick="faqlist()">FAQ</button></li>
            </ul>
            <div id="mailboxes-mobile" class="hidden-md hidden-lg">
                <button type="button" class="btn btn-block btn-default dropdown-toggle" data-toggle="dropdown">
                    Threads <span class="caret"></span><span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu btn-block" role="menu">
                <li><button class="btn btn-danger btn-sm btn-block" type="button" onclick="newslist()">News</button></li>
                <li><button class="btn btn-danger btn-sm btn-block" type="button" onclick="buglist()">Bug Report</button></li>
                <li><button class="btn btn-danger btn-sm btn-block" type="button" onclick="suggestionslist()">Suggestions</button></li>
                <li><button class="btn btn-danger btn-sm btn-block" type="button" onclick="faqlist()">FAQ</button></li>
                </ul>
            </div>
        </div>


        <div class="col-sm-9 col-md-10">
            <div id="home">
                <div class="list-group">
                <div id="messagelist">

<div id="status" bgcolor="white">
<?php
    if (isset($_SESSION['islogin'])) {         
                    if (isset($_SESSION['id'])){
?>
<div id="status" bgcolor="white">
<span style="color:black;"><h1>News</h1></span>
    <?php
    $var = 0;
    if(isset($_POST['submit'])){
}else{
     $post = $con->query("SELECT * FROM post WHERE type='News' ORDER BY `id` DESC");
while ($rowpost = $post->fetch_array()){
$postid = $rowpost['id'];
$var = $var + 1;
if ($var == 3) {
    ?>
<div class="collapse" id="forum-read-more2" style="background-color: gray;">
    <?php
}
if ($var >= 3){
?>
<div class="message">
<a data-toggle="modal" class="list-group-item">
<div style="border: 1px solid gray; background: white; color: black; text-align: left;">
<?php if($rowpost['username'] === $username){
?>
<div style="float:right;">
        <a href="include/delete_post.php?id=<?php echo $rowpost['id']; ?>">Delete</a>
</div>
<?php
}
?>
<b><?php echo $rowpost['username']; ?></b><br>
<p><?php echo $rowpost['date']; ?></p>
<p><?php echo $rowpost['post']; ?></p>
<?php
$report_post = $con->query("SELECT * FROM report_post WHERE username = '$username' AND id = '$postid'");
if($rowpost['username'] === ($_SESSION['username'])){
}else if($report_post->num_rows > 0){}else{
?>
<a style="margin:0 10vh 0 10vh;" href="include/report_post.php?id=<?php echo $rowpost['id']; ?>">Report</a>
<?php
}
?>
<!-- Comments -->
<a data-toggle="collapse" href="#collapse<?php echo $postid; ?>" aria-expanded="false" aria-controls="collapseExample">
  Comments
</a>
<div class="collapse" id="collapse<?php echo $postid; ?>" style="background-color: gray;">
<div id="status-reply-<?php echo $postid; ?>">
<?php
    $reply = $con->query("SELECT * FROM reply WHERE id = '$postid'");
    while ($replypost = $reply->fetch_array()){
?>
<div style="border: 1px solid gray;">
<?php if($replypost['username'] === $username){
?>
<div style="float:right;">
        <a href="include/delete_reply.php?id=<?php echo $replypost['id']; ?>&id2=<?php echo $replypost['idreply']; ?>">Delete</a>
</div>
<?php
}
?>
<b><?php echo $replypost['username']; ?></b><br>
<p><?php echo $replypost['date']; ?></p>
<p><?php echo $replypost['post']; ?></p>
<?php
$reportid = $replypost['id'];
$idreply = $replypost['idreply'];
$report_reply = $con->query("SELECT * FROM report_reply WHERE username = '$username' AND id = '$reportid' AND idreply = '$idreply'");
if($replypost['username'] === ($_SESSION['username'])){}else if($report_reply->num_rows > 0){}else{
?>
<a style="margin:0 10vh 0 10vh;" href="include/report_reply.php?id=<?php echo $replypost['id']; ?>&id2=<?php echo $replypost['idreply']; ?>">Report</a>
<?php
}
?>
</div>
<?php
}
?>
<form method="POST">
    <textarea class="form-control" rows="3" id="reply<?php echo $postid; ?>" name="reply<?php echo $postid; ?>" required></textarea>
    <input type="hidden" name="post_id<?php echo $postid; ?>" id="post_id<?php echo $postid; ?>" value="<?php echo $postid; ?>">
    <input type="submit" class="btn btn-dark" value="Reply" onclick="ajax_reply('reply<?php echo $postid; ?>','post_id<?php echo $postid; ?>','status-reply-<?php echo $postid; ?>');"></input>
</form>
 </a>
</div>
</div>
</div>
</div>
<?php
}else{
?>
<div class="message">
<a data-toggle="modal" class="list-group-item">
<div style="border: 1px solid gray; background: white; color: black; text-align: left;">
<?php if($rowpost['username'] === $username){
?>
<div style="float:right;">
        <a href="include/delete_post.php?id=<?php echo $rowpost['id']; ?>">Delete</a>
</div>
<?php
}
?>
<b><?php echo $rowpost['username']; ?></b><br>
<p><?php echo $rowpost['date']; ?></p>
<p><?php echo $rowpost['post']; ?></p>
<?php
$report_post = $con->query("SELECT * FROM report_post WHERE username = '$username' AND id = '$postid'");
if($rowpost['username'] === ($_SESSION['username'])){
}else if($report_post->num_rows > 0){}else{
?>
<a style="margin:0 10vh 0 10vh;" href="include/report_post.php?id=<?php echo $rowpost['id']; ?>">Report</a>
<?php
}
?>
<!-- Comments -->
<a data-toggle="collapse" href="#collapse<?php echo $postid; ?>" aria-expanded="false" aria-controls="collapseExample">
  Comments
</a>
<div class="collapse" id="collapse<?php echo $postid; ?>" style="background-color: gray;">
<div id="status-reply-<?php echo $postid; ?>">
<?php
    $reply = $con->query("SELECT * FROM reply WHERE id = '$postid'");
    while ($replypost = $reply->fetch_array()){
?>
<div style="border: 1px solid gray;">
<?php if($replypost['username'] === $username){
?>
<div style="float:right;">
        <a href="include/delete_reply.php?id=<?php echo $replypost['id']; ?>&id2=<?php echo $replypost['idreply']; ?>">Delete</a>
</div>
<?php
}
?>
<b><?php echo $replypost['username']; ?></b><br>
<p><?php echo $replypost['date']; ?></p>
<p><?php echo $replypost['post']; ?></p>
<?php
$reportid = $replypost['id'];
$idreply = $replypost['idreply'];
$report_reply = $con->query("SELECT * FROM report_reply WHERE username = '$username' AND id = '$reportid' AND idreply = '$idreply'");
if($replypost['username'] === ($_SESSION['username'])){}else if($report_reply->num_rows > 0){}else{
?>
<a style="margin:0 10vh 0 10vh;" href="include/report_reply.php?id=<?php echo $replypost['id']; ?>&id2=<?php echo $replypost['idreply']; ?>">Report</a>
<?php
}
?>
</div>
<?php
}
?>
<form method="POST">
    <textarea class="form-control" rows="3" id="reply<?php echo $postid; ?>" name="reply<?php echo $postid; ?>" required></textarea>
    <input type="hidden" name="post_id<?php echo $postid; ?>" id="post_id<?php echo $postid; ?>" value="<?php echo $postid; ?>">
    <input type="submit" class="btn btn-dark" value="Reply" onclick="ajax_reply('reply<?php echo $postid; ?>','post_id<?php echo $postid; ?>','status-reply-<?php echo $postid; ?>');">
</form>
</a>
</div>
</div>
</div>
</div>
<?php
}}
?>
</div>
<?php
if ($var == 3) {
    ?>
</div>
<?php
}}
if ($var > 2) {
?>
<a data-toggle="collapse" class="btn btn-light" href="#forum-read-more2" aria-expanded="false" aria-controls="collapseExample">
  Read More
</a>  
<?php
}
?>

<!-- if not login forum -->
<?php
}}else{
?>
<span style="color:black;"><h1>News</h1></span>
    <?php
    $var = 0;
    if(isset($_POST['submit'])){
}else{
     $post = $con->query("SELECT * FROM post WHERE type='News' ORDER BY `id` DESC");
while ($rowpost = $post->fetch_array()){
$postid = $rowpost['id'];
$var = $var + 1;
if ($var == 3) {
    ?>
<div class="collapse" id="forum-read-more2" style="background-color: gray;">
    <?php
}
if ($var >= 3){
?>
<div class="message">
<a data-toggle="modal" class="list-group-item">
<div style="border: 1px solid gray; background: white; color: black; text-align: left;">

<b><?php echo $rowpost['username']; ?></b><br>
<p><?php echo $rowpost['date']; ?></p>
<p><?php echo $rowpost['post']; ?></p>
<!-- Comments -->
<a data-toggle="collapse" href="#collapse<?php echo $postid; ?>" aria-expanded="false" aria-controls="collapseExample">
  Comments
</a>
<div class="collapse" id="collapse<?php echo $postid; ?>" style="background-color: gray;">
<div id="status-reply-<?php echo $postid; ?>">
<?php
    $reply = $con->query("SELECT * FROM reply WHERE id = '$postid'");
    while ($replypost = $reply->fetch_array()){
?>
<div style="border: 1px solid gray;">

<b><?php echo $replypost['username']; ?></b><br>
<p><?php echo $replypost['date']; ?></p>
<p><?php echo $replypost['post']; ?></p>
<?php
$reportid = $replypost['id'];
$idreply = $replypost['idreply'];
?>
</div>
<?php
}
?>
    <textarea class="form-control" rows="3" required></textarea>
    <input type="submit" class="btn btn-dark" value="Reply" data-target=".login" data-toggle="modal"></input>
 </a>
</div>
</div>
</div>
</div>
<?php
}else{
?>
<div class="message">
<a data-toggle="modal" class="list-group-item">
<div style="border: 1px solid gray; background: white; color: black; text-align: left;">

<b><?php echo $rowpost['username']; ?></b><br>
<p><?php echo $rowpost['date']; ?></p>
<p><?php echo $rowpost['post']; ?></p>

<!-- Comments -->
<a data-toggle="collapse" href="#collapse<?php echo $postid; ?>" aria-expanded="false" aria-controls="collapseExample">
  Comments
</a>
<div class="collapse" id="collapse<?php echo $postid; ?>" style="background-color: gray;">
<div id="status-reply-<?php echo $postid; ?>">
<?php
    $reply = $con->query("SELECT * FROM reply WHERE id = '$postid'");
    while ($replypost = $reply->fetch_array()){
?>
<div style="border: 1px solid gray;">

<b><?php echo $replypost['username']; ?></b><br>
<p><?php echo $replypost['date']; ?></p>
<p><?php echo $replypost['post']; ?></p>
<?php
$reportid = $replypost['id'];
$idreply = $replypost['idreply'];
?>
</div>
<?php
}
?>
    <textarea class="form-control" rows="3" ></textarea>
    <input type="submit" class="btn btn-dark" value="Reply" data-target=".login" data-toggle="modal">
</a>
</div>
</div>
</div>
</div>
<?php
}}
?>
</div>
<?php
if ($var == 3) {
    ?>
</div>
<?php
}}
if ($var > 2) {
?>
<a class="btn btn-light" data-target=".login" data-toggle="modal">
  Read More
</a>  
<?php
}}
?>
                </div>
                </div>
            </div>
        </div>
 <!-- /.row (nested) -->
                </div>
                <!-- /.col-lg-10 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->

    </section>

    <section id="contact" class="bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <h2 class="section-heading">Let's Get In Touch!</h2>
                    <hr class="primary">
                    <!-- <p>Ready to start your next project with us? That's great! Give us a call or send us an email and we will get back to you as soon as possible!</p> -->
                </div>
                <div class="col-lg-4 col-lg-offset-2 text-center">
                    <i class="fa fa-phone fa-3x sr-contact"></i>
                    <p>(04)8475-38374</p>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="fa fa-envelope-o fa-3x sr-contact"></i>
                    <p><a href="mailto:your-email@your-domain.com">pampangachurches@gmail.com</a></p>
                </div>
            </div>
        </div>
<script>
$(document).ready(function(e) {
    $('img[usemap]').rwdImageMaps();
    
    $('area').on('click', function() {
        alert($(this).attr('alt') + ' clicked');
    });
});
</script>
    </section>

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="vendor/scrollreveal/scrollreveal.min.js"></script>
    <script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
    <!-- Theme JavaScript -->
    <script src="js/creative.min.js"></script>

</body>

</html>
