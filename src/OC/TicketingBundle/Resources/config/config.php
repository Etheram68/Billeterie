<?php
namespace OC\TicketingBundle\config;

require_once('vendor/autoload.php');

$stripe = array(
    "secret_key"       =>  "sk_test_5Gt4c4qjUq2zAN7swepRgwat",
    "publishable_key"  =>  "pk_test_erK5taHwMMWiA47iTpnZ369Z"
);
\Stripe\Stripe::setApiKey($stripe['secret_key']);