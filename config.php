<?php
$conn = mysqli_connect("localhost", "root", "Suraj@123","");
$db = "if0_39975536_food";

mysqli_select_db($conn, $db) or die(mysqli_error($conn));
//mysql_select_db($db,$conn) or die(mysql_error()); 
ini_set('date.timezone', 'Asia/Calcutta');

/*---------------------------*/
/*---------------------------*/
$host = $_SERVER['DOCUMENT_ROOT'];
$currentUrl = $host;

$currentUrl2 = '';
//product-----------shoes\media\product
$settingPath         = $currentUrl . "/ayurvedic/media/setting/";

$websiteLink = "https://tastybitefood.free.nf";
$thumbPath = "media/image/thumb/";
$mainPath = "media/image/";

$productPath           = $currentUrl . "/media/image/";
$productPathThumb       = $currentUrl . "/media/image/thumb/";
// ================== Global variable =====================

$tblAdmin     = "tbl_admin";
$tblSetting = "tbl_setting";
$urlSetting = "setting.php";
$tblEnquiry = "tbl_enquiry";
$tblMenuCategory         = "tbl_menu_category";
$tblMenu         = "tbl_admin_menu";
$tblbooking        = "tbl_room_booking";
$tbluser        = "users";

$tblService         = "tbl_services";

$tblTeam         = "tbl_team";

$tblTestimonial        = "tbl_testimonial";

// / ========= tbl_banner ========
$tblBanner        = "tbl_banner";

// / ========= tbl_portfolio ========
$tblPortfolio        = "tbl_portfolio";


// / / ========= tbl_blog ========
$tblBlog        = "tbl_blog";

// / / ========= tbl_portfolio_img ========
$tblPortfolioImage        = "tbl_portfolio_image";

// / / ========= tbl_menu_category ========
$tblMenuCategory       = "tbl_menu_category";

// / / ========= tbl_menu ========
$tblMenu       = "tbl_admin_menu";

// / / ========= tbl_product_category ========
$tblProductCategory       = "tbl_product_category";

// / / ========= tbl_product ========
$tblProduct      = "tbl_product";
$tblDance        = "tbl_dance";

// / / ========= tbl_setting ========
$tblSetting      = "tbl_setting";
$urlSetting    = "setting.php?id=1";

// / / ========= tbl_size ========
$tblSize      = "tbl_size";
$urlSize    = "size.php";
$urlsizeList    = "size-list.php";


// / / ========= tbl_color ========
$tblColor      = "tbl_color";

// ========= tbl_city ========
$tblCity         = "tbl_city";

// ========= tbl_location ========
$tblLocation         = "tbl_location";

// ========= tbl_delivery_type ========
$tblDeliveryType         = "tbl_delivery_type";

// ========= tbl_customer ========
$tblCustomer         = "tbl_customer";

// ========= tbl_customer_product ========
$tblCustomerProduct         = "tbl_customer_product";

// ========= tbl_group ========
$tblGroup         = "tbl_group";

// ========= tbl_customer_group ========
$tblCustomerGroup         = "tbl_customer_group";
// ========= tbl_delivery_boy ========
$tblDeliveryBoy         = "tbl_delivery_boy";


// ========= tbl_temp_order ========
$tblTempOrder        = "tbl_temp_order";

$tblgallery        = "tbl_gallery";




// ========= tbl_off_days ========
$tblOffDays         = "tbl_off_days";

$tblCourseCategory         = "tbl_course_category";
$tblCourse         = "tbl_course";
$tblPartner      = "tbl_partner";
$tblAward      = "tbl_award";
$tblEnquiry      = "tbl_enquiry";

$user_id=1;
$sql=mysqli_query($conn,"select * from $tblSetting where id='$user_id'")or die(mysqli_error($conn));
$row=mysqli_fetch_assoc($sql);
extract($row);
