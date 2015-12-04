<?php
include("connection.php");
ini_set('display_errors', 1);
error_reporting(~0);


$game_id =  trim(mysqli_real_escape_string($con,$_POST['game_id']));


//$sql = "select name, l.type from game g, location l, hotel h where h.game =" .$game_id . " and h.location = l.id"; 

$sql = "select * from game g, location l, hotel h where h.game =" .$game_id . " and h.location = l.id";
$count = mysqli_num_rows( mysqli_query($con, $sql) );
if ($count > 0 ) {
$query = mysqli_query($con, $sql);
?>
	  
	<label>
	<h3>Groups</h3> 
		<select name="group" id="drop2">
			<option value=""></option>
	
			<?php while ($rs = mysqli_fetch_array($query, MYSQLI_ASSOC)) { ?>
			<option name = "groupID" value="<?php echo $rs['id']; ?>"><?php echo $rs['name'] . " | ".$rs['type'] ; ?></option>
			<?php } ?>
		</select>
	</label>



<script src="jquery-1.9.0.min.js"></script>
<script>
/*$(document).ready(function(){


$("select#drop2").change(function(){

	var group_id = $("select#drop2 option:selected").attr('value');
    alert(group_id);
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
				//alert(html);
			}
		});
	} else {
		$("#students").html( "" );
	}
});

});*/
</script>