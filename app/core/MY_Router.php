<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * 自定义路由类
 *
 */
class MY_Router extends CI_Router
{
    /**
     *  Set the directory name
     *
     * @access  public
     * @param   string
     * @return  void
     */
    function url($type='',$num='',$any='')
    {
		$arr=array(
			'topic_show'=>'topic/show/$1',
			'node_show'=>'node/show/$1',
			'tag_show'=>'tag/show/$1'
		);
	    $url = array_keys($this->routes,$arr[$type]);
		$url = str_replace('(:any)', $any, str_replace('(:num)', $num, $url));
        return site_url($url[0]);
    }

}
// END MY_Router Class
 