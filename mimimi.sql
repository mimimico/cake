-- phpMyAdmin SQL Dump
-- version 4.0.5
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Авг 26 2013 г., 17:33
-- Версия сервера: 5.5.29
-- Версия PHP: 5.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `mimimi`
--

-- --------------------------------------------------------

--
-- Структура таблицы `accounts`
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
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;

--
-- Дамп данных таблицы `accounts`
--

INSERT INTO `accounts` (`uid`, `email`, `password`, `activated`, `registered`, `lastonline`, `fbid`, `vkid`) VALUES
(1, 'asdasd@asdas.com', 'ad1a4b6f8f611f4a8eb8d2a2ecc3ea85', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(5, 'vladis-g@ukr.net', '4e861126c005acd26e36c75ef947bcde', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(6, 'asd@ads.asd', 'ad1a4b6f8f611f4a8eb8d2a2ecc3ea85', 0, '0000-00-00 00:00:00', '2013-08-14 11:49:54', 0, 0),
(7, 'asd@asd.asd', 'ad1a4b6f8f611f4a8eb8d2a2ecc3ea85', 1, '0000-00-00 00:00:00', '2013-08-14 12:02:27', 0, 0),
(8, 'asd@asd.asdasd', 'ad1a4b6f8f611f4a8eb8d2a2ecc3ea85', 0, '0000-00-00 00:00:00', '2013-08-14 12:18:10', 0, 0),
(9, 'test@gmail.com', 'a57b16f5af2693e058b43854315db883', 0, '0000-00-00 00:00:00', '2013-08-17 17:15:58', 0, 0),
(10, 'asd@asdasd.asd', 'ad1a4b6f8f611f4a8eb8d2a2ecc3ea85', 0, '0000-00-00 00:00:00', '2013-08-17 17:18:40', 0, 0),
(11, 'test1@gmail.com', 'a57b16f5af2693e058b43854315db883', 0, '0000-00-00 00:00:00', '2013-08-17 17:20:03', 0, 0),
(12, 'asd@asdasdasd.asdasd', 'ad1a4b6f8f611f4a8eb8d2a2ecc3ea85', 0, '0000-00-00 00:00:00', '2013-08-20 10:10:20', 0, 0),
(13, 'a@asd.com', 'ad1a4b6f8f611f4a8eb8d2a2ecc3ea85', 1, '2013-08-20 09:18:50', '2013-08-20 10:18:50', 0, 0),
(18, 'vladgritsenko@gmail.com', '', 1, '2013-08-20 12:49:06', '2013-08-20 13:49:06', 100000470641337, 0),
(19, '', '', 1, '2013-08-20 17:08:41', '2013-08-21 08:25:52', 0, 8075635),
(20, 'admin@gmail.com', '148ba2c9bfb655f6f89f1b66fd70f371', 0, '2013-08-26 14:16:30', '2013-08-26 15:16:30', 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `uid` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent` int(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`uid`, `name`, `parent`) VALUES
(1, 'category_accessories', 0),
(2, 'category_decorations', 0),
(3, 'category_forhome', 0),
(4, 'category_clothes', 0),
(5, 'category_art', 0),
(6, 'category_misc', 0),
(7, 'subcategory_sunglasses', 1),
(8, 'subcategory_pictures', 5);

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `uid` int(255) NOT NULL AUTO_INCREMENT,
  `userid` int(255) NOT NULL,
  `itemid` int(255) NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`uid`, `userid`, `itemid`, `text`, `date`) VALUES
(1, 1, 16, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut eu dolor et nulla imperdiet dapibus. Sed eget varius elit. In blandit lacus eu vehicula posuere. Ut mollis, quam sit amet ullamcorper porta, nisl neque cursus elit, eu auctor ante est ut turpis. Cras ullamcorper ornare eleifend. Phasellus id arcu tellus. Integer cursus ut erat vitae posuere. Nunc pulvinar quam leo, iaculis consequat ipsum ullamcorper quis. Pellentesque at tortor nulla. Integer hendrerit tortor ut felis aliquam, eu luctus ipsum sodales. Aliquam eleifend lacinia vulputate. Cras malesuada ipsum ac mauris ullamcorper, et gravida libero semper. In nulla justo, imperdiet sit amet dui eget, imperdiet facilisis leo. Proin dictum neque volutpat enim dignissim commodo.', '2013-07-27 10:28:21'),
(2, 1, 16, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut eu dolor et nulla imperdiet dapibus. Sed eget varius elit. In blandit lacus eu vehicula posuere. Ut mollis, quam sit amet ullamcorper porta, nisl neque cursus elit, eu auctor ante est ut turpis. Cras ullamcorper ornare eleifend. Phasellus id arcu tellus. Integer cursus ut erat vitae posuere. Nunc pulvinar quam leo, iaculis consequat ipsum ullamcorper quis. Pellentesque at tortor nulla. Integer hendrerit tortor ut felis aliquam, eu luctus ipsum sodales. Aliquam eleifend lacinia vulputate. Cras malesuada ipsum ac mauris ullamcorper, et gravida libero semper. In nulla justo, imperdiet sit amet dui eget, imperdiet facilisis leo. Proin dictum neque volutpat enim dignissim commodo.', '2013-07-27 10:28:21');

-- --------------------------------------------------------

--
-- Структура таблицы `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `uid` int(255) NOT NULL AUTO_INCREMENT,
  `shopid` int(255) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category` int(3) NOT NULL,
  `price` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `size` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

--
-- Дамп данных таблицы `items`
--

INSERT INTO `items` (`uid`, `shopid`, `title`, `image`, `category`, `price`, `size`) VALUES
(1, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image8.jpg', 7, '20', 1),
(2, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image2.jpg', 7, '20', 1),
(3, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image10.jpg', 7, '20', 1),
(4, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image4.jpg', 7, '20', 2),
(5, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image2.jpg', 7, '20', 1),
(6, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image6.jpg', 7, '20', 1),
(7, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image3.jpg', 7, '20', 1),
(8, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image11.jpg', 7, '20', 1),
(9, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image9.jpg', 7, '20', 1),
(10, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image1.jpg', 7, '20', 2),
(11, 0, 'BLablabla', 'images/temp/image7.jpg', 8, '30', 1),
(12, 0, 'Teestestest', 'images/temp/image5.jpg', 8, '30', 1),
(13, 0, 'BLablabla', 'images/temp/image3.jpg', 7, '100', 1),
(14, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image8.jpg', 7, '20', 1),
(15, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image2.jpg', 7, '20', 1),
(16, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image10.jpg', 7, '20', 1),
(17, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image4.jpg', 7, '20', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `likes`
--

CREATE TABLE IF NOT EXISTS `likes` (
  `uid` int(255) NOT NULL AUTO_INCREMENT,
  `itemid` int(255) NOT NULL,
  `userid` int(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `likes`
--

INSERT INTO `likes` (`uid`, `itemid`, `userid`, `date`) VALUES
(1, 16, 18, '0000-00-00 00:00:00'),
(2, 14, 18, '0000-00-00 00:00:00'),
(3, 9, 18, '0000-00-00 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
