ALTER TABLE `clt_system` ADD COLUMN `code` varchar(10)  COLLATE utf8_general_ci NULL DEFAULT 'close' COMMENT '是否开启验证码' after `mobile` ;

ALTER TABLE `clt_category` ADD COLUMN `is_show` tinyint(1) unsigned   NOT NULL DEFAULT 0 COMMENT '是否预览' after `lang` ;

ALTER TABLE `clt_region` ENGINE=InnoDB;

ALTER TABLE `clt_module` 
	CHANGE `sort` `sort` smallint(3) unsigned   NOT NULL DEFAULT 0 after `listfields` , 
	DROP COLUMN `setup` ;
