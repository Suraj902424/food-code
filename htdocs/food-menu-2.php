<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login");
    exit;
}
?>
<?php
// session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'include/head.php'; ?>
</head>
<body>

<?php include 'include/topbar.php'; ?>
<?php include 'include/header.php'; ?>

<!-- Breadcrumb -->
<div class="breadcrumb-area bg-cover shadow dark text-center text-light" style="background-image: url(assets/img/shape/5.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>Restaurant Best Food</h1>
                <ul class="breadcrumb">
                    <li><a href="#"><i class="fas fa-home"></i> Home</a></li>
                    <li>Menu</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Food Menu Area -->
<div class="food-menu-area shape-less default-padding-top">
    <div class="container">
        <div class="food-menu-items text-light">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="nav nav-tabs food-menu-nav" id="nav-tab" role="tablist">
                        <?php
                        include 'config.php';
                        $categoryResult = mysqli_query($conn, "SELECT * FROM tbl_product_category WHERE status = 1 ORDER BY id ASC");
                        $tabIndex = 1;
                        while ($cat = mysqli_fetch_assoc($categoryResult)) {
                            $active = ($tabIndex === 1) ? 'active' : '';
                            $tabId = 'tab' . $tabIndex;
                            echo '<button class="nav-link ' . $active . '" id="nav-id-' . $tabIndex . '" data-bs-toggle="tab" data-bs-target="#' . $tabId . '" type="button" role="tab">' . htmlspecialchars($cat['name']) . '</button>';
                            $tabIndex++;
                        }
                        ?>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="tab-content food-menu-tab-content" id="nav-tabContent">
                        <?php
                        mysqli_data_seek($categoryResult, 0);
                        $tabIndex = 1;
                        while ($category = mysqli_fetch_assoc($categoryResult)) {
                            $tabId = 'tab' . $tabIndex;
                            $activeClass = ($tabIndex === 1) ? 'show active' : '';
                            $categoryId = $category['id'];
                            ?>
                            <div class="tab-pane fade <?= $activeClass ?>" id="<?= $tabId ?>" role="tabpanel">
                                <div class="row">
                                    <div class="col-xl-5 thumb" style="background: url(assets/img/banner/3.jpg);">
                                        <div class="discount-badge">
                                            <strong>15%</strong> Discount
                                        </div>
                                    </div>
                                    <div class="col-xl-7">
                                        <div class="info">

                                            <!-- Global Toggle -->
                                            <ul class="meal-type">
                                                <li onclick="setGlobalPrice('half')" style="cursor: pointer;">Half</li>
                                                <li onclick="setGlobalPrice('full')" style="cursor: pointer;">Full</li>
                                            </ul>

                                            <ul class="meal-items">
                                                <?php
                                                $productResult = mysqli_query($conn, "SELECT * FROM tbl_product WHERE category_id = $categoryId AND status = 1");
                                                while ($product = mysqli_fetch_assoc($productResult)) {
                                                    $pid = $product['id'];
                                                    $image = !empty($product['image1']) ? 'admin/uploads/products/' . $product['image1'] : 'assets/img/food/default.jpg';
                                                    $name = htmlspecialchars($product['name']);
                                                    $desc = strip_tags($product['description']);
                                                    $price_half = htmlspecialchars($product['price_half']);
                                                    $price_full = htmlspecialchars($product['price_full']);
                                                    ?>
                                                    <li>
                                                        <div class="thumbnail">
                                                            <img src="<?= $image ?>" alt="<?= $name ?>">
                                                        </div>
                                                        <div class="content">
                                                            <div class="top">
                                                                <div class="title">
                                                                    <h4><a href="booking.php"><?= $name ?></a></h4>
                                                                </div>
                                                                <div class="price" id="price_<?= $pid ?>" data-half="<?= $price_half ?>" data-full="<?= $price_full ?>">
                                                                    ₹<?= $price_half ?>
                                                                </div>
                                                            </div>
                                                            <div class="bottom">
                                                                <div class="left">
                                                                    <p><?= $desc ?></p>
                                                                </div>
                                                                <!-- <div class="right">
                                                                    <label>
                                                                        <input type="radio" name="size_<?= $pid ?>" value="<?= $price_half ?>" checked onchange="updateSinglePrice(<?= $pid ?>)"> Half
                                                                    </label>
                                                                    <label style="margin-left:10px;">
                                                                        <input type="radio" name="size_<?= $pid ?>" value="<?= $price_full ?>" onchange="updateSinglePrice(<?= $pid ?>)"> Full
                                                                    </label>
                                                                </div> -->
                                                            </div>
                                                        </div>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php $tabIndex++; } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS for Half/Full Toggle -->
<script>
function updateSinglePrice(id) {
    let radios = document.getElementsByName("size_" + id);
    for (let r of radios) {
        if (r.checked) {
            document.getElementById("price_" + id).innerText = "₹" + r.value;
        }
    }
}

function setGlobalPrice(type) {
    const allPrices = document.querySelectorAll('[id^="price_"]');
    allPrices.forEach(priceEl => {
        const pid = priceEl.id.split("_")[1];
        const value = type === 'half' ? priceEl.dataset.half : priceEl.dataset.full;
        priceEl.innerText = "₹" + value;

        // auto-check that radio
        const radios = document.getElementsByName("size_" + pid);
        radios.forEach(radio => {
            if (radio.value === value) radio.checked = true;
        });
    });
}
</script>


<!-- Script to update price -->
<script>
function updatePrice(id) {
    const radios = document.getElementsByName('size_' + id);
    for (const radio of radios) {
        if (radio.checked) {
            document.getElementById('price_' + id).innerText = '₹' + radio.value;
        }
    }
}
</script>

<!-- booking foem -->

<div class="contact-form-area default-padding">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="form-box shadow-lg p-5 rounded bg-white">
          <div class="heading text-center mb-4">
            <h5 class="text-muted">BOOK YOUR TABLE</h5>
            <h2 class="fw-bold">Book Your Order</h2>
          </div>

          <form action="submit_booking.php" method="POST" id="bookingForm">
            <div class="row g-4">

              <!-- Name -->
              <div class="col-md-6">
                <input type="text" name="customer_name" class="form-control" placeholder="Your Name *" required>
              </div>

              <!-- Mobile -->
              <div class="col-md-6">
                <input type="tel" name="mobile" class="form-control" placeholder="Mobile Number *" pattern="[0-9]{10}" required>
              </div>

              <!-- Email -->
              <div class="col-md-12">
                <input type="email" name="email" class="form-control" placeholder="Email Address *" required>
              </div>

              <!-- Table -->
              <div class="col-md-6">
                <select name="table_number" class="form-select" required>
                  <option value="">Select Table</option>
                  <?php for ($i = 1; $i <= 40; $i++) { ?>
                    <option value="<?= $i ?>">Table <?= $i ?></option>
                  <?php } ?>
                </select>
              </div>

              <!-- Category -->
              <div class="col-md-6">
                <select name="category_id" id="category_id" class="form-select" required>
                  <option value="">Select Category</option>
                  <?php
                  include 'config.php';
                  $cat_res = mysqli_query($conn, "SELECT * FROM tbl_product_category WHERE status=1");
                  while ($cat = mysqli_fetch_assoc($cat_res)) {
                    echo '<option value="'.$cat['id'].'">'.$cat['name'].'</option>';
                  }
                  ?>
                </select>
              </div>

              <!-- Product -->
              <div class="col-md-12">
                <select name="product_id" id="product_id" class="form-select" required disabled>
                  <option value="">Select Product</option>
                </select>
              </div>

              <!-- Size -->
           <div class="radio-group">
  <input type="radio" id="half" name="size" value="half" checked>
  <label for="half">Half</label>

  <input type="radio" id="full" name="size" value="full">
  <label for="full">Full</label>
</div>

              <!-- Quantity -->
              <div class="col-md-6">
                <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" required placeholder="Quantity">
              </div>

              <!-- Total Price -->
              <div class="col-md-6">
                <input type="text" name="total_price" id="total_price" class="form-control" readonly placeholder="Total Price">
              </div>

              <!-- Submit -->
              <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-dark w-100 py-2 fw-bold">Book Now</button>
              </div>

            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'include/footer.php'; ?>
<?php include 'include/js.php'; ?>
</body>
</html>

<!-- 🔧 JavaScript: Auto Product Load & Price Calculation -->
<script>
document.addEventListener("DOMContentLoaded", function () {
  const categorySelect = document.getElementById('category_id');
  const productSelect = document.getElementById('product_id');
  const quantityInput = document.getElementById('quantity');
  const totalPriceInput = document.getElementById('total_price');
  const sizeRadios = document.querySelectorAll('input[name="size"]');

  // Fetch products when category changes
  categorySelect.addEventListener('change', function () {
    const catId = this.value;
    productSelect.disabled = true;
    productSelect.innerHTML = '<option>Loading...</option>';

    fetch('get_products.php?cat_id=' + catId)
      .then(res => res.json())
      .then(data => {
        let html = '<option value="">Select Product</option>';
        data.forEach(product => {
          html += `<option value="${product.id}" data-half="${product.price_half}" data-full="${product.price_full}">${product.name}</option>`;
        });
        productSelect.innerHTML = html;
        productSelect.disabled = false;
        updateTotal();
      });
  });

  // Price Calculation Function
  function updateTotal() {
    const selectedProduct = productSelect.options[productSelect.selectedIndex];
    const size = document.querySelector('input[name="size"]:checked').value;
    const qty = parseInt(quantityInput.value) || 1;

    if (!selectedProduct || !selectedProduct.dataset[size]) {
      totalPriceInput.value = '';
      return;
    }

    const price = parseFloat(selectedProduct.dataset[size]);
    if (isNaN(price)) {
      totalPriceInput.value = '';
      return;
    }

    const total = price * qty;
    totalPriceInput.value = '₹' + total.toFixed(2);
  }

  // Event listeners
  productSelect.addEventListener('change', updateTotal);
  sizeRadios.forEach(radio => radio.addEventListener('change', updateTotal));
  quantityInput.addEventListener('input', updateTotal);
});
</script>

<style>
  .contact-form-area {
  padding: 60px 0;
  background: #f8f9fa;
}
.form-box {
  background: #fff;
  border-radius: 12px;
}
.form-control, .form-select {
  height: 48px;
  border-radius: 8px;
  font-size: 15px;
}
.form-control:focus, .form-select:focus {
  border-color: #c59d5f;
  box-shadow: none;
}
.btn-dark {
  background-color: #c59d5f;
  border: none;
}
.btn-dark:hover {
  background-color: #a27d3b;
}
.radio-group {
  display: flex;
  gap: 20px;
  margin: 10px 0;
}

.radio-group input[type="radio"] {
  display: none;
}

.radio-group label {
  padding: 10px 25px;
  border: 2px solid #ccc;
  border-radius: 30px;
  cursor: pointer;
  transition: all 0.3s ease;
  font-weight: 500;
  background-color: #fff;
  color: #333;
}

.radio-group input[type="radio"]:checked + label {
  background-color: #005eff;
  color: #fff;
  border-color: #005eff;
  box-shadow: 0 0 8px rgba(0, 94, 255, 0.4);
}

</style>
