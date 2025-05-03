<?php
  require_once('stripe/init.php');

  $token  = $_POST['stripeToken'];

  $customer = \Stripe\Customer::create(array(
      'email' => 'customer@example.com',
      'source'  => $token
  ));

$charge=\Stripe\Charge::create(array( 
    'customer' => $customer->id, 
    'amount' => ($_POST['amount']*100),
    'currency' => 'usd' 
    )); 

  echo '<h1>Successfully charged $50.00!</h1>';
?>