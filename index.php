<?php
	$ppts = scandir("ppt");
	$rslt = "";
	if( $ppts )
	{
		foreach ($ppts as $key=>$value)
		{
			if ($value == "." || $value == "..") continue;
			$rslt .= "<li><a href='ppt/$value'>$value</a></li>";
		}
		
	}
	
	$files = scandir("files");
	$filesToRead = "";
	if ($files){
		foreach( $files as $key=>$value){
			if($value == "." || $value =="..") continue;
			$filesToRead .= "<li><a href='files/$value'>$value</a></li>";
		}
	}
	
	$ops = scandir("ops");
	$opFiles = "";
	if($ops){
		foreach( $ops as $k=>$v){
			if($v == "." || $v =="..") continue;
			$opFiles .= "<li><a href='ops/$v'>$v</a></li>";
		}
	}
?>
<html>
<head>
<style>
	body > center > div{
		width: 30%;
	}
	#docs > div{
		background-color: gray;
		margin-bottom: 5px;
		border-radius: 5px;
		padding-left: 5px;
	}
	#docs > ul {
		background-color: lightgray
	}
	#docs > div:hover{ cursor: pointer; background-color:lightgray; }
	
	.no-bullet > li{
		list-style-type: none;
	}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript">
	$(function(){
		$("#docs > div").on("click", function(){ $(this).next().slideToggle()});
		$("#docs > div").next().hide();
		function CreateOverlay(content){
			$window = $("<div />");
			$content = $("<div />");
			$window.width(window.outerWidth);
			$window.height(window.outerHeight);
			
			$("body").append($window);
			$window.append($content);
			$window.css({ textAlign:"center", backgroundColor: "black", position:"absolute", left: 0, top: 0});
			$content.append(content);
			$content.css({display:"inline-block",marginLeft:"auto", marginRight:"auto", marginTop: "auto", verticalAlignment:"center", position:"relative", top:"50%", transform:"translateY(-50%)"});
			
			
			
			
			
			//button.on("click", function(){ $window.show(); }.bind(this));
			$window.on("click", function(){  $(this).hide(); $(this).remove();});
			$content.on("click", function(event){ event.stopPropagation(); });
			
		}
		
		var embedContent = '<iframe src="https://drive.google.com/file/d/0B3gN5-3YYPjHYTM0SUFTVlJVYjg/preview" width="640" height="480" allowfullscreen></iframe>';
		$("a#christmasVacation").on("click", function(){
			CreateOverlay(embedContent);
		});
		
		var swEmbed = '<iframe width="854" height="480" src="https://www.youtube.com/embed/2WBG2rJZGW8" frameborder="0" allowfullscreen></iframe>';
		$("a#starWarsAttack").on("click", function(){
			CreateOverlay(swEmbed);
		});
		
		var bob = [
			'<iframe src="https://drive.google.com/file/d/0B3gN5-3YYPjHZE5ZRlNDcVVSMm8/preview" width="640" height="480" allowfullscreen></iframe>',
			'<iframe src="https://drive.google.com/file/d/0B3gN5-3YYPjHR2lPV2VLcGVlVjA/preview" width="640" height="480" allowfullscreen></iframe>',
			'<iframe src="https://drive.google.com/file/d/0B3gN5-3YYPjHREtHazhjSDJQdU0/preview" width="640" height="480" allowfullscreen></iframe>',
			'<iframe src="https://drive.google.com/file/d/0B3gN5-3YYPjHeklyaVYzY1MtdkU/preview" width="640" height="480" allowfullscreen></iframe>',
			'<iframe src="https://drive.google.com/file/d/0B3gN5-3YYPjHbUZpeVZSVHRkcEk/preview" width="640" height="480" allowfullscreen></iframe>',
			'<iframe src="https://drive.google.com/file/d/0B3gN5-3YYPjHVnlDOGRpNk9jODg/preview" width="640" height="480" allowfullscreen></iframe>',
			'<iframe src="https://drive.google.com/file/d/0B3gN5-3YYPjHMmJwQkVuanhyaE0/preview" width="640" height="480" allowfullscreen></iframe>',
			'<iframe src="https://drive.google.com/file/d/0B3gN5-3YYPjHQzVmU3pQTkluLUk/preview" width="640" height="480" allowfullscreen></iframe>',
			'<iframe src="https://drive.google.com/file/d/0B3gN5-3YYPjHWkRTTFl6dDJ5NVU/preview" width="640" height="480" allowfullscreen></iframe>',
			'<iframe src="https://drive.google.com/file/d/0B3gN5-3YYPjHcnZpUl9nSHFrc3c/preview" width="640" height="480" allowfullscreen></iframe>'
		];
		
		var bob_titles = ["Currahee", "Day of Days", "Carentan", "Replacements", "Crossroads", "Bastogne", "The Breaking Point", "The Lost Patrol", "Why We Fight", "Points"];
		
		for (var i in bob){
			console.log(i);
			var id = Number(i)+1;
			var strName= "Band of Brothers: Ep "+id + " ("+bob_titles[i]+")";
			var embed = bob[i];
			$("ul#bandofbrothers").append($("<li />").append($("<a href='#' id = 'bob_"+id+"'/>")));
			$("a#bob_"+id).text(strName);
			$("a#bob_"+id).on("click", function(){ 
				var bob_index = Number($(this).attr("id").split("_")[1]) - 1;
				CreateOverlay(bob[bob_index]); 
			});
		}
	
	});

</script>
</head>
<body>
	<center>
	<div>For PT, visit: <br/><a href="PT.php">HERE</a></div>
	<div>For PT Analytics, Visit:<br/><a href="PTData.php">HERE</a></div>
	<br />
	<div><a href="ChangePassword.php">Change Your Password</a></div>
	<br />
	<!--<div><a href="NovemberHomework.docx">Homework From CPT Boyles</a></div>-->
	<div><a href="homework.txt">Homework</a></div>
	<div><a href="HomeworkFormat.docx">Homework Format</a></div>
	<div><a href="https://docs.google.com/spreadsheets/d/1VBVORdvZXhdHbGkq7W96mQVKMH1Bhf_9dtH4tm4y0Qs/edit?usp=sharing">Homework Tracker</a></div>
	<div><a href="opord.doc">OpOrd for Homework</a></div>
	<div><a href="CSI_MHIC_TSPSlides.pdf">PPT Slides For Homework</a></div>
	<div><a href="http://usacac.army.mil/organizations/mccoe/call">CALL Website</a></div>
	<br />
	<div><a href="https://PlatoonLeader.net/register/">Register for PlatoonLeader</a></div>
	<div><a href="https://www.milsuite.mil/book/groups/det-1-ocs-2166-regiment-rti">Join MilSuite OCS 56T Group</a></div>
	<div><a href="https://www.riteintherain.com/shop-products">All Weather Field Books Here</a></div>
	<!--<div><a id="christmasVacation" href="#">National Lampoon's Christmas Vacation<a/></div>-->
	<!--<div><a id="starWarsAttack" href="#">Star Wars A New Hope Attack Scene</a></div>-->
	</center>
	<br/>
	<br />
	<div id="docs">
		<div>Army Doctrines</div>
		<ul>
			<li>
				<div>ADP</div>
				<ul>
					<li><a href="http://armypubs.army.mil/doctrine/DR_pubs/dr_a/pdf/adp1.pdf">ADP-1 (The Army)</a></li>
					<li><a href="http://armypubs.army.mil/doctrine/DR_pubs/dr_a/pdf/adp1_01.pdf">ADP 1-01 (Doctrine Primer)</a></li>
					<li><a href="http://armypubs.army.mil/doctrine/DR_pubs/dr_a/pdf/adp3_0.pdf">ADP 3-0 (Operations)</a></li>
					<li><a href="http://armypubs.army.mil/doctrine/DR_pubs/dr_a/pdf/adp5_0.pdf">ADP 5-0 (The Operations Process)</a></li>
				</ul>
			</li>
			<li>
				<div>ADRP</div>
				<ul>
					<li><a href="http://armypubs.army.mil/doctrine/DR_pubs/dr_a/pdf/adrp1.pdf">ADRP-1 (The Army Profession)</a></li>
					<li><a href="http://armypubs.army.mil/doctrine/DR_pubs/dr_a/pdf/adp2_0.pdf">Intelligence</a></li>
					<li><a href="http://armypubs.army.mil/doctrine/DR_pubs/dr_a/pdf/adrp6_22.pdf">ADRP 6-22 (Army Leadership)</a></li>
				</ul>
			</li>
			<li>
				<div>AR</div>
				<ul>
					<li><a href="http://armypubs.army.mil/epubs/pdf/r25_50.pdf">AR 25-50 (Preparing and Managing Correspondence)</a></li>
				</ul>
			</li>
			<li>
				<div>ATP</div>
				<ul>
					<li><a href="http://armypubs.army.mil/doctrine/DR_pubs/dr_a/pdf/atp6_22x1.pdf">ATP 6-22.1 (The Counseling Process)</a></li>
				</ul>
			</li>
			<li>
				<div>FM</div>
				<ul>
					<li><a href="http://downloads.army.mil/fm3-0/FM3-0.pdf">Operations</a></li>
					<li><a href="http://armypubs.army.mil/doctrine/DR_pubs/DR_a/pdf/fm3_21x8.pdf">FM 3-21.8 (Infantry Rifle PLT and SQD)</a></li>
					<li><a href="https://fas.org/irp/doddir/army/fm5-0.pdf">FM 5-0 (The Operations Process)</a></li>
					<li><a href="http://armypubs.army.mil/doctrine/DR_pubs/dr_a/pdf/fm6_22.pdf">FM 6-22 (Leader Development)</a></li>
				</ul>
			</li>
			<li>
				<div>TC</div>
				<ul>
					<li><a href="http://www.acq.osd.mil/dpap/ccap/cc/jcchb/Files/Topical/After_Action_Report/resources/tc25-20.pdf">TC 25-20 (A Leaders Guide to After-Action Reviews)</a></li>
				</ul>
			</li>
			<li>
				<div>Other</div>
				<ul>
					<li><a href="https://fas.org/irp/doddir/army/ranger.pdf">Ranger Handbook</a></li>
				</ul>
			</li>
		</ul>
		<div>PPT files</div>
		<ul>
		<?php echo $rslt; ?>
		</ul>
		<div>Band Of Brothers</div>
		<ul id = "bandofbrothers">
			
		</ul>
		<div>Killer Angels Audio Book</div>
		<ul>
			<li>
				<a href="https://onedrive.live.com/redir?resid=41AEAD5CD301B558!4387&authkey=!AFBmYS0JDa8vMpY&ithint=file,mp3">Part 1</a>
			</li>
			<li>
				<a href="https://onedrive.live.com/redir?resid=41AEAD5CD301B558!4389&authkey=!AHEZqO_i__DENoo&ithint=file,mp3">Part 2</a>
			</li>
			<li>
				<a href="https://onedrive.live.com/redir?resid=41AEAD5CD301B558!4388&authkey=!ANGeo0c-4GMiyvg&ithint=file,mp3">Part 3</a>
			</li>
			<li>
				<a href="https://onedrive.live.com/redir?resid=41AEAD5CD301B558!4394&authkey=!AN88XPIIPACdjfQ&ithint=file,mp3">Part 4</a>
			</li>
			<li>
				<a href="https://onedrive.live.com/redir?resid=41AEAD5CD301B558!4393&authkey=!ALD12v9KradL6ww&ithint=file,mp3">Part 5</a>
			</li>
			<li>
				<a href="https://onedrive.live.com/redir?resid=41AEAD5CD301B558!4392&authkey=!AJqq9p3NdJbRmjk&ithint=file,mp3">Part 6</a>
			</li>
			<li>
				<a href="https://onedrive.live.com/redir?resid=41AEAD5CD301B558!4391&authkey=!ANXfmTgbL3-7WO4&ithint=file,mp3">Part 7</a>
			</li>
			<li>
				<a href="https://onedrive.live.com/redir?resid=41AEAD5CD301B558!4390&authkey=!AAxEyLwR357ij_o&ithint=file,mp3">Part 8</a>
			</li>
			<li>
				<a href="https://onedrive.live.com/redir?resid=41AEAD5CD301B558!4395&authkey=!ACITkH3VNjlQJBU&ithint=file,mp3">Part 9</a>
			</li>
			<li>
				<a href="https://onedrive.live.com/redir?resid=41AEAD5CD301B558!4396&authkey=!ALCCc-CJHXZDugs&ithint=file,mp3">Part 10</a>
			</li>
			<li>
				<a href="https://onedrive.live.com/redir?resid=41AEAD5CD301B558!4397&authkey=!AJWjOtya_t4Yjdg&ithint=file,mp3">Part 11</a>
			</li>
		</ul>
		<div>Homework Files to Read</div>
		<ul>
			<?php echo $filesToRead; ?>
		</ul>
		<div>OCS Root Folder</div>
		<ul class="no-bullet">
			<li><iframe src="https://drive.google.com/embeddedfolderview?id=0B3gN5-3YYPjHU2JoQXhzc1NLV1U#list" width="100%" height="500" frameborder="0"></iframe></li>
		</ul>
		<div>OPORD Shells</div>
		<ul class="no-bullet">
			<li><iframe src="https://drive.google.com/embeddedfolderview?id=0B3gN5-3YYPjHVENndnQzQnRNY2M#list" width="100%" height="500" frameborder="0"></iframe></li>
		</ul>
		<div>OPERATIONS</div>
		<ul><?php echo $opFiles; ?></ul>
		<div>Admin Files</div>
		<ul>
			<li><a href="IDTDates.pdf">IDT Dates</a></li>
			<li><a href="ScantronExample.pdf">Scantron</a></li>
			<li><a href="AdditionalStudyandCurriculum.pdf">Additional Study Material</a></li>
			<li><a href="CPTDerr_SFCHendrickAssignments.pdf">CPT Derr / SFC Hendrick Homework</a></li>
		</ul>
	</div>
</body>
</html>
