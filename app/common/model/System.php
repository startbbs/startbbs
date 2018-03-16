<?php
/**
 * Description of System.php.
 * User: StartBBS <startbbs@126.com>
 * Date: 2017-08-03 14:31
 */

namespace app\common\model;

use think\Db;
use think\Model;
use think\Validate;

use Config, Request, Cache;

class System extends Model
{
    protected $autoWriteTimestamp = true; //自动写入创建和更新的时间戳字段
    protected $auto = ['title', 'name'];
    protected $insert = ['status' => 1];
    protected $update = [];


	/**
	 * 获取配置
	 * @param string $
	 * @return
	 */
	public function getConfig()
	{
        $data = Cache::get('front_config');
        if (empty($data)) {
	        $where=array(
				//['area','in','0,1'],
				['status','=',1]
	        );
            $data = Db::name('system')->where($where)->select();
            Cache::tag('system_config')->set('front_config', $data);
        }
        foreach($data as $v){
        	$config[$v['group']][$v['name']]=$v['value'];
        }
        return Config::set($config);
        //Log::record("[ 系统配置 ]：初始化成功");
	}
    /**
     * 批量保存配置
     * @param array $data 配置数据
     * @author StartBBS <startbbs@126.com>
     * @return array
     */

    public function batchSave(array $data = []) {
        foreach ($data as $name => $value) {
           $status= $this::where(['name' => $name])->setField('value', $value);
           if ($status===false){
               $this->error='系统错误，请稍候再试';
               return false;
           }
        }
        return true;
    }

    /*====================获取器====================*/

    /**
     * 获取配置的分组
     * @param  $value 配置分组
     * @author StartBBS <startbbs@126.com>
     * @return string
     */
    function getGroupAttr($value)
    {
        $list = Config::get('config_group_list');
        return (int)$value ? $list[ $value ] : '不予显示';
    }

    /**
     * 配置区域
     * @author StartBBS <startbbs@126.com>
     * @param $value
     * @return mixed
     */
    public function getAreaAttr($value)
    {
        return is_numeric($value) ? change_status($value,['前后台','前台','后台']):null;
    }

    /**
     * 配置类型
     * @author StartBBS <startbbs@126.com>
     * @param $value
     * @return mixed
     */
    public function getTypeAttr($value)
    {
        $list = Config::get('config_type_list');
        return (int)$value ? $list[ $value ] : '';
    }

}