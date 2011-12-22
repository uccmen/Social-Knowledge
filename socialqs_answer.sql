CREATE TABLE `socialqs_answer` (
`question_id` int(4) NOT NULL default '0',
`a_id` int(4) NOT NULL default '0',
`fbid` bigint(64) NOT NULL default '',
`a_answer` longtext NOT NULL,
`a_datetime` varchar(25) NOT NULL default '',
KEY `a_id` (`a_id`)
) TYPE=MyISAM;