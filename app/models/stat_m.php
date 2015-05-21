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

    public function get_item($item) {
        return $this->db->get_where(self::TB_STAT, array('item' => $item), 1)->row_array();
    }
}