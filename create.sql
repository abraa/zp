/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : mb

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-01-12 15:35:16
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `py_admin`
-- ----------------------------
DROP TABLE IF EXISTS `py_admin`;
CREATE TABLE `py_admin` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '管理员ID',
  `user_name` varchar(50) NOT NULL COMMENT '登录名',
  `real_name` varchar(200) NOT NULL COMMENT '管理员真实名称',
  `password` char(32) NOT NULL COMMENT '登录密码',
  `sex` tinyint(1) NOT NULL DEFAULT '1' COMMENT '性别',
  `session_key` char(32) NOT NULL COMMENT '登录密码串',
  `locked` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否锁定',
  `group_id` int(11) NOT NULL COMMENT '组织架构',
  `role_id` int(11) NOT NULL COMMENT '角色',
  `menu_id` text NOT NULL COMMENT '功能ID集合，逗号隔开',
  `is_open` tinyint(1) DEFAULT '0' COMMENT '开放权限',
  `create_time` int(11) DEFAULT NULL COMMENT '插入时间',
  `update_time` int(11) DEFAULT NULL COMMENT '最后更新时间',
  `last_login_time` int(11) DEFAULT NULL COMMENT '上次登录时间',
  `now_login_time` int(11) DEFAULT NULL COMMENT '本次登录时间',
  `last_login_ip` varchar(50) DEFAULT NULL COMMENT '上次登录密码',
  `now_login_ip` varchar(50) DEFAULT NULL COMMENT '本次登录IP',
  PRIMARY KEY (`user_id`),
  KEY `index_user_name` (`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of py_admin
-- ----------------------------
INSERT INTO `py_admin` VALUES ('1', '800001', '超级管理员', '758894b3e908de2074e26216e973e677', '1', '1mr2rerrinve3pcbk59funhji5', '0', '1', '1', '', '0', '1435324617', '1515724530', '1512378183', '1512378224', '127.0.0.1', '127.0.0.1');

-- ----------------------------
-- Table structure for `py_admin_log`
-- ----------------------------
DROP TABLE IF EXISTS `py_admin_log`;
CREATE TABLE `py_admin_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `module_name` varchar(255) NOT NULL,
  `controller_name` varchar(255) NOT NULL,
  `action_name` varchar(255) NOT NULL,
  `note` varchar(255) NOT NULL,
  `params` text COMMENT '参数',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_note` (`note`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=utf8 COMMENT='登录日志表';

-- ----------------------------
-- Records of py_admin_log
-- ----------------------------

-- ----------------------------
-- Table structure for `py_config`
-- ----------------------------
DROP TABLE IF EXISTS `py_config`;
CREATE TABLE `py_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '配置名称',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置类型',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '配置说明',
  `group` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置分组',
  `extra` varchar(255) NOT NULL DEFAULT '' COMMENT '配置项',
  `remark` varchar(100) NOT NULL COMMENT '配置说明',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  `value` text NOT NULL COMMENT '配置值',
  `orderby` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_name` (`name`),
  KEY `type` (`type`),
  KEY `group` (`group`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='系统配置表';

-- ----------------------------
-- Records of py_config
-- ----------------------------
INSERT INTO `py_config` VALUES ('1', 'SITE_TITLE', '1', '网站标题', '1', '', '网站标题前台显示标题', '1435324617', '1490864693', '凤鸣集团网站后台管理平台', '50');
INSERT INTO `py_config` VALUES ('2', 'SITE_DESCRIPTION', '1', '网站描述', '1', '', '网站搜索引擎描述', '1435324617', '1490601795', '凤鸣集团网站后台管理平台', '50');
INSERT INTO `py_config` VALUES ('3', 'SITE_KEYWORD', '1', '网站关键字', '1', '', '网站搜索引擎关键字', '1435324617', '1438265293', '凤鸣集团网站后台管理平台', '50');
INSERT INTO `py_config` VALUES ('4', 'SITE_CLOSE', '5', '开启站点', '1', '0:关闭,1:开启', '站点关闭后其他用户不能访问，管理员可以正常访问', '1435324617', '1439647872', '0', '50');
INSERT INTO `py_config` VALUES ('5', 'OPEN_REGISTER', '5', '会员注册', '3', '0:关闭,1:开启', '关闭后所有访客都不可进行注册', '1435324617', '1493790596', '1', '50');
INSERT INTO `py_config` VALUES ('11', 'CONFIG_GROUP_LIST', '4', '配置分组', '0', '', '', '1435324617', '1490781408', '1:基本,2:内容,3:用户,4:系统', '50');
INSERT INTO `py_config` VALUES ('12', 'CONFIG_TYPE_LIST', '4', '配置类型', '0', '', '', '1435324617', null, '1:数字,2:字符,3:文本,4:数组,5:枚举', '50');
INSERT INTO `py_config` VALUES ('13', 'VERIFY_CLOSE', '5', '开启验证码', '1', '0:关闭,1:开启', '验证码关闭后无需使用验证码', '1461200474', '1515666899', '0', '50');

-- ----------------------------
-- Table structure for `py_group`
-- ----------------------------
DROP TABLE IF EXISTS `py_group`;
CREATE TABLE `py_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `text` varchar(255) NOT NULL COMMENT '组别名称',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '上级组别',
  `remark` varchar(255) NOT NULL COMMENT '描述',
  `locked` tinyint(1) NOT NULL DEFAULT '0' COMMENT '禁用',
  `orderby` smallint(5) NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `index_locked` (`locked`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='角色表';

-- ----------------------------
-- Records of py_group
-- ----------------------------
INSERT INTO `py_group` VALUES ('1', '超级管理员', '0', '', '0', '50', '1435324617', '1435324617');
INSERT INTO `py_group` VALUES ('3', '管理员', '0', '', '0', '50', '1503539517', '1515659477');

-- ----------------------------
-- Table structure for `py_menu`
-- ----------------------------
DROP TABLE IF EXISTS `py_menu`;
CREATE TABLE `py_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(255) DEFAULT NULL COMMENT '菜单名',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父级ID',
  `module` varchar(50) DEFAULT NULL COMMENT '模块名',
  `controller` varchar(50) DEFAULT NULL COMMENT '控制器名称',
  `method` varchar(50) DEFAULT NULL COMMENT '方法名称',
  `other_method` varchar(255) DEFAULT NULL COMMENT '关联权限方法',
  `display` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示到菜单',
  `icon` varchar(50) DEFAULT NULL COMMENT '图标',
  `orderby` smallint(5) NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='模块表';

-- ----------------------------
-- Records of py_menu
-- ----------------------------
INSERT INTO `py_menu` VALUES ('1', '权限', '0', 'admin', 'master', '*', '', '1', 'fa-power-off', '60', '1435324617', '1487318419');
INSERT INTO `py_menu` VALUES ('2', '系统', '0', 'admin', 'setting', '*', '', '1', 'fa-dashboard', '100', '1435324617', '1479806145');
INSERT INTO `py_menu` VALUES ('3', '系统设置', '2', 'admin', 'config', 'setting', '', '1', 'fa-plane', '7', '1435324617', '1448952211');
INSERT INTO `py_menu` VALUES ('5', '管理人员', '1', 'admin', 'admin', '*', '', '1', 'fa-user-md', '50', '1435324617', '1448677843');
INSERT INTO `py_menu` VALUES ('6', '角色管理', '1', 'admin', 'role', '*', '', '1', 'fa-user-secret', '50', '1435324617', '1447831484');
INSERT INTO `py_menu` VALUES ('7', '组织架构', '1', 'admin', 'group', '*', 'save', '1', 'fa-sitemap', '50', '1435324617', '1448589479');
INSERT INTO `py_menu` VALUES ('8', '功能管理', '1', 'admin', 'menu', '*', '', '1', 'fa-cogs', '50', '1435324617', '1447831850');

-- ----------------------------
-- Table structure for `py_role`
-- ----------------------------
DROP TABLE IF EXISTS `py_role`;
CREATE TABLE `py_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '角色ID',
  `text` varchar(255) DEFAULT NULL COMMENT '角色名称',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父级ID',
  `remark` varchar(255) DEFAULT NULL COMMENT '描述',
  `locked` tinyint(1) NOT NULL DEFAULT '0' COMMENT '禁用',
  `orderby` smallint(5) NOT NULL DEFAULT '0' COMMENT '排序',
  `menu_id` text COMMENT '功能ID集合，逗号隔开',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `index_locked` (`locked`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='角色表';

-- ----------------------------
-- Records of py_role
-- ----------------------------
INSERT INTO `py_role` VALUES ('1', '超级管理员', '0', '', '0', '50', '1', '1435324617', '1490600242');
INSERT INTO `py_role` VALUES ('2', '管理员', '0', '', '0', '50', '84,86,92,87,88,93,94,89,95,96', '1503539475', '1515655050');

CREATE TABLE `py_company` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '公司ID',
  `text` varchar(255) DEFAULT NULL COMMENT '公司名称',
  `address` varchar(255) DEFAULT NULL COMMENT '公司地址',
  `scale` varchar(255) DEFAULT NULL COMMENT '公司规模',
  `welfare` varchar(255) DEFAULT NULL COMMENT '公司福利',
  `industry` varchar(255) DEFAULT NULL COMMENT '所属行业',
  `logo` varchar(255) DEFAULT NULL COMMENT 'logo',
  `thumb` varchar(255) DEFAULT NULL COMMENT 'thumb',
  `tel` varchar(255) DEFAULT NULL COMMENT '电话',
  `qq` varchar(255) DEFAULT NULL COMMENT 'QQ',
  `license` varchar(255) DEFAULT NULL COMMENT '营业执照照片',
  `remark` text COMMENT '描述',
  `audit` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审核',
  `locked` tinyint(1) NOT NULL DEFAULT '0' COMMENT '禁用',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `index_locked` (`locked`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='公司表';


INSERT INTO `py_menu` VALUES ('11', '公司管理', '0', 'admin', 'company', '*', '', '1', 'fa-cogs', '50', '1435324617', '1447831850');
INSERT INTO `py_menu` VALUES ('12', '用户管理', '0', 'admin', 'user', '*', '', '1', 'fa-cogs', '50', '1435324617', '1447831850');
INSERT INTO `py_menu` VALUES ('13', '内容管理', '0', 'admin', 'content', '*', '', '1', 'fa-cogs', '50', '1435324617', '1447831850');
INSERT INTO `py_menu` VALUES ('', '公司审核', '11', 'admin', 'company', '*', '', '1', 'fa-cogs', '50', '1435324617', '1447831850');


CREATE TABLE `py_social_r` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '话题id',
  `user_id` varchar(255) DEFAULT NULL COMMENT 'userid',
  `title` varchar(255) DEFAULT NULL COMMENT '标题描述',
  `content` text COMMENT '内容描述',
  `locked` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否锁定',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='话题表';


CREATE TABLE `py_social_a` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '答案id',
  `user_id` varchar(255) DEFAULT NULL COMMENT 'userid',
  `r_id` int(11) DEFAULT NULL COMMENT '话题id',
  `content` text COMMENT '内容描述',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='答复表';


CREATE TABLE `py_social_approval` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '答案id',
  `user_id` varchar(255) DEFAULT NULL COMMENT 'userid',
  `r_id` int(11) DEFAULT NULL COMMENT '话题id',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='赞赏表';

CREATE TABLE `py_tag` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '标签id',
  `type_id` int(11) DEFAULT NULL COMMENT '标签类型',
  `text` varchar(255) DEFAULT NULL COMMENT '标签名称',
  `order` smallint(5)   DEFAULT '0'  COMMENT '推荐顺序',
  `locked` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否锁定',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='标签表';

INSERT INTO `py_menu` VALUES ('', '标签', '13', 'admin', 'tag', '*', '', '1', 'fa-cogs', '50', '1435324617', '1447831850');


CREATE TABLE `py_tag_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '标签类型id',
  `text` varchar(255) NOT NULL COMMENT '标签类型',
  `locked` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否锁定',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='标签类型表';

CREATE TABLE `py_report` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `tag_id` int(11)  DEFAULT NULL COMMENT '标签id',
  `tag_text` varchar(255) DEFAULT NULL COMMENT '标签名称',
  `type_id` int(11) DEFAULT NULL COMMENT '类型id 公司举报|用户举报',
  `c_id` int(11) DEFAULT NULL COMMENT '简历id|职位id',
  `c_name` int(11) DEFAULT NULL COMMENT '用户真实姓名|公司名称',
  `locked` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否锁定',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='举报表';

INSERT INTO `py_menu` VALUES ('', '举报', '13', 'admin', 'report', '*', '', '1', 'fa-cogs', '50', '1435324617', '1447831850');


CREATE TABLE `py_msg_sys` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'd',
  `title` varchar(255) DEFAULT NULL COMMENT '标题描述',
  `thumb` varchar(255) DEFAULT NULL COMMENT '标题图片 ',
  `content` text  COMMENT '内容描述',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='系统消息表表';

INSERT INTO `py_menu` VALUES ('', '系统消息', '13', 'admin', 'msgSys', '*', '', '1', 'fa-cogs', '50', '1435324617', '1447831850');


CREATE TABLE `py_msg_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `thumb` varchar(255) DEFAULT NULL COMMENT '头像',
  `content` text  COMMENT '内容',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='用户消息表';

CREATE TABLE `py_msg_feedback` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `content` text  COMMENT '内容',
  `locked` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否锁定',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='意见反馈表';

INSERT INTO `py_menu` VALUES ('', '意见反馈', '13', 'admin', 'feedback', '*', '', '1', 'fa-cogs', '50', '1435324617', '1447831850');

CREATE TABLE `py_user_collection` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `position_id` int(11)  DEFAULT 0 COMMENT '职位id',
  `user_id` int(11)  NOT NULL  COMMENT '用户id',
  `locked` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否锁定',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `index_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='用户收藏表';

CREATE TABLE `py_user_position` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `position_id` int(11)  DEFAULT 0 COMMENT '职位id',
  `user_id` int(11)  NOT NULL  COMMENT '用户id',
  `locked` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否锁定',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `index_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='我看过的职位表';

CREATE TABLE `py_user_company` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `company_id` int(11)  DEFAULT 0 COMMENT '公司id',
  `user_id` int(11)  NOT NULL  COMMENT '用户id',
  `locked` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否锁定',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `index_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='看过我的企业表';

CREATE TABLE `py_company_collection` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `resume_id` int(11)  DEFAULT 0 COMMENT '简历id',
  `user_id` int(11)  NOT NULL  COMMENT '用户id',
  `locked` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否锁定',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `index_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='公司收藏表';


CREATE TABLE `py_company_position` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `company_id` int(11)  DEFAULT 0 COMMENT '公司id',
  `user_id` int(11)  NOT NULL  COMMENT '用户id',
  `latitude` decimal(12,8) DEFAULT NULL COMMENT '纬度',
  `longitude` decimal(12,8) DEFAULT NULL COMMENT '经度',
  `position_name` varchar(255) DEFAULT NULL COMMENT '职位名称',
  `position_tag` varchar(255) DEFAULT NULL COMMENT '职位名称tag',
  `place` varchar(255) DEFAULT NULL COMMENT '工作地点',
  `duty` text COMMENT '岗位职责',
  `salary` int(11) DEFAULT NULL COMMENT '招聘薪资tag_id',
  `experience` int(11) DEFAULT NULL COMMENT '工作经验tag_id',
  `education` int(11) DEFAULT NULL COMMENT '学历tag_id',
  `order` smallint(5)   DEFAULT '0'  COMMENT '推荐顺序',
  `locked` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否锁定',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `index_name` (`position_tag`,`position_name`,`place`),
  KEY `index_company` (`company_id`),
  KEY `index_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='公司职位表';

CREATE TABLE `py_user_resume` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `user_id` int(11)  NOT NULL  COMMENT '用户id',
  `position_name` varchar(255) DEFAULT NULL COMMENT '职位名称',
  `position_tag` varchar(255) DEFAULT NULL COMMENT '职位名称tag',
  `status` varchar(255) DEFAULT NULL COMMENT '在职状态',
  `tel` varchar(255) DEFAULT NULL COMMENT '联系方式',
  `email` varchar(255) DEFAULT NULL COMMENT '邮箱',
  `qq` varchar(255) DEFAULT NULL COMMENT 'QQ',
  `thumb` varchar(255) DEFAULT NULL COMMENT '头像',
  `realname` varchar(255) DEFAULT NULL COMMENT '真实姓名',
  `sex` tinyint(3) NOT NULL DEFAULT '0' COMMENT '性别1,男，2女',
  `birthday` varchar(255) DEFAULT NULL COMMENT '生日',
  `work` text COMMENT '工作经验',
  `schoole` text COMMENT '教育经历',
  `appraisal` text COMMENT '自我评价',
  `place` varchar(255) DEFAULT NULL COMMENT '工作地点',
  `salary` int(11) DEFAULT NULL COMMENT '招聘薪资tag_id',
  `experience` int(11) DEFAULT NULL COMMENT '工作经验tag_id',
  `education` int(11) DEFAULT NULL COMMENT '学历tag_id',
  `latitude` decimal(12,8) DEFAULT NULL COMMENT '纬度',
  `longitude` decimal(12,8) DEFAULT NULL COMMENT '经度',
  `order` smallint(5)   DEFAULT '0'  COMMENT '推荐顺序',
  `locked` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否锁定',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `index_name` (`position_tag`,`position_name`,`place`),
  KEY `index_user` (`user_id`,`realname`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='用户简历表';

INSERT INTO `py_menu` VALUES ('', '职位管理', '11', 'admin', 'companyPosition', '*', '', '1', 'fa-cogs', '50', '1435324617', '1447831850');
INSERT INTO `py_menu` VALUES ('', '简历管理', '12', 'admin', 'userResume', '*', '', '1', 'fa-cogs', '50', '1435324617', '1447831850');

CREATE TABLE `py_user_work` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `start_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `locked` tinyint(1) DEFAULT NULL,
  `resume_id` int(11) unsigned DEFAULT NULL COMMENT '简历id',
  `text` varchar(250) DEFAULT NULL COMMENT '职位名称',
  `company` varchar(250) DEFAULT NULL COMMENT '公司名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `py_user_school` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `start_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `locked` tinyint(1) DEFAULT NULL,
  `resume_id` int(11) unsigned DEFAULT NULL COMMENT '简历id',
  `text` varchar(250) DEFAULT NULL COMMENT '专业名称',
  `school` varchar(250) DEFAULT NULL COMMENT '学校名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `py_warrant` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `company_id` int(11) DEFAULT NULL COMMENT '公司idid',
  `level_surplus` int(11) DEFAULT '0' COMMENT '剩余',
  `level_text` varchar(255) DEFAULT NULL COMMENT '等级名称',
  `level_id` int(11) DEFAULT NULL COMMENT '等级id',
  `locked` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否锁定',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '公司用户id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='公司授权表';

CREATE TABLE `py_warrant_linked` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `company_id` int(11) DEFAULT NULL COMMENT '公司id',
  `resume_id` int(11) DEFAULT NULL COMMENT '简历id',
  `locked` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否锁定',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '公司用户id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='公司关联表';

CREATE TABLE `py_level` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `text` varchar(255) NOT NULL COMMENT '文本',
  `num` int(11) DEFAULT '0' COMMENT '数量',
  `price` int(11) DEFAULT NULL COMMENT '价格',
  `remark` text COMMENT '描述',
  `locked` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否锁定',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='公司关联表';

CREATE TABLE `py_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `text` varchar(255) NOT NULL COMMENT '文本(名称)',
  `product_id` int(11) NOT NULL COMMENT '关联商品id',
  `num` int(11) DEFAULT '0' COMMENT '数量',
  `price` int(11) DEFAULT NULL COMMENT '价格',
  `pay_type` varchar(255) NOT NULL COMMENT '支付方式',
  `pay_status` tinyint(3) DEFAULT '0' COMMENT '支付状态0.未付款|.已付款',
  `remark` text COMMENT '描述',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '公司用户id',
  `locked` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否锁定',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='公司关联表';

