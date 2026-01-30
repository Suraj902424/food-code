<?php
// === CONFIGURATION & INITIALIZATION ===
// Session को शुरू करें
session_start();

// Strict error reporting for MySQLi (Recommended for development)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); 

// 'config.php' को सिर्फ एक बार लोड करें, सुनिश्चित करें कि इसमें $conn है
require_once 'config.php'; 

// --- डेटाबेस कनेक्शन जाँच ---
if (!isset($conn) || $conn->connect_error) {
    die("Error: Database connection failed. Please check config.php.");
}

// === AUTHENTICATION & REDIRECTION ===
// 'USER_ID' (uppercase) का उपयोग करें, जैसा कि हमने login.php में सेट किया है
if (!isset($_SESSION['USER_ID'])) {
    // Redirection से पहले session को clean करें
    session_destroy();
    header('Location: login.php'); 
    exit;
}

// User ID को सुरक्षित रूप से integer में cast करें
$user_id = (int)$_SESSION['USER_ID'];
$wishlist_items = [];
$error_message = null;

// === FETCH WISHLIST ITEMS ===
$query = "
    SELECT  
        p.id,
        p.name,
        p.image1,
        p.description,
        p.price_half,
        p.price_full
    FROM tbl_wishlist w
    JOIN tbl_product p ON p.id = w.product_id
    WHERE w.user_id = ?
    ORDER BY w.added_at DESC
";

try {
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $wishlist_items[] = $row;
        }
        $stmt->close();
    }
} catch (Exception $e) {
    // Database Query Error Handling
    error_log("Wishlist Query Error: " . $e->getMessage()); 
    $error_message = "Could not fetch your favorites right now. Please try again.";
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist - TastyBite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #e63946; /* Red */
            --success: #2a9d8f; /* Teal */
            --light: #f8f9fa;
            --dark-text: #1d3557;
        }
        body {
            background-color: var(--light);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .wishlist-card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }
        .wishlist-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .card-img-top {
            height: 220px;
            object-fit: cover;
        }
        .card-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--dark-text);
            white-space: nowrap; /* Prevents overflow in single line */
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .card-text {
            color: #6c757d;
            font-size: 0.9rem;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: 0.5rem; /* Reduced margin */
        }
        .price {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--primary);
        }
        .btn-view, .btn-remove {
            font-weight: 600;
            border-radius: 8px;
            transition: background-color 0.3s;
        }
        .btn-view {
            background-color: var(--success) !important;
        }
        .btn-remove {
            background-color: #dc3545 !important;
        }
        .badge-wishlist {
            background-color: var(--primary) !important;
            color: white;
            font-size: 0.8em;
            vertical-align: middle;
        }
        .empty-state {
            padding: 4rem 1rem;
            color: #6c757d;
        }
        .empty-state i {
            font-size: 4rem;
            color: #ced4da;
        }
    </style>
</head>
<body>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
        <h1 class="text-dark">
            <i class="fas fa-heart text-danger me-2"></i> My Wishlist
            <span class="badge badge-wishlist ms-2" id="wishlist-count"><?= count($wishlist_items) ?></span>
        </h1>
        <a href="index.php" class="btn btn-outline-secondary d-none d-sm-inline-flex align-items-center">
            <i class="fas fa-shopping-basket me-2"></i> Continue Shopping
        </a>
    </div>

    <?php if ($error_message): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($error_message) ?>
        </div>

    <?php elseif (empty($wishlist_items)): ?>
        <div class="empty-state bg-white rounded-4 shadow p-5 text-center">
            <i class="fas fa-heart-broken mb-3"></i>
            <h4 class="mt-3 text-dark">Your wishlist is empty</h4>
            <p class="text-muted">Looks like you haven't added any favorite food items yet.</p>
            <a href="products.php" class="btn btn-primary btn-lg mt-3" style="background-color: var(--primary); border: none;">
                <i class="fas fa-search me-2"></i> Explore Products
            </a>
        </div>

    <?php else: ?>
        <div class="row g-4" id="wishlist-grid">
            <?php foreach ($wishlist_items as $item): ?>
                <div class="col-sm-6 col-md-4 col-lg-3 item-col" data-product-id="<?= (int)$item['id'] ?>">
                    <div class="card h-100 wishlist-card">
                        
                        <div style="height: 220px; overflow: hidden;">
                            <img 
                                src="<?= htmlspecialchars($item['image1'] ?? 'assets/images/default.jpg') ?>" 
                                class="card-img-top" 
                                alt="<?= htmlspecialchars($item['name']) ?>"
                                onerror="this.src='assets/images/default.jpg'"
                            >
                        </div>

                        <div class="card-body d-flex flex-column p-3">
                            <h5 class="card-title" title="<?= htmlspecialchars($item['name']) ?>">
                                <?= htmlspecialchars($item['name']) ?>
                            </h5>

                            <div class="mt-auto">
                                <span class="price">
                                    ₹<?= number_format((float)$item['price_half'], 2) ?>
                                </span>
                                <?php if (!empty($item['price_full']) && $item['price_full'] > $item['price_half']): ?>
                                    <small class="text-muted ms-2 text-decoration-line-through">
                                        ₹<?= number_format((float)$item['price_full'], 2) ?> (Full)
                                    </small>
                                <?php else: ?>
                                    <small class="text-muted ms-1">(Half Plate)</small>
                                <?php endif; ?>
                            </div>

                            <p class="card-text my-2 flex-grow-1">
                                <?= htmlspecialchars(
                                        (strlen($item['description']) > 80)
                                            ? substr($item['description'], 0, 80) . '...'
                                            : $item['description']
                                ) ?>
                            </p>
                            
                            <div class="d-grid gap-2 mt-2">
                                <a href="product.php?id=<?= (int)$item['id'] ?>" 
                                   class="btn btn-sm btn-view text-white">
                                    <i class="fas fa-eye me-1"></i> View Details
                                </a>
                                <button type="button" 
                                   class="btn btn-sm btn-remove text-white"
                                   onclick="removeFromWishlist(<?= (int)$item['id'] ?>, this)">
                                    <i class="fas fa-trash me-1"></i> Remove
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
/**
 * Removes a product from the wishlist using AJAX.
 */
function removeFromWishlist(productId, button) {
    if (!confirm('Are you sure you want to remove this item from your wishlist?')) {
        return;
    }

    const formData = new FormData();
    formData.append('action', 'remove');
    formData.append('product_id', productId);

    // Disable button and show loading state
    const originalText = button.innerHTML;
    button.disabled = true;
    button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Removing...';

    // Fetch request to the action file
    fetch('wishlist-action.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        // Handle non-JSON response gracefully (e.g., if a PHP error occurs)
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.status === 'success') {
            // Success: Remove the item card from the DOM
            const cardElement = button.closest('.item-col');
            if (cardElement) {
                cardElement.remove();
                updateWishlistCount();
            }
        } else {
            // Failure: Show alert and re-enable button
            alert(data.message || 'Failed to remove the item from the wishlist.');
            button.innerHTML = originalText;
            button.disabled = false;
        }
    })
    .catch(error => {
        // Network/Parsing Error
        console.error('Fetch error:', error);
        alert('An unexpected error occurred. Please check the console for details.');
        button.innerHTML = originalText;
        button.disabled = false;
    });
}

/**
 * Updates the displayed wishlist count badge and reloads if the list is empty.
 */
function updateWishlistCount() {
    const count = document.querySelectorAll('.item-col').length;
    const countBadge = document.getElementById('wishlist-count');
    
    if (countBadge) {
        countBadge.textContent = count;
    }
    
    // If the list is empty after removal, refresh to show the empty state
    if (count === 0) {
        // Delay reload slightly to allow badge update
        setTimeout(() => {
            location.reload(); 
        }, 300); 
    }
}
</script>

</body>
</html>