# PHP SDK

Supported Features

- Only Non Seamless Integration Api SUpported
- Create Order
- Fetch/Verify Order

## Non Seamless

    This sdk only supports non seamless integration, by non seamless we mean the the use will alway need to redirect the ens user to payment gateways where he'll select his preferred payment method and complete payment.

## Create Order

```php

$api_key = "test_123";
$api_secret = "secret_123";

$paytring = new  \Paytring\Php\Api($api_key, $api_secret);

$amount_in_paisa  = "100";
$receipt_number  = "10123450";
$merchant_callback_Url  = "http://localhost:8000/callback";

$customer_info = [
    'name' => 'John Doe',
    'email' => 'a@mcsam.in',
    'phone' => '9234567890',    
];

$response = $paytring->CreateOrder( 
        $amount_in_paisa,
        $receipt_number, 
        $merchant_callback_Url, 
        $customer_info
    );

var_dump($response);
```

CreateOrder method ask you to provide below listened info and wont proceed without it.

- Amount in paisa eg. for Rs.1 == 100
- Receipt Number eg. 100d12 # this is merchant order ref no
- Merchant Callback url , this is were pg will redirect user after payment complete(success/failure) in post request.
- CUstomer Info eg. Name, Email and Phone


## Fetch Order

```php

$api_key = "test_123";
$api_secret = "secret_123";

$paytring = new  \Paytring\Php\Api($api_key, $api_secret);

$pg_order_id  = "d234ew32r4345fd";

$fetchResponse = $paytring->FetchOrder($pg_order_id);

var_dump($fetchResponse);

```

Fetch Order method ask you to provide below listened info and wont proceed without it.

- PG Order Id, when you create a order pg will give you an order if you can pass the same to this function to get info like payment status and more about that here. 