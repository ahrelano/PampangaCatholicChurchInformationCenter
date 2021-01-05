<?php
session_start();
if(isset($_SESSION['islogin'])){
    $islogin=$_SESSION['islogin'];
    if ($islogin === 1) {
        header('location: ../index.php');
        exit();
    }else if  ($islogin === 3) {
        header('location: ../superadmin/index.php');
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
      $adminchurch = $info['churchname'];
      $admintown = $info['town'];
      $_SESSION['church'] = $info['churchname'];
      $_SESSION['town'] = $info['town'];
      $admincoordinate = $info['coordinate'];
      $adminpassword = $info['password'];
      $adminid = $info['id'];
      $_SESSION['coordinate'] = $info['coordinate'];
    }
  }
}

        if(isset($_POST['submitHeader'])){
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

    if (isset($_SESSION['versedelete'])) {
        if (empty($_SESSION['versedelete'])) {
        }else{
            ?>
            <script type="text/javascript">
                alert('Bible verse successfuly deleted!');
            </script>
            <?php
        $_SESSION['versedelete'] = "";
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

    if (isset($_SESSION['disapprove'])) {
        if (empty($_SESSION['disapprove'])) {
        }else{
            ?>
            <script type="text/javascript">
                alert('Disapproved Success!');
            </script>
            <?php
        $_SESSION['disapprove'] = "";
        }
    } 

    if (isset($_SESSION['itemremove'])) {
        if (empty($_SESSION['itemremove'])) {
        }else{
            ?>
            <script type="text/javascript">
                alert('Item successfuly removed!');
            </script>
            <?php
        $_SESSION['itemremove'] = "";
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
    <title>Admin</title>

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
        <h6 style="color: #fff;" >Hi <?php echo $adminname . " <br>of<br> " . $adminchurch; ?>!</h6>
        <ul>
          <li class="link">
            <a href="#header">
              <span class="glyphicon glyphicon-th" aria-hidden="true"></span>
              <span>Header</span>
            </a>
          </li>

<!--           <li class="link">
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

<!--           <li class="link">
            <a href="tags.php">
              <span class="glyphicon glyphicon-tags" aria-hidden="true"></span>
              <span>Tags</span>
            </a>
          </li>

          <li class="link">
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
              <!-- <input type="text" id="header-search-field" placeholder="Search">
 -->            </div>
            <div class="col-md-7">
              <ul class="pull-right">
                <li id="welcome"><h4>Welcome to your administration area</h4></li>
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

        <script type="text/javascript">
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

<?php 
include('include/connect_to_db.php');
$restrictchat = $con->query("SELECT chat FROM `restrict` WHERE username = '$adminname' LIMIT 1");
if ($restrictchat->num_rows > 0){ 
  while ($rowrestrict = $restrictchat->fetch_array()) {
  if ($rowrestrict['chat'] == 'no') {
      }else{
        ?>
        <!-- SECTION FOR CHAT -->
        <section id="chat"> 
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
        <?php
      }
  }
} ?>

<?php 
include('include/connect_to_db.php');
$restrictchat = $con->query("SELECT header FROM `restrict` WHERE username = '$adminname' LIMIT 1");
if ($restrictchat->num_rows > 0){ 
  while ($rowrestrict = $restrictchat->fetch_array()) {
  if ($rowrestrict['header'] == 'no') {
      }else{
        ?>
        <!-- SECTION FOR HEADER -->
        <section id="header" style="clear:both;">
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
        <?php
      }
  }
} ?>


<?php 
include('include/connect_to_db.php');
$restrictchat = $con->query("SELECT history FROM `restrict` WHERE username = '$adminname' LIMIT 1");
if ($restrictchat->num_rows > 0){ 
  while ($rowrestrict = $restrictchat->fetch_array()) {
  if ($rowrestrict['history'] == 'no') {
      }else{
        ?>
        <!-- SECTION FOR HISTORY -->
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
<br><br><input type="text" value="<?php echo $rowhistory['title']; ?>" readonly><br>
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
            ?><br><br>
            <textarea class="form-control" rows="3" readonly><?php echo $rowhistory['info']; ?></textarea>
            <a href="#updateInfo<?php echo $rowhistory['id']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>Update Info</a>
                  <a href="include/deleteinfo.php?id=<?php echo $rowhistory['id']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>Delete Info</a>

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
        <?php
      }
  }
} ?>

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

<?php 
include('include/connect_to_db.php');
$restrictchat = $con->query("SELECT galleries FROM `restrict` WHERE username = '$adminname' LIMIT 1");
if ($restrictchat->num_rows > 0){ 
  while ($rowrestrict = $restrictchat->fetch_array()) {
  if ($rowrestrict['galleries'] == 'no') {
      }else{
        ?>
        <!-- SECTION FOR GALLERIES -->
        <section id="galleries">
        <h1>Galleries</h1>
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
        <?php
      }
  }
} ?>

<section id="dailyverse" style="clear:both;">
  <h1>Daily Bible Verse</h1>
  <a href="#addverse" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>Add Mass Schedule</a><br>
          <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="addverse" class="modal fade" style="display: none;">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Add Bible Verse</h4>
        </div>
<div class="modal-body">
<form action="include/addverse.php" method="post" class="form-horizontal">
        <div class="form-group">
        <label class="col-lg-2 control-label">Title</label>
           <div class="col-lg-10">
           <input class="form-control" type="text" name="titleverse" id="titleverse" required>
           </div>
        </div>
         <div class="form-group">
         <label class="col-lg-2 control-label">Body</label>
           <div class="col-lg-10">
           <textarea class="form-control" rows="3" name="bodyverse" id="bodyverse" required></textarea>
           </div>
        </div>
        <div class="form-group">
        <label class="col-lg-2 control-label">Month</label>
           <div class="col-lg-10">
           <select name="monthverse" id="monthverse" class="form-control" onchange="checkverse()">
           <option value="<?php echo date('F'); ?>"><?php echo date('F'); ?></option>
           <?php
           $month = date('F');
           if ($month === 'January') {
             ?>
             <option value="February">February</option>
             <?php
           }else if($month === 'February'){
            ?>
             <option value="March">March</option>
             <?php
           }else if($month === 'March'){
            ?>
             <option value="April">April</option>
             <?php
           }else if ($month === 'April') {
              ?>
             <option value="May">May</option>
             <?php 
           }else if ($month === 'May') {
            ?>
             <option value="June">June</option>
             <?php  
           }else if ($month === 'June') {
            ?>
             <option value="July">July</option>
             <?php
           }else if ($month === 'July') {
              ?>
             <option value="August">August</option>
             <?php
           }else if ($month === 'August') {
            ?>
             <option value="September">September</option>
             <?php  
           }else if ($month === 'September') {
             ?>
             <option value="October">October</option>
             <?php
                 }else if ($month === 'October') {
             ?>
             <option value="November">November</option>
             <?php
                }else if ($month === 'November') {
             ?>
             <option value="December">December</option>
             <?php
           }else if ($month === 'December') {
             ?>
             <option value="January">January</option>
             <?php
           }
           ?>
           </select>
           </div>
        </div> 
        <div class="form-group">
        <label class="col-lg-2 control-label">Day</label>
           <div class="col-lg-10">
            <select id="dayverse" name="dayverse" class="form-control" onchange="checkverse()">
              <?php
              for ($i=1; $i <= 31; $i++) { 
                ?>
               <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php
              }
              ?>
            </select>
        </div>
        </div>
        <input type="hidden" id="versecoordinate" name="versecoordinate" value="<?php echo $admincoordinate; ?>">
        <span id="versestatus" style="color:red;"></span><br>
 <button type="submit" id="btnVerse" class="btn btn-danger btn-sm" disabled>Submit</button><br>
        </form>
                                      </div>
                                  </div><!-- /.modal-content -->
                              </div><!-- /.modal-dialog -->
                          </div><!-- /.modal -->
<?php
include('include/connect_to_db.php');
$countwake = 0;
            $total = 0;
            $numberwake = 0;
            $five = 5;
$queryverse = $con->query("SELECT * FROM dailyverse WHERE coordinate = '$admincoordinate' ORDER BY id DESC");
if ($queryverse->num_rows > 0) {
  ?>
  <div id="statusbibleverse">
          <table class="table table-bordered">
        <th colspan="4" style="text-align:center; background-color: lightgreen; color: white;"><h3>Daily Bible Verse</h3></th>
<tr>
<th>Title</th>
<th>Body</th>
<th>Date</th>
<th>Action</th>
</tr>
  <?php
  while ($rowverse = $queryverse->fetch_array()) {
    $numberwake = $numberwake + 1;
              if ($numberwake <= 5) { 
    ?>
    <tr>
      <td><?php echo $rowverse['verse']; ?></td>
      <td><?php echo $rowverse['text']; ?></td>
      <td><?php echo $rowverse['date']; ?></td>
      <td>
<a href="include/deleteverse.php?v=<?php echo $rowverse['id']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>Delete</a><br>
<a href="#editverse<?php echo $rowverse['id']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>Edit</a><br>
      </td>
    </tr>
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="editverse<?php echo $rowverse['id']; ?>" class="modal fade" style="display: none;">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Edit Bible Verse</h4>
        </div>
<div class="modal-body">
<form action="include/editverse.php" method="post" class="form-horizontal">
        <div class="form-group">
        <label class="col-lg-2 control-label">Title</label>
           <div class="col-lg-10">
           <input class="form-control" type="text" name="titleverse" id="titleverse" value="<?php echo $rowverse['verse']; ?>" required>
           </div>
        </div>
         <div class="form-group">
         <label class="col-lg-2 control-label">Body</label>
           <div class="col-lg-10">
           <textarea class="form-control" rows="3" name="bodyverse" id="bodyverse" required><?php echo $rowverse['text']; ?></textarea>
           </div>
        </div>
         <div class="form-group">
        <label class="col-lg-2 control-label">Date</label>
           <div class="col-lg-10">
           <input class="form-control" type="text" value="<?php echo $rowverse['date']; ?>" readonly>
           </div>
        </div>
        <input type="hidden" id="verseid" name="verseid" value="<?php echo $rowverse['id']; ?>">
 <button type="submit" class="btn btn-danger btn-sm" >Update</button><br>
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
            }
}
?>
</table>
</div>
<?php
            if ($total <> 0) {
              ?>
              <button class="btn btn-danger btn-sm" type="button" onclick="nextverse('0')">1</button>
              <?php
              $a = 1;
              for ($i=1; $i <= $total; $i++) { 
                $a = $a + 1;
              ?>
              <button class="btn btn-danger btn-sm" type="button" onclick="nextverse(<?php echo $i; ?>)"><?php echo $a; ?></button>
              <?php
              }
            }
            ?>
<?php
}
?>
</section>

<script type="text/javascript">
  function nextverse(number){
    // Create our XMLHttpRequest object
    var hr = new XMLHttpRequest();
    // Create some variables we need to send to our PHP file
    var url = "include/nextverse.php";
    // var ln = document.getElementById("last_name").value;
    var vars = "message="+number;
    hr.open("POST", url, true);
    // Set content type header information for sending url encoded variables in the request
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // Access the onreadystatechange event for the XMLHttpRequest object
    hr.onreadystatechange = function() {
        if(hr.readyState == 4 && hr.status == 200) {
            var return_data = hr.responseText;
            document.getElementById("statusbibleverse").innerHTML = return_data;
        }
    }
    // Send the data to PHP now... and wait for response to update the status div
    hr.send(vars); // Actually execute the request
}

        function _ (el) {
        return document.getElementById(el);
    }
    function checkverse(){
        var status = document.getElementById("versestatus");
        var d = document.getElementById("dayverse").value;
        var m = document.getElementById("monthverse").value;
        var coor = document.getElementById("versecoordinate").value;
            status.innerHTML = 'checking...';
            var hr = new XMLHttpRequest();
            hr.open("POST", "auth/checkverse.php", true);
            hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            hr.onreadystatechange = function() {
                if(hr.readyState == 4 && hr.status == 200) {
                    status.innerHTML = hr.responseText;
                    if (hr.responseText == "ok") {
                        status.innerHTML = "";
                        _('btnVerse').disabled = false;
                    }else {
                        _('btnVerse').disabled = true;
                    }
                }
            }
            var v = "dayverse=" + d + "&monthverse=" + m + "&coordinate=" + coor;
            hr.send(v);
    }
  </script>

<?php 
include('include/connect_to_db.php');
$restrictchat = $con->query("SELECT mass FROM `restrict` WHERE username = '$adminname' LIMIT 1");
if ($restrictchat->num_rows > 0){ 
  while ($rowrestrict = $restrictchat->fetch_array()) {
  if ($rowrestrict['mass'] == 'no') {
      }else{
        ?>
        <!-- SECTION FOR MASS -->
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
        <?php
      }
  }
} ?>

 <?php 
include('include/connect_to_db.php');
$restrictchat = $con->query("SELECT mass FROM `restrict` WHERE username = '$adminname' LIMIT 1");
if ($restrictchat->num_rows > 0){ 
  while ($rowrestrict = $restrictchat->fetch_array()) {
  if ($rowrestrict['mass'] == 'no') {
      }else{
        ?>
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
        <?php
      }
  }
} ?>

<!-- PENDING RESERVATION -->
<section id="services">
<h2><span style="color:red;">Pending Reservation</span></h2>
<!-- RESERVATION FOR WAKE -->
        <div class="container">
            <?php
            $countwake = 0;
            $total = 0;
            $numberwake = 0;
            $five = 5;
            $querywake = $con->query("SELECT * FROM wake WHERE church = '$adminchurch' AND town = '$admintown' AND approve='no' ORDER BY id DESC");
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
              <td> <span style="color:red;"><?php echo $rowwake['approve']; ?></span></td>
              <td>
                <a href="#viewWake<?php echo $rowwake['id']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>View</a>
                   <a href="include/approvewake.php?id=<?php echo $rowwake['id']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>Approve</a>
                    <a href="auth/cancelwake.php?wakeid=<?php echo $rowwake['id']; ?>&deleteUntil=<?php echo $rowwake['until']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>Disapprove</a>
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
            }
          }
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
            $querywedding = $con->query("SELECT * FROM wedding WHERE church = '$adminchurch' AND town = '$admintown' AND approve='no' ORDER BY id DESC");
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
                <a href="include/approvewedding.php?id=<?php echo $rowwedding['id']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>Approve</a>
                <a href="auth/cancelwedding.php?weddingid=<?php echo $rowwedding['id']; ?>&removeUntil=<?php echo $rowwedding['until']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>Disapprove</a>               
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
            $querychristening = $con->query("SELECT * FROM christening WHERE church = '$adminchurch' AND town = '$admintown' AND approve='no' ORDER BY id DESC");
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
                <a href="include/approvechristening.php?id=<?php echo $rowchristening['id']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>Approve</a>
               <a href="auth/cancelchristening.php?christeningid=<?php echo $rowchristening['id']; ?>&banishUntil=<?php echo $rowchristening['until']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>Disapprove</a>
               
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
              </table>
              <?php
            }}
            ?>
        </div>
</section>

<!-- APPROVED RESERVATION -->
<section id="services">
<h2><span style="color:green;">Approved Reservation</span></h2>
<!-- RESERVATION FOR WAKE -->
        <div class="container">
            <?php
            $querywake = $con->query("SELECT * FROM wake WHERE church = '$adminchurch' AND town = '$admintown' AND approve='yes' ORDER BY id DESC");
            if ($querywake->num_rows > 0){
                ?>
        <table class="table table-bordered">
        <th colspan="4" style="text-align:center; background-color: blacK; color: white;"><h3>Wake</h3></th>
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
                    <?php if ($rowwake['show'] == 'yes'){ ?>
                      <a href="include/deletewake.php?v=<?php echo $rowwake['id']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>Hide</a>
                    <?php }else{
                      ?>
                       <a href="include/showwake.php?v=<?php echo $rowwake['id']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>Unhide</a>
                      <?php
                      } 
                      ?>
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
            $querywedding = $con->query("SELECT * FROM wedding WHERE church = '$adminchurch' AND town = '$admintown' AND approve='yes' ORDER BY id DESC");
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
                    <?php if ($rowwedding['show'] == 'yes'){ ?>
                     <a href="include/deletewedding.php?v=<?php echo $rowwedding['id']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>Hide</a>                         
                     <?php }else{
                      ?>
                       <a href="include/showwedding.php?v=<?php echo $rowwedding['id']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>Unhide</a>  
                       <?php
                      } 
                      ?>
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
            $querychristening = $con->query("SELECT * FROM christening WHERE church = '$adminchurch' AND town = '$admintown' AND approve='yes' ORDER BY id DESC");
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
                <?php if ($rowchristening['show'] == 'yes'){ ?>
                   <a href="include/deletechristening.php?v=<?php echo $rowchristening['id']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>Hide</a>          
                <?php }else{ ?>
<a href="include/showchristening.php?v=<?php echo $rowchristening['id']; ?>" data-toggle="modal"  title="Compose" class="btn btn-danger btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>Unhide</a>
                  <?php
                  } 
                  ?>
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
include('include/connect_to_db.php');
$restrictchat = $con->query("SELECT forum FROM `restrict` WHERE username = '$adminname' LIMIT 1");
if ($restrictchat->num_rows > 0){ 
  while ($rowrestrict = $restrictchat->fetch_array()) {
  if ($rowrestrict['forum'] == 'no') {
      }else{
        ?>
        <!-- SECTION FOR FORUM -->
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
<?php
$report_post = $con->query("SELECT * FROM report_post WHERE username = '$username' AND id = '$postid'");
if($rowpost['username'] === $adminname){
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
        <?php
      }
  }
} ?>

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