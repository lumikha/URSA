<?php
    require 'header.php';
    require 'customer_functions.php';
?>
    <style>
        .form-errors {
            color: #e60000;
            font-size: 30px;
            margin-top: -40px;
            margin-bottom: -5px;
        }
        .error {
            border:1px solid #ff4d4d;
            box-shadow: 0 0 5px #ff4d4d;
        }
        .rem-bor{
        border: none;
        overflow: auto;
        outline: none;

        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        box-shadow: none;
        margin-top: -10px;
        position: relative;
        top: 7px;
        }
    </style>"
        <div class="full-width-div">
        <div class="container_12">
        
      <div class="grid_12 push_2 omega" style="margin-top:-1.5em;">
    <div id="boxes" class="text-center" style="display:none;">
        <div class="cust_id grid_2" style="padding: 1em;margin-right:3em;margin-left:0em;margin-bottom:1em;border:solid black 2px;"><strong><?php echo $billing_sum; ?></strong></div>
        <div class="grid_2" style="padding: 1em;margin-right:2em;margin-bottom:1em;border:solid black 2px;"><strong><?php echo "TalkDesk"; ?></strong></div>
        <div class="grid_2" style="padding: 1em;margin-right:3em;margin-bottom:1em;border:solid black 2px;height:52px;overflow:hidden;"><div id="email_box" style="width: 100%;height: 300%;overflow:auto;"><strong><?php echo $email; ?></strong></div></div>
        <div class="grid_2" style="padding: 1em;margin-right:3em;margin-bottom:1em;border:solid #A60800 2px;color:#A60800"><strong>Ticket</strong></div>
        <div class="grid_2" style="padding: 1em;margin-right:1em;margin-bottom:1em;border:solid #340570 2px;color:#340570"><strong>Disposition</strong></div>
        
    </div>
    <div class="container_12" style="padding: 1em;">
         <div class="grid_9 alpha"   style="margin-top:0.5em;">
    <div class="tab-content">

    <div class="tab-content">
        <?php 
            //Customer's AccountProv Info
            include "forms/cust_account_form.php";
            //Customer's Prov Info
            include "forms/cust_prov_form.php";
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
    </div></div>
        
<?php
    require "footer.php";
?>

<?php 
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
?>
                                    
                    <div class="grid_2 omega ticket-pane" style="font-size:83%;color:gray;margin-right:0px; margin-left:3em; margin-top:0.5em;height:450px; overflow:auto;">
                    <?php
                    
                    if(isset($_GET['id'])) {
                        $touch_cnt = 0;
                        foreach (array_reverse($all_logs) as $object) {
                            $log_customer_id = $object['customer_id']['S'];
                            if($log_customer_id == $_GET['id'])
                            {
                                $touch_cnt++;
                            }
                        }
                        foreach (array_reverse($all_logs) as $object) {
                            //$log_id = $object->value->id;
                            $log_user_id = $object['user_id']['S'];
                            $log_customer_id = $object['customer_id']['S'];
                            $log_event = $object['event']['S'];
                            $log_data = $object['data']['S'];
                            $log_date = $object['date']['S'];
                            if($log_customer_id == $_GET['id'])
                            {
                                echo "<p><b>#</b>".$touch_cnt." - <b>".$log_event."</b> ".$log_data." - ".$log_date."</p>";
                                $touch_cnt--;
                            }
                        }
                    }
                    
                    ?>
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