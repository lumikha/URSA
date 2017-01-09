<?php
/**
 * GDS Example - Create one record, with no Schema
 *
 * @author Tom Walder <twalder@gmail.com>
 */
date_default_timezone_set("Asia/Manila");
//require_once('apiclient/vendor/autoload.php');
require_once('../../../app/apiclient/vendor/autoload.php');
require_once('../google/php-gds/src/GDS/Entity.php');
require_once('../google/php-gds/src/GDS/Schema.php');
require_once('../google/php-gds/src/GDS/Store.php');
require_once('../google/php-gds/src/GDS/Gateway.php');
require_once('../google/php-gds/src/GDS/Mapper.php');
require_once('../google/php-gds/src/GDS/Gateway/RESTv1.php');
require_once('../google/php-gds/src/GDS/Mapper/RESTv1.php');
require_once('../google/php-gds/src/GDS/Mapper/ProtoBuf.php');
require_once('../google/php-gds/src/GDS/Mapper/ProtoBufGQLParser.php');
require_once('../google/php-gds/src/GDS/Exception/GQL.php');

// This Store uses the default Protocol Buffer Gateway - for App Engine local development or live App Engine
//$obj_store = new \GDS\Store('user');

// Alternative Gateway (remote JSON API)
// Download your service JSON file from the Google Developer Console
putenv('GOOGLE_APPLICATION_CREDENTIALS=../../../secret/secret.json');
$obj_gateway_customer = new GDS\Store('customer', new \GDS\Gateway\RESTv1('fluid-dreamer-152802'));

$result_db_customers = $obj_gateway_customer->fetchAll("SELECT * FROM customer");
/*
$params2 = [
    'TableName' => 'ursa-customers',
    'ProjectionExpression' => 'customer_id,customer_first_name,customer_last_name,chargify_id,
        business_email,business_name,keywords
        '
];
*/
$result = array();
foreach ($result_db_customers as $obj_model) {
        $data = array(
                   'customer_id'    =>   $obj_model->getKeyId(),
                   'customer_first_name'  =>  $obj_model->customer_first_name,
                   'customer_last_name'  =>  $obj_model->customer_last_name,
                   'chargify_id'  =>  $obj_model->chargify_id,
                   'business_email'  =>  $obj_model->business_email,
                   'business_name'  =>  $obj_model->business_name,
                   'keywords'  =>  $obj_model->keywords
         );
         array_push($result,$data);
    }

print_r(json_encode($result));
?>