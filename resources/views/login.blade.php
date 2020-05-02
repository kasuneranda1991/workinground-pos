<!DOCTYPE html>
<html lang="en">
<head>
  <title>WORKINGROUND POS</title>
  <meta charset="UTF-8">
  <meta name="description" content="{{ Carbon\Carbon::now()->toFormattedDateString() }} This is a Web Based Pos System that facilitate the inventory and Billing for users who use this,We'Allways Monitering you and help you to solve your problems and guid user business to larger incomes">
  <meta name="keywords" content="POS, android pos, Sri Lanka, Point of Sales Solutions in Sri Lanka, POS System in Sri Lanka, Best POS System in Sri Lanka, Supermarket POS Systems in Sri Lanka, point of sale, restaurant pos software, pos for small business, best pos system for small business, touch screen cash register, restaurant point of sale systems, pos app, restaurant computer systems, tablet pos, mobile pos system, retail pos system, bar pos system, pos inventory system, aloha pos, grocery store pos,post hoc, what is point of sale, pos system meaning" />

  <meta name="google-site-verification" content="B6m8GdiTiX82dWVD6LxuiEFqUEmxJ_X3Q75CJex9SAU" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->  
<link rel="icon" href="{{asset('logo/logo.png')}}" type="image/x-icon" media="print">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" media="print" >
<!--===============================================================================================-->
   <!-- <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet"> -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<!--===============================================================================================-->
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous" media="print">
<!--===============================================================================================-->
  <!-- <link rel="stylesheet" type="text/css" href="{{ asset('login/css/animate.css') }}"> -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css" media="print">
<!--===============================================================================================-->  
  <link rel="stylesheet" type="text/css" href="{{ asset('login/css/hamburgers.min.css') }}" media="print">
<!--===============================================================================================-->
  <!-- <link rel="stylesheet" type="text/css" href="{{ asset('login/css/select2.min.css') }}"> -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" media="print">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="{{ asset('login/css/util.css') }}" media="print">
  <link rel="stylesheet" type="text/css" href="{{ asset('login/css/main.css') }}">
<!--===============================================================================================-->
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-134041156-1"></script>
<script async>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-134041156-1');
</script>
</head>
<body>

  <div class="limiter">
    <div class="container-login100">

    @include('system_messege.message-block')
      <div class="wrap-login100">
        <div class="login100-pic js-tilt" data-tilt>
          <img src="{{ asset('logo/logo-poster.png') }}" alt="www.workinground.com">
        </div>
        <form class="login100-form validate-form" action="/signup" method="post">
        {{ csrf_field() }}
          <span class="login100-form-title">
            Member Login
          </span>
          <div class="wrap-input100 validate-input" data-validate = "Shop ID is Required">
            <input class="input100" type="text" name="shop_id" placeholder="Shop ID">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
              <i class="fa fa-hashtag" aria-hidden="true"></i>
            </span>
          </div>
          <div class="wrap-input100 validate-input" data-validate = "Username is Required">
            <input class="input100" type="text" name="username" placeholder="Username">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
              <i class="fa fa-user" aria-hidden="true"></i>
            </span>
          </div>

          <div class="wrap-input100 validate-input" data-validate = "Password is required">
            <input class="input100" type="password" name="password" placeholder="Password">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
              <i class="fa fa-lock" aria-hidden="true"></i>
            </span>
          </div>
          
          <div class="container-login100-form-btn">
            <button class="login100-form-btn">
              Login
            </button>
            <br>
            <br><br>
            <a class="btn btn-outline-success" href="/sri-lanka-workinground-web-based-pos-system-software-create-account">
              <h4>Create your Account now</h4>
            </a>
          </div>

          <div class="text-center p-t-12">
            <span class="txt1">
              Forgot
            </span>
            <a class="txt2" href="#">
              Username / Password?
            </a>
          </div>
          <div class="text-center p-t-12">
            <span class="txt1">
              <a href="https://www.workinground.com/sri-lanka-workinground-free-web-based-pos-system-software"> © workinground.com</a>
            </span>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <p class="text-justify">You dont need to do any payment to use this system,because this is under testing period and please give us your valuable comment,During this testing period we will provide users to monthly based payment method including all functionality of this system,Monthly payment will be less than 12 USD</p>
        <br>
        <p class="text-justify">ඔබට මෙම පද්ධතිය භාවිතය සඳහා කිසිදු ගෙවීමක් කිරීමට අවශ්‍ය නොවේ.මෙම පද්ධතිය පරික්ශන මට්ටමේ පවතින බැවින් ඔබගේ වටිනා අදහස් පහත ඇති චැට් මොඩුලය භාවිතයෙන් අපට ලබාදෙන්න,සියලු පද්ධති පරික්ශාවෙන් පසු ඔබහට රු.2000 ට අඩු මාසික ගෙවීම් පදනම මත පද්ධතිය භාවිතයට ඉඩ ලබාදෙනු ලැබේ</p>
        
        <a class="badge badge-success" href="https://www.workinground.com/sri-lanka-workinground-free-web-based-pos-system-software">Watch our Product Demo Workinground.com</a>
      </div>
    </div>
  </div>
</div>
  

  
<!--===============================================================================================-->  
 <!-- <script src="{{ asset('login/js/popper.js') }}"></script> -->
<!--===============================================================================================-->  
  <!-- <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script> -->
  <!-- <script src="{{ asset('js/bootstrap.min.js') }}"></script> -->
  <script src="https://code.jquery.com/jquery-3.4.0.min.js"  integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg="  crossorigin="anonymous"></script>
  <script defer src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script defer src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<!--===============================================================================================-->
  <!-- <script src="{{ asset('login/js/select2.min.js') }}"></script> -->
  <script async src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
<!--===============================================================================================-->
  <script async src="{{ asset('login/js/tilt.jquery.min.js') }}"></script>
  <script defer>
    $('.js-tilt').tilt({
      scale: 1.1
    });
  </script>
  <script>$(document).ready(function(){$('#exampleModal').modal('show');});</script>
<!--===============================================================================================-->
  <script defer src="{{ asset('login/js/main.js') }}"></script>
  <script defer type="text/javascript">function add_chatinline(){var hccid=48739943;var nt=document.createElement("script");nt.async=true;nt.src="https://mylivechat.com/chatinline.aspx?hccid="+hccid;var ct=document.getElementsByTagName("script")[0];ct.parentNode.insertBefore(nt,ct);}
add_chatinline(); </script>

<!-- mD -->
<script defer type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ShoppingCenter",
  "name": "WORKINGROUND",
  "image": "https://res.cloudinary.com/workinground/image/upload/v1556021353/logo/logo-poster_r4ly6i.png",
  "@id": "",
  "url": "https://www.workinground.com/sri-lanka-web-based-pos-system-software-signup",
  "telephone": "+94720782825",
  "priceRange": "1500LKR",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "Udhayamawatha",
    "addressLocality": "Anuradhapura",
    "postalCode": "50000",
    "addressCountry": "LK"
  },
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": 8.3243545,
    "longitude": 80.4014062
  },
  "openingHoursSpecification": {
    "@type": "OpeningHoursSpecification",
    "dayOfWeek": [
      "Monday",
      "Tuesday",
      "Wednesday",
      "Thursday",
      "Friday",
      "Saturday",
      "Sunday"
    ],
    "opens": "00:00",
    "closes": "23:59"
  },
  "aggregateRating":{
    "@type":"AggregateRating",
    "ratingValue":"4.6",
    "reviewCount":"1985"},
    
  "sameAs": "https://www.youtube.com/channel/UCKKorc4sUHCg_v2T7DBWK-g"
}
</script>

</body>
</html>