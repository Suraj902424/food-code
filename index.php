<?php include 'config.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<!-- Standard SEO -->
<meta name="description" content="TastyBite Food mein hum banate hain ghar jaisa swaad, fresh ingredients se. Online order karein healthy & delicious meals, delivery Jaipur mein.">

<!-- Open Graph for social media sharing -->
<meta property="og:title" content="TastyBite Food – Swadisht, Healthy Homemade Meals">
<meta property="og:description" content="Fresh & tasty meals delivered to your door in Jaipur. Order now!">
<meta name="keywords" content="homemade meals, tastybite food, fresh meals delivery, healthy meals, ghar ka khana, lunch box delivery, dinner delivery, homemade tiffin, quick meal delivery, catering Jaipur">

<meta property="og:image" content="https://tastybitefood.free.nf/path/to/featured-image.jpg">
<meta property="og:url" content="https://tastybitefood.free.nf/">
<meta property="og:type" content="website">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="TastyBite Food – Swadisht, Healthy Homemade Meals">
<meta name="twitter:description" content="Fresh & tasty meals delivered to your door in Jaipur. Order now!">
<meta name="twitter:image" content="https://tastybitefood.free.nf/path/to/featured-image.jpg">


<head>
    <!-- ========== Meta Tags ========== -->
     <?php include 'include/head.php' ?>
   
    <!-- ========== End Stylesheet ========== -->

  

</head>

<body class="color-style-two">

    <!-- Start Preloader 
    ============================================= -->
   
    <!-- End Preloader -->
<?php include 'include/topbar.php' ?>
    <!-- End Topbar -->

    <!-- Header 
    ============================================= -->
    <?php include 'include/header.php' ?>
    <!-- End Header -->

    <!-- Start Banner Area 
    ============================================= -->
    <?php include 'include/banner.php' ?>
    <!-- End Banner -->

    <!-- Start About 
    ============================================= -->
    <?php include 'include/about.php' ?>
    <!-- End About -->

    <!-- Start Best Food 
    ============================================= -->
    <?php include 'include/food.php' ?>
    <!-- End Best Food -->

    <!-- Start Best Deal
    ============================================= -->
    <?php include 'include/offer.php' ?>
    <!-- End Best Deal -->

    <!-- Start Food Menu 
    ============================================= -->
    <!-- End Food Menu -->

    <!-- Start Compo Offer 
    ============================================= -->
    <div class="combo-offer-area default-padding bg-theme text-light bg-cover" style="background-image: url(assets/img/shape/6.jpg);">
        <div class="container">
            <div class="row align-center">
                <div class="col-xl-5 col-lg-6">
                    <h4>Super Compbo Offer</h4>
                    <h2 class="title">Burger and sea fish curry combo</h2>
                    <p>
                        Continue indulged speaking the was out horrible for domestic position. Seeing rather her you not esteem men settle genius excuse. Deal say over you age from. Comparison new ham melancholy son themselves.
                    </p>
                    <a class="btn btn-md circle btn-theme animation mt-10" href="shoping">Accept This Deal</a>
                </div>
                <div class="col-xl-6 offset-xl-1 col-lg-6">
                    <div class="comob-thumb">
                        <img src="assets/img/thumb/12.jpg" alt="Image Not Found">
                        <img src="assets/img/illustration/13.png" alt="Image Not Found">
                        <div class="item-price">
                            <h1><del>$80</del> $65</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Combo Offer -->

    <!-- Start Opening Hours 
    ============================================= -->
    <?php include 'include/time.php' ?>
    <!-- End Opening Hours -->

    <!-- Start Testimonial 
    ============================================= -->
    <?php include 'include/testimonial.php' ?>
    <!-- End Testimonial -->

    <!-- Start Blog 
    ============================================= -->
    <!-- End Blog -->
    

    <!-- Start Footer 
    ============================================= -->
    <?php include 'include/footer.php' ?>
    <!-- End Footer -->
    
    <!-- jQuery Frameworks
    ============================================= -->
    <?php include 'include/js.php' ?>
   

</body>

</html>