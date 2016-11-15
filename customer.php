<?php
    require 'header.php';
    require 'php/customer_functions.php';
?>

<link rel="stylesheet" type="text/css" href="css/customer_style.css"/>

    <!--TWILIO CALL MODAL -->
    <div class="modal fade" id="callTwilio" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Call <?php echo $fname." ".$lname."?"; ?></h4>
                </div>
                <div class="cs_loading text-center hidden">
                    <img src="img/phone_calling.gif" style="height:200px">
                </div> 
                <div class="modal-body" id="call_body">
                    <form method="POST">
                        <p><h1>Make a call to <strong class="text-info"><?php echo $phone."</strong> ?" ?></h1></p>
                        <p>
                            <div class="checkbox hidden">
                                <label><input type="checkbox" value="yes">Record the call</label>
                            </div>
                        </p>
                </div>
                <div class="modal-footer">
                    <input type="submit" id="cancel" class="btn btn-default" onClick="cancelCall();" data-dismiss="modal" value="No">
                    <input type="submit" id="yes" class="btn btn-primary" name="call" value="Yes" onclick="callNtext();">
                </div>
                    </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<!--
    <div class="modal fade" id="callTwilio" tabindex="-1" role="dialog">
        <div id="modal_cont" class="modal-dialog">
            <div class="modal-content text-center" style="padding:2em">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Modal title</h4>
                  </div>
                <div class="cs_loading hidden">
                    <img src="img/loader1.gif">
                </div>       
                <div class="modal-body">
                    <form method='POST'>
                        
                    </form>
                   
                </div>
                    

        
            </div>
        </div>
    </div>
-->
    <!-- END MODAL -->
    <div class="full-width-div">
        <div class="container_12 boxcustomer">
            <div class="grid_12 push_2 omega " style="margin-top:0em;">
                <div id="boxes" class="text-center" style="display:none;">
                    <div class="cust_id grid_2" style="padding: 1em;margin-right:3em;margin-left:0em;margin-bottom:1em;border: solid #052F6D 2px;">
                        <strong><?php echo $billing_sum; ?></strong>
                    </div>
                    <div class="grid_2" style="padding: 1em;margin-right:2em;margin-bottom:1em;border: solid #052F6D 2px;">
                        <strong>
                            <a href="#" onclick="return callTwilio();" style="color: #337ab7 !important;"><?php echo "Twilio"; ?></a>
                        </strong>
                    </div>
                    <div class="grid_2" style="padding: 1em;margin-right:3em;margin-bottom:1em;border: solid #052F6D 2px; height:49px;overflow:hidden;">
                        <div id="email_box" style="width: 100%;height: 300%;overflow:auto; color: #052F6D !important;">
                            <strong><?php echo $email; ?></strong>
                        </div>
                    </div>
                    <div class="grid_2" style="padding: 1em;margin-right:3em;margin-bottom:1em;border: solid #052F6D 2px; color: #C63C33 !important">
                        <strong>Ticket</strong>
                    </div>
                    <div class="grid_2" style="padding: 1em;margin-right:1em;margin-bottom:1em;border: solid #052F6D 2px; color: #052F6D !important">
                        <strong>Disposition</strong>
                    </div>
                </div>

        
                
                    <div class="grid_9 alpha"   style="margin-top:0.5em; margin-right:3em; margin-left: 1em;">
                        <div class="tab-content">
                        <?php 
                            //Customer's AccountProv Info
                            include "forms/cust_account_form.php";
                            //Customer's Prov Info
                            //include "forms/cust_prov_form.php";
                            include "forms/cust_prov_form_test_hide.php";
                            //Customer's Support Info
                            include "forms/cust_support_form.php";
                            //Customer's Customer Info
                            include "forms/cust_customer_form.php";
                            //Customer's Quality Info
                            include "forms/cust_quality_form.php";
                            //Customer's Dashboard Info
                            include "forms/cust_dashboard_form.php";
                            //Customer's Center Info
                            include "forms/cust_center_form.php";
                            //Customer's Admin Info
                            include "forms/cust_admin_form.php";
                        ?>

                        <!--alert box below tab content-->
                            <!--
                            <div class="alert alert-danger fade in">
                                <span class="closebtn"  onclick="this.parentElement.style.display='none';">&times;</span> 
                                    This is an alert box. Sample only. <strong>Oh snap! You got an error!</strong> 
                                <div class="row"> 
                                    <div class="col-md-3 col-sm-5 col-xs-6">
                                        <button type="button" class="btn btn-default btn-sm" style="width: 100%; background-color: #C63C33; color: white;">
                                            Take this action
                                        </button>
                                    </div>
                                    <div class="col-md-2 col-sm-4 col-xs-5">
                                        <button type="button" class="btn btn-default btn-sm" style="width: 100%;">
                                            or this
                                        </button>
                                    </div>
                                </div>
                            </div>
                            -->
                        <!--end of alert box-->
                        </div>

        
<?php
    require "footer.php";
?>

<?php 
/*
    if(isset($_GET['id'])) {
        $char_state = $result_customer_id_search[0]->state;
        $char_state_exp = explode('_', $char_state);
        $count=0;
        $fin_char_state = "";
        while(!empty($char_state_exp[$count])) {
            $fin_char_state .= ucfirst($char_state_exp[$count])."&nbsp;";
            $count++;
        }
        echo "<input type='text' id='char_state' value='".$fin_char_state."' hidden>";

        ?><script>
            document.getElementById("cust_id").title = document.getElementById("char_state").value;
            document.getElementById("bill_stat").innerHTML = document.getElementById("char_state").value;
        </script><?php
    }
*/
?>
                                      
                            <div class="grid_2 omega ticket-pane" style="font-size:83%;color:gray;margin-right:0px; margin-left:0em; margin-top:0.5em;height:450px; overflow:auto;">
                            <?php
                                if(isset($_GET['id'])) {
                                    $touch_cnt = 0;
                                    $logs_this_cust = array();
                                    foreach ($all_logs as $object) {
                                        $log_customer_id = $object['customer_id']['S'];
                                        if($log_customer_id == $_GET['id'])
                                        {
                                            array_push($logs_this_cust, array(
                                                "log_user_id" => $object['user_id']['S'],
                                                "log_customer_id" => $object['customer_id']['S'],
                                                "log_event" => $object['event']['S'],
                                                "log_data" => $object['data']['S'],
                                                "log_date" => $object['date']['S'],
                                            ));
                                            $logs_this_cust[$object['date']['S']] = $logs_this_cust[$touch_cnt];
                                            unset($logs_this_cust[$touch_cnt]);
                                            $touch_cnt++;
                                        }
                                    }

                                    krsort($logs_this_cust);
                                    foreach ($logs_this_cust as $log) {
                                        $log_user_id = $log['log_user_id'];
                                        $log_customer_id = $log['log_customer_id'];
                                        $log_event = $log['log_event'];
                                        $log_data = $log['log_data'];
                                        $log_date = $log['log_date'];
                                        echo "<p><b>#</b>".$touch_cnt." - <b>".$log_event."</b> ".$log_data." - ".$log_date."</p>";
                                        $touch_cnt--;
                                    }
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                    <!--box below forms-->
                     <div class="row"> 
                         <div class="col lg-12 alert" hidden>
                         </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="scripts/customer_scripts.js"></script>
<script>
    $(document).ready(function() {
        customerPageOnload();
    });
</script>
                     