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

class stat_m extends SB_Controller {

    const TB_STAT = "site_stats";

    public function __construct() {
        parent::__construct();
    }

    public function get_list() {
        return $this->db->get(self::TB_STAT)->result_array();
    }


}