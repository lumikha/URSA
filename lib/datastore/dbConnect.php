<?php
ini_set('max_execution_time', 0); //300 seconds = 5 minutes
/**
 * GDS Example - Create one record, with no Schema
 *
 * @author Tom Walder <twalder@gmail.com>
 */
date_default_timezone_set("Asia/Manila");
//require_once('apiclient/vendor/autoload.php');
require_once('../app/apiclient/vendor/autoload.php');
require_once('lib/google/php-gds/src/GDS/Entity.php');
require_once('lib/google/php-gds/src/GDS/Schema.php');
require_once('lib/google/php-gds/src/GDS/Store.php');
require_once('lib/google/php-gds/src/GDS/Gateway.php');
require_once('lib/google/php-gds/src/GDS/Mapper.php');
require_once('lib/google/php-gds/src/GDS/Gateway/RESTv1.php');
require_once('lib/google/php-gds/src/GDS/Mapper/RESTv1.php');
require_once('lib/google/php-gds/src/GDS/Mapper/ProtoBuf.php');
require_once('lib/google/php-gds/src/GDS/Mapper/ProtoBufGQLParser.php');
require_once('lib/google/php-gds/src/GDS/Exception/GQL.php');

// This Store uses the default Protocol Buffer Gateway - for App Engine local development or live App Engine
//$obj_store = new \GDS\Store('user');

// Alternative Gateway (remote JSON API)
// Download your service JSON file from the Google Developer Console
putenv('GOOGLE_APPLICATION_CREDENTIALS=../secret/secret.json');
$obj_gateway = new GDS\Store('user', new \GDS\Gateway\RESTv1('fluid-dreamer-152802'));
$obj_gateway_customer = new GDS\Store('customer', new \GDS\Gateway\RESTv1('fluid-dreamer-152802'));
$obj_gateway_user = new GDS\Store('user', new \GDS\Gateway\RESTv1('fluid-dreamer-152802'));
$obj_gateway_ticket = new GDS\Store('ticket', new \GDS\Gateway\RESTv1('fluid-dreamer-152802'));
$obj_gateway_note = new GDS\Store('note', new \GDS\Gateway\RESTv1('fluid-dreamer-152802'));
$obj_gateway_log = new GDS\Store('log', new \GDS\Gateway\RESTv1('fluid-dreamer-152802'));