<?php
// ----------------------------------------------------
// Database Connection Configuration
// ----------------------------------------------------
$dbHost = "localhost";
$dbUser = "root";
$dbPass = "Suraj@123";
$dbName = "if0_39975536_food"; // Ensure this is your actual database name

$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

// Connection error handling
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Select the database (optional, can be done in mysqli_connect)
mysqli_select_db($conn, $dbName) or die("Could not select database: " . mysqli_error($conn));

// Set timezone for date/time functions
ini_set('date.timezone', 'Asia/Kolkata');


// ----------------------------------------------------
// Path & URL Configuration
// ----------------------------------------------------

// Base URL for the website (IMPORTANT: Adjust this to your actual project URL)
// यह वह URL होना चाहिए जहाँ से आपका 'artbots' फोल्डर वेब पर एक्सेस किया जा सकता है।
// आपके द्वारा दिए गए URL (localhost/ronak/12.1.20.1/check/artbots/admin/blog-list.php) के अनुसार:
$baseURL = "https://tastybitefood.free.nf/admin/";

// Server-side absolute file system path to your 'artbots' project folder.
// *** यह सबसे महत्वपूर्ण लाइन है जिसे आपको अपनी वास्तविक सर्वर पाथ से बदलना होगा! ***
// उदाहरण के लिए, यदि आप XAMPP उपयोग कर रहे हैं और आपका project 'C:/xampp/htdocs/ronak/12.1.20.1/check/artbots/' पर है:
$projectServerPath = "C:/xampp/htdocs/ronak/12.1.20.1/check/artbots/";
// यदि आपका dbc.php 'admin' फोल्डर में है, तो आप इसका उपयोग कर सकते हैं (PHP 5.3+):
// $projectServerPath = realpath(__DIR__ . '/..') . '/';
// लेकिन ऊपर दिया गया सीधा पाथ ज्यादा स्पष्ट है, बस इसे सही करें।


// Web URL for displaying images (used in HTML <img> tags)
// यह अब सही पाथ बनाएगा: http://localhost/ronak/12.1.20.1/check/artbots/uploads/products/
$mainPath = $baseURL . "uploads/products/";

// Server-side path for full-size images (used by PHP functions like move_uploaded_file, unlink)
// यह अब सही सर्वर पाथ बनाएगा: C:/xampp/htdocs/ronak/12.1.20.1/check/artbots/uploads/products/
$productPath = $projectServerPath . "uploads/products/";

// Server-side path for thumbnails
$productPathThumb = $projectServerPath . "uploads/products/thumbs/";

// Other specific paths
$settingPath = $projectServerPath . "uploads/settings/";


// ----------------------------------------------------
// Global Variables & Company Information
// ----------------------------------------------------
$companyName = "Food";
$developerName = "Suraj Singh";
 $year = ("2025 Copyright");


// ----------------------------------------------------
// Table Names & Corresponding URLs
// ----------------------------------------------------

// Admin & Settings
$tblAdmin        = "tbl_admin";
$tblSetting      = "tbl_setting";
$urlSetting      = "setting.php?id=1";
$tblEnquiry      = "tbl_enquiry";
$urlEnquiryList  = "enquiry-list.php";
$roombooking      = "tbl_room_booking";
$urlroombooking  = "room-booking-list.php";

$tblboking      = "tbl_booking";
$urlbookingList  = "booking-list.php";
$tblorders      = "orders";
$urlorderList  = "order-list.php";

$tbluser      = "users";
$urluserList  = "user-list.php";

// Menu Management
$tblMenuCategory       = "tbl_menu_category";
$urlMenuCategory       = "menu-category.php";
$urlMenuCategoryList   = "menu-category-list.php";

$tblMenu         = "tbl_admin_menu";
$urlMenu         = "menu.php";
$urlMenuList     = "menu-list.php";

// Services
$tblService      = "tbl_services";
$urlService      = "service.php";
$urlServiceList  = "service-list.php";

// Team
$tblTeam         = "tbl_team";
$urlTeam         = "team.php";
$urlTeamList     = "team-list.php";

// Testimonials
$tblTestimonial      = "tbl_testimonial";
$urlTestimonial      = "testimonial.php";
$urlTestimonialList  = "testimonial-list.php";

// Banner
$tblBanner       = "tbl_banner";
$urlBanner       = "banner.php";
$urlBannerList   = "banner-list.php";

// Portfolio
$tblPortfolio        = "tbl_portfolio";
$urlPortfolio        = "portfolio.php";
$urlPortfolioList    = "portfolio-list.php";

$tblPortfolioImage       = "tbl_portfolio_image";
$urlPortfolioImage       = "portfolio-image.php";
$urlPortfolioImageList   = "portfolio-image-list.php";

// Blog
$tblBlog         = "tbl_blog";
$urlBlog         = "blog.php";
$urlblogList     = "blog-list.php";

// Product Management
$tblProductCategory      = "tbl_product_category";
$urlProductCategory      = "product-category.php";
$urlProductCatgoryList   = "product-category-list.php";

$tblProduct      = "tbl_product";
$urlProduct      = "product.php";
$urlProductList  = "product-list.php";

// Product Attributes (Size, Color)
$tblSize         = "tbl_size";
$urlSize         = "size.php";
$urlsizeList     = "size-list.php";

$tblColor        = "tbl_color";
$urlColor        = "color.php";
$urlColorList    = "color-list.php";

// Location & Delivery
$tblCity             = "tbl_city";
$urlCity             = "city.php";
$urlCityList         = "city-list.php";

$tblLocation         = "tbl_location";
$urlLocation         = "location.php";
$urlLocationList     = "location-list.php";

$tblDeliveryType     = "tbl_delivery_type";
$urlDeliveryType     = "delivery-type.php";
$urlDeliveryTypeList = "delivery-type-list.php";

$tblDeliveryBoy      = "tbl_delivery_boy";
$urlDeliveryBoy      = "delivery-boy.php";
$urlDeliveryBoyList  = "delivery-boy-list.php";

// Customer & Groups
$tblCustomer     = "tbl_customer";
$urlCustomer     = "customer.php";
$urlCustomerList = "customer-list.php";

$tblCustomerProduct      = "tbl_customer_product";
$urlCustomerProduct      = "customer-product.php";
$urlCustomerProductList  = "customer-product-list.php";

$tblGroup        = "tbl_group";
$urlGroup        = "group.php";
$urlGroupList    = "group-list.php";

$tblCustomerGroup      = "tbl_customer_group";
$urlCustomerGroup      = "customer-group.php";
$urlCustomerGroupList  = "customer-group-list.php";

// Order & Off-days
$tblTempOrder = "tbl_temp_order";
$tblOrder     = "tbl_order";

$tblOffDays      = "tbl_off_days";
$urlOffDays      = "offdays.php";
$urlOffDaysList  = "offdays-list.php";

// Course Management (if applicable)
$tblCourseCategory       = "tbl_course_category";
$urlCourseCategory       = "course-category.php";
$urlCourseCategoryList   = "course-category-list.php";

$tblCourse       = "tbl_course";
$urlCourse       = "course.php";
$urlCourseList   = "course-list.php";

// Partners & Awards
$tblPartner      = "tbl_partner";
$urlPartner      = "partner.php";
$urlPartnerList  = "partner-list.php";

$tblAward        = "tbl_award";
$urlAward        = "award.php";
$urlAwardList    = "award-list.php";


// this is image gallery 
$tblgallery        = "tbl_gallery";
$urlgallery        = "gallery.php";
$urlgalleryList    = "gallery-list.php";


?>