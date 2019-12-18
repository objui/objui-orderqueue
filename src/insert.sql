drop table if exists `obj_goods`;
create table `obj_goods`(
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
	`stocks` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '库存量',
	`price` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '价格',
	`img` varchar(100) NOT NULL DEFAULT '' COMMENT '封面',
	`create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
	`update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COMMENT='商品表';

drop table if exists `obj_order`;
create table `obj_order`(
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`out_order_no` char(24) NOT NULL DEFAULT '' COMMENT '订单号',
	`uid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
	`price` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '原价格',
	`real_pay` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '实际支付',
	`buy_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '下单时间',
	`pay_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '支付时间',
	`status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态：1未支付，2已支付，3已退款，4订单超时',
	PRIMARY KEY (`id`),
	UNIQUE KEY (`out_order_no`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COMMENT='订单表';

drop table if exists `obj_user`;
create table `obj_user`(
	`id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
	`username` varchar(50) NOT NULL DEFAULT '' COMMENT '账号',
	`password` char(32) NOT NULL DEFAULT '' COMMENT '密码',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COMMENT='用户表';