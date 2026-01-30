<?php
// topbar.php


    
// --- 1. Session Start ---
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config.php';

// --- 2. Currency Setup ---
$available_currencies = [
    'INR' => ['symbol' => '₹', 'rate' => 1],
    'USD' => ['symbol' => '$', 'rate' => 0.012],
    'EUR' => ['symbol' => '€', 'rate' => 0.011],
    'GBP' => ['symbol' => '£', 'rate' => 0.0095],
    'AUD' => ['symbol' => 'A$', 'rate' => 0.018],
    'CAD' => ['symbol' => 'C$', 'rate' => 0.016],
];

// --- 3. Handle Currency Change ---
if (isset($_GET['currency'])) {
    $new_currency = strtoupper($_GET['currency']);
    if (isset($available_currencies[$new_currency])) {
        $_SESSION['currency'] = $new_currency;
    }
    // Redirect to same page without currency param
    $redirect_url = strtok($_SERVER["REQUEST_URI"], '?');
    $params = $_GET;
    unset($params['currency']);
    if (!empty($params)) {
        $redirect_url .= '?' . http_build_query($params);
    }
    header('Location: ' . $redirect_url);
    exit;
}

// --- 4. Set Current Currency ---
$current_currency = $_SESSION['currency'] ?? 'INR';
$current_symbol = $available_currencies[$current_currency]['symbol'];
$current_rate = $available_currencies[$current_currency]['rate'];

/**
 * Format Price Function
 * Converts and displays price based on selected currency
 */
function format_price($price_in_inr) {
    global $current_currency, $available_currencies;
    $rate = $available_currencies[$current_currency]['rate'];
    $symbol = $available_currencies[$current_currency]['symbol'];
    $converted = floatval($price_in_inr) * $rate;

    // Round based on currency type
    $precision = ($current_currency === 'INR') ? 0 : 2;
    return $symbol . number_format($converted, $precision);
}
?>

<div class="top-bar-area top-bar-style-one bg-theme text-light">
  <div class="container">
    <div class="row align-center">
      <div class="col-lg-7">
        <ul class="item-flex">
          <li>
            <a href="tel:+4733378901">
              <i class="fas fa-phone-alt"></i>
              <span>Phone</span>: <?= $row['phone1'] ?>
            </a>
          </li>
          <li>
            <a href="mailto:<?= $row['email'] ?>">
              <i class="fas fa-envelope"></i>
              <span>Email</span>: <?= $row['email'] ?>
            </a>
          </li>
        </ul>
      </div>

      <div class="col-lg-5 text-end">
        <div class="item-flex" style="gap:15px; align-items:center;">

          <!-- 🔍 Search Button -->
          <a href="javascript:void(0)" class="search-toggle text-light">
            <i class="fas fa-search fa-lg"></i>
          </a>

          <!-- 💱 Currency Dropdown -->
          <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle d-flex align-items-center"
                    type="button" id="currencyDropdown" data-bs-toggle="dropdown"
                    aria-expanded="false"
                    style="background:none;border:none;color:#fff;font-weight:bold;font-size:14px;">
              <?= $current_symbol . ' ' . $current_currency ?>
              <i class="fas fa-angle-down ms-1"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="currencyDropdown">
              <?php foreach ($available_currencies as $code => $data): ?>
                <li>
                  <a class="dropdown-item <?= ($current_currency == $code) ? 'active' : '' ?>"
                     href="?currency=<?= $code ?>">
                    <?= $data['symbol'] . ' ' . $code ?>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>

          <!-- 🌐 Language Dropdown -->
          <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle d-flex align-items-center" type="button" id="langDropdown" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="assets/img/icon/flag.png" alt="Flag" class="me-1" width="20">
              English <i class="fas fa-angle-down ms-1"></i>
            </button>
            <ul class="dropdown-menu" aria-labelledby="langDropdown">
              <li><a class="dropdown-item lang-select" data-lang="en" href="#">English</a></li>
              <li><a class="dropdown-item lang-select" data-lang="hi" href="#">हिंदी</a></li>
            </ul>
          </div>

          <!-- 👤 User Account -->
          <div class="user-account d-flex align-items-center gap-2">
            <?php if(isset($_SESSION['user_id'])): ?>
              <a href="my-account.php" class="text-light" title="My Account"><i class="fas fa-user-circle fa-lg"></i></a>
              <a href="logout.php" class="text-light" title="Logout"><i class="fas fa-sign-out-alt fa-lg"></i></a>
            <?php else: ?>
              <a href="login.php" class="text-light" title="Login"><i class="fas fa-sign-in-alt fa-lg"></i></a>
            <?php endif; ?>
          </div>

          <!-- 🔗 Social Icons -->
          <div class="social d-flex align-items-center gap-2">
            <a href="<?= $row['link1'] ?>"><i class="fab fa-facebook-f"></i></a>
            <a href="<?= $row['link2'] ?>"><i class="fab fa-twitter"></i></a>
            <a href="<?= $row['link4'] ?>"><i class="fab fa-youtube"></i></a>
            <a href="<?= $row['link3'] ?>"><i class="fab fa-instagram"></i></a>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<!-- 🔎 Search Overlay -->
<div class="search-overlay">
  <span class="search-close">&times;</span>
  <form action="search.php" method="get" class="overlay-search-form">
    <input type="text" name="q" placeholder="Type to search products..." required>
    <button type="submit"><i class="fas fa-search"></i></button>
  </form>
</div>

<style>
/* 🔸 Search Overlay */
.search-overlay {
  position: fixed; top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0,0,0,0.9);
  display: none; justify-content: center; align-items: center;
  z-index: 9999; flex-direction: column; padding: 20px;
}
.search-overlay.active { display: flex; }
.search-overlay .search-close {
  position: absolute; top: 30px; right: 40px;
  font-size: 40px; color: #fff; cursor: pointer;
}
.overlay-search-form {
  width: 100%; max-width: 600px; display: flex;
  background: #fff; border-radius: 50px; overflow: hidden;
}
.overlay-search-form input {
  flex: 1; border: none; padding: 15px 20px;
  font-size: 18px; outline: none;
}
.overlay-search-form button {
  background: #ff5722; border: none;
  color: #fff; padding: 15px 25px; cursor: pointer;
  font-size: 18px;
}
.overlay-search-form button:hover { background: #e64a19; }

/* 🔸 User & Social Icons */
.user-account a, .social a {
  color: #fff; font-size: 18px; transition: 0.3s;
}
.user-account a:hover, .social a:hover {
  color: #ff5722;
}
.dropdown-menu a.active {
  background-color: #ff5722;
  color: #fff !important;
}
</style>

<script>
// Search Overlay Logic
document.querySelector('.search-toggle').addEventListener('click', () => {
  document.querySelector('.search-overlay').classList.add('active');
});
document.querySelector('.search-close').addEventListener('click', () => {
  document.querySelector('.search-overlay').classList.remove('active');
});
document.addEventListener('keydown', e => {
  if (e.key === "Escape") document.querySelector('.search-overlay').classList.remove('active');
});
</script>
