<?php
session_start();
include('connect_to_db.php');
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