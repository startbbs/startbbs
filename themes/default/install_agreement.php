<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<?php $this->load->view ( 'common/header-meta' ); ?>
    <title>安装向导 | Powered By StartBBS</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">安装向导 >> 协议</div>
                    <div class="panel-body">
						<h2 class="text-center"><b>StartBBS开源授权协议</b></h2></br>

						<p>感谢您选择StartBBS（简称STB），StartBBS致力于为用户提供轻量级高负载的轻论坛/微社区解决方案。
						StartBBS Team为StartBBS产品的开发商，依法独立拥有StartBBS产品著作权。StartBBS官方网站网址为 http://www.startbbs.com。</p></br>
						<p>StartBBS著作权受法律和国际公约保护。使用者：无论个人或组织、盈利与否、用途如何（包括以学习和研究为目的），均需仔细阅读本协议，在理解、同意、并遵守本协议的全部条款后，方可开始使用 StartBBS 软件。</p>
						<p>本授权协议仅适用于1.1.5.3即以上的 StartBBS 版本，StartBBS Team拥有对本授权协议的最终解释权。</p>
						<p>本协议是在完全遵守GPLv2（类路径例外）的前提下添加部分不冲突条款。</p>
						<p>GPLv2原文 http://www.gnu.org/software/classpath/license.html ，类路径例外原文 http://www.gnu.org/software/classpath/license.html 。</p></br>

						<h3><b>1.0 协议许可的权利</b></h3>
						<p>
						1）被授权方可以在完全遵守本最终用户授权协议的基础上，将本软件应用于非商业用途(一切逾越《StartBBS开源授权协议》的行为皆为用于商业用途)，而不必支付软件版权授权费用；</p>
						<p>2）被授权方可以在所有协议规定的约束和限制范围内修改 StartBBS 源代码或界面风格以适应您的网站要求；</p>
						<p>3）被授权方允许在完全遵守GPLv2（类路径例外）的前提下自由分发复制。</p></br>

						<h3><b>2.0 协议规定的约束和限制 </b></h3>
						<p>1）被授权方必须完全遵守GPLv2（类路径例外）开源授权协议 </p>
						<p>2）未经授权不得用于商业用途(一切逾越《StartBBS开源授权协议》的行为皆为用于商业用途)，否则我们将保留追究的权利；</p>
						<p>3）无论如何（即无论用途如何、是否经过修改或美化、修改程度如何），只要使用StartBBS的整体或任何部分，未经书面许可，页面页脚处的 Powered by StartBBS名称和官网网站的链接（http://www.startbbs.com ）都必须保留，而不能清除或修改；</p>
						<p>3）若将StartBBS嵌入任何其他软件则必须将该软件整体开源(详见GPLv2)；</p>
						<p>4）禁止StartBBS的整体或任何部分基础上以发展任何用于商业用途(仅包括以盈利为目或实现盈利的商业行为)的派生版本、修改版本或第三方版本。</p></br>

						<h3><b>3.0 有限担保和免责声明 </b></h3>
						<p>1）本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；</p>
						<p>2）被授权方出于自愿而使用本软件，被授权方必须了解使用本软件的风险，我方不承担任何因使用本软件而产生问题的相关责任；</p>
						<p>3）StartBBS官方不对使用本软件构建的论坛中的文章或信息承担责任；</p>
						<p>4）如果本软件带有其它软件的整合API示范例子包，这些文件版权不属于本软件官方，并且这些文件是没经过授权发布的，请参考相关软件的使用许可合法的使用。</p></br>
						<p>
						有关 StartBBS 最终用户授权协议、商业授权与技术服务的详细内容，均由 StartBBS 官方网站独家提供。</p>
						<p>StartBBS Team拥有在不事先通知的情况下，修改授权协议和服务价目表的权力，修改后的协议或价目表对自改变之日起的新授权用户生效。</p></br>

						<p>电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和等同的法律效力。您一旦开始安装 StartBBS，即被视为完全理解并接受本协议的各项条款，在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。</p></br>
						<p>
						版权所有 (c) 2013-2014，StartBBS Team保留所有权利。</p></br></br>
                            <p class="pull-right">StartBBS开发团队</br><?php echo date('Y-m-d',time())?></p>

                            <div class="clearfix"></div>
                            <center>
                                <br>
                                <a class="btn btn-primary btn-block" href="<?php echo site_url('install/check');?>" role="button">接受协议并继续</a>
                            </center>
                    </div>
                    <center class="panel-footer">
                        Copyright © 2014 <a href="http://startbbs.com">StartBBS</a>. All rights reserved.
                    </center>
                </div>
            </div>
        </div>
    </div>
</body>
</html>