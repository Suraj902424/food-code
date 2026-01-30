<?php include 'config.php'; ?>
<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from validthemes.net/site-template/restan/about-us.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 08 Jul 2025 09:24:55 GMT -->
<?php include 'include/head.php'; ?>
<body>

    <!-- Start Preloader 
    ============================================= -->
    <?php include 'include/preloader.php'; ?>
    <!-- Start Header Top 
    ============================================= -->
    <?php include 'include/topbar.php'; ?>
    <!-- End Header Top -->


    <!-- Header 
    ============================================= -->
    <?php include 'include/header.php'; ?>
    <!-- End Header -->
    

    <!-- Start Breadcrumb 
    ============================================= -->
    <div class="breadcrumb-area bg-cover shadow dark text-center text-light" style="background-image: url(assets/img/shape/5.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h1>About Us</h1>
                    <ul class="breadcrumb">
                        <li><a href="#"><i class="fas fa-home"></i> Home</a></li>
                        <li>About</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb -->

    <!-- Start Brand 
    ============================================= -->
    <div class="brand-area overflow-hidden default-padding bg-cover text-center bg-gray" style="background-image: url(assets/img/shape/1.png);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="sub-title">OUR TRUSTED 8K HAPPY PARTNER</h4>
                    <div class="brand-style-one-carousel swiper mt-40">
                        <!-- Additional required wrapper -->
                        <div class="swiper-wrapper">
                            <!-- Single Item -->
                              <?php 
$sql=mysqli_query($conn,"select * from tbl_partner") or die(mysqli_error($conn));
                while($row=mysqli_fetch_assoc($sql)){
                ?>
                            <div class="swiper-slide">
                                <img src=" admin/uploads/products/<?= $row['image1'] ?>" alt="Thumb">
                            </div>
                            <?php } ?>
                            <!-- End Single Item -->
                            <!-- Single Item -->
                            <!-- <div class="swiper-slide">
                                <img src="assets/img/brand/2.png" alt="Thumb">
                            </div> -->
                            <!-- End Single Item -->
                            <!-- Single Item -->
                            <!-- <div class="swiper-slide">
                                <img src="assets/img/brand/3.png" alt="Thumb">
                            </div> -->
                            <!-- End Single Item -->
                            <!-- Single Item -->
                            <!-- <div class="swiper-slide">
                                <img src="assets/img/brand/4.png" alt="Thumb">
                            </div> -->
                            <!-- End Single Item -->
                            <!-- Single Item -->
                            <!-- <div class="swiper-slide">
                                <img src="assets/img/brand/5.png" alt="Thumb">
                            </div> -->
                            <!-- End Single Item -->
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Brand -->

    <!-- Start About 
    ============================================= -->
              <?php 
$sql=mysqli_query($conn,"select * from tbl_setting") or die(mysqli_error($conn));
                while($row=mysqli_fetch_assoc($sql)){
                ?>
    <div class="about-style-one-area default-padding mb-80">
        <div class="about-thumb">
            <div class="item" style="background-image: url(admin/uploads/products/<?= $row['image2'] ?>);"></div>
            <div class="item" style="background-image: url(admin/uploads/products/<?= $row['image2'] ?>);"></div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-6">
                    <div class="about-style-one-info">
                        <img src="assets/img/shape/2.png" alt="Image Not Found">
                        <h4 class="sub-heading">About us</h4>
                        <h2 class="title"><?= $row['about_us_heading'] ?></h2>
                        <p>
                           <?= $row['description'] ?>
                        </p>
                        <a class="btn btn-theme btn-md animation mt-10" href="about-us.html">Discover More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <!-- End About -->

    <!-- Start Chef Area 
    ============================================= -->
    <div class="chef-area default-padding bg-gray text-center">
        <div class="container">

            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="site-heading text-center">
                        <h4 class="sub-title">MASTER CHEFS</h4>
                        <h2 class="title">Meet Our Special Chefs</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Single Item -->
                  <?php 
$sql=mysqli_query($conn,"select * from tbl_team") or die(mysqli_error($conn));
                while($row=mysqli_fetch_assoc($sql)){
                ?>
                <div class="col-xl-4 col-lg-6">
                    <div class="chef-style-one">
                        <div class="chef-thumb">
                            <img src="admin/uploads/products/<?= $row['image1'] ?>" alt="Image Not Found">
                            <div class="info">
                                <h4><a href="chef-details.html"><?= $row['name'] ?></a></h4>
                                <span><?= $row['post'] ?></span>
                            </div>
                            <ul class="social">
                                <li>
                                    <a href="<?= $row['link'] ?>">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= $row['link3'] ?>">
                                        <i class="fab fa-youtube"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <!-- End Single Item -->
                <!-- Single Item -->
                <!-- <div class="col-xl-4 col-lg-6">
                    <div class="chef-style-one">
                        <div class="chef-thumb">
                            <img src="assets/img/team/2.jpg" alt="Image Not Found">
                            <div class="info">
                                <h4><a href="chef-details.html">Mendia Juxef</a></h4>
                                <span>Burger King</span>
                            </div>
                            <ul class="social">
                                <li>
                                    <a href="#">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-youtube"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div> -->
                <!-- End Single Item -->
                <!-- Single Item -->
                <!-- <div class="col-xl-4 col-lg-6">
                    <div class="chef-style-one">
                        <div class="chef-thumb">
                            <img src="assets/img/team/3.jpg" alt="Image Not Found">
                            <div class="info">
                                <h4><a href="chef-details.html">Petro William</a></h4>
                                <span>Main Chef</span>
                            </div>
                            <ul class="social">
                                <li>
                                    <a href="#">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-youtube"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div> -->
                <!-- End Single Item -->
            </div>
        </div>
    </div>
    <!-- End Chef Area -->

    <!-- Start Opening Hours 
    ============================================= -->
    <?php include 'include/footer.php' ?> 
    <!-- End Footer -->
    
    <!-- jQuery Frameworks
    ============================================= -->
    <?php include 'include/js.php' ?>

</body>

<!-- Mirrored from validthemes.net/site-template/restan/about-us.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 08 Jul 2025 09:24:55 GMT -->
</html>