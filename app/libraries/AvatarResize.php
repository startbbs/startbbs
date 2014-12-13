<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class AvatarResize {

    var $avatar_dir;
    var $uid;
    var $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->library('image_lib');
        $this->uid = $this->CI->session->userdata('uid');
        $this->avatar_dir = $this->set_dir();
    }

    /**
     * 设置目录
     */
    function set_dir() {
 		$uid = sprintf ( "%02d", $this->uid);
		$dir1 = substr ( $uid, -1, 1 );
		$dir2 = substr ( $uid, -2, 2 );
        $path = FCPATH.'uploads/avatar/'. $dir1 . '/' . $dir2. '/';
        if(!file_exists($path)){
            mkdir($path,0777,true);
        }
        return $path;
    }

    /**
     * 获得目录
     */
    function get_dir() {
 		$uid = sprintf ( "%02d", $this->uid);
		$dir1 = substr ( $uid, -1, 1 );
		$dir2 = substr ( $uid, -2, 2 );
        $path = 'uploads/avatar/'. $dir1 . '/'.$dir2 . '/'. $this->uid . '_';
        return $path;
    }

    /**
     * resize用户头像
     * @param   $source 源文件路径
     * @param   $width  宽度
     * @param   $height 高度
     * @param   $size   size名称
     */
    public function resize($source, $width, $height, $size)
    {
        $config['image_library'] = 'gd2';
        $config['source_image'] = $source;
        $config['maintain_ratio'] = false;
        $config['width'] = $width;
        $config['height'] = $height;
        $config['new_image'] = $this->avatar_dir . $this->uid . '_' . $size .'.png';
        $config['master_dim'] = 'auto';

        $this->CI->image_lib->initialize($config);
        return $this->CI->image_lib->resize();
        $this->CI->image_lib->clear();
    }
}

/* End of file AvatarResize.php */
/* Location: ./application/libraries/AvatarResize.php */
