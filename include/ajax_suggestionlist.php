<?php
session_start();
include('connect_to_db.php');
?>
<span style="color:black;"><h1>Suggestions</h1></span>
<textarea class="form-control" rows="3" id="suggest" name="suggest" required></textarea>
<input type="hidden" name="typeThread" id="typeThread" value="Suggestion">
<input name="myBtn" type="submit" class="btn btn-light" value="Post" onclick="ajax_post();"> <br><br>
    <?php
    $var = 0;
    if(isset($_POST['submit'])){
}else{
     $post = $con->query("SELECT * FROM post WHERE type='Suggestion' ORDER BY `id` DESC");
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
<?php if($rowpost['username'] === $_SESSION['username']){
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
<?php if($replypost['username'] === $_SESSION['username']){
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
<?php if($rowpost['username'] === $_SESSION['username']){
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
<?php if($replypost['username'] === $_SESSION['username']){
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
