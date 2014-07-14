--
-- Table structure for table `news`
--
CREATE TABLE IF NOT EXISTS `oc_news` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `count_read` int(11) NOT NULL DEFAULT '0',
  `allow_comment` int(1) NOT NULL DEFAULT '1',
  `comment_permission` int(1) NOT NULL DEFAULT '0',
  `comment_need_approval` int(1) NOT NULL DEFAULT '0',
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`news_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `news_category`
--
CREATE TABLE IF NOT EXISTS `oc_news_category` (
  `news_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `top` tinyint(1) NOT NULL,
  `column` int(3) NOT NULL,
  `top_article` INT( 3 ) NOT NULL DEFAULT '0',
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`news_category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `news_category_description`
--
CREATE TABLE IF NOT EXISTS `oc_news_category_description` (
  `news_category_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `meta_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `meta_keyword` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`news_category_id`,`language_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `news_category_to_layout`
--
CREATE TABLE IF NOT EXISTS `oc_news_category_to_layout` (
  `news_category_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL,
  PRIMARY KEY (`news_category_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `news_category_to_store`
--
CREATE TABLE IF NOT EXISTS `oc_news_category_to_store` (
  `news_category_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  PRIMARY KEY (`news_category_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `news_comment`
--
CREATE TABLE IF NOT EXISTS `oc_news_comment` (
  `news_comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `comment` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `date_added` datetime DEFAULT '0000-00-00 00:00:00',
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`news_comment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `news_description`
--
CREATE TABLE IF NOT EXISTS `oc_news_description` (
  `news_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `short_description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `meta_description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `meta_keyword` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`news_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `news_related`
--
CREATE TABLE IF NOT EXISTS `oc_news_related` (
  `parent_news_id` int(11) NOT NULL DEFAULT '0',
  `child_news_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `news_to_category`
--
CREATE TABLE IF NOT EXISTS `oc_news_to_category` (
  `news_id` int(11) NOT NULL,
  `news_category_id` int(11) NOT NULL,
  PRIMARY KEY (`news_id`,`news_category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `news_to_store`
--
CREATE TABLE IF NOT EXISTS `oc_news_to_store` (
  `news_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  PRIMARY KEY (`news_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `news_to_store`
--

CREATE TABLE IF NOT EXISTS `oc_news_tag` (
  `news_tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `tag` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`news_tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oc_news_category_permission`
--

CREATE TABLE IF NOT EXISTS `oc_news_category_permission` (
  `news_category_id` int(11) NOT NULL,
  `customer_group_id` int(11) NOT NULL,
  `permission` int(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
