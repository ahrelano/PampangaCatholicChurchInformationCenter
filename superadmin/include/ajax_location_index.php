<form method="POST" action="index.php">
<select name="church" onchange="this.form.submit()">
<option value="Church">Church</option>
<?php
session_start();
include ('connect_to_db.php');
if(isset($_POST['town'])){
	$town = $_POST['town'];

	$query = $con->query("SELECT * FROM church WHERE town = '$town'");
	while ($rowtown = $query->fetch_array()){
		?>
		<option value="<?php echo $rowtown['coordinate']; ?>"><?php echo $rowtown['churchname']; ?></option>
		<?php
	}
}
?>
</select>
</form>