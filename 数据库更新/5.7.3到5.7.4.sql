ALTER TABLE `clt_debris` 
	CHANGE `type_id` `type_id` int(6)   NULL COMMENT '碎片分类ID' after `id` , 
	CHANGE `title` `title` varchar(120)  COLLATE utf8_general_ci NULL COMMENT '标题' after `type_id` , 
	CHANGE `content` `content` text  COLLATE utf8_general_ci NULL COMMENT '内容' after `title` , 
	CHANGE `addtime` `addtime` int(13)   NULL COMMENT '添加时间' after `content` , 
	CHANGE `sort` `sort` int(11)   NULL DEFAULT 50 COMMENT '排序' after `addtime` , 
	ADD COLUMN `url` varchar(120)  COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '链接' after `sort` , 
	ADD COLUMN `pic` varchar(120)  COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '图片' after `url` ;
	
ALTER TABLE `clt_page` 
	CHANGE `content` `content` text  COLLATE utf8_general_ci NULL COMMENT '内容' after `lang` ;