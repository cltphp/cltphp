ALTER TABLE `clt_article` 
	CHANGE `title` `title` varchar(80)  COLLATE utf8_general_ci NOT NULL DEFAULT '' after `username` , 
	CHANGE `keywords` `keywords` varchar(120)  COLLATE utf8_general_ci NOT NULL DEFAULT '' after `title` , 
	CHANGE `status` `status` varchar(255)  COLLATE utf8_general_ci NOT NULL DEFAULT '1' after `posid` , 
	CHANGE `thumb` `thumb` varchar(100)  COLLATE utf8_general_ci NOT NULL DEFAULT '' after `fromlink` , 
	CHANGE `title_style` `title_style` varchar(100)  COLLATE utf8_general_ci NOT NULL DEFAULT '' after `thumb` ;

ALTER TABLE `clt_download` 
	ADD COLUMN `files` varchar(80)  COLLATE utf8_general_ci NOT NULL DEFAULT '' after `updatetime` , 
	CHANGE `ext` `ext` varchar(255)  COLLATE utf8_general_ci NOT NULL DEFAULT 'zip' after `files` , 
	DROP COLUMN `file` ;

ALTER TABLE `clt_page` CHANGE `status` `status` varchar(255)  COLLATE utf8_general_ci NOT NULL DEFAULT '1' after `hits` ;

ALTER TABLE `clt_system` ADD COLUMN `mobile` int(1)   NULL DEFAULT 1 COMMENT '是否开启手机端' after `logo` ;

ALTER TABLE `clt_team` ADD COLUMN `template` varchar(50)  COLLATE utf8_general_ci NULL after `info` ;