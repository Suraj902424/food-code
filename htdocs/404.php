<?php
// Agar aapka site already header/footer include karta hai to ye file adjust kar lo.
// Set HTTP status 404
http_response_code(404);

// Optional: agar aap chahte ho search engines ko index na karein
header("X-Robots-Tag: noindex, nofollow");

// Site base URL (agar zarurat ho)
$base_url = '/'; // change to your site root, e.g. '/mysite/' or 'https://example.com/'
?>
<!doctype html>
<html lang="hi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>404 — Page Not Found</title>
  <meta name="description" content="Requested page not found. Home पर जाएँ या search करें.">
  <meta name="robots" content="noindex, nofollow">
    <?php include 'include/head.php'; ?>

  <!-- Basic styling (change to your CSS or use your main stylesheet) -->
  <style>
    :root{--bg:#f6f7fb;--card:#ffffff;--muted:#6b7280;--accent:#2563eb;}
    *{box-sizing:border-box}
    body{margin:0;font-family:Tahoma, Arial, sans-serif;background:var(--bg);color:#111}
    .wrap{min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px}
    .card{background:var(--card);max-width:980px;width:100%;padding:32px;border-radius:12px;
          box-shadow:0 6px 24px rgba(15,23,42,0.08);display:grid;grid-template-columns:1fr 360px;gap:24px}
    .left h1{font-size:48px;margin:0 0 12px}
    .left p{color:var(--muted);margin:0 0 18px;line-height:1.6}
    .home-btn{display:inline-block;padding:10px 18px;border-radius:8px;background:var(--accent);
             color:#fff;text-decoration:none;font-weight:600}
    .small-links{margin-top:14px}
    .small-links a{color:var(--accent);text-decoration:none;margin-right:12px;font-size:14px}
    .search-box{display:flex;gap:8px;margin-top:18px}
    .search-box input{flex:1;padding:12px;border:1px solid #e5e7eb;border-radius:8px;font-size:15px}
    .search-box button{padding:12px 14px;border-radius:8px;border:0;background:#111;color:#fff}
    .right{background:linear-gradient(180deg, #fbfdff, #fff);padding:18px;border-radius:8px;border:1px solid #f1f5f9}
    .right h3{margin:0 0 10px}
    .help-list{list-style:none;padding:0;margin:0}
    .help-list li{padding:8px 0;border-bottom:1px dashed #eef2f7}
    .help-list li a{color:#0f172a;text-decoration:none}
    @media (max-width:880px){
      .card{grid-template-columns:1fr; padding:20px}
      .left h1{font-size:36px}
    }
  </style>
</head>
<body>
        <!-- Start Preloader 
    ============================================= -->
    <?php include 'include/preloader.php'; ?>
    <!-- Start Header Top 
    ============================================= -->
    <?php include 'include/topbar.php'; ?>
    <!-- End Header Top -->


    <!-- Header 
    ============================================= -->
    <?php include 'include/header.php'; ?>
    <!-- End Header -->
  <div class="wrap">
    <div class="card" role="main" aria-labelledby="pageTitle">
      <div class="left">
        <h1 id="pageTitle">404 — Page Not Found</h1>
        <p>Jo page aap dhundh rahe hain, wo mil nahi paaya. Shayad URL galat ho, page shift hua ho, ya delete kar diya gaya ho.</p>

        <!-- Search form (aapki site search handler pe submit kare) -->
        <form class="search-box" action="<?php echo htmlspecialchars($base_url . 'search.php'); ?>" method="get" role="search" aria-label="Site search">
          <input name="q" type="search" placeholder="Search karen (example: course name, topic)" aria-label="Search query">
          <button type="submit" aria-label="Search">Search</button>
        </form>

        <div style="margin-top:18px;">
          <a class="home-btn" href="<?php echo htmlspecialchars($base_url); ?>">Home पर जाएँ</a>
          <div class="small-links">
            <a href="<?php echo htmlspecialchars($base_url . 'sitemap.php'); ?>">Sitemap</a>
            <a href="<?php echo htmlspecialchars($base_url . 'contact'); ?>">Contact</a>
            <a href="<?php echo htmlspecialchars($base_url . 'help.php'); ?>">Help</a>
          </div>
        </div>
      </div>

      <aside class="right" aria-label="Helpful links and suggestions">
        <h3>Helpful links</h3>
        <ul class="help-list">
          <li><a href="<?php echo htmlspecialchars($base_url . 'shop'); ?>">Shop</a></li>
          <li><a href="<?php echo htmlspecialchars($base_url . 'team'); ?>">About Us</a></li>
         
        </ul>

        <div style="margin-top:12px;color:var(--muted);font-size:13px">
          Agar aapko lagta hai yeh error galti se aa rahi hai, toh <a href="<?php echo htmlspecialchars($base_url . 'contact.php'); ?>">humein batayein</a>.
        </div>
      </aside>
    </div>
  </div>
  <?php include 'include/footer.php' ?> 
    <!-- End Footer -->
    
    <!-- jQuery Frameworks
    ============================================= -->
    <?php include 'include/js.php' ?>
  <!-- Optional: small script to track the missing URL (for logs) -->
  <script>
    (function(){
      try {
        var payload = {
          url: location.href,
          ref: document.referrer || ''
        };
        // Send to a logging endpoint (create on server) - optional and safe (no PII)
        navigator.sendBeacon && navigator.sendBeacon('<?php echo htmlspecialchars($base_url . "log-404.php"); ?>', JSON.stringify(payload));
      } catch(e){}
    })();
  </script>
</body>
</html>
