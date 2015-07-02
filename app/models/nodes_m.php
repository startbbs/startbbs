<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * nodes_m.php
 *
 * @author  :  Skiychan <developer@zzzzy.com>
 * @created :  2015/5/21
 * @modified:  
 * @version :  0.0.1
 */

class Nodes_m extends CI_Model {

    const TB_NODES = "nodes";

    public function __construct() {
        parent::__construct();
    }

    /**
     * 获取版块信息
     * @param $node_id 版块id
     * @return mixed
     */
    public function get_cat($node_id) {
        return $this->db->get_where(self::TB_NODES, array('node_id' => $node_id), 1)->row_array();
    }

    /**
     * 贴子数递增
     * @param $node_id
     * @param $field 递增的字段
     */
    public function set_increase($node_id, $field) {
        $this->db->set($field, $field.'+1',FALSE)->where('node_id',$node_id)->update(self::TB_NODES);
    }
}