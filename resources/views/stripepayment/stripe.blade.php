<html>
   <head>
      <title>How To Integrate Stripe Payment Gateway In Laravel 8 - Techsolutionstuff</title>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>      
   </head>
   <body>
      <div class="container">         
         <div class="row">
          <h3 style="text-align: center;margin-top: 40px;margin-bottom: 40px;">How To Integrate Stripe Payment Gateway In Laravel 8 - Techsolutionstuff</h3>
            <div class="col-md-6 col-md-offset-3">
               <div class="panel panel-default credit-card-box">
                  <div class="panel-heading" >
                     <div class="row">
                        <h3>Payment Details</h3>                        
                     </div>
                  </div>
                  <div class="panel-body">
                     @if (Session::has('success'))
                     <div class="alert alert-success text-center">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <p>{{ Session::get('success') }}</p><br>
                     </div>
                     @endif
                     <br>
                     <!-- <form role="form" action="{{ route('stripe.post') }}" method="post" class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">
                        @csrf
                        <div class='form-row row'>
                           <div class='col-xs-12 col-md-6 form-group required'>
                              <label class='control-label'>Name on Card</label> 
                              <input class='form-control' size='4' type='text'>
                           </div>
                           <div class='col-xs-12 col-md-6 form-group required'>
                              <label class='control-label'>Card Number</label> 
                              <input autocomplete='off' class='form-control card-number' size='20' type='text'>
                           </div>                           
                        </div>                        
                        <div class='form-row row'>
                           <div class='col-xs-12 col-md-4 form-group cvc required'>
                              <label class='control-label'>CVC</label> 
                              <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4' type='text'>
                           </div>
                           <div class='col-xs-12 col-md-4 form-group expiration required'>
                              <label class='control-label'>Expiration Month</label> 
                              <input class='form-control card-expiry-month' placeholder='MM' size='2' type='text'>
                           </div>
                           <div class='col-xs-12 col-md-4 form-group expiration required'>
                              <label class='control-label'>Expiration Year</label> 
                              <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text'>
                           </div>
                        </div>                     
                        <div class="form-row row">
                           <div class="col-xs-12">
                              <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now</button>
                           </div>
                        </div>
                     </form> -->
                     <div class="card">
                <form action="{{ route('stripe.post') }}" method="post" id="payment-form">
                    @csrf                    
                    <div class="form-group">
                        <div class="card-header">
                            <label for="card-element">
                                Enter your credit card information
                            </label>
                        </div>
                        <div class="card-body">
                            <div id="card-element">
                            <!-- A Stripe Element will be inserted here. -->
                            </div>
                            <!-- Used to display form errors. -->
                            <div id="card-errors" role="alert"></div>
                            <input type="hidden" name="plan" value="{{-- $plan->id --}}" />
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-dark" type="submit">Pay</button>
                    </div>
                </form>
            </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </body>   
</html>
<script type="text/javascript" src="https://js.stripe.com/v3/"></script>
<!-- <script type="text/javascript">
$(function() {
    var $form = $(".require-validation");
    $('form.require-validation').bind('submit', function(e) {
        var $form = $(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]', 'input[type=text]', 'input[type=file]', 'textarea'].join(', '),
        $inputs = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid = true;
        $errorMessage.addClass('hide');
        $('.has-error').removeClass('has-error');
        $inputs.each(function(i, el) {
            var $input = $(el);
            if ($input.val() === '') {
                $input.parent().addClass('has-error');
                $errorMessage.removeClass('hide');
                e.preventDefault();
            }
        });
        if (!$form.data('cc-on-file')) {
          e.preventDefault();
          Stripe.setPublishableKey($form.data('stripe-publishable-key'));
          Stripe.createToken({
              number: $('.card-number').val(),
              cvc: $('.card-cvc').val(),
              exp_month: $('.card-expiry-month').val(),
              exp_year: $('.card-expiry-year').val()
          }, stripeResponseHandler);
        }
    });

    function stripeResponseHandler(status, response) {
        if(response.error) {
            $('.error')
            .removeClass('hide')
            .find('.alert')
            .text(response.error.message);
        }else {
          /* token contains id, last4, and card type */
          var token = response['id'];
          $form.find('input[type=text]').empty();
          $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
          $form.get(0).submit();
        }
    }
});
</script> -->
<script>
    // Create a Stripe client.
var stripe = Stripe('{{ env("STRIPE_KEY") }}');

// Create an instance of Elements.
var elements = stripe.elements();

// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
  base: {
    color: '#32325d',
    lineHeight: '18px',
    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
    fontSmoothing: 'antialiased',
    fontSize: '16px',
    '::placeholder': {
      color: '#aab7c4'
    }
  },
  invalid: {
    color: '#fa755a',
    iconColor: '#fa755a'
  }
};

// Create an instance of the card Element.
var card = elements.create('card', {hidePostalCode: true,style: style});

// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');

// Handle real-time validation errors from the card Element.
card.addEventListener('change', function(event) {
  var displayError = document.getElementById('card-errors');
  if (event.error) {
    displayError.textContent = event.error.message;
  } else {
    displayError.textContent = '';
  }
});

// Handle form submission.
var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
  event.preventDefault();

  stripe.createToken(card).then(function(result) {
    if (result.error) {
      // Inform the user if there was an error.
      var errorElement = document.getElementById('card-errors');
      errorElement.textContent = result.error.message;
    } else {
      // Send the token to your server.
      stripeTokenHandler(result.token);
    }
  });
});

// Submit the form with the token ID.
function stripeTokenHandler(token) {
  // Insert the token ID into the form so it gets submitted to the server
  var form = document.getElementById('payment-form');
  var hiddenInput = document.createElement('input');
  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('name', 'stripeToken');
  hiddenInput.setAttribute('value', token.id);
  form.appendChild(hiddenInput);

  // Submit the form
  form.submit();
}
</script>