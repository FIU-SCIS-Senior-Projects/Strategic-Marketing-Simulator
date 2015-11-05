<?php
include("connection.php");
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

<script src="jquery-1.9.0.min.js"></script>
<script>
/*$(document).ready(function(){


$("select#drop2").change(function(){

	var group_id = $("select#drop2 option:selected").attr('value');
    //alert(group_id);
	if (group_id.length > 0 ) { 
	 $.ajax({
			type: "POST",
			url: "fetch_students.php",
			data: "group_id="+group_id,
			cache: false,
			beforeSend: function () { 
				$('#students').html('<img src="/srv/marketsim/www/loader.gif" alt="" width="24" height="24">');
			},
			success: function(html) {    
				$("#students").html( html );
				alert(html);
			}
		});
	} else {
		$("#students").html( "" );
	}
});

});*/
</script>