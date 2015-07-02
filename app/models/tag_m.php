<?php

#doc
#	classname:	Tag_m
#	scope:		PUBLIC
#	StartBBS起点轻量开源社区系统
#	author :doudou QQ:858292510 startbbs@126.com
#	Copyright (c) 2013 http://www.startbbs.com All rights reserved.
#/doc

class Tag_m extends SB_Model
{

	function __construct ()
	{
		parent::__construct();

	}

	// 获取远程
	function sb_get_contents($url,$timeout=100,$referer=''){
		if(function_exists('curl_init')){
			$ch = curl_init();
			curl_setopt ($ch, CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT,$timeout);
			if($referer){
				curl_setopt ($ch, CURLOPT_REFERER, $referer);
			}		
			$content = curl_exec($ch);
			curl_close($ch);
			if($content){
				return $content;
			}		
		}
		$ctx = stream_context_create(array('http'=>array('timeout'=>$timeout)));
		$content = @file_get_contents($url, 0, $ctx);
		if($content){
			return $content;
		}
		return false;
	}

	//TAG分词自动获取
	function get_tag_auto($title,$content){
		$data = $this->sb_get_contents('http://keyword.discuz.com/related_kw.html?ics=utf-8&ocs=utf-8&title='.rawurlencode($title).'&content='.rawurlencode(mb_substr($content,0,500)));
		if($data) {
			$parser = xml_parser_create();
			xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
			xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
			xml_parse_into_struct($parser, $data, $values, $index);
			xml_parser_free($parser);
			$kws = array();
			foreach($values as $valuearray) {
				if($valuearray['tag'] == 'kw') {
					if(strlen($valuearray['value']) > 3){
						$kws[] = trim($valuearray['value']);
					}
				}elseif($valuearray['tag'] == 'ekw'){
					$kws[] = trim($valuearray['value']);
				}
			}
			return implode(',',$kws);
		}
		return false;
	}

	//入库Tag
	public function insert_tag($data,$topic_id)
	{
		if(!empty($data)){
			$arr = explode(',',$data);
			if(is_array($arr)){
				foreach( $arr as $k => $v ){
					$info=$this->db->where('tag_title',$v)->get('tags')->row_array();
					if(empty($info)){
						$this->db->set('tag_title',trim($v));
						$this->db->set('topics','topics+1',false);
						$this->db->insert('tags');
						$tid = $this->db->insert_id();
						$this->db->insert('tags_relation', array('tag_id'=>$tid, 'topic_id'=>$topic_id));
						
					} else{
						$info_relation= $this->db->get_where('tags_relation', array('tag_id'=>$info['tag_id'], 'topic_id'=>$topic_id))->row_array();
						if(empty($info_relation)){
							$this->db->insert('tags_relation', array('tag_id'=>$info['tag_id'], 'topic_id'=>$topic_id));
							$this->db->set('topics', 'topics+1', false)->where('tag_id', $info['tag_id'])->update('tags');
						}
					}
				}
			}
			return true;
		}
	} 
	//X条相关贴子
	public function get_related_topics_by_tag($tags,$limit) 
	{
		$get_tag_ids = $this->db->select('tag_id')->where_in('tag_title',$tags)->get('tags')->result_array();
		foreach($get_tag_ids as $k => $v){
			$tag_ids[]=$v['tag_id'];
		}
		$tag_ids = implode(',',$tag_ids);		
		if($tag_ids){
			$this->db->select('a.topic_id, a.title')
			->from('topics a')
			->join('tags_relation b','a.topic_id=b.topic_id')
			->join('tags c','b.tag_id=c.tag_id')
			->where_in('c.tag_id',$tag_ids)
			->limit($limit);
			return $query=$this->db->get()->result_array();
			
		} else {
			return false;
		}
	}
	//tag贴子列表
	public function get_tag_topics_list($page,$limit,$tag_title)
	{
		$tag = $this->db->select('tag_id')->where('tag_title',$tag_title)->get('tags')->row_array();
		if($tag){
			$this->db->select('a.topic_id, a.title, a.comments, a.is_top, a.updatetime, b.uid, b.username, b.avatar')
			->from('topics a')
			->join('users b','a.uid=b.uid')
			->join('tags_relation c','a.topic_id=c.topic_id')
			->join('tags d','c.tag_id=d.tag_id')
			->where('d.tag_id',$tag['tag_id'])
			->limit($limit,$page);
			$query=$this->db->get();
			return $query->result_array();
		} else {
			return false;
		}

	}
	//最新tag列表
	public function get_latest_tags($num)
	{
		$this->db->select('tag_id, tag_title')->order_by('tag_id','desc')->limit($num);
		$query = $this->db->get('tags');
		if($query->num_rows>0){
			return $query->result_array();
		}
		
	}
	//tag分页列表
	public function get_tag_list($page,$limit)
	{
		$this->db->select('*')->order_by('tag_id','desc')->limit($limit,$page);
		$query = $this->db->get('tags');
		if($query->num_rows>0){
			return $query->result_array();
		}
		
	}


}
