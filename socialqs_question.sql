CREATE TABLE `socialqs_question` (
`id` int(4) NOT NULL auto_increment,
`fbid` bigint(64) NOT NULL default '',
`qid` varchar(32) NOT NULL,
`question` longtext NOT NULL default '',
`datetime` varchar(25) NOT NULL default '',
`view` int(4) NOT NULL default '0',
`reply` int(4) NOT NULL default '0',
PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;