<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Room Photos</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Magnific Popup CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css"/>

  <?php include 'include/head.php' ?>
</head>
<body>
  <?php include 'include/preloader.php'; ?>
  <?php include 'include/topbar.php' ?>
  <?php include 'include/header.php' ?>

  <!-- Gallery Section -->
  <section class="gallerys-section white-bg section-padding">
    <div class="container-fluid">
      <div class="section-title mb-5 text-center">
        <span class="sub-font">View Photo</span>
        <h2 class="fw-semibold">
          See Our Exclusive <br>RESTAN Panthanivas - Rambha Gallery’s
        </h2>
      </div>

      <div class="row g-4">
        <!-- Example Gallery Item -->
        <div class="col-sm-6 col-md-6 col-lg-3">
          <a href="assets/img/room/apartment-big1.jpg" class="img-popup d-block">
            <img src="assets/img/room/apartment-big1.jpg" alt="Room 1" class="w-100" style="height: 356px; object-fit: cover;">
          </a>
        </div>

        <div class="col-sm-6 col-md-6 col-lg-3">
          <a href="assets/img/room/apartment-big2.jpg" class="img-popup d-block">
            <img src="assets/img/room/apartment-big2.jpg" alt="Room 2" class="w-100" style="height: 356px; object-fit: cover;">
          </a>
        </div>

        <div class="col-sm-6 col-md-6 col-lg-3">
          <a href="assets/img/room/offer-room.jpg" class="img-popup d-block">
            <img src="assets/img/room/offer-room.jpg" alt="Offer Room" class="w-100" style="height: 356px; object-fit: cover;">
          </a>
        </div>

        <div class="col-sm-6 col-md-6 col-lg-3">
          <a href="assets/img/room/room-q1.jpg" class="img-popup d-block">
            <img src="assets/img/room/room-q1.jpg" alt="Room Q1" class="w-100" style="height: 356px; object-fit: cover;">
          </a>
        </div>


         <div class="col-sm-6 col-md-6 col-lg-3">
          <a href="assets/img/room/room-q2.jpg" class="img-popup d-block">
            <img src="assets/img/room/room-q2.jpg" alt="Room Q1" class="w-100" style="height: 356px; object-fit: cover;">
          </a>
        </div>

         <div class="col-sm-6 col-md-6 col-lg-3">
          <a href="assets/img/room/room-q3.jpg" class="img-popup d-block">
            <img src="assets/img/room/room-q3.jpg" alt="Room Q1" class="w-100" style="height: 356px; object-fit: cover;">
          </a>
        </div>

         <div class="col-sm-6 col-md-6 col-lg-3">
          <a href="assets/img/room/room-qe4.jpg" class="img-popup d-block">
            <img src="assets/img/room/room-qe4.jpg" alt="Room Q1" class="w-100" style="height: 356px; object-fit: cover;">
          </a>
        </div>

         <div class="col-sm-6 col-md-6 col-lg-3">
          <a href="assets/img/room/room-qe6.jpg" class="img-popup d-block">
            <img src="assets/img/room/room-qe6.jpg" alt="Room Q1" class="w-100" style="height: 356px; object-fit: cover;">
          </a>
        </div>

        <!-- Add More Items Similarly -->
      </div>
    </div>
  </section>

  <!-- Footer -->
     <!-- Start Footer 
    ============================================= -->
    <?php include 'include/footer.php' ?> 
    <!-- End Footer -->
    
    <!-- jQuery Frameworks
    ============================================= -->
    <?php include 'include/js.php' ?>
  

  <!-- jQuery & Magnific Popup -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>

  <!-- Init Lightbox -->
  <script>
    $(document).ready(function() {
      $('.img-popup').magnificPopup({
        type: 'image',
        gallery: {
          enabled: true
        }
      });
    });
  </script>
</body>
</html>
