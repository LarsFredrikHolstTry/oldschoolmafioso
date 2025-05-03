<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} else {

    
$point_name[0] = "50 poeng";
$point_name[1] = "150 poeng";
$point_name[2] = "355 poeng";
    
$point_amount[0] = 50;
$point_amount[1] = 150;
$point_amount[2] = 355;

$point_price[0] = "50";
$point_price[1] = "70";
$point_price[2] = "100";
    
$price_stripe[0] = 10000;
$price_stripe[1] = 7000;
$price_stripe[2] = 5000;

$point_image[0] = 'background-image: url("img/point/0.png")';
$point_image[1] = 'background-image: url("img/point/1.png")';
$point_image[2] = 'background-image: url("img/point/2.png")';
    
$point_goods[0] =           "Nullstill bunker ventetid.";
$point_goods_price[0] =     5;
    
$point_goods[1] =           "Nullstill Heist ventetid.";
$point_goods_price[1] =     25;
    
$point_goods[2] =           "Happy hour i 1 time for alle.";
$point_goods_price[2] =     75;
    
$point_goods[3] =           "Bytte nick.";
$point_goods_price[3] =     100;
    
$point_goods[4] =           "Restart flyplass ventetid";
$point_goods_price[4] =     5;
    
$point_goods[5] =           "Kjøp full beskyttelse for garasje";
$point_goods_price[5] =     65;
    
$point_goods[6] =           "12 gpu på crypto farm";
$point_goods_price[6] =     290;
    
$point_goods[7] =           "Hopp over oppdrag";
$point_goods_price[7] =     15;
    
$point_goods[8] =           "Kjøp 100 kuler";
$point_goods_price[8] =     35;
    
    if(isset($_POST['0'])){          
        
            require_once('stripe/init.php');
            // Set your secret key: remember to change this to your live secret key in production
            // See your keys here: https://dashboard.stripe.com/account/apikeys
            \Stripe\Stripe::setApiKey('sk_test_GHxvFFxnD2EtfTtQRqwyYkNy00Mi1oc331');

            $intent = \Stripe\PaymentIntent::create([
                'amount' => 1099,
                'currency' => 'nok',
            ]);

        
    }

?>
<!-- CONTENT -->
<html>
    <head> <script src="https://js.stripe.com/v3/"></script>
        <script>
        
        var stripe = Stripe('pk_test_sGWuWqO4QUnwMHbgO9ERhc2i00Nnmj07eB');
        var elements = stripe.elements();
        
var style = {
  base: {
    color: "#32325d",
  }
};

var card = elements.create("card", { style: style });
card.mount("#card-element");
            
card.addEventListener('change', ({error}) => {
  const displayError = document.getElementById('card-errors');
  if (error) {
    displayError.textContent = error.message;
  } else {
    displayError.textContent = '';
  }
});
            
var submitButton = document.getElementById('submit');

submitButton.addEventListener('click', function(ev) {
  stripe.confirmCardPayment(clientSecret, {
    payment_method: {
      card: card,
      billing_details: {
        name: 'Jenny Rosen'
      }
    }
  }).then(function(result) {
    if (result.error) {
      // Show error to your customer (e.g., insufficient funds)
      console.log(result.error.message);
    } else {
      // The payment has been processed!
      if (result.paymentIntent.status === 'succeeded') {
        // Show a success message to your customer
        // There's a risk of the customer closing the window before callback
        // execution. Set up a webhook or plugin to listen for the
        // payment_intent.succeeded event that handles any business critical
        // post-payment actions.
      }
    }
  });
});
            
        </script>
        
        
    </head>
    <body>
        <div class="breadcrumb">
            <span style="color: #afafaf;">Poeng</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <div class="content">
            <div class="header">
                <span>Poeng</span>
            </div>
            <p style="padding: 0 10px; text-align: center;">Poeng kan kjøpes for penger. Betaling skjer med bankkort. <br>Vilkår skal alltid leses før det foretas ett kjøp.</p>
            <div class="role_container">
<div id="card-errors" role="alert"></div>
                
                <form method="post">
                <?php for($i = 0; $i < 3; $i++){ ?>

                <button id="submit card-element" name="<?php echo $i ?>" type="submit"> 
                    <div class="role_<?php echo $i ?>">
                        <style>
                            
                        .role_<?php echo $i ?> {
                            position: relative;
                            width: 160px;
                            height: 208px;
                            margin: 5px;
                            float: left;
                            display: inline-block;
                             transition: 0.3s;
                            border: 1px solid #2c2c2c;
                        }
                            
                        .role_<?php echo $i ?> {
                            <?php echo $point_image[$i] ?>
                        }

                        .role_<?php echo $i ?>:hover {
                            <?php echo $point_image[$i] ?>
                        }
                        </style>
                        <div class="header">
                            <span><?php echo $point_name[$i] ?></span>
                        </div>
                        <div class="role_footer">
                            <p style="margin: 0; padding: 5px">
                                <center><b>Pris: </b><?php echo number($point_price[$i]); ?> NOK</center>
                            </p>
                        </div>
                    </div>
                </button>
                <?php } ?>
                </form>
            </div>
            <center>Løs inn poengkode: <input style="width: 20%;" type="text"><input style="width: auto;" type="submit" value="Innløs"></center>
            <br>
            <div class="header">
                <span>Poenghandel</span>
            </div>
            
        <form method="POST" action="">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr style="height: 30px;">
                    <th style="padding-left: 10px; width: 30%">Beskrivelse</th>
                    <th style="width: 20%">Pris</th>
                    <th style="width: 10%"></th>
                </tr>
                <?php for($i = 0; $i < count($point_goods); $i++){
                    ?>
                <tr>
                    <td style="height: 30px; padding-left: 10px;"><?php echo $point_goods[$i] ?></td>
                    <td><?php echo number($point_goods_price[$i]) ?> poeng</td>
                    <td>
                        <label class="radio_container" style="margin-top: -12px;">
                            <input type="radio" name='radioBtn' value="<?php echo $i ?>" required>
                            <span class="checkmark"></span>
                        </label>
                    </td>
                </tr>
                <?php } ?>
            </table>
            <input style="width: 97%;" type="submit" name="submit" value="Kjøp">
        </form>
        </div>
    </body>
</html>
<?php 

}

?>
























<!DOCTYPE html>
<!--  This site was created in Webflow. http://www.webflow.com  -->
<!--  Last Published: Sun Nov 12 2017 20:47:18 GMT+0000 (UTC)  -->
<html>
<head>

<script
  src="https://code.jquery.com/jquery-2.1.3.js"
  integrity="sha256-goy7ystDD5xbXSf+kwL4eV6zOPJCEBD1FBiCElIm+U8="
  crossorigin="anonymous"></script>
  
<script src="https://checkout.stripe.com/checkout.js"></script>

</head>
<body>
    
    
<form id="myForm" action="charge.php" method="POST">
  <input type="number" id="amount" name="amount" />
  <input type="hidden" id="stripeToken" name="stripeToken" />
  <input type="hidden" id="stripeEmail" name="stripeEmail" />
</form>

<input type="button" id="customButton" value="Pay">

<script>

    var handler = StripeCheckout.configure({
  key: 'pk_test_sGWuWqO4QUnwMHbgO9ERhc2i00Nnmj07eB',
  image: 'https://stripe.com/img/documentation/checkout/marketplace.png',
  token: function(token) {
    $("#stripeToken").val(token.id);
    $("#stripeEmail").val(token.email);
    $("#myForm").submit();
  }
});

$('#customButton').on('click', function(e) {
  var amount = $("#amount").val() * 100;
  var displayAmount = parseFloat(Math.floor($("#amount").val() * 100) / 100).toFixed(2);
  // Open Checkout with further options
  handler.open({
    name: 'Demo Site',
    description: 'Custom amount ($' + displayAmount + ')',
    amount: amount
  });
  e.preventDefault();
});

// Close Checkout on page navigation
$(window).on('popstate', function() {
  handler.close();
});
</script>


  <!-- [if lte IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif] -->
</body>
</html>