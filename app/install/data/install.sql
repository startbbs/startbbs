-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2018 �?03 �?16 �?12:57
-- 服务器版本: 5.5.53
-- PHP 版本: 5.6.27

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `startbbs`
--

-- --------------------------------------------------------

--
-- 表的结构 `stb_article`
--

DROP TABLE IF EXISTS `stb_article`;
CREATE TABLE IF NOT EXISTS `stb_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章ID',
  `cid` smallint(5) unsigned NOT NULL COMMENT '分类ID',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `introduction` varchar(255) DEFAULT '' COMMENT '简介',
  `content` longtext COMMENT '内容',
  `author` varchar(20) DEFAULT '' COMMENT '作者',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0 待审核  1 审核',
  `reading` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '阅读量',
  `thumb` varchar(255) DEFAULT '' COMMENT '缩略图',
  `photo` text COMMENT '图集',
  `is_top` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否置顶  0 不置顶  1 置顶',
  `is_recommend` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否推荐  0 不推荐  1 推荐',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `publish_time` datetime NOT NULL COMMENT '发布时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文章表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `stb_article_category`
--

DROP TABLE IF EXISTS `stb_article_category`;
CREATE TABLE IF NOT EXISTS `stb_article_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `alias` varchar(50) DEFAULT '' COMMENT '导航别名',
  `content` longtext COMMENT '分类内容',
  `thumb` varchar(255) DEFAULT '' COMMENT '缩略图',
  `icon` varchar(20) DEFAULT '' COMMENT '分类图标',
  `list_template` varchar(50) DEFAULT '' COMMENT '分类列表模板',
  `detail_template` varchar(50) DEFAULT '' COMMENT '分类详情模板',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '分类类型  1  列表  2 单页',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `path` varchar(255) DEFAULT '' COMMENT '路径',
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='分类表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `stb_attachment`
--

DROP TABLE IF EXISTS `stb_attachment`;
CREATE TABLE IF NOT EXISTS `stb_attachment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '附件id',
  `topic_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '话题id',
  `post_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '贴子id',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `original` varchar(255) DEFAULT NULL COMMENT '原始名称',
  `file_name` varchar(255) DEFAULT NULL COMMENT '文件名字',
  `file_type` varchar(100) DEFAULT NULL COMMENT '文件类型',
  `hash` varchar(255) DEFAULT NULL COMMENT '文件hash',
  `url` varchar(300) DEFAULT NULL COMMENT '网路地址',
  `path` varchar(300) DEFAULT NULL COMMENT '文件全路径地址',
  `size` bigint(20) DEFAULT '0' COMMENT '文件大小',
  `is_image` tinyint(1) unsigned DEFAULT '1',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='附件表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `stb_auth_group`
--

DROP TABLE IF EXISTS `stb_auth_group`;
CREATE TABLE IF NOT EXISTS `stb_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` varchar(255) NOT NULL COMMENT '权限规则ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='权限组表' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `stb_auth_group`
--

INSERT INTO `stb_auth_group` (`id`, `title`, `status`, `rules`) VALUES
(1, '超级管理组', 1, '1,2,3,73,74,88,5,6,7,8,9,10,11,12,39,40,41,42,43,14,13,20,21,22,23,24,15,25,26,27,28,29,30,75,77,78,79,80,81,76,82,83,84,85,86,87,16,17,44,45,46,47,48,18,49,50,51,52,53,19,31,32,33,34,35,36,37,54,55,58,59,60,61,62,56,63,64,65,66,67,57,68,69,70,71,72'),
(2, '版主', 1, ''),
(3, '普通会员', 1, '');

-- --------------------------------------------------------

--
-- 表的结构 `stb_auth_group_access`
--

DROP TABLE IF EXISTS `stb_auth_group_access`;
CREATE TABLE IF NOT EXISTS `stb_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='权限组规则表';

--
-- 转存表中的数据 `stb_auth_group_access`
--

INSERT INTO `stb_auth_group_access` (`uid`, `group_id`) VALUES
(19, 1);

-- --------------------------------------------------------

--
-- 表的结构 `stb_auth_rule`
--

DROP TABLE IF EXISTS `stb_auth_rule`;
CREATE TABLE IF NOT EXISTS `stb_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL DEFAULT '' COMMENT '规则名称',
  `title` varchar(20) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `pid` smallint(5) unsigned NOT NULL COMMENT '父级ID',
  `icon` varchar(50) DEFAULT '' COMMENT '图标',
  `sort` tinyint(4) unsigned NOT NULL COMMENT '排序',
  `condition` char(100) DEFAULT '',
  `param` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='规则表' AUTO_INCREMENT=89 ;

--
-- 转存表中的数据 `stb_auth_rule`
--

INSERT INTO `stb_auth_rule` (`id`, `name`, `title`, `type`, `status`, `pid`, `icon`, `sort`, `condition`, `param`) VALUES
(1, 'admin/System/default', '系统配置', 1, 1, 0, 'fa fa-gears', 0, '', ''),
(2, 'admin/System/siteConfig', '站点配置', 1, 1, 1, '', 0, '', 'id=1'),
(3, 'admin/System/updateSiteConfig', '更新配置', 1, 0, 1, '', 0, '', ''),
(5, 'admin/Menu/default', '菜单管理', 1, 1, 0, 'fa fa-bars', 0, '', ''),
(6, 'admin/Menu/index', '后台菜单', 1, 1, 5, '', 0, '', ''),
(7, 'admin/Menu/add', '添加菜单', 1, 0, 6, '', 0, '', ''),
(8, 'admin/Menu/save', '保存菜单', 1, 0, 6, '', 0, '', ''),
(9, 'admin/Menu/edit', '编辑菜单', 1, 0, 6, '', 0, '', ''),
(10, 'admin/Menu/update', '更新菜单', 1, 0, 6, '', 0, '', ''),
(11, 'admin/Menu/delete', '删除菜单', 1, 0, 6, '', 0, '', ''),
(12, 'admin/Nav/index', '导航管理', 1, 1, 5, '', 0, '', ''),
(13, 'admin/Category/index', '版块管理', 1, 1, 14, 'fa fa-sitemap', 0, '', ''),
(14, 'admin/Content/default', '内容管理', 1, 1, 0, 'fa fa-file-text', 0, '', ''),
(15, 'admin/Topic/index', '话题管理', 1, 1, 14, '', 0, '', ''),
(16, 'admin/User/default', '用户管理', 1, 1, 0, 'fa fa-users', 0, '', ''),
(17, 'admin/User/index', '普通用户', 1, 1, 16, '', 0, '', ''),
(18, 'admin/AdminUser/index', '管理员', 1, 1, 16, '', 0, '', ''),
(19, 'admin/AuthGroup/index', '权限组', 1, 1, 16, '', 0, '', ''),
(20, 'admin/Category/add', '添加版块', 1, 0, 13, '', 0, '', ''),
(21, 'admin/Category/save', '保存版块', 1, 0, 13, '', 0, '', ''),
(22, 'admin/Category/edit', '编辑版块', 1, 0, 13, '', 0, '', ''),
(23, 'admin/Category/update', '更新版块', 1, 0, 13, '', 0, '', ''),
(24, 'admin/Category/delete', '删除版块', 1, 0, 13, '', 0, '', ''),
(25, 'admin/Topic/add', '添加话题', 1, 0, 15, '', 0, '', ''),
(26, 'admin/Topic/save', '保存话题', 1, 0, 15, '', 0, '', ''),
(27, 'admin/Topic/edit', '编辑话题', 1, 0, 15, '', 0, '', ''),
(28, 'admin/Topic/update', '更新话题', 1, 0, 15, '', 0, '', ''),
(29, 'admin/Topic/delete', '删除话题', 1, 0, 15, '', 0, '', ''),
(30, 'admin/Topic/toggle', '话题审核', 1, 0, 15, '', 0, '', ''),
(31, 'admin/AuthGroup/add', '添加权限组', 1, 0, 19, '', 0, '', ''),
(32, 'admin/AuthGroup/save', '保存权限组', 1, 0, 19, '', 0, '', ''),
(33, 'admin/AuthGroup/edit', '编辑权限组', 1, 0, 19, '', 0, '', ''),
(34, 'admin/AuthGroup/update', '更新权限组', 1, 0, 19, '', 0, '', ''),
(35, 'admin/AuthGroup/delete', '删除权限组', 1, 0, 19, '', 0, '', ''),
(36, 'admin/AuthGroup/auth', '授权', 1, 0, 19, '', 0, '', ''),
(37, 'admin/AuthGroup/updateAuthGroupRule', '更新权限组规则', 1, 0, 19, '', 0, '', ''),
(39, 'admin/Nav/add', '添加导航', 1, 0, 12, '', 0, '', ''),
(40, 'admin/Nav/save', '保存导航', 1, 0, 12, '', 0, '', ''),
(41, 'admin/Nav/edit', '编辑导航', 1, 0, 12, '', 0, '', ''),
(42, 'admin/Nav/update', '更新导航', 1, 0, 12, '', 0, '', ''),
(43, 'admin/Nav/delete', '删除导航', 1, 0, 12, '', 0, '', ''),
(44, 'admin/User/add', '添加用户', 1, 0, 17, '', 0, '', ''),
(45, 'admin/User/save', '保存用户', 1, 0, 17, '', 0, '', ''),
(46, 'admin/User/edit', '编辑用户', 1, 0, 17, '', 0, '', ''),
(47, 'admin/User/update', '更新用户', 1, 0, 17, '', 0, '', ''),
(48, 'admin/User/delete', '删除用户', 1, 0, 17, '', 0, '', ''),
(49, 'admin/AdminUser/add', '添加管理员', 1, 0, 18, '', 0, '', ''),
(50, 'admin/AdminUser/save', '保存管理员', 1, 0, 18, '', 0, '', ''),
(51, 'admin/AdminUser/edit', '编辑管理员', 1, 0, 18, '', 0, '', ''),
(52, 'admin/AdminUser/update', '更新管理员', 1, 0, 18, '', 0, '', ''),
(53, 'admin/AdminUser/delete', '删除管理员', 1, 0, 18, '', 0, '', ''),
(54, 'admin/Slide/default', '扩展管理', 1, 1, 0, 'fa fa-wrench', 0, '', ''),
(55, 'admin/SlideCategory/index', '轮播分类', 1, 1, 54, '', 0, '', ''),
(56, 'admin/Slide/index', '轮播图管理', 1, 1, 54, '', 0, '', ''),
(57, 'admin/Link/index', '友情链接', 1, 1, 54, 'fa fa-link', 0, '', ''),
(58, 'admin/SlideCategory/add', '添加分类', 1, 0, 55, '', 0, '', ''),
(59, 'admin/SlideCategory/save', '保存分类', 1, 0, 55, '', 0, '', ''),
(60, 'admin/SlideCategory/edit', '编辑分类', 1, 0, 55, '', 0, '', ''),
(61, 'admin/SlideCategory/update', '更新分类', 1, 0, 55, '', 0, '', ''),
(62, 'admin/SlideCategory/delete', '删除分类', 1, 0, 55, '', 0, '', ''),
(63, 'admin/Slide/add', '添加轮播', 1, 0, 56, '', 0, '', ''),
(64, 'admin/Slide/save', '保存轮播', 1, 0, 56, '', 0, '', ''),
(65, 'admin/Slide/edit', '编辑轮播', 1, 0, 56, '', 0, '', ''),
(66, 'admin/Slide/update', '更新轮播', 1, 0, 56, '', 0, '', ''),
(67, 'admin/Slide/delete', '删除轮播', 1, 0, 56, '', 0, '', ''),
(68, 'admin/Link/add', '添加链接', 1, 0, 57, '', 0, '', ''),
(69, 'admin/Link/save', '保存链接', 1, 0, 57, '', 0, '', ''),
(70, 'admin/Link/edit', '编辑链接', 1, 0, 57, '', 0, '', ''),
(71, 'admin/Link/update', '更新链接', 1, 0, 57, '', 0, '', ''),
(72, 'admin/Link/delete', '删除链接', 1, 0, 57, '', 0, '', ''),
(73, 'admin/ChangePassword/index', '修改密码', 1, 1, 1, '', 0, '', ''),
(74, 'admin/ChangePassword/updatePassword', '更新密码', 1, 0, 1, '', 0, '', ''),
(75, 'admin/ArticleCategory/index', '文章栏目', 1, 1, 14, '', 0, '', ''),
(76, 'admin/Article/index', '文章管理', 1, 1, 14, '', 0, '', ''),
(77, 'admin/ArticleCategory/add', '添加栏目', 1, 0, 75, '', 0, '', ''),
(78, 'admin/ArticleCategory/save', '保存栏目', 1, 0, 75, '', 0, '', ''),
(79, 'admin/ArticleCategory/edit', '编辑栏目', 1, 0, 75, '', 0, '', ''),
(80, 'admin/ArticleCategory/update', '更新栏目', 1, 0, 75, '', 0, '', ''),
(81, 'admin/ArticleCategory/delete', '删除栏目', 1, 0, 75, '', 0, '', ''),
(82, 'admin/Article/add', '添加文章', 1, 0, 76, '', 0, '', ''),
(83, 'admin/Article/save', '保存文章', 1, 0, 76, '', 0, '', ''),
(84, 'admin/Article/edit', '编辑文章', 1, 0, 76, '', 0, '', ''),
(85, 'admin/Article/update', '更新文章', 1, 0, 76, '', 0, '', ''),
(86, 'admin/Article/delete', '删除文章', 1, 0, 76, '', 0, '', ''),
(87, 'admin/Article/toggle', '文章审核', 1, 0, 76, '', 0, '', ''),
(88, 'admin/System/siteConfig1', '内容配置', 1, 0, 1, '', 0, '', 'id=2');

-- --------------------------------------------------------

--
-- 表的结构 `stb_category`
--

DROP TABLE IF EXISTS `stb_category`;
CREATE TABLE IF NOT EXISTS `stb_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '版块ID',
  `name` varchar(50) NOT NULL COMMENT '版块名称',
  `alias` varchar(50) DEFAULT '' COMMENT '导航别名',
  `description` varchar(255) DEFAULT NULL COMMENT '版块描述',
  `thumb` varchar(255) DEFAULT '/public/uploads/category/default.png' COMMENT '缩略图',
  `icon` varchar(20) DEFAULT '' COMMENT '版块图标',
  `list_template` varchar(50) DEFAULT '' COMMENT '版块列表模板',
  `detail_template` varchar(50) DEFAULT '' COMMENT '版块详情模板',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '版块类型  1  列表  2 单页',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `path` varchar(255) DEFAULT '' COMMENT '路径',
  `topics` int(11) unsigned DEFAULT '0' COMMENT '话题数',
  `posts` int(11) unsigned DEFAULT '0' COMMENT '贴子数',
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='分类表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `stb_link`
--

DROP TABLE IF EXISTS `stb_link`;
CREATE TABLE IF NOT EXISTS `stb_link` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '链接名称',
  `link` varchar(255) DEFAULT '' COMMENT '链接地址',
  `image` varchar(255) DEFAULT '' COMMENT '链接图片',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1 显示  2 隐藏',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='友情链接表' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `stb_link`
--

INSERT INTO `stb_link` (`id`, `name`, `link`, `image`, `status`, `sort`) VALUES
(1, 'StartBBS', 'http://www.startbbs.com', '', 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `stb_nav`
--

DROP TABLE IF EXISTS `stb_nav`;
CREATE TABLE IF NOT EXISTS `stb_nav` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL COMMENT '父ID',
  `name` varchar(20) NOT NULL COMMENT '导航名称',
  `alias` varchar(20) DEFAULT '' COMMENT '导航别称',
  `link` varchar(255) DEFAULT '' COMMENT '导航链接',
  `icon` varchar(255) DEFAULT '' COMMENT '导航图标',
  `target` varchar(10) DEFAULT '' COMMENT '打开方式',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态  0 隐藏  1 显示',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='导航表' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `stb_nav`
--

INSERT INTO `stb_nav` (`id`, `pid`, `name`, `alias`, `link`, `icon`, `target`, `status`, `sort`) VALUES
(1, 0, '首页', 'Home', '/', 'fa fa-home', '_self', 1, 0),
(2, 0, '版块', '', '/category/', '', '_self', 1, 0),
(3, 0, '文章', 'article', '/article/', '', '_self', 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `stb_post`
--

DROP TABLE IF EXISTS `stb_post`;
CREATE TABLE IF NOT EXISTS `stb_post` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '话题ID',
  `cid` smallint(5) unsigned NOT NULL COMMENT '版块ID',
  `uid` int(10) unsigned NOT NULL COMMENT '用户id',
  `topic_id` int(10) unsigned NOT NULL COMMENT '话题id',
  `description` varchar(255) DEFAULT '' COMMENT '描述',
  `content` longtext COMMENT '内容',
  `username` varchar(20) DEFAULT '' COMMENT '用户名',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0 待审核  1 审核',
  `reading` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '阅读量',
  `thumb` varchar(255) DEFAULT '' COMMENT '缩略图',
  `photo` text COMMENT '图集',
  `is_first` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否首贴',
  `is_top` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否置顶  0 不置顶  1 置顶',
  `is_recommend` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否推荐  0 不推荐  1 推荐',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` int(10) NOT NULL COMMENT '创建时间',
  `update_time` int(10) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文章表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `stb_slide`
--

DROP TABLE IF EXISTS `stb_slide`;
CREATE TABLE IF NOT EXISTS `stb_slide` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(10) unsigned NOT NULL COMMENT '分类ID',
  `name` varchar(50) NOT NULL COMMENT '轮播图名称',
  `description` varchar(255) DEFAULT '' COMMENT '说明',
  `link` varchar(255) DEFAULT '' COMMENT '链接',
  `target` varchar(10) DEFAULT '' COMMENT '打开方式',
  `image` varchar(255) DEFAULT '' COMMENT '轮播图片',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态  1 显示  0  隐藏',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='轮播图表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `stb_slide_category`
--

DROP TABLE IF EXISTS `stb_slide_category`;
CREATE TABLE IF NOT EXISTS `stb_slide_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '轮播图分类',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='轮播图分类表' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `stb_slide_category`
--

INSERT INTO `stb_slide_category` (`id`, `name`) VALUES
(1, '首页轮播');

-- --------------------------------------------------------

--
-- 表的结构 `stb_system`
--

DROP TABLE IF EXISTS `stb_system`;
CREATE TABLE IF NOT EXISTS `stb_system` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `system` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为系统配置(1是，0否)',
  `group` varchar(20) NOT NULL DEFAULT 'base' COMMENT '分组',
  `title` varchar(20) NOT NULL COMMENT '配置标题',
  `name` varchar(50) NOT NULL COMMENT '配置名称，由英文字母和下划线组成',
  `value` text NOT NULL COMMENT '配置值',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '配置类型()',
  `options` text NOT NULL COMMENT '配置项(选项名:选项值)',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '文件上传接口',
  `tips` varchar(255) NOT NULL COMMENT '配置提示',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) unsigned NOT NULL COMMENT '状态',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='系统配置' AUTO_INCREMENT=53 ;

--
-- 转存表中的数据 `stb_system`
--

INSERT INTO `stb_system` (`id`, `system`, `group`, `title`, `name`, `value`, `type`, `options`, `url`, `tips`, `sort`, `status`, `create_time`, `update_time`) VALUES
(1, 1, 'sys', '扩展配置分组', 'config_group', '', 3, ' ', '', '请按如下格式填写：&lt;br&gt;键值:键名&lt;br&gt;键值:键名&lt;br&gt;&lt;span style=&quot;color:#f00&quot;&gt;键值只能为英文、数字、下划线&lt;/span&gt;', 1, 1, 1492140215, 1492140215),
(13, 1, 'base', '网站域名', 'site_domain', '', 1, '', '', '', 2, 1, 1492140215, 1492140215),
(14, 1, 'upload', '图片上传大小限制', 'upload_image_size', '0', 1, '', '', '单位：KB，0表示不限制大小', 3, 1, 1490841797, 1491040778),
(15, 1, 'upload', '允许上传图片格式', 'upload_image_ext', 'jpg,png,gif,jpeg,ico', 1, '', '', '多个格式请用英文逗号（,）隔开', 4, 1, 1490842130, 1491040778),
(16, 1, 'upload', '缩略图裁剪方式', 'thumb_type', '2', 5, '1:等比例缩放\r\n2:缩放后填充\r\n3:居中裁剪\r\n4:左上角裁剪\r\n5:右下角裁剪\r\n6:固定尺寸缩放\r\n', '', '', 5, 1, 1490842450, 1491040778),
(17, 1, 'upload', '图片水印开关', 'image_watermark', '1', 4, '0:关闭\r\n1:开启', '', '', 6, 1, 1490842583, 1491040778),
(18, 1, 'upload', '图片水印图', 'image_watermark_pic', '/upload/sys/image/49/4d0430eaf30318ef847086d0b63db0.png', 8, '', '', '', 7, 1, 1490842679, 1491040778),
(19, 1, 'upload', '图片水印透明度', 'image_watermark_opacity', '50', 1, '', '', '可设置值为0~100，数字越小，透明度越高', 8, 1, 1490857704, 1491040778),
(20, 1, 'upload', '图片水印图位置', 'image_watermark_location', '9', 5, '7:左下角\r\n1:左上角\r\n4:左居中\r\n9:右下角\r\n3:右上角\r\n6:右居中\r\n2:上居中\r\n8:下居中\r\n5:居中', '', '', 9, 1, 1490858228, 1491040778),
(21, 1, 'upload', '文件上传大小限制', 'upload_file_size', '0', 1, '', '', '单位：KB，0表示不限制大小', 1, 1, 1490859167, 1491040778),
(22, 1, 'upload', '允许上传文件格式', 'upload_file_ext', 'doc,docx,xls,xlsx,ppt,pptx,pdf,wps,txt,rar,zip', 1, '', '', '多个格式请用英文逗号（,）隔开', 2, 1, 1490859246, 1491040778),
(23, 1, 'upload', '文字水印开关', 'text_watermark', '0', 4, '0:关闭\r\n1:开启', '', '', 10, 1, 1490860872, 1491040778),
(24, 1, 'upload', '文字水印内容', 'text_watermark_content', '', 1, '', '', '', 11, 1, 1490861005, 1491040778),
(25, 1, 'upload', '文字水印字体', 'text_watermark_font', '', 9, '', '', '不上传将使用系统默认字体', 12, 1, 1490861117, 1491040778),
(26, 1, 'upload', '文字水印字体大小', 'text_watermark_size', '20', 1, '', '', '单位：px(像素)', 13, 1, 1490861204, 1491040778),
(27, 1, 'upload', '文字水印颜色', 'text_watermark_color', '#000000', 1, '', '', '文字水印颜色，格式:#000000', 14, 1, 1490861482, 1491040778),
(28, 1, 'upload', '文字水印位置', 'text_watermark_location', '7', 5, '7:左下角\r\n1:左上角\r\n4:左居中\r\n9:右下角\r\n3:右上角\r\n6:右居中\r\n2:上居中\r\n8:下居中\r\n5:居中', '', '', 11, 1, 1490861718, 1491040778),
(29, 1, 'upload', '缩略图尺寸', 'thumb_size', '300x300;500x500', 1, '', '', '为空则不生成，生成 500x500 的缩略图，则填写 500x500，多个规格填写参考 300x300;500x500;800x800', 4, 1, 1490947834, 1491040778),
(30, 1, 'develop', '开发模式', 'app_debug', '1', 4, '0:关闭\r\n1:开启', '', '', 0, 1, 1491005004, 1492093874),
(31, 1, 'develop', '页面Trace', 'app_trace', '1', 4, '0:关闭\r\n1:开启', '', '', 0, 1, 1491005081, 1492093874),
(33, 1, 'sys', '富文本编辑器', 'editor', 'kindeditor', 5, 'ueditor:UEditor\r\numeditor:UMEditor\r\nkindeditor:KindEditor\r\nckeditor:CKEditor', '', '', 2, 0, 1491142648, 1492140215),
(35, 1, 'databases', '备份目录', 'backup_path', './backup/database/', 1, '', '', '数据库备份路径,路径必须以 / 结尾', 0, 1, 1491881854, 1491965974),
(36, 1, 'databases', '备份分卷大小', 'part_size', '20971520', 1, '', '', '用于限制压缩后的分卷最大长度。单位：B；建议设置20M', 0, 1, 1491881975, 1491965974),
(37, 1, 'databases', '备份压缩开关', 'compress', '1', 4, '0:关闭\r\n1:开启', '', '压缩备份文件需要PHP环境支持gzopen,gzwrite函数', 0, 1, 1491882038, 1491965974),
(38, 1, 'databases', '备份压缩级别', 'compress_level', '4', 6, '1:最低\r\n4:一般\r\n9:最高', '', '数据库备份文件的压缩级别，该配置在开启压缩时生效', 0, 1, 1491882154, 1491965974),
(39, 1, 'base', '网站状态', 'site_status', '1', 4, '0:关闭\r\n1:开启', '', '站点关闭后将不能访问，后台可正常登录', 1, 1, 1492049460, 1494690024),
(40, 1, 'sys', '后台管理路径', 'admin_path', 'admin.php', 1, '', '', '必须以.php为后缀', 0, 0, 1492139196, 1492140215),
(41, 1, 'base', '网站标题', 'site_title', 'StartBBS轻量社区系统', 1, '', '', '网站标题是体现一个网站的主旨，要做到主题突出、标题简洁、连贯等特点，建议不超过28个字', 6, 1, 1492502354, 1494695131),
(42, 1, 'base', '网站关键词', 'site_keywords', 'startbbs,轻量社区,微社区', 1, '', '', '网页内容所包含的核心搜索关键词，多个关键字请用英文逗号&quot;,&quot;分隔', 7, 1, 1494690508, 1494690780),
(43, 1, 'base', '网站描述', 'site_description', 'StartBBS 是一款优雅、开源、轻量社区系统，基于MVC架构，自带文章系统。', 2, '', '', '网页的描述信息，搜索引擎采纳后，作为搜索结果中的页面摘要显示，建议不超过80个字', 8, 1, 1494690669, 1494691075),
(44, 1, 'base', 'ICP备案信息', 'site_icp', '', 1, '', '', '请填写ICP备案号，用于展示在网站底部，ICP备案官网：&lt;a href=&quot;http://www.miibeian.gov.cn&quot; target=&quot;_blank&quot;&gt;http://www.miibeian.gov.cn&lt;/a&gt;', 9, 1, 1494691721, 1494692046),
(45, 1, 'base', '统计代码', 'site_statis', '', 2, '', '', '第三方流量统计代码，前台调用时请先用 htmlspecialchars_decode函数转义输出', 10, 1, 1494691959, 1494694797),
(46, 1, 'base', '网站名称', 'site_name', 'StartBBS', 1, '', '', '将显示在浏览器窗口标题等位置', 3, 1, 1494692103, 1494694680),
(47, 1, 'base', '网站LOGO', 'site_logo', '', 8, '', '', '网站LOGO图片', 4, 1, 1494692345, 1494693235),
(48, 1, 'base', '网站图标', 'site_favicon', '', 8, '', '/admin/annex/favicon', '又叫网站收藏夹图标，它显示位于浏览器的地址栏或者标题前面，&lt;strong class=&quot;red&quot;&gt;.ico格式&lt;/strong&gt;，&lt;a href=&quot;https://www.baidu.com/s?ie=UTF-8&amp;wd=favicon&quot; target=&quot;_blank&quot;&gt;点此了解网站图标&lt;/a&gt;', 5, 0, 1494692781, 1494693966),
(49, 1, 'base', '手机网站', 'wap_site_status', '0', 4, '0:关闭\r\n1:开启', '', '如果有手机网站，请设置为开启状态，否则只显示PC网站', 2, 0, 1498405436, 1498405436),
(50, 1, 'sys', '云端推送', 'cloud_push', '0', 4, '0:关闭\r\n1:开启', '', '关闭之后，无法通过云端推送安装扩展', 3, 0, 1504250320, 1504250320),
(51, 0, 'base', '手机网站域名', 'wap_domain', '', 1, '', '', '手机访问将自动跳转至此域名', 2, 0, 1504304776, 1504304837),
(52, 0, 'sys', '多语言支持', 'multi_language', '0', 4, '0:关闭\r\n1:开启', '', '开启后你可以自由上传多种语言包', 4, 0, 1506532211, 1506532211);

-- --------------------------------------------------------

--
-- 表的结构 `stb_topic`
--

DROP TABLE IF EXISTS `stb_topic`;
CREATE TABLE IF NOT EXISTS `stb_topic` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '话题ID',
  `cid` smallint(5) unsigned NOT NULL COMMENT '版块ID',
  `uid` int(10) unsigned NOT NULL COMMENT '用户id',
  `first_post_id` int(10) unsigned DEFAULT '0' COMMENT '首贴id',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `description` varchar(255) DEFAULT '' COMMENT '描述',
  `username` varchar(20) DEFAULT '' COMMENT '用户名',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0 待审核  1 审核',
  `views` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '阅读量',
  `posts` int(10) unsigned DEFAULT '1' COMMENT '贴子数',
  `thumb` varchar(255) DEFAULT '' COMMENT '缩略图',
  `photo` text COMMENT '图集',
  `is_top` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否置顶  0 不置顶  1 置顶',
  `is_recommend` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否推荐  0 不推荐  1 推荐',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` int(10) NOT NULL COMMENT '创建时间',
  `update_time` int(10) NOT NULL COMMENT '更新时间',
  `ord` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排列',
  PRIMARY KEY (`id`),
  KEY `ord` (`ord`),
  KEY `views` (`views`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文章表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `stb_user`
--

DROP TABLE IF EXISTS `stb_user`;
CREATE TABLE IF NOT EXISTS `stb_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT '3' COMMENT '用户组id',
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `password` char(60) NOT NULL COMMENT '密码',
  `avatar` varchar(100) DEFAULT '/public/uploads/avatar/default' COMMENT '头像',
  `mobile` varchar(11) DEFAULT '' COMMENT '手机',
  `email` varchar(50) DEFAULT '' COMMENT '邮箱',
  `hometown` varchar(20) DEFAULT '' COMMENT '城市',
  `signature` varchar(255) DEFAULT NULL COMMENT '自我介绍',
  `topics` int(11) unsigned DEFAULT '0' COMMENT '话题数',
  `posts` int(11) unsigned DEFAULT '0' COMMENT '贴子数',
  `status` tinyint(1) unsigned DEFAULT '1' COMMENT '用户状态  1 正常  2 禁止',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  `last_login_time` int(10) DEFAULT NULL COMMENT '最后登陆时间',
  `last_login_ip` varchar(50) DEFAULT '' COMMENT '最后登录IP',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户表' AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
