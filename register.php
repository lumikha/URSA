<?php

  require_once 'settings.php'; 
  $stripe = false; //redeclaring this variable
  require_once 'lib/dynamoDB/dbConnect.php';
  use Aws\DynamoDb\Exception\DynamoDbException;
  use Aws\DynamoDb\Marshaler;

  date_default_timezone_set("Asia/Manila");

  $dynamodb = $sdk->createDynamoDb();
  $marshaler = new Marshaler();

  $created_doc_id = "";
  $done = 0;
  $error_message = "";

  function GUID() {
    $t = microtime(true);
    $micro = sprintf("%06d",($t - floor($t)) * 1000000);
    $d = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );

    return $d->format("YmdHisu");
  }

  if(isset($_POST['submit_business_form'])) {
    //adding - to phone number
    /*
    $num_arr = array_map('intval', str_split($_POST['biz-pnumber']));
    $fin_num = array();
    array_push($fin_num, '1-');
    $i = 0;
    while($i < 3){
      array_push($fin_num, $num_arr[$i]);
      $i++;
    }
    array_push($fin_num, '-');
    $j = 3;
    while($j < 6){
      array_push($fin_num, $num_arr[$j]);
      $j++;
    }
    array_push($fin_num, '-');
    $k = 6;
    while($k < 10){
      array_push($fin_num, $num_arr[$k]);
      $k++;
    }
    $btn_number = implode("",$fin_num);
    */
    $btn_number = "1".$_POST['biz-pnumber'];

    //adding - to alternate mobile number
    if(!empty($_POST['biz-mnumber'])) {
      /*
      $num_arr2 = array_map('intval', str_split($_POST['biz-mnumber']));
      $fin_num2 = array();
      array_push($fin_num2, '1-');
      $x = 0;
      while($x < 3){
        array_push($fin_num2, $num_arr2[$x]);
        $x++;
      }
      array_push($fin_num2, '-');
      $y = 3;
      while($y < 6){
        array_push($fin_num2, $num_arr2[$y]);
        $y++;
      }
      array_push($fin_num2, '-');
      $z = 6;
      while($z < 10){
        array_push($fin_num2, $num_arr2[$z]);
        $z++;
      }
      $btn_number2 = implode("",$fin_num2);
      */
      $btn_number2 = "1".$_POST['biz-mnumber'];
    } else {
      $btn_number2 = "null";
    }

    $cust_id = GUID();

    if($_POST['allthetime'] == false) {
      $b_hours = @$_POST['biz-hours'];
    } else {
      $b_hours = "24/7";
    }
    $count_paymet = 0;
    $paymethod = "";
    foreach($_POST["payment-method"] as $method) {
      if($count_paymet == 0) {
        $paymethod = $method;
      } else {
        $paymethod .= " $method";
      }
      $count_paymet++;
    }
    $suite_num=@$_POST['suite-number'];
    $web=@$_POST['biz-web'];
    if(empty($suite_num)){
      $suite_num = "null";
    }
    if(empty($web)){
      $web = "null";
    }

    $item = $marshaler->marshalJson('
      {
        "customer_id": "'.$cust_id.'",
        "business_name": "'.@$_POST['biz-name'].'",
        "business_address": "'.@$_POST['biz-street'].'",
        "business_suite_no": "'.$suite_num.'",
        "business_city": "'.@$_POST['biz-city'].'",
        "business_state": "'.@$_POST['biz-state'].'",
        "business_zip": "'.@$_POST['biz-zip'].'",
        "business_country": "US",
        "business_phone_no": "'.@$btn_number.'",
        "business_email": "'.@$_POST['biz-eadd'].'",
        "business_website": "'.$web.'",
        "business_alternate_phone_no": "'.$btn_number2.'",
        "business_post_address": "'.@$_POST['biz-post-address'].'",
        "business_hours": "'.$b_hours.'",
        "payment_method": "'.@$paymethod.'"
      }
    ');
    
    $params = [
      'TableName' => 'ursa-customers',
      'Item' => $item
    ];

    try {
      $result = $dynamodb->putItem($params);
    } catch (DynamoDbException $e) {
      echo "Unable to add item:\n";
      echo $e->getMessage() . "\n";
    }

    $created_doc_id = $cust_id;

    $p2_bname = $_POST['biz-name']; 
    $p2_email = $_POST['biz-eadd'];
    
    if($_POST['same-bill-info'] == "yes") {
      $p2_street = $_POST['biz-street']; 
      $p2_city = $_POST['biz-city'];
      $p2_state = $_POST['biz-state'];
      $p2_zip = $_POST['biz-zip'];
    } else {
      $p2_street = ""; 
      $p2_city = "";
      $p2_state = "";
      $p2_zip = "";
    }

    $done = 1;
  }

/***** SECOND FORM *****/
$err_msg = "";
  if(isset($_POST['submit_billing_form'])) {

    $sale_date = date("m/d/Y");

    if($stripe == true) {
      require_once 'lib/stripe/init.php';
    } else {
      require_once 'lib/chargify/Chargify.php';
    }

    $key = $marshaler->marshalJson('
    {
      "customer_id": "'.$_POST['created_doc_id'].'"
    }
    ');

    $btn_number = "1".$_POST["c-phone"];

    $num_arr = array_map('intval', str_split($_POST["c-phone"]));
    $fin_num = array();
    array_push($fin_num, '1-');
    $i = 0;
    while($i < 3){
      array_push($fin_num, $num_arr[$i]);
      $i++;
    }
    array_push($fin_num, '-');
    $j = 3;
    while($j < 6){
      array_push($fin_num, $num_arr[$j]);
      $j++;
    }
    array_push($fin_num, '-');
    $k = 6;
    while($k < 10){
      array_push($fin_num, $num_arr[$k]);
      $k++;
    }
    $btn_charNumber = implode("",$fin_num);

    if($stripe == false) {
      if($_POST["product-handle"] == 'prod_001') {
        $prodID = 3881312;
        $prodName = "Basic Plan";
      } else if($_POST["product-handle"] == 'plan_002') {
        $prodID = 3881313;
        $prodName = "Start-up Plan";
      } else if($_POST["product-handle"] == 'plan_005') {
        $prodID = 3881318;
        $prodName = "Upgrade to Start-up Plan";
      } else if($_POST["product-handle"] == 'plan_003') {
        $prodID = 3881314;
        $prodName = "Business Plan";
      } else if($_POST["product-handle"] == 'plan_006') {
        $prodID = 3881319;
        $prodName = "Upgrade to Business Plan";
      } else if($_POST["product-handle"] == 'plan_004') {
        $prodID = 3881316;
        $prodName = "Enterprise Plan";
      } else {
        $prodID = 3881320;
        $prodName = "Upgrade to Enterprise Plan";
      }  

      $test = true;

      $new_customer = new ChargifyCustomer(NULL, $test);
      $new_customer->first_name = $_POST["bfname"];
      $new_customer->last_name = $_POST["blname"];
      $new_customer->email = $_POST["c-eadd"];
      $new_customer->organization = stripslashes($_POST["bussiness-name"]);
      $new_customer->phone = $btn_charNumber;
      $saved_customer = $new_customer->create();
      
      $new_payment_profile = new ChargifyCreditCard(NULL, $test);
      $new_payment_profile->first_name = $_POST["bfname"];
      $new_payment_profile->last_name = $_POST["blname"];
      $new_payment_profile->full_number = $_POST["card-number"];
      $new_payment_profile->expiration_month = $_POST["card-expiry-month"];
      $new_payment_profile->expiration_year = $_POST["card-expiry-year"];
      $new_payment_profile->cvv = $_POST["card-cvc"];
      $new_payment_profile->billing_address = $_POST["c-street"];
      $new_payment_profile->billing_address_2 = $_POST["c-street2"];
      $new_payment_profile->billing_city = $_POST["c-city"];
      $new_payment_profile->billing_state = $_POST["c-state"];
      $new_payment_profile->billing_zip = $_POST["c-zip"];
      $new_payment_profile->billing_country = "US";
      
      $new_subscription = new ChargifySubscription(NULL, $test);
      $new_subscription->product_handle = $_POST["product-handle"];
      $new_subscription->customer_id = $saved_customer->id;
      $new_subscription->credit_card_attributes = $new_payment_profile;
      //$new_subscription->coupon_code = $_POST["coupon-code"];

      try{
        $saved_subscription = $new_subscription->create();
        
        $new_metadata = new ChargifyMetadata(NULL, $test);
        $new_metadata->name = "Sale Date";
        $new_metadata->value = $sale_date;
        $new_metadata->create($saved_subscription->id);

        $new_metadata = new ChargifyMetadata(NULL, $test);
        $new_metadata->name = "Sales Agent";
        $new_metadata->value = $_POST["sales-agent"];
        $new_metadata->create($saved_subscription->id);

        $new_metadata = new ChargifyMetadata(NULL, $test);
        $new_metadata->name = "Sales Center";
        $new_metadata->value = $_POST["sales-center"];
        $new_metadata->create($saved_subscription->id);

        if(empty($saved_subscription->credit_card->customer_vault_token)) {
          $pp_id = '":payment_processor_id": "N.A. - Bogus",';
        } else {
          $pp_id = '":payment_processor_id": "'.$saved_subscription->credit_card->customer_vault_token.'",';
        }
      } catch(Exception $error) {
        $done = 1;
        $err_msg = $error->getMessage();
      }

      $IdLabel = 'chargify_id';
      $IdValue = $saved_customer->id;
      $prod_comp_coup = '":product_id": "'.$prodID.'",
        ":product_handle": "'.$_POST["product-handle"].'",
        ":product_name": "'.$prodName.'",
        ":product_component_id": "196368",
        ":product_component_name": "Custom Company Domain",
        ":product_component_quantity": "0",
        ":product_coupon_code": "null",
        ":product_coupon_name": "null",';

      $param_pcc = "product_id=:product_id,
          product_handle=:product_handle,
          product_name=:product_name,";
    } else {
      \Stripe\Stripe::setApiKey('sk_test_T8cInYaDaLdip8ZpmtPzaq9B');

      try {
        $token = \Stripe\Token::create(array(
          "card" => array(
            "number" => $_POST["card-number"],
            "exp_month" => $_POST["card-expiry-month"],
            "exp_year" => $_POST["card-expiry-year"],
            "cvc" => $_POST["card-cvc"],
            "name" => $_POST["bfname"]." ".$_POST["blname"],
            "address_line1" => $_POST["c-street"],
            "address_line2" => $_POST["c-street2"],
            "address_city" => $_POST["c-city"],
            "address_country" => "US",
            "address_state" => $_POST["c-state"],
            "address_zip" => $_POST["c-zip"]
            )
        ));

        $newCustomer = \Stripe\Customer::create(array(
          'source'   => $token,
          "email" => $_POST["c-eadd"],
          "metadata" => array(
            "Business Name" => stripslashes($_POST["bussiness-name"]),
            "Sale Center" => $_POST['sales-center'],
            "Sale Date" => $sale_date,
            "Sale Agent" => $_POST['sales-agent']
          ),
          "plan" => "ursa_basic_plan",
          "account_balance" => 100, //in cents
          "description" => stripslashes($_POST["bussiness-name"])
        ));

        $unprotected_response_object = json_decode(json_encode($newCustomer), true);

        $IdLabel = 'stripe_id';

        foreach($unprotected_response_object as $obj=>$val) {
          if($obj == "id") {
            $IdValue = $val;
          }
          if($obj == "default_source") {
            $pp_id = '":payment_processor_id": "'.$val.'",';
          }
        }

        if($_POST["product-handle"] == 'prod_001') {
          $planID = 'ursa_basic_plan';
          $planName = "Basic Plan";
        } else if($_POST["product-handle"] == 'plan_002') {
          $planID = 'ursa_startup_plan';
          $planName = "Start-up Plan";
        } else if($_POST["product-handle"] == 'plan_005') {
          $planID = 'ursa_upgrade_to_startup_plan';
          $planName = "Upgrade to Start-up Plan";
        } else if($_POST["product-handle"] == 'plan_003') {
          $planID = 'ursa_business_plan';
          $planName = "Business Plan";
        } else if($_POST["product-handle"] == 'plan_006') {
          $planID = 'ursa_upgrade_to_business_plan';
          $planName = "Upgrade to Business Plan";
        } else if($_POST["product-handle"] == 'plan_004') {
          $planID = 'ursa_enterprise_plan';
          $planName = "Enterprise Plan";
        } else {
          $planID = 'ursa_upgrade_to_enterprise_plan';
          $planName = "Upgrade to Enterprise Plan";
        }

        $prod_comp_coup = '":plan_id": "'.$planID.'",
          ":plan_name": "'.$planName.'",
          ":product_component_id": "prod_9WCNxQgw3GjcHe",
          ":product_component_name": "Custom Company Domain",
          ":product_component_quantity": "0",
          ":product_coupon_code": "null",
          ":product_coupon_name": "null",';

        $param_pcc = "plan_id=:plan_id,
            plan_name=:plan_name,";
      } catch(\Stripe\Error\Card $e) {
        $body = $e->getJsonBody();
        $err  = $body['error'];
        $done = 1;
        $err_msg = $err['message'];
      }
    }

    if(empty($err_msg)) {
      $street2=@$_POST['c-street2'];
      if(empty($street2)){
        $street2 = "null";
      }

      $full_n = @$_POST['bfname']." ".@$_POST['blname'];
      $f = @$_POST['bfname'][0];
      $l = @$_POST['blname'][0];
      $cp = str_replace("-", "", @$btn_number);
      $keywords = $full_n." ".$f.$l." ".$f." ".$l." ".$cp;
      if(!empty($_POST['title'])) {
        $title = $_POST['title'];
      } else {
        $title = "null";
      }
        
      $eav = $marshaler->marshalJson('
        {
          ":'.$IdLabel.'": "'.@$IdValue.'",
          ":business_name": "'.@$_POST['bussiness-name'].'",
          ":customer_salutation": "'.@$_POST['salut'].'",
          ":customer_title": "'.$title.'",
          ":customer_first_name": "'.@$_POST['bfname'].'",
          ":customer_last_name": "'.@$_POST['blname'].'",
          ":customer_email": "'.@$_POST['c-eadd'].'",
          ":customer_phone_no": "'.@$btn_number.'",
          ":customer_billing_address": "'.@$_POST['c-street'].'",
          ":customer_suite_no": "'.@$street2.'",
          ":customer_billing_city": "'.@$_POST['c-city'].'",
          ":customer_billing_state": "'.@$_POST['c-state'].'",
          ":customer_billing_zip": "'.@$_POST['c-zip'].'",
          ":customer_billing_country": "'."US".'",
          ":customer_card_last_four": "'.substr($_POST['card-number'], -4).'",
          ":customer_card_cvc": "'.@$_POST['card-cvc'].'",
          ":customer_card_expire_month": "'.@$_POST['card-expiry-month'].'",
          ":customer_card_expire_year": "'.@$_POST['card-expiry-year'].'",
          '.$pp_id.'
          '.$prod_comp_coup.'
          ":sale_date": "'.date("m/d/Y").'",
          ":sale_center": "'.@$_POST['sales-center'].'",
          ":sale_agent": "'.@$_POST['sales-agent'].'",
          ":business_category": "null",
          ":prov_gmail": "null",
          ":prov_keywords": "null",
          ":prov_special_request": "null",
          ":prov_existing_social1": "null",
          ":prov_existing_social2": "null",
          ":prov_biglo_website": "null",
          ":prov_analytical_address": "null",
          ":prov_google_plus": "null",
          ":prov_google_maps": "null",
          ":prov_facebook": "null",
          ":prov_foursquare": "null",
          ":prov_twitter": "null",
          ":prov_linkedin": "null",
          ":keywords": "'.$keywords.'"
        }
      ');

      $params = [
        'TableName' => 'ursa-customers',
        'Key' => $key,
        'UpdateExpression' =>
          'set '.$IdLabel.'=:'.$IdLabel.',
            business_name=:business_name,
            customer_salutation=:customer_salutation,
            customer_title=:customer_title,
            customer_first_name=:customer_first_name,
            customer_last_name=:customer_last_name,
            customer_email=:customer_email,
            customer_phone_no=:customer_phone_no,
            customer_billing_address=:customer_billing_address,
            customer_suite_no=:customer_suite_no,
            customer_billing_city=:customer_billing_city,
            customer_billing_state=:customer_billing_state,
            customer_billing_zip=:customer_billing_zip,
            customer_billing_country=:customer_billing_country,
            customer_card_last_four=:customer_card_last_four,
            customer_card_cvc=:customer_card_cvc,
            customer_card_expire_month=:customer_card_expire_month,
            customer_card_expire_year=:customer_card_expire_year,
            payment_processor_id=:payment_processor_id,
            '.$param_pcc.'
            product_component_id=:product_component_id,
            product_component_name=:product_component_name,
            product_component_quantity=:product_component_quantity,
            product_coupon_code=:product_coupon_code,
            product_coupon_name=:product_coupon_name,
            sale_date=:sale_date,
            sale_center=:sale_center,
            sale_agent=:sale_agent,
            business_category=:business_category,
            prov_gmail=:prov_gmail,
            prov_keywords=:prov_keywords,
            prov_special_request=:prov_special_request,
            prov_existing_social1=:prov_existing_social1,
            prov_existing_social2=:prov_existing_social2,
            prov_biglo_website=:prov_biglo_website,
            prov_analytical_address=:prov_analytical_address,
            prov_google_plus=:prov_google_plus,
            prov_google_maps=:prov_google_maps,
            prov_facebook=:prov_facebook,
            prov_foursquare=:prov_foursquare,
            prov_twitter=:prov_twitter,
            prov_linkedin=:prov_linkedin,
            keywords=:keywords
            ',
        'ExpressionAttributeValues'=> $eav,
        'ReturnValues' => 'UPDATED_NEW'
      ];  

      try {
        $result = $dynamodb->updateItem($params);
        $done = 2;
      } catch (DynamoDbException $e) {
        $done = 1;
        echo "Unable to update item:\n";
        echo $e->getMessage() . "\n";
      }

      $user_pass_a = mt_rand(0 , 100000);
      $user_pass_b = mt_rand(0 , 100000);
      $user_pass_final = $user_pass_a.$user_pass_b;

      $usr_id = GUID();
      $item = $marshaler->marshalJson('
        {
          "user_id": "'.$usr_id.'",
          "customer_id": "'.@$_POST['created_doc_id'].'",
          "email": "'.@$_POST['c-eadd'].'",
          "password": "'.@$user_pass_final.'",
          "userType": "Customer",
          "status": "active"
        }
      ');

      $params2 = [
        'TableName' => 'ursa-users',
        'Item' => $item
      ];

      try {
        $result2 = $dynamodb->putItem($params2);
      } catch (DynamoDbException $e) {
        echo "Unable to add item:\n";
        echo $e->getMessage() . "\n";
      }

      $key3 = $marshaler->marshalJson('
        {
          "customer_id": "'.@$_POST['created_doc_id'].'"
        }
      ');
      $eav3 = $marshaler->marshalJson('
        {
          ":user_id": "'.$usr_id.'"
        }
      ');
      $params3 = [
        'TableName' => 'ursa-customers',
        'Key' => $key3,
        'UpdateExpression' =>
          'set user_id=:user_id ',
        'ExpressionAttributeValues'=> $eav3,
        'ReturnValues' => 'UPDATED_NEW'
      ];

      try {
        $result3 = $dynamodb->updateItem($params3);
      } catch (DynamoDbException $e) {
        echo "Unable to update item:\n";
        echo $e->getMessage() . "\n";
      }
    }
  }

  if($done == 2) {
    ?>
    <script>
      //window.location = "success_register.php?e=<?php echo $_POST['c-eadd']; ?>&p=<?php echo $user_pass_final; ?>"; //this is for local test
      window.location = "success_register1";
    </script>
    <?php
  }

?>




<html>
<head>
  <title>Payment Page</title>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
  <link rel="stylesheet" type="text/css" href="js/dataTables/dataTables.bootstrap.min.css"/>
  <link rel="stylesheet" type="text/css" href="js/field_trappings/error_msg.css"/>

    <link rel="Shortcut icon" href="img/ursa_tab_logo.png"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <link rel="stylesheet" type="text/css" href="css/jquery.tagsinput.css" />
        
    <!--960 grid stylesheet links-->
    <link href="css/960.css" rel="stylesheet"/>
    <link href="css/reset.css" rel="stylesheet"/>
    <link href="css/text.css" rel="stylesheet"/>
    <link rel="stylesheet" href="style.css"/>
       
    <!--media queries-->
    <link rel="stylesheet" type="text/css" href="css/ursa/mediaquery.css">


    <!-- FOR MEDIA QUERIES TO BE ORGANIZED

    <link rel="stylesheet" type="text/css" href="css/ursa/XS.css">

    <link rel="stylesheet" type="text/css" href="css/ursa/SM.css">

    <link rel="stylesheet" type="text/css" href="css/ursa/MD.css">

    <link rel="stylesheet" type="text/css" href="css/ursa/normal_laptops.css">

    <link rel="stylesheet" type="text/css" href="css/ursa/LG_largelaptops.css"> 

    -->
  <style>
    .error {
      font-size: 12px;
      font-style: italic; 
      display: inline;
      color: red;
    }

    #error_check_all {
      font-size: 20px;
      font-style: italic;
      font-weight: bold;
      color: red;
      text-align: center;
    }
  </style>


</head>
<body>


<!--aesthetics design for register.php-->
<style type="text/css">

html, body 
{ 
  /*background-image: url("img/little_dipper.jpg");*/
  background: #EEEEEE;

}

label,
.checkboxes,
.os

{
  color:  #052F6D;
}



.pagetitle
{
  text-align: center;
  margin-left: 0em;
  font-size: 30px;
  color: #052F6D;

}

.formtitle
{
  color: #052F6D;
  margin-left: -1.25em;
}

.regbutton
{
  background-color: #052F6D !important;
  color: #FFF;
  
}

#business_information input,#business_information
select

{
  background-color: #f9f9f9;
}

#business_information input:focus,
#business_information select:focus
{
  background-color: #FFF;
}

.thisisrequired {
  float: right;
}

.asterisk_req {
  font-size: 20px;
  color: red;
}

</style>

<?php if($done == 0 || $done != 1) { ?>

        <div class="container_12 logotitle" style="margin-top:60px; ">                          
            <div class="grid_4 push_3 logo text-center">
                <a id="home" class="disp_tickets" href="#"> 
                    <img src="img/ursablue.png" height="160" align="middle" >
                </a>
            </div> 
        </div>

            <div class="container_12 logotitle">
              
              <div class="grid_4 push_3 pagetitle">
                 Payment Page 
              </div>             
            
        </div>



<div class="container_12" style="padding: 1em;">
<div id="business_information" class="grid_10">
  <div class="grid_10" style="">
    <div class="panel-body" id="demo">
      
      <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data" onsubmit="return checkFields_enroll1();">
        <fieldset>
        <div class="formtitle"><h3>Business Information</h3> </div>
          <div class="thisisrequired">
            <b class="asterisk_req">*</b> <i>These fields are required.</i>
          </div>
          <div class="form-group">
            <div class="grid_10 alpha ">
              <label>Business Name </label><b class="asterisk_req">*</b>&nbsp;&nbsp;<span class="hido" id="hido1"><p id="error1" class="error"></p></span>
              <input type="text" class="form-control" id="biz-name" name="biz-name" onkeypress="return KeyPressBName(event)" onclick="clickField1()">
            </div>
          </div>

          <div class="form-group">
            <div class="grid_5 alpha">
              <label>Business Address 1</label><b class="asterisk_req">*</b>&nbsp;&nbsp;<span class="hido" id="hido2"><p id="error2" class="error"></p></span>
              <input type="text" class="form-control" id="biz-street" name="biz-street" onkeypress="return KeyPressBStreet(event)" onclick="clickField2()">
            </div>
            <div class="grid_5 omega" style="margin-top: 0.85em;">
              <label>Suite/Apartment No.</label>
              <input type="text" class="form-control" name="suite-number">
            </div>
          </div>

          <div class="form-group">
            <div class="grid_5 alpha">
              <label>City</label><b class="asterisk_req">*</b>&nbsp;&nbsp;<span class="hido" id="hido3"><p id="error3" class="error"></p></span>
              <input type="text" class="form-control" id="biz-city" name="biz-city" onkeypress="return KeyPressBCity(event)" onclick="clickField3()">
            </div>
            <div class="grid_2">
              <label>State</label><b class="asterisk_req">*</b>&nbsp;&nbsp;<span class="hido" id="hido4-state"><p id="error4-state" class="error"></p></span>
              <select class="form-control" id="biz-state" name="biz-state" onchange="ChangeState()">
                <option value='' disabled selected>Select</option>
                <option value="AL">AL</option> 
                <option value="AK">AK</option>
                <option value="AZ">AZ</option> 
                <option value="AR">AR</option> 
                <option value="CA">CA</option> 
                <option value="CO">CO</option> 
                <option value="CT">CT</option> 
                <option value="DE">DE</option> 
                <option value="DC">DC</option> 
                <option value="FL">FL</option> 
                <option value="GA">GA</option> 
                <option value="HI">HI</option> 
                <option value="ID">ID</option> 
                <option value="IL">IL</option> 
                <option value="IN">IN</option> 
                <option value="IA">IA</option> 
                <option value="KS">KS</option> 
                <option value="KY">KY</option> 
                <option value="LA">LA</option> 
                <option value="ME">ME</option> 
                <option value="MD">MD</option> 
                <option value="MA">MA</option> 
                <option value="MI">MI</option> 
                <option value="MN">MN</option> 
                <option value="MS">MS</option> 
                <option value="MO">MO</option> 
                <option value="MT">MT</option> 
                <option value="NE">NE</option> 
                <option value="NV">NV</option> 
                <option value="NH">NH</option> 
                <option value="NJ">NJ</option> 
                <option value="NM">NM</option> 
                <option value="NY">NY</option> 
                <option value="NC">NC</option> 
                <option value="ND">ND</option> 
                <option value="OH">OH</option> 
                <option value="OK">OK</option> 
                <option value="OR">OR</option> 
                <option value="PA">PA</option> 
                <option value="RI">RI</option> 
                <option value="SC">SC</option> 
                <option value="SD">SD</option> 
                <option value="TN">TN</option> 
                <option value="TX">TX</option> 
                <option value="UT">UT</option> 
                <option value="VT">VT</option> 
                <option value="VA">VA</option> 
                <option value="WA">WA</option> 
                <option value="WV">WV</option> 
                <option value="WI">WI</option> 
                <option value="WY">WY</option>
              </select>
            </div>
            <div class="grid_3 omega">
              <label>Zip</label><b class="asterisk_req">*</b>&nbsp;&nbsp;<span class="hido" id="hido4"><p id="error4" class="error"></p></span>
              <input type="text" class="form-control" id="biz-zip" name="biz-zip" maxlength="5" onkeypress="return KeyPressBZip(event)" onclick="clickField4()">
            </div>
          </div>

          <div class="form-group">
            <div class="grid_5 alpha">
              <label>Business Phone</label><b class="asterisk_req">*</b>&nbsp;&nbsp;<span class="hido" id="hido5"><p id="error5" class="error"></p></span>
              <input type="text" class="form-control" id="biz-pnumber" name="biz-pnumber" maxlength="10" onkeypress="return KeyPressBPNumber(event)" onclick="clickField5()">
            </div>
            <div class="grid_5 omega">
              <label>Email Address</label><b class="asterisk_req">*</b>&nbsp;&nbsp;<span class="hido" id="hido6"><p id="error6" class="error"></p></span>
              <input type="text" class="form-control" id="biz-eadd" name="biz-eadd" onkeypress="return KeyPressBEAdd(event)" onclick="clickField6()">
            </div>
          </div>

          <div class="form-group">
            <div class="grid_10 alpha">
              <label> Website</label>
              <input type="text" class="form-control" id="biz-web" name="biz-web">
            </div>
          </div>

          <div class="form-group">
            <div class="grid_5 alpha">
              <label>Hours of Operation</label><b class="asterisk_req">*</b>&nbsp;&nbsp;<span class="hido" id="hido7"><p id="error7" class="error"></p></span>
              <div class="os">
                <label> 24 / 7?</label>
                <input type="radio" id="allthetime_yes" name="allthetime" value="true"  onchange="alltime();">Yes
                <input type="radio" id="allthetime_no" name="allthetime" value="false"  onchange="notalltime();" checked>No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="number" min="0" max="24" class="form-control" style="width: 100px; display: inline;" id="spinner" name="biz-hours" onclick="clickField7()">
              </div>
              
            </div>
            <div class="grid_5 omega" style="margin-top: 0.85em;">
              <label>Alternate/Mobile Number</label>&nbsp;&nbsp;<span class="hido" id="hidomnum"><p id="errormnum" class="error"></p></span>
              <input type="text" class="form-control" id="biz-mnumber" name="biz-mnumber" maxlength="10" onkeypress="return KeyPressMNumber(event)"  onclick="clickFieldmnum()">
            </div>
          </div>

          <div class="form-group">
            <div class="grid_5 alpha">
              <label>Do You Want Your Address Posted?</label><br>
              <label class="radio-inline"><input type="radio" name="biz-post-address" value="yes" checked="checked">Yes</label>
              <label class="radio-inline"><input type="radio" name="biz-post-address" value="no">No</label>
            </div>
          </div>

          <div class="form-group">
            <div class="grid_10 alpha">
              <label>Do your Office Address the same with your Billing Address?</label>
            </div>
            <div class="grid_5 alpha">
              <label class="radio-inline"><input type="radio" name="same-bill-info" value="yes" checked="checked">Yes</label>
              <label class="radio-inline"><input type="radio" name="same-bill-info" value="no">No</label>
            </div>
          </div>

          <div class="form-group">
            <div class="grid_10 alpha">
              <label>Payment Accepted</label><b class="asterisk_req">*</b>&nbsp;&nbsp;<span class="hido" id="hido8"><p id="error8" class="error"></p></span>
              <div class="form-group">
                <div class="grid_10 alpha checkboxes">
                  <div class=" grid_10">
                    <div class="grid_2 alpha"><input type="checkbox" id="paymet_1"  name="payment-method[]" value="Cash" style="margin-left: 30px;" onchange="payment();">&nbsp;Cash </div>
                    <div class="grid_2"><input type="checkbox" id="paymet_2"  name="payment-method[]" value="Check" style="margin-left: 30px;" onchange="payment();">&nbsp;Check </div>
                    <div class="grid_2"><input type="checkbox" id="paymet_3"  name="payment-method[]" value="Visa" style="margin-left: 30px;" onchange="payment();">&nbsp;Visa </div>
                    <div class="grid_2 omega"><input type="checkbox" id="paymet_4"  name="payment-method[]" value="Paypal" style="margin-left: 30px;" onchange="payment();">&nbsp;Paypal </div>
                  </div>
                  <div class="grid_10">
                    <div class="grid_2 alpha"><input type="checkbox" id="paymet_5"  name="payment-method[]" value="Amex" style="margin-left: 30px;" onchange="payment();">&nbsp;AMEX </div>
                    <div class="grid_2"><input type="checkbox" id="paymet_6"  name="payment-method[]" value="Mastercard" style="margin-left: 30px;" onchange="payment();">&nbsp;Mastercard </div>
                    <div class="grid_2 omega"><input type="checkbox" id="paymet_7"  name="payment-method[]" value="Discover" style="margin-left: 30px;" onchange="payment();">&nbsp;Discover </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div style="text-align: center; margin-top: 25px;">
            <span class="payment-errors">
            <?php echo $error_message; ?>
              <span class="hido" id="error_check_all"><label id="error_check_all"></label></span>
            </span>
          </div>

          <div class="grid_2 push_4">
            <input type="submit" class="btn btn-primary regbutton" name="submit_business_form" value="Submit">
          </div>
         

        </fieldset>
      </form>
    </div>
  </div>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/dataTables/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="js/field_trappings/enroll_form_a.js"></script>
</div>
<?php } else { ?>

        <div class="container_12 logotitle" style="margin-top:60px; ">                          
            <div class="grid_4 push_3 logo text-center">
                <a id="home" class="disp_tickets" href="#"> 
                    <img src="img/ursablue.png" height="160" align="middle" >
                </a>
            </div> 
        </div>

            <div class="container_12 logotitle">
              
              <div class="grid_4 push_3 pagetitle">
                 Payment Page 
              </div>             
            
        </div>

<div class="container_12" style="padding: 1em;">
<div id="billing_information" class="grid_10">
    <div class="grid_10" style="">
        <div class="panel-body" id="demo">
          
         <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data" onsubmit="return checkFields_enroll2();">
          <input type="hidden" name="created_doc_id" 
          value="<?php if(empty($err_msg)){echo $created_doc_id;}else{echo $_POST['created_doc_id'];} ?>">
          <input type="hidden" name="product-handle" value="prod_001">
          <input type="hidden" name="sales-center" value="URSA_SALES_CENTER">
          <input type="hidden" id="option_1_hidden_value" 
          value="<?php if(empty($err_msg)){echo $p2_state;}else{echo $_POST['c-state'];} ?>">
          <fieldset>
            <div class="formtitle"><h3>Billing Information</h3></div> 
            <div class="thisisrequired">
              <b class="asterisk_req">*</b> <i>This fields are required.</i>
            </div>
            <div class="form-group">
              <div class="grid_10 alpha">
                <label>Business Name</label>
                <input type="text" class="form-control" id="bussiness-name" name="bussiness-name" value="<?php if(empty($err_msg)){echo $p2_bname;}else{echo $_POST['bussiness-name'];} ?>" readonly>
              </div>
            </div>

            <div class="form-group">
              <div class="grid_5 alpha">
                <label>Salutation</label><b class="asterisk_req">*</b>&nbsp;&nbsp;<span class="hido" id="hido-sal"><p id="error-sal" class="error"></p></span>
                <select name="salut" id="salut" class="form-control" onchange="ChangeSal()">
                <?php 
                  $arr_sltn = array('Mr','Mrs','Ms','Miss','Dr','Herr','Monsieur','Hr','Frau','A V M','Admiraal','Admiral','Air Cdre','Air Commodore','Air Marshal','Air Vice Marshal','Alderman','Alhaji','Ambassador','Baron','Barones','Brig','Brig Gen','Brig General','Brigadier','Brigadier General','Brother','Canon','Capt','Captain','Cardinal','Cdr','Chief','Cik','Cmdr','Col','Col Dr','Colonel','Commandant','Commander','Commissioner','Commodore','Comte','Comtessa','Congressman','Conseiller','Consul','Conte','Contessa','Corporal','Councillor','Count','Countess','Crown Prince','Crown Princess','Dame','Datin','Dato','Datuk','Datuk Seri','Deacon','Deaconess','Dean','Dhr','Dipl Ing','Doctor','Dott','Dott sa','Dr','Dr Ing','Dra','Drs','Embajador','Embajadora','En','Encik','Eng','Eur Ing','Exma Sra','Exmo Sr','F O','Father','First Lieutient','First Officer','Flt Lieut','Flying Officer','Fr','Frau','Fraulein','Fru','Gen','Generaal','General','Governor','Graaf','Gravin','Group Captain','Grp Capt','H E Dr','H H','H M','H R H','Hajah','Haji','Hajim','Her Highness','Her Majesty','Herr','High Chief','His Highness','His Holiness','His Majesty','Hon','Hr','Hra','Ing','Ir','Jonkheer','Judge','Justice','Khun Ying','Kolonel','Lady','Lcda','Lic','Lieut','Lieut Cdr','Lieut Col','Lieut Gen','Lord','M','M L','M R','Madame','Mademoiselle','Maj Gen','Major','Master','Mevrouw','Miss','Mlle','Mme','Monsieur','Monsignor','Mr','Mrs','Ms','Mstr','Nti','Pastor','President','Prince','Princess','Princesse','Prinses','Prof','Prof Dr','Prof Sir','Professor','Puan','Puan Sri','Rabbi','Rear Admiral','Rev','Rev Canon','Rev Dr','Rev Mother','Reverend','Rva','Senator','Sergeant','Sheikh','Sheikha','Sig','Sig na','Sig ra','Sir','Sister','Sqn Ldr','Sr','Sr D','Sra','Srta','Sultan','Tan Sri','Tan Sri Dato','Tengku','Teuku','Than Puying','The Hon Dr','The Hon Justice','The Hon Miss','The Hon Mr','The Hon Mrs','The Hon Ms','The Hon Sir','The Very Rev','Toh Puan','Tun','Vice Admiral','Viscount','Viscountess','Wg Cdr');

                    if(!empty($err_msg)) {
                      echo "<option value='".$_POST['salut']."'>".$_POST['salut']."</option>";
                    } else {
                      echo "<option value='' disabled selected>Select</option>";
                    } ?>
                    <?php
                      $count_sltn = 0;
                      while(!empty($arr_sltn[$count_sltn])) {
                        echo "<option value='".$arr_sltn[$count_sltn]."'>".$arr_sltn[$count_sltn]."</option>";
                        $count_sltn++;
                      } 
                    ?>
                </select>
              </div>
              <div class="grid_5 omega" style="margin-top: 0.85em;">
                <label>Title</label>
                <select name="title" id="title" class="form-control">
                <?php 
                  $arr_ttl = array('Accountant','Accountant Systems','Acquisition Management Intern','Actuarial Analyst','Actuary','Administrative Generalist/Specialist','Affordable Housing Specialist','Analyst','Appraiser','Archaeologist','Area Systems Coordinator','Asylum or Immigration Officer','Attorney/Law Clerk','Audience Analyst','Audit Resolution Follow Up','Auditor','Behavioral Scientist','Biologist, Fishery','Biologist, Marine','Biologist, Wildlife','Budget Analyst','Budget Specialist','Business Administration Officer','Chemical Engineer','Chemist','Citizen Services Specialist','Civil Engineer','Civil Penalties Specialist','Civil/Mechanical/Structural','Engineer','Communications Specialist','Community and Intergovernmental','Program Specialist','Community Planner','Community Planning\Development','Specialist','Community Services Program','Specialist','Compliance Specialist','Computer Engineer','Computer Programmer/Analyst','Computer Scientist','Computer Specialist','Consumer Safety Officer','Contract Specialist','Contract Specialist/Grants','Management Specialist','Corporate Management Analyst','Cost Account','Criminal Enforcement Analyst','Criminal Investigator','Customer Account Manager','Customer Acct Mgr\Specialist','Democracy Specialist','Desk Officer','Disaster Operations Specialist','Disbursing Specialist','Ecologist','Economist','Economist, Financial','Education Specialist','Electrical Engineer','Electronics Engineer','Emergency Management Specialist','Employee and Management','Development Specialist','Employee Development Specialist','Employee Relations Specialist','Energy and Environmental Policy','Analyst','Energy Program Specialist','Engineer (General)','Environmental Engineer','Environmental Planning and Policy','Specialist','Environmental Protection Specialist','Environmental Specialist','Epidemiologist','Equal Employment Opportunity','Specialist','Equal Opportunity Specialist','Ethics Program Specialist','Evaluation and Technical Services Generalist','Evaluator','Executive Analyst','Facilities Analyst','Federal Retirement Benefits Specialist','Field Management Assistant','Field Office Supervisor','Financial Management Specialist','Financial Legislative Specialist','Financial Specialist','Financial Systems Analyst','Financial Transactions Examination Officer','Food Safety Coordinator','Food Technologist','Foreign Affairs Officer','Foreign Affairs Specialist','Foreign Assets Control Intelligence Analyst','Foreign Assets Control Terrorist Program Analyst','Functional Area Analyst','General Engineer','Geographer','Geographical Information Systems/Computer Aided','Geophysicist','Grants Program Specialist','Grants Specialist','Hazard Mitigation Specialist','Hazardous Waste Generator Initiative Specialist','Health Communications Specialist','Health Educator','Health Insurance Specialist','Health Scientist','Health Systems Specialist','Hospital Finance Associate','Housing Program Specialist','Housing Project Manager','Human Resources Advisor\Consultant','Human Resources Consultant','Human Resources Development','Human Resources Evaluator','Human Resources Representative','Human Resources Specialist','Hydraulic Engineer','Immigration Officer','Import Policy Analyst','Industrial Hygienist','Information Management Specialist','Information Research Specialist','Information Resource Management Specialist','Information Technology Policy Analyst','Information Technology Security Assistant','Information Technology Specialist','Inspector','Instructional Systems Design Specialist','Instructions Methods Specialist','Insurance Marketing Specialist','Insurance Specialist','Intelligence Analyst','Intelligence Operations Specialist','Intelligence Research Specialist','Intelligence Specialist','Internal Program Specialist','Internal Revenue Agent','International Affairs Specialist','International Aviation Operations Specialist','International Cooperation Specialist','International Economist','International Project Manager','International Relations Specialist','International Trade Litigation Electronic Database C','International Trade Specialist','International Transportation Specialist','Investigator','Junior Foreign Affairs Officer','Labor Relations Specialist','Labor Relations Specialist','Learning Specialist','Legislative Assistant','Legislative Analyst','Legislative Specialist','Lender Approval Analyst','Lender Monitoring Analyst','Licensing Examining Specialist/Offices','Logistics Management Specialist','Managed Care Specialist','Management Analyst','Management and Budget Analyst','Management and Program Analyst','Management Intern','Management Support Analyst ','Management Support Specialist','Manpower Analyst','Manpower Development Specialist','Marketing Analyst','Marketing Specialist','Mass Communications Producer','Mathematical Statistician','Media Relations Assistant','Meteorologist','Microbiologist','Mitigation Program Specialist','National Security Training Technology','Natural Resources Specialist','Naval Architect','Operations Officer','Operations Planner','Operations Research Analyst','Operations Supervisor','Outdoor Recreation Planner','Paralegal Specialis','Passport/Visa Specialist','Personnel Management Specialist','Personnel Staffing and Classification Specialist','Petroleum Engineer','Physical Science Officer','Physical Scientist, General','Physical Security Specialist','Policy Advisor to the Director','Policy Analyst','Policy and Procedure Analyzt','Policy and Regulatory Analyst','Policy Coordinator','Policy/Program Analyst','Population/Family Planning Specialist','Position Classification Specialist','Presidential Management Fellow','Procurement Analyst','Procurement Specialist','Professional Relations Outreach','Program Administrator','Program Analyst','Program and Policy Analyst','Program Evaluation and Risk Analyst','Program Evolution Team Leader','Program Examiner','Program Manager','Program Operations Specialist','Program Specialist','Program Support Specialist','Program/Public Health Analyst','Project Analyst','Project Manager','Prototype Activities Coordinator','Psychologist (General)','Public Affairs Assistant','Public Affairs Intern','Public Affairs Specialist','Public Health Advisor','Public Health Analyst','Public Health Specialist','Public Liaison/Outreach Specialist','Public Policy Analyst','Quantitative Analyst','Real Estate Appraiser','Realty Specialist','Regional Management Analyst','Regional Technician','Regulatory Analyst','Regulatory Specialist','Research Analyst','Restructuring Analyst','Risk Analyst','Safety and Occupational Health Manager','Safety and Occupational Health Specialist','Safety Engineer/Industrial Hygienist','Science Program Analyst','Securities Compliance Examiner','Security Specialist','SeniorManagement Information Specialist','Social Insurance Analyst','Social Insurance Policy Specialist','Social Insurance Specialist','Social Science Analyst','Social Science Research Analyst','Social Scientist','South Asia Desk Officer','Special Assistant','Special Assistant for Foreign Policy Strategy','Special Assistant to the Associate Director','Special Assistant to the Chief Information Office','Special Assistant to the Chief, FBI National Security', 'Special Assistant to the Director','Special Emphasis Program Manager','Special Projects Analyst','Specialist','Staff Associate','Statistician','Supply Systems Analyst','Survey or Mathematical Statistician','Survey Statistician','Systems Accountant','Systems Analyst','Tax Law Specialist','Team Leader','Technical Writer/Editor','Telecommunications Policy Analyst','Telecommunications Specialist','Traffic Management Specialist','Training and Technical Assistant','Training Specialist','Transportation Analyst','Transportation Industry Analyst','Transportation Program Specialist','Urban Development Specialist','Usability Researcher','Veterans Employment Specialist','Video Production Specialist','Visa Specialist','Work Incentives Coordinator','Workers Compensation Specialist','Workforce Development Specialist','Worklife Wellness Specialist','Writer','Writer/Editor');

                    if(!empty($err_msg)) {
                      echo "<option value='".$_POST['title']."'>".$_POST['title']."</option>";
                    } else {
                      echo "<option value='' disabled selected>Select</option>";
                    } ?>
                    <?php
                      $count_ttl = 0;
                      while(!empty($arr_ttl[$count_ttl])) {
                        echo "<option value='".$arr_ttl[$count_ttl]."'>".$arr_ttl[$count_ttl]."</option>";
                          $count_ttl++;
                      } 
                    ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="grid_5 alpha">
                <label>First Name</label><b class="asterisk_req">*</b>&nbsp;&nbsp;<span class="hido" id="hido1"><p id="error1" class="error"></p></span>
                <input type="text" class="form-control" id="bfname" name="bfname" onkeypress="return KeyPressFName(event)" onclick="clickField1()" value="<?php if(!empty($err_msg)){echo $_POST['bfname'];} ?>">
              </div>
              <div class="grid_5 omega">
                <label>Last Name</label><b class="asterisk_req">*</b>&nbsp;&nbsp;<span class="hido" id="hido2"><p id="error2" class="error"></p></span>
                <input type="text" class="form-control" id="blname" name="blname" onkeypress="return KeyPressLName(event)" onclick="clickField2()" value="<?php if(!empty($err_msg)){echo $_POST['blname'];} ?>">
              </div>
            </div>

            <div class="form-group">
              <div class="grid_5 alpha">
                <label>Email</label>&nbsp;&nbsp;<span class="hido" id="hido3"><p id="error3" class="error"></p></span>
                <input type="text" class="form-control" id="c-eadd" name="c-eadd" value="<?php if(empty($err_msg)){echo $p2_email;}else{echo $_POST['c-eadd'];} ?>" readonly>
              </div>
              <div class="grid_5 omega" style="margin-top: -0.85em;">
                <label>Contact Number</label><b class="asterisk_req">*</b>&nbsp;&nbsp;<span class="hido" id="hido4"><p id="error4" class="error"></p></span>
                <input type="text" class="form-control" id="c-phone" name="c-phone" maxlength="10" onkeypress="return KeyPressPhone(event)" onclick="clickField4()" value="<?php if(!empty($err_msg)){echo $_POST['c-phone'];} ?>">
              </div>
            </div>

            <div class="form-group">
              <div class="grid_5 alpha">
                <label>Billing Address 1</label><b class="asterisk_req">*</b>&nbsp;&nbsp;<span class="hido" id="hido5"><p id="error5" class="error"></p></span>
                <input type="text" class="form-control" id="c-street" name="c-street" onkeypress="return KeyPressStreet(event)" onclick="clickField5()" value="<?php if(empty($err_msg)){echo $p2_street;}else{echo $_POST['c-street'];} ?>">
              </div>
              <div class="grid_5 omega" style="margin-top: 0.85em;">
                <label>Suite/Apartment Number</label>
                <input type="text" class="form-control" name="c-street2" value="<?php if(!empty($err_msg)){echo $_POST['c-street2'];} ?>">
              </div>
            </div>

            <div class="form-group">
              <div class="grid_5 alpha">
                <label>City</label><b class="asterisk_req">*</b>&nbsp;&nbsp;<span class="hido" id="hido6"><p id="error6" class="error"></p></span>
                <input type="text" class="form-control" id="c-city" name="c-city" onkeypress="return KeyPressCity(event)" onclick="clickField6()" value="<?php if(empty($err_msg)){echo $p2_city;}else{echo $_POST['c-city'];} ?>">
              </div>
              <div class="grid_2">
               <label>State</label><b class="asterisk_req">*</b>&nbsp;&nbsp;<span class="hido" id="hido7-state"><p id="error7-state" class="error"></p></span>
                <select class="form-control" name="c-state" id="c-state" onchange="ChangeState()">
                  <?php if(empty($err_msg) && !empty($p2_state)) {
                    echo "<option value='' id='option_1'>".$p2_state."</option>";
                  } else if(!empty($err_msg) && empty($p2_state)) {
                    echo "<option value='".$_POST['c-state']."' id='option_1'>".$_POST['c-state']."</option>";
                  } else {  
                    echo "<option value='' disabled selected>Select</option>";
                  } ?>
                  
                  <option value="AL">AL</option> 
                  <option value="AK">AK</option>
                  <option value="AZ">AZ</option> 
                  <option value="AR">AR</option> 
                  <option value="CA">CA</option> 
                  <option value="CO">CO</option> 
                  <option value="CT">CT</option> 
                  <option value="DE">DE</option> 
                  <option value="DC">DC</option> 
                  <option value="FL">FL</option> 
                  <option value="GA">GA</option> 
                  <option value="HI">HI</option> 
                  <option value="ID">ID</option> 
                  <option value="IL">IL</option> 
                  <option value="IN">IN</option> 
                  <option value="IA">IA</option> 
                  <option value="KS">KS</option> 
                  <option value="KY">KY</option> 
                  <option value="LA">LA</option> 
                  <option value="ME">ME</option> 
                  <option value="MD">MD</option> 
                  <option value="MA">MA</option> 
                  <option value="MI">MI</option> 
                  <option value="MN">MN</option> 
                  <option value="MS">MS</option> 
                  <option value="MO">MO</option> 
                  <option value="MT">MT</option> 
                  <option value="NE">NE</option> 
                  <option value="NV">NV</option> 
                  <option value="NH">NH</option> 
                  <option value="NJ">NJ</option> 
                  <option value="NM">NM</option> 
                  <option value="NY">NY</option> 
                  <option value="NC">NC</option> 
                  <option value="ND">ND</option> 
                  <option value="OH">OH</option> 
                  <option value="OK">OK</option> 
                  <option value="OR">OR</option> 
                  <option value="PA">PA</option> 
                  <option value="RI">RI</option> 
                  <option value="SC">SC</option> 
                  <option value="SD">SD</option> 
                  <option value="TN">TN</option> 
                  <option value="TX">TX</option> 
                  <option value="UT">UT</option> 
                  <option value="VT">VT</option> 
                  <option value="VA">VA</option> 
                  <option value="WA">WA</option> 
                  <option value="WV">WV</option> 
                  <option value="WI">WI</option> 
                  <option value="WY">WY</option>
                </select>
              </div>
              <div class="grid_3 omega">
                <label>Zip</label><b class="asterisk_req">*</b>&nbsp;&nbsp;<span class="hido" id="hido7"><p id="error7" class="error"></p></span>
                <input type="text" class="form-control" id="c-zip" name="c-zip" maxlength="5" onkeypress="return KeyPressZip(event)" onclick="clickField7()" value="<?php if(empty($err_msg)){echo $p2_zip;}else{echo $_POST['c-zip'];} ?>">
              </div>
            </div>

            <div class="form-group">
              <div class="grid_5 alpha">
                <label>Card Number</label><b class="asterisk_req">*</b>&nbsp;&nbsp;<span class="hido" id="hido8"><p id="error8" class="error"></p></span>
                <input type="text" class="form-control" id="card-number" name="card-number" onkeypress="return KeyPressCCNumber(event)" onclick="clickField8()" value="<?php if(!empty($err_msg)){echo $_POST['card-number'];} ?>">
              </div>
              <div class="grid_3">
               <label> CVC </label><b class="asterisk_req">*</b>
                <input type="text" class="form-control" id="card-cvc" name="card-cvc" maxlength="3" onkeypress="return KeyPressCVC(event)" onclick="clickField9()" value="<?php if(!empty($err_msg)){echo $_POST['card-cvc'];} ?>">
              </div>
              <div class="grid_2 omega">
                <label>Exp. Date (mm/yy)</label><b class="asterisk_req">*</b>
                <div style="display: inline;">
                  <input type="text" class="form-control" style="float: left; width: 45%;"  maxlength="2" id="card-expiry-month" name="card-expiry-month" onkeypress="return KeyPressCCExpiryMM(event)" onclick="clickField10()" value="<?php if(!empty($err_msg)){echo $_POST['card-expiry-month'];} ?>">
                  <input type="text" class="form-control" style="float: left; width: 45%; margin-left: 5%;" maxlength="2" id="card-expiry-year" name="card-expiry-year" onkeypress="return KeyPressCCExpiryYY(event)" onclick="clickField11()" value="<?php if(!empty($err_msg)){echo $_POST['card-expiry-year'];} ?>">
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="grid_5 alpha">
                <label>Sales Agent</label><b class="asterisk_req">*</b>&nbsp;&nbsp;<span class="hido" id="hido12"><p id="error12" class="error"></p></span>
                <select class="form-control" id="sales-agent" name="sales-agent" onchange="ChangeAgent()">
                <?php 
                  if(!empty($err_msg)) {
                  echo "
                    <optgroup>
                      <option value='".$_POST['sales-agent']."'>".$_POST['sales-agent']."</option>
                    </optgroup>"; 
                  } else {
                    echo "<option value='' disabled selected>Select</option>";
                  }
                ?>
                  <option value="Bethany">Bethany</option>
                  <option value="Gem">Gem</option>
                  <option value="Jasper">Jasper</option>
                </select>
              </div>
              <div class="col-lg-3">
                <span class="hido" id="hido9"><p id="error9" class="error"></p></span>
              </div>
              <div class="col-lg-3">
                <span class="hido" id="hido10"><p id="error10" class="error"></p></span><br />
                <span class="hido" id="hido11"><p id="error11" class="error"></p></span>
              </div>
            </div>

              <div style="text-align: center; margin-top: 25px;">
                <span class="payment-errors">
                  <span id="error_check_all"><?php echo $err_msg; ?></span>
                  <span class="hido" id="error_check_all"><label id="error_check_all"></label></span>
                </span>
              </div>

              <div class="grid_2 push_4">
                <input type="submit" class="btn btn-primary regbutton" name="submit_billing_form" value="Submit">
              </div>
            </div>

          </fieldset>
        </form>
        </div>
      </div>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/dataTables/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="js/field_trappings/enroll_form_b.js"></script>
  </div>

  <script>
    var x = document.getElementById("option_1_hidden_value").value;

    function setSelectValue (id, val) {
        document.getElementById(id).value = val;
    }
    setSelectValue('option_1', x);
  </script>
<?php } ?>
</body>
</html>