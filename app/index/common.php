<?php
use Think\facade\Cache;
/**
 * 获取头像
 * @param int $id
 * @param string $size
 * @return mixed
 */
function get_avatar($id,$size='middle')
{
	$savepath = '/public/uploads/avatar/';
	$folder = substr($id, -1);
	$avatar=$savepath.$folder.'/'.$id.'_'.$size.'.png';
	$file = str_replace('\\', '/', ROOT_PATH . $avatar);
	if(is_file($file)){
		return $avatar;
	}else{
		return '/public/uploads/avatar/default_'.$size.'.png';
	}
}
/**
 * 获取分类名
 * @param int $id
 * @param string $size
 * @return mixed
 */
function get_category_name($cid)
{
	$category_list= Cache::get('category_list');
	foreach($category_list as $v)
	{
		if($v['id']==$cid){
			return $v['name'];
		}
	}
}