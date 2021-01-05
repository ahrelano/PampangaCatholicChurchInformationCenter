<?php
session_start();
include('connect_to_db.php');
if (isset($_POST['message']) ) {
// $adminchurch = $_SESSION['church'];
// $admintown = $_SESSION['town'];
if ($_POST['message'] <> 0) {
$number = $_POST['message'] * 5;
$limit = $number * 2;
?>
   <table class="table table-bordered">
        <th colspan="4" style="text-align:center; background-color: red; color: black;"><h3>Admins</h3></th>
<tr>
<th>Username</th>
<th>Church</th>
<th>Status</th>
<th>Restriction</th>
</tr>
            <?php
             $page = 0;
             $admin = $con->query("SELECT * FROM account WHERE type='admin' ORDER BY username");
            while ($rowadmin = $admin->fetch_array()) {
              $page = $page + 1;
              if ($page > $number AND $page <= $limit) {    
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
              }
              ?>
              </table>
<?php
}else{
	$number = $_POST['message'];
?>
 <table class="table table-bordered">
        <th colspan="4" style="text-align:center; background-color: red; color: black;"><h3>Admins</h3></th>
<tr>
<th>Username</th>
<th>Church</th>
<th>Status</th>
<th>Restriction</th>
</tr>
            <?php
             $page = 0;
             $admin = $con->query("SELECT * FROM account WHERE type='admin' ORDER BY username");
            while ($rowadmin = $admin->fetch_array()) {
              $page = $page + 1;
              if ($page <= 5) {     
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
              }
              ?>
              </table>
	<?php
}}
?>
