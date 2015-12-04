<?php
include("connection.php");
ini_set('display_errors', 1);
error_reporting(~0);



$group_id =  trim(mysqli_real_escape_string($con,$_POST['game_id']));

echo "something";

$sql = "select * from student s, hotel h, where h.id =" . $group_id . " and s.hotel.h.id;";
$count = mysqli_num_rows( mysqli_query($con, $sql) );
if ($count > 0 ) {
$query = mysqli_query($con, $sql);
?>
<label>  
<select name="students" id="drop3">
	<option value=""></option>
	<?php while ($rs = mysqli_fetch_array($query, MYSQLI_ASSOC)) { ?>
	<option name = "studentsID" value="<?php echo $rs['id']; ?>"><?php echo $rs['fname'] . " | ".$rs['lname'] ; ?></option>
	<?php } ?>
</select>
</label>
<?php 
	}
	else
	{
		echo "query didn't work";
	}


?>

