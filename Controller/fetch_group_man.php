


<?php
include("../Model/connection.php");
ini_set('display_errors', 1);
error_reporting(~0);



$game_id =  trim(mysqli_real_escape_string($con,$_POST['game_id']));

//$sql = "select h.id as id, name, l.type from game g, location l, hotel h where h.game =" .$game_id . " and h.location = l.id"; 

$sql = "select distinct h.id as id, h.name, l.type as type1, h.type as type2 from game g, location l, hotel h where h.game =" .$game_id . " and h.location = l.id";
$count = mysqli_num_rows( mysqli_query($con, $sql) );
if ($count > 0 ) {
$query = mysqli_query($con, $sql);
?>
	<label>
	<div class='col-md-14'><h3 class='alert bg-primary'>Groups</h3></div>
	<select name="group" id="drop2">
	<!--<option value="Select a group" selected>Select a group</option>-->
	
	<?php while ($rs = mysqli_fetch_array($query, MYSQLI_ASSOC)) { ?>
	<option name = "group" value="<?php echo $rs['id']; ?>" selected><?php echo $rs['name'] . " | ".$rs['type1']. " | ".$rs['type2'] ; ?></option>
	<?php } ?>
		
	</select>
	 <br />
	<div class='panel-body' align='left'> 
		<input name = 'new group' type = 'submit' value = 'new group' class='btn btn-primary'/>
		<input name = 'deactivate group' type = 'submit' value = 'deactivate group' class='btn btn-primary'/>
		<input name = 'edit group' type = 'submit' value = 'edit group' class='btn btn-primary'/>
	</div>
	</label>

<?php 	}   ?>

<script src="jquery-1.9.0.min.js"></script>
<script>
$(document).ready(function(){


$("select#drop2").change(function(){

	var group_id = $("select#drop2 option:selected").attr('value');
    alert(group_id);
	if (group_id.length > 0 ) { 
	 $.ajax({
			type: "POST",
			url: "../fetch_students.php",
			data: "group_id="+group_id,
			cache: false,
			beforeSend: function () { 
				$('#student').html('<img src="../loader.gif" alt="" width="24" height="24">');
			},
			success: function(html) {    
				$("#student").html( html );
				//alert(html);
			}
		});
	} else {
		$("#students").html( "couldn't get students" );
	}
});

});
</script>