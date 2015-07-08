<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Markdown.php
 *
 * @author  :  Skiychan <dev@skiy.net>
 * @created :  2015/7/8
 * @modified:  
 * @version :  0.0.1
 */

require_once dirname(__FILE__) . '/MarkdownExtra.inc.php';

class Michelf extends MarkdownExtra {

    public function __construct() {
        parent::__construct();
    }

    /**
     * markdown转格式
     * @param $text 内容
     * @return string
     */
    public function convert($text) {
        return $this->transform($text);
    }
}