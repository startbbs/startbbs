<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * cache.php
 *
 * @author  :  Skiychan <dev@skiy.net>
 * @created :  2015/7/8
 * @modified:  
 * @version :  0.0.1
 */

class cache_m extends SB_Model {

    public function __contruct() {
        parent::__construct();
    }

    /**
     * @param $theme 风格
     * @param $page 页面
     */
    public function del($theme, $page) {
        $this->db->cache_delete("/".$theme, $page);
    }
}