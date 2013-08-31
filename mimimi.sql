-- phpMyAdmin SQL Dump
-- version 4.0.5
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Авг 31 2013 г., 11:17
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
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `avatar` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=32 ;

--
-- Дамп данных таблицы `accounts`
--

INSERT INTO `accounts` (`uid`, `email`, `password`, `activated`, `registered`, `lastonline`, `fbid`, `vkid`, `firstname`, `lastname`, `type`, `avatar`) VALUES
(18, '', '', 1, '2013-08-20 12:49:06', '2013-08-20 13:49:06', 100000470641337, 0, 'Vladislav', 'Gritsenko', 1, 'https://graph.facebook.com/inlife360/picture?width=100&height=100'),
(28, 'antuan@i.aaa', '5d0c3643afbd328bf13485c22f3980ef', 1, '2013-08-29 20:16:42', '2013-08-29 21:16:42', 0, 0, '', '', 0, '0');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `comments`
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
-- Структура таблицы `items`
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
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;

--
-- Дамп данных таблицы `items`
--

INSERT INTO `items` (`uid`, `userid`, `title`, `image`, `category`, `price`, `size`, `date`, `description`) VALUES
(1, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image8.jpg', 7, '20', 1, '0000-00-00 00:00:00', ''),
(2, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image2.jpg', 7, '20', 1, '0000-00-00 00:00:00', ''),
(3, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image10.jpg', 7, '20', 1, '0000-00-00 00:00:00', ''),
(4, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image4.jpg', 7, '20', 2, '0000-00-00 00:00:00', ''),
(5, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image2.jpg', 7, '20', 1, '0000-00-00 00:00:00', ''),
(6, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image6.jpg', 7, '20', 1, '0000-00-00 00:00:00', ''),
(7, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image3.jpg', 7, '20', 1, '0000-00-00 00:00:00', ''),
(8, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image11.jpg', 7, '20', 1, '0000-00-00 00:00:00', ''),
(9, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image9.jpg', 7, '20', 1, '0000-00-00 00:00:00', ''),
(10, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image1.jpg', 7, '20', 2, '0000-00-00 00:00:00', ''),
(11, 0, 'BLablabla', 'images/temp/image7.jpg', 8, '30', 1, '0000-00-00 00:00:00', ''),
(12, 0, 'Teestestest', 'images/temp/image5.jpg', 8, '30', 1, '0000-00-00 00:00:00', ''),
(13, 0, 'BLablabla', 'images/temp/image3.jpg', 7, '100', 1, '0000-00-00 00:00:00', ''),
(14, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image8.jpg', 7, '20', 1, '0000-00-00 00:00:00', ''),
(15, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image2.jpg', 7, '20', 1, '0000-00-00 00:00:00', ''),
(16, 18, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image10.jpg', 7, '20', 1, '0000-00-00 00:00:00', ''),
(17, 0, 'Blue Sapphire Gemstone Bracelet Precious Gem Gold Chain Delicate Handmade Jewelry', 'images/temp/image4.jpg', 7, '20', 2, '0000-00-00 00:00:00', ''),
(21, 18, 'Mario', 'http://inlife.no-ip.org/proto/uploads/e30acc21d7782d618a6767b463dffa21.jpeg', 8, '250000', 1, '2013-08-30 14:23:58', 'THIS IS MARIO!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!\n\n!!!!!!!!!!!!!!!!!!!!!!!!!!!\n!!!!!!!!!!!!!!!!!!!!\n!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!\n!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!\n\n');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

--
-- Дамп данных таблицы `likes`
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
(10, 12, 28, '2013-08-29 19:43:47'),
(11, 13, 28, '0000-00-00 00:00:00'),
(12, 14, 28, '2013-08-29 19:43:17'),
(13, 15, 28, '0000-00-00 00:00:00'),
(14, 16, 28, '2013-08-29 19:43:11'),
(15, 17, 28, '2013-08-29 19:43:59'),
(16, 15, 7, '2013-08-29 20:23:34'),
(17, 21, 18, '2013-08-30 20:36:46');

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `uid` int(255) NOT NULL AUTO_INCREMENT,
  `userid` int(255) NOT NULL,
  `senderid` int(255) NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=24 ;

--
-- Дамп данных таблицы `messages`
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
(23, 28, 18, 'потом сделаем,я уверен', '2013-08-31 08:43:38');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
