<title>Setup Stripe</title>
<?php
	require_once('init.php');

	\Stripe\Stripe::setApiKey('sk_test_T8cInYaDaLdip8ZpmtPzaq9B');

	/** Plan 1 **/
	$plan1 = \Stripe\Plan::create(array(
		"amount" => 599,
		"interval" => "month",
		"name" => "URSA Basic Plan",
		"currency" => "usd",
		"id" => "ursa_basic_plan",
		"trial_period_days" => 14
	));

	//$unprotected_response_object = json_decode(json_encode($plan1), true);
	echo "URSA <b>Basic Plan</b> created";
	echo "<br/><br/>";

	/** Plan 2 **/
	$plan2 = \Stripe\Plan::create(array(
		"amount" => 1999,
		"interval" => "month",
		"name" => "URSA Start-up Plan",
		"currency" => "usd",
		"id" => "ursa_startup_plan",
		"trial_period_days" => 14
	));

	//$unprotected_response_object = json_decode(json_encode($plan2), true);
	echo "URSA <b>Start-up Plan</b> created";
	echo "<br/><br/>";

	/** Plan 3 **/
	$plan3 = \Stripe\Plan::create(array(
		"amount" => 1999,
		"interval" => "month",
		"name" => "URSA Upgrade to Start-up Plan",
		"currency" => "usd",
		"id" => "ursa_upgrade_to_startup_plan"
	));

	//$unprotected_response_object = json_decode(json_encode($plan3), true);
	echo "URSA <b>Upgrade to Start-up Plan</b> created";
	echo "<br/><br/>";

	/** Plan 4 **/
	$plan4 = \Stripe\Plan::create(array(
		"amount" => 7999,
		"interval" => "month",
		"name" => "URSA Business Plan",
		"currency" => "usd",
		"id" => "ursa_business_plan",
		"trial_period_days" => 14
	));

	//$unprotected_response_object = json_decode(json_encode($plan4), true);
	echo "URSA <b>Business Plan</b> created";
	echo "<br/><br/>";

	/** Plan 5 **/
	$plan5 = \Stripe\Plan::create(array(
		"amount" => 7999,
		"interval" => "month",
		"name" => "URSA Upgrade to Business Plan",
		"currency" => "usd",
		"id" => "ursa_upgrade_to_business_plan"
	));

	//$unprotected_response_object = json_decode(json_encode($plan5), true);
	echo "URSA <b>Upgrade to Business Plan</b> created";
	echo "<br/><br/>";

	/** Plan 6 **/
	$plan6 = \Stripe\Plan::create(array(
		"amount" => 39900,
		"interval" => "month",
		"name" => "URSA Enterprise Plan",
		"currency" => "usd",
		"id" => "ursa_enterprise_plan",
		"trial_period_days" => 14
	));

	//$unprotected_response_object = json_decode(json_encode($plan6), true);
	echo "URSA <b>Enterprise Plan</b> created";
	echo "<br/><br/>";

	/** Plan 7 **/
	$plan7 = \Stripe\Plan::create(array(
		"amount" => 39900,
		"interval" => "month",
		"name" => "URSA Upgrade to Enterprise Plan",
		"currency" => "usd",
		"id" => "ursa_upgrade_to_enterprise_plan"
	));

	//$unprotected_response_object = json_decode(json_encode($plan7), true);
	echo "URSA <b>Upgrade to Enterprise Plan</b> created";
	echo "<br/><br/>";

	$product = \Stripe\Product::create(array(
		"name" => 'Custom Company Domain',
		"caption" => "Domains",
		"description" => ".com., .co, .net, .org, .me",
		"shippable" => false
	));

	$unprotected_response_object = json_decode(json_encode($product), true);
	$product_id = $unprotected_response_object['id'];
	echo "<b>Custom Company Domain</b> Product created: ".$product_id;
	echo "<br/><br/>";
	$SKU = \Stripe\SKU::create(array(
		"product" => $product_id,
		"price" => 1299,
		"currency" => "usd",
		"inventory" => array(
			"type" => "infinite"
		)
	));

	$unprotected_response_object = json_decode(json_encode($SKU), true);
	echo "<b>SKU</b> created: ".$unprotected_response_object['id'];
	echo "<br/><br/>";

	$coupon1 = \Stripe\Coupon::create(array(
		"percent_off" => 50,
		"duration" => "forever",
  		"id" => "Discount Coupon"
	));

	$unprotected_response_object = json_decode(json_encode($coupon1), true);
	echo "<b>Discount Coupon</b> created";
	echo "<br/><br/>";

	$coupon2 = \Stripe\Coupon::create(array(
		"percent_off" => 100,
		"duration" => "repeating",
		"duration_in_months" => 12,
  		"id" => "Domain Coupon"
	));

	$unprotected_response_object = json_decode(json_encode($coupon2), true);
	echo "<b>Domain Coupon</b> created";
	echo "<br/><br/>";

	$coupon3 = \Stripe\Coupon::create(array(
		"percent_off" => 50,
		"duration" => "forever",
  		"id" => "Referral Coupon"
	));

	$unprotected_response_object = json_decode(json_encode($coupon3), true);
	echo "<b>Referral Coupon</b> created";
	echo "<br/><br/>";
?>