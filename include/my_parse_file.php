<?php
session_start();
include ('connect_to_db.php');
if(isset($_SESSION['username']) && isset($_POST['suggest']) && isset($_POST['thread'])){
    $username = $_SESSION['username'];
    $post = $_POST['suggest'];
  $thread = $_POST['thread'];
$now = date('M d, Y g:i:s A');
function BadWordFilter(&$text, $replace){
 
     // fill this array with the bad words you want to filter and their replacements
$bads = array (
array("butt","b***"),
array("poop","p***"),
array("fuck","f***"),
array("damn","d***"),
array("sex","s**"),
array("dildo","d****"),
array("animal","a*****"),
array("bugok","b****"),
array("alte","a***"),
array("bobo","b***"),
array("alangbalo","a*******"),
array("tarantado","t********"),
array("anakputaka","a***********"),
array("tangina","t*****"),
array("pussy","p****"),
array("penis","p*****"),
array("pekpek","p*****"),
array("butu","b***"),
array("boobs","b****"),
array("tits","t***"),
array("susu","s***"),
array("animal","a*****"),
array("karat","k****"),
array("bakla","b****"),
array("mamulang","m*******"),
array("mulala","m*****"),
array("bolang","b*****"),
array("sirabuntuk","s*********"),
array("lol","l**"),
array("./.","***"),
array("midfing","m******"),
array("flirt","f****"),
array("takshapo","t*******"),
array("mayangin","m*******"),
array("burat","b****"),
array("fuck you","f*******")
     );
 
     if($replace==1) {                                        //we are replacing
          $remember = $text;
 
          for($i=0;$i<sizeof($bads);$i++) {               //go through each bad word
               $text = eregi_replace($bads[$i][0],$bads[$i][1],$text); //replace it
          }
 
          if($remember!=$text) RETURN 1;                     //if there are any changes, return 1
 
     } else {                                                  //we are just checking
 
          for($i=0;$i<sizeof($bads);$i++) {               //go through each bad word
               if(eregi($bads[$i][0],$text)) return 1; //if we find any, return 1
          }     
     }
}
// this will replace all bad words with their replacements. $any is 1 if it found any
$any = BadWordFilter($post,1); 
 
// this will not repace any bad words. $any is 1 if it found any
$any = BadWordFilter($post,0); 

    $query = $con->query("INSERT INTO post (username,post,`date`,type) VALUES ('$username','$post','$now','$thread')");
}
?>

<textarea class="form-control" rows="3" id="suggest" name="suggest" required></textarea>
<input type="hidden" name="typeThread" id="typeThread" value="<?php echo $thread; ?>">
<input name="myBtn" type="submit" class="btn btn-light" value="Post" onclick="ajax_post();"> <br><br>
    <?php
    $var = 0;
    if(isset($_POST['submit'])){
}else{
     $post = $con->query("SELECT * FROM post WHERE type='$thread' ORDER BY `id` DESC");
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
