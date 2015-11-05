<?php
include("connection.php");
ini_set('display_errors', 1);
error_reporting(~0);

$group_id =  trim(mysqli_real_escape_string($con,$_POST['group_id']));

//$sql = "select name, l.type from game g, location l, hotel h where h.game =" .$game_id . " and h.location = l.id"; 

$sql = "select * from student s, hotel h where s.hotel = h.id and h.id =" . $group_id . ";";
$count = mysqli_num_rows( mysqli_query($con, $sql) );
if ($count > 0 ) {
$query = mysqli_query($con, $sql);
?>
<label> 

		<div class='col-md-8'><h3 class='alert bg-primary'>Students</h3></div>
		
  
<select name="student" name = "box">

	<!--<option value="select a student" selected>select a student</option>-->
	
	<?php while ($rs = mysqli_fetch_array($query, MYSQLI_ASSOC)) { ?>
	<option value="<?php echo $rs['id']; ?>" selected><?php echo $rs['fname'] . " | ".$rs['lname'] ; ?></option>
	
	<?php } ?>
</select>

<br /> <br />

<input name = 'new student' type = 'submit' value = 'new student' class='btn btn-primary'/>
<input name = 'deactivate student' type = 'submit' value = 'deactivate student' class='btn btn-primary'/>
<input name = 'create bot group' type = 'submit' value = 'create bot group' class='btn btn-primary'/>
<input name = 'create admin' type = 'submit' value = 'create admin' class='btn btn-primary'/>
<input type "text" name= 'searchStudent'><input type = 'submit' value = "search">

</label>
<?php } ?>
