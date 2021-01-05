<?php
session_start();
include ('connect_to_db.php');
if(isset($_POST['id']) && isset($_SESSION['username'])){
	$postid = $_POST['id'];
	$reply = $_POST['reply'];
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
array("pennis","p*****"),
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
array("butt","b***"),
array("burat","b****"),
array("fuckyou","f*******"),
array("butt","b***")
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
$any = BadWordFilter($reply,1); 
 
// this will not repace any bad words. $any is 1 if it found any
$any = BadWordFilter($reply,0); 
	$username = $_SESSION['username'];
$now = date('M d, Y g:i:s A');
$query = $con->query("INSERT INTO reply (id,username,post,`date`) VALUES ('$postid','$username','$reply','$now')");
?>
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
    <textarea class="form-control" rows="3" id="reply<?php echo $postid; ?>" name="reply<?php echo $postid; ?>"></textarea>
    <input type="hidden" name="post_id<?php echo $postid; ?>" id="post_id<?php echo $postid; ?>" value="<?php echo $postid; ?>">
    <input type="submit" class="btn btn-dark" value="Reply" onclick="ajax_reply('reply<?php echo $postid; ?>','post_id<?php echo $postid; ?>','status-reply-<?php echo $postid; ?>');">
</form>
</div>
</div>
</div>
<?php
}
?>