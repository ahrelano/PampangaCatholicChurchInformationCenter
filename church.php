<?php
session_start();
if(isset($_SESSION['islogin'])){
    $islogin=$_SESSION['islogin'];
    if ($islogin === 2) {
        header('location: admin/index.php');
        exit();
    }else if  ($islogin === 3) {
        header('location: ../superadmin/index.php');
        exit();
}}

if (empty($_GET['v'])){
    header('location: index.php');
}else{
    $coordinate = $_GET['v'];
}

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

        if (isset($_SESSION['reservation-sent'])) {
        if (empty($_SESSION['reservation-sent'])) {
        }else{
            ?>
            <script type="text/javascript">
                alert('Reservation sent!');
            </script>
            <?php
        $_SESSION['reservation-sent']="";
        }
    }

    if (isset($_SESSION['ratings-save'])) {
        $ratings_save = $_SESSION['ratings-save'];
    if ($ratings_save === 'YES') {
        ?>
        <script type="text/javascript">
            alert('Thank you for your feedback!');
        </script>
        <?php
    $_SESSION['ratings-save']="";
    }else if($ratings_save === 'NO'){
        ?>
        <script type="text/javascript">
            alert('Sorry, you can only rate once!');
        </script>
        <?php
    $_SESSION['ratings-save']="";
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

    <title>
    <?php
    include('include/connect_to_db.php');
    $church = $con->query("SELECT * FROM church WHERE coordinate = '$coordinate'");
    while ($numchurchname = $church->fetch_array()) {
    $churchname = $numchurchname['churchname'];
    $currentchurchtown = $numchurchname['town'];
    $currentchurchheader = $numchurchname['img'];
    $_SESSION['coordinate'] = $numchurchname['coordinate'];
    echo $numchurchname['churchname'];
    }
    ?>
    </title>

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
                        <a class="page-scroll" href="index.php">Back to Homepage</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#map">Map</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#history">History</a>
                    </li>
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
                        <a class="page-scroll" href="#mass">Mass Schedule</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#verse">Daily Bible Verse</a>
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
    <a href="include/logout.php?id=<?php echo $id; ?>&v=<?php echo $coordinate; ?>">Logout</a>
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

    <header style="background-image: url('church-gallery/<?php echo $currentchurchheader ?>');">
        <div class="header-content">
            <div class="header-content-inner">
                <h1 id="homeHeading"><?php echo $churchname; ?></h1>
                <h3><?php echo $currentchurchtown; ?></h3>
                <hr>
                <!-- <p>Start Bootstrap can help you build better websites using the Bootstrap CSS framework! Just download your template and start going, no strings attached!</p> -->
                <a href="#map" class="btn btn-primary btn-xl page-scroll">Find Out More</a>
            </div>
        </div>
    </header>
   <!--  Map -->
    <section class="bg-primary no-padding" id="map">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <h2 class="section-heading">Church Navigator</h2>
                    <hr class="light">
                    <p class="text-faded">This feature allows the navigation of different churches in the province of Pampanga</p>
                </div>
                <section style="height: 500px;">
                    <iframe  width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?q=<?php echo $coordinate;?>&z=10&output=embed"></iframe>
                </section>
            </div>
        </div>
    </section>
<!-- History -->
  <section id="history">
        <div class="container" style="color:black;">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>H i s t o r y</h2>
<!--
  Don't use the "5-unsafe" CDN version in your own code. It will break on you.
  Instead go to videojs.com and copy the CDN urls for the latest version.
-->
<?php
    if (isset($_SESSION['islogin'])) {
                    if (isset($_SESSION['id'])){
?>
<div id="instructions">
<?php
include ('include/connect_to_db.php');
    $queryvideo = $con->query("SELECT * FROM video WHERE coordinate = '$coordinate'");
    if ($queryvideo->num_rows > 0) {
      ?>
<video width="100%" height="100%" controls>
  <?php
    while ($rowvideo = $queryvideo->fetch_array()) {
  ?>
    <source src="video/<?php echo $rowvideo['name']; ?>.mp4" type='video/mp4' />
    <source src="video/<?php echo $rowvideo['name']; ?>.webm" type='video/webm' />
    <source src="video/<?php echo $rowvideo['name']; ?>.mpg" type='video/mpg' />
    <source src="video/<?php echo $rowvideo['name']; ?>.ogg" type='video/ogg' />
    <source src="video/<?php echo $rowvideo['name']; ?>.mpeg" type='video/mpeg' />

<?php } ?>
  </video>
<?php
    }
  ?>
                </div>

                <div class="collapse" id="viewHistory">
                <?php
                $queryhistory = $con->query("SELECT * FROM history WHERE coordinate = '$coordinate'");
                if ($queryhistory->num_rows > 0) {
                while ($rowhistory = $queryhistory->fetch_array()) {
                    ?>
                    <h2><?php echo $rowhistory['title']; ?></h2>
                    <p><?php echo $rowhistory['info']; ?></p><br><br>
                    <?php if (($rowhistory['priest']) <> ""){
                        $present = "Present Priest";
                        $priest = $rowhistory['priest'];
                    }}}else{
                        echo "<h3>No history!</h3>";
                    }
                ?>
                <h3><?php
                if (isset($present)) {
                echo $present;
                   }
                ?></h3>
                    <label><span style="text-align: right;"><?php
        if (isset($priest)) {
                    echo $priest;
                }
                    ?></span></label>

                </div>
                <a class="btn btn-primary btn-xl" data-toggle="collapse" href="#viewHistory" aria-expanded="false" aria-controls="collapseExample" role="button">Learn More</a>
<?php
}}else{
?>

<div id="instructions">
<?php
include ('include/connect_to_db.php');
    $queryvideo = $con->query("SELECT * FROM video WHERE coordinate = '$coordinate'");
    if ($queryvideo->num_rows > 0) {
      ?>
<video width="100%" height="100%" controls>
  <?php
    while ($rowvideo = $queryvideo->fetch_array()) {
  ?>
    <source src="video/<?php echo $rowvideo['name']; ?>.mp4" type='video/mp4' />
    <source src="video/<?php echo $rowvideo['name']; ?>.webm" type='video/webm' />
    <source src="video/<?php echo $rowvideo['name']; ?>.mpg" type='video/mpg' />
    <source src="video/<?php echo $rowvideo['name']; ?>.ogg" type='video/ogg' />
    <source src="video/<?php echo $rowvideo['name']; ?>.mpeg" type='video/mpeg' />

<?php } ?>
  </video>
<?php
    }
  ?>
                </div>
                <a class="btn btn-primary btn-xl" href="" data-toggle="modal" data-target=".login">Learn More</a>

<?php
}
?>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
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
                <form class="sa-innate-form" method="post" action="include/checklogin.php?v=<?php echo $coordinate; ?>">
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
                <form class="sa-innate-form" method="post" action="include/checkregister.php?v=<?php echo $coordinate; ?>">
                    <label>Username</label>
                    <input type="text" name="username" id="username" onkeyup="checkusername()" maxlength="16" autofocus required>
                    <span id="usernamestatus" style="color:red;"></span><br>
                    <label>Email</label>
                    <input type="email" name="email" id="email" onkeyup="checkemail()" required>
                    <span id="emailstatus" style="color:red;"></span><br>
                    <label>Password</label>
                    <input type="password" name="password" required>
                    <button type="submit" id="signUpBtn" disabled>Sign Up</button>
                </form>
                </div>
            </div>
    </div>
    </div>
    </div>
</div>
<!-- Daily Bible Verse -->
<section id="verse" class="bg-primary">
    <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Daily Bible Verse</h2>
                    <hr class="primary">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
            <?php
           include('include/connect_to_db.php');
           $fulldate = date('F d, Y');
           $queryverse = $con->query("SELECT * FROM dailyverse WHERE coordinate = '$coordinate' AND `date` = '$fulldate'");
           if ($queryverse->num_rows > 0){
            while ($rowverse = $queryverse->fetch_array()) {
                ?>
                    <div class="text-center">
                    <div class="service-box">
                                <h4>
                                    <strong><?php echo $rowverse['verse']; ?></strong>
                                </h4>
                                <hr class="small">
                                <p><?php echo $rowverse['text']; ?></p>
                            </div>
                        </div>
                    <?php }} ?>
        </div>
        </div>
</section>
<!-- Mass Schedule -->
<section id="mass">
    <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Mass Schedule</h2>
                    <hr class="primary">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
            <?php
$countmass = 0;
include('include/connect_to_db.php');
$querymass = $con->query("SELECT * FROM mass WHERE coordinate = '$coordinate'");
if ($querymass->num_rows > 0) {
    while ($rowmass = $querymass->fetch_array()) {
        $countmass = $countmass + 1;
            if ($countmass === 4) {
                 ?>
                 <div class="row">
                 <?php
            }
        if($rowmass['type'] == ""){
            ?>
            <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                                <h4>
                                    <strong><?php echo $rowmass['date']; ?></strong>
                                </h4>
                                <hr class="small">
                                <p><?php echo $rowmass['time']; ?></p>
                            </div>
                        </div>
            <?php
        }else{
            ?>
            <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                                <h4>
                                    <strong><?php echo $rowmass['type']; ?></strong>
                                </h4>
                                <h6><strong><?php echo $rowmass['date']; ?></strong></h6>
                                <hr class="small">
                                <p><?php echo $rowmass['time']; ?></p>
                            </div>
                        </div>
            <?php
        }
        if ($countmass === 4) {
                    ?>
                    </div>
                    <?php
                    $count = 0;
                    }
    }
}
?>
        </div>
        </div>
</section>

<section id="services" class="bg-primary">
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
                        <!-- <p class="text-muted">Our templates are updated regularly so they don't break.</p>
 -->                         <a href="#modalWake" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm btn-block" role="button"><i class="glyphicon glyphicon-pencil"></i>Reserve Now</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <img src="img/Wedding.png" width="130px" height="130px">
                        <h3>Wedding</h3>
                        <!-- <p class="text-muted">You can use this theme as is, or you can make changes!</p> -->
                        <a href="#modalWedding" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm btn-block" role="button"><i class="glyphicon glyphicon-pencil"></i>Reserve Now</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <img src="img/Visit.png" width="130px" height="130px">
                        <h3>Tourist Visiting</h3>
                        <!-- <p class="text-muted">We update dependencies to keep things fresh.</p> -->
                        <a href="#modalTouristVisiting" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm btn-block" role="button"><i class="glyphicon glyphicon-pencil"></i>Reserve Now</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <img src="img/Christening.png" width="130px" height="130px">
                        <h3>Christening</h3>
                        <!-- <p class="text-muted">You have to make your websites with love these days!</p> -->
                        <a href="#modalChristening" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm btn-block" role="button"><i class="glyphicon glyphicon-pencil"></i>Reserve Now</a>
                    </div>
                </div>
            </div>
        </div>
</section>
<?php
    if (isset($_SESSION['islogin'])) {
                    if (isset($_SESSION['id'])){
                        $id = $_SESSION['id'];
                        $queryemail = $con->query("SELECT email FROM account WHERE id = '$id' LIMIT 1");
                        if ($queryemail->num_rows > 0) {
                            while ($numemail = $queryemail->fetch_array()) {
                            $email = $numemail['email'];
                        }}

?>

<!-- Modal Wake -->
                          <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modalWake" class="modal fade" style="display: none;">
                              <div class="modal-dialog">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                          <h4 class="modal-title">Wake</h4>
                                      </div>
                                      <div class="modal-body">
<form action="auth/submitwake.php?v=<?php echo $coordinate . '&town=' . $currentchurchtown ; ?>" method="post" class="form-horizontal">
<div class="form-group">
        <label class="col-lg-2 control-label">Church</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" id="wakeChurch" name="wakeChurch" value="<?php echo $churchname; ?>" readonly>
           <input type="hidden" id="typeWake" name="typeWake" value="Wake">
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Username</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" id="wakeUsername" name="wakeUsername" value="<?php echo ($_SESSION['username']); ?>"readonly>
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Email</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" id="wakeEmail" name="wakeEmail" value="<?php echo $email; ?>"readonly>
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Name</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" id="wakeName" name="wakeName" onblur="validate()" required>
           </div>
        </div>
      <div class="form-group">
        <label class="col-lg-2 control-label">Age</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" name="wakeAge" id="wakeAge" onkeyup="validate()" required>
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Contact No:</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" name="wakeContact" id="wakeContact" onkeyup="validate()" required>
           </div>
        </div>

<div class="container">
<div class="form-group">
        <label class="col-lg-2 control-label">Choose Date</label>
           <div class="col-lg-10">
<input class="form-control" id="demoWake" name="demoWake" type="text" onchange="validate()"><br>
</div>
</div>
</div>
<div class="form-group">
        <div class="col-lg-10">
        <span id="errorWake" style="color:red;"></span>
        </div>
        </div>
 <button type="submit" class="btn btn-danger btn-sm" id="btnWake" onclick="submitwake()" disabled>Submit</button><br>
        </form>
                                      </div>
                                  </div><!-- /.modal-content -->
                              </div><!-- /.modal-dialog -->
                          </div><!-- /.modal -->

<script type="text/javascript">
  function validate(){
        var status = document.getElementById("errorWake");
        var name = document.getElementById("wakeName").value;
        var age = document.getElementById("wakeAge").value;
        var date = document.getElementById("demoWake").value;
        var contact = document.getElementById("wakeContact").value;
            status.innerHTML = 'checking...';
            var hr = new XMLHttpRequest();
            hr.open("POST", "auth/error-wake-check.php", true);
            hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            hr.onreadystatechange = function() {
                if(hr.readyState == 4 && hr.status == 200) {
                    status.innerHTML = hr.responseText;
                    if (hr.responseText == "ok") {
                        status.innerHTML = "";
                        //enable submit button here
                        document.getElementById('btnWake').disabled = false;
                    }else {
                        document.getElementById('btnWake').disabled = true;
                    }
                }
            }
            var v = "name=" + name + "&age=" + age + "&date=" + date + "&contact=" + contact;
            hr.send(v);
    }
</script>

<!-- Modal Christening-->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modalChristening" class="modal fade" style="display: none;">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Christening</h4>
        </div>
        <div class="modal-body">
<form action="auth/submitchristening.php?v=<?php echo $coordinate . '&town=' . $currentchurchtown ; ?>" method="post" class="form-horizontal">
<div class="form-group">
        <label class="col-lg-2 control-label">Church</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" id="christeningChurch" name="christeningChurch" value="<?php echo $churchname; ?>" readonly>
           <input type="hidden" id="typeChristening" name="typeChristening" value="Christening">
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Username</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" id="christeningUsername" name="christeningUsername" value="<?php echo ($_SESSION['username']); ?>"readonly>
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Email</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" id="christeningEmail" name="christeningEmail" value="<?php echo $email; ?>"readonly>
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Contact No:</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" name="christeningContact" id="christeningContact" onkeyup="validateChristening()" required>
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Firstname</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" name="christening-first" id="christening-first" required>
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Surname</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" name="christening-sur" id="christening-sur" required>
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Father Name</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" name="christening-fname" id="christening-fname" required>
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Mother Name</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" name="christening-mname" id="wake-mname" required>
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Father Occupation</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" name="christening-occupation" id="christening-occupation" required>
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Place of Birth</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" name="christening-birth" id="christening-birth" required>
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Date of birth</label>
           <div class="col-lg-10">
        <select id="christening-month" name="christening-month" onchange="validateChristening()">
<option value="Month" selected>Month</option>
<option value="January">January</option>
<option value="February">February</option>
<option value="March">March</option>
<option value="April">April</option>
<option value="May">May</option>
<option value="June">June</option>
<option value="July">July</option>
<option value="August">August</option>
<option value="September">September</option>
<option value="October">October</option>
<option value="November">November</option>
<option value="December">December</option>
</select>

<select name="christening-day" id="christening-day" onchange="validateChristening()">
  <option value="Day" selected>Day</option>
  <script type="text/javascript">
for(var i=1;i<=31;i++)
{
    document.write("<option name='"+i+"'>"+i+"</option>");
}
</script>
</select>

<select name="christening-year" id="christening-year" onchange="validateChristening()">
<option value="Year" selected>Year</option>
<script type="text/javascript">
for(var i=2016;i>=1905;i--)
{
    document.write("<option name='"+i+"'>"+i+"</option>");
}
</script>
</select><br>
        </div>
        </div>
                  <div class="container">
<div class="form-group">
        <label class="col-lg-2 control-label">Choose Date</label>
           <div class="col-lg-10">
<input class="form-control" id="demoChristening" name="demoChristening" type="text" onchange="validateChristening()">
</div>
</div>
</div>
<div class="form-group">
        <div class="col-lg-10">
        <span id="errorChristening" style="color:red;"></span>
        </div>
        </div>
        <button type="submit" class="btn btn-danger btn-sm" id="btnChristening" disabled>Submit</button><br>
        </form>
                                      </div>
                                  </div><!-- /.modal-content -->
                              </div><!-- /.modal-dialog -->
                          </div><!-- /.modal -->
<script type="text/javascript">
  function validateChristening(){
        var status = document.getElementById("errorChristening");
        var month = document.getElementById("christening-month").value;
        var year = document.getElementById("christening-year").value;
        var day = document.getElementById("christening-day").value;
        var date = document.getElementById("demoChristening").value;
        var username = document.getElementById("christeningUsername").value;
        var contact = document.getElementById("christeningContact").value;

            status.innerHTML = 'checking...';
            var hr = new XMLHttpRequest();
            hr.open("POST", "auth/error-christening-check.php", true);
            hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            hr.onreadystatechange = function() {
                if(hr.readyState == 4 && hr.status == 200) {
                    status.innerHTML = hr.responseText;
                    if (hr.responseText == "ok") {
                        status.innerHTML = "";
                        //enable submit button here
                        document.getElementById('btnChristening').disabled = false;
                    }else {
                        document.getElementById('btnChristening').disabled = true;
                    }
                }
            }
            var v = "month=" + month + "&year=" + year + "&day=" + day + "&date=" + date + "&username=" + username + "&contact=" + contact;
            hr.send(v);
    }
</script>

<!-- Modal Wedding -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modalWedding" class="modal fade" style="display: none;">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Wedding</h4>
        </div>
<div class="modal-body">
<form action="auth/submitwedding.php?v=<?php echo $coordinate . '&town=' . $currentchurchtown ; ?>" method="post" class="form-horizontal">
<div class="form-group">
        <label class="col-lg-2 control-label">Church</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" id="weddingChurch" name="weddingChurch" value="<?php echo $churchname; ?>" readonly>
           <input type="hidden" id="typeWedding" name="typeWedding" value="Wedding">
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Username</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" id="weddingUsername" name="weddingUsername" value="<?php echo ($_SESSION['username']); ?>"readonly>
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Email</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" id="weddingEmail" name="weddingEmail" value="<?php echo $email; ?>"readonly>
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Contact No:</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" name="weddingContact" id="weddingContact" onkeyup="checkwedage()" required>
           </div>
        </div>
<h3 style="text-align:center;">Groom</h3>
        <div class="form-group">
        <label class="col-lg-2 control-label">Firstname</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" name="wedding-gfirst" id="wedding-gfirst" required>
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Surname</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" name="wedding-gsur" id="wedding-gsur" required>
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Age</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" name="wedding-gage" id="wedding-gage" onkeyup="checkwedage()" required>
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Occupation</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" name="wedding-goccupation" id="wedding-goccupation" required>
           </div>
        </div>
<h3 style="text-align:center;">Groom Father</h3>
        <div class="form-group">
        <label class="col-lg-2 control-label">Firstname</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" name="wedding-gffirst" id="wedding-gffirst" required>
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Surname</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" name="wedding-gfsur" id="wedding-gfsur" required>
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Occupation</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" name="wedding-gfoccupation" id="wedding-gfoccupation" required>
           </div>
        </div>
<h3 style="text-align:center;">Bride</h3>
 <div class="form-group">
        <label class="col-lg-2 control-label">Firstname</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" name="wedding-bfirst" id="wedding-bfirst" required>
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Surname</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" name="wedding-bsur" id="wedding-bsur" required>
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Age</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" name="wedding-bage" id="wedding-bage" onkeyup="checkwedage()" required >
           </div>
        </div>
<h3 style="text-align:center;">Bride Father</h3>
        <div class="form-group">
        <label class="col-lg-2 control-label">Firstname</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" name="wedding-bffirst" id="wedding-bffirst" required>
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Surname</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" name="wedding-bfsur" id="wedding-bfsur" required>
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Occupation</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" name="wedding-bfoccupation" id="wedding-bfoccupation" required>
           </div>
        </div>

<div class="container">
<div class="form-group">
        <label class="col-lg-2 control-label">Choose Date</label>
           <div class="col-lg-10">
<input class="form-control" id="demoWedding" name="demoWedding" type="text" onchange="checkwedage()">
</div>
</div>
</div>
<div class="form-group">
        <div class="col-lg-10">
        <span id="errorWedding" style="color:red;"></span>
        </div>
        </div>
<div class="form-group">
        <div class="col-lg-10">
        <span id="errorWedding" style="color:red;"></span>
        </div>
        </div>
 <button id="btnWedding" type="submit" class="btn btn-danger btn-sm" disabled>Submit</button><br>
        </form>
                                      </div>
                                  </div><!-- /.modal-content -->
                              </div><!-- /.modal-dialog -->
                          </div><!-- /.modal -->

    <script type="text/javascript">
  function checkwedage(){
        var status = document.getElementById("errorWedding");
        var bage = document.getElementById("wedding-bage").value;
        var gage = document.getElementById("wedding-gage").value;
        var wake = document.getElementById("demoWedding").value;
        var contact = document.getElementById("weddingContact").value;
            status.innerHTML = 'checking...';
            var hr = new XMLHttpRequest();
            hr.open("POST", "auth/error-wedding-check.php", true);
            hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            hr.onreadystatechange = function() {
                if(hr.readyState == 4 && hr.status == 200) {
                    status.innerHTML = hr.responseText;
                    if (hr.responseText == "ok") {
                        status.innerHTML = "";
                        //enable submit button here
                        document.getElementById('btnWedding').disabled = false;
                    }else {
                        document.getElementById('btnWedding').disabled = true;
                    }
                }
            }
            var v = "bage=" + bage + "&gage=" + gage + "&wake=" + wake + "&contact=" + contact;
            hr.send(v);
    }

</script>

<?php
}}else{
?>
<!-- Modal Wake -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modalWake" class="modal fade" style="display: none;">
<div class="modal-dialog">
   <div class="modal-content">
      <div class="modal-header">
          <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
          <h4 class="modal-title">Wake</h4>
      </div>
       <div class="modal-body">
<form method="post" class="form-horizontal">
<div class="form-group">
        <label class="col-lg-2 control-label">Church</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" value="<?php echo $churchname; ?>" readonly>
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Username</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" value="Please login first!"readonly>
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Name</label>
           <div class="col-lg-10">
           <input type="text" class="form-control">
           </div>
        </div>
      <div class="form-group">
        <label class="col-lg-2 control-label">Age</label>
           <div class="col-lg-10">
           <input type="text" class="form-control">
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Contact No:</label>
           <div class="col-lg-10">
           <input type="text" class="form-control">
           </div>
        </div>

<div class="container">
<div class="form-group">
        <label class="col-lg-2 control-label">Choose Date</label>
           <div class="col-lg-10">
<input class="form-control" id="demoWake" name="demoWake" type="text"><br>
</div>
</div>
</div>
 <a href="" class="btn btn-danger btn-sm btn-block" role="button" disabled>Submit</a><br>
        </form>
                                      </div>
                                  </div><!-- /.modal-content -->
                              </div><!-- /.modal-dialog -->
                          </div><!-- /.modal -->

<!-- Modal Christening-->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modalChristening" class="modal fade" style="display: none;">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Christening</h4>
        </div>
        <div class="modal-body">
<form method="post" class="form-horizontal">
<div class="form-group">
        <label class="col-lg-2 control-label">Church</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" value="<?php echo $churchname; ?>" readonly>
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Username</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" value="Please login first!" readonly>
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Contact No:</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" >
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Firstname</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" >
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Surname</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" >
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Father Name</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" >
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Mother Name</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" >
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Father Occupation</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" >
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Place of Birth</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" >
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Date of birth</label>
           <div class="col-lg-10">
        <select>
<option value="Month" selected>Month</option>
<option value="January">January</option>
<option value="February">February</option>
<option value="March">March</option>
<option value="April">April</option>
<option value="May">May</option>
<option value="June">June</option>
<option value="July">July</option>
<option value="August">August</option>
<option value="September">September</option>
<option value="October">October</option>
<option value="November">November</option>
<option value="December">December</option>
</select>

<select>
  <option value="Day" selected>Day</option>
  <script type="text/javascript">
for(var i=1;i<=31;i++)
{
    document.write("<option name='"+i+"'>"+i+"</option>");
}
</script>
</select>

<select>
<option value="Year" selected>Year</option>
<script type="text/javascript">
for(var i=2016;i>=1905;i--)
{
    document.write("<option name='"+i+"'>"+i+"</option>");
}
</script>
</select><br>
        </div>
        </div>
                  <div class="container">
<div class="form-group">
        <label class="col-lg-2 control-label">Choose Date</label>
           <div class="col-lg-10">
<input class="form-control" id="demoChristening" name="demoChristening" type="text">
</div>
</div>
</div>
        <a href="" class="btn btn-danger btn-sm btn-block" role="button" disabled>Submit</a><br>
        </form>
                                      </div>
                                  </div><!-- /.modal-content -->
                              </div><!-- /.modal-dialog -->
                          </div><!-- /.modal -->

<!-- Modal Wedding -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modalWedding" class="modal fade" style="display: none;">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Wedding</h4>
        </div>
        <div class="modal-body">
<form method="post" class="form-horizontal">
<div class="form-group">
        <label class="col-lg-2 control-label">Church</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" value="<?php echo $churchname; ?>" readonly>
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Username</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" value="Please login first!" readonly>
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Contact No:</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" >
           </div>
        </div>
<h3 style="text-align:center;">Groom</h3>
        <div class="form-group">
        <label class="col-lg-2 control-label">Firstname</label>
           <div class="col-lg-10">
           <input type="text" class="form-control">
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Surname</label>
           <div class="col-lg-10">
           <input type="text" class="form-control">
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Age</label>
           <div class="col-lg-10">
           <input type="text" class="form-control">
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Occupation</label>
           <div class="col-lg-10">
           <input type="text" class="form-control">
           </div>
        </div>
<h3 style="text-align:center;">Groom Father</h3>
        <div class="form-group">
        <label class="col-lg-2 control-label">Firstname</label>
           <div class="col-lg-10">
           <input type="text" class="form-control">
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Surname</label>
           <div class="col-lg-10">
           <input type="text" class="form-control">
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Occupation</label>
           <div class="col-lg-10">
           <input type="text" class="form-control">
           </div>
        </div>
<h3 style="text-align:center;">Bride</h3>
 <div class="form-group">
        <label class="col-lg-2 control-label">Firstname</label>
           <div class="col-lg-10">
           <input type="text" class="form-control">
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Surname</label>
           <div class="col-lg-10">
           <input type="text" class="form-control">
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Age</label>
           <div class="col-lg-10">
           <input type="text" class="form-control">
           </div>
        </div>
<h3 style="text-align:center;">Bride Father</h3>
        <div class="form-group">
        <label class="col-lg-2 control-label">Firstname</label>
           <div class="col-lg-10">
           <input type="text" class="form-control">
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Surname</label>
           <div class="col-lg-10">
           <input type="text" class="form-control">
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Occupation</label>
           <div class="col-lg-10">
           <input type="text" class="form-control">
           </div>
        </div>

<div class="container">
<div class="form-group">
        <label class="col-lg-2 control-label">Choose Date</label>
           <div class="col-lg-10">
<input class="form-control" id="demoWedding" name="demoWedding" type="text">
</div>
</div>
</div>
<a href="" class="btn btn-danger btn-sm btn-block" role="button" disabled>Submit</a><br>
        </form>
                                      </div>
                                  </div><!-- /.modal-content -->
                              </div><!-- /.modal-dialog -->
                          </div><!-- /.modal -->
<?php
}
?>


<section class="no-padding" id="galleries">
<?php
    if (isset($_SESSION['islogin'])) {
      if (isset($_SESSION['id'])){
    $countheader = 0;
    include('include/connect_to_db.php');
    $queryimg = $con->query("SELECT img FROM churchimages WHERE coordinate = '$coordinate' ORDER BY img");
    if ($queryimg->num_rows > 0) {
        ?>
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
        <?php
    while ($numimg = $queryimg->fetch_array()) {
    $countheader = $countheader + 1;
            if ($countheader === 1 ) {
    ?>
    <div class="item active">

                    <div class="portfolio-box">
                        <img src="church-gallery/<?php echo $churchname .'/'. $numimg['img']; ?>.jpg" class="img-responsive" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <!-- <div class="project-category text-faded">
                                </div> -->
                                <!-- <div class="project-name">
                                    Click to view
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>

    <?php
    }else{
     ?>
     <div class="item">

                   <div class="portfolio-box">
                        <img src="church-gallery/<?php echo $churchname .'/'. $numimg['img']; ?>.jpg" class="img-responsive" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <!-- <div class="project-category text-faded">
                                </div> -->
                                <!-- <div class="project-name">
                                    Click to view
                                </div>
 -->                            </div>
                        </div>
                        </div>

    </div>
     <?php
    }
}
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
     <?php
    include('include/connect_to_db.php');
    $queryheader = $con->query("SELECT img FROM churchimages WHERE coordinate = '$coordinate'");
    $dot = -1;
    if ($queryheader->num_rows > 0) {
        while ($rowheader = $queryheader->fetch_array()) {
            $dot = $dot + 1;
            if ($dot === 0) {
            ?>
    <li data-target="#carousel-example-generic" data-slide-to="<?php echo $dot; ?>" class="active"></li>
    <?php
            }else{
            ?>
    <li data-target="#carousel-example-generic" data-slide-to="<?php echo $dot; ?>"></li>
    <?php
        }}
    }
    ?>
  </ol>
    </section>
    </div>
    <?php
}
}}else{
    include('include/connect_to_db.php');
    $noimg = 0;
    $queryimg = $con->query("SELECT img FROM churchimages WHERE coordinate = '$coordinate' ORDER BY img");
    if ($queryimg->num_rows > 0) {
        ?>
                <div class="container-fluid">
            <div class="row no-gutter popup-gallery">
        <?php
    while ($numimg = $queryimg->fetch_array()) {
        $noimg = $noimg + 1;
        if ($noimg > 3) {

        }else{
    ?>
                <div class="col-lg-4 col-sm-6">
                    <a href="church-gallery/<?php echo $churchname .'/'. $numimg['img']; ?>.jpg" class="portfolio-box">
                        <img src="church-gallery/<?php echo $churchname .'/'. $numimg['img']; ?>.jpg" class="img-responsive" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <!-- <div class="project-category text-faded">
                                </div> -->
                                <div class="project-name">
                                    Click to view
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
    <?php
    }}}}
    ?>
            </div>
        </div>
        <?php
if (isset($_SESSION['islogin'])) {
                    if (isset($_SESSION['id'])){
    }}else{
        if($noimg > 3){  ?>
            <a style="text-align:center;" href="" data-toggle="modal" data-target=".login" ><h3>View More...</h3></a>
        <?php }} ?>
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
    <link rel="stylesheet"  href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="ratings/css/star-rating.css" media="all" rel="stylesheet" type="text/css"/>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="ratings/js/star-rating.js" type="text/javascript"></script>
    <script>
    jQuery(document).ready(function () {
        $("#input-21f").rating({
            starCaptions: function(val) {
                if (val < 3) {
                    return val;
                } else {
                    return 'high';
                }
            },
            starCaptionClasses: function(val) {
                if (val < 3) {
                    return 'label label-danger';
                } else {
                    return 'label label-success';
                }
            },
            hoverOnClear: false
        });

        $('#rating-input').rating({
              min: 0,
              max: 5,
              step: 1,
              size: 'lg',
              showClear: false
           });

        $('#btn-rating-input').on('click', function() {
            $('#rating-input').rating('refresh', {
                showClear:true,
                disabled: !$('#rating-input').attr('disabled')
            });
        });


        $('.btn-danger').on('click', function() {
            $("#kartik").rating('destroy');
        });

        $('.btn-success').on('click', function() {
            $("#kartik").rating('create');
        });

        $('#rating-input').on('rating.change', function() {
            alert($('#rating-input').val());
        });


        $('.rb-rating').rating({'showCaption':true, 'stars':'3', 'min':'0', 'max':'3', 'step':'1', 'size':'xs', 'starCaptions': {0:'status:nix', 1:'status:wackelt', 2:'status:geht', 3:'status:laeuft'}});
    });
</script>

        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-center">
                <h2 class="section-heading">Please rate Us!</h2>
                <hr class="primary">
<div id="submitratings"></div>
<form action="include/saveratings.php" method="POST">
    <input id="input-21b" name="ratings" value="4" type="number" class="rating" min=0 max=5 step=0.2 data-size="sm">
    <?php
    if(isset($_SESSION['islogin'])){
     ?>
    <input type="submit" value="Submit" class="btn btn-primary btn-sm">
    <?php }else{ ?>
    <input data-target=".login" data-toggle="modal" value="Submit" class="btn btn-primary btn-sm">
    <?php } ?>
</form>
<!--                     <h4><strong>Start Bootstrap</strong>
                    </h4> -->
Ratings:
<?php
$checkratings = $con->query("SELECT ratings FROM church WHERE coordinate = '$coordinate'");
if ($checkratings->num_rows > 0) {
    while ($rowcheckratings = $checkratings->fetch_array()) {

         echo $rowcheckratings['ratings'];

    }
}
?>


                    <!-- <p>Ready to start your next project with us? Thats great! Give us a call or send us an email and we will get back to you as soon as possible!</p> -->
                </div>
                <div class="col-lg-4 col-lg-offset-2 text-center">
                    <i class="fa fa-phone fa-3x sr-contact"></i>
                    <p><?php
$querycontact = $con->query("SELECT * FROM contact WHERE coordinate = '$coordinate'");
if ($querycontact->num_rows > 0) {
    ?>
    <i class="fa fa-phone fa-fw"></i>Contact No.
    <?php
    while ($rowcontact = $querycontact->fetch_array()) {

         echo $rowcontact['contact'];

    }
    ?>
    <?php
}
?></p>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="fa fa-refresh fa-3x sr-contact"></i>
                    <p><a href="index.php">www.pampangachurches.com</a></p>
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


    <!-- For Calendar -->
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link href="css/dcalendar.picker.css" rel="stylesheet" type="text/css">
<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="js/dcalendar.picker.js"></script>

<script>
$('#demoWake').dcalendarpicker();
$('#demoWake2').dcalendarpicker();
$('#demoWedding').dcalendarpicker();
$('#demoChristening').dcalendarpicker();
$('#demoTouristVisiting').dcalendarpicker();
$('#calendar-demo').dcalendar(); //creates the calendar
</script>

</body>

</html>
