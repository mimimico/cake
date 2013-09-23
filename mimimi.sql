-- phpMyAdmin SQL Dump
-- version 4.0.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 23, 2013 at 08:16 PM
-- Server version: 5.5.29
-- PHP Version: 5.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mimimi`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `uid` int(255) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `registered` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastonline` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fbid` bigint(255) NOT NULL DEFAULT '0',
  `vkid` bigint(255) NOT NULL DEFAULT '0',
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `avatar` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postindex` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=33 ;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`uid`, `email`, `password`, `activated`, `registered`, `lastonline`, `fbid`, `vkid`, `firstname`, `lastname`, `type`, `avatar`, `phone`, `country`, `city`, `address`, `postindex`) VALUES
(18, 'Vladgritsenko@gmail.com', '4adb2e567e097fdcd0b88e15a435004a', 1, '2013-08-20 12:49:06', '2013-08-20 13:49:06', 100000470641337, 0, 'Vladislav', 'Gritsenko', 1, 'https://graph.facebook.com/inlife360/picture?width=100&height=100', '+380966322253', 'Украина', 'Киев', 'пр-кт. Оболонский, 16', '04205'),
(28, 'antuan@i.aaa', '5d0c3643afbd328bf13485c22f3980ef', 1, '2013-08-29 20:16:42', '2013-08-29 21:16:42', 0, 0, '', '', 0, '0', '0', '', '', '', '0'),
(32, '', '', 1, '2013-09-03 12:28:39', '2013-09-03 13:28:39', 0, 8075635, 'Владислав', 'Гриценко', 0, 'http://cs303308.vk.me/u8075635/d_809e807e.jpg', '0', '', '', '', '0');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `uid` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent` int(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=166 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`uid`, `name`, `parent`) VALUES
(10, 'category_art', 0),
(20, 'category_homeliving', 0),
(22, 'sub_2', 10),
(23, 'sub_3', 10),
(24, 'sub_4', 10),
(25, 'sub_5', 10),
(26, 'sub_6', 10),
(27, 'sub_7', 10),
(28, 'sub_8', 10),
(29, 'sub_9', 10),
(30, 'category_women', 0),
(31, 'sub_10', 10),
(32, 'sub_12', 10),
(33, 'sub_13', 10),
(34, 'sub_14', 20),
(35, 'sub_15', 20),
(36, 'sub_16', 20),
(37, 'sub_17', 20),
(38, 'sub_18', 20),
(39, 'sub_19', 20),
(40, 'category_men', 0),
(41, 'sub_20', 20),
(42, 'sub_22', 20),
(43, 'sub_23', 20),
(44, 'sub_24', 20),
(45, 'sub_25', 20),
(46, 'sub_26', 20),
(47, 'sub_27', 30),
(48, 'sub_28', 30),
(49, 'sub_29', 30),
(50, 'category_kids', 0),
(51, 'sub_30', 30),
(52, 'sub_32', 30),
(53, 'sub_33', 30),
(54, 'sub_34', 30),
(55, 'sub_35', 30),
(56, 'sub_36', 30),
(57, 'sub_37', 30),
(58, 'sub_38', 30),
(59, 'sub_39', 40),
(60, 'category_jewerly', 0),
(61, 'sub_40', 40),
(62, 'sub_42', 40),
(63, 'sub_43', 40),
(64, 'sub_44', 40),
(65, 'sub_45', 40),
(66, 'sub_46', 40),
(67, 'sub_47', 40),
(68, 'sub_48', 40),
(69, 'sub_49', 40),
(70, 'category_vintage', 0),
(71, 'sub_50', 40),
(72, 'sub_52', 40),
(73, 'sub_53', 40),
(74, 'sub_54', 40),
(75, 'sub_55', 40),
(76, 'sub_56', 50),
(77, 'sub_57', 50),
(78, 'sub_58', 50),
(79, 'sub_59', 50),
(80, 'category_giftideas', 0),
(81, 'sub_60', 50),
(82, 'sub_62', 50),
(83, 'sub_63', 50),
(84, 'sub_64', 50),
(85, 'sub_65', 50),
(86, 'sub_66', 50),
(87, 'sub_67', 50),
(88, 'sub_68', 60),
(89, 'sub_69', 60),
(90, 'sub_70', 60),
(91, 'sub_71', 60),
(92, 'sub_72', 60),
(93, 'sub_73', 60),
(94, 'sub_74', 60),
(95, 'sub_75', 60),
(96, 'sub_76', 60),
(97, 'sub_77', 60),
(98, 'sub_78', 60),
(99, 'sub_79', 60),
(100, 'sub_80', 60),
(101, 'sub_81', 70),
(102, 'sub_82', 70),
(103, 'sub_83', 70),
(104, 'sub_84', 70),
(105, 'sub_85', 70),
(106, 'sub_86', 70),
(107, 'sub_87', 70),
(108, 'sub_88', 70),
(109, 'sub_89', 70),
(110, 'sub_90', 70),
(111, 'sub_91', 70),
(112, 'sub_92', 70),
(113, 'sub_93', 70),
(114, 'sub_94', 70),
(115, 'sub_95', 70),
(116, 'sub_96', 70),
(149, 'sub_97', 80),
(150, 'sub_98', 80),
(151, 'sub_99', 80),
(152, 'sub_100', 80),
(153, 'sub_101', 80),
(154, 'sub_102', 80),
(155, 'sub_103', 80),
(156, 'sub_104', 80),
(157, 'sub_105', 80),
(158, 'sub_106', 80),
(159, 'sub_107', 80),
(160, 'sub_108', 80),
(161, 'sub_109', 80),
(162, 'sub_110', 80),
(163, 'sub_111', 80),
(164, 'sub_112', 80),
(165, 'sub_113', 80);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `uid` int(255) NOT NULL AUTO_INCREMENT,
  `userid` int(255) NOT NULL,
  `itemid` int(255) NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`uid`, `userid`, `itemid`, `text`, `date`) VALUES
(1, 28, 16, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut eu dolor et nulla imperdiet dapibus. Sed eget varius elit. In blandit lacus eu vehicula posuere. Ut mollis, quam sit amet ullamcorper porta, nisl neque cursus elit, eu auctor ante est ut turpis. Cras ullamcorper ornare eleifend. Phasellus id arcu tellus. Integer cursus ut erat vitae posuere. Nunc pulvinar quam leo, iaculis consequat ipsum ullamcorper quis. Pellentesque at tortor nulla. Integer hendrerit tortor ut felis aliquam, eu luctus ipsum sodales. Aliquam eleifend lacinia vulputate. Cras malesuada ipsum ac mauris ullamcorper, et gravida libero semper. In nulla justo, imperdiet sit amet dui eget, imperdiet facilisis leo. Proin dictum neque volutpat enim dignissim commodo.', '2013-07-27 10:28:21'),
(2, 28, 16, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut eu dolor et nulla imperdiet dapibus. Sed eget varius elit. In blandit lacus eu vehicula posuere. Ut mollis, quam sit amet ullamcorper porta, nisl neque cursus elit, eu auctor ante est ut turpis. Cras ullamcorper ornare eleifend. Phasellus id arcu tellus. Integer cursus ut erat vitae posuere. Nunc pulvinar quam leo, iaculis consequat ipsum ullamcorper quis. Pellentesque at tortor nulla. Integer hendrerit tortor ut felis aliquam, eu luctus ipsum sodales. Aliquam eleifend lacinia vulputate. Cras malesuada ipsum ac mauris ullamcorper, et gravida libero semper. In nulla justo, imperdiet sit amet dui eget, imperdiet facilisis leo. Proin dictum neque volutpat enim dignissim commodo.', '2013-07-27 10:28:21'),
(3, 18, 16, 'asdadasdasdsad', '2013-08-29 07:29:07'),
(4, 28, 21, 'asdasdasd', '2013-08-30 10:36:44'),
(5, 18, 21, 'lalka', '2013-08-30 14:32:28'),
(6, 18, 21, 'lalka2', '2013-08-30 14:32:33');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `uid` int(255) NOT NULL AUTO_INCREMENT,
  `userid` int(255) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category` int(3) NOT NULL,
  `price` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `size` int(1) NOT NULL DEFAULT '1',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `views` int(255) NOT NULL DEFAULT '0',
  `subimage_0` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subimage_1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subimage_2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=24 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`uid`, `userid`, `title`, `image`, `category`, `price`, `size`, `date`, `description`, `views`, `subimage_0`, `subimage_1`, `subimage_2`) VALUES
(1, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image8.jpg', 28, '20', 1, '0000-00-00 00:00:00', '', 0, '', '', ''),
(2, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image2.jpg', 28, '20', 1, '0000-00-00 00:00:00', '', 0, '', '', ''),
(3, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image10.jpg', 28, '20', 1, '0000-00-00 00:00:00', '', 2, '', '', ''),
(4, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image4.jpg', 28, '20', 2, '0000-00-00 00:00:00', '', 0, '', '', ''),
(5, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image2.jpg', 28, '20', 1, '0000-00-00 00:00:00', '', 1, '', '', ''),
(6, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image6.jpg', 28, '20', 1, '0000-00-00 00:00:00', '', 1, '', '', ''),
(7, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image3.jpg', 28, '20', 1, '0000-00-00 00:00:00', '', 2, '', '', ''),
(8, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image11.jpg', 28, '20', 1, '0000-00-00 00:00:00', '', 2, '', '', ''),
(9, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image9.jpg', 28, '20', 1, '0000-00-00 00:00:00', '', 1, '', '', ''),
(10, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image1.jpg', 28, '20', 2, '0000-00-00 00:00:00', '', 2, '', '', ''),
(11, 0, 'BLablabla', 'images/temp/image7.jpg', 56, '30', 1, '0000-00-00 00:00:00', '', 2, '', '', ''),
(12, 0, 'Teestestest', 'images/temp/image5.jpg', 56, '30', 1, '0000-00-00 00:00:00', '', 2, '', '', ''),
(13, 0, 'BLablabla', 'images/temp/image3.jpg', 28, '100', 1, '0000-00-00 00:00:00', '', 1, '', '', ''),
(14, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image8.jpg', 28, '20', 1, '0000-00-00 00:00:00', '', 3, '', '', ''),
(15, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image2.jpg', 28, '20', 1, '0000-00-00 00:00:00', '', 2, '', '', ''),
(16, 18, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image10.jpg', 28, '20', 1, '0000-00-00 00:00:00', '', 9, '', '', ''),
(17, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image4.jpg', 28, '20', 2, '0000-00-00 00:00:00', '', 1, '', '', ''),
(21, 18, 'Mario', 'http://inlife.no-ip.org/proto/uploads/e30acc21d7782d618a6767b463dffa21.jpeg', 56, '250000', 1, '2013-08-30 14:23:58', 'THIS IS MARIO!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!\n\n!!!!!!!!!!!!!!!!!!!!!!!!!!!\n!!!!!!!!!!!!!!!!!!!!\n!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!\n!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!\n\n', 57, '', '', ''),
(22, 18, 'Test#4', 'http://inlife.no-ip.org/proto/uploads/593edb0a3baa2d74c9490f65064b3cf3_8885.jpg', 26, '100', 1, '2013-09-23 16:20:49', 'asdasdasd', 29, 'http://inlife.no-ip.org/proto/uploads/593edb0a3baa2d74c9490f65064b3cf3_37115.jpg', 'http://inlife.no-ip.org/proto/uploads/593edb0a3baa2d74c9490f65064b3cf3_6179.jpg', ''),
(23, 18, 'Covers', 'http://inlife.no-ip.org/proto/uploads/067f3b10d621d6354f6f4df6941d450d_18519.jpg', 29, '1000', 1, '2013-09-23 16:38:56', 'asdasd', 24, 'http://inlife.no-ip.org/proto/uploads/067f3b10d621d6354f6f4df6941d450d_3060.jpg', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE IF NOT EXISTS `likes` (
  `uid` int(255) NOT NULL AUTO_INCREMENT,
  `itemid` int(255) NOT NULL,
  `userid` int(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=28 ;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`uid`, `itemid`, `userid`, `date`) VALUES
(1, 16, 18, '0000-00-00 00:00:00'),
(2, 14, 18, '0000-00-00 00:00:00'),
(3, 9, 18, '0000-00-00 00:00:00'),
(5, 15, 18, '2013-08-26 15:45:57'),
(6, 13, 18, '0000-00-00 00:00:00'),
(7, 6, 18, '2013-08-26 15:51:50'),
(8, 12, 18, '2013-08-26 18:10:03'),
(9, 10, 18, '2013-08-27 17:10:45'),
(16, 15, 7, '2013-08-29 20:23:34'),
(19, 7, 28, '2013-09-17 13:25:32'),
(21, 9, 28, '2013-09-17 13:25:45'),
(22, 10, 28, '2013-09-17 13:26:13'),
(25, 16, 28, '2013-09-17 13:44:48'),
(26, 21, 28, '2013-09-21 08:06:53'),
(27, 21, 18, '2013-09-23 12:52:10');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `uid` int(255) NOT NULL AUTO_INCREMENT,
  `userid` int(255) NOT NULL,
  `senderid` int(255) NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=27 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`uid`, `userid`, `senderid`, `text`, `date`) VALUES
(6, 18, 30, 'Эй, привет, как твои дела?', '2013-08-31 07:10:31'),
(7, 30, 18, 'Нормально', '2013-08-31 07:13:22'),
(8, 30, 18, 'Привееет!!!', '2013-08-31 08:05:53'),
(9, 18, 30, 'Привет!!!!!!', '2013-08-31 08:06:23'),
(10, 18, 30, 'Как у тебя дела?', '2013-08-31 08:06:27'),
(11, 30, 18, 'Нормально, вот сижу фигней старадаю', '2013-08-31 08:07:04'),
(12, 30, 18, 'а ты че?', '2013-08-31 08:07:18'),
(13, 30, 18, 'эй', '2013-08-31 08:07:21'),
(14, 30, 18, 'ты куда пропал?', '2013-08-31 08:07:28'),
(15, 30, 18, 'ЛАЛКА!!!', '2013-08-31 08:07:35'),
(16, 18, 18, 'Добрый день, я бы хотел заказать ваш товар под именем Mario', '2013-08-31 08:23:28'),
(17, 28, 18, 'Привет', '2013-08-31 08:41:06'),
(18, 18, 28, 'здарова', '2013-08-31 08:41:44'),
(19, 18, 28, 'жвалпзщкпвап', '2013-08-31 08:43:05'),
(20, 28, 18, 'как дела?)', '2013-08-31 08:43:10'),
(21, 28, 18, 'автообновления нету =*(', '2013-08-31 08:43:21'),
(22, 28, 18, 'пока что', '2013-08-31 08:43:27'),
(23, 32, 18, 'потом сделаем,я уверен', '2013-08-31 08:43:38'),
(24, 18, 28, 'Hello, i want to buy your item, Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', '2013-09-17 14:44:49'),
(25, 18, 0, 'Hello, i want to buy your product: Mario', '2013-09-23 15:42:12'),
(26, 18, 0, 'Hello, i want to buy your product: Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', '2013-09-23 15:43:00');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE IF NOT EXISTS `subscribers` (
  `uid` int(255) NOT NULL AUTO_INCREMENT,
  `shopid` int(255) NOT NULL,
  `userid` int(255) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`uid`, `shopid`, `userid`) VALUES
(1, 18, 28);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
