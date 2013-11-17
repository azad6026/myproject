-- phpMyAdmin SQL Dump
-- version 4.0.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 14, 2013 at 09:17 PM
-- Server version: 5.5.32-cll
-- PHP Version: 5.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `database`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(30) NOT NULL,
  PRIMARY KEY (`category_name`),
  KEY `categoryId` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Motivation'),
(2, 'Romance'),
(3, 'Sense of humor'),
(4, 'Sport'),
(5, 'Life''s facts'),
(6, 'Humanity'),
(7, 'Happiness'),
(8, 'Strength'),
(9, 'Tenacity'),
(10, 'Dreams'),
(11, 'Life Style'),
(12, 'Relationship'),
(13, 'Management'),
(14, 'Health'),
(15, 'Financial'),
(16, 'Believes');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `comment_content` varchar(200) NOT NULL,
  `published_date` datetime NOT NULL,
  `author` varchar(30) NOT NULL,
  `edited_date` datetime NOT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `postId` (`post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `post_id`, `comment_content`, `published_date`, `author`, `edited_date`) VALUES
(1, 13, '"this is great', '2013-01-01 06:24:08', 'aza', '0000-00-00 00:00:00'),
(2, 13, 'fantastic quot"/.', '2013-01-01 20:35:24', 'guest', '0000-00-00 00:00:00'),
(3, 8, 'jojo', '2013-01-01 20:37:10', 'guest', '0000-00-00 00:00:00'),
(4, 9, 'hi:)', '2013-01-04 17:09:30', 'guest', '0000-00-00 00:00:00'),
(5, 11, 'this is a good quote', '2013-01-05 08:27:49', 'guest', '0000-00-00 00:00:00'),
(6, 9, 'i love bears.they are hard workers too!!!', '2013-01-12 13:23:09', 'guest', '0000-00-00 00:00:00'),
(7, 9, 'great quote.thanks', '2013-01-12 13:25:21', 'guest', '0000-00-00 00:00:00'),
(8, 7, 'love is kind.', '2013-01-14 13:09:28', 'guest', '0000-00-00 00:00:00'),
(9, 10, 'it is  good', '2013-02-02 14:23:46', 'guest', '0000-00-00 00:00:00'),
(18, 11, 'hi', '2013-04-27 22:34:48', 'admin', '0000-00-00 00:00:00'),
(19, 7, 'love is what life is about', '2013-06-25 08:14:02', 'admin', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `lookup_posts`
--

CREATE TABLE IF NOT EXISTS `lookup_posts` (
  `post_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_title` varchar(200) DEFAULT NULL,
  `post_content` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`post_id`),
  FULLTEXT KEY `post_title` (`post_title`,`post_content`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `lookup_posts`
--

INSERT INTO `lookup_posts` (`post_id`, `post_title`, `post_content`) VALUES
(1, 'Life', 'Today is the first day of the rest of your life. The time, you cann\\''t stop it,but you can use it more efficiently.'),
(2, 'mistakes', 'â€œFreedom is not worth having if it does not include the freedom to make mistakes.â€ Mahatma Gandhi'),
(3, 'Indifference ', 'â€œIndifference and neglect often do much more damage than outright dislike.â€ J.K. Rowling, Harry Potter and the Order of the Phoenix'),
(4, 'cry-smile', 'â€œDon\\''t cry because it\\''s over, smile because it happened.â€ Dr. Seuss'),
(5, 'minutes', 'â€œFor every minute you are angry you lose sixty seconds of happiness.â€Ralph Waldo Emerson'),
(6, 'First and last love', 'Men always want to be a woman\\''s first love - women like to be a man\\''s last romance.Oscar Wilde'),
(7, 'Romance and love', 'Romance is tempestuous. Love is calm.Mason Cooley '),
(8, 'Secret in goals', 'Let me tell you the secret that has led me to my goal: my strength lies solely in my tenacity.Louis Pasteur'),
(9, 'Perseverance ', 'â€œPerseverance is the hard work you do after you get tired of doing the hard work you already did.â€Newt Gingrich'),
(10, 'Right skills', '\\"Never try to teach a pig to sing; it wastes your time and it annoys the pig.\\"Paul Dickson'),
(11, 'Human ends', 'Always recognize that human individuals are ends, and do not use them as means to your end.Immanuel Kant'),
(12, 'Financial freedom', 'A big part of financial freedom is having your heart and mind free from worry about the what-ifs of life. By:Suze Orman '),
(13, 'Financial speculation', 'For the merchant, even honesty is a financial speculation. By:Charles Baudelaire \n  ');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_title` varchar(30) NOT NULL,
  `post_content` varchar(300) NOT NULL,
  `published_date` datetime NOT NULL,
  `username` varchar(30) NOT NULL,
  `photo_path` varchar(100) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `edited_date` datetime NOT NULL,
  PRIMARY KEY (`post_id`),
  KEY `category_id` (`category_id`),
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `post_title`, `post_content`, `published_date`, `username`, `photo_path`, `category_id`, `edited_date`) VALUES
(1, 'Life', 'Today is the first day of the rest of your life. The time, you cann\\''t stop it,but you can use it more efficiently.', '2012-11-29 20:42:20', 'clearsky', '/images/posts_images/955_57333371268_1354210886.jpg', 5, '0000-00-00 00:00:00'),
(2, 'mistakes', 'â€œFreedom is not worth having if it does not include the freedom to make mistakes.â€ Mahatma Gandhi', '2012-11-29 20:57:54', 'clearsky', '/images/posts_images/216936_41309054_1354211869.jpg', 6, '0000-00-00 00:00:00'),
(3, 'Indifference ', 'â€œIndifference and neglect often do much more damage than outright dislike.â€ J.K. Rowling, Harry Potter and the Order of the Phoenix', '2012-11-29 20:59:51', 'clearsky', '/images/posts_images/150221_14857712_1354211986.jpg', 6, '0000-00-00 00:00:00'),
(4, 'cry-smile', 'â€œDon\\''t cry because it\\''s over, smile because it happened.â€ Dr. Seuss', '2012-11-29 21:01:45', 'clearsky', '/images/posts_images/150221_14857712_1354211986.jpg', 7, '0000-00-00 00:00:00'),
(5, 'minutes', 'â€œFor every minute you are angry you lose sixty seconds of happiness.â€Ralph Waldo Emerson', '2012-11-29 21:02:55', 'clearsky', '/images/posts_images/382126_52322893_1354212168.jpg', 7, '0000-00-00 00:00:00'),
(6, 'First and last love', 'Men always want to be a woman\\''s first love - women like to be a man\\''s last romance.Oscar Wilde', '2012-11-29 21:15:22', 'clearsky', '/images/posts_images/10480_379858438_1354212920.jpg', 2, '0000-00-00 00:00:00'),
(7, 'Romance and love', 'Romance is tempestuous. Love is calm.Mason Cooley ', '2012-11-29 21:16:48', 'clearsky', '/images/posts_images/251894_133_1354213007.jpg', 2, '0000-00-00 00:00:00'),
(8, 'Secret in goals', 'Let me tell you the secret that has led me to my goal: my strength lies solely in my tenacity.Louis Pasteur', '2012-11-29 21:18:53', 'clearsky', '/images/posts_images/404754_51615309_1354213059.jpg', 9, '0000-00-00 00:00:00'),
(9, 'Perseverance ', 'â€œPerseverance is the hard work you do after you get tired of doing the hard work you already did.â€Newt Gingrich', '2012-11-29 21:20:43', 'clearsky', '/images/posts_images/402463_48232045_1354213240.jpg', 9, '0000-00-00 00:00:00'),
(10, 'Right skills', '\\"Never try to teach a pig to sing; it wastes your time and it annoys the pig.\\"Paul Dickson', '2012-11-29 21:23:38', 'clearsky', '/images/posts_images/575253_54848631_1354213415.jpg', 13, '0000-00-00 00:00:00'),
(11, 'Human ends', 'Always recognize that human individuals are ends, and do not use them as means to your end.Immanuel Kant', '2012-11-29 21:25:18', 'clearsky', '/images/posts_images/644014_24411566_1354213517.jpg', 13, '0000-00-00 00:00:00'),
(12, 'Financial feedom', 'A big part of financial freedom is having your heart and mind free from worry about the what-ifs of life. By:Suze Orman', '2012-12-04 19:12:09', 'clearsky', '/images/posts_images/76397_484900014_1354212118.jpg', 15, '0000-00-00 00:00:00'),
(13, 'Financial speculation', 'For the merchant, even honesty is a financial speculation. By:Charles Baudelaire', '2012-12-04 19:15:51', 'clearsky', '/images/posts_images/b_1351152023.jpg', 15, '0000-00-00 00:00:00'),
(14, 'Life is short', 'Today is the first day of the rest of your life.', '2013-04-26 17:36:50', 'clearskyadmin', '/images/posts_images/cooltext1007255057 (1).png', 5, '0000-00-00 00:00:00'),
(15, 'Life is great', 'enjoy life as it is.Love every moment.Be motivated every second.Always do your best.It worth it.', '2013-06-25 07:17:20', 'admin', '/images/posts_images/971679_450322395064716_549170732_n.jpg', 10, '0000-00-00 00:00:00');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
