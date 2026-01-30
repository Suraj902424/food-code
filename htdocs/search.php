<?php
require_once 'config.php';
$q = isset($_GET['q']) ? mysqli_real_escape_string($conn, $_GET['q']) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Search Results</title>
  <?php include 'include/head.php'; ?>
</head>
<body>
<?php include 'include/topbar.php'; ?>
<?php include 'include/header.php'; ?>

<div class="container my-5">
  <h3 class="mb-4">Search Results for "<?= htmlspecialchars($q) ?>"</h3>
  <div class="row">
    <?php
    if ($q != '') {
        $sql = "SELECT * FROM tbl_product 
                WHERE status=1 
                AND (name LIKE '%$q%' OR description LIKE '%$q%')";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $image = !empty($row['image1']) ? 'admin/uploads/products/' . $row['image1'] : 'assets/img/food/default.jpg';
                ?>
                <div class="col-md-3 col-sm-6 mb-4">
                  <div class="card h-100 shadow-sm">
                    <img src="<?= $image ?>" class="card-img-top" alt="<?= $row['name'] ?>">
                    <div class="card-body d-flex flex-column">
                      <h5 class="card-title"><?= $row['name'] ?></h5>
                      <p class="card-text flex-grow-1"><?= substr(strip_tags($row['description']),0,80) ?>...</p>
                      <div class="mt-auto">
                        <p class="mb-2 text-danger fw-bold">₹<?= $row['price_half'] ?></p>
                        <a href="book" class="btn btn-sm btn-primary w-100"><i class="fas fa-shopping-bag"></i> Add to cart</a>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
            }
        } else {
            echo '<div class="col-12"><p>No products found.</p></div>';
        }
    } else {
        echo '<div class="col-12"><p>Please enter a search query.</p></div>';
    }
    ?>
  </div>
</div>

<?php include 'include/footer.php'; ?>
</body>
</html>
<style>
    .card h5.card-title {
  font-size: 1rem;
  font-weight: 600;
}
.card .btn-primary {
  background-color: #ff5722;
  border-color: #ff5722;
  border-radius: 30px;
}
.card .btn-primary:hover {
  background-color: #e64a19;
}

</style>