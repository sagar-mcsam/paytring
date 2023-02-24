<?php

namespace Paytring\Php;

class Api
{

    protected $key;
    protected $secret;

    protected $endpoint = "https://api.paytring.com/api/";
    protected $version = "v1";

    protected $api = null;

    public function __construct($api_key, $api_secret)
    {
        $this->key = $api_key;
        $this->secret = $api_secret;

        $this->api = $this->endpoint . $this->version . '/';
    }

    public function CreateOrder($amount, $txnID, $callbackUrl, $customer, $billingAddress = [], $shippingAddress = [], $notes = [])
    {

        self::CustomerValidation($customer);

        $body = [
            'key' => $this->key,
            'amount' => $amount,
            'callback_url' => $callbackUrl,
            'receipt_id' => $txnID,
            'cname' => $customer['name'],
            'email' => $customer['email'],
            'phone' => $customer['phone'],
        ];

        if(count($billingAddress)){
            $body['billing_address'] = $billingAddress;
        }

        if(count($shippingAddress)){
            $body['shipping_address'] = $shippingAddress;
        }

        if(count($notes)){
            $body['notes'] = $notes;
        }

        
        $body['hash'] = $this->createHash($body);

        return $this->POST( $this->api.'order/create', $body );
    }

    public function FetchOrder($id)
    {

        $body = [
            'id' => $id,
            'key' => $this->key,
        ];

        $body['hash'] = $this->createHash($body);

        return $this->POST( $this->api.'order/fetch', $body );
    }

    public function createHash($params){
        
        if(!is_array($params)){
            throw new \Exception("Params must be an array");
        }
        ksort($params);

        foreach ($params as $key => $value) {
            if(is_array($value)){
                unset($params[$key]);
            }
        }

        return hash('sha512',implode('|', $params)  .'|'. $this->secret);
        
    }

    private function POST($uri, $body)
    {
        $body = json_encode($body);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Invalid UTF-8");
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $uri,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        
        return $response;
    }

    private static function CustomerValidation($customer){
        if (!isset($customer['name'])) {
            throw new \Exception("Customer name is required");
        }

        if (!isset($customer['email'])) {
            throw new \Exception("Customer email is required");
        }

        if (!isset($customer['phone'])) {
            throw new \Exception("Customer phone is required");
        }
    }
}
