--
-- Table structure for table `oc_news_category_permission`
--

CREATE TABLE IF NOT EXISTS `oc_news_category_permission` (
  `news_category_id` int(11) NOT NULL,
  `customer_group_id` int(11) NOT NULL,
  `permission` int(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
