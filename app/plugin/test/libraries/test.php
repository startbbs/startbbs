<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class Test {

    public function index()
    {
	    $ci = &get_instance();
	    return $ci->config->item('words');
    }
}

/* End of file test.php */