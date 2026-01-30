<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($row['meta_title'] ?? 'Food Menu') ?></title>
    <meta name="description" content="<?= htmlspecialchars($row['meta_description'] ?? 'Delicious food items from our menu.') ?>">
    <meta name="keywords" content="<?= htmlspecialchars($row['meta_keyword'] ?? 'food, restaurant, menu, online order') ?>">
    <?php include 'include/head.php'; ?>
    <style>
        :root {
            --primary: #ff5722;
            --text: #333;
            --light: #f9f9f9;
            --white: #fff;
            --gray: #ddd;
            --radius: 12px;
            --shadow: 0 4px 15px rgba(0,0,0,0.08);
            --transition: all 0.3s ease;
        }
        body {
            background: var(--light);
            font-family: 'Arial', sans-serif;
            color: var(--text);
            line-height: 1.6;
        }

        /* Breadcrumb */
        .breadcrumb-area {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('assets/img/shape/5.jpg') center/cover;
            padding: 60px 0;
            text-align: center;
            color: #fff;
        }
        .breadcrumb-area h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            font-weight: 700;
        }
        .breadcrumb {
            list-style: none;
            padding: 0;
            margin: 0;
            display: inline-flex;
            background: rgba(255,255,255,0.1);
            border-radius: 30px;
            padding: 8px 20px;
        }
        .breadcrumb li {
            color: #fff;
        }
        .breadcrumb li + li::before {
            content: "/";
            margin: 0 10px;
            opacity: 0.7;
        }
        .breadcrumb a {
            color: #fff;
            text-decoration: none;
        }
        .breadcrumb a:hover {
            text-decoration: underline;
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 0 15px;
        }

        /* Category Filter */
        .category-filter {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 12px;
            margin: 30px 0;
        }
        .cat-item {
            padding: 10px 24px;
            font-weight: 600;
            font-size: 15px;
            color: var(--text);
            background: var(--white);
            border: 2px solid var(--gray);
            border-radius: 30px;
            text-decoration: none;
            transition: var(--transition);
        }
        .cat-item:hover,
        .cat-item.active {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }

        /* Product Grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }
        .product {
            background: var(--white);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
            display: flex;
            flex-direction: column;
        }
        .product:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }
        .product-image {
            position: relative;
            overflow: hidden;
            height: 220px;
        }
        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .product:hover .product-image img {
            transform: scale(1.08);
        }

        .product-caption {
            padding: 18px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .product-title {
            margin: 0 0 8px;
            font-size: 1.1rem;
            font-weight: 700;
        }
        .product-title a {
            color: var(--text);
            text-decoration: none;
            transition: color 0.3s;
        }
        .product-title a:hover {
            color: var(--primary);
        }
        .price {
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--primary);
            margin: 8px 0;
        }
        .product-desc {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 12px;
            flex-grow: 1;
        }
        .cart-btn {
            display: block;
            background: var(--primary);
            color: #fff;
            text-align: center;
            padding: 10px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            margin-top: auto;
        }
        .cart-btn:hover {
            background: #e64a19;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
            flex-wrap: wrap;
            margin: 40px 0;
        }
        .pagination .page-item {
            list-style: none;
        }
        .pagination .page-link {
            display: block;
            padding: 10px 16px;
            color: var(--primary);
            border: 1px solid var(--gray);
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }
        .pagination .page-link:hover,
        .pagination .page-item.active .page-link {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }

        /* No Products */
        .no-products {
            text-align: center;
            padding: 60px 20px;
            color: #888;
            font-size: 1.2rem;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .products-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        @media (max-width: 992px) {
            .products-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .breadcrumb-area h1 {
                font-size: 2rem;
            }
        }
        @media (max-width: 600px) {
            .products-grid {
                grid-template-columns: 1fr;
            }
            .category-filter {
                gap: 8px;
            }
            .cat-item {
                padding: 8px 16px;
                font-size: 14px;
            }
            .product-image {
                height: 180px;
            }
        }
    </style>
</head>
<body>
<?php include 'include/topbar.php'; ?>
<?php include 'include/header.php'; ?>

<!-- BREADCRUMB -->
<div class="breadcrumb-area">
    <div class="container">
        <h1>Our Special Food Menu</h1>
        <ul class="breadcrumb">
            <li><a href="index.php">Home</a></li>
            <li>Food</li>
        </ul>
    </div>
</div>

<!-- SHOP SECTION -->
<div class="container">
    <!-- CATEGORY FILTER -->
    <div class="category-filter">
        <?php
        $current_category = $_GET['category'] ?? 'all';
        ?>
        <a href="?category=all" class="cat-item <?= ($current_category == 'all') ? 'active' : '' ?>">All</a>
        <?php
        $catQuery = mysqli_query($conn, "SELECT * FROM tbl_product_category WHERE status=1 ORDER BY name ASC");
        while ($cat = mysqli_fetch_assoc($catQuery)) {
            $slug = !empty($cat['slug']) ? $cat['slug'] : strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $cat['name']));
            $active = ($current_category == $slug) ? 'active' : '';
            echo '<a href="?category=' . $slug . '" class="cat-item ' . $active . '">' . htmlspecialchars($cat['name']) . '</a>';
        }
        ?>
    </div>

    <!-- PRODUCTS GRID -->
    <div class="products-grid">
        <?php
        $limit = 8;
        $page = max(1, (int)($_GET['page'] ?? 1));
        $offset = ($page - 1) * $limit;
        $category_slug = $current_category;
        $where_clause = "WHERE status=1";
        if ($category_slug !== 'all') {
            $catRes = mysqli_query($conn, "SELECT id FROM tbl_product_category WHERE slug='$category_slug' OR LOWER(REPLACE(name,' ','-'))='$category_slug'");
            $catRow = mysqli_fetch_assoc($catRes);
            $category_id = $catRow['id'] ?? 0;
            if ($category_id) {
                $where_clause .= " AND category_id = '$category_id'";
            }
        }
        $productQuery = "SELECT id, name, image1, description, price_half, price_full
                         FROM tbl_product $where_clause
                         ORDER BY id DESC LIMIT $offset, $limit";
        $productResult = mysqli_query($conn, $productQuery);
        $totalQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM tbl_product $where_clause");
        $totalRow = mysqli_fetch_assoc($totalQuery);
        $totalPages = ceil($totalRow['total'] / $limit);

        if (mysqli_num_rows($productResult) > 0):
            while ($product = mysqli_fetch_assoc($productResult)):
                $pid = $product['id'];
                $image = !empty($product['image1']) ? 'admin/uploads/products/' . $product['image1'] : 'assets/img/food/default.jpg';
                $name = htmlspecialchars($product['name']);
                $desc = strip_tags($product['description']);
                $price_half = number_format((float)$product['price_half'], 2);
                $price_full = number_format((float)$product['price_full'], 2);
        ?>
        <div class="product">
         <div class="product-image">
    <a href="add_to_cart.php?id=<?= $pid ?>&type=half">
        <img src="<?= $image ?>" alt="<?= htmlspecialchars($name) ?>" loading="lazy">
    </a>

                <!-- Wishlist Button Removed -->
            </div>
            <div class="product-caption">
                <h4 class="product-title">
                    <a href="add_to_cart.php?id=<?= $pid ?>&type=half"><?= $name ?></a>
                </h4>
                <div class="price">
                    <?= format_price($price_half, $current_currency) ?>
                </div>
                <p class="product-desc">
                    <?= strlen($desc) > 80 ? substr($desc, 0, 80) . '...' : $desc ?>
                </p>
                <a href="add_to_cart.php?id=<?= $pid ?>&type=half" class="cart-btn">
                    Add to Cart
                </a>
            </div>
        </div>
        <?php
            endwhile;
        else:
            echo '<div class="no-products"><h3>No products found in this category.</h3></div>';
        endif;
        ?>
    </div>

    <!-- PAGINATION -->
    <?php if ($totalPages > 1): ?>
    <ul class="pagination">
        <?php
        $base_url = '?category=' . urlencode($category_slug) . '&page=';
        if ($page > 1):
            echo '<li class="page-item"><a class="page-link" href="' . $base_url . ($page - 1) . '">Prev</a></li>';
        endif;
        for ($i = max(1, $page - 2); $i <= min($page + 2, $totalPages); $i++):
            $active = ($i == $page) ? 'active' : '';
            echo '<li class="page-item ' . $active . '"><a class="page-link" href="' . $base_url . $i . '">' . $i . '</a></li>';
        endfor;
        if ($page < $totalPages):
            echo '<li class="page-item"><a class="page-link" href="' . $base_url . ($page + 1) . '">Next</a></li>';
        endif;
        ?>
    </ul>
    <?php endif; ?>
</div>

<?php include 'include/footer.php'; ?>
<?php include 'include/js.php'; ?>

<!-- No Wishlist JS Needed -->
</body>
</html>