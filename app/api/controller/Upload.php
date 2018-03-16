<?php
namespace app\api\controller;

use think\Controller;
use Session;
use Db;
use image\Image;
use Cache;
use Env;

/**
 * 通用上传接口
 * Class Upload
 * @package app\api\controller
 */
class Upload extends Controller
{
    protected function initialize()
    {
        parent::initialize();
        define('ROOT_PATH',Env::get('root_path'));
        //if (!Session::has('admin_id')) {
        //    $result = [
        //        'error'   => 1,
        //        'message' => '未登录'
        //    ];

        //    return json($result);
        //}
    }

    /**
     * 通用图片上传接口
     * @return \think\response\Json
     */
    public function upload()
    {
        $config = [
            'size' => 2097152,
            'ext'  => 'jpg,gif,png,bmp'
        ];

        $file = $this->request->file('file');

        $upload_path = str_replace('\\', '/', ROOT_PATH . 'public/uploads');
        $save_path   = '/uploads/';
        $info        = $file->validate($config)->move($upload_path);

        if ($info) {
            $result = [
                'error' => 0,
                'url'   => str_replace('\\', '/', $save_path . $info->getSaveName())
            ];
        } else {
            $result = [
                'error'   => 1,
                'message' => $file->getError()
            ];
        }

        return json($result);
    }
    /**
     * 头像上传接口
     * @return \think\response\Json
     */
    public function avatar()
    {
        $config = [
            'size' => 102400,
            'ext'  => 'jpg,gif,png,bmp'
        ];

        $file = $this->request->file('file');
        $user_id=Session::get('user_id');
		$folder=substr($user_id, -1);
        $upload_path = str_replace('\\', '/', ROOT_PATH . 'public/uploads/avatar/'.$folder.'/');
        $save_path   = '/public/uploads/avatar/'.$folder.'/';
		if (! file_exists ($upload_path)) {
		        mkdir ($upload_path, 0777, true );
		}
        $image = Image::open($file);
		$info=$image->thumb(192, 192)->save($upload_path.$user_id.'_large.png');
		$image->thumb(96, 96)->save($upload_path.$user_id.'_middle.png');
		$image->thumb(48, 48)->save($upload_path.$user_id.'_small.png');
        if ($info) {
            $result = [
                'error' => 0,
                'url'   => str_replace('\\', '/', $save_path . $user_id.'_large.png')
            ];
            Db::name('user')->where('id',Session::get('user_id'))->update(['avatar'=>$save_path . $user_id]);
            Session::set('avatar',$save_path.$user_id.'_small.png');
        } else {
            $result = [
                'error'   => 1,
                'message' => $file->getError()
            ];
        }

        return json($result);
    }


    /**
     * 附件上传接口
     * @return \think\response\Json
     */
    public function attach()
    {
        $config = [
            'size' => 2097152,
            'ext'  => 'jpg,gif,png,bmp'
        ];
        $file = $this->request->file('file');
        $attach = $this->request->post('attach');

        $upload_path = str_replace('\\', '/', ROOT_PATH . 'public/uploads/tmp/'.$attach);
        $save_path   = '/public/uploads/tmp/'.$attach.'/';
        $info        = $file->validate($config)->rule('uniqid')->move($upload_path);
       
        if ($info) {
            $result = [
                'success' => true,
                'file_path' => str_replace('\\', '/', $save_path . $info->getSaveName()),
                'msg' => '上传成功！'
            ];

	        $cache_file=Cache::get($attach);
	        $info_array=$info->getInfo();
	        $file_info=[array(
				'name'=>$info_array['name'],
				'type'=>$info_array['type'],
				'size'=>$info_array['size'],
				'savename'=>$info->getFilename()
	        )];
            if($cache_file){
	            $cache_file=array_merge_recursive($cache_file,$file_info);
            }else{
	            $cache_file=$file_info;
            }
            Cache::set($attach,$cache_file,3600);

        } else {
            $result = [
                'success'   => false,
                'msg' => $file->getError()
            ];
        }        
        return json($result);
    }
    /**
     * 多文件上传接口
     * @return \think\response\Json
     */
    public function mutiupload()
    {
        $config = [
            'size' => 209715,
            'ext'  => 'jpg,gif,png,bmp'
        ];
        $uploadfiles = $this->request->file('files');
        $atoken=$this->request->post('atoken');
        $upload_path = str_replace('\\', '/', ROOT_PATH . 'public/uploads/attachment/');
        $save_path   = '/public/uploads/attachment/';
		foreach($uploadfiles as $k=>$file){
	        $info=$file->validate($config)->rule('set_savename')->move($upload_path);
	        if ($info) {
				$files[]=str_replace('\\', '/', $save_path . $info->getSaveName());
				$messages[] = 'File ' .$info->getSaveName() . ' was uploaded';
	            //入库
	        } else {
	            $messages[] =$file->getError();
	        }
        } 
        $cache_files=Cache::get('{$atoken}');
        if($cache_files){
	        $cache_files=array_merge($cache_files,$files);
	    }else{
		    $cache_files=$files;
	    }
        Cache::set('{$atoken}',$cache_files,3600);
        $result = [
        	"success" =>true,
		    "data" => [
		    	"baseurl"=>'http://127.0.0.12',
		        "code" => 220,
		        "files" => $files,
		        "messages"=>$messages
		    ],
		    'time' =>time()
        ];
        return json($result);
    }

    /**
     * 栏目上传接口
     * @return \think\response\Json
     */
    public function category()
    {
        $config = [
            'size' => 10240,
            'ext'  => 'jpg,gif,png,bmp'
        ];

        $file = $this->request->file('file');
        $cid=$this->request->post('cid');
        $upload_path = str_replace('\\', '/', ROOT_PATH . 'public/uploads/category/');
        $save_path   = '/public/uploads/category/';
		if (! file_exists ($upload_path)) {
		        mkdir ($upload_path, 0777, true );
		}
        $image = Image::open($file);
		$info=$image->thumb(192, 192)->save($upload_path.$cid.'.png');
        if ($info) {
            $result = [
                'error' => 0,
                'url'   => str_replace('\\', '/', $save_path .$cid.'.png')
            ];
        } else {
            $result = [
                'error'   => 1,
                'message' => $file->getError()
            ];
        }

        return json($result);
    }
    
}