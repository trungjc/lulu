CREATE TABLE IF NOT EXISTS `oc_news_tag` (
  `news_tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `tag` varchar(32) NOT NULL,
  PRIMARY KEY (`news_tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
