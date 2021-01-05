<?php
session_start();
include ('connect_to_db.php');
if(isset($_POST['town'])){
	$townclick = $_POST['town'];
?>
<div class="form-group">
           <div class="col-lg-10">
                <select class="form-control" name="location" id="location" onchange="checkcoordinate()">
                <option id="selected" value="Town" selected>Choose Town</option>
                <?php
                $query = $con->query("SELECT DISTINCT town FROM church ORDER BY town"); 
                while($townrows = $query->fetch_array()){
                $town = preg_replace('#[^a-z0-9]#i', '', $townrows['town']);
                ?>
                <option value="<?php echo $townrows['town']; ?>" <?php if ($townrows['town'] == $townclick) echo 'selected'; ?>><?php echo $town; ?></option>
                <?php
                }
                ?>
                </select>
           </div>
        </div>

<div class="form-group">
 <div class="col-lg-10">
<?php
if ($townclick <> "Town") {
?>
<select class="form-control" name="churchupdate" id="churchupdate">
<?php
	$query = $con->query("SELECT * FROM church WHERE town = '$townclick'");
	while ($rowtown = $query->fetch_array()){
		$coordinate = $rowtown['coordinate'];
		?>
		<option value="<?php echo $rowtown['coordinate']; ?>"><?php echo $rowtown['churchname']; ?></option>
		<?php
	
	}
}
?>
</select>
<?php } ?>
</div>
</div>
