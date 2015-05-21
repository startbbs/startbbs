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
     * @param $nid nodeid 版块id
     * @return mixed
     */
    public function get_cat($nid) {
        return $this->db->get_where(self::TB_NODES, array('node_id' => $nid), 1)->row_array();
    }
}