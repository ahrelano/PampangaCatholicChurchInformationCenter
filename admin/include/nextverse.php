<?php
session_start();
include('connect_to_db.php');
if (isset($_POST['message']) && isset($_SESSION['coordinate'])) {
$admincoordinate = $_SESSION['coordinate'];
if ($_POST['message'] <> 0) {
$number = $_POST['message'] * 5;
$limit = $number * 2;
?>
 <table class="table table-bordered">
        <th colspan="4" style="text-align:center; background-color: lightgreen; color: white;"><h3>Daily Bible Verse</h3></th>
<tr>
<th>Title</th>
<th>Body</th>
<th>Date</th>
<th>Action</th>
</tr>
  <?php
  $page = 0;
  $queryverse = $con->query("SELECT * FROM dailyverse WHERE coordinate = '$admincoordinate' ORDER BY id DESC");
  while ($rowverse = $queryverse->fetch_array()) {
    $page = $page + 1;
              if ($page > $number AND $page <= $limit) { 
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
}
?>
</table>

<?php
}else{
$number = $_POST['message'];
?>
<table class="table table-bordered">
        <th colspan="4" style="text-align:center; background-color: lightgreen; color: white;"><h3>Daily Bible Verse</h3></th>
<tr>
<th>Title</th>
<th>Body</th>
<th>Date</th>
<th>Action</th>
</tr>
  <?php
  $page = 0;
  $queryverse = $con->query("SELECT * FROM dailyverse WHERE coordinate = '$admincoordinate' ORDER BY id DESC");
  while ($rowverse = $queryverse->fetch_array()) {
   $page = $page + 1;
              if ($page <= 5) {    
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
}
?>
</table>
<?php
}}
?>