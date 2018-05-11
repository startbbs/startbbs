<?php

namespace app\common\controller;

use think\View;
use think\Exception;
use Request;
use think\Controller;
/**
 * 插件类
 * @package app\common\controller
 */
abstract class PluginBase extends Controller
{
    /**
     * @var null 视图实例对象
     */
    protected $view = null;

    /**
     * @var string 错误信息
     */
    protected $error = '';

    /**
     * @var string 插件路径
     */
    public $plugin_path = '';

    /**
     * @var string 插件信息
     */
    public $plugin_info = '';

    /**
     * @var string 插件名
     */
    public $plugin_name = '';

    /**
     * 插件构造方法
     */
    public function __construct()
    {
        // 获取插件名
        $class = get_class($this);
        $this->plugin_name = substr($class, strrpos($class, '\\') + 1);

        $this->view = new View();
        $this->plugin_path = ROOT_PATH.'plugin/'.$this->plugin_name.'/';

        if (is_file($this->plugin_path.'info.php')) {
            $this->plugin_info = include $this->plugin_path.'info.php';
        }
    }

    /**
     * 模板变量赋值
     * @param string $name 模板变量
     * @param string $value 变量的值
     * @author 烧饼 <858292510@qq.com>
     * @return $this
     */
    final protected function assign($name = '', $value='')
    {
        $this->view->assign($name, $value);
        return $this;
    }

    /**
     * 显示方法,仅限钩子方法使用
     * @param string $template 模板名
     * @param array $vars 模板输出变量
     * @param array $replace 替换内容
     * @param array $config 模板参数
     * @author 烧饼 <858292510@qq.com>
     * @return mixed
     */
    final protected function fetch($template = '', $vars = [], $config = [])
    {
	    $current_controller = Request::controller();
	    $template=$template?:$current_controller;
	    $template = $this->plugin_path. 'view/'. $template . '.html';
        if (!is_file($template)) {
            throw new Exception('模板不存在：'.$template);
        }
        $this->view->engine(['view_path' => $template]);
        echo $this->view->fetch($template,$vars,$config);
    }

    /**
     * 获取错误信息
     * @author 烧饼 <858292510@qq.com>
     * @return string
     */
    final public function getError()
    {
        return $this->error;
    }

    /**
     * 必须实现安装方法
     * @author 烧饼 <858292510@qq.com>
     * @return mixed
     */
    abstract public function install();

    /**
     * 必须实现卸载方法
     * @author 烧饼 <858292510@qq.com>
     * @return mixed
     */
    abstract public function uninstall();
}
