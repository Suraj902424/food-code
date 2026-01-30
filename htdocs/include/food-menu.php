<div class="food-menu-style-four-area overflow-hidden default-padding bg-gray">
    <div class="container">
        <!-- Section Heading -->
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="site-heading">
                    <h4 class="sub-title">Food Menu</h4>
                    <h2 class="title">Our Specials Menu</h2>
                </div>
            </div>
        </div>


    <!-- Floating Image -->
    <div class="food-menu-style-four-items">
        <div class="upDownScrol animate-up-down">
            <img src="assets/img/illustration/18.png" alt="Image Not Found">
        </div>

        <!-- Category Tabs -->
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="nav nav-tabs food-menu-nav style-three four" id="nav-tab" role="tablist">
                    <?php
                    include 'config.php';
                    $categoryResult = mysqli_query($conn, "SELECT * FROM tbl_product_category WHERE status = 1 ORDER BY id ASC");
                    $tabIndex = 1;

                    while ($cat = mysqli_fetch_assoc($categoryResult)) {
                        $active = ($tabIndex === 1) ? 'active' : '';
                        $ariaSelected = ($tabIndex === 1) ? 'true' : 'false';
                        $tabId = 'tab' . $tabIndex;
                    ?>
                        <button class="nav-link <?= $active ?>"
                                id="nav-id-<?= $tabIndex ?>"
                                data-bs-toggle="tab"
                                data-bs-target="#<?= $tabId ?>"
                                type="button"
                                role="tab"
                                aria-controls="<?= $tabId ?>"
                                aria-selected="<?= $ariaSelected ?>">
                            <?= htmlspecialchars($cat['name']) ?>
                        </button>
                    <?php 
                        $tabIndex++; 
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>
```

</div>

<!-- Product Items -->

<div class="col-lg-12">
    <div class="tab-content food-style-four-content" id="nav-tabContent">
        <?php
        mysqli_data_seek($categoryResult, 0);
        $tabIndex = 1;

    while ($category = mysqli_fetch_assoc($categoryResult)) {
        $tabId = 'tab' . $tabIndex;
        $activeClass = ($tabIndex === 1) ? 'show active' : '';
        $categoryId = $category['id'];
    ?>
    <div class="tab-pane fade <?= $activeClass ?>" id="<?= $tabId ?>" role="tabpanel" aria-labelledby="nav-id-<?= $tabIndex ?>">
        <div class="container">
            <?php
            $productResult = mysqli_query($conn, "SELECT * FROM tbl_product WHERE category_id = $categoryId AND status = 1");
            $counter = 0;

            while ($product = mysqli_fetch_assoc($productResult)) {
                $pid = $product['id']; // define product id
                $image = !empty($product['image1']) ? 'admin/uploads/products/' . $product['image1'] : 'assets/img/food/default.jpg';
                $name = htmlspecialchars($product['name']);
                $desc = strip_tags($product['description']);
                $price_half = htmlspecialchars($product['price_half']);
                $price_full = htmlspecialchars($product['price_full']);

                if ($counter % 2 === 0) echo '<div class="row mb-4">';
            ?>
                <div class="col-xl-6">
                    <div class="food-menus-item">
                        <ul class="meal-items">
                            <li>
                                <div class="thumbnail">
                                    <img src="<?= $image ?>" alt="<?= $name ?>">
                                </div>
                                <div class="content">
                                    <div class="top">
                                        <div class="title">
                                            <h4><a href="shop"><?= $name ?></a></h4>
                                        </div>
                                        <div class="price">
                                            <span>Half: ₹<?= $price_half ?></span><br>
                                            <span>Full: ₹<?= $price_full ?></span>
                                        </div>
                                    </div>
                                    <div class="bottom">
                                        <div class="left">
                                            <p><?= $desc ?></p>
                                        </div>
                                        <div class="right">
                                            <p>Free Drinks</p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php
                $counter++;
                if ($counter % 2 === 0) echo '</div>';
            }

            if ($counter % 2 !== 0) echo '</div>'; // close last unclosed row
            ?>
        </div>
    </div>
    <?php 
        $tabIndex++; 
    } ?>
</div>
```

</div>
