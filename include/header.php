<?php include 'config.php'; ?>
<header>
  <!-- Start Navigation -->
  <nav class="navbar mobile-sidenav navbar-sticky navbar-default validnavs">
    <div class="container d-flex justify-content-between align-items-center">
      <!-- Brand + toggle -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
          <i class="fa fa-bars"></i>
        </button>
        <a class="navbar-brand" href="index.php">
          <img src="admin/uploads/products/<?= $row['image1'] ?>" class="logo" alt="Logo">
        </a>
      </div>
      <!-- Menu -->
      <div class="collapse navbar-collapse" id="navbar-menu">
        <img src="assets/img/logo-2.png" alt="Logo" class="d-block d-lg-none mb-3">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
          <i class="fa fa-times"></i>
        </button>
        <ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
          <li><a href="home">Home</a></li>
          <li><a href="team">About Us</a></li>
          <li><a href="shoping">Shop</a></li>
          <li><a href="room">Room</a></li>
          <li><a href="contact">Reservation</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
      <!-- Desktop Icons: Wishlist, Cart, Account -->
      <div class="attr-right d-none d-lg-flex align-items-center gap-3">
        <div class="attr-nav d-flex align-items-center">
          <ul class="list-unstyled d-flex mb-0 align-items-center gap-3">
            <!-- Cart -->
            <li>
              <a href="cart" class="icon-btn" title="Cart">
                <i class="fa fa-shopping-cart"></i>
              </a>
            </li>
            <!-- Account -->
            <li>
              <a href="my-account" class="account-btn btn btn-outline-primary">
                <span class="icon">User</span> My Account
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="overlay-screen"></div>
  </nav>
  <!-- End Navigation -->

  <!-- Mobile Bottom Nav (Room Icon Added) -->
  <div class="mobile-bottom-nav d-lg-none">
    <a href="home" class="nav-item">
      <i class="fa fa-home"></i>
      <span>Home</span>
    </a>
    <a href="shoping" class="nav-item">
      <i class="fa fa-shopping-bag"></i>
      <span>Food</span>
    </a>
    <a href="room" class="nav-item"> <!-- Room Icon Added -->
      <i class="fa fa-bed"></i>
      <span>Room</span>
    </a>
    <a href="cart" class="nav-item">
      <i class="fa fa-shopping-cart"></i>
      <span>Cart</span>
    </a>
    <a href="my-account" class="nav-item">
      <i class="fa fa-user"></i>
      <span>Account</span>
    </a>
  </div>
</header>

<style>
  /* Account Button (Desktop) */
  .account-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    font-size: 15px;
    font-weight: 600;
    color: #fff;
    text-decoration: none;
    border-radius: 30px;
    background: linear-gradient(45deg, #0072ff, #00c6ff);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
  }
  .account-btn:hover {
    background: linear-gradient(45deg, #00c6ff, #0072ff);
    transform: translateY(-2px);
  }

  /* Wishlist & Cart Icons (Desktop) */
  .icon-btn {
    color: #333;
    font-size: 20px;
    position: relative;
    text-decoration: none;
    transition: color 0.3s ease;
  }
  .icon-btn:hover {
    color: #0072ff;
  }

  /* Mobile Bottom Nav */
  .mobile-bottom-nav {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: #fff;
    border-top: 1px solid #ddd;
    display: flex;
    justify-content: space-around;
    align-items: center;
    padding: 6px 0;
    z-index: 9999;
    box-shadow: 0 -1px 8px rgba(0,0,0,0.1);
  }
  .mobile-bottom-nav .nav-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    color: #444;
    font-size: 13px;
    text-decoration: none;
    flex: 1;
  }
  .mobile-bottom-nav .nav-item i {
    font-size: 18px;
    margin-bottom: 2px;
  }
  .mobile-bottom-nav .nav-item.active,
  .mobile-bottom-nav .nav-item:hover {
    color: #0072ff;
  }

  body {
    padding-bottom: 60px; /* Prevent content hidden behind nav */
  }

  @media (min-width: 992px) {
    .mobile-bottom-nav {
      display: none;
    }
  }
</style>