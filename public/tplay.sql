-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2019 �?06 �?18 �?18:39
-- 服务器版本: 5.5.47
-- PHP 版本: 5.5.30

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `tplay`
--

-- --------------------------------------------------------

--
-- 表的结构 `tplay_admin`
--

CREATE TABLE IF NOT EXISTS `tplay_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(20) DEFAULT NULL COMMENT '昵称',
  `name` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `thumb` int(11) NOT NULL DEFAULT '1' COMMENT '管理员头像',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '修改时间',
  `login_time` int(11) DEFAULT NULL COMMENT '最后登录时间',
  `login_ip` varchar(100) DEFAULT NULL COMMENT '最后登录ip',
  `admin_cate_id` int(2) NOT NULL DEFAULT '1' COMMENT '管理员分组',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE,
  KEY `admin_cate_id` (`admin_cate_id`) USING BTREE,
  KEY `nickname` (`nickname`) USING BTREE,
  KEY `create_time` (`create_time`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- 转存表中的数据 `tplay_admin`
--

INSERT INTO `tplay_admin` (`id`, `nickname`, `name`, `password`, `thumb`, `create_time`, `update_time`, `login_time`, `login_ip`, `admin_cate_id`) VALUES
(1, 'admin', 'admin', '153441086ce450f9b62643cf4830698e', 2, 1510885948, 1560492763, 1560829097, '127.0.0.1', 1),
(16, 'heze', 'heze_admin', '153441086ce450f9b62643cf4830698e', 5, 1560493985, 1560493985, 1560828860, '127.0.0.1', 20);

-- --------------------------------------------------------

--
-- 表的结构 `tplay_admin_cate`
--

CREATE TABLE IF NOT EXISTS `tplay_admin_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `permissions` text COMMENT '权限菜单',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `desc` text COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE,
  KEY `name` (`name`) USING BTREE,
  KEY `create_time` (`create_time`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- 转存表中的数据 `tplay_admin_cate`
--

INSERT INTO `tplay_admin_cate` (`id`, `name`, `permissions`, `create_time`, `update_time`, `desc`) VALUES
(1, '超级管理员', '4,5,6,7,8,11,13,14,16,17,19,20,21,25,26,28,29,34,35,37,38,39,40,42,43,44,45,47,48', 0, 1517022009, '超级管理员，拥有最高权限！'),
(20, '普通管理员', '6,7,8,34,35,37,38,39,40,42,43,44,45,47,48', 1560493824, 1560494143, '普通管理员');

-- --------------------------------------------------------

--
-- 表的结构 `tplay_admin_log`
--

CREATE TABLE IF NOT EXISTS `tplay_admin_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_menu_id` int(11) NOT NULL COMMENT '操作菜单id',
  `admin_id` int(11) NOT NULL COMMENT '操作者id',
  `ip` varchar(100) DEFAULT NULL COMMENT '操作ip',
  `operation_id` varchar(200) DEFAULT NULL COMMENT '操作关联id',
  `create_time` int(11) NOT NULL COMMENT '操作时间',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE,
  KEY `admin_id` (`admin_id`) USING BTREE,
  KEY `create_time` (`create_time`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

--
-- 转存表中的数据 `tplay_admin_log`
--

INSERT INTO `tplay_admin_log` (`id`, `admin_menu_id`, `admin_id`, `ip`, `operation_id`, `create_time`) VALUES
(1, 50, 1, '127.0.0.1', '', 1560492491),
(2, 49, 1, '127.0.0.1', '2', 1560492578),
(3, 7, 1, '127.0.0.1', '1', 1560492580),
(4, 8, 1, '127.0.0.1', '', 1560492616),
(5, 50, 1, '127.0.0.1', '', 1560492639),
(6, 11, 1, '127.0.0.1', '', 1560492690),
(7, 11, 1, '127.0.0.1', '', 1560492711),
(8, 25, 1, '127.0.0.1', '1', 1560492751),
(9, 7, 1, '127.0.0.1', '1', 1560492763),
(10, 49, 1, '127.0.0.1', '3', 1560492809),
(11, 4, 1, '127.0.0.1', '52', 1560493222),
(12, 4, 1, '127.0.0.1', '52', 1560493284),
(13, 28, 1, '127.0.0.1', '20', 1560493824),
(14, 49, 1, '127.0.0.1', '4', 1560493926),
(15, 49, 1, '127.0.0.1', '5', 1560493938),
(16, 25, 1, '127.0.0.1', '16', 1560493985),
(17, 50, 16, '127.0.0.1', '', 1560494012),
(18, 50, 1, '127.0.0.1', '', 1560494058),
(19, 28, 1, '127.0.0.1', '20', 1560494143),
(20, 49, 16, '127.0.0.1', '6', 1560494207),
(21, 49, 16, '127.0.0.1', '7', 1560494213),
(22, 50, 16, '127.0.0.1', '', 1560494361),
(23, 50, 1, '127.0.0.1', '', 1560494573),
(24, 4, 1, '127.0.0.1', '53', 1560494809),
(25, 4, 1, '127.0.0.1', '54', 1560494901),
(26, 4, 1, '127.0.0.1', '54', 1560494921),
(27, 4, 1, '127.0.0.1', '54', 1560494970),
(28, 4, 1, '127.0.0.1', '54', 1560495065),
(29, 4, 1, '127.0.0.1', '55', 1560495379),
(30, 50, 1, '127.0.0.1', '', 1560739256),
(31, 50, 1, '127.0.0.1', '', 1560748907),
(32, 50, 1, '127.0.0.1', '', 1560749012),
(33, 4, 1, '127.0.0.1', '55', 1560761869),
(34, 4, 1, '127.0.0.1', '55', 1560761901),
(35, 42, 1, '127.0.0.1', '7', 1560767939),
(36, 50, 1, '127.0.0.1', '', 1560822311),
(37, 49, 1, '127.0.0.1', '8', 1560827102),
(38, 49, 1, '127.0.0.1', '9', 1560827120),
(39, 50, 16, '127.0.0.1', '', 1560828860),
(40, 50, 1, '127.0.0.1', '', 1560829097);

-- --------------------------------------------------------

--
-- 表的结构 `tplay_admin_menu`
--

CREATE TABLE IF NOT EXISTS `tplay_admin_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `module` varchar(50) NOT NULL COMMENT '模块',
  `controller` varchar(100) NOT NULL COMMENT '控制器',
  `function` varchar(100) NOT NULL COMMENT '方法',
  `parameter` varchar(50) DEFAULT NULL COMMENT '参数',
  `description` varchar(250) DEFAULT NULL COMMENT '描述',
  `is_display` int(1) NOT NULL DEFAULT '1' COMMENT '1显示在左侧菜单2只作为节点',
  `type` int(1) NOT NULL DEFAULT '1' COMMENT '1权限节点2普通节点',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '上级菜单0为顶级菜单',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `icon` varchar(100) DEFAULT NULL COMMENT '图标',
  `is_open` int(1) NOT NULL DEFAULT '0' COMMENT '0默认闭合1默认展开',
  `orders` int(11) NOT NULL DEFAULT '0' COMMENT '排序值，越小越靠前',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE,
  KEY `module` (`module`) USING BTREE,
  KEY `controller` (`controller`) USING BTREE,
  KEY `function` (`function`) USING BTREE,
  KEY `is_display` (`is_display`) USING BTREE,
  KEY `type` (`type`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='系统菜单表' AUTO_INCREMENT=56 ;

--
-- 转存表中的数据 `tplay_admin_menu`
--

INSERT INTO `tplay_admin_menu` (`id`, `name`, `module`, `controller`, `function`, `parameter`, `description`, `is_display`, `type`, `pid`, `create_time`, `update_time`, `icon`, `is_open`, `orders`) VALUES
(1, '系统', '', '', '', '', '系统设置。', 1, 2, 0, 0, 1517015748, 'fa-cog', 1, 0),
(2, '菜单', '', '', '', '', '菜单管理。', 1, 2, 1, 0, 1517015764, 'fa-paw', 0, 0),
(51, '系统菜单排序', 'admin', 'menu', 'orders', '', '系统菜单排序。', 2, 1, 3, 1517562047, 1517562047, '', 0, 0),
(3, '系统菜单', 'admin', 'menu', 'index', NULL, '系统菜单管理', 1, 2, 2, 0, 0, 'fa-share-alt', 0, 0),
(4, '新增/修改系统菜单', 'admin', 'menu', 'publish', '', '新增/修改系统菜单.', 2, 1, 3, 1516948769, 1516948769, '', 0, 0),
(5, '删除系统菜单', 'admin', 'menu', 'delete', '', '删除系统菜单。', 2, 1, 3, 1516948857, 1516948857, '', 0, 0),
(6, '个人', '', '', '', '', '个人信息管理。', 1, 1, 1, 1516949308, 1517021986, 'fa-user', 0, 0),
(7, '个人信息', 'admin', 'admin', 'personal', '', '个人信息修改。', 1, 1, 6, 1516949435, 1516949435, 'fa-user', 0, 0),
(8, '修改密码', 'admin', 'admin', 'editpassword', '', '管理员修改个人密码。', 1, 1, 6, 1516949702, 1517619887, 'fa-unlock-alt', 0, 0),
(9, '设置', '', '', '', '', '系统相关设置。', 1, 2, 1, 1516949853, 1517015878, 'fa-cog', 0, 0),
(10, '网站设置', 'admin', 'webconfig', 'index', '', '网站相关设置首页。', 1, 2, 9, 1516949994, 1516949994, 'fa-bullseye', 0, 0),
(11, '修改网站设置', 'admin', 'webconfig', 'publish', '', '修改网站设置。', 2, 1, 10, 1516950047, 1516950047, '', 0, 0),
(12, '邮件设置', 'admin', 'emailconfig', 'index', '', '邮件配置首页。', 1, 2, 9, 1516950129, 1516950129, 'fa-envelope', 0, 0),
(13, '修改邮件设置', 'admin', 'emailconfig', 'publish', '', '修改邮件设置。', 2, 1, 12, 1516950215, 1516950215, '', 0, 0),
(14, '发送测试邮件', 'admin', 'emailconfig', 'mailto', '', '发送测试邮件。', 2, 1, 12, 1516950295, 1516950295, '', 0, 0),
(15, '短信设置', 'admin', 'smsconfig', 'index', '', '短信设置首页。', 1, 2, 9, 1516950394, 1516950394, 'fa-comments', 0, 0),
(16, '修改短信设置', 'admin', 'smsconfig', 'publish', '', '修改短信设置。', 2, 1, 15, 1516950447, 1516950447, '', 0, 0),
(17, '发送测试短信', 'admin', 'smsconfig', 'smsto', '', '发送测试短信。', 2, 1, 15, 1516950483, 1516950483, '', 0, 0),
(18, 'URL 设置', 'admin', 'urlsconfig', 'index', '', 'url 设置。', 1, 2, 9, 1516950738, 1516950804, 'fa-code-fork', 0, 0),
(19, '新增/修改url设置', 'admin', 'urlsconfig', 'publish', '', '新增/修改url设置。', 2, 1, 18, 1516950850, 1516950850, '', 0, 0),
(20, '启用/禁用url美化', 'admin', 'urlsconfig', 'status', '', '启用/禁用url美化。', 2, 1, 18, 1516950909, 1516950909, '', 0, 0),
(21, ' 删除url美化规则', 'admin', 'urlsconfig', 'delete', '', ' 删除url美化规则。', 2, 1, 18, 1516950941, 1516950941, '', 0, 0),
(22, '会员', '', '', '', '', '会员管理。', 1, 2, 0, 1516950991, 1517015810, 'fa-users', 0, 0),
(23, '管理员', '', '', '', '', '系统管理员管理。', 1, 2, 22, 1516951071, 1517015819, 'fa-user', 0, 0),
(24, '管理员', 'admin', 'admin', 'index', '', '系统管理员列表。', 1, 2, 23, 1516951163, 1516951163, 'fa-user', 0, 0),
(25, '新增/修改管理员', 'admin', 'admin', 'publish', '', '新增/修改系统管理员。', 2, 1, 24, 1516951224, 1516951224, '', 0, 0),
(26, '删除管理员', 'admin', 'admin', 'delete', '', '删除管理员。', 2, 1, 24, 1516951253, 1516951253, '', 0, 0),
(27, '权限组', 'admin', 'admin', 'admincate', '', '权限分组。', 1, 2, 23, 1516951353, 1517018168, 'fa-dot-circle-o', 0, 0),
(28, '新增/修改权限组', 'admin', 'admin', 'admincatepublish', '', '新增/修改权限组。', 2, 1, 27, 1516951483, 1516951483, '', 0, 0),
(29, '删除权限组', 'admin', 'admin', 'admincatedelete', '', '删除权限组。', 2, 1, 27, 1516951515, 1516951515, '', 0, 0),
(30, '操作日志', 'admin', 'admin', 'log', '', '系统管理员操作日志。', 1, 2, 23, 1516951754, 1517018196, 'fa-pencil', 0, 0),
(31, '内容', '', '', '', '', '内容管理。', 1, 2, 0, 1516952262, 1517015835, 'fa-th-large', 0, 0),
(32, '文章', '', '', '', '', '文章相关管理。', 1, 2, 31, 1516952698, 1517015846, 'fa-bookmark', 0, 0),
(33, '分类', 'admin', 'articlecate', 'index', '', '文章分类管理。', 1, 2, 32, 1516952856, 1516952856, 'fa-tag', 0, 0),
(34, '新增/修改文章分类', 'admin', 'articlecate', 'publish', '', '新增/修改文章分类。', 2, 1, 33, 1516952896, 1516952896, '', 0, 0),
(35, '删除文章分类', 'admin', 'articlecate', 'delete', '', '删除文章分类。', 2, 1, 33, 1516952942, 1516952942, '', 0, 0),
(36, '文章', 'admin', 'article', 'index', '', '文章管理。', 1, 2, 32, 1516953011, 1516953028, 'fa-bookmark', 0, 0),
(37, '新增/修改文章', 'admin', 'article', 'publish', '', '新增/修改文章。', 2, 1, 36, 1516953056, 1516953056, '', 0, 0),
(38, '审核/拒绝文章', 'admin', 'article', 'status', '', '审核/拒绝文章。', 2, 1, 36, 1516953113, 1516953113, '', 0, 0),
(39, '置顶/取消置顶文章', 'admin', 'article', 'is_top', '', '置顶/取消置顶文章。', 2, 1, 36, 1516953162, 1516953162, '', 0, 0),
(40, '删除文章', 'admin', 'article', 'delete', '', '删除文章。', 2, 1, 36, 1516953183, 1516953183, '', 0, 0),
(41, '附件', 'admin', 'attachment', 'index', '', '附件管理。', 1, 2, 31, 1516953306, 1516953306, 'fa-cube', 0, 0),
(42, '附件审核', 'admin', 'attachment', 'audit', '', '附件审核。', 2, 1, 41, 1516953359, 1516953440, '', 0, 0),
(43, '附件上传', 'admin', 'attachment', 'upload', '', '附件上传。', 2, 1, 41, 1516953392, 1516953392, '', 0, 0),
(44, '附件下载', 'admin', 'attachment', 'download', '', '附件下载。', 2, 1, 41, 1516953430, 1516953430, '', 0, 0),
(45, '附件删除', 'admin', 'attachment', 'delete', '', '附件删除。', 2, 1, 41, 1516953477, 1516953477, '', 0, 0),
(46, '留言', 'admin', 'tomessages', 'index', '', '留言管理。', 1, 2, 31, 1516953526, 1516953526, 'fa-comments', 0, 0),
(47, '留言处理', 'admin', 'tomessages', 'mark', '', '留言处理。', 2, 1, 46, 1516953605, 1516953605, '', 0, 0),
(48, '留言删除', 'admin', 'tomessages', 'delete', '', '留言删除。', 2, 1, 46, 1516953648, 1516953648, '', 0, 0),
(49, '图片上传', 'admin', 'common', 'upload', '', '图片上传。', 2, 2, 0, 1516954491, 1516954491, '', 0, 0),
(50, '管理员登录', 'admin', 'common', 'login', '', '管理员登录。', 2, 2, 0, 1516954517, 1516954517, '', 0, 0),
(52, '数据分析', '', '', '', '', '数据分析管理。', 1, 2, 31, 1560493222, 1560493284, 'fa-area-chart ', 0, 0),
(53, '文章数据', '', '', '', '', '文章数据分析', 1, 2, 52, 1560494809, 1560494809, 'fa-file-text', 0, 0),
(54, '报名数据', '', '', '', '', '报名数据分析', 1, 2, 52, 1560494901, 1560495065, 'fa-address-book ', 0, 0),
(55, '报名列表', 'admin', 'register', 'index', '', '报名列表', 1, 2, 31, 1560495379, 1560761901, 'fa-cubes ', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `tplay_article`
--

CREATE TABLE IF NOT EXISTS `tplay_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `article_cate_id` int(11) NOT NULL,
  `thumb` int(11) DEFAULT NULL,
  `content` text,
  `admin_id` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `edit_admin_id` int(11) NOT NULL COMMENT '最后修改人',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '0待审核1已审核',
  `is_top` int(1) NOT NULL DEFAULT '0' COMMENT '1置顶0普通',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE,
  KEY `status` (`status`) USING BTREE,
  KEY `is_top` (`is_top`) USING BTREE,
  KEY `article_cate_id` (`article_cate_id`) USING BTREE,
  KEY `admin_id` (`admin_id`) USING BTREE,
  KEY `create_time` (`create_time`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `tplay_article_cate`
--

CREATE TABLE IF NOT EXISTS `tplay_article_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `tag` varchar(250) DEFAULT NULL COMMENT '关键词',
  `description` varchar(250) DEFAULT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `pid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `tplay_attachment`
--

CREATE TABLE IF NOT EXISTS `tplay_attachment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module` char(15) NOT NULL DEFAULT '' COMMENT '所属模块',
  `filename` char(50) NOT NULL DEFAULT '' COMMENT '文件名',
  `filepath` char(200) NOT NULL DEFAULT '' COMMENT '文件路径+文件名',
  `filesize` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `fileext` char(10) NOT NULL DEFAULT '' COMMENT '文件后缀',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `uploadip` char(15) NOT NULL DEFAULT '' COMMENT '上传IP',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0未审核1已审核-1不通过',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `admin_id` int(11) NOT NULL COMMENT '审核者id',
  `audit_time` int(11) NOT NULL COMMENT '审核时间',
  `use` varchar(200) DEFAULT NULL COMMENT '用处',
  `download` int(11) NOT NULL DEFAULT '0' COMMENT '下载量',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE,
  KEY `status` (`status`) USING BTREE,
  KEY `filename` (`filename`) USING BTREE,
  KEY `create_time` (`create_time`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='附件表' AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `tplay_attachment`
--

INSERT INTO `tplay_attachment` (`id`, `module`, `filename`, `filepath`, `filesize`, `fileext`, `user_id`, `uploadip`, `status`, `create_time`, `admin_id`, `audit_time`, `use`, `download`) VALUES
(1, 'admin', '79811855a6c06de53047471c4ff82a36.jpg', '\\uploads\\admin\\admin_thumb\\20180104\\79811855a6c06de53047471c4ff82a36.jpg', 13781, 'jpg', 1, '127.0.0.1', 1, 1515046060, 1, 1515046060, 'admin_thumb', 0),
(2, 'admin', 'c1313819fd18690f364394b26d0c35e2.png', '\\uploads\\admin\\admin_thumb\\20190614\\c1313819fd18690f364394b26d0c35e2.png', 9704, 'png', 1, '127.0.0.1', 1, 1560492578, 1, 1560492578, 'admin_thumb', 0),
(3, 'admin', '97b9af50166460d110fb7faa2eec0513.png', '\\uploads\\admin\\article_thumb\\20190614\\97b9af50166460d110fb7faa2eec0513.png', 9704, 'png', 1, '127.0.0.1', 1, 1560492809, 1, 1560492809, 'article_thumb', 0),
(4, 'admin', 'b241afc39addb75261efcba1a0d971ae.jpg', '\\uploads\\admin\\admin_thumb\\20190614\\b241afc39addb75261efcba1a0d971ae.jpg', 43008, 'jpg', 1, '127.0.0.1', 1, 1560493926, 1, 1560493926, 'admin_thumb', 0),
(5, 'admin', '29363d0894f7f5b10b1fb45acef19ee6.jpg', '\\uploads\\admin\\admin_thumb\\20190614\\29363d0894f7f5b10b1fb45acef19ee6.jpg', 13280, 'jpg', 1, '127.0.0.1', 1, 1560493938, 1, 1560493938, 'admin_thumb', 0),
(6, 'admin', 'b6fa434c649fc18975547dc2db5a25f4.jpg', '\\uploads\\admin\\article_thumb\\20190614\\b6fa434c649fc18975547dc2db5a25f4.jpg', 349100, 'jpg', 16, '127.0.0.1', 1, 1560494207, 16, 1560494207, 'article_thumb', 0),
(7, 'admin', 'db42e32a847da7db13065231d88665b5.gif', '\\uploads\\admin\\article_thumb\\20190614\\db42e32a847da7db13065231d88665b5.gif', 22182, 'gif', 16, '127.0.0.1', 1, 1560494213, 0, 1560767939, 'article_thumb', 0),
(8, 'admin', '287208de4388609d34b448490d07c0f6.jpg', '\\uploads\\admin\\admin_thumb\\20190618\\287208de4388609d34b448490d07c0f6.jpg', 213341, 'jpg', 1, '127.0.0.1', 1, 1560827102, 1, 1560827102, 'admin_thumb', 0),
(9, 'admin', 'f4bf1d56a2b122137029b5712dd4d209.jpg', '\\uploads\\admin\\admin_thumb\\20190618\\f4bf1d56a2b122137029b5712dd4d209.jpg', 299148, 'jpg', 1, '127.0.0.1', 1, 1560827120, 1, 1560827120, 'admin_thumb', 0);

-- --------------------------------------------------------

--
-- 表的结构 `tplay_emailconfig`
--

CREATE TABLE IF NOT EXISTS `tplay_emailconfig` (
  `email` varchar(5) NOT NULL COMMENT '邮箱配置标识',
  `from_email` varchar(50) NOT NULL COMMENT '邮件来源也就是邮件地址',
  `from_name` varchar(50) NOT NULL,
  `smtp` varchar(50) NOT NULL COMMENT '邮箱smtp服务器',
  `username` varchar(100) NOT NULL COMMENT '邮箱账号',
  `password` varchar(100) NOT NULL COMMENT '邮箱密码',
  `title` varchar(200) NOT NULL COMMENT '邮件标题',
  `content` text NOT NULL COMMENT '邮件模板',
  KEY `email` (`email`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tplay_emailconfig`
--

INSERT INTO `tplay_emailconfig` (`email`, `from_email`, `from_name`, `smtp`, `username`, `password`, `title`, `content`) VALUES
('email', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `tplay_messages`
--

CREATE TABLE IF NOT EXISTS `tplay_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `create_time` int(11) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `is_look` int(1) NOT NULL DEFAULT '0' COMMENT '0未读1已读',
  `message` text NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE,
  KEY `is_look` (`is_look`) USING BTREE,
  KEY `create_time` (`create_time`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `tplay_question`
--

CREATE TABLE IF NOT EXISTS `tplay_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '流水id',
  `question_title` varchar(100) NOT NULL COMMENT '问卷调查title',
  `question_desc` varchar(255) DEFAULT NULL COMMENT '问卷调查描述',
  `question_config` text NOT NULL COMMENT '问卷调查配置信息',
  `question_lastdesc` varchar(200) NOT NULL COMMENT '表单末尾插入文本内容',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime NOT NULL COMMENT '更新时间',
  `user_id` int(11) DEFAULT NULL COMMENT '编辑信息用户id',
  `ip` varchar(50) NOT NULL COMMENT '操作ip',
  `jump_type` int(11) NOT NULL COMMENT '提交后跳转方式（1：显示文字内容；2：跳转链接）',
  `jump_text` varchar(200) DEFAULT NULL COMMENT '提交跳转显示文字',
  `jump_href` varchar(200) DEFAULT NULL COMMENT '提交跳转链接',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `tplay_question`
--

INSERT INTO `tplay_question` (`id`, `question_title`, `question_desc`, `question_config`, `question_lastdesc`, `create_time`, `update_time`, `user_id`, `ip`, `jump_type`, `jump_text`, `jump_href`) VALUES
(1, 'ACCA学前评估', 'ACCA学前评估顾问通过你的问卷选择进行评估，评估内容包括：英语水平是否适合学习ACCA、未来ACCA学习进度情况、ACCA给你带来的影响，并提供适当建议。', '', '', '2019-06-18 11:00:18', '2019-06-18 16:59:06', 16, '127.0.0.1', 1, '您的答卷已经提交，感谢您的参与！', ''),
(2, ' ACCA学习资料领取', '温馨提示：您提交信息之后，将自动跳转页面获取百度云盘链接，自行下载即可。\r\n\r\n*隐私申明：个人信息仅用于本测试，我们在未征得您事先同意的情况下，不会向第三方提供或泄露您的任何个人信息。', '', '', '2019-06-18 11:10:33', '2019-06-18 11:10:33', 1, '127.0.0.1', 0, '您的答卷已经提交，感谢您的参与！\r\n链接: https://pan.baidu.com/s/1z1kuXta5cts7ZmC51UrxnA    提取码: m3af', ''),
(3, '管理会计师CMA报考条件快速测试通道', '美国注册管理会计师简称"CMA"，它是目前全球管理会计及财务管理领域最权威的资格认证。在全球120个国家、200家地方分会中拥有超过68,000名会员，在中国的会员数超过10000名。拥有CMA，不仅代表其具备完整会计及财务相关领域知识，也表明了具备高度专业能力来分析企业内部经营状况、协助管理当局、参与集团财务管理、拟定未来策略、执行流程优化工作等。', '', '温馨提示：您提交信息之后，认证部老师将会在1个工作日内将结果发送给您，为确保结果准确，请如实填写。\r\n\r\n*隐私申明：个人信息仅用于本测试，我们在未征得您事先同意的情况下，不会向第三方提供或泄露您的任何个人信息。', '2019-06-18 11:25:56', '2019-06-18 11:25:56', 1, '127.0.0.1', 0, '您的答卷已经提交，感谢您的参与！', '');

-- --------------------------------------------------------

--
-- 表的结构 `tplay_question_answer`
--

CREATE TABLE IF NOT EXISTS `tplay_question_answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '流水id',
  `question_id` varchar(255) NOT NULL COMMENT '问卷配置id',
  `answer_datas` text NOT NULL COMMENT '问卷回答内容 json 字串',
  `source` varchar(30) NOT NULL COMMENT '信息收集来源',
  `create_time` datetime NOT NULL COMMENT '提交时间',
  `total_time` int(11) NOT NULL COMMENT '消耗时长',
  `ip` varchar(50) NOT NULL COMMENT '报名ip',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- 转存表中的数据 `tplay_question_answer`
--

INSERT INTO `tplay_question_answer` (`id`, `question_id`, `answer_datas`, `source`, `create_time`, `total_time`, `ip`) VALUES
(1, 'question_02', '{"question_name_01":"\\u5f20\\u4e09san","question_name_02":"17610900163","question_name_03":"2929006594@qq.com","question_name_04":"fs15535256683"}', 'question_02', '2019-06-17 16:18:22', 60, '127.0.0.1'),
(2, 'question_01', '{"question_name_01":"1","question_name_02":"2","question_name_03":"\\u5f20\\u4e09","question_name_04":"15803486478","question_name_05":"2929006594@qq.com"}', 'question_01', '2019-06-17 16:18:31', 60, '124.126.1.197'),
(3, 'question_01', '{"question_name_01":"2","question_name_02":"2","question_name_03":"\\u674e\\u56db","question_name_04":"15803486478","question_name_05":"2929006594@qq.com"}', 'question_01', '2019-06-17 16:18:49', 60, '127.0.0.1'),
(4, 'question_01', '{"question_name_01":"2","question_name_02":"2","question_name_03":"\\u738b\\u4e94","question_name_04":"15803486478","question_name_05":"2929006594@qq.com"}', 'question_01', '2019-06-17 16:18:54', 60, '127.0.0.1'),
(5, 'question_02', '{"question_name_01":"\\u674e\\u56dbsi","question_name_02":"17610900163","question_name_03":"2929006594@qq.com","question_name_04":"fs15535256683"}', 'question_02', '2019-06-17 16:19:03', 60, '127.0.0.1'),
(6, 'question_02', '{"question_name_01":"\\u738b\\u4e94wu","question_name_02":"17610900163","question_name_03":"2929006594@qq.com","question_name_04":"fs15535256683"}', 'question_02', '2019-06-17 16:19:11', 60, '127.0.0.1'),
(7, 'question_01', '{"question_name_01":"2","question_name_02":"2","question_name_03":"\\u5218\\u516d","question_name_04":"15803486478","question_name_05":"2929006594@qq.com"}', 'question_01', '2019-06-17 16:19:25', 60, '127.0.0.1'),
(8, 'question_02', '{"question_name_01":"\\u5218\\u516dliu","question_name_02":"17610900163","question_name_03":"2929006594@qq.com","question_name_04":"fs15535256683"}', 'question_02', '2019-06-17 16:19:34', 60, '127.0.0.1'),
(9, 'question_03', '{"question_name_01":"\\u5f20\\u4e09CMA","question_name_02":"2","question_name_03":"2","question_name_04":"fs15535256683","question_name_05":"17610900163","question_name_06":"2929006594@qq.com"}', 'question_02', '2019-06-17 16:28:32', 80, '127.0.0.1'),
(10, 'question_03', '{"question_name_01":"\\u674e\\u56dbCMA","question_name_02":"3","question_name_03":"2","question_name_04":"fs15535256683","question_name_05":"17610900163","question_name_06":"2929006594@qq.com"}', 'question_02', '2019-06-17 16:28:47', 80, '127.0.0.1'),
(11, 'question_03', '{"question_name_01":"\\u738b\\u4e94CMA","question_name_02":"3","question_name_03":"3","question_name_04":"fs15535256683","question_name_05":"17610900163","question_name_06":"2929006594@qq.com"}', 'question_02', '2019-06-17 16:29:01', 80, '127.0.0.1'),
(12, 'question_03', '{"question_name_01":"\\u5218\\u516dCMA","question_name_02":"3","question_name_03":"3","question_name_04":"fs15535256683","question_name_05":"17610900163","question_name_06":"2929006594@qq.com"}', 'question_02', '2019-06-17 16:40:05', 80, '127.0.0.1'),
(13, 'question_03', '{"question_name_01":"\\u7530\\u4e03CMA","question_name_02":"2","question_name_03":"3","question_name_04":"fs15535256683","question_name_05":"17610900163","question_name_06":"2929006594@qq.com"}', 'question_02', '2019-06-17 16:40:19', 80, '127.0.0.1'),
(14, 'question_03', '{"question_name_01":"\\u516b\\u65d7CMA","question_name_02":"2","question_name_03":"3","question_name_04":"fs15535256683","question_name_05":"17610900163","question_name_06":"2929006594@qq.com"}', 'question_02', '2019-06-17 16:40:32', 80, '127.0.0.1'),
(15, 'question_02', '{"question_name_01":"\\u7530\\u4e03liu","question_name_02":"17610900163","question_name_03":"2929006594@qq.com","question_name_04":"fs15535256683"}', 'question_02', '2019-06-17 16:40:40', 40, '127.0.0.1'),
(16, 'question_02', '{"question_name_01":"\\u516b\\u65d7liu","question_name_02":"17610900163","question_name_03":"2929006594@qq.com","question_name_04":"fs15535256683"}', 'question_02', '2019-06-17 16:40:47', 40, '127.0.0.1'),
(17, 'question_01', '{"question_name_01":"2","question_name_02":"2","question_name_03":"\\u7530\\u4e03","question_name_04":"15803486478","question_name_05":"2929006594@qq.com"}', 'question_01', '2019-06-17 16:40:57', 60, '127.0.0.1'),
(18, 'question_01', '{"question_name_01":"2","question_name_02":"2","question_name_03":"\\u516b\\u65d7","question_name_04":"15803486478","question_name_05":"2929006594@qq.com"}', 'question_01', '2019-06-17 16:41:02', 60, '127.0.0.1');

-- --------------------------------------------------------

--
-- 表的结构 `tplay_smsconfig`
--

CREATE TABLE IF NOT EXISTS `tplay_smsconfig` (
  `sms` varchar(10) NOT NULL DEFAULT 'sms' COMMENT '标识',
  `appkey` varchar(200) NOT NULL,
  `secretkey` varchar(200) NOT NULL,
  `type` varchar(100) DEFAULT 'normal' COMMENT '短信类型',
  `name` varchar(100) NOT NULL COMMENT '短信签名',
  `code` varchar(100) NOT NULL COMMENT '短信模板ID',
  `content` text NOT NULL COMMENT '短信默认模板',
  KEY `sms` (`sms`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tplay_smsconfig`
--

INSERT INTO `tplay_smsconfig` (`sms`, `appkey`, `secretkey`, `type`, `name`, `code`, `content`) VALUES
('sms', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `tplay_urlconfig`
--

CREATE TABLE IF NOT EXISTS `tplay_urlconfig` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aliases` varchar(200) NOT NULL COMMENT '想要设置的别名',
  `url` varchar(200) NOT NULL COMMENT '原url结构',
  `desc` text COMMENT '备注',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '0禁用1使用',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE,
  KEY `status` (`status`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `tplay_urlconfig`
--

INSERT INTO `tplay_urlconfig` (`id`, `aliases`, `url`, `desc`, `status`, `create_time`, `update_time`) VALUES
(1, 'admin_login', 'admin/common/login', '后台登录地址。', 0, 1517621629, 1517621629);

-- --------------------------------------------------------

--
-- 表的结构 `tplay_webconfig`
--

CREATE TABLE IF NOT EXISTS `tplay_webconfig` (
  `web` varchar(20) NOT NULL COMMENT '网站配置标识',
  `name` varchar(200) NOT NULL COMMENT '网站名称',
  `keywords` text COMMENT '关键词',
  `desc` text COMMENT '描述',
  `is_log` int(1) NOT NULL DEFAULT '1' COMMENT '1开启日志0关闭',
  `file_type` varchar(200) DEFAULT NULL COMMENT '允许上传的类型',
  `file_size` bigint(20) DEFAULT NULL COMMENT '允许上传的最大值',
  `statistics` text COMMENT '统计代码',
  `black_ip` text COMMENT 'ip黑名单',
  `url_suffix` varchar(20) DEFAULT NULL COMMENT 'url伪静态后缀',
  KEY `web` (`web`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tplay_webconfig`
--

INSERT INTO `tplay_webconfig` (`web`, `name`, `keywords`, `desc`, `is_log`, `file_type`, `file_size`, `statistics`, `black_ip`, `url_suffix`) VALUES
('web', 'Tplay后台管理框架', 'Tplay,后台管理,thinkphp5,layui', 'Tplay是一款基于ThinkPHP5.0.12 + layui2.2.45 + ECharts + Mysql开发的后台管理框架，集成了一般应用所必须的基础性功能，为开发者节省大量的时间。', 1, 'jpg,png,gif,mp4,zip,jpeg', 500, '', '', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `tplay_wx_access_token`
--

CREATE TABLE IF NOT EXISTS `tplay_wx_access_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `access_token` varchar(255) NOT NULL COMMENT 'access_token',
  `refresh_token` varchar(255) NOT NULL COMMENT '刷新获取access_token',
  `ticket` varchar(255) NOT NULL COMMENT 'jssdk_ticket',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `cut_time` datetime NOT NULL COMMENT '到期时间',
  `status` int(11) NOT NULL COMMENT 'access_token 状态（1：普通token；2：授权token；3：js_token）',
  `openid` varchar(100) NOT NULL COMMENT '用户openid',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=155 ;

--
-- 转存表中的数据 `tplay_wx_access_token`
--

INSERT INTO `tplay_wx_access_token` (`id`, `access_token`, `refresh_token`, `ticket`, `create_time`, `cut_time`, `status`, `openid`) VALUES
(154, '22_dNdvzayOS2czsAhswYi26JYFOIEXqRzRLiICFThRUEIKIYs8SZSzgPR2bzk_2YwIeSKXfcJeSnVA8f0zUGSLnF4PD7w63mIETnwYfckhTi7VaIXv-CdchlGc_wMBQWeABATIO', '', '', '2019-06-14 17:07:03', '2019-06-14 19:07:03', 4, '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
