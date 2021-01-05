<?php
session_start();
include('connect_to_db.php');
if (isset($_POST['message']) && isset($_SESSION['username'])) {
$username = $_SESSION['username'];
if ($_POST['message'] <> 0) {
$number = $_POST['message'] * 5;
$limit = $number * 2;
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
                $page = 0;
               $querywake = $con->query("SELECT * FROM wake WHERE username = '$username' AND approve='no' ORDER BY id DESC");
            while ($rowwake = $querywake->fetch_array()) {
              $page = $page + 1;
              if ($page > $number AND $page <= $limit) {       
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
            }
            ?>
            </table>
<?php
}else{
$number = $_POST['message'];
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
                $page = 0;
               $querywake = $con->query("SELECT * FROM wake WHERE username = '$username' AND approve='no' ORDER BY id DESC");
            while ($rowwake = $querywake->fetch_array()) {
              $page = $page + 1;
              if ($page <= 5) {       
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
            }
            ?>
            </table>
<?php
}}
?>
