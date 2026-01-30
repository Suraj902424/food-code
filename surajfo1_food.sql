-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 30, 2026 at 08:44 AM
-- Server version: 11.4.9-MariaDB
-- PHP Version: 8.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `surajfo1_food`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `plate_type` enum('half','full') DEFAULT 'full'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `created_at`, `plate_type`) VALUES
(8, 2, 4, 1, '2025-09-08 17:42:57', 'full');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(11) NOT NULL,
  `category` enum('Main Dishes','Desserts','Sea Food','Beverage') NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `ingredients` text DEFAULT NULL,
  `offer` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `payment_method` enum('COD','Online') DEFAULT NULL,
  `status` enum('Pending','Confirmed','Delivered','Undelivered') DEFAULT 'Pending',
  `expected_delivery_date` date DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `state` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `customer_name`, `address`, `phone`, `payment_method`, `status`, `expected_delivery_date`, `total_amount`, `created_at`, `state`, `city`, `pincode`) VALUES
(1, 7, 'Suraj singh', 'kjdsjfkwsdf, Malviya Nagar, Hatheni Branch Post Office, Jaipur, Rajasthan - 302017', '8239840816', 'COD', 'Pending', NULL, 89.00, '2025-11-05 07:00:25', 'Rajasthan', 'Jaipur', '302017'),
(2, 7, 'Suraj singh', 'hatheni bharapur, Tonk Road, government school, Jaipur, Rajasthan - 302018', '8239840816', 'COD', 'Confirmed', '2025-11-05', 98.00, '2025-11-05 07:01:55', 'Rajasthan', 'Jaipur', '302018'),
(3, 7, 'manoj', 'hatheni bharapur, Malviya Nagar, Hatheni Branch Post Office, Jaipur, Rajasthan - 302017', '8239840816', 'COD', 'Confirmed', '2025-11-05', 79.00, '2025-11-05 07:19:16', 'Rajasthan', 'Jaipur', '302017'),
(4, 1, 'sanju', 'hatheni, Malviya Nagar, bsadu, Jaipur, Rajasthan - 302017', '8239840816', 'COD', 'Pending', NULL, 598.00, '2025-11-05 09:25:10', 'Rajasthan', 'Jaipur', '302017'),
(5, 1, 'Bhavdeep Singh', 'Gg, Jagatpura, Hhj, Jaipur, Rajasthan - 302017', '7597126142', 'Online', 'Pending', NULL, 178.00, '2025-11-07 10:29:29', 'Rajasthan', 'Jaipur', '302017');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `plate_type` enum('half','full') DEFAULT 'full',
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `plate_type`, `quantity`, `price`, `total`) VALUES
(1, 1, 37, 'full', 1, 89.00, 89.00),
(2, 2, 37, 'half', 2, 49.00, 98.00),
(3, 3, 36, 'full', 1, 79.00, 79.00),
(4, 4, 22, 'full', 2, 299.00, 598.00),
(5, 5, 37, 'full', 2, 89.00, 178.00);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `room_number` varchar(10) NOT NULL,
  `room_type` varchar(50) DEFAULT NULL,
  `status` enum('available','occupied') DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_number`, `room_type`, `status`) VALUES
(6, '001', 'Standard', ''),
(7, '002', 'Standard', ''),
(8, '003', 'Standard', ''),
(9, '004', 'Standard', ''),
(10, '005', 'Standard', 'available'),
(11, '006', 'Standard', ''),
(12, '007', 'Standard', 'available'),
(13, '008', 'Standard', ''),
(14, '009', 'Standard', ''),
(15, '010', 'Standard', 'available'),
(16, '011', 'Standard', ''),
(17, '012', 'Standard', 'available'),
(18, '013', 'Standard', 'available'),
(19, '014', 'Standard', 'available'),
(20, '015', 'Standard', 'occupied'),
(21, '016', 'Standard', 'available'),
(22, '017', 'Standard', ''),
(23, '018', 'Standard', 'available'),
(24, '019', 'Standard', 'available'),
(25, '020', 'Standard', 'available'),
(26, '021', 'Standard', 'available'),
(27, '022', 'Standard', 'available'),
(28, '023', 'Standard', 'available'),
(29, '024', 'Standard', 'available'),
(30, '025', 'Standard', 'available'),
(31, '026', 'Standard', 'available'),
(32, '027', 'Standard', 'available'),
(33, '028', 'Standard', 'available'),
(34, '029', 'Standard', 'available'),
(35, '030', 'Standard', 'available'),
(36, '031', 'Standard', 'available'),
(37, '032', 'Standard', 'available'),
(38, '033', 'Standard', 'available'),
(39, '034', 'Standard', 'available'),
(40, '035', 'Standard', 'available'),
(41, '036', 'Standard', 'available'),
(42, '037', 'Standard', 'available'),
(43, '038', 'Standard', 'available'),
(44, '039', 'Standard', 'available'),
(45, '040', 'Standard', 'available'),
(46, '041', 'Standard', 'available'),
(47, '042', 'Standard', 'available'),
(48, '043', 'Standard', 'available'),
(49, '044', 'Standard', 'available'),
(50, '045', 'Standard', 'available'),
(51, '046', 'Standard', 'available'),
(52, '047', 'Standard', 'available'),
(53, '048', 'Standard', 'available'),
(54, '049', 'Standard', 'available'),
(55, '050', 'Standard', 'available'),
(56, '051', 'Standard', 'available'),
(57, '052', 'Standard', 'available'),
(58, '053', 'Standard', 'available'),
(59, '054', 'Standard', 'available'),
(60, '055', 'Standard', 'available'),
(61, '056', 'Standard', 'available'),
(62, '057', 'Standard', 'available'),
(63, '058', 'Standard', 'available'),
(64, '059', 'Standard', 'available'),
(65, '060', 'Standard', 'available'),
(66, '061', 'Standard', 'available'),
(67, '062', 'Standard', 'available'),
(68, '063', 'Standard', 'available'),
(69, '064', 'Standard', 'available'),
(70, '065', 'Standard', 'available'),
(71, '066', 'Standard', 'available'),
(72, '067', 'Standard', 'available'),
(73, '068', 'Standard', 'available'),
(74, '069', 'Standard', 'available'),
(75, '070', 'Standard', 'available'),
(76, '071', 'Standard', 'available'),
(77, '072', 'Standard', 'available'),
(78, '073', 'Standard', 'available'),
(79, '074', 'Standard', 'available'),
(80, '075', 'Standard', 'available'),
(81, '076', 'Standard', 'available'),
(82, '077', 'Standard', 'available'),
(83, '078', 'Standard', 'available'),
(84, '079', 'Standard', 'available'),
(85, '080', 'Standard', 'available'),
(86, '081', 'Standard', 'available'),
(87, '082', 'Standard', 'available'),
(88, '083', 'Standard', 'available'),
(89, '084', 'Standard', 'available'),
(90, '085', 'Standard', 'available'),
(91, '086', 'Standard', 'available'),
(92, '087', 'Standard', 'available'),
(93, '088', 'Standard', 'available'),
(94, '089', 'Standard', 'available'),
(95, '090', 'Standard', 'available'),
(96, '091', 'Standard', 'available'),
(97, '092', 'Standard', 'available'),
(98, '093', 'Standard', 'available'),
(99, '094', 'Standard', 'available'),
(100, '095', 'Standard', 'available'),
(101, '096', 'Standard', 'available'),
(102, '097', 'Standard', 'available'),
(103, '098', 'Standard', 'available'),
(104, '099', 'Standard', 'available'),
(105, '100', 'Standard', 'available');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(10) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `status` int(10) NOT NULL,
  `s_password` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `master` varchar(255) DEFAULT NULL,
  `menu` varchar(255) DEFAULT NULL,
  `add_status` int(10) NOT NULL DEFAULT 0,
  `edit_status` int(10) DEFAULT 0,
  `delete_status` int(10) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `name`, `email`, `password`, `phone`, `status`, `s_password`, `type`, `master`, `menu`, `add_status`, `edit_status`, `delete_status`) VALUES
(1, 'Parangat', 'admin@gmail.com', '202cb962ac59075b964b07152d234b70', '7895060040', 1, '123', '1', NULL, NULL, 1, 1, 1),
(4, '', 'surajfoujdar45@gmail.com', '8a18982980d6d80637f5013ea0ddb5cf', '', 0, NULL, NULL, NULL, NULL, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_menu`
--

CREATE TABLE `tbl_admin_menu` (
  `id` int(10) NOT NULL,
  `category_id` int(10) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin_menu`
--

INSERT INTO `tbl_admin_menu` (`id`, `category_id`, `name`, `url`) VALUES
(10, 5, 'Service List', 'service-list.php'),
(24, 23, 'Portfolio List', 'portfolio-list.php'),
(34, 5, 'Banner List', 'banner-list.php'),
(36, 5, 'Testimonial List', 'testimonial-list.php'),
(38, 23, 'Portfolio Image List', 'portfolio-image-list.php'),
(39, 5, 'Blog List', 'blog-list.php'),
(42, 5, 'Team List', 'team-list.php'),
(43, 9, 'Category List', 'menu-category-list.php'),
(44, 9, 'Menu List', 'menu-list.php'),
(47, 11, 'Product List', 'product-list.php'),
(49, 27, 'Size List', 'size-list.php'),
(52, 26, 'Setting', 'setting.php?id=1'),
(53, 27, 'City List', 'city-list.php'),
(54, 27, 'Location List', 'location-list.php'),
(55, 27, 'Delivery Type List', 'delivery-type-list.php'),
(56, 28, 'Customer List', 'customer-list.php'),
(57, 28, 'Customer Product List', 'customer-product-list.php'),
(58, 27, 'Group List', 'group-list.php'),
(59, 28, 'Customer Group List', 'customer-group-list.php'),
(60, 28, 'Delivery Boy List', 'delivery-boy-list.php'),
(61, 11, 'Bill Generate', 'bill-generate.php'),
(62, 28, 'Off Days List ', 'offdays-list.php'),
(63, 29, 'Customer Wise Report', 'customer-wise-report.php'),
(64, 29, 'Group Wise Report', 'group-wise-report.php'),
(65, 29, 'Delivery Boy Wise Report', 'delivery-boy-wise-report.php'),
(66, 29, 'Product wise Report', 'product-wise-report.php'),
(67, 29, 'Sales Report', 'sales-report.php'),
(68, 30, 'Course Category List', 'course-category-list.php'),
(69, 30, 'Course List', 'course-list.php'),
(70, 5, 'Partner List', 'partner-list.php'),
(71, 5, 'Award List', 'award-list.php'),
(72, 31, 'Enquiry List', 'enquiry-list.php'),
(73, 5, 'Gallery', 'gallery-list.php'),
(74, 32, 'products Category', 'product-category-list.php'),
(75, 32, 'Add Product-list', 'product-list.php'),
(76, 31, 'booking', 'booking-list.php'),
(77, 31, 'Room Booking list', 'room_booking-list.php'),
(78, 31, 'Order - Booking', 'order-list.php'),
(79, 31, 'User-list', 'user-list.php');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_award`
--

CREATE TABLE `tbl_award` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image1` varchar(255) NOT NULL,
  `thumb1` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_award`
--

INSERT INTO `tbl_award` (`id`, `name`, `image1`, `thumb1`) VALUES
(1, 'Lorem Ippsum', '6736fc4f231e7_award-1.png', '6736fc4f23641thumb_award-1.png'),
(3, 'Lorem Ippsum', '6736fc7789da9_award-2.png', '6736fc778a20cthumb_award-2.png'),
(4, 'Lorem Ippsum', '6736fc82c4797_award-3.png', '6736fc82c4b61thumb_award-3.png'),
(5, 'Lorem Ippsum', '6736fc910af33_award-4.png', '6736fc910b232thumb_award-4.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_banner`
--

CREATE TABLE `tbl_banner` (
  `id` int(10) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `link` text DEFAULT NULL,
  `image1` varchar(255) DEFAULT NULL,
  `thumb1` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_banner`
--

INSERT INTO `tbl_banner` (`id`, `name`, `description`, `link`, `image1`, `thumb1`) VALUES
(9, 'The intelligent way to plan.', '<div>\r\n<div>Our Reputation Is&nbsp; Built On Solid Ground</div>\r\n</div>', 'contact.php', '68712e244edc6_3.jpg', '68712e244f528thumb_3.jpg'),
(10, 'Need Better Plan To Start Business', '<div>\r\n<div>Our Reputation Is Built On Solid Ground</div>\r\n</div>', 'contact.php', '68712e35d08ed_20.jpg', '68712e35d3fcbthumb_20.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blog`
--

CREATE TABLE `tbl_blog` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `heading` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `meta_title` text DEFAULT NULL,
  `meta_keyword` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `image1` varchar(255) DEFAULT NULL,
  `thumb1` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_blog`
--

INSERT INTO `tbl_blog` (`id`, `name`, `heading`, `date`, `short_description`, `description`, `meta_title`, `meta_keyword`, `meta_description`, `image1`, `thumb1`) VALUES
(13, '', 'Food Trip: Jaipur to Agra via Bharatpur', '0000-00-00', 'Plan the ultimate foodie road trip from Jaipur to Agra via Bharatpur â€” taste the best local dishes and hidden food gems along the way.', '<p>If you love food and travel, the Jaipur&ndash;Bharatpur&ndash;Agra route is your dream road trip. Start your journey in Jaipur with <strong data-start=\"6197\" data-end=\"6214\">Pyaaz Kachori</strong> and <strong data-start=\"6219\" data-end=\"6239\">Dal Baati Churma</strong>, head to Bharatpur for <strong data-start=\"6263\" data-end=\"6277\">Bajra Roti</strong> and <strong data-start=\"6282\" data-end=\"6291\">Rabdi</strong>, and finish in Agra with <strong data-start=\"6317\" data-end=\"6326\">Petha</strong> and <strong data-start=\"6331\" data-end=\"6353\">Mughlai delicacies</strong>.<br data-start=\"6354\" data-end=\"6357\" /> Along the way, you&rsquo;ll find countless highway dhabas serving fresh, flavorful meals. Don&rsquo;t forget to capture the scenic drive and local food moments.<br data-start=\"6505\" data-end=\"6508\" /> This food trail is not just about eating &mdash; it&rsquo;s about experiencing the rich cultural flavors of Rajasthan and Uttar Pradesh in one trip.</p>', '', '', '', '68e5fd8edb46d_17.jpg', '68e5fd8edb88ethumb_17.jpg'),
(14, '', 'Best Cafes in Jaipur', '0000-00-00', 'Discover Jaipurâ€™s most aesthetic and flavorful cafes â€” from Tapri Central to CafÃ© Bae â€” perfect for coffee lovers and Instagram vibes.', '<p>Jaipur&rsquo;s caf&eacute; culture beautifully blends heritage and modernity. From rooftop caf&eacute;s overlooking forts to artistic indoor spaces, the Pink City has it all.<br data-start=\"5452\" data-end=\"5455\" /> <strong data-start=\"5455\" data-end=\"5472\">Tapri Central</strong> is famous for its masala chai and sandwiches, while <strong data-start=\"5525\" data-end=\"5537\">Caf&eacute; Bae</strong> offers continental delights with an elegant ambience. <strong data-start=\"5592\" data-end=\"5605\">Nibs Caf&eacute;</strong> and <strong data-start=\"5610\" data-end=\"5625\">Anokhi Caf&eacute;</strong> are loved by youngsters for their desserts and cozy d&eacute;cor.<br data-start=\"5684\" data-end=\"5687\" /> These caf&eacute;s are perfect spots to relax, work, or capture Instagram-worthy moments while sipping on a refreshing drink or enjoying a light meal.</p>', '', '', '', '68e5fd62028c4_18.jpg', '68e5fd6202b61thumb_18.jpg'),
(15, '', 'Jaipurâ€“Agra Highway Food Stops', '0000-00-00', 'A perfect food trail on NH21 â€” explore the famous dhabas and highway restaurants between Jaipur and Agra for an unforgettable taste.', '<p data-start=\"4536\" data-end=\"5071\">If you&rsquo;re traveling between Jaipur and Agra via NH21, you&rsquo;re in for a delicious journey. This highway is lined with some of the best <strong data-start=\"4693\" data-end=\"4725\">dhabas and roadside eateries</strong> in North India.<br data-start=\"4741\" data-end=\"4744\" /> Stop at <strong data-start=\"4752\" data-end=\"4769\">Old Rao Dhaba</strong>, <strong data-start=\"4771\" data-end=\"4787\">Highway King</strong>, or <strong data-start=\"4792\" data-end=\"4808\">Sharma Dhaba</strong> for authentic North Indian meals. Enjoy piping-hot parathas, paneer butter masala, and lassi served in traditional clay cups.<br data-start=\"4934\" data-end=\"4937\" /> These food stops not only offer great taste but also a glimpse of Indian hospitality &mdash; perfect for a quick break and a memorable bite.</p>', '', '', '', '68e5fd3b519d0_2.jpg', '68e5fd3b51dc1thumb_2.jpg'),
(16, '', 'Bharatpur Local Taste', '0000-00-00', 'Savor Bharatpurâ€™s authentic countryside flavors â€” Bajra Roti, Lahsun Chutney, Churma, and Rabdi that reflect true Rajasthani culture.', '<p>Bharatpur, the Gateway to Rajasthan, is known not only for its bird sanctuary but also for its traditional rural flavors. The food here is simple yet deeply satisfying.<br data-start=\"3965\" data-end=\"3968\" /> A typical meal includes <strong data-start=\"3992\" data-end=\"4006\">Bajra Roti</strong>, <strong data-start=\"4008\" data-end=\"4026\">Lahsun Chutney</strong>, <strong data-start=\"4028\" data-end=\"4037\">Kadhi</strong>, and <strong data-start=\"4043\" data-end=\"4053\">Churma</strong> served with ghee. Locals love the <strong data-start=\"4088\" data-end=\"4097\">Rabdi</strong> and <strong data-start=\"4102\" data-end=\"4112\">Ghevar</strong> for dessert.<br data-start=\"4125\" data-end=\"4128\" /> Visit <strong data-start=\"4134\" data-end=\"4163\">Saraswati Misthan Bhandar</strong> or local dhabas near Keoladeo National Park to experience the real taste of Bharatpur. The earthy flavors and rustic cooking style make this food unforgettable.</p>', '', '', '', '68e5fd1b9505d_20.jpg', '68e5fd1b95319thumb_20.jpg'),
(17, '', 'Agra Mughlai Magic', '0000-00-00', 'Discover the rich Mughlai flavors of Agra â€” from creamy Butter Chicken to smoky Seekh Kebabs and aromatic Biryani.', '<p>Agra&rsquo;s Mughlai heritage adds a royal touch to its cuisine. Influenced by the Mughals, the city offers rich, aromatic, and creamy dishes that are a feast for non-veg lovers.<br data-start=\"3172\" data-end=\"3175\" /> Popular restaurants like <strong data-start=\"3200\" data-end=\"3218\">Pinch of Spice</strong>, <strong data-start=\"3220\" data-end=\"3244\">Taj Mahal Restaurant</strong>, and <strong data-start=\"3250\" data-end=\"3284\">Mama Chicken Mama Franky House</strong> serve delicious Mughlai dishes.<br data-start=\"3316\" data-end=\"3319\" /> Try the <strong data-start=\"3327\" data-end=\"3345\">Butter Chicken</strong>, <strong data-start=\"3347\" data-end=\"3363\">Mutton Korma</strong>, and <strong data-start=\"3369\" data-end=\"3385\">Seekh Kebabs</strong>, all slow-cooked with traditional spices. End your meal with a cup of <strong data-start=\"3456\" data-end=\"3470\">Kesar Chai</strong> or <strong data-start=\"3474\" data-end=\"3484\">Phirni</strong> for a perfect finish. Agra&rsquo;s Mughlai food truly captures the essence of royal India.</p>', '', '', '', '68e5fcf28fd73_24.jpg', '68e5fcf28fff8thumb_24.jpg'),
(18, '', 'Agra Sweet Journey', '0000-00-00', 'Taste the sweetness of Agra with its iconic Petha, spicy Dal Moth, and delicious Bedai-Jalebi â€” a perfect treat for every foodie', '<p data-start=\"2183\" data-end=\"2794\">Agra is not just about the Taj Mahal; it&rsquo;s also a paradise for sweet lovers. The city&rsquo;s most famous delicacy is the <strong data-start=\"2323\" data-end=\"2337\">Agra Petha</strong>, a translucent sweet made from ash gourd and flavored with rose, saffron, or cardamom.<br data-start=\"2424\" data-end=\"2427\" /> Visit <strong data-start=\"2433\" data-end=\"2449\">Panchi Petha</strong> for the most authentic taste. Another must-try is <strong data-start=\"2500\" data-end=\"2520\">Bedai and Jalebi</strong>, a classic breakfast combination loved by locals. You can enjoy this at <strong data-start=\"2593\" data-end=\"2611\">Deviram Sweets</strong>.<br data-start=\"2612\" data-end=\"2615\" /> Round off your food journey with <strong data-start=\"2648\" data-end=\"2660\">Dal Moth</strong>, a spicy lentil-based snack that&rsquo;s perfect for gifting or munching. Agra&rsquo;s sweets are simple yet magical &mdash; much like the city itself.</p>', '', '', '', '68e5fccaedbf8_6.jpg', '68e5fccaee046thumb_6.jpg'),
(19, '', 'Jaipur Street Food Guide', '0000-00-00', 'From Pyaaz Kachori to Kulhad Lassi â€” explore the mouthwatering street food that defines the vibrant streets of Jaipur.', '<p>The streets of Jaipur are filled with irresistible aromas and flavors. The city&rsquo;s street food scene is a paradise for food lovers. Start your culinary journey with <strong data-start=\"1576\" data-end=\"1617\">Rawat Misthan Bhandar&rsquo;s Pyaaz Kachori</strong>, a crispy, spicy snack filled with onion masala.<br data-start=\"1666\" data-end=\"1669\" /> Next, head to <strong data-start=\"1683\" data-end=\"1699\">Masala Chowk</strong> for a variety of local street dishes &mdash; from Golgappa, Mirchi Bada, and Samosa to Kulhad Chai and Lassi.<br data-start=\"1803\" data-end=\"1806\" /> Don&rsquo;t forget to try the <strong data-start=\"1830\" data-end=\"1846\">Mawa Kachori</strong> from <strong data-start=\"1852\" data-end=\"1859\">LMB</strong> and <strong data-start=\"1864\" data-end=\"1881\">Kulfi Falooda</strong> from local stalls in Bapu Bazaar. Jaipur&rsquo;s street food reflects the true flavor and warmth of Rajasthan.</p>', '', '', '', '690db7f37c577_anh-nguyen-kcA-c3f_3FE-unsplash.jpg', '690db7f37d42cthumb_anh-nguyen-kcA-c3f_3FE-unsplash.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_booking`
--

CREATE TABLE `tbl_booking` (
  `id` int(11) NOT NULL,
  `table_number` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` enum('half','full') NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `is_confirmed` tinyint(1) NOT NULL DEFAULT 0,
  `customer_name` varchar(100) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `status` enum('pending','confirmed') DEFAULT 'pending',
  `confirm_token` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `dine_time` datetime DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL,
  `delivery_charge` decimal(10,2) DEFAULT 0.00,
  `grand_total` decimal(10,2) DEFAULT NULL,
  `booking_type` enum('hotel','home') DEFAULT 'home'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_booking`
--

INSERT INTO `tbl_booking` (`id`, `table_number`, `category_id`, `product_id`, `size`, `quantity`, `price`, `total_price`, `created_at`, `is_confirmed`, `customer_name`, `mobile`, `email`, `status`, `confirm_token`, `user_id`, `dine_time`, `address`, `city`, `pincode`, `delivery_charge`, `grand_total`, `booking_type`) VALUES
(71, 2, 7, 23, 'full', 1, 99.00, 99.00, '2025-11-04 23:56:28', 1, 'bhavdeep', '8239840816', 'admin@gmail.com', 'confirmed', '6c7fbc58bb2c15462a70a34cb92475cd', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(72, 2, 7, 22, 'full', 1, 299.00, 299.00, '2025-11-04 23:56:28', 1, 'bhavdeep', '8239840816', 'admin@gmail.com', 'confirmed', '6c7fbc58bb2c15462a70a34cb92475cd', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(73, 5, 7, 22, 'full', 2, 299.00, 598.00, '2025-11-05 00:46:43', 1, 'Sanju', '8239840816', 'Surajfoujdar39@gmail.com', 'confirmed', '1a0fd4fc1531e3aaa444815e8ba88558', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(74, 4, 7, 23, 'full', 1, 99.00, 99.00, '2025-11-05 09:27:48', 0, 'Suraj singh', '7073288449', 'Surajfoujdar45@gmail.com', 'pending', '2c9ddc8013e151b8c834d73825b7adba', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(75, 4, 7, 22, 'full', 2, 299.00, 598.00, '2025-11-05 09:27:48', 0, 'Suraj singh', '7073288449', 'Surajfoujdar45@gmail.com', 'pending', '2c9ddc8013e151b8c834d73825b7adba', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(76, 8, 7, 23, 'full', 1, 99.00, 99.00, '2025-11-05 09:29:36', 0, 'Mahon singh', '7073288449', 'Surajfoujdar45@gmail.com', 'pending', '10ee469e59db478b198ecc9b158b75fa', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(77, 7, 7, 22, 'full', 2, 299.00, 598.00, '2025-11-05 09:34:33', 1, 'Suraj singh', '8239840816', 'Surajfoujdar45@gmail.com', 'confirmed', '7f9a7f3edcd7b6127e1e426e901311be', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(78, 2, 7, 24, 'full', 1, 129.00, 129.00, '2025-11-05 09:51:23', 1, 'Suraj singh', '8239840816', 'Surajfoujdar45@gmail.com', 'confirmed', 'bc4c6e34b7d8bec275b3fcdc6c1e5b38', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(79, 4, 7, 23, 'full', 2, 99.00, 198.00, '2025-11-05 10:03:47', 0, 'Suraj singh', '8239840816', 'surajfoujdar39@gmail.com', 'pending', 'd4d6ea39932a537eb7bf88722645aa4e', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(80, 3, 7, 23, 'full', 1, 99.00, 99.00, '2025-11-05 10:05:34', 0, 'Suraj singh', '8239840816', 'Surajfoujdar45@gmail.com', 'pending', '4471e5e5c6614227500b3da4d487de1a', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(81, 6, 7, 23, 'full', 1, 99.00, 99.00, '2025-11-05 10:07:43', 0, 'Suraj singh', '8239840816', 'Surajfoujdar45@gmail.com', 'pending', 'd27f7901474c259edd2971457de75827', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(82, 15, 7, 23, 'half', 1, 59.00, 59.00, '2025-11-05 10:16:11', 0, 'Suraj singh', '8239840816', 'Surajfoujdar45@gmail.com', 'pending', 'e23025d371c689f85a20fc365e81ee0b', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(83, 15, 7, 25, 'full', 1, 119.00, 119.00, '2025-11-05 10:16:11', 0, 'Suraj singh', '8239840816', 'Surajfoujdar45@gmail.com', 'pending', 'e23025d371c689f85a20fc365e81ee0b', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(84, 10, 7, 24, 'half', 1, 79.00, 79.00, '2025-11-05 10:36:01', 0, 'Suraj singh', '8239840816', 'Surajfoujdar45@gmail.com', 'pending', 'da1ab5940faa08c63ca837b2cb2a23d5', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(85, 10, 10, 37, 'full', 2, 89.00, 178.00, '2025-11-05 10:36:01', 0, 'Suraj singh', '8239840816', 'Surajfoujdar45@gmail.com', 'pending', 'da1ab5940faa08c63ca837b2cb2a23d5', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(86, 10, 10, 36, 'half', 1, 49.00, 49.00, '2025-11-05 10:36:01', 0, 'Suraj singh', '8239840816', 'Surajfoujdar45@gmail.com', 'pending', 'da1ab5940faa08c63ca837b2cb2a23d5', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(87, 4, 10, 37, 'half', 11, 49.00, 539.00, '2025-11-05 11:46:55', 0, 'Suraj singh', '8239840816', 'Surajfoujdar45@gmail.com', 'pending', 'b29475a7502d429acf1a269d71ee7936', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(88, 13, 10, 37, 'full', 2, 89.00, 178.00, '2025-11-05 12:13:21', 0, 'Suraj singh', '8239840816', 'Surajfoujdar45@gmail.com', 'pending', 'cc3fd3473d78be45f2de6c0fb3a035c6', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(89, 13, 10, 35, 'half', 1, 99.00, 99.00, '2025-11-05 12:13:21', 0, 'Suraj singh', '8239840816', 'Surajfoujdar45@gmail.com', 'pending', 'cc3fd3473d78be45f2de6c0fb3a035c6', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(90, 15, 10, 36, 'half', 1, 49.00, 49.00, '2025-11-05 12:35:45', 1, 'Suraj singh', '8239840816', 'Surajfoujdar45@gmail.com', 'confirmed', '518a1a46265e5eb57901e39b42b15f45', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(91, 4, 10, 37, 'full', 1, 89.00, 89.00, '2025-11-05 12:47:55', 1, 'ritiwik', '8239840816', 'surajfoujdar39@gmail.com', 'confirmed', '471fd5fa2368508174d83f39d60395d9', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(92, 2, 9, 0, 'half', 1, 0.00, 0.00, '2025-11-04 23:43:15', 0, 'Suraj singh', '8239840816', NULL, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(93, 4, 10, 37, 'half', 2, 49.00, 98.00, '2025-11-05 14:24:36', 1, 'Suraj singh', '8239840816', 'Surajfoujdar45@gmail.com', 'confirmed', '34753c5168a733428ed3d271d374f1f4', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(94, 8, 10, 37, 'full', 1, 89.00, 89.00, '2025-11-05 17:42:46', 0, 'Arushi', '7073306455', 'Surajfoujdar45@gmail.com', 'pending', '077ab54fc0d060fd65fb2162fb6afbed', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(95, 10, 10, 37, 'full', 3, 89.00, 267.00, '2025-11-05 19:11:27', 1, 'Suraj singh', '8239840816', 'Surajfoujdar45@gmail.com', 'confirmed', 'b518d0645ed6577ac6a494ca6de16210', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(96, 10, 10, 35, 'full', 1, 199.00, 199.00, '2025-11-05 19:11:27', 1, 'Suraj singh', '8239840816', 'Surajfoujdar45@gmail.com', 'confirmed', 'b518d0645ed6577ac6a494ca6de16210', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(97, 10, 7, 22, 'full', 1, 299.00, 299.00, '2025-11-05 19:11:27', 1, 'Suraj singh', '8239840816', 'Surajfoujdar45@gmail.com', 'confirmed', 'b518d0645ed6577ac6a494ca6de16210', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(98, 14, 10, 37, 'full', 1, 89.00, 89.00, '2025-11-05 19:12:37', 1, 'Suraj singh', '8239840816', 'Surajfoujdar45@gmail.com', 'confirmed', 'f9011fffdcf2b3dc7bceff0dab50bbb2', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(99, 14, 10, 35, 'half', 1, 99.00, 99.00, '2025-11-05 19:12:37', 1, 'Suraj singh', '8239840816', 'Surajfoujdar45@gmail.com', 'confirmed', 'f9011fffdcf2b3dc7bceff0dab50bbb2', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(100, 14, 10, 36, 'full', 1, 79.00, 79.00, '2025-11-05 19:12:37', 1, 'Suraj singh', '8239840816', 'Surajfoujdar45@gmail.com', 'confirmed', 'f9011fffdcf2b3dc7bceff0dab50bbb2', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(101, 4, 10, 36, 'full', 1, 79.00, 79.00, '2025-11-05 19:18:45', 0, 'Suraj singh', '8239840816', 'Surajfoujdar45@gmail.com', 'pending', 'eaaa5e7eb8d28a29381e682fe23785b8', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(102, 7, 10, 36, 'full', 1, 79.00, 79.00, '2025-11-05 19:21:11', 1, 'Suraj singh', '8239840816', 'Surajfoujdar45@gmail.com', 'confirmed', '5b85169a4be0f536886506146d6c380c', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(103, 8, 10, 36, 'full', 1, 79.00, 79.00, '2025-11-06 09:28:56', 1, 'Suraj', '8854963202', 'surajfoujdar45@gmail.com', 'confirmed', '4b7bf4e4efd1387ababa5d6897c40517', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(104, 5, 10, 37, 'full', 2, 89.00, 178.00, '2025-11-07 14:34:14', 0, 'Suraj singh', '9352578335', 'Surajfoujdar45@gmail.com', 'pending', 'eff69f9600410f090b470f0bd49c8cfd', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(105, 5, 10, 35, 'full', 1, 199.00, 199.00, '2025-11-07 14:34:14', 0, 'Suraj singh', '9352578335', 'Surajfoujdar45@gmail.com', 'pending', 'eff69f9600410f090b470f0bd49c8cfd', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(106, 5, 9, 32, 'full', 1, 299.00, 299.00, '2025-11-07 14:34:14', 0, 'Suraj singh', '9352578335', 'Surajfoujdar45@gmail.com', 'pending', 'eff69f9600410f090b470f0bd49c8cfd', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(107, 5, 10, 36, 'full', 1, 79.00, 79.00, '2025-11-07 14:34:14', 0, 'Suraj singh', '9352578335', 'Surajfoujdar45@gmail.com', 'pending', 'eff69f9600410f090b470f0bd49c8cfd', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(108, 5, 9, 34, 'full', 1, 179.00, 179.00, '2025-11-07 14:34:14', 0, 'Suraj singh', '9352578335', 'Surajfoujdar45@gmail.com', 'pending', 'eff69f9600410f090b470f0bd49c8cfd', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(109, 7, 10, 37, 'full', 1, 89.00, 89.00, '2025-11-08 09:06:22', 0, 'Suraj singh', '8239840816', 'Surajfoujdar45@gmail.com', 'pending', 'df7eaf190715e6ce91610894591ae2c2', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(110, 6, 10, 37, 'full', 1, 89.00, 89.00, '2025-11-08 09:47:44', 1, 'Arushi', '8239840816', 'arshisehrawat123@gmail.com', 'confirmed', '305b1357d5e698e1519b861eb57026ef', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(111, 4, 10, 37, 'full', 1, 89.00, 89.00, '2025-11-08 09:54:53', 1, 'arushi', '8239840816', 'Surajfoujdar45@gmail.com', 'confirmed', '73e86638401481243905cf3c39258555', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(112, 12, 10, 36, 'full', 1, 79.00, 79.00, '2025-11-08 10:05:25', 1, 'SURAJ SINGH', '8239840816', 'admin@gmail.com', 'confirmed', '1fd79c0c52613840450066f9b35556aa', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(113, 6, 10, 36, 'full', 1, 79.00, 79.00, '2025-11-08 10:10:14', 0, 'arushi', '8239840816', 'admin@gmail.com', 'pending', 'b1146c47963c0c24dba4f6faa22cd337', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(114, 7, 10, 37, 'full', 1, 89.00, 89.00, '2025-11-08 10:12:34', 1, 'Arushi', '7678353688', 'Surajfoujdar45@gmail.com', 'confirmed', 'c5ed401b998f623a76fbfb3cbc5e9d12', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(115, 6, 10, 37, 'full', 1, 89.00, 89.00, '2025-11-08 10:23:42', 1, 'Sanju', '7073306455', 'Surajfoujdar45@gmail.com', 'confirmed', '02e4dfbe37248294f51a9adcd9f7f9b8', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(116, 3, 10, 36, 'full', 2, 79.00, 158.00, '2026-01-01 18:35:01', 0, 'suraj', '8239840816', 'admin@gmail.com', 'pending', '9e078e831df7f49406e1fce4e067b795', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(117, 3, 10, 37, 'full', 1, 89.00, 89.00, '2026-01-01 18:35:01', 0, 'suraj', '8239840816', 'admin@gmail.com', 'pending', '9e078e831df7f49406e1fce4e067b795', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(118, 14, 10, 36, 'full', 1, 79.00, 79.00, '2026-01-01 22:42:34', 1, 'suraj', '8239840816', 'admin@gmail.com', 'confirmed', '6da9c6786970b762fcc291d885eb30e5', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(119, 8, 10, 36, 'full', 1, 79.00, 79.00, '2026-01-02 19:16:26', 1, 'suraj', '8239840816', 'admin@gmail.com', 'confirmed', 'dd0c80b0b5f0ea4e891b67bd0d4a1ea4', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(120, 8, 10, 37, 'full', 2, 89.00, 178.00, '2026-01-02 19:16:26', 1, 'suraj', '8239840816', 'admin@gmail.com', 'confirmed', 'dd0c80b0b5f0ea4e891b67bd0d4a1ea4', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(121, 8, 9, 32, 'full', 1, 299.00, 299.00, '2026-01-02 19:16:26', 1, 'suraj', '8239840816', 'admin@gmail.com', 'confirmed', 'dd0c80b0b5f0ea4e891b67bd0d4a1ea4', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(122, 7, 10, 36, 'full', 1, 79.00, 79.00, '2026-01-03 09:46:31', 1, 'ashok', '9116346385', 'ashok@gmail.com', 'confirmed', '6472511207d3202827dcbe230e3b42d8', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(123, 4, 10, 37, 'full', 1, 89.00, 89.00, '2026-01-03 12:27:27', 1, 'ashok', '829840816', 'ashok@gmail.com', 'confirmed', '3371de9c9d1a26a6fae5448533021ef8', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(124, 31, 10, 37, 'full', 1, 89.00, 89.00, '2026-01-06 15:45:37', 1, 'suraj', '8239840816', 'admin@gmail.com', 'confirmed', '95f28cf240bead250e86ba6179537fc3', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(125, 9, 10, 37, 'full', 2, 89.00, 178.00, '2026-01-10 09:29:34', 1, 'suraj', '8239840816', 'admin@gmail.com', 'confirmed', '4d66eca4224680921749194258251487', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(126, 3, 9, 32, 'full', 1, 299.00, 299.00, '2026-01-18 16:29:07', 1, 'suraj', '9024244731', 'admin@gmail.com', 'confirmed', '3beb21bb9d85a77f5596fb5c25e7e40f', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(127, 3, 9, 33, 'full', 1, 239.00, 239.00, '2026-01-18 16:29:07', 1, 'suraj', '9024244731', 'admin@gmail.com', 'confirmed', '3beb21bb9d85a77f5596fb5c25e7e40f', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(128, 12, 10, 37, 'full', 2, 89.00, 178.00, '2026-01-29 19:58:41', 0, 'suraj', '9024244731', 'admin@gmail.com', 'pending', '5d7f4a01a6d0eb75ccadb59963348363', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home'),
(129, 12, 10, 36, 'full', 1, 79.00, 79.00, '2026-01-29 19:58:41', 0, 'suraj', '9024244731', 'admin@gmail.com', 'pending', '5d7f4a01a6d0eb75ccadb59963348363', NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 'home');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_city`
--

CREATE TABLE `tbl_city` (
  `id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_city`
--

INSERT INTO `tbl_city` (`id`, `state_id`, `name`) VALUES
(1, 26, 'Agra');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_color`
--

CREATE TABLE `tbl_color` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `ordering` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_color`
--

INSERT INTO `tbl_color` (`id`, `name`, `ordering`) VALUES
(2, 'Green ', 2),
(4, 'Red', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_course`
--

CREATE TABLE `tbl_course` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `short_description` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `eligibility` varchar(255) NOT NULL,
  `duration` varchar(255) NOT NULL,
  `internship` varchar(255) NOT NULL,
  `image1` varchar(255) NOT NULL,
  `thumb1` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_course`
--

INSERT INTO `tbl_course` (`id`, `category_id`, `name`, `short_description`, `description`, `eligibility`, `duration`, `internship`, `image1`, `thumb1`) VALUES
(1, 1, 'Diploma in Hotel Management', 'It is the course where applicants indulge in the complexities of the area, encouraging them to obtain the support required in the hospitality sector within the Diploma in Hotel Management.', '<p>It is the course where applicants indulge in the complexities of the area, encouraging them to obtain the support required in the hospitality sector within the Diploma in Hotel Management. The Course offers a vast field for students to invent on their scientific, management, and technological skills, therefore creating a stable foundation for them to inculcate professionalism and start encouraging career possibilities.</p>', ' 10th or equivalent', ' 1 Year (2 Semesters)', '6 Months', '6735ef25ade10_01.jpg', '6735ef25aede4thumb_01.jpg'),
(2, 2, 'Bachelor in Hotel Management', 'Bachelor inHotel Management is a specialized Course designed as per the growing demands of the modern Hospitality Industry. ', '<p>Bachelor inHotel Management is a specialized Course designed as per the growing demands of the modern Hospitality Industry. The Hotel Management is the industry within the service industries that includes lodging, food and drinking services, event planning, consign practice, transportation, cross lane, travel additional field within the tourism industry. One of the reasons to study hotel management is to find a great job and career opportunities for anyone who wants to get involved in the World of Tourism.</p>', '10+2 or equivalent', '3 Year', '6 Months + 6 Months = 1 Year (2 Trainings)', '6735ef69b5f31_02.jpg', '6735ef69b6311thumb_02.jpg'),
(3, 3, 'MBA in Hotel Management', 'If you are an aspiring individual to be being around people all the time and enjoy making them happy and comfortable with your communication and activities,', '<p>If you are an aspiring individual to be being around people all the time and enjoy making them happy and comfortable with your communication and activities, then education in hospitality is one of the best and basic courses for you to have opted. MBA in Hospitality Management is a complete post-graduation course that makes you able about the different types of management roles in hospitality businesses such as hotels, resorts, and others.<br />If we talk about the syllabus of the course, the 2- year course is managed to train the curriculum in many areas like Food, Beverage, events and meetings, Tourism services, Accommodations, Entertainment, etc. Besides this, the course also managed to train the students in Accounting, Business Law, Human Resource Management, Finance Management, and Marketing.</p>', 'Graduate (any stream) or equivalent', '2 Year or equivalent', '6 Months + 6 Months = 1 year (2 Trainings)', '6735ef99cf171_03.jpg', '6735ef99cf513thumb_03.jpg'),
(4, 1, 'Advanced Diploma in Hotel Management', 'The hotel industry promises a bright future for anyone who wishes to take up a career in this segment. The students opting for hotel management courses must have an affinity towards socializing and understanding the needs of the people. As Hotels falls un', '', '10th or equivalent', '18 Months (3 Semesters)', '4 Months + 6 Months = 10 Months (2 trainings)', '673d8bfc58d3c_a-diploma.jpg', '673d8bfc59356thumb_a-diploma.jpg'),
(5, 1, 'International Diploma in Hotel Management', 'The Hotel Management diploma is designed for 10th and 12th passed students willing to work in the hospitality sector on international locations and looking for a career in world most employable industries around the world. This course is specially designe', '<p>The Hotel Management diploma is designed for 10th and 12th passed students willing to work in the hospitality sector on international locations and looking for a career in world most employable industries around the world. This course is specially designed for those students who are willing to Study and work internationally in 5*Hotels. In this Course, the student will study in India for 6 months and then will go for 18 months of International internship in Malaysia.</p>\r\n<p><strong>Key features of International Diploma:</strong></p>\r\n<p>Take the next step along your career path with a world-class internship in your industry of choice.</p>\r\n<p>Gain professional skills through career speaker events, company visits and career workshops.</p>\r\n<p>Build unique experience that will help you stand out in a rapidly expanding job market.</p>\r\n<p>Discover Malaysia-Truly Asia through after-work activities and explore Southeast Asia on weekend trips.</p>\r\n<p>Live in a multicultural environment with fellow Absolute Interns from across the globe.</p>\r\n<p>The Hospitality Career is popular among the student moving to Malaysiafor their higher studies and Internships. Internships in Malaysiaare specifically designed and offered to meet today&rsquo;s requirement of global growth &amp; career opportunities that are helpful to increase your professional worth.</p>\r\n<p><strong>Highlights:</strong></p>\r\n<p>All the placements will be in high profile companies.</p>\r\n<p>Salary information is given on average basis. It can be higher or lesser depending upon candidate to candidate.</p>\r\n<p>You can also enjoy the many benefits like overtime, tips etc.</p>\r\n<p>No IELTS or Any Entrance exams required.</p>\r\n<p>International Certifications.</p>\r\n<p>You can undergo 18 months training with International Expertise for working in the field of Hospitality. These programs are designed with the perspective to reflect both nature of various industries and polish interpersonal skills in the environment.</p>\r\n<p>After completion of your training period you will get the opportunity for a job offer to work in best hotels from which you gain professional experience and opportunities to enhance your career goal.</p>\r\n<p>You will get professional certificates which will help you to work in other foreign countries and build up your future over there.</p>\r\n<p>International Internship you do are paid so that you can enjoy earning good fortune and getting international work exposures with low investment in both terms of money and time.</p>', '10th or equivalent', '2 Years (4 Semesters)', '18 Months (Candidate must be 18+ years & must have valid passport)', '673d8ed11209d_international-diploma.jpg', '673d8ed1123cathumb_international-diploma.jpg'),
(6, 2, 'Bachelor in Hotel Management (BHM) + International Diploma Dual Certification (with International Exposure)', 'Bachelor in Hotel Management + International Diploma (with International exposure) is a combination of 3 year Bachelor in Hotel Management and International Diploma in Hotel Management.', '<p>Bachelor in Hotel Management + International Diploma (with International exposure) is a combination of 3 year Bachelor in Hotel Management and International Diploma in Hotel Management.</p>\r\n<p>IAHM conducts a 3 year program spread over 6 capsules, 2 capsules each year. Every International Certification is divided into levels, which must be completed with theoretical knowledge practical skills, and service attitude. This program is designed as &ldquo;Earn while you Learn&rdquo; Concepts which includes International Internship in Malaysia while your course.</p>\r\n<p>This course is specially designed for those students who are willing to Study and work internationally in 5*Hotels. In this Course, the student will study in India for 6 months and then will go for 30 months of International internship in Malaysia.</p>\r\n<p><strong>Key features of International Diploma:</strong></p>\r\n<p>Take the next step along your career path with a world-class internship in your industry of choice.</p>\r\n<p>Gain professional skills through career speaker events, company visits and career workshops.</p>\r\n<p>Build unique experience that will help you stand out in a rapidly expanding job market.</p>\r\n<p>Discover Malaysia-Truly Asia through after-work activities and explore Southeast Asia on weekend trips.</p>\r\n<p>Live in a multicultural environment with fellow Absolute Interns from across the globe.</p>\r\n<p>The Hospitality Career is popular among the student moving to Malaysia for their higher studies and Internships. Internships in Malaysia are specifically designed and offered to meet today&rsquo;s requirement of global growth &amp; career opportunities that are helpful to increase your professional worth.</p>\r\n<p><strong>Highlights:</strong></p>\r\n<p>All the placements will be in high profile companies.</p>\r\n<p>Salary information is given on average basis. It can be higher or lesser depending upon candidate to candidate.</p>\r\n<p>You can also enjoy the many benefits like overtime, tips etc.</p>\r\n<p>No IELTS or Any Entrance exams required.</p>\r\n<p>International Certifications.</p>\r\n<p>You can undergo 30 months training with International Expertise for working in the field of Hospitality. These programs are designed with the perspective to reflect both nature of various industries and polish interpersonal skills in the environment.</p>\r\n<p>After completion of your training period you will get the opportunity for a job offer to work in best hotels from which you gain professional experience and opportunities to enhance your career goal.</p>\r\n<p>You will get professional certificates which will help you to work in other foreign countries and build up your future over there.</p>\r\n<p>International Internship you do are paid so that you can enjoy earning good fortune and getting international work exposures with low investment in both terms of money and time.</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>', '10th or equivalent', '2 Years (4 Semesters)', ' 18 Months (Candidate must be 18+ years & must have valid passport)', '673d92c75f88b_diploma.jpg', '673d92c75fc5fthumb_diploma.jpg'),
(7, 3, 'MBA in Hotel Management (MHM) + International Diploma Dual Certification (with International Exposure)', 'MBA in Hotel Management + International Diploma (with International exposure) is a combination of 2 year MBA in Hotel Management and International Diploma in Hotel Management.', '<p>MBA in Hotel Management + International Diploma (with International exposure) is a combination of 2 year MBA in Hotel Management and International Diploma in Hotel Management.</p>\r\n<p>IAHM conducts a 2 year program spread over 4 capsules, 2 capsules each year. Every International Certification is divided into levels, which must be completed with theoretical knowledge practical skills, and service attitude. This program is designed as &ldquo;Earn while you Learn&rdquo; Concepts which includes International Internship in Malaysia while your course.</p>\r\n<p>This course is specially designed for those students who are willing to Study and work internationally in 5*Hotels. In this Course, the student will study in India for 6 months and then will go for 18 months of International Internship in Malaysia.</p>\r\n<p><strong>Key features of International Diploma:</strong></p>\r\n<p>Take the next step along your career path with a world-class internship in your industry of choice.</p>\r\n<p>Gain professional skills through career speaker events, company visits and career workshops.</p>\r\n<p>Build unique experience that will help you stand out in a rapidly expanding job market.</p>\r\n<p>Discover Malaysia-Truly Asia through after-work activities and explore Southeast Asia on weekend trips.</p>\r\n<p>Live in a multicultural environment with fellow Absolute Interns from across the globe.</p>\r\n<p>The Hospitality Career is popular among the student moving to Malaysia for their higher studies and Internships. Internships in Malaysia are specifically designed and offered to meet today&rsquo;s requirement of global growth &amp; career opportunities that are helpful to increase your professional worth.</p>\r\n<p><strong>Highlights:</strong></p>\r\n<p>All the placements will be in high profile companies.</p>\r\n<p>Salary information is given on average basis. It can be higher or lesser depending upon candidate to candidate.</p>\r\n<p>You can also enjoy the many benefits like overtime, tips etc.</p>\r\n<p>No IELTS or Any Entrance exams required.</p>\r\n<p>International Certifications.</p>\r\n<p>You can undergo 30 months training with International Expertise for working in the field of Hospitality. These programs are designed with the perspective to reflect both nature of various industries and polish interpersonal skills in the environment.</p>\r\n<p>After completion of your training period you will get the opportunity for a job offer to work in best hotels from which you gain professional experience and opportunities to enhance your career goal.</p>\r\n<p>You will get professional certificates which will help you to work in other foreign countries and build up your future over there.</p>\r\n<p>International Internship you do are paid so that you can enjoy earning good fortune and getting international work exposures with low investment in both terms of money and time.</p>', 'Graduate or equivalent', '2 Years (4 Semesters)', '18 Months (Candidate must be 18+ years & must have valid passport)', '6871cd62a13c6_2.jpg', '6871cd62a1d47thumb_2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_course_category`
--

CREATE TABLE `tbl_course_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_course_category`
--

INSERT INTO `tbl_course_category` (`id`, `name`, `url`) VALUES
(1, 'Diploma Program', 'diploma-program'),
(2, 'Graduate Program', 'graduate-program'),
(3, 'Post Graduacte Program', 'post-graduate-program');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer`
--

CREATE TABLE `tbl_customer` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `landmark` varchar(255) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `delivery_type_id` int(11) DEFAULT NULL,
  `ordering` int(11) NOT NULL,
  `extra_note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_customer`
--

INSERT INTO `tbl_customer` (`id`, `name`, `phone`, `email`, `address`, `location_id`, `landmark`, `city_id`, `state_id`, `delivery_type_id`, `ordering`, `extra_note`) VALUES
(1, 'Anu', '8532874070', 'anu@gmail.com', 'Shahganj, Agra', 1, 'Ram Nagar Puliya', 1, 26, 1, 1, '<p>Good Morning</p>'),
(2, 'Akash', '8745329621', 'akash@gmail.com', 'Shahganj, Agra', 1, '', 1, 26, 1, 2, '<p>Good Morning</p>'),
(3, 'Divya ', '8745369102', 'divya@gmail.com', 'Shahganj, Agra', 1, 'Cos Mos Mall', 1, 26, 1, 3, '<p>Good Morning</p>'),
(4, 'Sumit', '8798723255', 'sumit@gmail.com', 'Shahganj, Agra', 1, 'Cosmos Mall', 1, 26, 1, 4, '<p>Good Morning</p>'),
(5, 'Kunal', '8756085920', 'kunal@gmail.com', 'Shahganj, Agra', 1, 'Cosmos Mall', 1, 26, 1, 5, '<p>Good Morning</p>'),
(6, 'Krishna', '8979813265', 'krishna@gmail.com', 'Shahganj, Agra', 1, 'Cosmos Mall', 1, 26, 1, 6, '<p>Good Morning</p>'),
(7, 'Paras ', '9879654565', 'paras@gmail.com', 'Shahganj, Agra', 1, 'Cosmos Mall', 1, 26, 1, 7, '<p>Good Morning</p>'),
(8, 'Hemant', '8798652121', 'hemant@gmail.com', 'Shahganj, Agra', 1, 'Cosmos Mall', 1, 26, 1, 8, '<p>Good Morning</p>'),
(9, 'Ankit', '1234567890', 'ankit@gmail.com', 'Sanjay Place', 1, 'Cosmos Mall', 1, 26, 2, 9, '<p>Good Morning</p>'),
(10, 'Shnatanu ', '9998894655', 'shantanu@gmail.com', 'Sanjay Place', 1, 'Cosmos Mall', 1, 26, 3, 11, '<p>Good Morning</p>'),
(11, 'Shilpi', '9879854625', 'shipli@gmail.com', 'Sanjay Place ', 1, 'Cosmos Mall', 1, 26, 2, 10, '<p>Good Morning</p>');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer_group`
--

CREATE TABLE `tbl_customer_group` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_customer_group`
--

INSERT INTO `tbl_customer_group` (`id`, `group_id`, `customer_id`) VALUES
(1, 1, 1),
(3, 1, 2),
(4, 5, 3),
(5, 5, 4),
(6, 5, 5),
(7, 1, 6),
(8, 6, 7),
(9, 6, 8),
(10, 1, 9),
(11, 1, 10),
(12, 1, 11);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer_product`
--

CREATE TABLE `tbl_customer_product` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `size_id` int(11) NOT NULL,
  `delivery` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_customer_product`
--

INSERT INTO `tbl_customer_product` (`id`, `customer_id`, `product_id`, `price`, `size_id`, `delivery`) VALUES
(3, 1, 9, 80, 5, '1'),
(4, 1, 12, 40, 6, '1'),
(5, 2, 11, 120, 9, '1'),
(6, 3, 10, 50, 9, '1'),
(7, 4, 9, 70, 6, '1'),
(8, 4, 10, 50, 9, '1'),
(9, 9, 10, 50, 9, '1'),
(10, 9, 9, 70, 5, '1'),
(11, 10, 12, 60, 6, '1'),
(12, 10, 11, 120, 9, '1'),
(13, 11, 9, 70, 7, '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_delivery_boy`
--

CREATE TABLE `tbl_delivery_boy` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `group_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_delivery_boy`
--

INSERT INTO `tbl_delivery_boy` (`id`, `name`, `phone`, `email`, `address`, `group_id`) VALUES
(1, 'Anu', '8532874070', 'anu@gmail.com', '<p>Shahganj, Agra</p>', '1,5,6');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_delivery_type`
--

CREATE TABLE `tbl_delivery_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_delivery_type`
--

INSERT INTO `tbl_delivery_type` (`id`, `name`) VALUES
(1, 'On Door '),
(2, 'Knock the Door'),
(3, 'Only Ring the bell');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_enquiry`
--

CREATE TABLE `tbl_enquiry` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `company_name` varchar(150) DEFAULT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `course` text NOT NULL,
  `website` varchar(255) NOT NULL,
  `table_number` int(255) NOT NULL,
  `status` int(11) DEFAULT 0,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_enquiry`
--

INSERT INTO `tbl_enquiry` (`id`, `name`, `email`, `mobile`, `phone`, `company_name`, `subject`, `message`, `course`, `website`, `table_number`, `status`, `date`) VALUES
(18, 'Once A Dancer, Is Always A Dance', 'tajconsultancyservice@gmail.com', '', '789564564541', NULL, NULL, 'asdfsdfadsf', '', '', 11, 0, NULL),
(19, 'suraj', 'surajfoujdar90@gmail.com', '', '823984081655', NULL, NULL, 'hello', '', '', 12, 0, '2025-07-12'),
(20, 'suraj', 'artipoptani2006@gmail.com', '', '789564564541', NULL, NULL, 'hello', '', '', 2, 0, '2025-07-11'),
(21, 'Once A Dancer, Is Always A Dance', 'tajconsultancyservice@gmail.com', '', '75785896966787', NULL, NULL, 'hello', '', '', 12, 0, '2025-07-04'),
(22, 'Suraj singh', 'Surajfoujdar45@gmail.com', '', '0902 424 4731', NULL, NULL, 'kkjlk', '', '', 13, 0, '2025-09-09'),
(23, 'Joanna Riggs', 'joannariggs211@gmail.com', '', '335661909', NULL, NULL, 'Hi,\r\n\r\nI just visited surajfoujdar.engineer and wondered if you\'d ever thought about having an engaging video to explain what you do?\r\n\r\nOur prices start from just $195 (USD).\r\n\r\nLet me know if you\'re interested in seeing samples of our previous work.\r\n\r\nRegards,\r\nJoanna\r\n\r\nUnsubscribe: https://unsubscribe.video/unsubscribe.php?d=surajfoujdar.engineer', '', '', 11, 0, '0000-00-00'),
(24, 'RaymondJew', 'no.reply.JiirqenWouters@gmail.com', '', '86661412693', NULL, NULL, 'Whatâ€™s up? surajfoujdar.engineer \r\n \r\nDid you know that it is possible to send business offer absolutely legal? \r\nWhen such proposals are submitted, no personal information is utilized, and messages are routed to forms specifically configured to receive messages and appeals securely. Communication Forms ensure that messages are not treated as spam, as these messages are regarded as essential. \r\nWe are offering you an opportunity to try our service without charge. \r\nWe can send up to 50,000 messages on your behalf. \r\n \r\nThe cost of sending one million messages is $59. \r\n \r\nThis letter is automatically generated. \r\n \r\nContact us. \r\nTelegram - https://t.me/FeedbackFormEU \r\nWhatsApp - +375259112693 \r\nWhatsApp  https://wa.me/+375259112693 \r\nWe only use chat for communication.', '', '', 3, 0, '1985-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_gallery`
--

CREATE TABLE `tbl_gallery` (
  `id` int(11) NOT NULL,
  `gallery_type` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image1` varchar(255) NOT NULL,
  `thumb1` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_gallery`
--

INSERT INTO `tbl_gallery` (`id`, `gallery_type`, `name`, `image1`, `thumb1`) VALUES
(1, '', 'fabric', '6868e2754bbb0_portfolio-01-738x398.jpg', '6868e2754e2e4thumb_portfolio-01-738x398.jpg'),
(2, '', 'Cotton Fabric', '6868e4365a0b0_portfolio-01-768x512.jpg', '6868e4365bf11thumb_portfolio-01-768x512.jpg'),
(3, '', 'Silk Fabric', '6868e447b513d_portfolio-01-1200x800.jpg', '6868e447b70e0thumb_portfolio-01-1200x800.jpg'),
(4, '', 'Linen Fabric', '6868e45cac47b_portfolio-02-768x512.jpg', '6868e45cadbf3thumb_portfolio-02-768x512.jpg'),
(5, '', 'Wool Fabric', '6868e46a6488d_portfolio-03-768x512.jpg', '6868e46a66a0cthumb_portfolio-03-768x512.jpg'),
(6, '', 'Denim Fabric', '6868e487638ad_portfolio-06-600x700.jpg', '6868e487677a7thumb_portfolio-06-600x700.jpg'),
(7, '', 'Georgette Fabric', '6868e50069237_portfolio-04-738x398.jpg', '6868e5006afb7thumb_portfolio-04-738x398.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_group`
--

CREATE TABLE `tbl_group` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_group`
--

INSERT INTO `tbl_group` (`id`, `name`) VALUES
(1, 'Group A'),
(5, 'Group B'),
(6, 'Group C');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_location`
--

CREATE TABLE `tbl_location` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_location`
--

INSERT INTO `tbl_location` (`id`, `name`) VALUES
(1, 'Sector 1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menu_category`
--

CREATE TABLE `tbl_menu_category` (
  `id` int(10) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `ordering` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_menu_category`
--

INSERT INTO `tbl_menu_category` (`id`, `name`, `ordering`) VALUES
(5, 'Service', 1),
(9, 'Menu', 2),
(23, 'Portfolio Management', 4),
(26, 'Web Setting', 6),
(30, 'Course Master', 3),
(31, 'Enquiry Master', 5),
(32, 'products', 6);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_off_days`
--

CREATE TABLE `tbl_off_days` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `remark` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_off_days`
--

INSERT INTO `tbl_off_days` (`id`, `customer_id`, `product_id`, `date`, `remark`) VALUES
(1, 1, 9, '2024-11-09', ''),
(2, 1, 9, '2024-11-10', ''),
(3, 1, 9, '2024-11-11', ''),
(5, 3, 11, '2024-11-14', ''),
(6, 3, 11, '2024-11-15', ''),
(7, 3, 11, '2024-11-16', ''),
(8, 1, 9, '2024-11-12', ''),
(9, 4, 9, '2024-11-13', 'Weekend'),
(10, 4, 9, '2024-11-14', 'Weekend'),
(11, 4, 9, '2024-11-15', 'Weekend'),
(12, 3, 10, '2024-11-13', 'not stay at home');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE `tbl_order` (
  `id` int(11) NOT NULL,
  `order_id` varchar(16) NOT NULL,
  `group_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `delivery_type` varchar(50) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `size_id` int(11) NOT NULL,
  `size_name` varchar(50) NOT NULL,
  `size_value` varchar(50) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `cart_status` tinyint(1) NOT NULL,
  `delivery_boy_id` int(11) NOT NULL,
  `delivery_boy_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_order`
--

INSERT INTO `tbl_order` (`id`, `order_id`, `group_id`, `order_date`, `customer_id`, `customer_name`, `delivery_type`, `product_id`, `product_name`, `product_price`, `size_id`, `size_name`, `size_value`, `total_amount`, `cart_status`, `delivery_boy_id`, `delivery_boy_name`) VALUES
(88, '2024111321637362', 1, '2024-11-01 00:00:00', 1, 'Anu', 'On Door ', 9, 'Cow Milk', 80.00, 5, '1 and half Ltr', '1.50', 120.00, 1, 0, ''),
(89, '2024111321637362', 1, '2024-11-01 00:00:00', 1, 'Anu', 'On Door ', 12, 'Buffallo Milk', 40.00, 6, '1 Ltr', '1', 40.00, 1, 0, ''),
(90, '2024111321637362', 1, '2024-11-01 00:00:00', 2, 'Akash', 'On Door ', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 1, 0, ''),
(91, '2024111321637362', 1, '2024-11-01 00:00:00', 9, 'Ankit', 'Knock the Door', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 1, 0, ''),
(92, '2024111321637362', 1, '2024-11-01 00:00:00', 9, 'Ankit', 'Knock the Door', 9, 'Cow Milk', 70.00, 5, '1 and half Ltr', '1.50', 105.00, 1, 0, ''),
(93, '2024111321637362', 1, '2024-11-01 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 12, 'Buffallo Milk', 60.00, 6, '1 Ltr', '1', 60.00, 1, 0, ''),
(94, '2024111321637362', 1, '2024-11-01 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 1, 0, ''),
(95, '2024111321637362', 1, '2024-11-01 00:00:00', 11, 'Shilpi', 'Knock the Door', 9, 'Cow Milk', 70.00, 7, '2 Ltr', '2', 140.00, 1, 0, ''),
(96, '2024111321637362', 1, '2024-11-01 00:00:00', 6, 'Krishna', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 1, 0, ''),
(97, '2024111315741277', 5, '2024-11-01 00:00:00', 3, 'Divya ', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 1, 0, ''),
(98, '2024111315741277', 5, '2024-11-01 00:00:00', 4, 'Sumit', 'On Door ', 9, 'Cow Milk', 70.00, 6, '1 Ltr', '1', 70.00, 1, 0, ''),
(99, '2024111315741277', 5, '2024-11-01 00:00:00', 4, 'Sumit', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 1, 0, ''),
(100, '2024111315741277', 5, '2024-11-01 00:00:00', 5, 'Kunal', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 1, 0, ''),
(101, '2024111306703370', 1, '2024-11-02 00:00:00', 1, 'Anu', 'On Door ', 9, 'Cow Milk', 80.00, 5, '1 and half Ltr', '1.50', 120.00, 1, 0, ''),
(102, '2024111306703370', 1, '2024-11-02 00:00:00', 1, 'Anu', 'On Door ', 12, 'Buffallo Milk', 40.00, 6, '1 Ltr', '1', 40.00, 1, 0, ''),
(103, '2024111306703370', 1, '2024-11-02 00:00:00', 2, 'Akash', 'On Door ', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 1, 0, ''),
(104, '2024111306703370', 1, '2024-11-02 00:00:00', 9, 'Ankit', 'Knock the Door', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 1, 0, ''),
(105, '2024111306703370', 1, '2024-11-02 00:00:00', 9, 'Ankit', 'Knock the Door', 9, 'Cow Milk', 70.00, 5, '1 and half Ltr', '1.50', 105.00, 1, 0, ''),
(106, '2024111306703370', 1, '2024-11-02 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 12, 'Buffallo Milk', 60.00, 6, '1 Ltr', '1', 60.00, 1, 0, ''),
(107, '2024111306703370', 1, '2024-11-02 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 1, 0, ''),
(108, '2024111306703370', 1, '2024-11-02 00:00:00', 11, 'Shilpi', 'Knock the Door', 9, 'Cow Milk', 70.00, 7, '2 Ltr', '2', 140.00, 1, 0, ''),
(109, '2024111306703370', 1, '2024-11-02 00:00:00', 6, 'Krishna', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 1, 0, ''),
(110, '2024111348504183', 5, '2024-11-02 00:00:00', 3, 'Divya ', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 1, 0, ''),
(111, '2024111348504183', 5, '2024-11-02 00:00:00', 4, 'Sumit', 'On Door ', 9, 'Cow Milk', 70.00, 6, '1 Ltr', '1', 70.00, 1, 0, ''),
(112, '2024111348504183', 5, '2024-11-02 00:00:00', 4, 'Sumit', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 1, 0, ''),
(113, '2024111348504183', 5, '2024-11-02 00:00:00', 5, 'Kunal', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 1, 0, ''),
(114, '2024111347360993', 1, '2024-11-03 00:00:00', 1, 'Anu', 'On Door ', 9, 'Cow Milk', 80.00, 5, '1 and half Ltr', '1.50', 120.00, 1, 0, ''),
(115, '2024111347360993', 1, '2024-11-03 00:00:00', 1, 'Anu', 'On Door ', 12, 'Buffallo Milk', 40.00, 6, '1 Ltr', '1', 40.00, 1, 0, ''),
(116, '2024111347360993', 1, '2024-11-03 00:00:00', 2, 'Akash', 'On Door ', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 1, 0, ''),
(117, '2024111347360993', 1, '2024-11-03 00:00:00', 9, 'Ankit', 'Knock the Door', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 1, 0, ''),
(118, '2024111347360993', 1, '2024-11-03 00:00:00', 9, 'Ankit', 'Knock the Door', 9, 'Cow Milk', 70.00, 5, '1 and half Ltr', '1.50', 105.00, 1, 0, ''),
(119, '2024111347360993', 1, '2024-11-03 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 12, 'Buffallo Milk', 60.00, 6, '1 Ltr', '1', 60.00, 1, 0, ''),
(120, '2024111347360993', 1, '2024-11-03 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 1, 0, ''),
(121, '2024111347360993', 1, '2024-11-03 00:00:00', 11, 'Shilpi', 'Knock the Door', 9, 'Cow Milk', 70.00, 7, '2 Ltr', '2', 140.00, 1, 0, ''),
(122, '2024111347360993', 1, '2024-11-03 00:00:00', 6, 'Krishna', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 1, 0, ''),
(123, '2024111314167612', 5, '2024-11-03 00:00:00', 3, 'Divya ', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 1, 0, ''),
(124, '2024111314167612', 5, '2024-11-03 00:00:00', 4, 'Sumit', 'On Door ', 9, 'Cow Milk', 70.00, 6, '1 Ltr', '1', 70.00, 1, 0, ''),
(125, '2024111314167612', 5, '2024-11-03 00:00:00', 4, 'Sumit', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 1, 0, ''),
(126, '2024111314167612', 5, '2024-11-03 00:00:00', 5, 'Kunal', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 1, 0, ''),
(127, '2024111335254911', 1, '2024-11-04 00:00:00', 1, 'Anu', 'On Door ', 9, 'Cow Milk', 80.00, 5, '1 and half Ltr', '1.50', 120.00, 1, 0, ''),
(128, '2024111335254911', 1, '2024-11-04 00:00:00', 1, 'Anu', 'On Door ', 12, 'Buffallo Milk', 40.00, 6, '1 Ltr', '1', 40.00, 1, 0, ''),
(129, '2024111335254911', 1, '2024-11-04 00:00:00', 2, 'Akash', 'On Door ', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 1, 0, ''),
(130, '2024111335254911', 1, '2024-11-04 00:00:00', 9, 'Ankit', 'Knock the Door', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 1, 0, ''),
(131, '2024111335254911', 1, '2024-11-04 00:00:00', 9, 'Ankit', 'Knock the Door', 9, 'Cow Milk', 70.00, 5, '1 and half Ltr', '1.50', 105.00, 1, 0, ''),
(132, '2024111335254911', 1, '2024-11-04 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 12, 'Buffallo Milk', 60.00, 6, '1 Ltr', '1', 60.00, 1, 0, ''),
(133, '2024111335254911', 1, '2024-11-04 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 1, 0, ''),
(134, '2024111335254911', 1, '2024-11-04 00:00:00', 11, 'Shilpi', 'Knock the Door', 9, 'Cow Milk', 70.00, 7, '2 Ltr', '2', 140.00, 1, 0, ''),
(135, '2024111335254911', 1, '2024-11-04 00:00:00', 6, 'Krishna', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 1, 0, ''),
(136, '2024111325852356', 5, '2024-11-04 00:00:00', 3, 'Divya ', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 1, 0, ''),
(137, '2024111325852356', 5, '2024-11-04 00:00:00', 4, 'Sumit', 'On Door ', 9, 'Cow Milk', 70.00, 6, '1 Ltr', '1', 70.00, 1, 0, ''),
(138, '2024111325852356', 5, '2024-11-04 00:00:00', 4, 'Sumit', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 1, 0, ''),
(139, '2024111325852356', 5, '2024-11-04 00:00:00', 5, 'Kunal', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 1, 0, ''),
(140, '2024111350416522', 1, '2024-11-05 00:00:00', 1, 'Anu', 'On Door ', 9, 'Cow Milk', 80.00, 5, '1 and half Ltr', '1.50', 120.00, 1, 0, ''),
(141, '2024111350416522', 1, '2024-11-05 00:00:00', 1, 'Anu', 'On Door ', 12, 'Buffallo Milk', 40.00, 6, '1 Ltr', '1', 40.00, 1, 0, ''),
(142, '2024111350416522', 1, '2024-11-05 00:00:00', 2, 'Akash', 'On Door ', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 1, 0, ''),
(143, '2024111350416522', 1, '2024-11-05 00:00:00', 9, 'Ankit', 'Knock the Door', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 1, 0, ''),
(144, '2024111350416522', 1, '2024-11-05 00:00:00', 9, 'Ankit', 'Knock the Door', 9, 'Cow Milk', 70.00, 5, '1 and half Ltr', '1.50', 105.00, 1, 0, ''),
(145, '2024111350416522', 1, '2024-11-05 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 12, 'Buffallo Milk', 60.00, 6, '1 Ltr', '1', 60.00, 1, 0, ''),
(146, '2024111350416522', 1, '2024-11-05 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 1, 0, ''),
(147, '2024111350416522', 1, '2024-11-05 00:00:00', 11, 'Shilpi', 'Knock the Door', 9, 'Cow Milk', 70.00, 7, '2 Ltr', '2', 140.00, 1, 0, ''),
(148, '2024111350416522', 1, '2024-11-05 00:00:00', 6, 'Krishna', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 1, 0, ''),
(149, '2024111341236922', 5, '2024-11-05 00:00:00', 3, 'Divya ', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 1, 0, ''),
(150, '2024111341236922', 5, '2024-11-05 00:00:00', 4, 'Sumit', 'On Door ', 9, 'Cow Milk', 70.00, 6, '1 Ltr', '1', 70.00, 1, 0, ''),
(151, '2024111341236922', 5, '2024-11-05 00:00:00', 4, 'Sumit', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 1, 0, ''),
(152, '2024111341236922', 5, '2024-11-05 00:00:00', 5, 'Kunal', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 1, 0, ''),
(153, '2024111314195002', 1, '2024-11-06 00:00:00', 1, 'Anu', 'On Door ', 9, 'Cow Milk', 80.00, 5, '1 and half Ltr', '1.50', 120.00, 1, 0, ''),
(154, '2024111314195002', 1, '2024-11-06 00:00:00', 1, 'Anu', 'On Door ', 12, 'Buffallo Milk', 40.00, 6, '1 Ltr', '1', 40.00, 1, 0, ''),
(155, '2024111314195002', 1, '2024-11-06 00:00:00', 2, 'Akash', 'On Door ', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 1, 0, ''),
(156, '2024111314195002', 1, '2024-11-06 00:00:00', 9, 'Ankit', 'Knock the Door', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 1, 0, ''),
(157, '2024111314195002', 1, '2024-11-06 00:00:00', 9, 'Ankit', 'Knock the Door', 9, 'Cow Milk', 70.00, 5, '1 and half Ltr', '1.50', 105.00, 1, 0, ''),
(158, '2024111314195002', 1, '2024-11-06 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 12, 'Buffallo Milk', 60.00, 6, '1 Ltr', '1', 60.00, 1, 0, ''),
(159, '2024111314195002', 1, '2024-11-06 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 1, 0, ''),
(160, '2024111314195002', 1, '2024-11-06 00:00:00', 11, 'Shilpi', 'Knock the Door', 9, 'Cow Milk', 70.00, 7, '2 Ltr', '2', 140.00, 1, 0, ''),
(161, '2024111314195002', 1, '2024-11-06 00:00:00', 6, 'Krishna', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 1, 0, ''),
(162, '2024111350935326', 5, '2024-11-06 00:00:00', 3, 'Divya ', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 1, 0, ''),
(163, '2024111350935326', 5, '2024-11-06 00:00:00', 4, 'Sumit', 'On Door ', 9, 'Cow Milk', 70.00, 6, '1 Ltr', '1', 70.00, 1, 0, ''),
(164, '2024111350935326', 5, '2024-11-06 00:00:00', 4, 'Sumit', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 1, 0, ''),
(165, '2024111350935326', 5, '2024-11-06 00:00:00', 5, 'Kunal', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 1, 0, ''),
(166, '2024111359248647', 1, '2024-11-07 00:00:00', 1, 'Anu', 'On Door ', 9, 'Cow Milk', 80.00, 5, '1 and half Ltr', '1.50', 120.00, 1, 0, ''),
(167, '2024111359248647', 1, '2024-11-07 00:00:00', 1, 'Anu', 'On Door ', 12, 'Buffallo Milk', 40.00, 6, '1 Ltr', '1', 40.00, 1, 0, ''),
(168, '2024111359248647', 1, '2024-11-07 00:00:00', 2, 'Akash', 'On Door ', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 1, 0, ''),
(169, '2024111359248647', 1, '2024-11-07 00:00:00', 9, 'Ankit', 'Knock the Door', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 1, 0, ''),
(170, '2024111359248647', 1, '2024-11-07 00:00:00', 9, 'Ankit', 'Knock the Door', 9, 'Cow Milk', 70.00, 5, '1 and half Ltr', '1.50', 105.00, 1, 0, ''),
(171, '2024111359248647', 1, '2024-11-07 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 12, 'Buffallo Milk', 60.00, 6, '1 Ltr', '1', 60.00, 1, 0, ''),
(172, '2024111359248647', 1, '2024-11-07 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 1, 0, ''),
(173, '2024111359248647', 1, '2024-11-07 00:00:00', 11, 'Shilpi', 'Knock the Door', 9, 'Cow Milk', 70.00, 7, '2 Ltr', '2', 140.00, 1, 0, ''),
(174, '2024111359248647', 1, '2024-11-07 00:00:00', 6, 'Krishna', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 1, 0, ''),
(175, '2024111327180720', 5, '2024-11-07 00:00:00', 3, 'Divya ', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 1, 0, ''),
(176, '2024111327180720', 5, '2024-11-07 00:00:00', 4, 'Sumit', 'On Door ', 9, 'Cow Milk', 70.00, 6, '1 Ltr', '1', 70.00, 1, 0, ''),
(177, '2024111327180720', 5, '2024-11-07 00:00:00', 4, 'Sumit', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 1, 0, ''),
(178, '2024111327180720', 5, '2024-11-07 00:00:00', 5, 'Kunal', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 1, 0, ''),
(179, '2024111319804719', 1, '2024-11-08 00:00:00', 1, 'Anu', 'On Door ', 9, 'Cow Milk', 80.00, 5, '1 and half Ltr', '1.50', 120.00, 1, 0, ''),
(180, '2024111319804719', 1, '2024-11-08 00:00:00', 1, 'Anu', 'On Door ', 12, 'Buffallo Milk', 40.00, 6, '1 Ltr', '1', 40.00, 1, 0, ''),
(181, '2024111319804719', 1, '2024-11-08 00:00:00', 2, 'Akash', 'On Door ', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 1, 0, ''),
(182, '2024111319804719', 1, '2024-11-08 00:00:00', 9, 'Ankit', 'Knock the Door', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 1, 0, ''),
(183, '2024111319804719', 1, '2024-11-08 00:00:00', 9, 'Ankit', 'Knock the Door', 9, 'Cow Milk', 70.00, 5, '1 and half Ltr', '1.50', 105.00, 1, 0, ''),
(184, '2024111319804719', 1, '2024-11-08 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 12, 'Buffallo Milk', 60.00, 6, '1 Ltr', '1', 60.00, 1, 0, ''),
(185, '2024111319804719', 1, '2024-11-08 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 1, 0, ''),
(186, '2024111319804719', 1, '2024-11-08 00:00:00', 11, 'Shilpi', 'Knock the Door', 9, 'Cow Milk', 70.00, 7, '2 Ltr', '2', 140.00, 1, 0, ''),
(187, '2024111319804719', 1, '2024-11-08 00:00:00', 6, 'Krishna', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 1, 0, ''),
(188, '2024111342330026', 5, '2024-11-08 00:00:00', 3, 'Divya ', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 1, 0, ''),
(189, '2024111342330026', 5, '2024-11-08 00:00:00', 4, 'Sumit', 'On Door ', 9, 'Cow Milk', 70.00, 6, '1 Ltr', '1', 70.00, 1, 0, ''),
(190, '2024111342330026', 5, '2024-11-08 00:00:00', 4, 'Sumit', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 1, 0, ''),
(191, '2024111342330026', 5, '2024-11-08 00:00:00', 5, 'Kunal', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 1, 0, ''),
(192, '2024111329687214', 1, '2024-11-09 00:00:00', 1, 'Anu', 'On Door ', 12, 'Buffallo Milk', 40.00, 6, '1 Ltr', '1', 40.00, 1, 0, ''),
(193, '2024111329687214', 1, '2024-11-09 00:00:00', 2, 'Akash', 'On Door ', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 1, 0, ''),
(194, '2024111329687214', 1, '2024-11-09 00:00:00', 9, 'Ankit', 'Knock the Door', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 1, 0, ''),
(195, '2024111329687214', 1, '2024-11-09 00:00:00', 9, 'Ankit', 'Knock the Door', 9, 'Cow Milk', 70.00, 5, '1 and half Ltr', '1.50', 105.00, 1, 0, ''),
(196, '2024111329687214', 1, '2024-11-09 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 12, 'Buffallo Milk', 60.00, 6, '1 Ltr', '1', 60.00, 1, 0, ''),
(197, '2024111329687214', 1, '2024-11-09 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 1, 0, ''),
(198, '2024111329687214', 1, '2024-11-09 00:00:00', 11, 'Shilpi', 'Knock the Door', 9, 'Cow Milk', 70.00, 7, '2 Ltr', '2', 140.00, 1, 0, ''),
(199, '2024111329687214', 1, '2024-11-09 00:00:00', 6, 'Krishna', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 1, 0, ''),
(200, '2024111349490271', 5, '2024-11-09 00:00:00', 3, 'Divya ', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 1, 0, ''),
(201, '2024111349490271', 5, '2024-11-09 00:00:00', 4, 'Sumit', 'On Door ', 9, 'Cow Milk', 70.00, 6, '1 Ltr', '1', 70.00, 1, 0, ''),
(202, '2024111349490271', 5, '2024-11-09 00:00:00', 4, 'Sumit', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 1, 0, ''),
(203, '2024111349490271', 5, '2024-11-09 00:00:00', 5, 'Kunal', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 1, 0, ''),
(204, '2024111301844258', 1, '2024-11-10 00:00:00', 1, 'Anu', 'On Door ', 12, 'Buffallo Milk', 40.00, 6, '1 Ltr', '1', 40.00, 1, 0, ''),
(205, '2024111301844258', 1, '2024-11-10 00:00:00', 2, 'Akash', 'On Door ', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 1, 0, ''),
(206, '2024111301844258', 1, '2024-11-10 00:00:00', 9, 'Ankit', 'Knock the Door', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 1, 0, ''),
(207, '2024111301844258', 1, '2024-11-10 00:00:00', 9, 'Ankit', 'Knock the Door', 9, 'Cow Milk', 70.00, 5, '1 and half Ltr', '1.50', 105.00, 1, 0, ''),
(208, '2024111301844258', 1, '2024-11-10 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 12, 'Buffallo Milk', 60.00, 6, '1 Ltr', '1', 60.00, 1, 0, ''),
(209, '2024111301844258', 1, '2024-11-10 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 1, 0, ''),
(210, '2024111301844258', 1, '2024-11-10 00:00:00', 11, 'Shilpi', 'Knock the Door', 9, 'Cow Milk', 70.00, 7, '2 Ltr', '2', 140.00, 1, 0, ''),
(211, '2024111301844258', 1, '2024-11-10 00:00:00', 6, 'Krishna', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 1, 0, ''),
(212, '2024111311748667', 5, '2024-11-10 00:00:00', 3, 'Divya ', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 1, 0, ''),
(213, '2024111311748667', 5, '2024-11-10 00:00:00', 4, 'Sumit', 'On Door ', 9, 'Cow Milk', 70.00, 6, '1 Ltr', '1', 70.00, 1, 1, 'Anu'),
(214, '2024111311748667', 5, '2024-11-10 00:00:00', 4, 'Sumit', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 1, 1, 'Anu'),
(215, '2024111311748667', 5, '2024-11-10 00:00:00', 5, 'Kunal', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 1, 1, 'Anu'),
(216, '2024111340965605', 1, '2024-11-11 00:00:00', 1, 'Anu', 'On Door ', 12, 'Buffallo Milk', 40.00, 6, '1 Ltr', '1', 40.00, 1, 0, ''),
(217, '2024111340965605', 1, '2024-11-11 00:00:00', 2, 'Akash', 'On Door ', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 1, 0, ''),
(218, '2024111340965605', 1, '2024-11-11 00:00:00', 9, 'Ankit', 'Knock the Door', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 1, 0, ''),
(219, '2024111340965605', 1, '2024-11-11 00:00:00', 9, 'Ankit', 'Knock the Door', 9, 'Cow Milk', 70.00, 5, '1 and half Ltr', '1.50', 105.00, 1, 0, ''),
(220, '2024111340965605', 1, '2024-11-11 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 12, 'Buffallo Milk', 60.00, 6, '1 Ltr', '1', 60.00, 1, 0, ''),
(221, '2024111340965605', 1, '2024-11-11 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 1, 0, ''),
(222, '2024111340965605', 1, '2024-11-11 00:00:00', 11, 'Shilpi', 'Knock the Door', 9, 'Cow Milk', 70.00, 7, '2 Ltr', '2', 140.00, 1, 0, ''),
(223, '2024111340965605', 1, '2024-11-11 00:00:00', 6, 'Krishna', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 1, 0, ''),
(224, '2024111334812717', 5, '2024-11-11 00:00:00', 3, 'Divya ', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 1, 0, ''),
(225, '2024111334812717', 5, '2024-11-11 00:00:00', 4, 'Sumit', 'On Door ', 9, 'Cow Milk', 70.00, 6, '1 Ltr', '1', 70.00, 1, 0, ''),
(226, '2024111334812717', 5, '2024-11-11 00:00:00', 4, 'Sumit', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 1, 0, ''),
(227, '2024111334812717', 5, '2024-11-11 00:00:00', 5, 'Kunal', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 1, 0, ''),
(228, '2024111354243276', 1, '2024-11-12 00:00:00', 1, 'Anu', 'On Door ', 12, 'Buffallo Milk', 40.00, 6, '1 Ltr', '1', 40.00, 1, 0, ''),
(229, '2024111354243276', 1, '2024-11-12 00:00:00', 2, 'Akash', 'On Door ', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 1, 0, ''),
(230, '2024111354243276', 1, '2024-11-12 00:00:00', 9, 'Ankit', 'Knock the Door', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 1, 0, ''),
(231, '2024111354243276', 1, '2024-11-12 00:00:00', 9, 'Ankit', 'Knock the Door', 9, 'Cow Milk', 70.00, 5, '1 and half Ltr', '1.50', 105.00, 1, 0, ''),
(232, '2024111354243276', 1, '2024-11-12 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 12, 'Buffallo Milk', 60.00, 6, '1 Ltr', '1', 60.00, 1, 0, ''),
(233, '2024111354243276', 1, '2024-11-12 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 1, 0, ''),
(234, '2024111354243276', 1, '2024-11-12 00:00:00', 11, 'Shilpi', 'Knock the Door', 9, 'Cow Milk', 70.00, 7, '2 Ltr', '2', 140.00, 1, 0, ''),
(235, '2024111354243276', 1, '2024-11-12 00:00:00', 6, 'Krishna', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 1, 0, ''),
(236, '2024111359396603', 5, '2024-11-12 00:00:00', 3, 'Divya ', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 1, 0, ''),
(237, '2024111359396603', 5, '2024-11-12 00:00:00', 4, 'Sumit', 'On Door ', 9, 'Cow Milk', 70.00, 6, '1 Ltr', '1', 70.00, 1, 0, ''),
(238, '2024111359396603', 5, '2024-11-12 00:00:00', 4, 'Sumit', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 1, 1, 'Anu'),
(239, '2024111359396603', 5, '2024-11-12 00:00:00', 5, 'Kunal', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 1, 1, 'Anu'),
(242, '2024111333931404', 6, '2024-11-01 00:00:00', 7, 'Paras ', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 1, 1, 'Anu'),
(243, '2024111333931404', 6, '2024-11-01 00:00:00', 8, 'Hemant', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 1, 1, 'Anu'),
(248, '2024111349230799', 5, '2024-11-13 00:00:00', 4, 'Sumit', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 1, 1, 'Anu'),
(249, '2024111349230799', 5, '2024-11-13 00:00:00', 5, 'Kunal', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 1, 1, 'Anu');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_partner`
--

CREATE TABLE `tbl_partner` (
  `id` int(11) NOT NULL,
  `partner_type` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image1` varchar(255) NOT NULL,
  `thumb1` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_partner`
--

INSERT INTO `tbl_partner` (`id`, `partner_type`, `name`, `image1`, `thumb1`) VALUES
(41, 'International Partner', 'Lorem Ippsum', '687282886baec_1.png', '687282886e580thumb_1.png'),
(42, 'Alumni Partner', 'Lorem Ippsum', '68728292ecf3e_2.png', '68728292ef3d7thumb_2.png'),
(43, 'Alumni Partner', 'Lorem Ippsum', '687282d019f0a_3.png', '687282d01bc5bthumb_3.png'),
(44, 'Alumni Partner', 'client 1', '687282da13418_4.png', '687282da16101thumb_4.png'),
(46, 'Hotel Partner', '', '687282e347d73_5.png', '687282e34a530thumb_5.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_portfolio`
--

CREATE TABLE `tbl_portfolio` (
  `id` int(10) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `image1` varchar(255) DEFAULT NULL,
  `thumb1` varchar(255) DEFAULT NULL,
  `meta_title` text DEFAULT NULL,
  `meta_keyword` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `short_description` varchar(255) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `category` varchar(255) NOT NULL,
  `client` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `completed_date` varchar(255) NOT NULL,
  `project_value` varchar(255) NOT NULL,
  `manager` varchar(255) NOT NULL,
  `designer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_portfolio`
--

INSERT INTO `tbl_portfolio` (`id`, `name`, `url`, `image1`, `thumb1`, `meta_title`, `meta_keyword`, `meta_description`, `short_description`, `description`, `category`, `client`, `location`, `completed_date`, `project_value`, `manager`, `designer`) VALUES
(9, 'Business', 'business', '686d3d8d3c0ec_1.jpg', '686d3d8d3c883thumb_1.jpg', '', '', '', 'Big Data Services', '<p>Every great project tells a story &mdash; from the client&rsquo;s initial vision to the final reveal. In this blog, we take you behind the scenes of one of our favorite projects, sharing how we worked closely with the <strong data-start=\"2619\" data-end=\"2629\">client</strong>, the challenges we overcame, and how our <strong data-start=\"2671\" data-end=\"2683\">designer</strong> team delivered a stunning result within the <strong data-start=\"2728\" data-end=\"2745\">project value</strong> and deadline. This case study highlights our approach, work ethic, and the importance of clear communication with the client throughout the journey</p>', 'Web development', 'Sbs', 'agra up', '2025-07-12', 'Fcs', 'Styvrat sir', 'Piyush'),
(10, 'Consulting', 'consulting', '686d3dc097ec0_2.jpg', '686d3dc09d190thumb_2.jpg', '', '', '', 'HR Recruiting', '<p>Before you begin any project, whether it&rsquo;s residential, commercial, or industrial, it\'s important to finalize three major aspects: the <strong data-start=\"1700\" data-end=\"1712\">category</strong>, <strong data-start=\"1714\" data-end=\"1726\">location</strong>, and <strong data-start=\"1732\" data-end=\"1749\">project value</strong>. These elements determine not only the design and construction approach but also the approvals, resources, and timeline required. This blog provides a detailed breakdown of how to strategically plan each element and avoid costly mistakes in the early stages of your project.</p>', 'digital marketing', 'Artbots', 'agra up', '2025-07-01', 'Fcs', 'Styvrat sir', 'Piyush'),
(11, 'Strategy', 'strategy', '686d3dea403c8_3.jpg', '686d3dea42f66thumb_3.jpg', '', '', '', 'Security Services', '<p>This project was designed and developed in close collaboration with the manufacturer to ensure the highest quality standards and performance. Every component used in this project reflects precision engineering and reliable craftsmanship. The manufacturer ensured that the materials, design, and technical specifications aligned with both client requirements and industry benchmarks. From concept to completion, the project demonstrates a perfect blend of innovation, durability, and aesthetic appeal.</p>', 'Ras', 'Bsdu', 'Jaipur Rajsthan', '2025-07-08', 'Fcs', 'Styvrat sir', 'Piyush'),
(12, 'Finance', 'finance', '686d3e0a9a081_4.jpg', '686d3e0a9c0e9thumb_4.jpg', '', '', '', 'Sales Enablement', '<p>Selecting the right <strong data-start=\"668\" data-end=\"680\">designer</strong> and <strong data-start=\"685\" data-end=\"704\">project manager</strong> can make or break your construction or renovation project. The designer brings creativity and vision, while the project manager ensures everything stays on schedule and within budget. In this blog, we&rsquo;ll explore the key qualities to look for in both roles, how to collaborate effectively as a client, and what red flags to avoid during hiring. Whether you\'re working on a residential space or a commercial setup, having the right team is your first step toward success.</p>', 'Manufacturing', 'Eadwine Tech', 'agra up', '2025-07-09', 'fms', 'Styvrat sir', 'Piyush'),
(14, ' Importance of Financial Planning for Small Businesses', '-importance-of-financial-planning-for-small-businesses', '686e2a49348e2_9.jpg', '686e2a49370e6thumb_9.jpg', '', '', '', 'inancial planning is the backbone of every successful small business.', '<p>A good financial plan helps small businesses manage their income, expenses, taxes, and growth. Without proper financial planning, many businesses struggle to survive in the competitive market. CAs play a vital role in structuring budgets, forecasting future growth, and ensuring tax compliance.</p>', 'Finance', 'CA S.K. Sharma', 'agra up', '2025-07-02', 'Fcs', 'Styvrat sir', 'Piyush'),
(15, 'GST Return Filing Mistakes to Avoid', 'gst-return-filing-mistakes-to-avoid', '686e2a2c1e102_6.jpg', '686e2a2c1ed93thumb_6.jpg', '', '', '', 'Avoid common GST filing errors that can lead to penalties.', '<p>Many businesses make errors in their GST returns like incorrect invoice details, mismatched data in GSTR-1 and 3B, or missing deadlines. A Chartered Accountant helps prevent these mistakes by regular reconciliation and ensuring timely submission. Staying updated with GST rules is key to avoiding notices and penalties.</p>', 'Taxation', 'CA Neha Verma', 'agra up', '2025-07-09', 'CA', 'Styvrat sir', 'Piyush'),
(16, 'How a CA Can Help During Income Tax Scrutiny', 'how-a-ca-can-help-during-income-tax-scrutiny', '686e2189648e7_6.jpg', '686e2189667a0thumb_6.jpg', '', '', '', 'Don’t panic during tax scrutiny – consult your CA.', '<p data-start=\"1513\" data-end=\"1830\">When the Income Tax Department selects a return for scrutiny, it is crucial to handle it professionally. A CA helps gather required documents, prepare replies, and represent the client before authorities. Their expertise reduces chances of penalties and ensures a smooth resolution of queries.</p>', '', ' Income Tax', 'Jaipur Rajsthan', '2025-07-11', 'Fcs', 'Styvrat sir', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_portfolio_image`
--

CREATE TABLE `tbl_portfolio_image` (
  `id` int(10) NOT NULL,
  `service_id` int(10) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image1` varchar(255) DEFAULT NULL,
  `thumb1` varchar(255) DEFAULT NULL,
  `url` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_portfolio_image`
--

INSERT INTO `tbl_portfolio_image` (`id`, `service_id`, `name`, `image1`, `thumb1`, `url`) VALUES
(20, 0, 'Image4', '6749a9d02f217_four.jpg', '6749a9d02f535thumb_four.jpg', 'image'),
(21, 0, 'Image5', '6749a9a1cebea_five.jpg', '6749a9a1ceea5thumb_five.jpg', 'image'),
(22, 0, 'Image6', '6749a9ecd2d61_six.jpg', '6749a9ecd30d9thumb_six.jpg', 'image');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `short_description` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` varchar(255) NOT NULL,
  `base_price` varchar(255) NOT NULL,
  `internship` varchar(255) NOT NULL,
  `image1` varchar(255) NOT NULL,
  `thumb1` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `price_half` decimal(10,2) DEFAULT 0.00,
  `price_full` decimal(10,2) DEFAULT 0.00,
  `thumb2` varchar(255) NOT NULL,
  `thumb3` varchar(255) NOT NULL,
  `extra_images` longtext DEFAULT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_keyword` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`id`, `category_id`, `name`, `short_description`, `description`, `price`, `base_price`, `internship`, `image1`, `thumb1`, `status`, `price_half`, `price_full`, `thumb2`, `thumb3`, `extra_images`, `meta_title`, `meta_keyword`, `meta_description`) VALUES
(22, 7, 'Pizza', 'Baked flatbread topped with cheese and veggies.', '<p>Italian-style pizza with tomato sauce, mozzarella cheese, and mixed veggies.</p>', '', '', '', '6905882f1cdd5_ivan-torres-MQUqbmszGGM-unsplash.jpg', '6905882f1d8d7thumb_ivan-torres-MQUqbmszGGM-unsplash.jpg', 1, 169.00, 299.00, '', '', NULL, '', '', ''),
(23, 7, 'French Fries', 'Crispy golden potato fries.', '<p>Thin, crispy fries made from fresh potatoes, served hot with ketchup or mayo.</p>', '', '', '', '69058888bb67c_pixzolo-photography-8YBHgP0WrEo-unsplash.jpg', '69058888bbe03thumb_pixzolo-photography-8YBHgP0WrEo-unsplash.jpg', 1, 59.00, 99.00, '', '', NULL, '', '', ''),
(24, 7, 'Hot Dog', 'Grilled sausage in a bun.', '<p>Juicy chicken sausage stuffed in a soft bun with ketchup and mustard.</p>\r\n<p>&nbsp;</p>', '', '', '', '690588dacfa5f_ball-park-brand-0GDN7NSoYRI-unsplash.jpg', '690588dad0176thumb_ball-park-brand-0GDN7NSoYRI-unsplash.jpg', 1, 79.00, 129.00, '', '', NULL, '', '', ''),
(25, 7, 'Sandwich', 'Layers of bread, veggies & cheese.', '<p>Club sandwich loaded with vegetables, cheese, and creamy dressing.</p>\r\n<p>&nbsp;</p>', '', '', '', '6905895f06a58_mae-mu-IZ0LRt1khgM-unsplash.jpg', '6905895f0725fthumb_mae-mu-IZ0LRt1khgM-unsplash.jpg', 1, 79.00, 119.00, '', '', NULL, '', '', ''),
(26, 7, 'Momos', 'Steamed dumplings with fillings.', '<p>Soft dumplings filled with spiced vegetables or chicken, served with chili sauce.</p>\r\n<p>&nbsp;</p>', '', '', '', '69058a0de9f15_shiv-singh-Vj-J5xNjnxA-unsplash.jpg', '69058a0def458thumb_shiv-singh-Vj-J5xNjnxA-unsplash.jpg', 1, 59.00, 99.00, '', '', NULL, '', '', ''),
(27, 7, 'Noodles', 'Stir-fried noodles with sauces.', '<p>Chinese-style fried noodles with vegetables and soy sauce.</p>\r\n<p>&nbsp;</p>', '', '', '', '69058a40815a5_krista-stucchio-2CZ0Zpuj-gU-unsplash.jpg', '69058a4081b8bthumb_krista-stucchio-2CZ0Zpuj-gU-unsplash.jpg', 1, 79.00, 129.00, '', '', NULL, '', '', ''),
(28, 8, 'Biryani', 'Spiced rice with meat or veggies.', '<p>Flavored rice cooked with aromatic spices and tender chicken or vegetables.</p>\r\n<p>&nbsp;</p>', '', '', '', '69058a9feb802_suchandra-varma-TNNZ8KNPfbY-unsplash.jpg', '69058a9fec184thumb_suchandra-varma-TNNZ8KNPfbY-unsplash.jpg', 1, 149.00, 249.00, '', '', NULL, '', '', ''),
(29, 8, 'Butter Chicken', 'Creamy chicken curry.', '<p>Soft chicken pieces cooked in buttery tomato gravy with cream and Indian spices.</p>\r\n<p>&nbsp;</p>', '', '', '', '69058aeab7c7d_raman-sqcH2q7lkvo-unsplash.jpg', '69058aeab8944thumb_raman-sqcH2q7lkvo-unsplash.jpg', 1, 179.00, 279.00, '', '', NULL, '', '', ''),
(30, 8, 'Paneer Tikka', 'Grilled paneer cubes.', '<p>Paneer marinated in yogurt and spices, grilled until smoky.</p>\r\n<p>&nbsp;</p>', '', '', '', '69058b2c4797b_rupa-venketa-vardhan-85gaOsWNsHo-unsplash.jpg', '69058b2c48a8bthumb_rupa-venketa-vardhan-85gaOsWNsHo-unsplash.jpg', 1, 129.00, 199.00, '', '', NULL, '', '', ''),
(31, 8, 'Masala Dosa', 'Crispy rice crepe with filling.', '<p>Crispy dosa filled with mashed potato masala, served with sambhar &amp; chutney.</p>\r\n<p>&nbsp;</p>', '', '', '', '69058bd278d5b_deepal-tamang-5oF7d_hPJG4-unsplash.jpg', '69058bd2d47f9thumb_deepal-tamang-5oF7d_hPJG4-unsplash.jpg', 1, 99.00, 149.00, '', '', NULL, '', '', ''),
(32, 9, 'Grilled Chicken', 'Marinated chicken grilled.', '<p>Herb-marinated chicken grilled over flame for a smoky flavor.</p>\r\n<p>&nbsp;</p>', '', '', '', '69058cbf30ed7_daniel-hooper-PaaboPF3dVY-unsplash.jpg', '69058cbf31dc2thumb_daniel-hooper-PaaboPF3dVY-unsplash.jpg', 1, 189.00, 299.00, '', '', NULL, '', '', ''),
(33, 9, 'Pasta Alfredo', 'White sauce pasta.', '<p>Creamy Italian pasta made with cheese, milk, and butter sauce.</p>\r\n<p>&nbsp;</p>', '', '', '', '69058d1888288_mohammad-amin-masoudi-X6wi4AV4jJE-unsplash.jpg', '69058d1892c15thumb_mohammad-amin-masoudi-X6wi4AV4jJE-unsplash.jpg', 1, 139.00, 239.00, '', '', NULL, '', '', ''),
(34, 9, 'Caesar Salad', 'Fresh lettuce with dressing.', '<p>Lettuce, parmesan, and croutons tossed with Caesar dressing.</p>\r\n<p>&nbsp;</p>', '', '', '', '69058d63248e3_chris-tweten-FK-UKNip0pE-unsplash.jpg', '69058d632534dthumb_chris-tweten-FK-UKNip0pE-unsplash.jpg', 1, 99.00, 179.00, '', '', NULL, '', '', ''),
(35, 10, 'Chocolate Cake', 'Rich creamy chocolate.', '<p>Soft chocolate sponge layered with dark cocoa frosting.</p>\r\n<p>&nbsp;</p>', '', '', '', '69058de317eb4_jacob-thomas-6jHpcBPw7i8-unsplash.jpg', '69058de318433thumb_jacob-thomas-6jHpcBPw7i8-unsplash.jpg', 1, 99.00, 199.00, '', '', NULL, '', '', ''),
(36, 10, 'Ice Cream', 'Frozen sweet dessert.', '<p>Creamy and cold ice cream available in various flavors.</p>\r\n<p>&nbsp;</p>', '', '', '', '69058e31942bf_ian-dooley-TLD6iCOlyb0-unsplash.jpg', '69058e3194797thumb_ian-dooley-TLD6iCOlyb0-unsplash.jpg', 1, 49.00, 79.00, '', '', NULL, '', '', ''),
(37, 10, 'Gulab Jamun', 'Fried balls in syrup.', '<p>Fried khoya balls soaked in warm sugar syrup.</p>\r\n<p>&nbsp;</p>', '', '', '', '69058ef1cfcf0_umair-ali-asad-2oJ4eGRPqrE-unsplash.jpg', '69058ef1d0471thumb_umair-ali-asad-2oJ4eGRPqrE-unsplash.jpg', 1, 49.00, 89.00, '', '', NULL, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_category`
--

CREATE TABLE `tbl_product_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `image1` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `created_date` datetime DEFAULT current_timestamp(),
  `updated_date` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_product_category`
--

INSERT INTO `tbl_product_category` (`id`, `name`, `slug`, `image1`, `url`, `status`, `created_date`, `updated_date`) VALUES
(7, 'Fast Food', NULL, NULL, '', 1, '2025-10-31 21:03:49', '2025-10-31 21:03:49'),
(8, 'Indian Cuisine', NULL, NULL, '', 1, '2025-10-31 21:19:42', '2025-10-31 21:19:42'),
(9, 'Continental Food', NULL, NULL, '', 1, '2025-10-31 21:26:36', '2025-10-31 21:26:36'),
(10, 'Desserts', NULL, NULL, '', 1, '2025-10-31 21:33:42', '2025-10-31 21:33:42');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_room_booking`
--

CREATE TABLE `tbl_room_booking` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `checkin` date NOT NULL,
  `checkout` date NOT NULL,
  `rooms` text NOT NULL,
  `guests` int(11) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(255) NOT NULL,
  `room_number` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_room_booking`
--

INSERT INTO `tbl_room_booking` (`id`, `name`, `email`, `checkin`, `checkout`, `rooms`, `guests`, `phone`, `created_at`, `status`, `room_number`, `user_id`) VALUES
(22, 'sanju', 'surajfoujdar90@gmail.com', '2025-09-10', '2025-09-11', '2', 1, '75785896966787', '2025-09-09 04:36:07', 'confirmed', '', ''),
(23, 'gajendra', 'Surajfoujdar45@gmail.com', '2025-10-11', '2025-10-11', '1', 1, '0902 424 4731', '2025-09-09 07:20:41', 'confirmed', '', ''),
(24, 'Suraj singh', 'Surajfoujdar90@gmail.com', '2025-09-09', '2025-09-11', '3', 1, '0902 424 4731', '2025-09-09 07:44:57', 'confirmed', '', ''),
(25, 'sanju', 'Surajfoujdar90@gmail.com', '2025-09-11', '2025-09-24', '4', 1, '0902 424 4731', '2025-09-09 07:47:10', 'confirmed', '', ''),
(26, 'gajju', 'surajfoujdar90@gmail.com', '2025-09-11', '2025-09-13', '17', 1, '8239840816', '2025-09-11 08:43:59', 'confirmed', '', ''),
(27, 'Suraj singh', 'Surajfoujdar45@gmail.com', '2025-11-06', '2025-11-07', '9', 1, '8239840816', '2025-11-05 09:06:11', 'confirmed', '285', ''),
(28, 'Suraj singh', 'Surajfoujdar45@gmail.com', '2025-11-06', '2025-11-08', '6', 1, '8239840816', '2025-11-05 09:06:32', 'confirmed', '247', ''),
(29, 'Suraj singh', 'Surajfoujdar45@gmail.com', '2025-11-05', '2025-11-06', '8', 1, '8239840816', '2025-11-05 09:19:18', 'confirmed', '108', ''),
(30, 'Suraj', 'surajfoujdar45@gmail.com', '2025-11-06', '2025-11-08', '11', 1, '8854963202', '2025-11-06 03:52:54', 'confirmed', '265', ''),
(31, 'suraj', 'admin@gmail.com', '2026-01-07', '2026-01-10', 'Deluxe Room', 1, '8239840816', '2026-01-07 14:44:37', 'confirmed', '015', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_services`
--

CREATE TABLE `tbl_services` (
  `id` int(10) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `full_description` text DEFAULT NULL,
  `meta_title` text DEFAULT NULL,
  `meta_keyword` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `image1` varchar(255) DEFAULT NULL,
  `thumb1` varchar(255) DEFAULT NULL,
  `image2` varchar(255) DEFAULT NULL,
  `thumb2` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_services`
--

INSERT INTO `tbl_services` (`id`, `name`, `url`, `icon`, `short_description`, `full_description`, `meta_title`, `meta_keyword`, `meta_description`, `image1`, `thumb1`, `image2`, `thumb2`, `status`) VALUES
(36, 'Solution Focused', 'solution-focused', NULL, ' We always provide people a complete solution focused of any business.', '<div>\r\n<div>Cras enim urna, interdum nec porttitor vitae, sollicitudin eu eros. Praesent eget mollis nulla, non lacinia urna. Donec sit amet neque auctor, ornare dui rutrum, condimentum justo. Duis dictum, ex accumsan eleifend eleifend, ex justo aliquam nunc, in ultrices ante quam eget massa. Sed scelerisque, odio eu tempor pulvinar, magna tortor finibus lorem.</div>\r\n</div>', '', '', '', '686e9184b7d45_1.png', '686e9184b9858thumb_1.png', NULL, NULL, 0),
(37, 'Reports Analysis', 'reports-analysis', NULL, 'We always provide people a complete solution focused of any business.', '<div>\r\n<div>Cras enim urna, interdum nec porttitor vitae, sollicitudin eu eros. Praesent eget mollis nulla, non lacinia urna. Donec sit amet neque auctor, ornare dui rutrum, condimentum justo. Duis dictum, ex accumsan eleifend eleifend, ex justo aliquam nunc, in ultrices ante quam eget massa. Sed scelerisque, odio eu tempor pulvinar, magna tortor finibus lorem.</div>\r\n</div>', '', '', '', '686e92fa7b7bd_2.png', '686e92fa7dfebthumb_2.png', NULL, NULL, 0),
(38, 'Profit Planning', 'profit-planning', NULL, 'We always provide people a complete solution focused of any business.', '<p>Profit Planning एक वित्तीय प्रक्रिया है जिसमें व्यापार अपने लक्षित लाभ को पहले से निर्धारित करता है। <br />यह योजना सभी व्यावसायिक गतिविधियों को लाभ के लक्ष्य की ओर निर्देशित करने में मदद करती है। <br />इसमें बजट बनाना, लागत नियंत्रण और राजस्व अनुमान शामिल होते हैं। <br />Profit Planning से व्यवसाय को जोखिम कम करने और संसाधनों का सही उपयोग सुनिश्चित करने में मदद मिलती है। <br />यह व्यवसाय की दीर्घकालिक स्थिरता और विकास सुनिश्चित करने का एक महत्वपूर्ण उपकरण है।</p>', '', '', '', '686e959211d91_3.png', '686e95921282fthumb_3.png', NULL, NULL, 0),
(39, 'Project Reporting', 'project-reporting', NULL, 'We always provide people a complete solution focused of any business.', '<p>Project Reporting एक प्रक्रिया है जिसमें परियोजना की प्रगति, बजट और प्रदर्शन की जानकारी नियमित रूप से साझा की जाती है। <br />यह रिपोर्ट सभी stakeholders को पारदर्शिता और निर्णय लेने में सहायता प्रदान करती है। <br />Project Reporting से यह सुनिश्चित होता है कि प्रोजेक्ट निर्धारित समय और लागत में पूरा हो। <br />इसमें milestone tracking, risk updates और resource utilization की जानकारी शामिल होती है। <br />यह प्रक्रिया टीम के बीच सहयोग को बढ़ावा देती है और परियोजना को सफल बनाने में अहम भूमिका निभाती है।</p>', '', '', '', '686e95bc664ff_4.png', '686e95bc69874thumb_4.png', NULL, NULL, 0),
(40, 'Estate Planning', 'estate-planning', NULL, 'We always provide people a complete solution focused of any business.', '<p>Estate Planning एक ऐसी प्रक्रिया है जिसमें व्यक्ति अपनी संपत्ति का प्रबंधन और वितरण मृत्यु के बाद कैसे होगा, यह पहले से तय करता है। <br />इसमें वसीयत (will), नामांकन और ट्रस्ट जैसी कानूनी व्यवस्थाएँ शामिल होती हैं। <br />यह योजना संपत्ति विवादों को रोकती है और उत्तराधिकारियों को वित्तीय सुरक्षा देती है। <br />Estate Planning टैक्स बचत और संपत्ति के सही उपयोग में भी मदद करता है। <br />यह हर उस व्यक्ति के लिए जरूरी है जो चाहता है कि उसकी संपत्ति सही हाथों में जाए।</p>', '', '', '', '686e95ed54e45_2.png', '686e95ed571c5thumb_2.png', NULL, NULL, 0),
(41, 'Security Enhanced', 'security-enhanced', NULL, 'We always provide people a complete solution focused of any business.', '<p>Security Enhanced सेवाएँ आपकी कंपनी के डेटा और सिस्टम को साइबर खतरों से सुरक्षित रखने में मदद करती हैं। <br />इनमें नेटवर्क सुरक्षा, एन्क्रिप्शन, फायरवॉल, और यूज़र एक्सेस कंट्रोल शामिल होते हैं। <br />यह सेवाएँ हैकिंग, मालवेयर और डेटा चोरी जैसी समस्याओं से सुरक्षा प्रदान करती हैं। <br />Security Enhanced समाधान व्यापार की विश्वसनीयता और ग्राहक विश्वास बढ़ाने में महत्वपूर्ण भूमिका निभाते हैं। <br />यह तकनीकी ढांचा सुनिश्चित करता है कि आपकी जानकारी सुरक्षित और गोपनीय बनी रहे।</p>', '', '', '', '686e96106007a_1.png', '686e96106365ethumb_1.png', NULL, NULL, 0),
(42, 'Cloud Computing', 'cloud-computing', NULL, 'We always provide people a complete solution focused of any business', '<p>Cloud Computing एक तकनीक है जिससे डेटा और एप्लिकेशन इंटरनेट के ज़रिए स्टोर और एक्सेस किए जाते हैं। <br />यह कंपनियों को अपने सर्वर, स्टोरेज और सॉफ्टवेयर को ऑनलाइन उपयोग करने की सुविधा देता है। <br />इससे लागत कम होती है, स्केलेबिलिटी बढ़ती है और मेंटेनेंस का झंझट खत्म होता है। <br />Cloud services 24/7 उपलब्ध होती हैं और किसी भी डिवाइस से एक्सेस की जा सकती हैं। <br />यह तकनीक आधुनिक बिज़नेस के लिए तेज़, सुरक्षित और लचीला समाधान प्रदान करती है।</p>', '', '', '', '686e96359ff3e_3.png', '686e9635a8126thumb_3.png', NULL, NULL, 0),
(43, 'Cryptocurrency', 'cryptocurrency', NULL, 'We always provide people a complete solution focused of any business.', '<p>Cryptocurrency एक डिजिटल मुद्रा है जो ब्लॉकचेन तकनीक पर आधारित होती है और सुरक्षित लेनदेन के लिए क्रिप्टोग्राफी का उपयोग करती है। <br />यह बिना किसी केंद्रीय बैंक या सरकार के नियंत्रण के काम करती है, जिससे यह विकेंद्रीकृत होती है। <br />Bitcoin, Ethereum जैसी क्रिप्टोकरेंसीज़ आज ग्लोबल फाइनेंस में तेजी से लोकप्रिय हो रही हैं। <br />Cryptocurrency से तेज, सुरक्षित और ट्रांसपेरेंट ट्रांजैक्शन संभव होते हैं। <br />यह निवेश और भुगतान का आधुनिक विकल्प बनता जा रहा है, खासकर डिजिटल इकॉनॉमी में।</p>', '', '', '', '686e96607d7ed_4.png', '686e96608018ethumb_4.png', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_setting`
--

CREATE TABLE `tbl_setting` (
  `id` int(10) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone1` varchar(255) DEFAULT NULL,
  `phone2` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `address1` varchar(255) DEFAULT NULL,
  `link1` varchar(255) DEFAULT NULL,
  `link2` varchar(255) DEFAULT NULL,
  `link3` varchar(255) DEFAULT NULL,
  `link4` varchar(255) DEFAULT NULL,
  `link5` text DEFAULT NULL,
  `link6` text DEFAULT NULL,
  `map` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `about_since` varchar(255) DEFAULT NULL,
  `about_us_heading` text DEFAULT NULL,
  `about_us_sub_heading` text DEFAULT NULL,
  `about_short` text DEFAULT NULL,
  `image1` varchar(255) DEFAULT NULL,
  `thumb1` varchar(255) DEFAULT NULL,
  `image2` varchar(255) NOT NULL,
  `thumb2` varchar(255) NOT NULL,
  `image3` varchar(255) NOT NULL,
  `thumb3` varchar(255) NOT NULL,
  `image4` varchar(255) NOT NULL,
  `thumb4` varchar(255) NOT NULL,
  `image5` varchar(255) NOT NULL,
  `thumb5` varchar(255) NOT NULL,
  `top_heading` varchar(255) DEFAULT NULL,
  `about_us_narration` varchar(255) NOT NULL,
  `experience` varchar(255) NOT NULL,
  `point1` varchar(255) NOT NULL,
  `point2` varchar(255) DEFAULT NULL,
  `point3` varchar(255) DEFAULT NULL,
  `point4` varchar(255) DEFAULT NULL,
  `point5` varchar(255) NOT NULL,
  `point6` varchar(255) NOT NULL,
  `point7` varchar(255) NOT NULL,
  `point8` varchar(255) NOT NULL,
  `point9` varchar(255) NOT NULL,
  `point10` varchar(255) NOT NULL,
  `point11` varchar(255) NOT NULL,
  `point12` varchar(255) NOT NULL,
  `point13` varchar(255) NOT NULL,
  `point14` varchar(255) NOT NULL,
  `point15` varchar(255) NOT NULL,
  `point16` varchar(255) NOT NULL,
  `value1` varchar(255) NOT NULL,
  `value2` varchar(255) NOT NULL,
  `value3` varchar(255) NOT NULL,
  `value4` varchar(255) NOT NULL,
  `value5` varchar(255) NOT NULL,
  `value6` varchar(255) NOT NULL,
  `value7` varchar(255) NOT NULL,
  `value8` varchar(255) NOT NULL,
  `value9` varchar(255) NOT NULL,
  `value10` varchar(255) NOT NULL,
  `value11` varchar(255) NOT NULL,
  `value12` varchar(255) NOT NULL,
  `value13` varchar(255) NOT NULL,
  `value14` varchar(255) NOT NULL,
  `value15` varchar(255) NOT NULL,
  `value16` varchar(255) NOT NULL,
  `privacy` text DEFAULT NULL,
  `terms` text DEFAULT NULL,
  `returns` text DEFAULT NULL,
  `vission` text NOT NULL,
  `mission` text NOT NULL,
  `career_hospitality` text NOT NULL,
  `internation_intenship` text NOT NULL,
  `alumani` text NOT NULL,
  `life_after_iahm` text NOT NULL,
  `open_timing` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_setting`
--

INSERT INTO `tbl_setting` (`id`, `email`, `phone1`, `phone2`, `address`, `address1`, `link1`, `link2`, `link3`, `link4`, `link5`, `link6`, `map`, `description`, `about_since`, `about_us_heading`, `about_us_sub_heading`, `about_short`, `image1`, `thumb1`, `image2`, `thumb2`, `image3`, `thumb3`, `image4`, `thumb4`, `image5`, `thumb5`, `top_heading`, `about_us_narration`, `experience`, `point1`, `point2`, `point3`, `point4`, `point5`, `point6`, `point7`, `point8`, `point9`, `point10`, `point11`, `point12`, `point13`, `point14`, `point15`, `point16`, `value1`, `value2`, `value3`, `value4`, `value5`, `value6`, `value7`, `value8`, `value9`, `value10`, `value11`, `value12`, `value13`, `value14`, `value15`, `value16`, `privacy`, `terms`, `returns`, `vission`, `mission`, `career_hospitality`, `internation_intenship`, `alumani`, `life_after_iahm`, `open_timing`, `url`) VALUES
(1, 'Surajfoujdar45@gmail.com', '8239840816', '8764480642', 'Ved Nagar Colony Devri Road Agra ', 'Hatheni bharatpur raj.', 'https://www.facebook.com/', 'https://x.com/', 'https://www.instagram.com/', 'https://www.youtube.com/', 'Linkdin', 'Telegram', 'About Cambridge School', '<div>\r\n<div>&nbsp;A relaxing and pleasant atmosphere, good jazz, dinner, and cocktails. The Patio Time Bar opens in the center of Florence. The only bar inspired by the 1960s, it will give you a experience that you&rsquo;ll have a hard time forgetting.</div>\r\n</div>', '1994', 'We Invite You <br> To Visit Our Restaurant', 'The ability to identify market-entry ', 'We are delivering next-generation textile production processes that will be radically efficient & sustainable manufacturer', '68dd646b06983_Yellow_and_Brown_Kitchen_Food_Logo_(1).png', '68dd646b06c05thumb_Yellow_and_Brown_Kitchen_Food_Logo_(1).png', '687243bb51894_2.jpg', '687243bb52dcdthumb_2.jpg', '671b4f07d87ee_img9.jpg', '671b4f07d8e08thumb_img9.jpg', '671b4f07ddce2_img2.jpg', '671b4f07de3a3thumb_img2.jpg', '671b4f07e25d0_img6.jpg', '671b4f07e2ad7thumb_img6.jpg', 'Ordered before 17:30, shipped today ï¿½ Support: +91 7300557847', 'Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet  eius modi tempora data.<', '07', '100% Campus Placement', '17000+ Alumni', '35+ Years Experienced Faculties', '5+ Countries International Internship Option', '100+ Hoteliors in Advisory Council', 'Quality Charger', 'AC Charger Services', 'EV Drivers Services', 'Charge Point Services', 'DC Charger Services', 'DC Charger Services', ' Building Services', '10', ' 42', '18', '30', 'We provide 100% placement for potential students with the best remuneration packages.', 'More than 17000 IAHMians working with renowned Hotel Groups, Airlines, Cruises etc across the world.', 'Highly Qualified and Experienced Faculties including vast experience of Hospitality Industry.', 'Courses with International Internships in countries like Malaysia, France, Dubai etc, progressively enhance candidate\'s career path.', 'More than 100 of hoteliers from top brands of hotels worldwide are in the advisory council of IAHM.', 'Possimus laoreet lec exercit , adipisicing hic ipsum rec sith.', 'Possimus laoreet lec exercit , adipisicing hic ipsum rec sith.', 'Possimus laoreet lec exercit , adipisicing hic ipsum rec sith.', 'Possimus laoreet lec exercit , adipisicing hic ipsum rec sith.', 'Possimus laoreet lec exercit , adipisicing hic ipsum rec sith.', 'Possimus laoreet lec exercit , adipisicing hic ipsum rec sith.', 'Possimus laoreet lec exercit , adipisicing hic ipsum rec sith.', 'Years Experience', 'Service Stations', 'Positive Reviews', 'Happy Customers', '<p><label>Privacy Policy</label></p>', '<p><label>Terms and Conditions</label></p>', '<p><label>Returns &amp; Refunds</label></p>', '', '', '', '', '', '', 'Mon - Sat (09.00AM - 06.00PM)', 'https://maps.google.com/maps?q=Hatheni%2C%20Bharatpur&z=13&output=embed');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_size`
--

CREATE TABLE `tbl_size` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `unit_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_size`
--

INSERT INTO `tbl_size` (`id`, `name`, `unit`, `unit_name`) VALUES
(5, '1 and half Ltr', '1.50', 'Litre'),
(6, '1 Ltr', '1', 'Litre'),
(7, '2 Ltr', '2', 'Litre'),
(8, '1 kg', '1', 'KiloGram'),
(9, '500 g', '.5', 'Gram');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_state`
--

CREATE TABLE `tbl_state` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_state`
--

INSERT INTO `tbl_state` (`id`, `name`, `status`) VALUES
(1, 'Andhra Pradesh', 'Active'),
(2, 'Arunachal Pradesh', 'Active'),
(3, 'Assam', 'Active'),
(4, 'Bihar', 'Active'),
(5, 'Chhattisgarh', 'Active'),
(6, 'Goa', 'Active'),
(7, 'Gujarat', 'Active'),
(8, 'Haryana', 'Active'),
(9, 'Himachal Pradesh', 'Active'),
(10, 'Jharkhand', 'Active'),
(11, 'Karnataka', 'Active'),
(12, 'Kerala', 'Active'),
(13, 'Madhya Pradesh', 'Active'),
(14, 'Maharashtra', 'Active'),
(15, 'Manipur', 'Active'),
(16, 'Meghalaya', 'Active'),
(17, 'Mizoram', 'Active'),
(18, 'Nagaland', 'Active'),
(19, 'Odisha', 'Active'),
(20, 'Punjab', 'Active'),
(21, 'Rajasthan', 'Active'),
(22, 'Sikkim', 'Active'),
(23, 'Tamil Nadu', 'Active'),
(24, 'Telangana', 'Active'),
(25, 'Tripura', 'Active'),
(26, 'Uttar Pradesh', 'Active'),
(27, 'Uttarakhand', 'Active'),
(28, 'West Bengal', 'Active'),
(29, 'Andaman and Nicobar Islands', 'Active'),
(30, 'Chandigarh', 'Active'),
(31, 'Dadra and Nagar Haveli and Daman and Diu', 'Active'),
(32, 'Lakshadweep', 'Active'),
(33, 'Delhi', 'Active'),
(34, 'Puducherry', 'Active'),
(35, 'Ladakh', 'Active'),
(36, 'Jammu and Kashmir', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_team`
--

CREATE TABLE `tbl_team` (
  `id` int(10) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `post` varchar(255) DEFAULT NULL,
  `image1` varchar(255) DEFAULT NULL,
  `thumb1` varchar(255) DEFAULT NULL,
  `image2` varchar(255) NOT NULL,
  `thumb2` varchar(255) NOT NULL,
  `overview` text DEFAULT NULL,
  `skills` text DEFAULT NULL,
  `awards` text DEFAULT NULL,
  `education` text DEFAULT NULL,
  `experience` text DEFAULT NULL,
  `total_prize` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `website_link` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `link` varchar(255) NOT NULL,
  `link1` varchar(255) NOT NULL,
  `link2` varchar(255) NOT NULL,
  `link3` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_team`
--

INSERT INTO `tbl_team` (`id`, `name`, `post`, `image1`, `thumb1`, `image2`, `thumb2`, `overview`, `skills`, `awards`, `education`, `experience`, `total_prize`, `phone`, `email`, `website_link`, `address`, `link`, `link1`, `link2`, `link3`) VALUES
(22, 'Gajju', 'Associate Professor', '6872860aabd2a_3.jpg', '6872860aadad5thumb_3.jpg', '', '', '<p class=\"ttm-textcolor-darkgrey fs-18\"><em>&ldquo;Lorem Ipsum is simply dummy text of the printing and typesetting industry&rdquo;</em></p>\r\n<p>Porta lorem mollis aliquam ut porttitor leo a diam. Elit pellentesque habitant morbi tristique senectus et netus. Sit amet venenatis urna cursus eget scelerisque.</p>', 'php\r\nhtml\r\ncss \r\njs ', '', '', '', '', '', '', '', 'hatheni bharatpur rajsthan', 'https://www.facebook.com', ' https://www.instagram.com', 'https://x.com/', 'https://www.youtube.com'),
(23, 'Narendra Kushwah', 'CEO & Founder', '687286009e74a_2.jpg', '68728600a008athumb_2.jpg', '', '', '', '', '', '', '', '', '', '', '', '', 'https://www.facebook.com', ' https://www.instagram.com', 'https://twitter.com', 'https://www.youtube.com'),
(24, 'Bhavdeep singh rathore', 'Team Lead ', '687285f698894_1.jpg', '687285f69daa8thumb_1.jpg', '', '', '', '', '', '', '', '', '', '', '', '', 'https://www.facebook.com', ' https://www.instagram.com', 'https://twitter.com', 'https://www.youtube.com');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_temp_order`
--

CREATE TABLE `tbl_temp_order` (
  `id` int(11) NOT NULL,
  `order_id` varchar(16) NOT NULL,
  `group_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `delivery_type` varchar(50) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `size_id` int(11) NOT NULL,
  `size_name` varchar(50) NOT NULL,
  `size_value` varchar(50) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `cart_status` tinyint(1) NOT NULL,
  `delivery_boy_id` int(11) NOT NULL,
  `delivery_boy_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_temp_order`
--

INSERT INTO `tbl_temp_order` (`id`, `order_id`, `group_id`, `order_date`, `customer_id`, `customer_name`, `delivery_type`, `product_id`, `product_name`, `product_price`, `size_id`, `size_name`, `size_value`, `total_amount`, `cart_status`, `delivery_boy_id`, `delivery_boy_name`) VALUES
(33, '2024111321637362', 1, '2024-11-01 00:00:00', 1, 'Anu', 'On Door ', 9, 'Cow Milk', 80.00, 5, '1 and half Ltr', '1.50', 120.00, 0, 0, ''),
(34, '2024111321637362', 1, '2024-11-01 00:00:00', 1, 'Anu', 'On Door ', 12, 'Buffallo Milk', 40.00, 6, '1 Ltr', '1', 40.00, 0, 0, ''),
(35, '2024111321637362', 1, '2024-11-01 00:00:00', 2, 'Akash', 'On Door ', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 0, 0, ''),
(36, '2024111321637362', 1, '2024-11-01 00:00:00', 9, 'Ankit', 'Knock the Door', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 0, 0, ''),
(37, '2024111321637362', 1, '2024-11-01 00:00:00', 9, 'Ankit', 'Knock the Door', 9, 'Cow Milk', 70.00, 5, '1 and half Ltr', '1.50', 105.00, 0, 0, ''),
(38, '2024111321637362', 1, '2024-11-01 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 12, 'Buffallo Milk', 60.00, 6, '1 Ltr', '1', 60.00, 0, 0, ''),
(39, '2024111321637362', 1, '2024-11-01 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 0, 0, ''),
(40, '2024111321637362', 1, '2024-11-01 00:00:00', 11, 'Shilpi', 'Knock the Door', 9, 'Cow Milk', 70.00, 7, '2 Ltr', '2', 140.00, 0, 0, ''),
(41, '2024111321637362', 1, '2024-11-01 00:00:00', 6, 'Krishna', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 0, 0, ''),
(42, '2024111306703370', 1, '2024-11-02 00:00:00', 1, 'Anu', 'On Door ', 9, 'Cow Milk', 80.00, 5, '1 and half Ltr', '1.50', 120.00, 0, 0, ''),
(43, '2024111306703370', 1, '2024-11-02 00:00:00', 1, 'Anu', 'On Door ', 12, 'Buffallo Milk', 40.00, 6, '1 Ltr', '1', 40.00, 0, 0, ''),
(44, '2024111306703370', 1, '2024-11-02 00:00:00', 2, 'Akash', 'On Door ', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 0, 0, ''),
(45, '2024111306703370', 1, '2024-11-02 00:00:00', 9, 'Ankit', 'Knock the Door', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 0, 0, ''),
(46, '2024111306703370', 1, '2024-11-02 00:00:00', 9, 'Ankit', 'Knock the Door', 9, 'Cow Milk', 70.00, 5, '1 and half Ltr', '1.50', 105.00, 0, 0, ''),
(47, '2024111306703370', 1, '2024-11-02 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 12, 'Buffallo Milk', 60.00, 6, '1 Ltr', '1', 60.00, 0, 0, ''),
(48, '2024111306703370', 1, '2024-11-02 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 0, 0, ''),
(49, '2024111306703370', 1, '2024-11-02 00:00:00', 11, 'Shilpi', 'Knock the Door', 9, 'Cow Milk', 70.00, 7, '2 Ltr', '2', 140.00, 0, 0, ''),
(50, '2024111306703370', 1, '2024-11-02 00:00:00', 6, 'Krishna', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 0, 0, ''),
(51, '2024111347360993', 1, '2024-11-03 00:00:00', 1, 'Anu', 'On Door ', 9, 'Cow Milk', 80.00, 5, '1 and half Ltr', '1.50', 120.00, 0, 0, ''),
(52, '2024111347360993', 1, '2024-11-03 00:00:00', 1, 'Anu', 'On Door ', 12, 'Buffallo Milk', 40.00, 6, '1 Ltr', '1', 40.00, 0, 0, ''),
(53, '2024111347360993', 1, '2024-11-03 00:00:00', 2, 'Akash', 'On Door ', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 0, 0, ''),
(54, '2024111347360993', 1, '2024-11-03 00:00:00', 9, 'Ankit', 'Knock the Door', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 0, 0, ''),
(55, '2024111347360993', 1, '2024-11-03 00:00:00', 9, 'Ankit', 'Knock the Door', 9, 'Cow Milk', 70.00, 5, '1 and half Ltr', '1.50', 105.00, 0, 0, ''),
(56, '2024111347360993', 1, '2024-11-03 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 12, 'Buffallo Milk', 60.00, 6, '1 Ltr', '1', 60.00, 0, 0, ''),
(57, '2024111347360993', 1, '2024-11-03 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 0, 0, ''),
(58, '2024111347360993', 1, '2024-11-03 00:00:00', 11, 'Shilpi', 'Knock the Door', 9, 'Cow Milk', 70.00, 7, '2 Ltr', '2', 140.00, 0, 0, ''),
(59, '2024111347360993', 1, '2024-11-03 00:00:00', 6, 'Krishna', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 0, 0, ''),
(60, '2024111335254911', 1, '2024-11-04 00:00:00', 1, 'Anu', 'On Door ', 9, 'Cow Milk', 80.00, 5, '1 and half Ltr', '1.50', 120.00, 0, 0, ''),
(61, '2024111335254911', 1, '2024-11-04 00:00:00', 1, 'Anu', 'On Door ', 12, 'Buffallo Milk', 40.00, 6, '1 Ltr', '1', 40.00, 0, 0, ''),
(62, '2024111335254911', 1, '2024-11-04 00:00:00', 2, 'Akash', 'On Door ', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 0, 0, ''),
(63, '2024111335254911', 1, '2024-11-04 00:00:00', 9, 'Ankit', 'Knock the Door', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 0, 0, ''),
(64, '2024111335254911', 1, '2024-11-04 00:00:00', 9, 'Ankit', 'Knock the Door', 9, 'Cow Milk', 70.00, 5, '1 and half Ltr', '1.50', 105.00, 0, 0, ''),
(65, '2024111335254911', 1, '2024-11-04 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 12, 'Buffallo Milk', 60.00, 6, '1 Ltr', '1', 60.00, 0, 0, ''),
(66, '2024111335254911', 1, '2024-11-04 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 0, 0, ''),
(67, '2024111335254911', 1, '2024-11-04 00:00:00', 11, 'Shilpi', 'Knock the Door', 9, 'Cow Milk', 70.00, 7, '2 Ltr', '2', 140.00, 0, 0, ''),
(68, '2024111335254911', 1, '2024-11-04 00:00:00', 6, 'Krishna', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 0, 0, ''),
(69, '2024111350416522', 1, '2024-11-05 00:00:00', 1, 'Anu', 'On Door ', 9, 'Cow Milk', 80.00, 5, '1 and half Ltr', '1.50', 120.00, 0, 0, ''),
(70, '2024111350416522', 1, '2024-11-05 00:00:00', 1, 'Anu', 'On Door ', 12, 'Buffallo Milk', 40.00, 6, '1 Ltr', '1', 40.00, 0, 0, ''),
(71, '2024111350416522', 1, '2024-11-05 00:00:00', 2, 'Akash', 'On Door ', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 0, 0, ''),
(72, '2024111350416522', 1, '2024-11-05 00:00:00', 9, 'Ankit', 'Knock the Door', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 0, 0, ''),
(73, '2024111350416522', 1, '2024-11-05 00:00:00', 9, 'Ankit', 'Knock the Door', 9, 'Cow Milk', 70.00, 5, '1 and half Ltr', '1.50', 105.00, 0, 0, ''),
(74, '2024111350416522', 1, '2024-11-05 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 12, 'Buffallo Milk', 60.00, 6, '1 Ltr', '1', 60.00, 0, 0, ''),
(75, '2024111350416522', 1, '2024-11-05 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 0, 0, ''),
(76, '2024111350416522', 1, '2024-11-05 00:00:00', 11, 'Shilpi', 'Knock the Door', 9, 'Cow Milk', 70.00, 7, '2 Ltr', '2', 140.00, 0, 0, ''),
(77, '2024111350416522', 1, '2024-11-05 00:00:00', 6, 'Krishna', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 0, 0, ''),
(78, '2024111314195002', 1, '2024-11-06 00:00:00', 1, 'Anu', 'On Door ', 9, 'Cow Milk', 80.00, 5, '1 and half Ltr', '1.50', 120.00, 0, 0, ''),
(79, '2024111314195002', 1, '2024-11-06 00:00:00', 1, 'Anu', 'On Door ', 12, 'Buffallo Milk', 40.00, 6, '1 Ltr', '1', 40.00, 0, 0, ''),
(80, '2024111314195002', 1, '2024-11-06 00:00:00', 2, 'Akash', 'On Door ', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 0, 0, ''),
(81, '2024111314195002', 1, '2024-11-06 00:00:00', 9, 'Ankit', 'Knock the Door', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 0, 0, ''),
(82, '2024111314195002', 1, '2024-11-06 00:00:00', 9, 'Ankit', 'Knock the Door', 9, 'Cow Milk', 70.00, 5, '1 and half Ltr', '1.50', 105.00, 0, 0, ''),
(83, '2024111314195002', 1, '2024-11-06 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 12, 'Buffallo Milk', 60.00, 6, '1 Ltr', '1', 60.00, 0, 0, ''),
(84, '2024111314195002', 1, '2024-11-06 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 0, 0, ''),
(85, '2024111314195002', 1, '2024-11-06 00:00:00', 11, 'Shilpi', 'Knock the Door', 9, 'Cow Milk', 70.00, 7, '2 Ltr', '2', 140.00, 0, 0, ''),
(86, '2024111314195002', 1, '2024-11-06 00:00:00', 6, 'Krishna', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 0, 0, ''),
(87, '2024111359248647', 1, '2024-11-07 00:00:00', 1, 'Anu', 'On Door ', 9, 'Cow Milk', 80.00, 5, '1 and half Ltr', '1.50', 120.00, 0, 0, ''),
(88, '2024111359248647', 1, '2024-11-07 00:00:00', 1, 'Anu', 'On Door ', 12, 'Buffallo Milk', 40.00, 6, '1 Ltr', '1', 40.00, 0, 0, ''),
(89, '2024111359248647', 1, '2024-11-07 00:00:00', 2, 'Akash', 'On Door ', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 0, 0, ''),
(90, '2024111359248647', 1, '2024-11-07 00:00:00', 9, 'Ankit', 'Knock the Door', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 0, 0, ''),
(91, '2024111359248647', 1, '2024-11-07 00:00:00', 9, 'Ankit', 'Knock the Door', 9, 'Cow Milk', 70.00, 5, '1 and half Ltr', '1.50', 105.00, 0, 0, ''),
(92, '2024111359248647', 1, '2024-11-07 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 12, 'Buffallo Milk', 60.00, 6, '1 Ltr', '1', 60.00, 0, 0, ''),
(93, '2024111359248647', 1, '2024-11-07 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 0, 0, ''),
(94, '2024111359248647', 1, '2024-11-07 00:00:00', 11, 'Shilpi', 'Knock the Door', 9, 'Cow Milk', 70.00, 7, '2 Ltr', '2', 140.00, 0, 0, ''),
(95, '2024111359248647', 1, '2024-11-07 00:00:00', 6, 'Krishna', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 0, 0, ''),
(96, '2024111319804719', 1, '2024-11-08 00:00:00', 1, 'Anu', 'On Door ', 9, 'Cow Milk', 80.00, 5, '1 and half Ltr', '1.50', 120.00, 0, 0, ''),
(97, '2024111319804719', 1, '2024-11-08 00:00:00', 1, 'Anu', 'On Door ', 12, 'Buffallo Milk', 40.00, 6, '1 Ltr', '1', 40.00, 0, 0, ''),
(98, '2024111319804719', 1, '2024-11-08 00:00:00', 2, 'Akash', 'On Door ', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 0, 0, ''),
(99, '2024111319804719', 1, '2024-11-08 00:00:00', 9, 'Ankit', 'Knock the Door', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 0, 0, ''),
(100, '2024111319804719', 1, '2024-11-08 00:00:00', 9, 'Ankit', 'Knock the Door', 9, 'Cow Milk', 70.00, 5, '1 and half Ltr', '1.50', 105.00, 0, 0, ''),
(101, '2024111319804719', 1, '2024-11-08 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 12, 'Buffallo Milk', 60.00, 6, '1 Ltr', '1', 60.00, 0, 0, ''),
(102, '2024111319804719', 1, '2024-11-08 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 0, 0, ''),
(103, '2024111319804719', 1, '2024-11-08 00:00:00', 11, 'Shilpi', 'Knock the Door', 9, 'Cow Milk', 70.00, 7, '2 Ltr', '2', 140.00, 0, 0, ''),
(104, '2024111319804719', 1, '2024-11-08 00:00:00', 6, 'Krishna', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 0, 0, ''),
(105, '2024111329687214', 1, '2024-11-09 00:00:00', 1, 'Anu', 'On Door ', 12, 'Buffallo Milk', 40.00, 6, '1 Ltr', '1', 40.00, 0, 0, ''),
(106, '2024111329687214', 1, '2024-11-09 00:00:00', 2, 'Akash', 'On Door ', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 0, 0, ''),
(107, '2024111329687214', 1, '2024-11-09 00:00:00', 9, 'Ankit', 'Knock the Door', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 0, 0, ''),
(108, '2024111329687214', 1, '2024-11-09 00:00:00', 9, 'Ankit', 'Knock the Door', 9, 'Cow Milk', 70.00, 5, '1 and half Ltr', '1.50', 105.00, 0, 0, ''),
(109, '2024111329687214', 1, '2024-11-09 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 12, 'Buffallo Milk', 60.00, 6, '1 Ltr', '1', 60.00, 0, 0, ''),
(110, '2024111329687214', 1, '2024-11-09 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 0, 0, ''),
(111, '2024111329687214', 1, '2024-11-09 00:00:00', 11, 'Shilpi', 'Knock the Door', 9, 'Cow Milk', 70.00, 7, '2 Ltr', '2', 140.00, 0, 0, ''),
(112, '2024111329687214', 1, '2024-11-09 00:00:00', 6, 'Krishna', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 0, 0, ''),
(113, '2024111301844258', 1, '2024-11-10 00:00:00', 1, 'Anu', 'On Door ', 12, 'Buffallo Milk', 40.00, 6, '1 Ltr', '1', 40.00, 0, 0, ''),
(114, '2024111301844258', 1, '2024-11-10 00:00:00', 2, 'Akash', 'On Door ', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 0, 0, ''),
(115, '2024111301844258', 1, '2024-11-10 00:00:00', 9, 'Ankit', 'Knock the Door', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 0, 0, ''),
(116, '2024111301844258', 1, '2024-11-10 00:00:00', 9, 'Ankit', 'Knock the Door', 9, 'Cow Milk', 70.00, 5, '1 and half Ltr', '1.50', 105.00, 0, 0, ''),
(117, '2024111301844258', 1, '2024-11-10 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 12, 'Buffallo Milk', 60.00, 6, '1 Ltr', '1', 60.00, 0, 0, ''),
(118, '2024111301844258', 1, '2024-11-10 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 0, 0, ''),
(119, '2024111301844258', 1, '2024-11-10 00:00:00', 11, 'Shilpi', 'Knock the Door', 9, 'Cow Milk', 70.00, 7, '2 Ltr', '2', 140.00, 0, 0, ''),
(120, '2024111301844258', 1, '2024-11-10 00:00:00', 6, 'Krishna', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 0, 0, ''),
(121, '2024111340965605', 1, '2024-11-11 00:00:00', 1, 'Anu', 'On Door ', 12, 'Buffallo Milk', 40.00, 6, '1 Ltr', '1', 40.00, 0, 0, ''),
(122, '2024111340965605', 1, '2024-11-11 00:00:00', 2, 'Akash', 'On Door ', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 0, 0, ''),
(123, '2024111340965605', 1, '2024-11-11 00:00:00', 9, 'Ankit', 'Knock the Door', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 0, 0, ''),
(124, '2024111340965605', 1, '2024-11-11 00:00:00', 9, 'Ankit', 'Knock the Door', 9, 'Cow Milk', 70.00, 5, '1 and half Ltr', '1.50', 105.00, 0, 0, ''),
(125, '2024111340965605', 1, '2024-11-11 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 12, 'Buffallo Milk', 60.00, 6, '1 Ltr', '1', 60.00, 0, 0, ''),
(126, '2024111340965605', 1, '2024-11-11 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 0, 0, ''),
(127, '2024111340965605', 1, '2024-11-11 00:00:00', 11, 'Shilpi', 'Knock the Door', 9, 'Cow Milk', 70.00, 7, '2 Ltr', '2', 140.00, 0, 0, ''),
(128, '2024111340965605', 1, '2024-11-11 00:00:00', 6, 'Krishna', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 0, 0, ''),
(129, '2024111354243276', 1, '2024-11-12 00:00:00', 1, 'Anu', 'On Door ', 12, 'Buffallo Milk', 40.00, 6, '1 Ltr', '1', 40.00, 0, 0, ''),
(130, '2024111354243276', 1, '2024-11-12 00:00:00', 2, 'Akash', 'On Door ', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 0, 0, ''),
(131, '2024111354243276', 1, '2024-11-12 00:00:00', 9, 'Ankit', 'Knock the Door', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 0, 0, ''),
(132, '2024111354243276', 1, '2024-11-12 00:00:00', 9, 'Ankit', 'Knock the Door', 9, 'Cow Milk', 70.00, 5, '1 and half Ltr', '1.50', 105.00, 0, 0, ''),
(133, '2024111354243276', 1, '2024-11-12 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 12, 'Buffallo Milk', 60.00, 6, '1 Ltr', '1', 60.00, 0, 0, ''),
(134, '2024111354243276', 1, '2024-11-12 00:00:00', 10, 'Shnatanu ', 'Only Ring the bell', 11, 'Paneer', 120.00, 9, '500 g', '.5', 60.00, 0, 0, ''),
(135, '2024111354243276', 1, '2024-11-12 00:00:00', 11, 'Shilpi', 'Knock the Door', 9, 'Cow Milk', 70.00, 7, '2 Ltr', '2', 140.00, 0, 0, ''),
(136, '2024111354243276', 1, '2024-11-12 00:00:00', 6, 'Krishna', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 0, 0, ''),
(137, '2024111315741277', 5, '2024-11-01 00:00:00', 3, 'Divya ', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 0, 0, ''),
(138, '2024111315741277', 5, '2024-11-01 00:00:00', 4, 'Sumit', 'On Door ', 9, 'Cow Milk', 70.00, 6, '1 Ltr', '1', 70.00, 0, 0, ''),
(139, '2024111315741277', 5, '2024-11-01 00:00:00', 4, 'Sumit', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 0, 0, ''),
(140, '2024111315741277', 5, '2024-11-01 00:00:00', 5, 'Kunal', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 0, 0, ''),
(141, '2024111348504183', 5, '2024-11-02 00:00:00', 3, 'Divya ', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 0, 0, ''),
(142, '2024111348504183', 5, '2024-11-02 00:00:00', 4, 'Sumit', 'On Door ', 9, 'Cow Milk', 70.00, 6, '1 Ltr', '1', 70.00, 0, 0, ''),
(143, '2024111348504183', 5, '2024-11-02 00:00:00', 4, 'Sumit', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 0, 0, ''),
(144, '2024111348504183', 5, '2024-11-02 00:00:00', 5, 'Kunal', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 0, 0, ''),
(145, '2024111314167612', 5, '2024-11-03 00:00:00', 3, 'Divya ', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 0, 0, ''),
(146, '2024111314167612', 5, '2024-11-03 00:00:00', 4, 'Sumit', 'On Door ', 9, 'Cow Milk', 70.00, 6, '1 Ltr', '1', 70.00, 0, 0, ''),
(147, '2024111314167612', 5, '2024-11-03 00:00:00', 4, 'Sumit', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 0, 0, ''),
(148, '2024111314167612', 5, '2024-11-03 00:00:00', 5, 'Kunal', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 0, 0, ''),
(149, '2024111325852356', 5, '2024-11-04 00:00:00', 3, 'Divya ', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 0, 0, ''),
(150, '2024111325852356', 5, '2024-11-04 00:00:00', 4, 'Sumit', 'On Door ', 9, 'Cow Milk', 70.00, 6, '1 Ltr', '1', 70.00, 0, 0, ''),
(151, '2024111325852356', 5, '2024-11-04 00:00:00', 4, 'Sumit', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 0, 0, ''),
(152, '2024111325852356', 5, '2024-11-04 00:00:00', 5, 'Kunal', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 0, 0, ''),
(153, '2024111341236922', 5, '2024-11-05 00:00:00', 3, 'Divya ', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 0, 0, ''),
(154, '2024111341236922', 5, '2024-11-05 00:00:00', 4, 'Sumit', 'On Door ', 9, 'Cow Milk', 70.00, 6, '1 Ltr', '1', 70.00, 0, 0, ''),
(155, '2024111341236922', 5, '2024-11-05 00:00:00', 4, 'Sumit', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 0, 0, ''),
(156, '2024111341236922', 5, '2024-11-05 00:00:00', 5, 'Kunal', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 0, 0, ''),
(157, '2024111350935326', 5, '2024-11-06 00:00:00', 3, 'Divya ', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 0, 0, ''),
(158, '2024111350935326', 5, '2024-11-06 00:00:00', 4, 'Sumit', 'On Door ', 9, 'Cow Milk', 70.00, 6, '1 Ltr', '1', 70.00, 0, 0, ''),
(159, '2024111350935326', 5, '2024-11-06 00:00:00', 4, 'Sumit', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 0, 0, ''),
(160, '2024111350935326', 5, '2024-11-06 00:00:00', 5, 'Kunal', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 0, 0, ''),
(161, '2024111327180720', 5, '2024-11-07 00:00:00', 3, 'Divya ', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 0, 0, ''),
(162, '2024111327180720', 5, '2024-11-07 00:00:00', 4, 'Sumit', 'On Door ', 9, 'Cow Milk', 70.00, 6, '1 Ltr', '1', 70.00, 0, 0, ''),
(163, '2024111327180720', 5, '2024-11-07 00:00:00', 4, 'Sumit', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 0, 0, ''),
(164, '2024111327180720', 5, '2024-11-07 00:00:00', 5, 'Kunal', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 0, 0, ''),
(165, '2024111342330026', 5, '2024-11-08 00:00:00', 3, 'Divya ', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 0, 0, ''),
(166, '2024111342330026', 5, '2024-11-08 00:00:00', 4, 'Sumit', 'On Door ', 9, 'Cow Milk', 70.00, 6, '1 Ltr', '1', 70.00, 0, 0, ''),
(167, '2024111342330026', 5, '2024-11-08 00:00:00', 4, 'Sumit', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 0, 0, ''),
(168, '2024111342330026', 5, '2024-11-08 00:00:00', 5, 'Kunal', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 0, 0, ''),
(169, '2024111349490271', 5, '2024-11-09 00:00:00', 3, 'Divya ', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 0, 0, ''),
(170, '2024111349490271', 5, '2024-11-09 00:00:00', 4, 'Sumit', 'On Door ', 9, 'Cow Milk', 70.00, 6, '1 Ltr', '1', 70.00, 0, 0, ''),
(171, '2024111349490271', 5, '2024-11-09 00:00:00', 4, 'Sumit', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 0, 0, ''),
(172, '2024111349490271', 5, '2024-11-09 00:00:00', 5, 'Kunal', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 0, 0, ''),
(173, '2024111311748667', 5, '2024-11-10 00:00:00', 3, 'Divya ', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 0, 0, ''),
(174, '2024111311748667', 5, '2024-11-10 00:00:00', 4, 'Sumit', 'On Door ', 9, 'Cow Milk', 70.00, 6, '1 Ltr', '1', 70.00, 0, 0, ''),
(175, '2024111311748667', 5, '2024-11-10 00:00:00', 4, 'Sumit', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 0, 0, ''),
(176, '2024111311748667', 5, '2024-11-10 00:00:00', 5, 'Kunal', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 0, 0, ''),
(177, '2024111334812717', 5, '2024-11-11 00:00:00', 3, 'Divya ', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 0, 0, ''),
(178, '2024111334812717', 5, '2024-11-11 00:00:00', 4, 'Sumit', 'On Door ', 9, 'Cow Milk', 70.00, 6, '1 Ltr', '1', 70.00, 0, 0, ''),
(179, '2024111334812717', 5, '2024-11-11 00:00:00', 4, 'Sumit', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 0, 0, ''),
(180, '2024111334812717', 5, '2024-11-11 00:00:00', 5, 'Kunal', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 0, 0, ''),
(181, '2024111359396603', 5, '2024-11-12 00:00:00', 3, 'Divya ', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 0, 0, ''),
(182, '2024111359396603', 5, '2024-11-12 00:00:00', 4, 'Sumit', 'On Door ', 9, 'Cow Milk', 70.00, 6, '1 Ltr', '1', 70.00, 0, 0, ''),
(183, '2024111359396603', 5, '2024-11-12 00:00:00', 4, 'Sumit', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 0, 0, ''),
(184, '2024111359396603', 5, '2024-11-12 00:00:00', 5, 'Kunal', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 0, 0, ''),
(185, '2024111333931404', 6, '2024-11-01 00:00:00', 7, 'Paras ', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 0, 1, 'Anu'),
(186, '2024111333931404', 6, '2024-11-01 00:00:00', 8, 'Hemant', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 0, 1, 'Anu'),
(187, '2024111317592028', 6, '2024-11-13 00:00:00', 7, 'Paras ', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 0, 1, 'Anu'),
(188, '2024111317592028', 6, '2024-11-13 00:00:00', 8, 'Hemant', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 0, 1, 'Anu'),
(189, '2024111349230799', 5, '2024-11-13 00:00:00', 4, 'Sumit', 'On Door ', 10, 'Curd', 50.00, 9, '500 g', '.5', 25.00, 0, 1, 'Anu'),
(190, '2024111349230799', 5, '2024-11-13 00:00:00', 5, 'Kunal', 'On Door ', 0, '', 0.00, 0, '', '', 0.00, 0, 1, 'Anu');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_testimonial`
--

CREATE TABLE `tbl_testimonial` (
  `id` int(10) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `heading` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image1` varchar(255) DEFAULT NULL,
  `thumb1` varchar(255) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_testimonial`
--

INSERT INTO `tbl_testimonial` (`id`, `name`, `heading`, `description`, `image1`, `thumb1`, `user_id`) VALUES
(11, 'suraj', 'Experience Luxury & Comfort at Hotel Prem In', '<p>Experience Luxury &amp; Comfort at Hotel Prem InExperience Luxury &amp; Comfort at Hotel Prem InExperience Luxury &amp; Comfort at Hotel Prem InExperience Luxury &amp; Comfort at Hotel Prem In</p>', '6871332632274_1.jpg', '687133263419bthumb_1.jpg', NULL),
(12, 'Narendra Kushwah', 'There are many variations passage have suffered available.', '<div>\r\n<p>Capitalize on low hanging fruit to identify a ballpark value added activity to beta test. Override the digital divide with additional clickthroughs from DevOps. Nanotechnology immersion along the information highway.</p>\r\n</div>', '687133359e427_2.jpg', '68713335a2e92thumb_2.jpg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_wishlist`
--

CREATE TABLE `tbl_wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `added_at` datetime DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'suraj', 'admin@gmail.com', '$2y$10$2r9qf5dt2Y2eSphQspWyvetjPbrNkExy7MvadDSCEPkVQyJugqyGy'),
(2, 'sanju', 'sanju@gmail.com', '$2y$10$wRXFk2vbVDcj1NaUXSyRK.74kwuZyQlzzjcLvAfx3id.mPWfNj9nq'),
(3, 'suraj singh', 'surajfoujdar90@gmail.com', '$2y$10$V3nxoyOztmkkH8Uwkcwnguv/H/1H.LIUcNtcy.Xx7EBC.oEVVfky.'),
(4, 'Seo', 'Surajfoujdar45@gmail.com', '$2y$10$Fj/3rBgvhZHMBcfEjUNdH.JIUvwvwBazeh.q.geBNXON8HUKng4cG'),
(7, 'Suraj singh', 'Surajfoujdar39@gmail.com', '$2y$10$zrNZNuNX8TAhUpaGuvCV0e1S/T22oJbvnp6PTKpSlkSnQ8PnW7s5O'),
(11, 'ashok', 'ashok@gmail.com', '$2y$10$9GTmwTwzZ.SgwzefxBDFbuHPrT3W0pVY8zU3bj1KN5PcrqiwkHwUG');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin_menu`
--
ALTER TABLE `tbl_admin_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_award`
--
ALTER TABLE `tbl_award`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_banner`
--
ALTER TABLE `tbl_banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_blog`
--
ALTER TABLE `tbl_blog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_booking`
--
ALTER TABLE `tbl_booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_city`
--
ALTER TABLE `tbl_city`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_color`
--
ALTER TABLE `tbl_color`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_course`
--
ALTER TABLE `tbl_course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_course_category`
--
ALTER TABLE `tbl_course_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD KEY `location_id` (`location_id`),
  ADD KEY `city_id` (`city_id`),
  ADD KEY `state_id` (`state_id`),
  ADD KEY `delivery_type_id` (`delivery_type_id`);

--
-- Indexes for table `tbl_customer_group`
--
ALTER TABLE `tbl_customer_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_customer_product`
--
ALTER TABLE `tbl_customer_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_delivery_boy`
--
ALTER TABLE `tbl_delivery_boy`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tbl_delivery_type`
--
ALTER TABLE `tbl_delivery_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_enquiry`
--
ALTER TABLE `tbl_enquiry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_gallery`
--
ALTER TABLE `tbl_gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_group`
--
ALTER TABLE `tbl_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_location`
--
ALTER TABLE `tbl_location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_menu_category`
--
ALTER TABLE `tbl_menu_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_off_days`
--
ALTER TABLE `tbl_off_days`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_partner`
--
ALTER TABLE `tbl_partner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_portfolio`
--
ALTER TABLE `tbl_portfolio`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_portfolio_image`
--
ALTER TABLE `tbl_portfolio_image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_product_category`
--
ALTER TABLE `tbl_product_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_room_booking`
--
ALTER TABLE `tbl_room_booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_services`
--
ALTER TABLE `tbl_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_setting`
--
ALTER TABLE `tbl_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_size`
--
ALTER TABLE `tbl_size`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_state`
--
ALTER TABLE `tbl_state`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_team`
--
ALTER TABLE `tbl_team`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_temp_order`
--
ALTER TABLE `tbl_temp_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_testimonial`
--
ALTER TABLE `tbl_testimonial`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_wishlist`
--
ALTER TABLE `tbl_wishlist`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_wishlist` (`user_id`,`product_id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_admin_menu`
--
ALTER TABLE `tbl_admin_menu`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `tbl_award`
--
ALTER TABLE `tbl_award`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_banner`
--
ALTER TABLE `tbl_banner`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_blog`
--
ALTER TABLE `tbl_blog`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tbl_booking`
--
ALTER TABLE `tbl_booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `tbl_city`
--
ALTER TABLE `tbl_city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_color`
--
ALTER TABLE `tbl_color`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_course`
--
ALTER TABLE `tbl_course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_course_category`
--
ALTER TABLE `tbl_course_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_customer_group`
--
ALTER TABLE `tbl_customer_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_customer_product`
--
ALTER TABLE `tbl_customer_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_delivery_boy`
--
ALTER TABLE `tbl_delivery_boy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_delivery_type`
--
ALTER TABLE `tbl_delivery_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_enquiry`
--
ALTER TABLE `tbl_enquiry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tbl_gallery`
--
ALTER TABLE `tbl_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_group`
--
ALTER TABLE `tbl_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_location`
--
ALTER TABLE `tbl_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_menu_category`
--
ALTER TABLE `tbl_menu_category`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `tbl_off_days`
--
ALTER TABLE `tbl_off_days`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=250;

--
-- AUTO_INCREMENT for table `tbl_partner`
--
ALTER TABLE `tbl_partner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `tbl_portfolio`
--
ALTER TABLE `tbl_portfolio`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_portfolio_image`
--
ALTER TABLE `tbl_portfolio_image`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tbl_product_category`
--
ALTER TABLE `tbl_product_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_room_booking`
--
ALTER TABLE `tbl_room_booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tbl_services`
--
ALTER TABLE `tbl_services`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `tbl_setting`
--
ALTER TABLE `tbl_setting`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_size`
--
ALTER TABLE `tbl_size`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_state`
--
ALTER TABLE `tbl_state`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `tbl_team`
--
ALTER TABLE `tbl_team`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tbl_temp_order`
--
ALTER TABLE `tbl_temp_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;

--
-- AUTO_INCREMENT for table `tbl_testimonial`
--
ALTER TABLE `tbl_testimonial`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_wishlist`
--
ALTER TABLE `tbl_wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD CONSTRAINT `tbl_customer_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `tbl_location` (`id`),
  ADD CONSTRAINT `tbl_customer_ibfk_2` FOREIGN KEY (`city_id`) REFERENCES `tbl_city` (`id`),
  ADD CONSTRAINT `tbl_customer_ibfk_3` FOREIGN KEY (`state_id`) REFERENCES `tbl_state` (`id`),
  ADD CONSTRAINT `tbl_customer_ibfk_4` FOREIGN KEY (`delivery_type_id`) REFERENCES `tbl_delivery_type` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
