<?php  
 //upload.php
session_start();
include ('connect_to_db.php');
 $output = ''; 
 if(isset($_FILES['fileUpload'])){
 if(isset($_SESSION['username'])){
$username = $_SESSION['username'];
      $target_file = "../picture/" . basename($_FILES["fileUpload"]["name"]);
$imageFileType = pathinfo($_FILES['fileUpload']['name'], PATHINFO_EXTENSION);
if($imageFileType === "jpg" || $imageFileType === "jpeg" || $imageFileType === "gif") {
  $ext = end((explode(".", $_FILES['fileUpload']['name'])));
  $new_name = md5(rand()) . '.' . $ext;
      move_uploaded_file($_FILES['fileUpload']['tmp_name'],"../picture/".$new_name);
      // $ext = pathinfo($_FILES['fileUpload']['name'], PATHINFO_EXTENSION);
  $output = '<img src="picture/'.$new_name.'" width="180px" height="180px" />';
  echo $output;
        $query = $con->query("UPDATE account SET image = '$new_name' WHERE username = '$username'");
      $query = $con->query("UPDATE post SET image = '$new_name' WHERE username = '$username'");
      $query = $con->query("UPDATE reply SET image = '$new_name' WHERE username = '$username'");
   } else { 
    echo "Sorry, only JPG, GIF and JPEG are allowed.<br>";
    if(isset($_SESSION['id'])){
$id = $_SESSION['id'];
$result = $con->query("SELECT * FROM account WHERE id = '$id'");
while ($rows = $result->fetch_array()){
  ?><img style="width: 180px; height: 180px;" src="picture/<?php echo $rows['image']; ?>">
  <?php
  }}
    }
}
}else{
echo "Sorry, only JPG, GIF and JPEG are allowed.<br>";
if(isset($_SESSION['id'])){
$id = $_SESSION['id'];
$result = $con->query("SELECT * FROM account WHERE id = '$id'");
while ($rows = $result->fetch_array()){
  ?><img style="width: 180px; height: 180px;" src="picture/<?php echo $rows['image']; ?>">
  <?php
  }}}
  ?>
