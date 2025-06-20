-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2025 at 06:18 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mr_pizza`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `orderID` int(11) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `total` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `shipping_address` text NOT NULL,
  `phone_num` varchar(15) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `fname`, `email`, `shipping_address`, `phone_num`, `order_date`) VALUES
(13, 'Nishmi Erandi', 'nishmierandi56@gmail.com', '96/E,weerajapanapadaya,uragasmanhandiya', '0764067432', '2025-06-11 04:00:02'),


-- --------------------------------------------------------

--
-- Table structure for table `delivery_driver`
--

CREATE TABLE `delivery_driver` (
  `driver_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menuitems`
--

CREATE TABLE `menuitems` (
  `itemID` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `category` varchar(10) DEFAULT NULL,
  `image` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menuitems`
--

INSERT INTO `menuitems` (`itemID`, `name`, `description`, `price`, `category`, `image`) VALUES
(3, 'Cheesy Chicken Pizza', 'Loaded with tender chicken, rich tomato sauce, and a generous layer of melted mozzarella and cheddar cheese on a crispy crust', 1800.00, 'pizza', 0x63686565737920636869636b656e2e6a7067),
(4, 'Cheesy Sausage Pizza', 'Topped with juicy sausage, rich tomato base, and melted cheese for a perfect cheesy bite', 1500.00, 'pizza', 0x6368656573792d736173756765732e6a7067),
(5, 'Vegi Pizza', 'A garden-fresh mix of colorful vegetables on a tangy tomato base with melted cheese', 1500.00, 'pizza', 0x766567692e6a7067),
(7, 'Cheesy Chicken Sausage Pizza', 'A mouthwatering combo of chicken and sausage topped with rich cheese and tomato sauce', 2000.00, 'pizza', 0x636869636b656e2d736175736167652e6a7067),
(8, 'Spicy Kochchi Chicken Pizza', 'Spicy Sri Lankan Kochchi chili meets juicy chicken and cheese for a fiery pizza experience.', 2000.00, 'pizza', 0x6b6f63686368692e6a7067),
(9, 'Double Cheesy Chicken Blast Pizza', 'Extra cheese and chunks of chicken make this a dream pizza for true cheese lovers.', 2700.00, 'pizza', 0x646f75626c652e6a7067),
(10, 'Cheesy Chicken Ham Pizza', 'A hearty mix of chicken and ham, topped with creamy cheese on a golden-baked crust', 1600.00, 'pizza', 0x68616d2e6a7067),
(11, 'Mr. Pizza Special', 'A signature pizza packed with premium toppings and house-special flavors in every bite.', 2000.00, 'pizza', 0x7370656369616c2e6a7067),
(12, 'Crispy Chicken Burger', 'Golden-fried chicken breast with fresh lettuce, creamy mayo, and a soft bun', 1500.00, 'burger', 0x64656c6963696f75735f6372697370795f636869636b656e5f6275726765722e706e67),
(13, 'veggie burger', 'A wholesome veggie patty stacked with fresh greens, tomatoes, and zesty sauce.', 1200.00, 'burger', 0x7665676769655f62757267652e706e67),
(14, ' cheeseburger', 'Juicy grilled beef topped with melted cheese, onions, pickles, and ketchup.', 1400.00, 'burger', 0x63686565736562757267652e706e67),
(15, ' Classic Beef Burger', 'Traditional beef patty with crisp lettuce, tomato, and house-made burger sauce.', 1800.00, 'burger', 0x636c61737369635f626565665f6275726765725f6f6e5f615f776f6f64656e5f2e706e67),
(16, 'Lasagna', 'Classic layers of pasta, meat, rich tomato sauce, and melted cheese baked to perfection.', 1600.00, 'other', 0x6c6173676e61205f6d656e752e706e67),
(17, 'Pot Biriyani', 'Classic layers of pasta, meat, rich tomato sauce, and melted cheese baked to perfection.', 1800.00, 'other', 0x706f745f6269726961796e692e706e67);

-- --------------------------------------------------------

--
-- Table structure for table `orderss`
--

CREATE TABLE `orderss` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `customer_phone` varchar(15) NOT NULL,
  `customer_address` text NOT NULL,
  `product_title` varchar(255) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `item_total` decimal(10,2) NOT NULL,
  `delivery_fee` decimal(10,2) NOT NULL DEFAULT 300.00,
  `grand_total` decimal(10,2) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_status` varchar(50) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderss`
--

INSERT INTO `orderss` (`order_id`, `customer_id`, `customer_name`, `customer_email`, `customer_phone`, `customer_address`, `product_title`, `product_image`, `product_price`, `quantity`, `item_total`, `delivery_fee`, `grand_total`, `order_date`, `order_status`) VALUES
(15, 13, 'Nishmi Erandi', 'nishmierandi56@gmail.com', '0764067432', '96/E,weerajapanapadaya,uragasmanhandiya', 'Vegi Pizza', 'vegi.jpg', 1500.00, 2, 3000.00, 300.00, 3300.00, '2025-06-11 04:00:02', 'delivered'),

(22, 16, 'thilini', 'thilini@gmail.com', '0787381786', '96/E,weerajapanapadaya,uragasmanhandiya', 'Cheesy Sausage Pizza', 'cheesy-sasuges.jpg', 1500.00, 1, 1500.00, 300.00, 1800.00, '2025-06-13 08:06:30', 'delivered'),

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `address`, `phone_number`, `email`, `password`) VALUES
(3, 'Nishmi', 'Erandi', '96/E,weerajapanapadaya,uragasmanhandiya', '0764067432', 'erandinishmi66@gmail.com', '$2y$10$b490GhqOeHxYE.5H8dVFLOXZ4ZYPVTisxRMnVr6VSZviH50VfLxk6'),


--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`orderID`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD KEY `idx_email` (`email`);

--
-- Indexes for table `delivery_driver`
--
ALTER TABLE `delivery_driver`
  ADD PRIMARY KEY (`driver_id`);

--
-- Indexes for table `menuitems`
--
ALTER TABLE `menuitems`
  ADD PRIMARY KEY (`itemID`);

--
-- Indexes for table `orderss`
--
ALTER TABLE `orderss`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `idx_customer_id` (`customer_id`),
  ADD KEY `idx_order_status` (`order_status`),
  ADD KEY `idx_order_date` (`order_date`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `delivery_driver`
--
ALTER TABLE `delivery_driver`
  MODIFY `driver_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menuitems`
--
ALTER TABLE `menuitems`
  MODIFY `itemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `orderss`
--
ALTER TABLE `orderss`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orderss`
--
ALTER TABLE `orderss`
  ADD CONSTRAINT `orderss_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
