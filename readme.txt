+=======================+
StartBBS开源社区系统（又名：起点bbs）
+=======================+

StartBBS（起点开源社区系统）是一个基于PHP+MySQL开发的新型社区系统，她轻量小巧, 简单易用，强大高效的开源论坛系统。又简称”SB（烧饼）”。

采用MVC框架开发，易于二次开发扩展，程序与模板文件分开，大家可以很方便地建立自己的模板，前台UI采用最流行的Twitter Bootstrap和Jquery，最大可能的发掘用户体验，增强用户对论坛的粘性和好感，设计上采用了流式响应式设计，无论你是使用电脑还是平板电脑和手机，都能很好地适应屏幕。无需要再开发相应的模板。

整体架构从缓存技术、数据库设计、代码优化等多个角度入手进行优化，支持百万级数据，开启缓存和gzip后,打开的网站速度如同静态页一样流畅.

安装包大小仅几百K, 比一般的blog还要小巧轻便, 从起点开始，给“臃肿”两字说拜拜吧！尽管目前还不完善，但我会尽心地把它开发下去，并保持更新。希望大家能互相推荐一下，尽可能地给我留一个链接。

StartBBS开源论坛
http://www.startbbs.com


+=======================+
StartBBS开源社区的环境需求
+=======================+

1. 可用的 www 服务器，如 Apache、IIS、nginx, 推荐使用Apache.
2. PHP4以上, 建议php5.0以上的版本
3. MySQL 5.0 及以上, 服务器需要支持 MySQLi 或 PDO_MySQL
4. GD 图形库支持或 ImageMagick 支持, 推荐使用 ImageMagick, 在处理大文件的时候表现较好

+=======================+
StartBBS开源社区系统下载
+=======================+

可到官方直接下载或到下面的托管地址

Google
http://code.google.com/p/startbbs/

+=======================+
StartBBS开源社区系统的安装
+=======================+

1. 上传目录中的文件到服务器
2. 设置目录属性（windows 服务器可忽略这一步）
	以下这些目录需要可读写权限
	./
	./app
	./app/cache
	./app/config目录以及子文件
	./uploads及子目录

3. 进入首页就自动提示安装，如重新安装请删除根目录中的intall.lock文件
   或访问 http://您的域名/home/install/进行安装
4. 参照页面提示，进行安装，直至安装完毕

+=======================+
StartBBS开源社区系统的升级
+=======================+
每一个版本，官方都会提供升级包。具体见官方论坛
a.上传升级包覆盖原文件
b.执行 http://域名/index.php/upgrade



+=======================+
Startbbs Rewrite 开启方法
+=======================+

Apache:

<IfModule mod_rewrite.c>
RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond $1 !^(index\.php|images|robots\.txt)
RewriteRule ^(.*)$ /index.php/$1 [L]
</IfModule>

后续会增加更多规则

+=======================+
Startbbs 软件的技术支持
+=======================+

当您在安装、升级、日常使用当中遇到疑难，请您到以下站点获取技术支持。

Startbbs官方网站：http://www.startbbs.com
官方邮箱startbbs@126.com