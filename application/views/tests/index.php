<script src="js/jquery-asPieProgress.min.js" type="text/javascript"></script>
<script src="/js/tests.js" type="text/javascript"></script>

<div class="ort">

	<div class="tstust">

		<div class="stats">
			<div class="pie_progress" role="progressbar" data-barcolor="#b11f24" data-trackcolor="#626262" data-barsize="25" >
				<div class="pie_progress__number">0%</div>
			</div>
		</div>
		<div class="altyz">
				You’ve completed <strong><?php echo $progress->taken; ?></strong> of your <strong><?php echo $progress->mandatory; ?></strong> mandatory classes!
				
				<br />

				<?php if ($progress->remaining): ?>

					You have <strong><?php echo $progress->remaining; ?></strong> more to take. You’d better start signing up!

				<?php endif; ?>
		</div>

	</div>

	<div class="tsts">
		<a href="javascript:;" onclick="tstblm(1);" class="slovl scl" id="blmlnk1" >ALL TESTS (2)</a>
		<a href="javascript:;" onclick="tstblm(2);" class="nrml" id="blmlnk2" >ONLINE TESTS (0)</a>
		<a href="javascript:;" onclick="tstblm(3);" class="sgovl nrml" id="blmlnk3" >OFFLINE TESTS (2)</a>
	</div>

	<div class="nrml_tstler">
		<div class="tstler" id="tstler1">
			<table cellpadding="0" cellspacing="0" width="100%" border="0" >
				<tr class="ilktd">
					<td class="yta">YOUR TESTS</td>
					<td class="ytb">MANDATORY?</td>
					<td class="ytb">SCORE</td>
					<td class="ytb">TYPE</td>
					<td class="ytb">STATUS</td>
					<td class="ytb">ACTION</td>
				</tr>

				<?php  //foreach ($tests as $test): ?>

<?php
/*

Spaced out for legibility

$bb_data = "select * from tests where status='1' order by id desc";
$bb_sorgu = mysql_query($bb_data);

while ($bb = mysql_fetch_assoc($bb_sorgu)) {

	$mandatory="";
	$link="";
	if ($bb['mandatory']=="1") {
		$mandatory="Yes";
	} else {
		$mandatory="No";
	}

	$scoret="";

	$answerinfo = mysql_fetch_array(mysql_query("SELECT score FROM test_answers WHERE user_id='".$uyene['id']."' and test_id='".$bb['id']."' and status='1' "));

	$scoret = $answerinfo['score'];

	if ($answerinfo['score']!="") {
		$text2="FINISHED";
		$text1="See Details";
	} else {
		$text2="<span>WAITING</span>";
		$text1="Start";
	}

	if ($bb['test_type']=="Online") {
		if ($answerinfo['score']!="") {
			$link="href='test_detay.php?id=".$bb['id']."'";
		} else {
			$link="href='test.php?id=".$bb['id']."'";
		}
	} else {
		$link="href='javascript:;' onclick='rndval(".$bb['id'].");'";
		$text1="Sign Up";
		$offlinebak=mysql_fetch_array(mysql_query("SELECT status,score FROM test_offline WHERE user_id='".$uyene['id']."' and test_id='".$bb['id']."' "));
		if ($offlinebak['status']=="0") {
			$text2 = "<span>SIGNED UP</span>";
			$link = "href='javascript:;'";
			$text1 = "Appointment";
		} elseif ($offlinebak['status']=="1") {
			$text2 = "FINISHED";
			$link = "href='javascript:;'";
			$text1 = "See Details";
		} else {
			$link = "href='javascript:;' onclick='rndval(".$bb['id'].");'";
		}

		$scoret=$offlinebak['score'];
	}

	$classne="";

	if ($text1=="See Details") {
		$classne="class='sd'";
	} else {
		$classne="class='nrml'";
	}

}
*/
?>

<?php if(count($all_tests) > 0){ ?>
	<?php foreach($all_tests as $all_data){ ?>
			<tr>
				<td class="itd"><?php echo $all_data->title; ?></td>
				<td><?php if($all_data->mandatory){ echo "Yes";}else{echo "No";} ?></td>
				<td>0</td>
				<td><?php echo $all_data->test_type; ?></td>
				<td><?php echo $all_data->status; ?></td>
				<td class="std"><a href="#" class="nrml">Start Test</a></td>
			</tr>
	<?php } ?>
<?php } ?>


					<!-- <tr>
						<td class="itd">
							Interacting with Customers
						</td>
						<td>
							Yes
						</td>
						<td>
							
						</td>
						<td>
							Offline
						</td>
						<td>
							<span>
								SIGNED UP
							</span>
						</td>
						<td class="std" >
							<a href='javascript:;' class='nrml' >
								Appointment
							</a>
						</td>
					</tr> -->

				<?php //endforeach; ?>

			</table>
		</div>

		<div class="tstler" id="tstler2">
			<table cellpadding="0" cellspacing="0" width="100%" border="0" >
				<tr class="ilktd">
					<td class="yta">YOUR TESTS</td>
					<td class="ytb">MANDATORY?</td>
					<td class="ytb">SCORE</td>
					<td class="ytb">TYPE</td>
					<td class="ytb">STATUS</td>
					<td class="ytb">ACTION</td>
				</tr>
			</table>
		</div>

		<div class="tstler" id="tstler3">
			<table cellpadding="0" cellspacing="0" width="100%" border="0" >
				<tr class="ilktd">
					<td class="yta">YOUR TESTS</td>
					<td class="ytb">MANDATORY?</td>
					<td class="ytb">SCORE</td>
					<td class="ytb">TYPE</td>
					<td class="ytb">STATUS</td>
					<td class="ytb">ACTION</td>
				</tr>
				<tr>
					<td class="itd" >Interacting with Customers</td>
					<td>Yes</td>
					<td></td>
					<td>Offline</td>
					<td><span>SIGNED UP</span></td>
					<td class="std" ><a href='javascript:;' class='nrml' >Appointment</a></td>
				</tr>
				<tr>
					<td class="itd" >Troubleshooting ; Ground Faults, Opens and Shorts</td>
					<td>Yes</td>
					<td></td>
					<td>Offline</td>
					<td><span>SIGNED UP</span></td>
					<td class="std" ><a href='javascript:;' class='nrml' >Appointment</a></td>
				</tr>
			</table>
		</div>
	</div>

	<div class="mobil_tstler">
		<div class="mtstler" id="mtstler1">
			<div class="mtst_bslk">
				<div class="fl sl">TEST</div>
				<div class="fl sg">STATUS</div>
				<div class="t"></div>
			</div>
			<div class="mtst_byztk" onclick="takpt('gri_1_7');" >
				<div class="sl">Interacting with Customers</div>
				<div class="sg">
					<span>SIGNED UP</span>
				</div>
			</div>
			<div class="mtst_gritk" id="gri_1_7">
				<div class="b1">
					SCORE<br /><span>-</span>
				</div>
				<div class="b2">
					MANDATORY?<br /><span>Yes</span>
				</div>
				<div class="b3">
					TYPE?<br /><span>Offline</span>
				</div>
				<div class="b4">
					<a href='javascript:;' class='nrml' >Appointment</a>
				</div>
			</div>
			<div class="mtst_byztk" onclick="takpt('gri_1_3');" >
				<div class="sl">Troubleshooting ; Ground Faults, Opens and Shorts</div>
				<div class="sg">
					<span>SIGNED UP</span>
				</div>
			</div>
			<div class="mtst_gritk" id="gri_1_3"><div class="b1">SCORE<br /><span>-</span></div><div class="b2">MANDATORY?<br /><span>Yes</span></div><div class="b3">TYPE?<br /><span>Offline</span></div><div class="b4"><a href='javascript:;' class='nrml' >Appointment</a></div></div>
		</div>

		<div class="mtstler" id="mtstler2">
		<div class="mtst_bslk"><div class="fl sl">TEST</div><div class="fl sg">STATUS</div><div class="t"></div></div>
		</div>

		<div class="mtstler" id="mtstler3">
		<div class="mtst_bslk"><div class="fl sl">TEST</div><div class="fl sg">STATUS</div><div class="t"></div></div>
		<div class="mtst_byztk" onclick="takpt('gri_3_7');" ><div class="sl">Interacting with Customers</div><div class="sg"><span>SIGNED UP</span></div></div>
		<div class="mtst_gritk" id="gri_3_7"><div class="b1">SCORE<br /><span>-</span></div><div class="b2">MANDATORY?<br /><span>Yes</span></div><div class="b3">TYPE?<br /><span>Offline</span></div><div class="b4"><a href='javascript:;' class='nrml' >Appointment</a></div></div>
		<div class="mtst_byztk" onclick="takpt('gri_3_3');" ><div class="sl">Troubleshooting ; Ground Faults, Opens and Shorts</div><div class="sg"><span>SIGNED UP</span></div></div>
		<div class="mtst_gritk" id="gri_3_3"><div class="b1">SCORE<br /><span>-</span></div><div class="b2">MANDATORY?<br /><span>Yes</span></div><div class="b3">TYPE?<br /><span>Offline</span></div><div class="b4"><a href='javascript:;' class='nrml' >Appointment</a></div></div>
		</div>

	</div>

</div>
