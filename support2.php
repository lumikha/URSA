<?php
    require 'header.php';
    require_once 'liveServer.php';

    ?>


<style type="text/css">
	
	#boxes
	{
	
		margin-top: -5.25em;

	}

	.ticketsummary2
	{
		 background-color: rgba(0, 0, 0, 0.2);
		 height: 500px;
		 width: 92% !important;
		 margin-left: 0.5em;
		 top: 1.25em;
	}

	.boxsupport
	{
		margin-left: 6.25em !important;
	}
</style>



<div class="full-width-div">

    <div class="container_12">

     <div class="grid_12 push_1 boxsupport">

       <div id="boxes" class="row text-center">

           <div class="grid_2" style="padding: 1em;margin-right:2.75em;margin-left: 1.5em; margin-bottom:1em;border:solid #340570 2px;color:#340570"><strong>Unassigned</strong><i class="glyphicon glyphicon-envelope"></i></div>

            <div class="grid_2" style="padding: 1em;margin-right:2.75em; margin-bottom:1em;border:solid #340570 2px;color:#340570"><strong>Mine</strong><i class="glyphicon glyphicon-inbox"></i></div>

            <div class="grid_2" style="padding: 1em;margin-right:2.75em; margin-bottom:1em;border:solid #340570 2px;color:#340570"><strong>Assigned</strong><i class="glyphicon glyphicon-user"></i></div>

            <div class="grid_2" style="padding: 1em;margin-right:2.75em; margin-bottom:1em;border:solid #340570 2px;color:#340570"><strong>Closed</strong><i class="glyphicon glyphicon-trash"></i></div>

            <div class="grid_2" style="padding: 1em;margin-right:2.78em; margin-bottom:1em;border:solid #340570 2px;color:#340570"><strong>Spam</strong><i class="glyphicon glyphicon-ban-circle"></i></div>

       </div>

      </div>

    </div>

<!--for the tickets-->

    <div class="container_12">

    	<div class="grid_12 push_2 alpha ticketsummary2">

    		


    	</div>


    </div>




</div>

