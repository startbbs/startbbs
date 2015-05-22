<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * stat_m.php
 *
 * @author  :  Skiychan <developer@zzzzy.com>
 * @created :  2015/5/21
 * @modified:  
 * @version :  0.0.1
 */

class Stat_m extends SB_Model {

    const TB_STAT = "site_stats";

    public function __construct() {
        parent::__construct();
    }

    public function get_list() {
        return $this->db->get(self::TB_STAT)->result_array();
    }

    /**
     * 通过item名取得item的值
     * @param $item
     * @return mixed
     */
    public function get_item($item) {
        return $this->db->get_where(self::TB_STAT, array('item' => $item), 1)->row_array();
    }

    /**
     * item值递增
     * @param $item
     * @param $def 自定义的值,数组形式 array('key' => array('set', 'convert')
     */
    public function set_item_val($item, $def=FALSE) {
        if (! $def) {
            $this->db->set('value','value+1',FALSE);
        } else {
            if (! is_array($def)) return;
            foreach ($def as $k => $v) {
                $this->db->set($k, $v['set'], isset($v['convert']) ? TRUE : FALSE);
            }
        }
        $this->db->where('item', $item)->update(self::TB_STAT);
    }

}