
<div class="blog-area home-blog default-padding bottom-less">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="site-heading text-center">
                    <h4 class="sub-title">News & Blog</h4>
                    <h2 class="title">Our Latest News & Blog</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Blog Posts -->
            <?php 
            $blogQuery = mysqli_query($conn, "SELECT * FROM tbl_blog ORDER BY id DESC LIMIT 2") or die(mysqli_error($conn));
            while ($blog = mysqli_fetch_assoc($blogQuery)) {
            ?>
                <div class="col-lg-6">
                    <div class="home-blog-style-one-item">
                        <img src="admin/uploads/products/<?= htmlspecialchars($blog['image1']) ?>" alt="Blog Image">
                        <div class="content">
                            <div class="info">
<div class="date">
    <?= date('d M', strtotime($blog['date'])) ?>
</div>
                                <ul class="blog-meta">
                                    <li>By <a href="#">Md Sohag</a></li>
                                    <li>
                                        <a href="#">Burger</a>, 
                                        <a href="#">Food</a>
                                    </li>
                                </ul>
                                <h4 class="title">
                                    <a href="full-blog?id=<?= $blog['id'] ?>">
                                        <?= htmlspecialchars($blog['heading']) ?>
                                    </a>
                                </h4>
                                <a href="full-blog?id=<?= $blog['id'] ?>" class="btn-read-more">
                                    Read More <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
   

   

                <!-- End Single Item -->
                <!-- Single Item -->
                <!-- <div class="col-lg-6">
                    <div class="home-blog-style-one-item">
                        <img src="assets/img/blog/2.jpg" alt="Image not Found">
                        <div class="content">
                            <div class="info">
                                <div class="date"><strong>18</strong> Nov</div>
                                <ul class="blog-meta">
                                    <li>
                                        By <a href="#">Md Sohag</a>
                                    </li>
                                    <li>
                                        <a href="#">Pizza</a> ,
                                        <a href="#">Food</a>
                                    </li>
                                </ul>
                                <h4 class="title">
                                    <a href="blog-single-with-sidebar.html">This prefabricated passive house is highly sustainable</a>
                                </h4>
                                <a href="blog-single-with-sidebar.html" class="btn-read-more">Read More <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div> -->
                <!-- End Single Item -->
            </div>
        </div>
    </div>
