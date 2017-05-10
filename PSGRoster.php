<?php
require("scripts/sconnect.php");

$plt_gear_accountability = "select g.g_id, g.name, g.itemCount, g.itemCount, ga.itemCount, gt.id, u.u_id, u.l_name, u.f_name from gear g join gearAccountability ga on g.g_id = ga.g_id join gearType gt on gt.id = g.type_id join users u on u.u_id = ga.u_id where g.showItem is true and ga.itemCount < g.itemCount order by gt.name asc, g.g_id asc;";




$gearResource = mysql_query($plt_gear_accountability);
$array = array();
while( $row  = mysql_fetch_assoc($gearResource))
	{
	$array[] = $row;
	}
?>

<html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript">
		var acc = <?php echo json_encode($array); ?>;	
		$(function(){
			for (var i = 0; i < acc.length; i++){
				var row = acc[i];
				var after_container;
				if ( $("div#gear > div#"+row["g_id"]).length == 0){
					$("<div class='title-bar' id='"+row["g_id"]+"' />").append($("<div />").append(row["name"])).appendTo($("div#gear"));
					$("<div />").appendTo($("div#gear"));
				}

				var $ita = $("div#gear > div#"+row["g_id"]);

				after_container = $ita.next();

				var $itb = $("<div />");
				$itb.append (  row["l_name"]+", "+row["f_name"] );
				//$ita.after($itb);
				after_container.append($itb);
			}

			$("div#gear > div.title-bar").each(function(){
				var c = $(this).next().children().length;
				$("<span class='count' />").append(c).appendTo($(this));
				});

			$("div#gear > div:not(.title-bar").hide();
			$("div#gear > div.title-bar").on("click", function(){
				$(this).next().slideToggle();
				});
		});
	</script>
	<style type="text/css">
		div#gear {
			margin-left: auto;
			margin-right: auto;
			width: 75%;
		}
		div#gear > div:not(.title-bar){
			padding-left: 20px;
		}
		div#gear > div.title-bar {
			background-color: lightblue;
			border: solid 1px black;
			border-radius: 5px;
			cursor: pointer;
		}
		div#gear > div.title-bar > div {
			display: inline;
		}

		div#gear > div.title-bar > span{
			float: right;
			margin-right: 20px;
			font-weight: bold;
		}
		div#gear > div.title-bar:hover{
			background-color: blue;
		}

	</style>
</head>
<body>
	<div id="gear">
	
<?php 

?>

	</div>

</body>
</html>



