    <div class="testimonial-area bg-gray default-padding">

        <div class="testimonial-shape">
            <img src="assets/img/shape/5.png" alt="Image Not Found">
            <img src="assets/img/shape/7.png" alt="Image Not Found">
        </div>

        <div class="container">

            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="site-heading text-center">
                        <h4 class="sub-title">Happy Customers</h4>
                        <h2 class="title">Our Customers Feedback</h2>
                    </div>
                </div>
            </div>

            <div class="row align-center ">
                <div class="col-lg-5">
                    <div class="testimonial-thumb">
                        <img src="assets/img/team/4.jpg" alt="Image Not Found">
                        <img src="assets/img/team/5.jpg" alt="Image Not Found">
                        <img src="assets/img/team/6.jpg" alt="Image Not Found">
                        <img src="assets/img/team/7.jpg" alt="Image Not Found">
                    </div>
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <div class="testimonial-carousel swiper">
                        <!-- Additional required wrapper -->
                        <div class="swiper-wrapper">
                            <!-- Single item -->
                              <?php 
$sql=mysqli_query($conn,"select * from tbl_testimonial") or die(mysqli_error($conn));
                while($row=mysqli_fetch_assoc($sql)){
                ?>
                            <div class="swiper-slide">
                                <div class="testimonial-style-one">
                                    
                                    <div class="item">
                                        <div class="content">
                                            <div class="rating">
                                                <div class="icon">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </div>
                                                <span>(5/5)</span>
                                            </div>
                                            <h2>The best food ever</h2>
                                            <p>
                                                <?= $row['description'] ?>
                                            </p>
                                        </div>
                                        <div class="provider">
                                            <i class="flaticon-quote"></i>
                                            <div class="info">
                                                <h4><?= $row['name'] ?></h4>
                                                <span><?= $row['heading'] ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                             <?php }?>
                            <!-- End Single item -->
                            <!-- Single item -->
                            <!-- <div class="swiper-slide">
                                <div class="testimonial-style-one">
                                    <div class="item">
                                        <div class="content">
                                            <div class="rating">
                                                <div class="icon">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </div>
                                                <span>(5/5)</span>
                                            </div>
                                            <h2>Awesome and delicious food</h2>
                                            <p>
                                                Breaking consultation discover apartments. ndulgence off under folly death wrote cause her way spite. Plan upon yet way get cold spot its week. Almost do am or limits hearts. Resolve parties but why she shewing.”
                                            </p>
                                        </div>
                                        <div class="provider">
                                            <i class="flaticon-quote"></i>
                                            <div class="info">
                                                <h4>Anthom Bu Spar</h4>
                                                <span>Marketing Manager</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <!-- End Single item -->
                        </div>

                        <!-- Pagination -->
                        <div class="swiper-pagination"></div>

                    </div>

                </div>
            </div>
        </div>
    </div>
