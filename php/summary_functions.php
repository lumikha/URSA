<?php
require_once 'settings.php';
require 'gmail_get_messages.php';
$result_db_customers = $obj_gateway_customer->fetchAll("SELECT * FROM customer");
$tbname = 'ursa-tickets';
$tbid = 'ticket_id';

$arr_unassigned = array();
$arr_mine = array();
$arr_assigned = array();
$arr_closed = array();
$arr_spam = array();
$unassigned = 0;
$mine = 0;
$assigned = 0;
$closed = 0;
$spam = 0;

$cnt_tckts = 0;
foreach ($ticket_check as $obj2) {
	if($obj2->ticket_gmail_id && $obj2->ticket_status != "closed"){
		$bdy_image = decodeBody(@$obj2->ticket_email_body);
		$arr_emb = explode(',', $obj2->ticket_embedded_image);

		preg_match_all('/src="cid:(.*)"/Uims', $bdy_image, $matches);
		if(count($matches)) {
			$cnt_emb = 0;
			foreach($matches[1] as $match) {
				$search = "src=\"cid:$match\"";
				$replace = "src=".$att_path.$obj2->ticket_gmail_id."/".$arr_emb[$cnt_emb];
				$bdy_image = str_replace($search, $replace, $bdy_image);  
				$cnt_emb++;       
			}
		}
		$arr_att = array();
		$att_file = $obj2->ticket_email_attachment;
		$arr = explode(',', $att_file);
                         
		if(preg_match('/.php/',$att_file)) {
			foreach ($arr as $key) {
				@$attmts = file_get_contents($att_path.$obj2->ticket_gmail_id.'/attachments/'.$key);
				array_push($arr_att, $attmts);
			}
		}
                
		if($obj2->ticket_notes == "(null)") {
			$noteLists = null;
		} else {
			$arr_notes = array();
			$nExp = explode(',', $obj2->ticket_notes);
			foreach($nExp as $tn) {
				$data_tNote = $obj_gateway_note->fetchById($tn);
				try {
					array_push($arr_notes, array(
						"n_id" => $data_tNote->getKeyId(),
						"n_created_at" => $data_tNote->note_created_at,
						"n_created_by" => $data_tNote->note_created_by,
						"n_content" => $data_tNote->note_content
					));
				} catch (Exception $e) {
					echo $e->getMessage() . "\n";
				}
			}
			$noteLists = $arr_notes;
		}

		if($live_server) {
			$locpath = "../URSA_att";
			$replace_livepath = "attachments";
			$arr_att = str_replace($locpath, $replace_livepath, $arr_att);
		}

		if($obj2->ticket_status == 'unassigned') {
			array_push($arr_unassigned, array(
				"ticket_id" => $obj2->getKeyId(),
				"no" => $obj2->ticket_number,
				"id" => $obj2->ticket_gmail_id,
				"status" => $obj2->ticket_status,
				"subject" => $obj2->ticket_email_subject,
				"body" => $bdy_image,
				"from" => $obj2->ticket_name_from,
				"email" => $obj2->ticket_email_from,
				"attachments" => $arr_att,
				"updated" => $obj2->ticket_updated_at,
				"notes" => $noteLists
			));
			$unassigned++;
		}

		if($obj2->ticket_status == 'mine') {
			array_push($arr_mine, array(
				"ticket_id" => $obj2->getKeyId(),
				"no" => $obj2->ticket_number,
				"id" => $obj2->ticket_gmail_id,
				"status" => $obj2->ticket_status,
				"subject" => $obj2->ticket_email_subject,
				"body" => $bdy_image,
				"from" => $obj2->ticket_name_from,
				"email" => $obj2->ticket_email_from,
				"attachments" => $arr_att,
				"updated" => $obj2->ticket_updated_at,
				"notes" => $noteLists
			));
			$mine++;
		}

		if($obj2->ticket_status == 'assigned') {
			array_push($arr_assigned, array(
				"ticket_id" => $obj2->getKeyId(),
				"no" => $obj2->ticket_number,
				"id" => $obj2->ticket_gmail_id,
				"status" => $obj2->ticket_status,
				"subject" => $obj2->ticket_email_subject,
				"body" => $bdy_image,
				"from" => $obj2->ticket_name_from,
				"email" => $obj2->ticket_email_from,
				"attachments" => $arr_att,
				"updated" => $obj2->ticket_updated_at,
				"assigned" => $obj2->ticket_assigned_to,
				"notes" => $noteLists
			));
			$assigned++;
		}

		if($obj2->ticket_status == 'closed') {
			array_push($arr_closed, array(
				"ticket_id" => $obj2->getKeyId(),
				"no" => $obj2->ticket_number,
				"id" => $obj2->ticket_gmail_id,
				"status" => $obj2->ticket_status,
				"subject" => $obj2->ticket_email_subject,
				"body" => $bdy_image,
				"from" => $obj2->ticket_name_from,
				"email" => $obj2->ticket_email_from,
				"attachments" => $arr_att,
				"updated" => $obj2->ticket_updated_at,
				"notes" => $noteLists
			));
			$closed++;
		}

		if($obj2->ticket_status == 'spam') {
			array_push($arr_spam, array(
				"ticket_id" => $obj2->getKeyId(),
				"no" => $obj2->ticket_number,
				"id" => $obj2->ticket_gmail_id,
				"status" => $obj2->ticket_status,
				"subject" => $obj2->ticket_email_subject,
				"body" => $bdy_image,
				"from" => $obj2->ticket_name_from,
				"email" => $obj2->ticket_email_from,
				"attachments" => $arr_att,
				"updated" => $obj2->ticket_updated_at,
				"notes" => $noteLists
			));
		$spam++;
		}
	}
	$cnt_tckts++;
}

$em_check = array();
foreach ($result_db_customers as $obj) {
	if(isset($obj->chargify_id)) {
		$paymentPotarlID = $obj->chargify_id;
	} 
	if(isset($obj->stripe_id)) {
		$paymentPotarlID = $obj->stripe_id;
	}

	if(isset($obj->customer_email)){
		array_push($em_check, array(
			"id" => $obj->getKeyId(),
            "email" => $obj->customer_email,
            "payportalid" => $paymentPotarlID,
			"bname" => $obj->business_name,
			"fname" => $obj->customer_first_name,
			"lname" => $obj->customer_last_name,
			"bphone" => $obj->business_phone_no
		));
	}
}

if(@$_POST['new_thread']){
	
        
	if($_POST['status'] != $_POST['curr_status']) {
		if(empty($_POST['message'])) {
			$n_ctnt = $_POST['message']."<b>~</b> changed status from ";
		} else {
			$n_ctnt = $_POST['message']."<br/></br><b>~</b> changed status from ";
		}
		$n_ctnt .= "<b>".strtoupper($_POST['curr_status'])."</b> to <b>".strtoupper($_POST['status'])."</b>.";
	} else {
		$n_ctnt = $_POST['message'];
	}

	$updatedDateNow = date('Y/m/d H:i:s');

	//insert new ticket note in ursa-ticket-notes
	$params_new_note = $obj_gateway_note->createEntity([
			"ticket_id"=> "".@$_POST['cTID']."",
			"note_content"=> "".$n_ctnt."",
			"note_created_at"=> "".$updatedDateNow."",
			"note_created_by"=> "".$fname."",
			"ticket_current_status"=> "".$_POST['status'].""
	]);

	//get list of existing notes for the current ticket_id

	try {
		$obj_gateway_note->upsert($params_new_note);
		$new_note_id = $params_new_note->getKeyId();
		$ticket = $obj_gateway_ticket->fetchById($_POST['cTID']);
		json_encode($ticket);
		$existing_notes = $ticket->ticket_notes;

		if($existing_notes == "(null)") {
			$upd_note_lists = $new_note_id;
		} else {
			$upd_note_lists = $existing_notes.",".$new_note_id;
		}

		$toUpdate = $obj_gateway_ticket->fetchById($_POST['cTID']);
		$toUpdate->ticket_notes="".$upd_note_lists."";
		$toUpdate->ticket_status="".$_POST['status']."";
		$toUpdate->ticket_updated_at="".$updatedDateNow."";


		$obj_gateway_ticket->upsert($toUpdate);
		?><script>
			window.location.href = "summary";
		</script><?php
	} catch (Exception $e) {
		echo $e->getMessage() . "\n";
	}
}
?>