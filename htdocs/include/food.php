<div class="best-food-style-one-area default-padding bottom-less bg-light text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="site-heading text-center">
                    <h4 class="sub-title text-warning mb-2 animate__animated animate__fadeIn">
                        Our Special
                    </h4>
                    <h2 class="title fw-bold display-5 text-dark animate__animated animate__fadeInUp">
                        Popular Burgers
                    </h2>
                    <p class="text-muted mt-2 animate__animated animate__fadeInUp animation-delay-1">
                        Juicy, cheesy, aur bilkul desi taste wale!
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <!-- Bootstrap Carousel (No Icons / Controls / Indicators) -->
        <div id="popularBurgerCarousel" class="carousel slide shadow-lg rounded-3 overflow-hidden" data-bs-ride="carousel" data-bs-interval="4000">
            <div class="carousel-inner">
                <?php
                $query = "SELECT * FROM tbl_product WHERE status=1 ORDER BY id DESC LIMIT 8";
                $result = mysqli_query($conn, $query);
                $products = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    $products[] = $row;
                }

                if (count($products) > 0) {
                    $chunks = array_chunk($products, 4);
                    $active = 'active';
                    foreach ($chunks as $chunk) {
                ?>
                        <div class="carousel-item <?= $active ?>">
                            <div class="row justify-content-center g-4">
                                <?php foreach ($chunk as $row) {
                                    $image = !empty($row['image1']) ? 'admin/uploads/products/' . $row['image1'] : 'assets/img/food/default.jpg';
                                    $name = htmlspecialchars($row['name']);
                                    $price = number_format((float)$row['price_full'], 2);
                                ?>
                                    <div class="col-xl-3 col-lg-4 col-md-6">
                                        <div class="best-food-card h-100 position-relative overflow-hidden rounded-3 shadow-sm bg-white 
                                                    border border-light animate__animated animate__zoomIn">
                                            
                                            <!-- Image with Gradient Overlay -->
                                            <div class="thumb position-relative overflow-hidden rounded-top-3">
                                                <img src="<?= $image ?>" alt="<?= $name ?>" 
                                                     class="img-fluid w-100 burger-img" 
                                                     style="height: 220px; object-fit: cover; transition: all 0.5s ease;">
                                                <div class="overlay-gradient"></div>
                                                <div class="badge-hot bg-danger text-white px-3 py-1 rounded-pill position-absolute top-0 start-0 m-3 
                                                            animate__animated animate__pulse animate__infinite">
                                                    HOT
                                                </div>
                                            </div>

                                            <!-- Info -->
                                            <div class="info p-4 text-center d-flex flex-column justify-content-between flex-grow-1">
                                                <h5 class="mb-2 fw-bold text-dark fs-5 burger-name">
                                                    <a href="add_to_cart.php?id=<?= $row['id'] ?>&type=full" 
                                                       class="text-decoration-none text-dark stretched-link">
                                                        <?= $name ?>
                                                    </a>
                                                </h5>
                                                <div class="price-tag mt-2">
                                                    <span class="text-danger fw-bold fs-4">₹<?= $price ?></span>
                                                    <small class="text-muted d-block">Full Size</small>
                                                </div>
                                                <button class="btn btn-warning btn-sm mt-3 w-100 rounded-pill fw-bold shadow-sm add-to-cart">
                                                    Add to Cart
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                <?php
                        $active = '';
                    }
                } else {
                    echo '<div class="carousel-item active py-5"><h4 class="text-center text-muted">Koi burger nahi mila</h4></div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Clean CSS (No Icons, No Arrows, No Indicators) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    .best-food-style-one-area {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 80px 0 60px;
    }

    .best-food-card {
        transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        border: none !important;
        overflow: hidden;
    }

    .best-food-card:hover {
        transform: translateY(-12px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
        z-index: 10;
    }

    .burger-img {
        transition: transform 0.6s ease;
    }

    .best-food-card:hover .burger-img {
        transform: scale(1.15);
    }

    .overlay-gradient {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(transparent 40%, rgba(0,0,0,0.6));
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .best-food-card:hover .overlay-gradient {
        opacity: 1;
    }

    .badge-hot {
        font-size: 0.8rem;
        font-weight: 700;
        animation-duration: 1.5s;
        z-index: 2;
        letter-spacing: 0.5px;
    }

    .add-to-cart {
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.3s ease;
    }

    .best-food-card:hover .add-to-cart {
        opacity: 1;
        transform: translateY(0);
    }

    @media (max-width: 768px) {
        .best-food-card:hover { transform: translateY(-8px); }
        .badge-hot { font-size: 0.7rem; padding: 4px 8px !important; }
    }

    .animation-delay-1 { animation-delay: 0.2s; }
</style>

<!-- Add-to-cart Script -->
<script>
    document.querySelectorAll('.add-to-cart').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const link = this.parentElement.querySelector('a.stretched-link').href;
            const originalText = this.innerHTML;
            this.innerHTML = 'Added!';
            this.classList.remove('btn-warning');
            this.classList.add('btn-success');
            setTimeout(() => {
                window.location.href = link;
            }, 800);
        });
    });
</script>
