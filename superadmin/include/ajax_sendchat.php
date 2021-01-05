<?php
session_start();
include('connect_to_db.php');
if (isset($username)) {
	$message = $_POST['message'];
	$username = $_SESSION['username'];
	$now = date('M d, Y g:i:s A');
$querychat = $con->query("INSERT INTO group_chat (username,message,submitdate) VALUES ('$username', '$message', '$now')");

$show = $con->query("SELECT * FROM group_chat ORDER BY submitdate");
	while ($rowchat = $show->fetch_array()) {
	if (($rowchat['username']) === $username) {
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
}}}
?>