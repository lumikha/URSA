<?php
	require 'header.php';
	require 'php/summary_functions.php';
?>

<link rel="stylesheet" type="text/css" href="css/summary_style.css"/>

<div class="container_12 hidden" id="accounts_display">
	<div class="grid_11 push_1 alpha accform">
	<?php include "forms/accounts_form.php"; ?>
	</div>
</div>

<div class="container_12 hidden" id="support_display">
	<?php include "forms/support_form.php"; ?>
</div>

<div class="modal fade" id="viewTicket" tabindex="-1" role="dialog">
	<div id="modal_dialog" class="modal-dialog modal-md" >
		<div class="modal-content">
			<span>
			</span>
			<div class="modal-body">
				<input type="type" id="cID" hidden>
				<div class="row">
					<div class="col-md-4">
						<label>Ticket Entry No.</label>
						<input type="text" class="form-control tNO" id="tNo" value="" style="text-align: center; font-weight: bold;" readonly>
					</div>
					<div class="col-md-3 col-md-offset-3">
						<label>Status:</label><br>
						<span type="text" id="tSTAT" class="tSTAT" name="status" value="" style="text-align: center; font-weight: bold; color: green;" readonly> &nbsp &nbspACTIVE <br></span>
					</div>
					<div class="col-md-5">
						<label style="display: none;">Ticket ID</label>
						<input type="text" class="form-control" id="tID" value="" style="text-align: center; font-weight: bold; display: none;" readonly>
					</div>
					<div class="col-md-3 text-right resize">
						<a id="expand" href="#"><span id="glyph_resize" class="btn btn-info btn-sm glyphicon glyphicon-fullscreen " aria-hidden="true"></span></a>
						<a id="close_modal" href="#"><span id="glyph_close" class="btn btn-danger btn-sm glyphicon glyphicon-remove " aria-hidden="true"></span></a>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<label>Subject:</label>
						<input type="text" class="form-control" id="tSubj" readonly>
					</div>
				</div>
				<div class="row">
					<div class="col-md-8">
						<label>From:</label>
						<input type="text" class="form-control" id="fromName"  readonly>
					</div>
					<div class="col-md-4">
						<label>Date:</label>
						<input type="text" class="form-control" id=""   readonly>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<label>Message</label>
						<div id="tBody" class="form-control" readonly style="overflow:auto;height:300px; background-color: #fff;">
							<span id="tMsg" style="height: auto;" readonly></span> 
							<span id="tMsgAtt"></span>
						</div>
					</div>
				</div>
				<div class="row">
					<center>
						<a href="#" class="btn btn-danger open-modal-updTicket">Update Ticket</a>
						<button class="btn btn-danger" onclick="gotoCustomerPage()">Go to Customer Page</button>
					</center>
				</div>
				<div class="row">
					<label class="col-md-12">Thread(s)</label>
					<div id="lbl_th" class="col-md-12"></div>
					<div id="magic_buttons" class="col-md-12"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="updateTicket" tabindex="-1" role="dialog">
	<div id="modal_cont" class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<form method="POST">
					<input type="type" id="cID_new_thread" name="cTID" hidden>
					<input type="type" id="curr_status" name="curr_status" hidden>
					<input type="type" id="status" name="status" hidden>
					<div class="row">
						<div class=" col-md-12  email_opt_top">
							<a id="note_tab" href="#" class="btn btn-primary btn-md active" onclick="return add_note();">
								<span class="glyphicon glyphicon-comment"></span> Add Note
							</a>
							<a id="reply_tab" href="#" class="btn btn-primary btn-md" onclick="return send_reply();">
								<span class="glyphicon glyphicon-pencil"></span> Reply
							</a>
							<a id="assign" href="#" class="btn btn-primary btn-md">
								<span class="glyphicon glyphicon-user"></span> Assign
							</a>
							<a id="status_tab" href="#" class="btn btn-primary btn-md">
								<span class="glyphicon glyphicon-flag"></span> Status
							</a>
							<a id="tag" href="#" class="btn btn-primary btn-md">
								<span class="glyphicon glyphicon-tags"></span> Tag
							</a>
							<a id="tag" href="#" class="btn btn-primary btn-md" style="display: none;">
								<span class="glyphicon glyphicon-trash"></span> Delete
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-md-9" style="position:relative">
							<label>Message</label>
							
							<!--<form class="form-inline " >
							  <div class="form-group has-success has-feedback" >
							    <div class="input-group pull-right" style="position:absolute;top:-30px;width:300px;height:30px">
							    	<input type="text" class="form-control" placeholder="Name" >
							      <span class="input-group-addon">Add</span>
							    </div>
							  </div>
							</form>
							<input style="position:absolute;top:-30px;width:300px;height:30px" class="form-control pull-right" type="text" placeholder="Name">-->
              <textarea class="form-control input-sm" id="commit_msg" name="message" style="height: 300px;"></textarea>
              
						</div>
						<div class="col-md-3">
							<label>Previous Conversations 
								<span class="glyphicon glyphicon-menu-up" title="hide content" id="hide" title="Hide Content"></span>
								&nbsp;
								<span class="glyphicon glyphicon-menu-down" title="show content" id="show" title="Show Content"></span>
							</label>
							<section class="form-control" id="prev_conv" name="prev_conv" style="height: 300px; background-color: rgba(0, 0, 0, 0.1);">
								<div class="prev_convo">
									<button type="button" class="btn btn-default btn-sm prevconvbutton" style="width: 100%; text-align: left !important;" >
										<span class="glyphicon glyphicon-envelope"></span> &nbsp; Sample Conversation #1
									</button>
									<button type="button" class="btn btn-default btn-sm prevconvbutton" style="width: 100%; text-align: left !important;" >
										<span class="glyphicon glyphicon-envelope"></span> &nbsp; Sample Conversation #2
									</button>
								</div>
							</section>
						</div>
					</div>
					<?php
						
?>
						
					<?php
					//error_reporting(E_ALL);
					//var_dump($_SERVER);
					$post_data = @$_POST['data'];
					if (!empty($post_data)) {
					    $dir = 'php/savedReplies/';
					    $file = $_REQUEST['reply_name'];
					    $filename = $dir.$file.'.txt';
					    $handle = fopen($filename, "w");
					    fwrite($handle, $post_data);
					    fclose($handle);
					}

					?>
					<div class="row">
						<center>
							<input id="new_thread" type="Submit" class="btn btn-danger" name="new_thread" value="Add Note">
							<input id="send_reply" type="Submit" class="btn btn-danger hidden" name="send_reply" value="Send Reply">	
							
				      		<div id="response" hidden></div>
						</center>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal_add_reply" tabindex="-1" role="dialog" style="margin-left: -5em;">
	<div id="modal_cont" class="modal-dialog modal-sm">
		<div class="modal-content">
		<div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">Add Reply</h4>
      	</div>                   
		<div class="modal-body">
			<h1 id="add_reply_loading" class="hidden">Loading ...</h1>
			<form class="form-inline">
			  <div id="reply_group" class="form-group has-success has-feedback pullright">
			    <div id="add_reply" class="input-group" >
			    	<input type="text" id="reply_name" name="reply_name" class="form-control" placeholder="Name" required style="height:30px;">
			      	<span class="input-group-addon btn btn-success" onclick="saveReply();return false;">Add</span>
			    </div>
			  </div>
			</form>
		</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal_replies" tabindex="-1" role="dialog" style="margin-left: -5em;">
	<div id="modal_cont" class="modal-dialog modal-sm">
		<div class="modal-content">
		<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Saved Replies</h4>
      </div>                   
			<div class="modal-body">
				<?php
							DEFINE ('PAGES', 'php/savedReplies/'); //Define the directory path
						$directory = new DirectoryIterator(PAGES); //Get all the contents in the directory 
						$rep_num = 1;
						//echo "<select class='form-control' onChange='changeText(this.value)' name='replies'>";
						foreach ($directory as $files) { //Check that the contents of the directory are each files  and then do what you want with them after you have the name of the file. 
						    if ($files->isFile()) {
						        $file_name = $files->getFilename();
						        $my_page = file_get_contents(PAGES. $file_name); //Collect the content of the file.
						        //echo '<option selected="true" disabled="disabled">Saved Replies</option>';
						        //echo '<option value="'.$my_page.'">'.str_replace(".txt", "",$file_name).'</option>';
						        //echo '<option value="">Clear</option>';
						        //echo $file_name;
						       // echo $my_page; // Do what you want with the contents of the file.
						        echo "<input type='text' id='repName$rep_num' name='repName$rep_num' value='$file_name' hidden>";
						        echo "<textarea id='repContent$rep_num' name='repContent$rep_num' hidden>$my_page</textarea>";
						        $rep_num++;
						    } else {
						        //Insert nothing into the $my_privacy_policy variable.
						    }
						}
								
						echo "<input type='text' id='repNum' name='repNum' value='$rep_num' hidden>";

								echo "<form class='form-inline'>
										<div class='form-group has-feedback pullright'>
										<div class='input-group' style='width:110%'>";
								echo "<select class='form-control' onChange='changeText(this.value)' id='select_reply' name='replies'>";
							    echo '<option id="country" selected="true" disabled="disabled" style="display: none;">Saved Replies</option>';
								foreach ($directory as $value) {
									if ($value->isFile()) {
										$file_n = $value->getFilename();
									    $my_p = file_get_contents(PAGES. $file_n); //Collect the content of the file.
									    echo '<option value="'.$my_p.'">'.str_replace(".txt", "",$file_n).'</option>';
									}
								}
							    echo '<option value="">Clear</option>';
								echo "</select>";
								?>
								<span class='input-group-addon btn btn-danger' onclick='removeReply();'>Remove</span>
								<?php
								echo "</div></div></form>";
							?>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="previewAtt" tabindex="-1" role="dialog" style="margin-left: -5em;">
	<div id="modal_cont" class="modal-dialog">
		<div class="modal-content" style="position: absolute; margin-left: auto; margin-right: auto; width: 0; height: 0; border: none; padding: none;">                   
			<div class="modal-body"></div>
			<div id="attid"></div>
			<span id="attfn" style="text-align:center !important; margin-top: 0em !important; background-color: transparent; font-size: 15px; color: #fff;" ></span>
		</div>
	</div>
</div>
<div class="full-width-div"> 
	<div class="container_12 boxsummary hidden" style="left: 150px;" id="tickets_display"> 
		<div class="container_12" style="margin-top:0em;">
			<div id="boxesSum" class="row text-center">
				<div class="grid_2 push_1 alpha ticketbutton" style="padding: 1em;margin-right:1em;margin-bottom:1em;border:solid #A60800 2px;color:#A60800"><a href="#" onclick="return addTicket();"><strong>Ticket</strong></a></div>
				<div class="grid_2 push_1 omega twiliobutton" style="padding: 1em;margin-right:1em;margin-bottom:1em;border:solid #340570 2px;color:#340570"><a href="#" onclick="return showTwilio();"><strong>Twilio</strong></a></div>
			</div>
		</div>
	
	<div class="container_12">
		<div id="sumArea" class="grid_5 push_1 alpha" style="overflow-y: scroll; overflow-x: hidden; height: 550px; ">
		<?php 
		foreach($arr_msgs as $a_m) { 
			$mID = $a_m['ticket_id'];
			$tNo = $a_m['no'];
			$sts = $a_m['status'];
			$sbj = $a_m['subject'];
			$frm = $a_m['from'];
			$bdy = htmlentities($a_m['body']);

			if($a_m['notes']) {
				$th_arr_fin = "";
				$th_arr = array();
				foreach($a_m['notes'] as $nl) {
					array_push($th_arr, "<i><b>".$nl['n_created_by']['S']."</b></i> added note||+||<span style='float: right;'>".$nl['n_created_at']['S']."</span>||+||<p>".$nl['n_content']['S']."</p>~^^^~");
				}

				$thArrCnt = 0;
				while(!empty($th_arr[$thArrCnt])) {
					$th_arr_fin .= $th_arr[$thArrCnt];
					$thArrCnt++;
				}
			} else {
				$th_arr_fin = "";
			}

			$ats_title = "";
			$ats = "";
			if($a_m['attachments']) {
				$ats_title = "<br/><b>Attachments</b><br/><br/>";
			}
			foreach($a_m['attachments'] as $am_ats) {
				$ats .= htmlentities($am_ats);
			}
			$em_cnt=0;
			while(!empty($em_check[$em_cnt])) {
				if($a_m['email'] == $em_check[$em_cnt]['email']) {
					$cID = $em_check[$em_cnt]['id'];
					$bn = $em_check[$em_cnt]['bname'];
					$fn = $em_check[$em_cnt]['fname'];
					$ln = $em_check[$em_cnt]['lname'];
					$bp = $em_check[$em_cnt]['bphone'];
					$payportalID = $em_check[$em_cnt]['payportalid'];
		?>
					<div class="container_12">
						<div class="grid_5 ticketsummary">
							<div class="grid_1 alpha round-div">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
							<div class="grid_2 omega ticketlist">
								<a href="#" class="open-modal" data-cid="<?=$cID?>" data-id="<?=$mID?>" data-name="<?=$frm?>" data-no="<?=$tNo?>" data-status="<?=$sts?>" data-subject="<?=$sbj?>" data-mes="<?=$bdy?>" data-atturl="<?=$ats_title.$ats?>" data-threadmsg="<?=$th_arr_fin?>">
								<strong><?php echo $bn; ?></strong></a> <br>
								<?php
									echo $fn." ".$ln."<br>".
										$bp."<br>".
										$payportalID;
								?>
							</div>
						</div>
					</div><br/>
		<?php 
				}
				$em_cnt++;
			}
		} 
        ?>
		</div>
	</div>
</div>
<?php
    require "footer.php";
?>
<script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="scripts/summary_scripts.js"></script>
<script>
	$(document).ready(function() {
		summaryPageOnload();
	});
</script>