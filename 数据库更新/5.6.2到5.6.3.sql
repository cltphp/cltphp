ALTER TABLE `clt_system` CHANGE `mobile` `mobile` varchar(10)  COLLATE utf8_general_ci NULL DEFAULT 'open' COMMENT '是否开启手机端 open 开启 close 关闭' after `logo` ;
	
ALTER TABLE `clt_field` CHANGE `setup` `setup` text  COLLATE utf8_general_ci NULL after `type` ;

ALTER TABLE `clt_module` CHANGE `sort` `sort` smallint(3) unsigned   NOT NULL DEFAULT 0 after `listfields` , DROP COLUMN `setup` ;