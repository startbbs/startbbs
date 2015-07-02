<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('br2nl'))
{
	function br2nl($text)
	{
		return preg_replace('/<br\\s*?\/??>/i', '', $text);
	}
}

/* End of file br2nl_helper.php */
/* Location: ./system/helpers/br2nl_helper.php */