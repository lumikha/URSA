<?php
include "../dynamoDB/dbCredentials.php";
session_start();
  if(@$_GET['logout']){
    session_destroy();
    header("Location: leads_login.php");
    exit();
  }
  if(@$_SESSION['logged'] == false){
    header("Location: leads_login.php");
    exit();
  }

	ini_set('max_execution_time', 0); //300 seconds = 5 minutes
	//include 'zip:///../URSA_att/1576f441017691df/attachments/LUMI_URSA_Spec-Wednesday2.zip#LUMI_URSA_Spec-Wednesday2.zip.php';
	require 'lib/vendor/autoload.php';
	use Aws\S3\S3Client;
	use Aws\DynamoDb\Exception\DynamoDbException;
	use Aws\DynamoDb\Marshaler;

	$sharedConfig = [
	    'region'  => 'us-west-2',
	    'version' => 'latest',
	    'credentials' => [
	        'key'    => $key,
	        'secret' => $token,
	    ],
	    'http'    => [
	        'verify' => false
	    ]
	];

	$sdk = new Aws\Sdk($sharedConfig);
	$dynamodb = $sdk->createDynamoDb();
	$marshaler = new Marshaler();

	if(@$_POST['refresh']){
		$check = "<?php \$done=0;\$last_purged=0; ?>";
		file_put_contents('logs/check.php', $check);
	}

?>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="js/dataTables/dataTables.bootstrap.min.css">
</head>
<style type="text/css">
	#import_link, #export_link, #mp_link, #logout{
		text-decoration: none;
	}
	#import_link:hover, #export_link:hover, #export_link:hover, #logout:hover{
		cursor: pointer;
	}
	.hidden{
		display: none !important;
	}
</style>
<body>
	<div class="row" style="border-bottom:solid maroon 3px">
		<div class="col-md-12" style="background-color:dimgray">
			<br>
			<br>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3 text-center">
			<h3 class="text-info">
				<a id="import_link" onClick="import_file();"><span class="glyphicon glyphicon-import" aria-hidden="true"></span><strong>Import</strong></a>
			</h3>
			<h3 class="text-info">
				<a id="export_link" ><span class="glyphicon glyphicon-export" aria-hidden="true"></span><strong>Export</strong></a>
			</h3>
		<!--
			<h3 class="text-info">
				<a id="mp_link"><span class="glyphicon glyphicon-import" aria-hidden="true"></span><strong>Manual Purge</strong></a>
			</h3>
		-->
			<h3 class="text-info">
				<a id="logout" href="?logout=1"><span class="glyphicon glyphicon-off" aria-hidden="true"></span><strong>Logout</strong></a>
			</h3>
		</div>
		<div class="col-md-8" style="">
			<br>
			<div class="row">
				<form method="POST" name="select_file" enctype="multipart/form-data">
					<input id="import_file" name="import_file" onChange="change();" type="file" class="hidden"> 
					<input type="submit" id="purge_btn" name="purge_btn" class="btn btn-danger" value="Purge Now" disabled="true" osnClick="return confirm('Note: Purging may take 3-5 minutes. Are you sure you want to Proceed?');">
					<input type="submit" id="add_btn" name="add_btn" class="btn btn-primary" value="Add to List" disabled="true" onClick="return confirm('Note: Purging may take 3-5 minutes. Are you sure you want to Proceed?');">
					<input type="submit" id="refresh" name="refresh" class="btn btn-default pull-right" value="Reset">
					<strong><span id="file_name"></span></strong>
				</form>
			</div>
			<div class="row well">
				<div id="logs" style="overflow-y: scroll; overflow-x: hidden; height: 400px; ">
					<?php
						$done = 0;
						$txt = "";
						/*
						$check = "<?php \$done=0;\$last_purged=0; ?>";
						file_put_contents('logs/check.php', $check);
						*/
						//$aa = file_get_contents("logs/arr_csv.txt");


						if(isset($_POST['purge_btn'])){
							$image_tmp = $_FILES['import_file']['tmp_name'];
							$file_name = $_FILES['import_file']['name'];
							$match = 0;
							if(isset($image_tmp)){
								try{
									if(strpos($file_name, '.csv') !== false){	
										$move = move_uploaded_file($image_tmp, "imports/".$file_name);
										if($move){

										}else{
											echo "not moved";
										}
										$feed = "imports/".$file_name;
										$keys = array();
										$newArray = array();

										function csvToArray($file, $delimiter) {
										  if (($handle = fopen($file, 'r')) !== FALSE) {
										    $i = 0; 
										    while (($lineArray = fgetcsv($handle, 4000, $delimiter, '"')) !== FALSE) {
										      for ($j = 0; $j < count($lineArray); $j++) { 
										        $arr[$i][$j] = $lineArray[$j]; 
										      }
										      $i++; 
										    } 
										    fclose($handle); 
										  }
										  return $arr; 
										}

										$data = csvToArray($feed, ',');
										$count = count($data) - 1;
										$labels = array_shift($data);  

										foreach ($labels as $label) {
										  $keys[] = $label;
										}

										for ($j = 0; $j < $count; $j++) {
										  $d = array_combine($keys, $data[$j]);
										  $newArray[$j] = $d;
										}
										file_put_contents('logs/arr_csv.txt', json_encode($newArray));
										

										$key = array_keys($newArray);
										$last_row = end($key);
										//echo $last_row."<br>";

										while (ob_get_level() > 0)
										    ob_end_flush();
										$match = 0;
										for($i=0;$i<=$last_row;$i++){		
											if(isset($newArray[$i]['PHONE_NUMBER'])){
												//$aa = file_get_contents("logs/check.txt");
										?>
											<script type="text/javascript">
													var objDiv = document.getElementById("logs");
													objDiv.scrollTop = objDiv.scrollHeight;
											</script>
										<?php			  
										  $cnt = $i + 2;
										  $string = $newArray[$i]['PHONE_NUMBER'];
										  if(empty($string) || $string==" " || $string==""){
										  	$string="emptyfield";
										  }else{
										  	$sc = array("-","(",")");
										  	$string = str_replace($sc, "", $string);
										  }
										  
										  if($i==12){
										  	$string ="";
										  }

										  $key = $marshaler->marshalJson('
										    {
										        "phone_number": "'.$string.'"
										    }
										');

										$eav = $marshaler->marshalJson('
										    {
										        ":val": "'.$string.'" 
										    }
										');

										$params = [
										    'TableName' => "",
										    'Key' => $key,
										    'ConditionExpression' => 'phone_number = :val',
										    'ExpressionAttributeValues'=> $eav
										];
										
										      try {
										          	//$result = $dynamodb->deleteItem($params);
										            echo $string." DELETED($cnt) <br>";
										            $match += 1;
										            flush();
										            $check = 0;
										            /*
													$check = "<?php \$last_purged=".$i."; ?>";
													file_put_contents('logs/check.php', $check);
													$path = dirname(__FILE__).'/logs/check.php';
													$fp = fopen($path, 'a');
													fwrite($fp, $check);
													fclose($fp);
													*/

										      } catch (DynamoDbException $e) {
										          echo "Unable to delete ".$string."($cnt) <br>";
										      }
										      	}else{
										      		$i = $last_row +1;
										      		echo "<strong>Warning: </strong>PHONE_NUMBER column not found.";
										      	}							  
										}
										$done = 1;
										if($done==1){
											$check = "<?php \$last_purged=0; ?>";
											file_put_contents('logs/check.php', $check);
										}
										echo "<strong>".$match." Matched</strong><br>";
									}else{
										echo "not a csv bruh";
									}
								}catch(Exception $e){
									echo "<strong>Error:</strong>".$e->getMessage();
									//$myfile = file_put_contents('logs/logs.txt', $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
									//echo "<strong>Warning:</strong>Unable to import file. Close the file and try again";
									$last_num = $i + 1;
									$check = "<?php \$last_purged=".$last_num."; ?>";
									file_put_contents('logs/check.php', $check);
								}
							}else{
								echo "not set";
							}
						}

						if(isset($_POST['continue_btn'])){
							?>
							<script type="text/javascript">
								alert("continue..");
							</script>
							<?php
						}
					?>
				</div>
			</div>
		<div class="row">
			<?php
			require_once('logs/check.php');
			if($last_purged!=0){
			?>
				<form method="POST">
					<input type="submit" id="continue_btn" name="continue_btn" class="btn btn-danger" value="Last purge is at row <?php echo $last_purged; ?>, Click to continue Purging.">
				</form>
				<?php
			}
				/*
					if(isset($_POST['continue_btn'])){
						echo $done;
					}
					*/
				?>
		</div>
		</div>
	</div>
</body>
</html>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="js/dataTables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script src="js/dataTables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="js/angular.min.js"></script>
<script type="text/javascript">
	function change(){
		var file_name = $('#import_file').val().replace(/\\/g, '/').replace(/.*\//, '');
		document.getElementById('file_name').innerHTML = file_name;
		if(file_name.indexOf('.csv') >= 0){
			document.getElementById("purge_btn").disabled = false;
		}else{
			document.getElementById("purge_btn").disabled = true;
		}
	}
	function import_file(){
		$('#import_file').click();
	}


</script>