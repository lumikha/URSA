<div class="full-width-div">
  <div class="container_12">
    <div class="grid_12 push_1 boxsupport">
      <div id="boxesSup" class="row text-center">
        <a href="#unassigned" onclick="openFolder(1, <?=$unassigned?>, '#datatable_unassigned')">
          <div class="grid_2" style="padding: 1em;margin-right:2.75em; margin-bottom:1em;border:solid #340570 2px;color:#340570">
            <i class="glyphicon glyphicon-envelope"></i> &nbsp<strong>Unassigned</strong>
          </div>
        </a>
        <a href="#mine" onclick="openFolder(2, <?=$mine?>, '#datatable_mine')">
          <div class="grid_2" style="padding: 1em;margin-right:2.75em; margin-bottom:1em;border:solid #340570 2px;color:#340570">
            <i class="glyphicon glyphicon-inbox"></i>&nbsp<strong>Mine</strong>
          </div>
        </a>
        <a href="#assigned"  onclick="openFolder(3, <?=$assigned?>, '#datatable_assigned')">
          <div class="grid_2" style="padding: 1em;margin-right:2.75em; margin-bottom:1em;border:solid #340570 2px;color:#340570">
            <i class="glyphicon glyphicon-user"></i>&nbsp<strong>Assigned</strong>
          </div>
        </a>
        <a href="#closed">
          <div onclick="openFolder(4, <?=$closed?>, '#datatable_closed')" class="grid_2" style="padding: 1em;margin-right:2.75em; margin-bottom:1em;border:solid #340570 2px;color:#340570">
            <i class="glyphicon glyphicon-trash"></i>&nbsp<strong>Closed</strong>
          </div>
        </a>
        <a href="#spam">
          <div onclick="openFolder(5, <?=$spam?>, '#datatable_spam')" class="grid_2" style="padding: 1em;margin-right:2.78em; margin-bottom:1em;border:solid #340570 2px;color:#340570">
           <i class="glyphicon glyphicon-ban-circle"></i>&nbsp <strong>Spam</strong>
          </div>
        </a>
      </div>
    </div>
  </div>

<!--for the tickets-->

    <div class="container_12">

    	<div class="grid_1 push_2 alpha ticketsummary2">
        <?php 
        function divChckBxs() {
            ?>
                <ul class="btngrpChckBxs">
                    <li class='btnAssignTo' onclick="checkedboxes()"><i class="glyphicon glyphicon-user"></i></li>
                    <li class='btnStatus' onclick="checkedboxes()"><i class="glyphicon glyphicon-flag"></i></li>
                    <li class='btnTag' onclick="checkedboxes()"><i class="glyphicon glyphicon-tag"></i></li>
                    <span class="ttAssignTo">Assign</span>
                    <span class="ttStatus">Status</span>
                    <span class="ttTag">Tag</span>
                </ul>
            <?php
        }
    ?>

    	 <div id="list_unassigned" class="folder_list_hide">
          <?php divChckBxs(); ?>             
          <table id="datatable_unassigned" class="table">
            <thead>
              <tr>
                <th><input type="checkbox" class="chckbx_all"></th>
                <th title="Sort">Customer</th>
                <th>Conversation</th>
                <th title="Sort">Number</th>
                <th title="Sort">Last Update</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($arr_unassigned as $aUN) { ?>
              <tr>
                <td><input type="checkbox" id="chckbxid<?=$aUN['no']?>" class="chckbx"></td>
                <td onclick="getTicketData('<?=$aUN["ticket_id"]?>')"><?=$aUN['from']?></td>
                <td onclick="getTicketData('<?=$aUN["ticket_id"]?>')">
                                            <div class="table_email_content">
                                                <b><?=$aUN['subject']?></b><br/>
                                                <?=str_replace("<br>",'',$aUN['body'])?>
                                            </div>
                                        </td>
                                        <td onclick="getTicketData('<?=$aUN["ticket_id"]?>')"><?=$aUN['no']?></td>
                                        <td onclick="getTicketData('<?=$aUN["ticket_id"]?>')"><?=$aUN['updated']?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div id="list_mine" class="folder_list_hide">
                            <?php divChckBxs(); ?>
                            <table id="datatable_mine" class="table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" class="chckbx_all"></th>
                                        <th title="Sort">Customer</th>
                                        <th>Conversation</th>
                                        <th title="Sort">Number</th>
                                        <th title="Sort">Last Update</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($arr_mine as $aM) { ?>
                                    <tr>
                                        <td><input type="checkbox" id="chckbxid<?=$aM['no']?>" class="chckbx"></td>
                                        <td onclick="getTicketData('<?=$aM["ticket_id"]?>')"><?=$aM['from']?></td>
                                        <td onclick="getTicketData('<?=$aM["ticket_id"]?>')">
                                            <div class="table_email_content">
                                                <b><?=$aM['subject']?></b><br/>
                                                <?=str_replace("<br>",'',$aM['body'])?>
                                            </div>
                                        </td>
                                        <td onclick="getTicketData('<?=$aM["ticket_id"]?>')"><?=$aM['no']?></td>
                                        <td onclick="getTicketData('<?=$aM["ticket_id"]?>')"><?=$aM['updated']?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div id="list_assigned" class="folder_list_hide">
                            <?php divChckBxs(); ?>
                            <table id="datatable_assigned" class="table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" class="chckbx_all"></th>
                                        <th title="Sort">Customer</th>
                                        <th>Conversation</th>
                                        <th title="Sort">Assigned To</th>
                                        <th title="Sort">Number</th>
                                        <th title="Sort">Last Update</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($arr_assigned as $aAS) { ?>
                                    <tr>
                                        <td><input type="checkbox" id="chckbxid<?=$aAS['no']?>" class="chckbx"></td>
                                        <td onclick="getTicketData('<?=$aAS["ticket_id"]?>')"><?=$aAS['from']?></td>
                                        <td onclick="getTicketData('<?=$aAS["ticket_id"]?>')">
                                            <div class="table_email_content">
                                                <b><?=$aAS['subject']?></b><br/>
                                                <?=str_replace("<br>",'',$aAS['body'])?>
                                            </div>
                                        </td>
                                        <td onclick="getTicketData('<?=$aAS["ticket_id"]?>')"><?=$aAS['assigned']?></td>
                                        <td onclick="getTicketData('<?=$aAS["ticket_id"]?>')"><?=$aAS['no']?></td>
                                        <td onclick="getTicketData('<?=$aAS["ticket_id"]?>')"><?=$aAS['updated']?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div id="list_closed" class="folder_list_hide">
                            <?php divChckBxs(); ?>
                            <table id="datatable_closed" class="table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" class="chckbx_all"></th>
                                        <th title="Sort">Customer</th>
                                        <th>Conversation</th>
                                        <th title="Sort">Number</th>
                                        <th title="Sort">Last Update</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($arr_closed as $aC) { ?>
                                    <tr>
                                        <td><input type="checkbox" id="chckbxid<?=$aC['no']?>" class="chckbx"></td>
                                        <td onclick="getTicketData('<?=$aC["ticket_id"]?>')"><?=$aC['from']?></td>
                                        <td onclick="getTicketData('<?=$aC["ticket_id"]?>')">
                                            <div class="table_email_content">
                                                <b><?=$aC['subject']?></b><br/>
                                                <?=str_replace("<br>",'',$aC['body'])?>
                                            </div>
                                        </td>
                                        <td onclick="getTicketData('<?=$aC["ticket_id"]?>')"><?=$aC['no']?></td>
                                        <td onclick="getTicketData('<?=$aC["ticket_id"]?>')"><?=$aC['updated']?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div id="list_spam" class="folder_list_hide">
                            <?php divChckBxs(); ?>
                            <table id="datatable_spam" class="table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" class="chckbx_all"></th>
                                        <th title="Sort">Customer</th>
                                        <th>Conversation</th>
                                        <th title="Sort">Number</th>
                                        <th title="Sort">Last Update</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($arr_spam as $aS) { ?>
                                    <tr>
                                        <td><input type="checkbox" id="chckbxid<?=$aS['no']?>" class="chckbx"></td>
                                        <td onclick="getTicketData('<?=$aS["ticket_id"]?>')"><?=$aS['from']?></td>
                                        <td onclick="getTicketData('<?=$aS["ticket_id"]?>')">
                                            <div class="table_email_content">
                                                <b><?=$aS['subject']?></b><br/>
                                                <?=str_replace("<br>",'',$aS['body'])?>
                                            </div>
                                        </td>
                                        <td onclick="getTicketData('<?=$aS["ticket_id"]?>')"><?=$aS['no']?></td>
                                        <td onclick="getTicketData('<?=$aS["ticket_id"]?>')"><?=$aS['updated']?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>


    	</div>


    </div>




</div>
    