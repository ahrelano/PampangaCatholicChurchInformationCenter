<?php
session_start();
if(isset($_SESSION['islogin'])){
    $islogin=$_SESSION['islogin'];
    if ($islogin === 1) {
        header('location: ../index.php');
        exit();
    }else if ($islogin === 2) {
        header('location: ../admin/index.php');
        exit();
    }}else{
        header('location: ../index.php');
        exit();
    }

if (isset($_SESSION['id'])) {
  $accountid = $_SESSION['id'];
  include('include/connect_to_db.php');
  $admininfo = $con->query("SELECT * FROM account WHERE id = '$accountid' LIMIT 1");
  if ($admininfo->num_rows > 0) {
    while ($info = $admininfo->fetch_array()) {
      $adminname = $info['username'];
      $_SESSION['username'] = $info['username'];
      $superadminemail = $info['email'];
      $adminpassword = $info['password'];
      $adminid = $info['id'];
    }
  }
}

      if(isset($_POST['submitHeader']) && isset($_SESSION['coordinate'])){
        $admincoordinate = $_SESSION['coordinate'];
                move_uploaded_file($_FILES['fileHeader']['tmp_name'],"../church-gallery/".$_FILES['fileHeader']['name']);
                $filename = $_FILES['fileHeader']['name'];
                $updateheader = $con->query("UPDATE church SET img = '$filename' WHERE coordinate='$admincoordinate'");
        ?>
            <script type="text/javascript">
                alert('Update Success!');
            </script>
            <?php
         
        }

        if(isset($_POST['submitGallery'])){
          $gallerychurch = $_POST['gallerychurch'];
          $gallerycoordinate = $_POST['gallerycoordinate'];
          $gallerytown = $_POST['gallerytown'];  
                move_uploaded_file($_FILES['fileGallery']['tmp_name'],"../church-gallery/". $_POST['gallerychurch'] . "/" . $_FILES['fileGallery']['name']);
                $filegallery = $_FILES['fileGallery']['name'];
                $filegallery = basename($filegallery, ".jpg");
                $update = $con->query("INSERT INTO churchimages (img, coordinate, churchname, town) VALUES ('$filegallery','$gallerycoordinate','$gallerychurch','$gallerytown')");
        ?>
            <script type="text/javascript">
                alert('Update Success!');
            </script>
            <?php
        }

if (isset($_SESSION['update'])) {
        if (empty($_SESSION['update'])) {
        }else{
            ?>
            <script type="text/javascript">
                alert('Update Success!');
            </script>
            <?php
        $_SESSION['update'] = "";
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

    if (isset($_SESSION['willupdate'])) {
        if (empty($_SESSION['willupdate'])) {
        }else{
          $willupdate = $_SESSION['willupdate'];
            ?>
            <script type="text/javascript">
                alert('<?php echo $willupdate; ?>');
            </script>
            <?php
        $_SESSION['willupdate'] = "";
        }
    }  

if (isset($_SESSION['create_admin'])) {
        if (empty($_SESSION['create_admin'])) {
        }else{
            ?>
            <script type="text/javascript">
                alert('Created Admin Success!');
            </script>
            <?php
        $_SESSION['create_admin'] = "";
        }
    }  
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Super Admin</title>

    <!-- Bootstrap -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/default.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <![endif]-->
    <script src="../vendor/jquery/jquery.min.js"></script>
  </head>
  <body onload="scroll()"> 
    <div class="container-fluid display-table">
      <div class="row display-table-row">
      <!-- side menu -->
      <div class="col-md-2 col-sm-1 hidden-xs display-table-cell valign-top" id="side-menu">
        <h1 style="color: #fff;" class="hidden-sm hidden-xs">Hi <?php echo $adminname; ?>!</h1>
        <ul>
          <li class="link">
            <a href="#header">
              <span class="glyphicon glyphicon-th" aria-hidden="true"></span>
              <span>Header</span>
            </a>
          </li>

          <!-- <li class="link">
            <a href="#collapse-post" data-toggle="collapse" aria-controls="collapse-post">
              <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
              <span>Article</span>
              <span class="label label-success">28</span>
              </a>
              <ul class="collapse collapseable" id="collapse-post">
                <li><a href="new-article">Create New</a></li>
                <li><a href="articles.html">View Article</a></li>
              </ul>
          </li> -->
          <li class="link">
            <a href="#history">
              <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
              <span>History</span>
            </a>
          </li>

          <li class="link">
            <a href="#createAdmin" data-toggle="modal">
              <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
              <span>Create Admin</span>
            </a>
          </li>
          <li class="link">
            <a href="#changepass" data-toggle="modal"  title="Compose" role="button"><i class="glyphicon glyphicon-pencil"></i>
              <span>Change Password</span>
            </a>
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="changepass" class="modal fade" style="display: none;">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Change Password</h4>
        </div>
<div class="modal-body">
<form action="include/changepass.php?v=<?php echo $adminid; ?>" method="post" class="form-horizontal">
        <div class="form-group">
           <div class="col-lg-10">
            <label class="col-lg-2 control-label">Password</label>
           <input class="form-control" type="text" name="adminpass" id="adminpass" value="<?php echo $adminpassword; ?>">
           </div>
        </div>   
 <button type="submit" class="btn btn-danger btn-sm">Update</button><br>
        </form>
                                      </div>
                                  </div><!-- /.modal-content -->
                              </div><!-- /.modal-dialog -->
                          </div><!-- /.modal -->
          </li>
         <!--  <li class="link">
            <a href="settings.php">
              <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              <span>Settings</span>
            </a>
          </li> -->
        </ul>
      </div>
      <!-- main content -->
      <div class="col-md-10 col-sm-1 display-table-cell valign-top">
        <div class="row">
          <header id="nav-header" class="clearfix">
            <div class="col-md-5">
            <nav class="navbar-default pull-left">
              <button type="button" class="navbar-toggle collapsed" data-toggle="offcanvas" data-target="#side-menu" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
            </nav>
              <!-- <input type="text" class="hidden-sm hidden-xs" id="header-search-field" placeholder="Search"> -->
            </div>
            <div class="col-md-7">
              <ul class="pull-right">
                <li id="welcome" class="hidden-xs"><h3>Welcome to your administration area</h3></li>
<!--                 <li class="fixed-width">
                  <a href="">
                    <span class="glyphicon glyphicon-bell" aria-hidden="true"></span>
                    <span class="label label-warning">3</span>
                  </a>
                </li>
                <li class="fixed-width">
                  <a href="">
                    <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                    <span class="label label-warning">3</span>
                  </a>
                </li> -->

                <li>
                  <a href="include/logout.php?id=<?php echo $adminname; ?>" class="logout">
                    <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
                    Log out
                  </a>
                </li>
              </ul>
            </div>
          </header>
        </div>
        <!-- Modal Create Admin -->
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="createAdmin" class="modal fade" style="display: none;">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Create Admin</h4>
        </div>
<div class="modal-body">
<form action="include/createadmin.php" method="post" class="form-horizontal">
      <div id="status-town">
        <div class="form-group">
           <div class="col-lg-10">
                <select class="form-control" name="Location" id="Location" onchange="checktown()">
                <option id="selected" value="Town" selected>Choose Town</option>
                <?php
                $query = $con->query("SELECT DISTINCT town FROM church ORDER BY town"); 
                while($townrows = $query->fetch_array()){
                $town = preg_replace('#[^a-z0-9]#i', '', $townrows['town']);
                ?>
                <option value="<?php echo $townrows['town']; ?>"><?php echo $town; ?></option>
                <?php
                }
                ?>
                </select>
           </div>
        </div>

        
        </div>

        <div class="form-group">
        <label class="col-lg-2 control-label">Username</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" id="username" name="username" onkeyup="checkusername()" required>
           <span id="usernamestatus" style="color:red;"></span><br>
           </div>
        </div>   
        <div class="form-group">
        <label class="col-lg-2 control-label">Email</label>
           <div class="col-lg-10">
           <input type="email" class="form-control" id="email" name="email" onkeyup="checkemail()" required>
           <span id="emailstatus" style="color:red;"></span><br>
           </div>
        </div> 
        <div class="form-group">
        <label class="col-lg-2 control-label">Password</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" id="password" name="password" onkeyup="checkpassword()" required>
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Retype Password</label>
           <div class="col-lg-10">
           <input type="text" class="form-control" id="retypepassword" name="retypepassword" onkeyup="checkpassword()" required>
           <span id="passwordstatus" style="color:red;"></span><br>
           </div>
        </div> 
 <button id="signUpBtn" type="submit" class="btn btn-danger btn-sm">Create</button><br>
        </form>
                                      </div>
                                  </div><!-- /.modal-content -->
                              </div><!-- /.modal-dialog -->
                          </div><!-- /.modal -->

        <script type="text/javascript">
             function _ (el) {
        return document.getElementById(el);
    }
    function checkusername(){
        var status = document.getElementById("usernamestatus");
        var u = document.getElementById("username").value;
        var l = document.getElementById("Location").value;
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
            var v = "name2check=" + u + "&town=" + l;
            hr.send(v);
    }

    function checkpassword(){
        var status = document.getElementById("passwordstatus");
        var u = document.getElementById("password").value;
        var l = document.getElementById("retypepassword").value;
            status.innerHTML = 'checking...';
            var hr = new XMLHttpRequest();
            hr.open("POST", "auth/checkpassword.php", true);
            hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            hr.onreadystatechange = function() {
                if(hr.readyState == 4 && hr.status == 200) {
                    status.innerHTML = hr.responseText;
                    if (hr.responseText == "ok") {
                      status.innerHTML = "<span style='color:green;'>Password Match!</span>";
                        _('signUpBtn').disabled = false;
                    }else {
                        _('signUpBtn').disabled = true;
                    }
                }
            }
            var v = "password=" + u + "&retypepassword=" + l;
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

        function checktown(){
             // Create our XMLHttpRequest object
    var hr = new XMLHttpRequest();
    // Create some variables we need to send to our PHP file
    var url = "include/ajax_location.php";
    var fn = document.getElementById("Location").value;
    // var ln = document.getElementById("last_name").value;
    var vars = "town="+fn;
    hr.open("POST", url, true);
    // Set content type header information for sending url encoded variables in the request
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // Access the onreadystatechange event for the XMLHttpRequest object
    hr.onreadystatechange = function() {
        if(hr.readyState == 4 && hr.status == 200) {
            var return_data = hr.responseText;
            document.getElementById("status-town").innerHTML = return_data;
            checkusername()
        }
    }
    // Send the data to PHP now... and wait for response to update the status div
    hr.send(vars); // Actually execute the request
    document.getElementById("status-town").innerHTML = "processing...";
    document.getElementById("Location").value = "";
        }

function sendchat(){
    // Create our XMLHttpRequest object
    var hr = new XMLHttpRequest();
    // Create some variables we need to send to our PHP file
    var url = "include/ajax_sendchat.php";
    var fn = document.getElementById("btn-input").value;
    // var ln = document.getElementById("last_name").value;
    var vars = "message="+fn;
    hr.open("POST", url, true);
    // Set content type header information for sending url encoded variables in the request
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // Access the onreadystatechange event for the XMLHttpRequest object
    hr.onreadystatechange = function() {
        if(hr.readyState == 4 && hr.status == 200) {
            var return_data = hr.responseText;
            document.getElementById("chatstatus").innerHTML = return_data;
            document.getElementById('panel-body').scrollTop=999999
        }
    }
    // Send the data to PHP now... and wait for response to update the status div
    hr.send(vars); // Actually execute the request
    document.getElementById("chatstatus").innerHTML = "processing...";
    document.getElementById("btn-input").value = "";

}

function refreshchat()
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
    document.getElementById("chatstatus").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("POST","include/ajax_refreshchat.php",true);
xmlhttp.send();
}

setInterval ( refreshchat, 1000);

function scroll(){  
         document.getElementById('panel-body').scrollTop=999999
}

scroll();
</script>

        <section id="admin">
          <?php
          include('include/connect_to_db.php');
          $countwake = 0;
            $total = 0;
            $numberwake = 0;
            $five = 5;
          $admin = $con->query("SELECT * FROM account WHERE type='admin' ORDER BY username");
          if ($admin->num_rows > 0) {
            ?>
        <div id="statusadmins">
                <table class="table table-bordered">
        <th colspan="4" style="text-align:center; background-color: red; color: black;"><h3>Admins</h3></th>
<tr>
<th>Username</th>
<th>Church</th>
<th>Status</th>
<th>Restriction</th>
</tr>
            <?php
            while ($rowadmin = $admin->fetch_array()) {
              $numberwake = $numberwake + 1;
              if ($numberwake <= 5) {    
              $restrictname = $rowadmin['username'];
              $restrict = $con->query("SELECT * FROM `restrict` WHERE username = '$restrictname' LIMIT 1");
              if ($rowadmin['active'] == 0) {
                ?>
  <!-- FOR OFFLINE ADMIN -->
               <?php
                while($rowrestrict = $restrict->fetch_array()) {
                 ?>
                 <tr>
                   <td><?php echo $rowadmin['username']; ?></td>
                   <td><?php echo $rowadmin['churchname']; ?></td>
                   <td><span style="color:gray;">Offline</span></td>
                   <td>
                     <a href="#edit<?php echo $rowadmin['username']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>Edit Restriction</a> 
                   </td>
                 </tr>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="edit<?php echo $rowadmin['username']; ?>" class="modal fade" style="display: none;">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Edit <?php echo $rowadmin['username']; ?> Restriction</h4>
        </div>
<div class="modal-body">
<form action="include/editrestriction.php?restrictid=<?php echo $rowrestrict['id']; ?>&adminid=<?php echo $rowadmin['id']; ?>" method="post" class="form-horizontal">
          <div class="form-group">
           <div class="col-lg-10">
           <label class="col-lg-2 control-label">Town:</label>
            <input type="text" class="form-control" style="margin: 10px;" value="<?php echo $rowadmin['town']; ?>" readonly>
           </div>
        </div>

        <div class="form-group">
           <div class="col-lg-10">
           <label class="col-lg-2 control-label">Church:</label>
            <input type="text" class="form-control" style="margin: 10px;" value="<?php echo $rowadmin['churchname']; ?>" readonly>
           </div>
        </div> 

       <div class="form-group">
           <div class="col-lg-10">
           <label class="col-lg-2 control-label">Username:</label>
            <input type="text" class="form-control" name="useradmin" id="useradmin" style="margin: 10px;" value="<?php echo $rowadmin['username']; ?>">
           </div>
        </div> 

        <div class="form-group">
           <div class="col-lg-10">
           <label class="col-lg-2 control-label">Password:</label>
            <input type="text" class="form-control" name="passadmin" id="passadmin" style="margin: 10px;" value="<?php echo $rowadmin['password']; ?>">
           </div>
        </div> 

        <div class="form-group">
           <div class="col-lg-10">
           <label class="col-lg-2 control-label">Email:</label>
            <input type="text" class="form-control" name="emailadmin" id="emailadmin" style="margin: 10px;" value="<?php echo $rowadmin['email']; ?>">
           </div>
        </div>
        <div style="clear:both;"> 
        <input type="checkbox" name="username" id="username" value="0" checked ><?php echo $rowadmin['username']; ?><span style="color:gray;"> Offline</span><br> 
        <?php
        if ($rowrestrict['history'] == 'yes') {
                    ?>
                    <input type="checkbox" name="history" id="history" value="yes" style="margin: 10px;" checked >Enable editing history<br>
                    <?php
                  }else{
                    ?>
                    <input type="checkbox" name="history" id="history" value="yes" style="margin: 10px;" >Enable editing history<br>
                    <?php
                  }

                  if ($rowrestrict['galleries'] == 'yes') {
                    ?>
                    <input type="checkbox" name="galleries" id="galleries" value="yes" style="margin: 10px;" checked >Enable editing galleries<br>
                    <?php
                  }else{
                    ?>
                    <input type="checkbox" name="galleries" id="galleries" value="yes" style="margin: 10px;" >Enable editing galleries<br>
                    <?php
                  }

                  if ($rowrestrict['mass'] == 'yes') {
                    ?>
                    <input type="checkbox" name="mass" id="mass" value="yes" style="margin: 10px;" checked >Enable editing mass schedule<br>
                    <?php
                  }else{
                    ?>
                    <input type="checkbox" name="mass" id="mass" value="yes" style="margin: 10px;" >Enable editing mass schedule<br>
                    <?php
                  }

                  if ($rowrestrict['forum'] == 'yes') {
                    ?>
                    <input type="checkbox" name="forum" id="forum" value="yes" style="margin: 10px;" checked >Enable posting in forum<br>
                    <?php
                  }else{
                    ?>
                    <input type="checkbox" name="forum" id="forum" value="yes" style="margin: 10px;" >Enable posting in forum<br>
                    <?php
                  }

                  if ($rowrestrict['contact'] == 'yes') {
                    ?>
                    <input type="checkbox" name="contact" id="contact" value="yes" style="margin: 10px;" checked >Enable editing contact<br>
                    <?php
                  }else{
                    ?>
                    <input type="checkbox" name="contact" id="contact" value="yes" style="margin: 10px;" >Enable editing contact<br>
                    <?php
                  }

                  if ($rowrestrict['chat'] == 'yes') {
                    ?>
                    <input type="checkbox" name="chat" id="chat" value="yes" style="margin: 10px;" checked >Enable to chat<br>
                    <?php
                  }else{
                    ?>
                    <input type="checkbox" name="chat" id="chat" value="yes" style="margin: 10px;" >Enable to chat<br>
                    <?php
                  }

                  if ($rowrestrict['header'] == 'yes') {
                    ?>
                    <input type="checkbox" name="header" id="header" value="yes" style="margin: 10px;" checked >Enable editing header<br>
                    <?php
                  }else{
                    ?>
                    <input type="checkbox" name="header" id="header" value="yes" style="margin: 10px;" >Enable editing header<br>
                    <?php
                  }
                  ?>
                  </div>
 <button type="submit" class="btn btn-danger btn-sm">Update</button><br>
        </form>
                                      </div>
                                  </div><!-- /.modal-content -->
                              </div><!-- /.modal-dialog -->
                          </div><!-- /.modal -->
                  <?php
                }
              }else if($rowadmin['active'] == 1){
                ?>
<!-- FOR ONLINE ADMIN -->
                <?php
                while($rowrestrict = $restrict->fetch_array()) {
                 ?>
                 <tr>
                   <td><?php echo $rowadmin['username']; ?></td>
                   <td><?php echo $rowadmin['churchname']; ?></td>
                   <td><span style="color:green;">Online</span></td>
                   <td>
                      <a href="#edit<?php echo $rowadmin['username']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>Edit Restriction</a>
                   </td>
                 </tr>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="edit<?php echo $rowadmin['username']; ?>" class="modal fade" style="display: none;">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Edit <?php echo $rowadmin['username']; ?> Restriction</h4>
        </div>
<div class="modal-body">
<form action="include/editrestriction.php?restrictid=<?php echo $rowrestrict['id']; ?>&adminid=<?php echo $rowadmin['id']; ?>" method="post" class="form-horizontal">
       <div class="form-group">
           <div class="col-lg-10">
           <label class="col-lg-2 control-label">Town:</label>
            <input type="text" class="form-control" style="margin: 10px;" value="<?php echo $rowadmin['town']; ?>" readonly>
           </div>
        </div>

        <div class="form-group">
           <div class="col-lg-10">
           <label class="col-lg-2 control-label">Church:</label>
            <input type="text" class="form-control" style="margin: 10px;" value="<?php echo $rowadmin['churchname']; ?>" readonly>
           </div>
        </div> 

       <div class="form-group">
           <div class="col-lg-10">
           <label class="col-lg-2 control-label">Username:</label>
            <input type="text" class="form-control" name="useradmin" id="useradmin" style="margin: 10px;" value="<?php echo $rowadmin['username']; ?>">
           </div>
        </div> 

        <div class="form-group">
           <div class="col-lg-10">
           <label class="col-lg-2 control-label">Password:</label>
            <input type="text" class="form-control" name="passadmin" id="passadmin" style="margin: 10px;" value="<?php echo $rowadmin['password']; ?>">
           </div>
        </div> 

        <div class="form-group">
           <div class="col-lg-10">
           <label class="col-lg-2 control-label">Email:</label>
            <input type="text" class="form-control" name="emailadmin" id="emailadmin" style="margin: 10px;" value="<?php echo $rowadmin['email']; ?>">
           </div>
        </div> 
        <div style="clear:both;"> 
       <input type="checkbox" name="username" id="username" value="1" checked><?php echo $rowadmin['username']; ?><span style="color:green;"> Online</span><br>
        <?php
        if ($rowrestrict['history'] == 'yes') {
                    ?>
                    <input type="checkbox" name="history" id="history" value="yes" style="margin: 10px;" checked >Enable editing history<br>
                    <?php
                  }else{
                    ?>
                    <input type="checkbox" name="history" id="history" value="yes" style="margin: 10px;" >Enable editing history<br>
                    <?php
                  }

                  if ($rowrestrict['galleries'] == 'yes') {
                    ?>
                    <input type="checkbox" name="galleries" id="galleries" value="yes" style="margin: 10px;" checked >Enable editing galleries<br>
                    <?php
                  }else{
                    ?>
                    <input type="checkbox" name="galleries" id="galleries" value="yes" style="margin: 10px;" >Enable editing galleries<br>
                    <?php
                  }

                  if ($rowrestrict['mass'] == 'yes') {
                    ?>
                    <input type="checkbox" name="mass" id="mass" value="yes" style="margin: 10px;" checked >Enable editing mass schedule<br>
                    <?php
                  }else{
                    ?>
                    <input type="checkbox" name="mass" id="mass" value="yes" style="margin: 10px;" >Enable editing mass schedule<br>
                    <?php
                  }

                  if ($rowrestrict['forum'] == 'yes') {
                    ?>
                    <input type="checkbox" name="forum" id="forum" value="yes" style="margin: 10px;" checked >Enable posting in forum<br>
                    <?php
                  }else{
                    ?>
                    <input type="checkbox" name="forum" id="forum" value="yes" style="margin: 10px;" >Enable posting in forum<br>
                    <?php
                  }

                  if ($rowrestrict['contact'] == 'yes') {
                    ?>
                    <input type="checkbox" name="contact" id="contact" value="yes" style="margin: 10px;" checked >Enable editing contact<br>
                    <?php
                  }else{
                    ?>
                    <input type="checkbox" name="contact" id="contact" value="yes" style="margin: 10px;" >Enable editing contact<br>
                    <?php
                  }

                  if ($rowrestrict['chat'] == 'yes') {
                    ?>
                    <input type="checkbox" name="chat" id="chat" value="yes" style="margin: 10px;" checked >Enable to chat<br>
                    <?php
                  }else{
                    ?>
                    <input type="checkbox" name="chat" id="chat" value="yes" style="margin: 10px;" >Enable to chat<br>
                    <?php
                  }

                  if ($rowrestrict['header'] == 'yes') {
                    ?>
                    <input type="checkbox" name="header" id="header" value="yes" style="margin: 10px;" checked >Enable editing header<br>
                    <?php
                  }else{
                    ?>
                    <input type="checkbox" name="header" id="header" value="yes" style="margin: 10px;" >Enable editing header<br>
                    <?php
                  }
                  ?>
                  </div>
 <button type="submit" class="btn btn-danger btn-sm">Update</button><br>
        </form>
                                      </div>
                                  </div><!-- /.modal-content -->
                              </div><!-- /.modal-dialog -->
                          </div><!-- /.modal -->
                  <?php
                }
              }else if ($rowadmin['active'] == 2){
                ?>
<!-- FOR BANNED ADMIN -->
               <?php
                while($rowrestrict = $restrict->fetch_array()) {
                  ?>
                  <tr>
                    <td><?php echo $rowadmin['username']; ?></td>
                    <td><?php echo $rowadmin['churchname']; ?></td>
                    <td><span style="color:red;">Banned</span></td>
                    <td>
                      <a href="#edit<?php echo $rowadmin['username']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>Edit Restriction</a>
                    </td>
                  </tr>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="edit<?php echo $rowadmin['username']; ?>" class="modal fade" style="display: none;">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Edit <?php echo $rowadmin['username']; ?> Restriction</h4>
        </div>
<div class="modal-body">
<form action="include/editrestriction.php?restrictid=<?php echo $rowrestrict['id']; ?>&adminid=<?php echo $rowadmin['id']; ?>" method="post" class="form-horizontal">
           <div class="form-group">
           <div class="col-lg-10">
           <label class="col-lg-2 control-label">Town:</label>
            <input type="text" class="form-control" style="margin: 10px;" value="<?php echo $rowadmin['town']; ?>" readonly>
           </div>
        </div>

        <div class="form-group">
           <div class="col-lg-10">
           <label class="col-lg-2 control-label">Church:</label>
            <input type="text" class="form-control" style="margin: 10px;" value="<?php echo $rowadmin['churchname']; ?>" readonly>
           </div>
        </div> 

       <div class="form-group">
           <div class="col-lg-10">
           <label class="col-lg-2 control-label">Username:</label>
            <input type="text" class="form-control" name="useradmin" id="useradmin" style="margin: 10px;" value="<?php echo $rowadmin['username']; ?>">
           </div>
        </div> 

        <div class="form-group">
           <div class="col-lg-10">
           <label class="col-lg-2 control-label">Password:</label>
            <input type="text" class="form-control" name="passadmin" id="passadmin" style="margin: 10px;" value="<?php echo $rowadmin['password']; ?>">
           </div>
        </div> 

        <div class="form-group">
           <div class="col-lg-10">
           <label class="col-lg-2 control-label">Email:</label>
            <input type="text" class="form-control" name="emailadmin" id="emailadmin" style="margin: 10px;" value="<?php echo $rowadmin['email']; ?>">
           </div>
        </div>
        <div style="clear:both;"> 
        <input type="checkbox" name="username" id="username" value="2"><?php echo $rowadmin['username']; ?><span style="color:red;"> Banned</span><br>
        <?php
        if ($rowrestrict['history'] == 'yes') {
                    ?>
                    <input type="checkbox" name="history" id="history" value="yes" style="margin: 10px;" checked >Enable editing history<br>
                    <?php
                  }else{
                    ?>
                    <input type="checkbox" name="history" id="history" value="yes" style="margin: 10px;" >Enable editing history<br>
                    <?php
                  }

                  if ($rowrestrict['galleries'] == 'yes') {
                    ?>
                    <input type="checkbox" name="galleries" id="galleries" value="yes" style="margin: 10px;" checked >Enable editing galleries<br>
                    <?php
                  }else{
                    ?>
                    <input type="checkbox" name="galleries" id="galleries" value="yes" style="margin: 10px;" >Enable editing galleries<br>
                    <?php
                  }

                  if ($rowrestrict['mass'] == 'yes') {
                    ?>
                    <input type="checkbox" name="mass" id="mass" value="yes" style="margin: 10px;" checked >Enable editing mass schedule<br>
                    <?php
                  }else{
                    ?>
                    <input type="checkbox" name="mass" id="mass" value="yes" style="margin: 10px;" >Enable editing mass schedule<br>
                    <?php
                  }

                  if ($rowrestrict['forum'] == 'yes') {
                    ?>
                    <input type="checkbox" name="forum" id="forum" value="yes" style="margin: 10px;" checked >Enable posting in forum<br>
                    <?php
                  }else{
                    ?>
                    <input type="checkbox" name="forum" id="forum" value="yes" style="margin: 10px;" >Enable posting in forum<br>
                    <?php
                  }

                  if ($rowrestrict['contact'] == 'yes') {
                    ?>
                    <input type="checkbox" name="contact" id="contact" value="yes" style="margin: 10px;" checked >Enable editing contact<br>
                    <?php
                  }else{
                    ?>
                    <input type="checkbox" name="contact" id="contact" value="yes" style="margin: 10px;" >Enable editing contact<br>
                    <?php
                  }

                  if ($rowrestrict['chat'] == 'yes') {
                    ?>
                    <input type="checkbox" name="chat" id="chat" value="yes" style="margin: 10px;" checked >Enable to chat<br>
                    <?php
                  }else{
                    ?>
                    <input type="checkbox" name="chat" id="chat" value="yes" style="margin: 10px;" >Enable to chat<br>
                    <?php
                  }

                  if ($rowrestrict['header'] == 'yes') {
                    ?>
                    <input type="checkbox" name="header" id="header" value="yes" style="margin: 10px;" checked >Enable editing header<br>
                    <?php
                  }else{
                    ?>
                    <input type="checkbox" name="header" id="header" value="yes" style="margin: 10px;" >Enable editing header<br>
                    <?php
                  }
                  ?>
                  </div>
 <button type="submit" class="btn btn-danger btn-sm">Update</button><br>
        </form>
                                      </div>
                                  </div><!-- /.modal-content -->
                              </div><!-- /.modal-dialog -->
                          </div><!-- /.modal -->
                  </div>
      <?php
                }
              } 
                  }
                                $countwake = $countwake + 1;  
            if ($countwake > $five) {
              $total = $total + 1;
              $five = $five + 5;
            }
              }
              ?>
              </table>
              </div>
              <?php
              if ($total <> 0) {
              ?>
              <button class="btn btn-danger btn-sm" type="button" onclick="nextadmin('0')">1</button>
              <?php
              $a = 1;
              for ($i=1; $i <= $total; $i++) { 
                $a = $a + 1;
              ?>
              <button class="btn btn-danger btn-sm" type="button" onclick="nextadmin(<?php echo $i; ?>)"><?php echo $a; ?></button>
              <?php
              }
            }
            }
          ?>
<script type="text/javascript">
  function nextadmin(number){
    // Create our XMLHttpRequest object
    var hr = new XMLHttpRequest();
    // Create some variables we need to send to our PHP file
    var url = "include/nextadmin.php";
    // var ln = document.getElementById("last_name").value;
    var vars = "message="+number;
    hr.open("POST", url, true);
    // Set content type header information for sending url encoded variables in the request
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // Access the onreadystatechange event for the XMLHttpRequest object
    hr.onreadystatechange = function() {
        if(hr.readyState == 4 && hr.status == 200) {
            var return_data = hr.responseText;
            document.getElementById("statusadmins").innerHTML = return_data;
        }
    }
    // Send the data to PHP now... and wait for response to update the status div
    hr.send(vars); // Actually execute the request
}

  </script>
          
        </section>

         <section id="chat">
         <br><br>
                  <div class="col-md-5" >
            <div class="panel panel-primary" >
                <div class="panel-heading" >
                    <span class="glyphicon glyphicon-comment"></span> Chat
                </div>
                <div id="panel-body" class="panel-body" >
                    <ul class="chat">
                    <div id="chatstatus" >
                    <?php
                        $show = $con->query("SELECT * FROM group_chat ORDER BY submitdate");
    while ($rowchat = $show->fetch_array()) {
    if (($rowchat['username']) === ($_SESSION['username'])) {
?>
<li class="right clearfix"><span class="chat-img pull-right">
      <img src="../img/me.png" alt="User Avatar" class="img-circle">
  </span>
      <div class="chat-body clearfix">
          <div class="header">
              <small class=" text-muted"><span class="glyphicon glyphicon-time"></span><?php echo $rowchat['submitdate']; ?></small>
              <strong class="pull-right primary-font"><?php echo $rowchat['username']; ?></strong>
          </div>
          <p>
              <?php echo $rowchat['message']; ?>
          </p>
      </div>
  </li>
<?php
}else{
?>
  <li class="left clearfix"><span class="chat-img pull-left">
      <!-- <img src="http://placehold.it/50/55C1E7/fff&amp;text=U" alt="User Avatar" class="img-circle"> -->
      <img src="../img/you.png" alt="User Avatar" class="img-circle">
  </span>
      <div class="chat-body clearfix">
          <div class="header">
              <strong class="primary-font"><?php echo $rowchat['username']; ?></strong> <small class="pull-right text-muted">
                  <span class="glyphicon glyphicon-time"></span><?php echo $rowchat['submitdate']; ?></small>
          </div>
          <p>
              <?php echo $rowchat['message']; ?>
          </p>
      </div>
  </li>
<?php
}}
?>
                    </div>
                    </ul>
                </div>
                <div class="panel-footer">
                    <div class="input-group">
                        <input id="btn-input" class="form-control input-sm" placeholder="Type your message here..." type="text">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-warning btn-sm" id="btn-chat" onclick="sendchat()">
                                Send</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        </section>

        <section id="updatefeatures" style="clear:both;">
        <br><br>
        <h1>Choose church to update</h1>
          <script type="text/javascript">
  function checkcoordinate(){
             // Create our XMLHttpRequest object
    var hr = new XMLHttpRequest();
    // Create some variables we need to send to our PHP file
    var url = "include/ajax_location_update.php";
    var fn = document.getElementById("location").value;
    // var ln = document.getElementById("last_name").value;
    var vars = "town="+fn;
    hr.open("POST", url, true);
    // Set content type header information for sending url encoded variables in the request
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // Access the onreadystatechange event for the XMLHttpRequest object
    hr.onreadystatechange = function() {
        if(hr.readyState == 4 && hr.status == 200) {
            var return_data = hr.responseText;
            document.getElementById("statuscoordinate").innerHTML = return_data;
        }
    }
    // Send the data to PHP now... and wait for response to update the status div
    hr.send(vars); // Actually execute the request
    document.getElementById("statuscoordinate").innerHTML = "processing...";
    document.getElementById("location").value = "";
        }
</script>

<form action="include/churchupdate.php" method="post" class="form-horizontal">
      <div id="statuscoordinate">
        <div class="form-group">
           <div class="col-lg-10">
                <select class="form-control" name="location" id="location" onchange="checkcoordinate()">
                <option id="selected" value="Town" selected>Choose Town</option>
                <?php
                $query = $con->query("SELECT DISTINCT town FROM church ORDER BY town"); 
                while($townrows = $query->fetch_array()){
                $town = preg_replace('#[^a-z0-9]#i', '', $townrows['town']);
                ?>
                <option value="<?php echo $townrows['town']; ?>"><?php echo $town; ?></option>
                <?php
                }
                ?>
                </select>
           </div>
        </div>    
      </div>

 <button type="submit" class="btn btn-danger btn-sm">Update features</button><br>
        </form>
        </section>

<?php if (isset($_SESSION['coordinate']) && isset($_SESSION['youarein'])){ 
$admincoordinate = $_SESSION['coordinate'];
$youarein = $_SESSION['youarein'];
  ?>


         <section id="header" style="clear:both;">
        <h1><u><?php echo $youarein; ?></u></h1><br>
        <h1>Header</h1>
         <?php
        $header = $con->query("SELECT img FROM church WHERE coordinate = '$admincoordinate'");
        while ($rowheader = $header->fetch_array()) {
          ?>
        <img src="../church-gallery/<?php echo $rowheader['img']; ?>" height="30%" width="30%">
        <?php
        }
        ?>

        <form action="" method="post" enctype="multipart/form-data">
                        <input type="file" name="fileHeader" required>
                        <input type="submit" name="submitHeader" value="Change Header" class="btn btn-danger btn-sm">
        </form>
        </section>

        <section id="history">
        <h1>History</h1>
<a href="#addHistory" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>Add History</a>
<br>
        <!-- Modal add history -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="addHistory" class="modal fade" style="display: none;">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Add History</h4>
        </div>
<div class="modal-body">
<form action="include/addhistory.php?v=<?php echo $admincoordinate; ?>" method="post" class="form-horizontal">
        <div class="form-group">
           <div class="col-lg-10">
            <label class="col-lg-2 control-label">Title</label>
           <textarea class="form-control" rows="3" name="year" id="year"></textarea>
           </div>
        </div>
        <div class="form-group">
           <div class="col-lg-10">
           <label class="col-lg-2 control-label">Info:</label>
           <textarea class="form-control" rows="3" name="info" id="info"></textarea>
           </div>
        </div>    
 <button type="submit" class="btn btn-danger btn-sm">Update</button><br>
        </form>
                                      </div>
                                  </div><!-- /.modal-content -->
                              </div><!-- /.modal-dialog -->
                          </div><!-- /.modal -->
           <?php
        $history = $con->query("SELECT * FROM history WHERE coordinate = '$admincoordinate'");
        while ($rowhistory = $history->fetch_array()) {
          if (empty($rowhistory['title'])) {}else{
            ?>
<input type="text" value="<?php echo $rowhistory['title']; ?>" readonly><br><br>
<a href="#updateYear<?php echo $rowhistory['id']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>Update Title</a>
<a href="include/deleteyear.php?id=<?php echo $rowhistory['id']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>Delete Title</a>
                  <!-- Modal Priest -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="updateYear<?php echo $rowhistory['id']; ?>" class="modal fade" style="display: none;">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Year</h4>
        </div>
<div class="modal-body">
<form action="include/updateyear.php?v=<?php echo $admincoordinate; ?>&yearid=<?php echo $rowhistory['id']; ?>" method="post" class="form-horizontal">
        <div class="form-group">
           <div class="col-lg-10">
           <textarea class="form-control" rows="3" name="year" id="year"><?php echo $rowhistory['title']; ?></textarea>
           </div>
        </div>
        
 <button type="submit" class="btn btn-danger btn-sm" >Update</button><br>
        </form>
                                      </div>
                                  </div><!-- /.modal-content -->
                              </div><!-- /.modal-dialog -->
                          </div><!-- /.modal -->
          <?php
          }
          if (empty($rowhistory['info'])) {}else{
            ?>
            <textarea class="form-control" rows="3" readonly><?php echo $rowhistory['info']; ?></textarea>
            <br><a href="#updateInfo<?php echo $rowhistory['id']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>Update Info</a>
                  <a href="include/deleteinfo.php?id=<?php echo $rowhistory['id']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>Delete Info</a><br>

                  <!-- Modal Priest -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="updateInfo<?php echo $rowhistory['id']; ?>" class="modal fade" style="display: none;">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Info</h4>
        </div>
<div class="modal-body">
<form action="include/updateinfo.php?v=<?php echo $admincoordinate; ?>&infoid=<?php echo $rowhistory['id']; ?>" method="post" class="form-horizontal">
        <div class="form-group">
           <div class="col-lg-10">
           <textarea class="form-control" rows="3" name="info" id="info"><?php echo $rowhistory['info']; ?></textarea>
           </div>
        </div>
        
 <button type="submit" class="btn btn-danger btn-sm" >Update</button><br>
        </form>
                                      </div>
                                  </div><!-- /.modal-content -->
                              </div><!-- /.modal-dialog -->
                          </div><!-- /.modal -->
            <?php
          }
          if (empty($rowhistory['priest'])) {
          }else{
            $presentpriest = $rowhistory['priest'];
          }
          ?>
        <?php
        }
        if (isset($presentpriest)) {}else{
          $presentpriest = "NONE";
        }
        ?>
        <h3>Present Priest</h3>
        <input type="text" value="<?php echo $presentpriest; ?>" readonly><br><br>
          <a href="#updatePriest" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>Update Priest</a>
        </section>

        <!-- Modal Priest -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="updatePriest" class="modal fade" style="display: none;">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Present Priest of Holy Rosary</h4>
        </div>
<div class="modal-body">
<form action="include/updatepriest.php?v=<?php echo $admincoordinate; ?>" method="post" class="form-horizontal">
        <div class="form-group">
           <div class="col-lg-10">
           <textarea class="form-control" rows="3" name="priest" id="priest"><?php echo $presentpriest; ?></textarea>
           </div>
        </div>
        
 <button type="submit" class="btn btn-danger btn-sm">Update</button><br>
        </form>
                                      </div>
                                  </div><!-- /.modal-content -->
                              </div><!-- /.modal-dialog -->
                          </div><!-- /.modal -->
        <section id="galleries">
        <h1>Galleries</h1>
        <?php
        $queryimages = $con->query("SELECT * FROM church WHERE coordinate = '$admincoordinate'");
        if ($queryimages->num_rows > 0) {
          while ($rowsimages = $queryimages->fetch_array()) {
      $adminchurch = $rowsimages['churchname'];
      $admintown = $rowsimages['town'];
          }
        }
        ?>
        <form action="" method="post" enctype="multipart/form-data">
                        <input type="file" name="fileGallery" required>
                        <input type="hidden" value="<?php echo $admincoordinate; ?>" name="gallerycoordinate">
                        <input type="hidden" value="<?php echo $adminchurch; ?>" name="gallerychurch">
                        <input type="hidden" value="<?php echo $admintown; ?>" name="gallerytown">
                        <input type="submit" name="submitGallery" class="btn btn-danger btn-sm" role="button" value="Add Image" required>
                        
        </form>
          <?php
          include("include/connect_to_db.php");
          $viewgallery = $con->query("SELECT * FROM churchimages WHERE coordinate = '$admincoordinate'");
          while ($rowgallery = $viewgallery->fetch_array()) {
          ?>
          <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
          <img src="../church-gallery/<?php echo $rowgallery['churchname'] . "/" . $rowgallery['img']; ?>.jpg" width="150px" height="150px">
          <a href="include/deleteimage.php?id=<?php echo $rowgallery['id']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>Delete</a><br>
          </div>
          </div>
          <?php
          }
          ?>
        </section><br>
        <section id="mass" style="clear:both;">
          <h1>Mass Schedule</h1>
 <a href="#addmass" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>Add Mass Schedule</a><br>
          <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="addmass" class="modal fade" style="display: none;">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Add Mass Schedule</h4>
        </div>
<div class="modal-body">
<form action="include/addmass.php?v=<?php echo $admincoordinate; ?>" method="post" class="form-horizontal">
        <div class="form-group">
        <label class="col-lg-2 control-label">Date</label>
           <div class="col-lg-10">
           <select name="date" id="date">
             <option value="Monday">Monday</option>
             <option value="Tuesday">Tuesday</option>
             <option value="Wednesday">Wednesday</option>
             <option value="Thursday">Thursday</option>
             <option value="Friday">Friday</option>
             <option value="Saturday">Saturday</option>
             <option value="Sunday">Sunday</option>
           </select>
           </div>
        </div>
         <div class="form-group">
         <label class="col-lg-2 control-label">Time</label>
           <div class="col-lg-10">
           <textarea class="form-control" rows="3" name="time" id="time"></textarea>
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Type</label>
           <div class="col-lg-10">
           <input type="text" name="type" id="type">
           </div>
        </div>
        
 <button type="submit" class="btn btn-danger btn-sm">Submit</button><br>
        </form>
                                      </div>
                                  </div><!-- /.modal-content -->
                              </div><!-- /.modal-dialog -->
                          </div><!-- /.modal -->

              <?php 
$countmass = 0;
include('include/connect_to_db.php');
$querymass = $con->query("SELECT * FROM mass WHERE coordinate = '$admincoordinate'");
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
                                <a href="#updatemass<?php echo $rowmass['id']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>Update Mass</a>
                  <a href="include/deletemass.php?id=<?php echo $rowmass['id']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>Delete Mass</a><br>                             
                            </div>
                        </div>
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="updatemass<?php echo $rowmass['id']; ?>" class="modal fade" style="display: none;">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Update Mass</h4>
        </div>
<div class="modal-body">
<form action="include/updatemass.php?massid=<?php echo $rowmass['id']; ?>" method="post" class="form-horizontal">
    <div class="form-group">
        <label class="col-lg-2 control-label">Date Save</label>
           <div class="col-lg-10">
           <input type="text" value="<?php echo $rowmass['date']; ?>" disabled> 
           </div>
        </div>
  <div class="form-group">
        <label class="col-lg-2 control-label">Change Date</label>
           <div class="col-lg-10">
           <select name="date" id="date">
             <option value="Monday">Monday</option>
             <option value="Tuesday">Tuesday</option>
             <option value="Wednesday">Wednesday</option>
             <option value="Thursday">Thursday</option>
             <option value="Friday">Friday</option>
             <option value="Saturday">Saturday</option>
             <option value="Sunday">Sunday</option>
           </select>
           </div>
        </div>
         <div class="form-group">
         <label class="col-lg-2 control-label">Time</label>
           <div class="col-lg-10">
           <textarea class="form-control" rows="3" name="time" id="time"><?php echo $rowmass['time']; ?></textarea>
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Type</label>
           <div class="col-lg-10">
           <input type="text" name="type" id="type" value="<?php echo $rowmass['type']; ?>">
           </div>
        </div>
        
 <button type="submit" class="btn btn-danger btn-sm">Submit</button><br>
        </form>
                                      </div>
                                  </div><!-- /.modal-content -->
                              </div><!-- /.modal-dialog -->
                          </div><!-- /.modal -->
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
                                <a href="#updatemass<?php echo $rowmass['id']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>Update Mass</a>
                  <a href="include/deletemass.php?id=<?php echo $rowmass['id']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>Delete Mass</a><br>                                
                            
                            </div>
                        </div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="updatemass<?php echo $rowmass['id']; ?>" class="modal fade" style="display: none;">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Update Mass</h4>
        </div>
<div class="modal-body">
<form action="include/updatemass.php?massid=<?php echo $rowmass['id']; ?>" method="post" class="form-horizontal">
    <div class="form-group">
        <label class="col-lg-2 control-label">Date Save</label>
           <div class="col-lg-10">
           <input type="text" value="<?php echo $rowmass['date']; ?>" disabled> 
           </div>
        </div>
  <div class="form-group">
        <label class="col-lg-2 control-label">Change Date</label>
           <div class="col-lg-10">
           <select name="date" id="date">
             <option value="Monday">Monday</option>
             <option value="Tuesday">Tuesday</option>
             <option value="Wednesday">Wednesday</option>
             <option value="Thursday">Thursday</option>
             <option value="Friday">Friday</option>
             <option value="Saturday">Saturday</option>
             <option value="Sunday">Sunday</option>
           </select>
           </div>
        </div>
         <div class="form-group">
         <label class="col-lg-2 control-label">Time</label>
           <div class="col-lg-10">
           <textarea class="form-control" rows="3" name="time" id="time"><?php echo $rowmass['time']; ?></textarea>
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Type</label>
           <div class="col-lg-10">
           <input type="text" name="type" id="type" value="<?php echo $rowmass['type']; ?>">
           </div>
        </div>
        
 <button type="submit" class="btn btn-danger btn-sm">Submit</button><br>
        </form>
                                      </div>
                                  </div><!-- /.modal-content -->
                              </div><!-- /.modal-dialog -->
                          </div><!-- /.modal -->
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
        </section>
<!--         <section id="verse" style="clear:both;">
          <h1>Daily Bible Verse</h1>
        </section>
 -->
  <!-- SECTION FOR CONTACT -->
        <section id="contact" style="clear:both;">
           <h1>Contact</h1>
           <?php
           include('include/connect_to_db.php');
           $querycontact = $con->query("SELECT * FROM contact WHERE coordinate = '$admincoordinate'");
        if ($querycontact->num_rows > 0) {
           while ($rowcontact = $querycontact->fetch_array()) {
             ?>
             <h3><?php echo $rowcontact['contact']; ?></h3>
             <a href="#updatecontact<?php echo $rowcontact['id']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>Update Contact</a>
             <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="updatecontact<?php echo $rowcontact['id']; ?>" class="modal fade" style="display: none;">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Update Contact</h4>
        </div>
<div class="modal-body">
<form action="include/updatecontact.php?id=<?php echo $rowcontact['id']; ?>" method="post" class="form-horizontal">
    <div class="form-group">
        <label class="col-lg-2 control-label">Contact</label>
           <div class="col-lg-10">
           <input type="text" value="<?php echo $rowcontact['contact']; ?>" name="contact" id="contact"> 
           </div>
        </div>    
 <button type="submit" class="btn btn-danger btn-sm">Submit</button><br>
        </form>
                                      </div>
                                  </div><!-- /.modal-content -->
                              </div><!-- /.modal-dialog -->
                          </div><!-- /.modal -->
             <?php
           }}else{
            ?>
            <a href="#addcontact" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>Add Contact</a>
             <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="addcontact" class="modal fade" style="display: none;">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Add Contact</h4>
        </div>
<div class="modal-body">
<form action="include/addcontact.php?v=<?php echo $admincoordinate; ?>" method="post" class="form-horizontal">
    <div class="form-group">
        <label class="col-lg-2 control-label">Contact</label>
           <div class="col-lg-10">
           <input type="text" name="contact" id="contact"> 
           </div>
        </div>    
 <button type="submit" class="btn btn-danger btn-sm">Submit</button><br>
        </form>
                                      </div>
                                  </div><!-- /.modal-content -->
                              </div><!-- /.modal-dialog -->
                          </div><!-- /.modal -->
            <?php
           }
           ?>
        </section>

<?php } ?>

        <!-- SECTION FOR FORUM -->
        <section id="forum" style="clear:both; background:white;">
        <h1>Forums</h1>
          <script>
// if user is login
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
<span style="color:black;"><h1>News</h1></span>
<textarea class="form-control" rows="3" id="suggest" name="suggest" required></textarea>
<input type="hidden" name="typeThread" id="typeThread" value="News">
<input name="myBtn" type="submit" class="btn btn-light" value="Post" onclick="ajax_post();"> <br><br>
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
<?php if($rowpost['username'] === $adminname){
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
<?php if($replypost['username'] === $adminname){
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
</div>
<?php
}
?>
<form method="POST">
    <textarea class="form-control" rows="3" id="reply<?php echo $postid; ?>" name="reply<?php echo $postid; ?>" required></textarea>
    <input type="hidden" name="post_id<?php echo $postid; ?>" id="post_id<?php echo $postid; ?>" value="<?php echo $postid; ?>">
    <input type="submit" class="btn btn-dark" value="Reply" onclick="ajax_reply('reply<?php echo $postid; ?>','post_id<?php echo $postid; ?>','status-reply-<?php echo $postid; ?>');">
</form>
</div>
</div>
</div>
<?php
}else{
?>
<div class="message">
<a data-toggle="modal" class="list-group-item">
<div style="border: 1px solid gray; background: white; color: black; text-align: left;">
<?php if($rowpost['username'] === $adminname){
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
<?php if($replypost['username'] === $adminname){
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
</div>
<?php
}
?>
<form method="POST">
    <textarea class="form-control" rows="3" id="reply<?php echo $postid; ?>" name="reply<?php echo $postid; ?>" required></textarea>
    <input type="hidden" name="post_id<?php echo $postid; ?>" id="post_id<?php echo $postid; ?>" value="<?php echo $postid; ?>">
    <input type="submit" class="btn btn-dark" value="Reply" onclick="ajax_reply('reply<?php echo $postid; ?>','post_id<?php echo $postid; ?>','status-reply-<?php echo $postid; ?>');">
</form>
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


        </section>

<!--         <div class="row">
          <footer id="admin-footer" class="clearfix">
            <div class="pull-left"><b>Copyright </b>&copy; 2016</div>
            <div class="pull-right">admin system</div>
          </footer>
        </div> -->
      </div>
      </div>
    </div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/default.js"></script>
  </body>
</html>