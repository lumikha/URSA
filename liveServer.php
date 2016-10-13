<?php
	$live_server = false;
    if($live_server) {
        $att_path = "attachments/";
        $tbname = 'ursa-tickets';
        $tbid = 'ticket_id';
    } else {
        $att_path = "http://biglo.co/attachments/";
        $tbname = 'ursa-tickets';
        $tbid = 'ticket_id';
    }
?>