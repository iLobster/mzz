SET NAMES `utf8`;

CREATE TABLE `tags_tagCoords` (
  `rel_id` int(10) unsigned NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `w` int(11) NOT NULL,
  `h` int(11) NOT NULL,
  PRIMARY KEY  (`rel_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
ALTER TABLE `tags_item_rel` ADD KEY `item_id` (`item_id`);