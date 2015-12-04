<?php

include("../Model/connection.php");
include("../Model/connection.php");
ini_set('display_errors', 1);
error_reporting(~0);



$game_id =  trim(mysqli_real_escape_string($con,$_POST['game_id']));

//$sql = "select name, l.type from game g, location l, hotel h where h.game =" .$game_id . " and h.location = l.id"; 

$sql = "select distinct h.id as id, h.name, l.type as type1, h.type as type2 from game g, location l, hotel h where h.game =" .$game_id . " and h.location = l.id";
$count = mysqli_num_rows( mysqli_query($con, $sql) );
if ($count > 0 ) {
$query = mysqli_query($con, $sql);
?>
<label>Please select a Group:  
<select name="group" id="drop2">
	<option value="">please select</option>
	
	<?php while ($rs = mysqli_fetch_array($query, MYSQLI_ASSOC)) {?>
	
	<option name = "group" value="<?php echo $rs['id']; ?>"><?php echo $rs['name'] . " | ".$rs['type1']. " | ".$rs['type2'] ; ?></option>
	<?php } ?>
</select>
</label>
<?php 
	}
	else print_r("error");

?>

<script src="../js/jquery-1.9.0.min.js"></script>
