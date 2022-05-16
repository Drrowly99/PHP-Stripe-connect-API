<?php 
session_start();

if ( $_SESSION['status'] == "completed"){
  die();
}else{

}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="theme-color" content="#7015b8" >
    <title>Accept a card payment</title>
    <meta name="description" content="A demo of a card payment on Stripe" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/global.css" />
    <link rel="stylesheet" href="css/w3.css" />
    <link rel="stylesheet" href="css/new.css" />
    <link rel="stylesheet" href="w3.css" />
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>
    <script src="/client.js" defer></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Alumni+Sans:wght@500;700&display=swap" rel="stylesheet">
    <style >
      @font-face{
          font-family: Avenir;
          src: url(css/avenir-next/AvenirNextLTPro-Regular.otf)
      }
     .font{font-family:Avenir;}
     .col{color:rgb(105, 115, 134)!important;}
     .logo-text{position:relative;font-family: 'Alumni Sans', sans-serif;font-style:italic;font-size:25px;letter-spacing:2px;top:4px;}
    </style>
  </head>

  <body class="w2-card w3-white "  style="position: relative; width :100%;  margin: auto; height:100vh;">
    <div id="succ" class="w3-green w3-animate-top w3-center w3-container success w3-round-large" style="display: none ;position: absolute;top:0; left:0;right:0; height: 60px; width: 80%;max-width:600px;margin: 10px auto;z-index:3;">
      <div style="line-height: 50px" class="bold-7"> <i class="fa fa-check"></i> Payment Successful</div>
    </div>
    <!-- Display a payment form -->
    <div class="w3-white" style="position: relative;width:100%;max-width:100vw;margin:auto;min-height:500px;height:auto;">
      <header class="w3-white" style="height: 60px; width:100%;padding-left: 10px;padding-top:5px;">
        <div class="bold-6 w3-medium w3-center" style="">
                <img src="image/main logo.svg" style="height:50px;width:50px;">
                <span class=" logo-text" >Cash Out</span> 
        </div>
      </header>
       

        <div class="font w3- w3-container relative w3-round" style="min-height:19vh;height:auto;width:100%;max-width:600px;margin:auto;top:10px;">
          <div class="w3-card-5 w3-border w3-border-white w3-purple w3-round-large w3-padding">
          
            <div class="w3-row w3-" style="position:relative; height:30px;top:10px;">
                <div class="w3-col s5 " style="font-size:13px;line-height:30px;">Amount</div>
                  <div class="w3-col s7 bold-6 s_title" style="font-size:13px;text-align:right;line-height:28px;"><span class="dollar_f"></span> <?php echo number_format($_SESSION['am']); ?></div>
             </div>
             <div class="w3-row w3-" style="position:relative; height:30px;top:10px;">
                <div class="w3-col s5 " style="font-size:13px;line-height:30px;">Fees (1.5%)</div>
                  <div class="w3-col s7 bold-6 s_title" style="font-size:13px;text-align:right;line-height:28px;"><span class="dollar_f"></span> <?php echo $_SESSION['fee']; ?></div>
             </div>
             <div class="w3-row w3-" style="position:relative; height:30px;top:10px;">
                <div class="w3-col s5 " style="font-size:13px;line-height:30px;">Total</div>
                  <div class="w3-col s7 bold-6 s_title" style="font-size:13px;text-align:right;line-height:28px;"><span class="dollar_f"></span> <?php echo number_format($_SESSION['total']/100); ?></div>
             </div>
             <div class="w3-row w3-" style="position:relative; height:30px;top:10px;">
                <div class="w3-col s5 " style="font-size:13px;line-height:30px;">Local Amount</div>
                  <div class="w3-col s7 bold-6 s_title" style="font-size:13px;text-align:right;line-height:28px;"><span class="dollar_l">&#8373;</span> <?php echo number_format($_SESSION['am_ngn']); ?></div>
             </div>
           </div>
         </div>
       
      <form id="payment-form" style="position: relative;max-width:600px; width:100%; min-height:60vh;height:auto;margin:25px auto 0 auto;" class="w3- w3-padding ">

        <div class="w3-white w3-round-large relative" style="position: relative; margin-top:20%;min-height:;height:auto;width:100%;max-width: 600px;margin:auto;">
         
            <div class="name w3-margin-bottom">
              <input type="text" name="name" value="" id="name" class="di_input" style="width:100%!important;padding:8px 8px;" placeholder="Your Name">
              <span class="name_err"></span>
            </div>
            <div class="email w3-margin-bottom">
               
              <input type="email" name="email" value="" id="email" class="di_input" style="width:100%!important;padding:8px 8px;" placeholder="Your Email Address">
              <span class="email_err"></span>
            </div>
            <div class="card w3-margin-bottom">
              <div id="card-element" class="di_input" style="width:100%!important;"></div>
            </div>



          <div id="_but" class="" id="login" style=" position: relative; bottom:-20px;left:0; right:0;">
            <button id="submit" class="w3-round-large" style="border:4px solid white;">
              <div class="spinner hidden "  id="spinner"></div>
              <span id="button-text">Pay With Stripe</span>
            </button>
          </div>
          <br><br>
          <p id="card-error" class="w3-small w3-center" role="alert"></p>
          <p class="w3-center result-message w3-text-grey hidden w3-small">
            Payment succeeded
           
          </p> 
     

        </div>


<!-- 
      <div id="card-element"><!Stripe.js injects the Card Element</div>
      <button id="submit">
        <div class="spinner hidden" id="spinner"></div>
        <span id="button-text">Pay With Stripe</span>
      </button>
      <p id="card-error" role="alert"></p>
      <p class="result-message hidden">
        Payment succeeded, see the result in your
        <a href="" target="_blank">Stripe dashboard.</a> Refresh the page to pay again.
      </p> -->
    </form>
      
    </div>

  
    <div class="w3-" style="position: absolute;bottom: 1%;left:0;right:0;height:10vh;">
      <p class="w3-small w3-center col">Powered By Stripe
<?php
 if (isset($_SESSION['f_currs'])) {
  echo "string";
 }
?></p>
    </div>
 
  </body>
</html>

<script type="text/javascript">

    
    // if(f == 'EUR'){
     
    //   $('.dollar_f').text('€')
    // }
    // else if(f == 'USD'){
    //   $('.dollar_f').text('$')
    // }

    // else if(f == 'CAD'){
    //    alert('na me')
    //    alert($('#name').val())

    //   $('.dollar_f').text('C$')
    // }else{
     
    //   $('.dollar_f').text('$')
    // }




    // let l = "<?php echo $_SESSION['l_curr'] ?>"
    // alert(l);
    // if(l == 'NGN'){
    //   $('.dollar_l').text('&#8358;')
    // }
    // else if(l == 'GHS'){
    //   $('.dollar_l').text('&#8373;')
    // }

    // else if(l  == 'CAD'){
    //   $('.dollar_l').text('CAD')
    // }else{
    
    //   $('.dollar_l').text('&#8358;')
    // }
</script>



<script type="text/javascript">
let name = $('#name').val();
let email = $('#email').val();
 let e = "<?php echo $_SESSION['pay_code']; ?>"
  //alert(e)
  console.log(e)

  /* --------Update Receivers Amount ----- */
 var updateamount = () => {
  let name = $('#name').val();
  let email = $('#email').val();
  
  let e = "<?php echo $_SESSION['pay_code']; ?>"

  alert(e)
      $.ajax({
          url:  'do.php',
          method: 'POST',
          data: {e:e, name:name, email:email},
          //dataType: 'json',
          beforeSend: function()
          {
              alert('sending')
            // $('.load').show()

          },
          success: function(data)
          {
            alert(data)
            $('.success').show()
              window.location = data;
            
             
             
          }
        })

    
  }
let f = "<?php echo $_SESSION['f_currs'] ?>"
if(f == 'EUR'){
     
      $('.dollar_f').text('€')
    }
    else if(f == 'USD'){
      $('.dollar_f').text('$')
    }

    else if(f == 'CAD'){
      $('.dollar_f').text('CAD')
    }else{
     
      $('.dollar_f').text('$')
    }

let l = "<?php echo $_SESSION['l_currs'] ?>"
    if(l == 'NGN'){
      $('.dollar_l').text('₦')
    }
    else if(l == 'GHS'){
      $('.dollar_l').text('₵')
    }

   else{
    
      $('.dollar_l').html('&#8358;')
    }
 
</script>