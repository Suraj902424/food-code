
<!-- Banner Slider Area Start -->
<div class="banner-area banner-style-six bg-dark navigation-circle overflow-hidden text-light bg-cover" style="background-image: url(assets/img/banner/9.jpg);">
    <!-- Slider main container -->
    <div class="banner-fade">
        <!-- Swiper Wrapper -->
        <div class="swiper-wrapper">
            <?php 
            $sql = mysqli_query($conn, "SELECT * FROM tbl_banner") or die(mysqli_error($conn));
            while ($row = mysqli_fetch_assoc($sql)) {
                ?>
                <div class="swiper-slide">
                    <div class="banner-bg">
                        <img src="admin/uploads/products/<?= htmlspecialchars($row['image1']) ?>" alt="Banner Image">
                    </div>
                    <div class="container">
                        <div class="content">
                            <div class="row align-center">
                                <div class="col-lg-7">
                                    <div class="info-text">
                                        <img src="assets/img/illustration/19.png" alt="Illustration Left">
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="item-discount">
                                        <img src="assets/img/illustration/21.png" alt="Illustration Right">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <!-- Navigation -->
        <div class="swiper-nav-left">
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>
</div>
<!-- Banner Slider Area End -->
