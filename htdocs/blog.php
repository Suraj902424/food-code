<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login");
    exit;
}
?>
<?php 
include 'config.php'; 



// Pagination setup
$limit = 4;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Total blog count
$totalResult = mysqli_query($conn, "SELECT COUNT(*) as total FROM tbl_blog");
$totalRow = mysqli_fetch_assoc($totalResult);
$total = $totalRow['total'];
$totalPages = ceil($total / $limit);

// Fetch blogs for current page
$blogQuery = mysqli_query($conn, "SELECT * FROM tbl_blog ORDER BY id DESC LIMIT $start, $limit");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'include/head.php'; ?>
</head>
<body>

<?php include 'include/preloader.php'; ?>
<?php include 'include/topbar.php'; ?>
<?php include 'include/header.php'; ?>

<!-- Breadcrumb -->
<div class="breadcrumb-area bg-cover shadow dark text-center text-light" style="background-image: url(assets/img/shape/5.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>Blog Grid</h1>
                <ul class="breadcrumb">
                    <li><a href="#"><i class="fas fa-home"></i> Home</a></li>
                    <li>Blog</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Blog Grid -->
<div class="blog-area blog-grid grid-colum-3 default-padding">
    <div class="container">
        <div class="blog-item-box">
            <div class="row">
                <?php while ($blog = mysqli_fetch_assoc($blogQuery)) { ?>
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
                                        <li><a href="#">Burger</a>, <a href="#">Food</a></li>
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
            </div>
        </div>

        <!-- Pagination -->
        <div class="row">
            <div class="col-md-12 pagi-area text-center">
                <nav aria-label="navigation">
                    <ul class="pagination">
                        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page - 1 ?>">
                                <i class="fas fa-angle-double-left"></i>
                            </a>
                        </li>

                        <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                            <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php } ?>

                        <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page + 1 ?>">
                                <i class="fas fa-angle-double-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<?php include 'include/footer.php'; ?>
<?php include 'include/js.php'; ?>

</body>
</html>
