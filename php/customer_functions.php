<?php
    //========Twilio Connection========
    //require_once 'lib/twilio/Twilio/autoload.php'; // Loads the library
    //use Twilio\Rest\Client;
$result_db_logs = $obj_gateway_log->fetchAll("SELECT * FROM log");
//$result_db_customers = $obj_gateway_customer->fetchAll("SELECT * FROM customer");
$all_logs = $result_db_logs;
date_default_timezone_set("Asia/Manila");
    $check = null;
    $usingPayPortal = "";
    if(!isset($_GET['id'])) {
        ?>
        <script>
            window.location = "summary";
        </script>
        <?php
    } else {
        $i=0;
        while(isset($result_db_customers[$i])) {
              
            if($result_db_customers[$i]->getKeyId() == $_GET['id']) {

                $customer_db_id = $result_db_customers[$i]->getKeyId();
                $business_name = $result_db_customers[$i]->business_name;
                $business_address = $result_db_customers[$i]->business_address;
                if($result_db_customers[$i]->business_suite_no != "null") {
                    $business_address_2 = $result_db_customers[$i]->business_suite_no;
                } else {
                    $business_address_2 = null;
                }
                $business_city = $result_db_customers[$i]->business_city;
                $business_state = $result_db_customers[$i]->business_state;
                $business_zip = $result_db_customers[$i]->business_zip;
                $business_country = $result_db_customers[$i]->business_country;
                $business_phone = $result_db_customers[$i]->business_phone_no;
                $business_email = $result_db_customers[$i]->business_email;
                $business_alt_phone = $result_db_customers[$i]->business_alternate_phone_no;
                $business_post_address = $result_db_customers[$i]->business_post_address;
                $business_hours = $result_db_customers[$i]->business_hours;
                $payment_method = $result_db_customers[$i]->payment_method;

                if(isset($result_db_customers[$i]->chargify_id) || isset($result_db_customers[$i]->stripe_id)) {
                    if(isset($result_db_customers[$i]->chargify_id)) {
                        $payportalID = $result_db_customers[$i]->chargify_id;
                        $product_id = $result_db_customers[$i]->product_id;
                        $product_handle = $result_db_customers[$i]->product_handle;
                        $product_name = $result_db_customers[$i]->product_name;
                        $usingPayPortal ="chargify";
                    }else if(isset($result_db_customers[$i]->stripe_id)) {
                        $payportalID = $result_db_customers[$i]->stripe_id;
                        $plan_id = $result_db_customers[$i]->plan_id;
                        $plan_name = $result_db_customers[$i]->plan_name;
                        $usingPayPortal = "stripe";
                    } else {
                        $payportalID = null;
                    }
                    $business_category = $result_db_customers[$i]->business_category;
                    $business_website = $result_db_customers[$i]->business_website;
                    $email = $result_db_customers[$i]->customer_email;

                    if(isset($result_db_customers[$i]->customer_alternate_email) && $result_db_customers[$i]->customer_alternate_email != "null") {
                        $alt_email = $result_db_customers[$i]->customer_alternate_email;
                    } else {
                        $alt_email = null;
                    }

                    $fname = $result_db_customers[$i]->customer_first_name;
                    $lname = $result_db_customers[$i]->customer_last_name;
                    $phone = $result_db_customers[$i]->customer_phone_no;
                    $office_phone = $business_phone;

                    /*
                    if(isset($result_db_customers['Items'][$i]['customer_alternate_phone_no']['S']) && $result_db_customers['Items'][$i]['customer_alternate_phone_no']['S'] != "null") {
                        $alt_phone = $result_db_customers['Items'][$i]['customer_alternate_phone_no']['S'];
                    } else {
                        $alt_phone = null;
                    }
                    */

                    if(isset($result_db_customers[$i]->customer_mobile_no) && $result_db_customers[$i]->customer_mobile_no != "null") {
                        $mobile = $result_db_customers[$i]->customer_mobile_no;
                    } else {
                        $mobile = null;
                    }

                    $salutation = $result_db_customers[$i]->customer_salutation;

                    if(isset($result_db_customers[$i]->customer_title) && $result_db_customers[$i]->customer_title != "null") {
                        $title = $result_db_customers[$i]->customer_title;
                    } else {
                        $title = null;
                    }

                    $sales_date = $result_db_customers[$i]->sale_date;
                    $sales_agent = $result_db_customers[$i]->sale_agent;
                    $sales_center = $result_db_customers[$i]->sale_center;
                    
                    $product_component_id = $result_db_customers[$i]->product_component_id;
                    $product_component_name = $result_db_customers[$i]->product_component_name;
                    $product_component_quantity = $result_db_customers[$i]->product_component_quantity;
                    $product_coupon_code = $result_db_customers[$i]->product_coupon_code;
                    $product_coupon_name = $result_db_customers[$i]->product_coupon_name;
                    $cc_last_four = $result_db_customers[$i]->customer_card_last_four;
                    $cc_exp_mm = $result_db_customers[$i]->customer_card_expire_month;
                    $cc_exp_yy = $result_db_customers[$i]->customer_card_expire_year;
                    $bill_address = $result_db_customers[$i]->customer_billing_address;
                    if($result_db_customers[$i]->business_suite_no != "null") {
                        $bill_address_2 = $result_db_customers[$i]->business_suite_no;
                    } else {
                        $bill_address_2 = null;
                    }
                    //$bill_address_2 = $result_db_customers['Items'][$i]['customer_suite_no']['S'];
                    $bill_city = $result_db_customers[$i]->customer_billing_city;
                    $bill_state = $result_db_customers[$i]->customer_billing_state;
                    $bill_zip = $result_db_customers[$i]->customer_billing_zip;
                    $bill_country = "US";
                    //prov
                    $gmail_acc = $result_db_customers[$i]->prov_gmail;
                    $keywords = $result_db_customers[$i]->prov_keywords;
                    $sp_request = $result_db_customers[$i]->prov_special_request;
                    $social1 = $result_db_customers[$i]->prov_existing_social1;
                    $social2 = $result_db_customers[$i]->prov_existing_social2;
                    $biglo_site = $result_db_customers[$i]->prov_biglo_website;
                    $analytical_address = $result_db_customers[$i]->prov_analytical_address;
                    $google_plus = $result_db_customers[$i]->prov_google_plus;
                    $google_maps = $result_db_customers[$i]->prov_google_maps;
                    $facebook = $result_db_customers[$i]->prov_facebook;
                    $foursquare = $result_db_customers[$i]->prov_foursquare;
                    $twitter = $result_db_customers[$i]->prov_twitter;
                    $linkedin = $result_db_customers[$i]->prov_linkedin;
                    //cancel
                    if(isset($result_db_customers[$i]->cancelled) && $result_db_customers[$i]->cancelled != "null") {
                        $cancelled = $result_db_customers[$i]->cancelled;
                        $cancel_reason = $result_db_customers[$i]->cancel_reason;
                    } else {
                        $cancelled = "no"; 
                        $cancel_reason = "";
                    }
                } 
            }
            $i++;
        }

        if($usingPayPortal == "chargify") {
            $test = true;
            $subscription = new ChargifySubscription(NULL, $test);

            try {
                $result_customer_id_search = $subscription->getByCustomerID($payportalID);
            } catch (ChargifyValidationException $cve) {
                echo $cve->getMessage();
            }

            $billing_sum = "$".number_format(($result_customer_id_search[0]->total_revenue_in_cents /100), 2, '.', ' ');
            $fin = explode('T',$result_customer_id_search[0]->updated_at,-1);
            $fin2 = explode('-',$fin[0]);
            $char_upd_at = $fin2[1].".".$fin2[2].".".$fin2[0];

            if($result_customer_id_search[0]->state == "trialing") {
                $trial_date = explode('T',$result_customer_id_search[0]->trial_ended_at,-1);
                $state_date = explode('-',$trial_date[0]);
                $state_date_fin = $state_date[1]."/".$state_date[2]."/".$state_date[0];
                $cust_search_state = "Trial End: ";
            } elseif($result_customer_id_search[0]->state == "active") {
                $billing_date = explode('T',$result_customer_id_search[0]->next_assessment_at,-1);
                $state_date = explode('-',$billing_date[0]);
                $state_date_fin = $state_date[1]."/".$state_date[2]."/".$state_date[0];
                $cust_search_state = "Next Billing: ";
            } else {
                $cancel_date = explode('T',$result_customer_id_search[0]->canceled_at,-1);
                $state_date = explode('-',$cancel_date[0]);
                $state_date_fin = $state_date[1]."/".$state_date[2]."/".$state_date[0];
                $cust_search_state = "Cancelled At: ";
            }

            $cust_status = $result_customer_id_search[0]->state;

        } else if($usingPayPortal == "stripe") {
            require_once('lib/stripe/init.php');

            \Stripe\Stripe::setApiKey('sk_test_T8cInYaDaLdip8ZpmtPzaq9B');

            /** get stripe customer total invoice **/
            $invoice = \Stripe\Invoice::all(array("customer" => $payportalID));

            $uro1 = json_decode(json_encode($invoice), true);

            $totalInv = 0;
            foreach($uro1['data'] as $inv) {
                if($inv['paid'] == true) {
                    $totalInv += $inv['amount_due'];
                }
            }
            $billing_sum = "$".number_format(($totalInv /100), 2, '.', ' ');

            /** get customer subscription status **/
            $customer = \Stripe\Customer::retrieve($payportalID);

            $uro2 = json_decode(json_encode($customer), true);

            foreach($uro2['subscriptions']['data'] as $inv) {
                $cust_status = $inv['status'];
            }

            if(!isset($cust_status)) {
                $cust_status = "canceled";
            } 
        } else {
            $business_category = "null";
            $billing_sum = "None";
            $email = $business_email;
            $cust_status = "canceled";
            $salutation = null;
            $fname = null;
            $lname = null;
            $title = null;
            $phone = null;
            $office_phone = $business_phone;
            $mobile = null;
            $alt_email = null;
            $bill_address = null;
            $bill_address_2 = null;
            $bill_city = null;
            $bill_state = null;
            $bill_zip = null;
            $sales_center = null;
            $sales_date = null;
            $sales_agent = null;
            $cancelled = "no";
            $cancel_reason = "";
        }

        //prime phone number - customer number
        if($phone != null) {
            $num_arr = array_map('intval', str_split($phone));
            $fin_num = array();
            array_push($fin_num, $num_arr[0].'-');
            $i = 1;
            while($i < 4){
              array_push($fin_num, $num_arr[$i]);
              $i++;
            }
            array_push($fin_num, '-');
            $j = 4;
            while($j < 7){
              array_push($fin_num, $num_arr[$j]);
              $j++;
            }
            array_push($fin_num, '-');
            $k = 7;
            while($k < 11){
              array_push($fin_num, $num_arr[$k]);
              $k++;
            }
            $phone = implode("",$fin_num);
        }

        //office number - business phone number
        $num_arr1 = array_map('intval', str_split($office_phone));
        $fin_num1 = array();
        array_push($fin_num1, $num_arr1[0].'-');
        $i = 1;
        while($i < 4){
          array_push($fin_num1, $num_arr1[$i]);
          $i++;
        }
        array_push($fin_num1, '-');
        $j = 4;
        while($j < 7){
          array_push($fin_num1, $num_arr1[$j]);
          $j++;
        }
        array_push($fin_num1, '-');
        $k = 7;
        while($k < 11){
          array_push($fin_num1, $num_arr1[$k]);
          $k++;
        }
        $office_phone = implode("",$fin_num1);
    } 

    if(isset($_POST['upd_acc'])) {
        $business_name = stripslashes($_POST['acc_b_name']);
        $business_category = $_POST['acc_category'];
        $salutation = $_POST['acc_salut'];
        $title = $_POST['acc_title'];
        $fname = $_POST['acc_fname'];
        $lname = $_POST['acc_lname'];
        $phone = $_POST['acc_phone'];
        $office_phone = $_POST['acc_office_phone'];
        $mobile = $_POST['acc_mobile_phone'];
        $email = $_POST['acc_email'];
        $alt_email = $_POST['acc_alter_email'];
        $bill_address = $_POST['acc_bill_add_1'];
        $bill_address_2 = $_POST['acc_bill_add_2'];
        $bill_city = $_POST['acc_bill_city'];
        $bill_state = $_POST['acc_bill_state'];
        $bill_zip = $_POST['acc_bill_zip'];
        $prod_handle = $_POST['acc_product'];
        $plan_id = $_POST['acc_product'];
        $comp_quantity = $_POST['acc_component'];
        $coupon_code = $_POST['acc_coupon'];

        if(empty($bill_address_2)) {
            $bill_address_2 = "null";
        }

        if(isset($_POST['cancel'])) {
            $cancelled = $_POST['cancel'];
            if($cancelled == "yes") {
                $cancel_reason = $_POST['cancel_reason'];
            } else {
                $cancel_reason = "";
            }
        }

        $phone = str_replace('-', '', $phone);
        $office_phone = str_replace('-', '', $office_phone);


        /* check what is changed, this is for logs */
        $changes = array();
        $i=0;
        $cardStripeUpd = array();
        $planprodUpdate = "";
        while(isset($result_db_customers[$i])) {
            if($result_db_customers[$i]->getKeyId() == $_GET['id']) {
                if($business_name != $result_db_customers[$i]->business_name) {
                    array_push($changes, "Business Name");
                }
                if($business_category != $result_db_customers[$i]->business_category) {
                    array_push($changes, "Business Category");
                }
                if($salutation != $result_db_customers[$i]->customer_salutation) {
                    array_push($changes, "Salutation");
                }
                if($title != $result_db_customers[$i]->customer_title) {
                    array_push($changes, "Title");
                }
                if($fname != $result_db_customers[$i]->customer_first_name) {
                    array_push($changes, "First Name");
                }
                if($lname != $result_db_customers[$i]->customer_last_name) {
                    array_push($changes, "Last Name");
                }
                if($phone != $result_db_customers[$i]->customer_phone_no) {
                    array_push($changes, "Primary Phone No.");
                }
                if($office_phone != $result_db_customers[$i]->business_phone_no) {
                    array_push($changes, "Office No.");
                }
                /*
                if(isset($result_db_customers['Items'][$i]['customer_alternate_phone_no']['S']) && $result_db_customers['Items'][$i]['customer_alternate_phone_no']['S'] != "null") {
                    if($alt_phone != $result_db_customers['Items'][$i]['customer_alternate_phone_no']['S']) {
                        array_push($changes, "Alternate Phone No.");
                    } 
                } else {
                    //no initial data
                    if(!empty($alt_phone)) {
                        array_push($changes, "Alternate Phone No.");
                    }
                }
                */
                if(isset($result_db_customers[$i]->customer_mobile_no) && $result_db_customers[$i]->customer_mobile_no != "null") {
                    if($mobile != $result_db_customers[$i]->customer_mobile_no) {
                        array_push($changes, "Mobile No.");
                    }
                } else {
                    //no initial data
                    if(!empty($mobile)) {
                        array_push($changes, "Mobile No.");
                    }
                }
                if($email != $result_db_customers[$i]->customer_email) {
                    array_push($changes, "Primary Email");
                }
                if(isset($result_db_customers[$i]->customer_alternate_email) && $result_db_customers[$i]->customer_alternate_email != "null") {
                    if($alt_email != $result_db_customers[$i]->customer_alternate_email) {
                        array_push($changes, "Alternate Email");
                    }
                } else {
                    if(!empty($alt_email)) {
                        array_push($changes, "Alternate Email");
                    }
                }
                if($bill_address != $result_db_customers[$i]->customer_billing_address) {
                    array_push($changes, "Billing Address 1");
                    array_push($cardStripeUpd, 'address_line1');
                }
                if($bill_address_2 != $result_db_customers[$i]->customer_suite_no) {
                    array_push($changes, "Billing Address 2");
                    array_push($cardStripeUpd, 'address_line2');
                }
                if($bill_city != $result_db_customers[$i]->customer_billing_city) {
                    array_push($changes, "Billing City");
                    array_push($cardStripeUpd, 'address_city');
                }
                if($bill_state != $result_db_customers[$i]->customer_billing_state) {
                    array_push($changes, "Office State");
                   array_push( $cardStripeUpd, 'address_state');
                }
                if($bill_zip != $result_db_customers[$i]->customer_billing_zip) {
                    array_push($changes, "Postal Code");
                    array_push($cardStripeUpd, 'address_zip');
                }
                if($usingPayPortal == "chargify") {
                    if($prod_handle != $result_db_customers[$i]->product_handle) {
                        array_push($changes, "Product");
                    }
                }
                if($usingPayPortal == "stripe") {
                    if($plan_id != $result_db_customers[$i]->plan_id) {
                        array_push($changes, "Product");
                    }
                }
                if($comp_quantity != $result_db_customers[$i]->product_component_quantity) {
                    array_push($changes, "Component Quantity");
                }
                if($coupon_code != $result_db_customers[$i]->product_coupon_code) {
                    array_push($changes, "Coupon");
                }
            }
            $i++;
        }

        if($usingPayPortal == "chargify") {
            if($prod_handle == 'prod_001') {
                $prodID = 3881312;
                $prodName = "Basic Plan";
            } else if($prod_handle == 'plan_002') {
                $prodID = 3881313;
                $prodName = "Start-up Plan";
            } else if($prod_handle == 'plan_005') {
                $prodID = 3881318;
                $prodName = "Upgrade to Start-up Plan";
            } else if($prod_handle == 'plan_003') {
                $prodID = 3881314;
                $prodName = "Business Plan";
            } else if($prod_handle == 'plan_006') {
                $prodID = 3881319;
                $prodName = "Upgrade to Business Plan";
            } else if($prod_handle == 'plan_004') {
                $prodID = 3881316;
                $prodName = "Enterprise Plan";
            } else {
                $prodID = 3881320;
                $prodName = "Upgrade to Enterprise Plan";
            }

            if($coupon_code == 'SAVE50') {  
                $couponName = "Discount Coupon";
            } else if($coupon_code == 'FREDOM') {
                $couponName = "Domain Coupon";
            } else if($coupon_code == 'REFER') {
                $couponName = "Referral Coupon";
            } else if($coupon_code == 'REMOVE') {
                $couponName = "null";
            } else {
                $couponName = "null";
            }

            $test = true;
            $customer = new ChargifyCustomer(NULL, $test);
            $upd_subscription = new ChargifySubscription(NULL, $test);
            $component = new ChargifyQuantityBasedComponent(NULL, $test);
            $coupon = new ChargifyCoupon(NULL, $test);

            $customer->id = $payportalID;
            $customer->organization = $business_name;
            $customer->first_name = $fname;
            $customer->last_name = $lname;
            $customer->email = $email;
            $customer->phone = $phone;

            $upd_subscription->id = @$result_customer_id_search[0]->id; //chargify subscriptionID
            $sub_prod = new stdClass();
            $sub_prod->handle = @$prod_handle;
            $sub_prod->id = @$prodID;
            $upd_subscription->product = $sub_prod;
            $component->id = @$result_customer_id_search[0]->id;
            $component->component_id = 196368;
            $component->quantity = $comp_quantity;

            try {
                $customer->update();
                if($prod_handle != $product_handle) {
                    $upd_subscription->updateProduct();
                }

                if($comp_quantity != $product_component_quantity) {
                    $component->update();
                }

                $coupon->subscription_id = @$result_customer_id_search[0]->id;
                if($coupon_code != $product_coupon_code) {
                    if($coupon_code != "null") {
                        if($product_coupon_code != "null") {
                            if($coupon_code == "REMOVE") {
                                $coupon->remove();
                                $coupon_code = "";
                            } else {
                                $coupon->remove();
                                $coupon->coupon_code = $coupon_code;
                                $coupon->add();
                            }
                        } else {
                            $coupon->coupon_code = $coupon_code;
                            $coupon->add();
                        }
                    } 
                }

                if($cancelled == "yes") {
                    array_push($changes, "Account to Canceled");
                    $subscription_cancel = new ChargifySubscription(NULL, $test);
                    $subscription_cancel->id = $result_customer_id_search[0]->id;
                    $subscription_cancel->cancellation_message = $cancel_reason;
                    $subscription_cancel->cancel();
                    $cust_status = "canceled";
                }
            } catch (ChargifyValidationException $cve) {
                echo $cve->getMessage();
            }

            $planprodUpdate_product_id = @$prodID;
            $planprodUpdate_product_handle = @$prod_handle;
            $planprodUpdate_product_name = @$prodName;

        }

        if($usingPayPortal == "stripe") {
            if($plan_id == 'ursa_basic_plan') {
                $planName = "Basic Plan";
            } else if($plan_id == 'ursa_startup_plan') {
                $planName = "Start-up Plan";
            } else if($plan_id == 'ursa_upgrade_to_startup_plan') {
                $planName = "Upgrade to Start-up Plan";
            } else if($plan_id == 'ursa_business_plan') {
                $planName = "Business Plan";
            } else if($plan_id == 'ursa_upgrade_to_business_plan') {
                $planName = "Upgrade to Business Plan";
            } else if($plan_id == 'ursa_enterprise_plan') {
                $planName = "Enterprise Plan";
            } else {
                $planName = "Upgrade to Enterprise Plan";
            }

            if($coupon_code == 'SAVE50') {  
                $couponName = "Discount Coupon";
            } else if($coupon_code == 'FREDOM') {
                $couponName = "Domain Coupon";
            } else if($coupon_code == 'REFER') {
                $couponName = "Referral Coupon";
            } else if($coupon_code == 'REMOVE') {
                $couponName = "null";
            } else {
                $couponName = "null";
            }

            if(!empty($cardStripeUpd)) {
                $customer = \Stripe\Customer::retrieve($payportalID);

                $unprotected_response_object = json_decode(json_encode($customer), true);

                foreach($unprotected_response_object['sources']['data'] as $inv) {
                    $card_id = $inv['id'];
                }

                try {
                    $card = $customer->sources->retrieve($card_id);
                    foreach($cardStripeUpd as $cSU) {
                        if($cSU == 'address_line1') {
                            $card->address_line1 = $bill_address;
                        }
                        if($cSU == 'address_line2') {
                            $card->address_line2 = $bill_address_2;
                        }
                        if($cSU == 'address_city') {
                            $card->address_city = $bill_city;
                        }
                        if($cSU == 'address_state') {
                            $card->address_state = $bill_state;
                        }
                        if($cSU == 'address_zip') {
                            $card->address_zip = $bill_zip;
                        }
                    }
                    $response = $card->save();
                    //print_r($response);
                } catch (\Stripe\Error\InvalidRequest $e) {
                    $body = $e->getJsonBody();
                    print_r($e);
                }
            }

            if($cancelled == "yes") {
                $customer1 = \Stripe\Customer::retrieve($payportalID);

                $unprotected_response_object1 = json_decode(json_encode($customer1), true);

                foreach($unprotected_response_object1['subscriptions']['data'] as $inv1) {
                    $subID = $inv1['id'];
                }

                try {
                    $sub = \Stripe\Subscription::retrieve($subID);
                    $cancel = $sub->cancel();
                    array_push($changes, "Account to Canceled");
                    $cust_status = "canceled";
                } catch (\Stripe\Error\InvalidRequest $e) {
                    $body = $e->getJsonBody();
                    print_r($e);
                }
            }

            $planprodUpdate_plan_id = @$plan_id;
            $planprodUpdate_plan_name = @$planName;

        }

        $params_upt_acc = $obj_gateway_customer->fetchById($customer_db_id);


        if(empty($alt_email)) {
            $alternate_email = 'null';
        } else {
            $alternate_email = @$alt_email;
        }

        /*
        if(empty($alt_phone)) {
            $alternate_phone = '":customer_alternate_phone_no": "null",';
        } else {
            $alternate_phone = '":customer_alternate_phone_no": "'.@$alt_phone.'",';
        }
        */

        if(empty($mobile)) {
            $mobile_phone = 'null';
        } else {
            $mobile_phone = @$mobile;
        }

            $params_upt_acc->business_name="".@$business_name."";
            $params_upt_acc->business_category="".@$business_category."";
            $params_upt_acc->business_phone_no="".@$office_phone."";
            $params_upt_acc->customer_salutation="".@$salutation."";
            $params_upt_acc->customer_title="".@$title."";
            $params_upt_acc->customer_first_name="".@$fname."";
            $params_upt_acc->customer_last_name="".@$lname."";
            $params_upt_acc->customer_phone_no="".@$phone."";
            $params_upt_acc->customer_mobile_no="".$mobile_phone."";
            $params_upt_acc->customer_email="".@$email."";
            $params_upt_acc->customer_alternate_email="".$alternate_email."";
            $params_upt_acc->customer_billing_address="".@$bill_address."";
            $params_upt_acc->customer_suite_no="".@$bill_address_2."";
            $params_upt_acc->customer_billing_city="".@$bill_city."";
            $params_upt_acc->customer_billing_state="".@$bill_state."";
            $params_upt_acc->customer_billing_zip="".@$bill_zip."";
            if(isset($planprodUpdate_product_id)){
                $params_upt_acc->product_id="".$planprodUpdate_product_id."";
                $params_upt_acc->product_handle="".$planprodUpdate_product_handle."";
                $params_upt_acc->product_name="".$planprodUpdate_product_name."";
            }
            if(isset($planprodUpdate_plan_id)){
                $params_upt_acc->plan_id="".$planprodUpdate_plan_id."";
                $params_upt_acc->plan_name="".$planprodUpdate_plan_name."";
            }
            $params_upt_acc->product_component_quantity="".@$comp_quantity."";
            $params_upt_acc->product_coupon_code="".@$coupon_code."";
            $params_upt_acc->product_coupon_name="".@$couponName."";
        $chg_cnt = 0;
        $str_changes = "";            
        while(!empty($changes[$chg_cnt])) {
            if($chg_cnt == 0) {
                $str_changes = $changes[$chg_cnt];
            } else {
                $str_changes .= ", ".$changes[$chg_cnt];
            }
            $chg_cnt++;
        }

        if($changes != null) {
            $params_add_log = $obj_gateway_log->createEntity([
                    "user_id"=> "".$_SESSION['user_now_id']."",
                    "customer_id"=> "".$_GET['id']."",
                    "event"=> "Updated",
                    "data"=> "".$str_changes."",
                    "date"=> "".date('Y/m/d H:i:s').""
            ]);
        }
                

        try {
            $result_apr_acc = $obj_gateway_customer->upsert($params_upt_acc);
            if($usingPayPortal == "chargify") {
                $product_handle = $prod_handle;
                $product_name = $prodName;
            }
            if($usingPayPortal == "stripe") {
                $plan_id = $plan_id;
                $plan_name = $planName;
            }
            $product_coupon_code = $coupon_code;
            $product_coupon_name = $couponName;
            $product_component_quantity = $comp_quantity;
            if($changes != null) {
                $result_add_log = $obj_gateway_log->upsert($params_add_log);
            }
            if($bill_address_2 == "null") {
                $bill_address_2 = null;
            }
            $result_db_logs = $obj_gateway_log->fetchAll("SELECT * FROM log");

            try {

                $all_logs = $result_db_logs;

                //prime phone number - customer number
                if($phone != null) {
                    $num_arr = array_map('intval', str_split($phone));
                    $fin_num = array();
                    array_push($fin_num, $num_arr[0].'-');
                    $i = 1;
                    while($i < 4){
                      array_push($fin_num, $num_arr[$i]);
                      $i++;
                    }
                    array_push($fin_num, '-');
                    $j = 4;
                    while($j < 7){
                      array_push($fin_num, $num_arr[$j]);
                      $j++;
                    }
                    array_push($fin_num, '-');
                    $k = 7;
                    while($k < 11){
                      array_push($fin_num, $num_arr[$k]);
                      $k++;
                    }
                    $phone = implode("",$fin_num);
                }

                //office number - business phone number
                $num_arr1 = array_map('intval', str_split($office_phone));
                $fin_num1 = array();
                array_push($fin_num1, $num_arr1[0].'-');
                $i = 1;
                while($i < 4){
                  array_push($fin_num1, $num_arr1[$i]);
                  $i++;
                }
                array_push($fin_num1, '-');
                $j = 4;
                while($j < 7){
                  array_push($fin_num1, $num_arr1[$j]);
                  $j++;
                }
                array_push($fin_num1, '-');
                $k = 7;
                while($k < 11){
                  array_push($fin_num1, $num_arr1[$k]);
                  $k++;
                }
                $office_phone = implode("",$fin_num1);

            } catch (Exception $e) {
                echo "Unable to scan LOGS:\n";
                echo $e->getMessage() . "\n";
            }
        } catch (Exception $e) {
            echo "Unable to update item:\n";
            echo $e->getMessage() . "\n";
        }
    }

        if($cust_status == "trialing") {
        ?><style>
            .cust_id {
                color: #A261B1;
            }
        </style><?php
        } elseif($cust_status == "active") {
        ?><style>
            .cust_id {
                color: #26B68E;
            }
        </style><?php
        } elseif($cust_status == "past_due") {
        ?><style>
            .cust_id {
                color: #E05A19;
            }
        </style><?php
        } elseif($cust_status == "unpaid") {
        ?><style>
            .cust_id {
                color: #C63C33;
            }
        </style><?php
        } elseif($cust_status == "canceled") {
        ?><style>
            .cust_id {
                color: #323232;
            }
        </style><?php
        } else {
        ?><style>
            .cust_id {
                color: #EAE17F;
            }
        </style><?php
        }

/*COMMENTED UPT PROV FOR A WHILE
    if(isset($_POST['upd_prov'])) {
        $business_name = stripslashes($_POST['bname']);
        $cancelled = $_POST['cancel'];
        if($cancelled == "yes") {
            $cancel_reason = $_POST['cancel_reason'];
        } else {
            $cancel_reason = "";
        }
        //$bill_d1 = $_POST['bill-d1'];
        //$bill_d2 = $_POST['bill-d2'];
        //$bill_d3 = $_POST['bill-d3'];
        $business_category = $_POST['b-category'];
        $business_website = $_POST['b-site'];
        $business_email = $_POST['b_email'];
        $gmail_acc = $_POST['b-gmail'];
        $keywords = $_POST['k-words'];
        $business_address = $_POST['b-address1'];
        $business_address_2 = $_POST['b-address2'];
        $business_post_address = $_POST['b-post-address'];
        $business_city = $_POST['b-city'];
        $business_state = $_POST['b-state'];
        $business_zip = $_POST['b-zip'];
        $business_country = $_POST['b-country'];
        $business_hours = $_POST['b-hours'];
        $payment_method = $_POST['payment'];
        $sp_request = $_POST['request'];
        $business_phone = $_POST['b-phone'];
        $business_alt_phone = $_POST['b-alt-phone'];
        $social1 = $_POST['b-social1'];
        $social2 = $_POST['b-social2'];
        $biglo_site = $_POST['biglo-site'];
        $analytical_address = $_POST['analyt-add'];
        $google_plus = $_POST['gplus'];
        $google_maps = $_POST['gmap'];
        $facebook = $_POST['fb'];
        $foursquare = $_POST['foursq'];
        $twitter = $_POST['twit'];
        $linkedin = $_POST['linkedin'];

        $test = true;
        $customer = new ChargifyCustomer(NULL, $test);
        $subscription = new ChargifySubscription(NULL, $test);

        try {
            $res_get_sub_id = $subscription->getByCustomerID($chargifyID);
        } catch (ChargifyValidationException $cve) {
            echo $cve->getMessage();
        }

        $customer->id = $chargifyID;
        $customer->organization = $business_name;/*
        $subscription->id = $res_get_sub_id[0]->id;
        $subscription->new_bill_date = $bill_d3."-".$bill_d1."-".$bill_d2;

        try {
            $result_upd_cus = $customer->update();
            $result_upd_billing = $subscription->updateNextBilling();
        } catch (ChargifyValidationException $cve) {
            echo $cve->getMessage();
        }*/

        /*
        if($cancelled == "yes") {
            $subscription_cancel = new ChargifySubscription(NULL, $test);
            $subscription_cancel->id = $res_get_sub_id[0]->id;
            $subscription_cancel->cancellation_message = $cancel_reason;
            $subscription_cancel->cancel();
        }
        */
        /*
        try {
            $doc = $client_customers->getDoc($customer_db_id);
        } catch (Exception $e) {
            echo "ERROR: ".$e->getMessage()." (".$e->getCode().")<br>\n";
        }

        $doc->business_name = @$business_name;
        $doc->cancelled = @$cancelled;
        $doc->cancel_reason = @$cancel_reason;
        $doc->business_category = @$business_category;
        $doc->business_website = @$business_website;
        $doc->business_email = @$business_email;
        $doc->prov_gmail = @$gmail_acc;
        $doc->prov_keywords = @$keywords;
        $doc->business_address = @$business_address;
        $doc->business_suite_no = @$business_address_2;
        $doc->business_post_address = @$business_post_address;
        $doc->business_city = @$business_city;
        $doc->business_state = @$business_state;
        $doc->business_zip = @$business_zip;
        $doc->business_country = @$business_country;
        $doc->business_hours = @$business_hours;
        $doc->payment_method = @$payment_method;
        $doc->prov_special_request = @$sp_request;
        $doc->business_phone = @$business_phone;
        $doc->business_alternate_phone_no = @$business_alt_phone;
        $doc->prov_existing_social1 = @$social1;
        $doc->prov_existing_social2 = @$social2;
        $doc->prov_biglo_website = @$biglo_site;
        $doc->prov_analytical_address = @$analytical_address;
        $doc->prov_google_plus = @$google_plus;
        $doc->prov_google_maps = @$google_maps;
        $doc->prov_facebook = @$facebook;
        $doc->prov_foursquare = @$foursquare;
        $doc->prov_twitter = @$twitter;
        $doc->prov_linkedin = @$linkedin;

        try {
            $client_customers->storeDoc($doc);
        } catch (Exception $e) {
            echo "ERROR: ".$e->getMessage()." (".$e->getCode().")<br>\n";
        }
    }
    */

/*COMMENTED UPT BILL FOR A WHILE
    if(isset($_POST['upd_bill'])) {
        echo $processor_id = $_POST['ppID']; echo "<br/>";
        echo $bill_state = $_POST['bill_stat']; echo "<br/>";
        echo $bill_cycle = $_POST['bill_cycle']; echo "<br/>";
        echo $bill_d1 = $_POST['bill-d1']; echo "<br/>";
        echo $bill_d2 = $_POST['bill-d2']; echo "<br/>";
        echo $bill_d3 = $_POST['bill-d3']; echo "<br/>";
        echo $bill_prod = $_POST['product']; echo "<br/>";
        echo $bill_comp_quan = $_POST['comp_quantity']; echo "<br/>";
        echo $bill_coup = $_POST['coupon']; echo "<br/>";
        echo $bill_ccnumber = $_POST['ccnumber']; echo "<br/>";
        echo $bill_ccexpm = $_POST['ccexpm']; echo "<br/>";
        echo $bill_ccexpy = $_POST['ccexpy']; echo "<br/>";
        echo $bill_add = $_POST['bill_address']; echo "<br/>";
        echo $bill_city = $_POST['bill_city']; echo "<br/>";
        echo $bill_state = $_POST['bill_state']; echo "<br/>";
        echo $bill_zip = $_POST['bill_zip']; echo "<br/>";
        echo $bill_country = $_POST['bill_country']; echo "<br/>";

        $test = true;
        //$customer = new ChargifyCustomer(NULL, $test);
        $subscription = new ChargifySubscription(NULL, $test);

        try {
            $res_get_sub_id = $subscription->getByCustomerID($chargifyID);
        } catch (ChargifyValidationException $cve) {
            echo $cve->getMessage();
        }

        //$customer->id = $chargifyID;
        //$customer->organization = $business_name;
        $subscription->id = $res_get_sub_id[0]->id;
        $subscription->new_bill_date = $bill_d3."-".$bill_d1."-".$bill_d2;

        try {
            //$result_upd_cus = $customer->update();
            $result_upd_billing = $subscription->updateNextBilling();
        } catch (ChargifyValidationException $cve) {
            echo $cve->getMessage();
        }

        try {
            $doc = $client_customers->getDoc($customer_db_id);
        } catch (Exception $e) {
            echo "ERROR: ".$e->getMessage()." (".$e->getCode().")<br>\n";
        }

        $doc->business_name = @$business_name;

    }
    */
/*
    if(isset($_GET['id'])) {
        $test = true;
        $subscription = new ChargifySubscription(NULL, $test);

        try {
            $result_customer_id_search = $subscription->getByCustomerID($chargifyID);
        } catch (ChargifyValidationException $cve) {
            echo $cve->getMessage();
        }

        $billing_sum = "$".number_format(($result_customer_id_search[0]->total_revenue_in_cents /100), 2, '.', ' ');
        $fin = explode('T',$result_customer_id_search[0]->updated_at,-1);
        $fin2 = explode('-',$fin[0]);
        $char_upd_at = $fin2[1].".".$fin2[2].".".$fin2[0];

        if($result_customer_id_search[0]->state == "trialing") {
            $trial_date = explode('T',$result_customer_id_search[0]->trial_ended_at,-1);
            $state_date = explode('-',$trial_date[0]);
            $state_date_fin = $state_date[1]."/".$state_date[2]."/".$state_date[0];
            $cust_search_state = "Trial End: ";
        } elseif($result_customer_id_search[0]->state == "active") {
            $billing_date = explode('T',$result_customer_id_search[0]->next_assessment_at,-1);
            $state_date = explode('-',$billing_date[0]);
            $state_date_fin = $state_date[1]."/".$state_date[2]."/".$state_date[0];
            $cust_search_state = "Next Billing: ";
        } else {
            $cancel_date = explode('T',$result_customer_id_search[0]->canceled_at,-1);
            $state_date = explode('-',$cancel_date[0]);
            $state_date_fin = $state_date[1]."/".$state_date[2]."/".$state_date[0];
            $cust_search_state = "Cancelled At: ";
        }

        if($result_customer_id_search[0]->state == "trialing") {
        ?><style>
            .cust_id {
                color: #b300b3;
            }
        </style><?php
        } elseif($result_customer_id_search[0]->state == "active") {
        ?><style>
            .cust_id {
                color: #28B22C;
            }
        </style><?php
        } elseif($result_customer_id_search[0]->state == "past_due") {
        ?><style>
            .cust_id {
                color: #e6e600;
            }
        </style><?php
        } elseif($result_customer_id_search[0]->state == "unpaid") {
        ?><style>
            .cust_id {
                color: #ff0000;
            }
        </style><?php
        } elseif($result_customer_id_search[0]->state == "canceled") {
        ?><style>
            .cust_id {
                color: #000000;
            }
        </style><?php
        } else {
        ?><style>
            .cust_id {
                color: #cccccc;
            }
        </style><?php
        }
    }
*/

//-------ADMIN
//COMMENTED ADMIN FUNCTIONS FOR A WHILE
//@$all_users = $client_users->getView('users','viewAll');
//@$all_tickets = $client_tickets->getView('tickets','viewAll');
//@$all_logs = $client_logs->getView('logs','viewAll');
  
if(@$_POST['submit_user'])
{
  if(@$_GET['user_id']){
    $params = $obj_gateway_user->fetchById(@$_GET['user_id']);
    $params->email="".$_POST['email']."";
    $params->password="".$_POST['pass']."";
    $params->userType="".$_POST['type']."";
    $params->user_first_name="".$_POST['fname']."";
    $params->user_last_name="".$_POST['lname']."";
    
    try {
        $result = $obj_gateway_user->upsert($params);
        ?>
        <script type="text/javascript">
            document.getElementById('home').click();
        </script>
      <?php

    } catch (Exception $e) {
        echo "Unable to update item:\n";
        echo $e->getMessage() . "\n";
    }

  }else{
    $params = $obj_gateway_user->createEntity([
            "email"=> "".$_POST['email']."",
            "password"=> "".$_POST['pass']."",
            "status"=> "active",
            "userType"=> "".$_POST['type']."",
            "user_first_name"=> "".$_POST['fname']."",
            "user_last_name"=> "".$_POST['lname'].""
    ]);

    try {
        $result = $obj_gateway_user->upsert($params);
        ?>
        <script type="text/javascript">
            document.getElementById('home').click();
        </script>
      <?php

    } catch (Exception $e) {
        echo "Unable to add item:\n";
        echo $e->getMessage() . "\n";
    }
  }
}
if(@$_GET['action'] == "edit"){
    try {
        $result = $obj_gateway_user->fetchById($_GET['user_id']);
        $user_fname =  $result->user_first_name;
        $user_lname =  $result->user_last_name;
        $user_email =  $result->email;
        $userType =  $result->userType;

    } catch (Exception $e) {
        echo "Unable to get item:\n";
        echo $e->getMessage() . "\n";
    }
}

if(@$_GET['action'] == "delete"){
    $params = $obj_gateway_user->fetchById($_GET['user_id']);
    try {
        $result = $obj_gateway_user->delete($params);

    } catch (Exception $e) {
        echo "Unable to delete item:\n";
        echo $e->getMessage() . "\n";
    }
}  
if(@$_GET['action'] == "status"){
    $result_get = $obj_gateway_user->fetchById($_GET['user_id']);
    try {
        $status =  $result_get->status;

    } catch (Exception $e) {
        echo "Unable to get item:\n";
        echo $e->getMessage() . "\n";
    }

    $key_stat = $marshaler->marshalJson('
        {
            "user_id": "'.@$_GET['user_id'].'"
        }
    ');

    if($status == "active"){
     $stat_now = "not active";
    }else{
      $stat_now = "active";
    }
    $result_get->status= "".$stat_now."";
    
    try {
        $result = $obj_gateway_user->upsert($result_get);
        ?>
        
      <?php

    } catch (Exception $e) {
        echo "Unable to update item:\n";
        echo $e->getMessage() . "\n";
    }
}
/* <----------remove this
    // Your Account Sid and Auth Token from twilio.com/user/account
    $sid = $sid;
    $token = $token;
    $client = new Client($sid, $token);
    $strip_phone = str_replace("-", "", $phone);
    $phone_num = "+"."$strip_phone";
    $from = "+15005550006";
    //+12565988804
    /*
    $number = $client->incomingPhoneNumbers->create(
        array(
            "voiceUrl" => "http://demo.twilio.com/docs/voice.xml",
            "phoneNumber" => "+15005550006"
        )
    );
    echo $number->sid;
    */
//*<------------remove this

    if(@$_POST['call']) {
        try {
            $call = $client->calls->create(
                "$phone_num", "$from",
                array("url" => "http://demo.twilio.com/docs/voice.xml")
            );
                ?>
                    <script type="text/javascript">
                        alert("Connected.<?=$phone_num?>");
                    </script>
                <?php
        } catch(Exception $e) {
                ?>
                    <script type="text/javascript">
                        alert("Failed to connect. <?=$phone_num?>");
                    </script>
                <?php
        }    
    }
    //==========TWILIO END===============

    /*** end most functions in customer.php ***/

