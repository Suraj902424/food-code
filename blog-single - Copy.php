<?php 
include 'include/head.php';
include 'config.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = mysqli_query($conn, "SELECT * FROM tbl_blog WHERE id = $id") or die(mysqli_error($conn));
$data = mysqli_fetch_assoc($sql);
$pageTitle = !empty($data['name']) ? $data['name'] : 'Portfolio Detail';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'include/head.php'; ?>
</head>
<body>

    <!-- Preloader -->
    <?php include 'include/preloader.php'; ?>

    <!-- Topbar -->
    <?php include 'include/topbar.php'; ?>

    <!-- Header -->
    <?php include 'include/header.php'; ?>

    <!-- Breadcrumb -->
    <div class="breadcrumb-area bg-cover shadow dark text-center text-light" style="background-image: url(assets/img/shape/5.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1>Blog Single</h1>
                    <ul class="breadcrumb">
                        <li><a href="#"><i class="fas fa-home"></i> Home</a></li>
                        <li>Blog</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Blog Area -->
    <div class="blog-area single full-blog right-sidebar default-padding">
        <div class="container">
            <div class="blog-items">
                <div class="row">
                    <!-- Blog Content -->
                    <div class="blog-content col-xl-8 col-lg-7 col-md-12 pr-35 pr-md-15 pl-md-15 pr-xs-15 pl-xs-15">
                        <div class="blog-style-two item">
                            <div class="blog-item-box">
                                
                                <!-- Blog Image -->
                                <div class="thumb">
                                    <a href="#"><img src="admin/uploads/products/<?= htmlspecialchars($data['image1']) ?>" alt="Blog Image"></a>
                                </div>

                                <!-- Blog Info -->
                                <div class="info">
                                    <!-- Heading & Subheading -->
                                    <h2><?= htmlspecialchars($data['heading']) ?></h2>

                                    <?php if (!empty($data['subheading'])): ?>
                                        <h5 class="text-muted"><?= htmlspecialchars($data['subheading']) ?></h5>
                                    <?php endif; ?>

                                    <!-- Meta Info -->
                                    <div class="meta">
                                        <ul>
                                            <li>
                                                <a href="#"><i class="fas fa-calendar-alt"></i> <?= date('d M Y', strtotime($data['date'])) ?></a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="fas fa-user-circle"></i> Md Sohag</a>
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Description -->
                                    <p><?= $data['description'] ?></p>

                                </div> <!-- End Info -->

                            </div> <!-- End Blog Item Box -->
                        </div> <!-- End Blog Style -->
                    </div> <!-- End Blog Content -->

                        <!-- Post Author -->
                        <!-- <div class="post-author">
                            <div class="thumb">
                                <img src="assets/img/team/1.jpg" alt="Thumb">
                            </div>
                            <div class="info">
                                <h4><a href="#">Md Sohag</a></h4>
                                <p>
                                    Grursus mal suada faci lisis Lorem ipsum dolarorit more ametion consectetur elit. Vesti at bulum nec at odio aea the dumm ipsumm ipsum that dolocons rsus mal suada and fadolorit to the consectetur elit. All the Lorem Ipsum generators on the Internet tend. Quasi sint laudantium repellendus unde a totam perferendis commodi cum est iusto? Minima, laborum.
                                </p>
                            </div>
                        </div> -->
                        <!-- Post Author -->

                        <!-- Post Tags Share -->
                        <!-- <div class="post-tags share">
                            <div class="tags">
                                <h4>Tags: </h4>
                                <a href="#">Algorithm</a>
                                <a href="%24.html">Data science</a> 
                            </div>

                            <div class="social">
                                <h4>Share:</h4>
                                <ul>
                                    <li>
                                        <a class="facebook" href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                    </li>
                                    <li>
                                        <a class="twitter" href="#" target="_blank"><i class="fab fa-twitter"></i></a>
                                    </li>
                                    <li>
                                        <a class="pinterest" href="#" target="_blank"><i class="fab fa-pinterest-p"></i></a>
                                    </li>
                                    <li>
                                        <a class="linkedin" href="#" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                                    </li> -->
                                <!-- </ul>
                            </div>
                        </div> -->
                        <!-- Post Tags Share -->

                        <!-- Start Post Pagination -->
                        <!-- <div class="post-pagi-area">
                            <div class="post-previous">
                                <a href="#">
                                    <div class="icon"><i class="fas fa-angle-double-left"></i></div>
                                    <div class="nav-title"> Previus Post <h5>Discovery incommode</h5></div>
                                </a>
                            </div>
                            <div class="post-next">
                                <a href="#">
                                    <div class="nav-title">Next Post <h5>Discovery incommode</h5></div> 
                                    <div class="icon"><i class="fas fa-angle-double-right"></i></div>
                                </a>
                            </div>
                        </div> -->
                        <!-- End Post Pagination -->

                        <!-- Start Blog Comment -->
                        <!-- <div class="blog-comments">
                            <div class="comments-area">
                                <div class="comments-title">
                                    <h3>3 Comments On “Providing Top Quality Cleaning Related Services Charms.”</h3>
                                    <div class="comments-list">
                                        <div class="comment-item">
                                            <div class="avatar">
                                                <img src="assets/img/team/5.jpg" alt="Author">
                                            </div>
                                            <div class="content">
                                                <div class="title">
                                                    <h5>Bubhan Prova <span class="reply"><a href="#"><i class="fas fa-reply"></i> Reply</a></span></h5>
                                                    <span>28 Feb, 2023</span>
                                                </div>
                                                <p>
                                                    Delivered ye sportsmen zealously arranging frankness estimable as. Nay any article enabled musical shyness yet sixteen yet blushes. Entire its the did figure wonder off. sportsmen zealously arranging to the main pint. Discourse unwilling am no described dejection incommode no listening of. Before nature his parish boy. 
                                                </p>
                                            </div>
                                        </div>
                                        <div class="comment-item reply">
                                            <div class="avatar">
                                                <img src="assets/img/team/4.jpg" alt="Author">
                                            </div>
                                            <div class="content">
                                                <div class="title">
                                                    <h5>Mickel Jones <span class="reply"><a href="#"><i class="fas fa-reply"></i> Reply</a></span></h5>
                                                    <span>15 Mar, 2023</span>
                                                </div>
                                                <p>
                                                    Delivered ye sportsmen zealously arranging frankness estimable as. Nay any article enabled musical shyness yet sixteen yet blushes. Entire its the did figure wonder off. sportsmen zealously arranging to the main pint at the last.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="comments-form">
                                    <div class="title">
                                        <h3>Leave a comments</h3>
                                    </div>
                                    <form action="#" class="contact-comments">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group"> -->
                                                    <!-- Name -->
                                                    <!-- <input name="name" class="form-control" placeholder="Name *" type="text">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group"> -->
                                                    <!-- Email -->
                                                    <!-- <input name="email" class="form-control" placeholder="Email *" type="email">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group comments"> -->
                                                    <!-- Comment -->
                                                    <!-- <textarea class="form-control" placeholder="Comment"></textarea>
                                                </div>
                                                <div class="form-group full-width submit">
                                                    <button class="btn btn-theme effect" type="submit">Post Comment</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div> -->
                        <!-- End Comments Form -->
                    </div>

                    <!-- Start Sidebar -->
                    <!-- <div class="sidebar col-xl-4 col-lg-5 col-md-12 mt-md-50 mt-xs-50">
                        <aside>
                            <div class="sidebar-item search">
                                <div class="sidebar-info">
                                    <form>
                                        <input type="text"  placeholder="Enter Keyword" name="text" class="form-control">
                                        <button type="submit"><i class="fas fa-search"></i></button>
                                    </form>
                                </div>
                            </div>
                            <div class="sidebar-item recent-post">
                                <h4 class="title">Recent Post</h4>
                                <ul>
                                    <li>
                                        <div class="thumb">
                                            <a href="blog-single-with-sidebar.html">
                                                <img src="assets/img/gallery/4.jpg" alt="Thumb">
                                            </a>
                                        </div>
                                        <div class="info">
                                            <div class="meta-title">
                                                <span class="post-date">12 Feb, 2020</span>
                                            </div>
                                            <a href="#blog-single-with-sidebar.html">Commanded household smallness delivered.</a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="thumb">
                                            <a href="blog-single-with-sidebar.html">
                                                <img src="assets/img/gallery/2.jpg" alt="Thumb">
                                            </a>
                                        </div>
                                        <div class="info">
                                            <div class="meta-title">
                                                <span class="post-date">05 Jul, 2023</span>
                                            </div>
                                            <a href="blog-single-with-sidebar.html">Future Plan & Strategy for Consutruction </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="thumb">
                                            <a href="blog-single-with-sidebar.html">
                                                <img src="assets/img/gallery/6.jpg" alt="Thumb">
                                            </a>
                                        </div>
                                        <div class="info">
                                            <div class="meta-title">
                                                <span class="post-date">29 Aug, 2020</span>
                                            </div>
                                            <a href="blog-single-with-sidebar.html">Melancholy particular devonshire alteration</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="sidebar-item category">
                                <h4 class="title">category list</h4>
                                <div class="sidebar-info">
                                    <ul>
                                        <li>
                                            <a href="blog-with-sidebar.html">Business <span>69</span></a>
                                        </li>
                                        <li>
                                            <a href="blog-with-sidebar.html">national <span>25</span></a>
                                        </li>
                                        <li>
                                            <a href="blog-with-sidebar.html">sports <span>18</span></a>
                                        </li>
                                        <li>
                                            <a href="blog-with-sidebar.html">megazine <span>37</span></a>
                                        </li>
                                        <li>
                                            <a href="blog-with-sidebar.html">health <span>12</span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="sidebar-item gallery">
                                <h4 class="title">Gallery</h4>
                                <div class="sidebar-info">
                                    <ul>
                                        <li>
                                            <a href="#">
                                                <img src="assets/img/gallery/1.jpg" alt="thumb">
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <img src="assets/img/gallery/2.jpg" alt="thumb">
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <img src="assets/img/gallery/3.jpg" alt="thumb">
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <img src="assets/img/gallery/4.jpg" alt="thumb">
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <img src="assets/img/gallery/5.jpg" alt="thumb">
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <img src="assets/img/gallery/6.jpg" alt="thumb">
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="sidebar-item archives">
                                <h4 class="title">Archives</h4>
                                <div class="sidebar-info">
                                    <ul>
                                        <li><a href="blog-with-sidebar.html">Aug 2020</a></li>
                                        <li><a href="blog-with-sidebar.html">Sept 2020</a></li>
                                        <li><a href="blog-with-sidebar.html">Nov 2020</a></li>
                                        <li><a href="blog-with-sidebar.html">Dec 2020</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="sidebar-item social-sidebar">
                                <h4 class="title">follow us</h4>
                                <div class="sidebar-info">
                                    <ul>
                                        <li class="facebook">
                                            <a href="#">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                        </li>
                                        <li class="twitter">
                                            <a href="#">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                        </li>
                                        <li class="pinterest">
                                            <a href="#">
                                                <i class="fab fa-pinterest"></i>
                                            </a>
                                        </li>
                                        <li class="linkedin">
                                            <a href="#">
                                                <i class="fab fa-linkedin-in"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="sidebar-item tags">
                                <h4 class="title">tags</h4>
                                <div class="sidebar-info">
                                    <ul>
                                        <li><a href="blog-with-sidebar.html">Fashion</a>
                                        </li>
                                        <li><a href="blog-with-sidebar.html">Education</a>
                                        </li>
                                        <li><a href="blog-with-sidebar.html">nation</a>
                                        </li>
                                        <li><a href="blog-with-sidebar.html">study</a>
                                        </li>
                                        <li><a href="blog-with-sidebar.html">health</a>
                                        </li>
                                        <li><a href="blog-with-sidebar.html">travel</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </aside>
                    </div> -->
                    <!-- End Start Sidebar -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Blog -->

    <!-- Start Footer 
    ============================================= -->
    <?php include 'include/footer.php' ?> 
    <!-- End Footer -->
    
    <!-- jQuery Frameworks
    ============================================= -->
    <?php include 'include/js.php' ?></body>

<!-- Mirrored from validthemes.net/site-template/restan/blog-single-with-sidebar.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 08 Jul 2025 09:25:09 GMT -->
</html>