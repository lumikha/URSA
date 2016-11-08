<style type="text/css">
    


    .shade
  {
    content:' ';
    position:;
    left:0;
    right:17px;
    height:0.75em;
    top:6.3em;
    background:linear-gradient(to bottom,
    rgba(0,0,0,0),
    rgba(0,0,0,0.15) 50%);
    z-index:10;
}

    .shade2
  {
    content:' ';
    position:;
    left:0;
    right:17px;
    height:0.75em;
    top:6.3em;
    background:linear-gradient(to top,
    rgba(0,0,0,0),
    rgba(0,0,0,0.15) 50%);
    z-index:10;
}


</style>




<h2 style="font-weight: bold; margin-left: 10px;">Business Accounts</h2>    
<div id="accountsArea" style="width: 100%; height: 100%; margin-top: 0px; backgroun-color: black;overflow:hidden;">
    <table id="datatable_accounts" class="table" style="width: 100% !important;  margin-bottom: 5em;">
        <div class="mc_loading">
            <div class="bg"></div>
            <img src="img/loader1.gif">
        </div>

        <div class="shade" style="margin-bottom: -3.5em;"></div>

        <thead>
            <tr class="hidden">
                <td></td>
            </tr>
        </thead>
        <tbody>
        <?php   
            $arrAccounts = array();
            $cnt = 0;
            foreach ($result_db_customers['Items'] as $i) {
                $cust = $marshaler->unmarshalItem($i); 
                array_push($arrAccounts, $cust);
                $arrAccounts[$cust['customer_id']] = $arrAccounts[$cnt];
                unset($arrAccounts[$cnt]);
                $cnt++;
            }

            krsort($arrAccounts);
            foreach($arrAccounts as $acs) {
                if(isset($acs['chargify_id']) || isset($acs['stripe_id'])) {
                    if(isset($acs['chargify_id'])) {
                        $payportalID = "chargify_id";
                    } 
                    if(isset($acs['stripe_id'])) {
                        $payportalID = "stripe_id";
                    }
                    ?><tr style="margin-left: 10px;"><td class="oneAcc" onclick="oneAccount('<?=$acs["customer_id"]?>')"><?php
                        echo '<span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span> &nbsp;&nbsp;&nbsp;<strong style="font-size: 20px; color: #31708f;">'.$acs['business_name'].'</strong><br>
                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;'.$acs['customer_first_name'].' '.$acs['customer_last_name'].'&nbsp;&nbsp;&nbsp; 
                            <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp; '.$acs['business_email'].'';
                        echo '</td></tr>';
                } else {
                    ?><tr style="margin-left: 10px;"><td class="oneAcc" onclick="oneAccount('<?=$acs["customer_id"]?>')"><?php
                        echo '<span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span> &nbsp;&nbsp;&nbsp;<strong style="font-size: 20px; color: #31708f;">'.$acs['business_name'].'</strong>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-info-sign" style="color: #aa2727"></span>&nbsp;<i style="color: #7c7777">Incomplete data</i>
                            <br>
                            
                            <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp; '.$acs['business_email'].'';
                        echo '</td></tr>';
                }
            } 
            ?>

        </tbody>
    </table>
    <div class="shade" style="margin-top: -4em;"></div>
</div>

