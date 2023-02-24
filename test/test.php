<?php

require_once __dir__.'/../vendor/autoload.php';

$api_key = "test_123";
$api_secret = "secret_123";

$paytring = new  \Paytring\Php\Api($api_key, $api_secret);

$response = $paytring->CreateOrder(100, 'TXN974923', 'https://httpbin.org/post', [
    'name' => 'John Doe',
    'email' => 'a@mcsam.in',
    'phone' => '9234567890',    
],[
    "firstname" => "BillingFirstname", 
   "lastname" => "BillingLastname", 
   "phone" => "09999999999", 
   "line1" => "Billing Address Line 1", 
   "line2" => "Billing Address Line 2", 
   "city" => "Gurugram", 
   "state" => "Haryana", 
   "country" => "India", 
   "zipcode" => "122001" 
],[
    "firstname" => "ShippingFirstname", 
   "lastname" => "ShippingLastname", 
   "phone" => "09999999999", 
   "line1" => "Shipping Address Line 1", 
   "line2" => "Shipping Address Line 2", 
   "city" => "Gurugram", 
   "state" => "Haryana", 
   "country" => "India", 
   "zipcode" => "122001" 
],[
    "udf1" => "udf1", 
    "udf2" => "udf2",
    "udf3" => "udf3",
    "udf4" => "udf4",
    "udf5" => "udf5",
    "udf6" => "udf6",
    "udf7" => "udf7",
    "udf8" => "udf8",
    "udf9" => "udf9",
    "udf10" => "udf10",
]);

$PaymentResponse = json_decode($response);

if($PaymentResponse->status == false){
    if(isset($PaymentResponse->error->message)){
        die($PaymentResponse->error->message);
    }
    die('Error: '.$PaymentResponse->exception->message);
}

$fetchResponse = $paytring->FetchOrder($PaymentResponse->order_id);

var_dump($fetchResponse);