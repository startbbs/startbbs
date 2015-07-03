<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class db_admin extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		/** 检查登陆 */
		if(!$this->auth->is_admin())
		{
			show_message('非管理员或未登录',site_url('admin/login/do_login'));
		}
	}

	public function index ()
	{
		$data['title'] = '数据库管理';
		$data['table_list']= $this->db->list_tables();
		$data['act']=$this->uri->segment(3);
		
		if($_POST){
			$tables=$this->input->post();
			$this->load->dbutil();
			for($i=0;$i<=12;$i++){
				if($this->input->post('optimize')){
					if($this->dbutil->optimize_table($tables[$i]))
					$this->session->set_flashdata('error', '优化表成功!');
					redirect('admin/db_admin/index');
				}
				if($this->input->post('repair')){
					if($this->dbutil->repair_table($tables[$i]))
					$this->session->set_flashdata('error', '修复表成功!');
					redirect('admin/db_admin/index');
				}
			}
			
		}
		$data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['csrf_token'] = $this->security->get_csrf_hash();
		$this->load->view('db_admin', $data);
		
	}

	public function backup()
	{
		$data['title'] = '数据库备份';
		$data['table_list']= $this->db->list_tables();
		$data['act']=$this->uri->segment(3);
		if($_POST){
			$tables=$this->input->post();
			for($i=0;$i<=12;$i++){
				$new_tables[]=$tables[$i];
			}
			//echo var_export($new_tables);
			$prefs = array(
			    'tables'      => $new_tables,
			    'ignore'      => array(),
			    'format'      => 'txt',
			    'filename'    => 'mybackup.sql', 
			    'add_drop'    => TRUE,
			    'add_insert'  => TRUE,
			    'newline'     => "\n"
			);
			$this->load->dbutil();
			$backup=$this->dbutil->backup($prefs);
			//$file='mysql'.time().'.sql';
			$lenth=rand(10,20);
			$file=randkey($lenth).'.sql';
			if(write_file(FCPATH.'data/db/'.$file, $backup)){
				$this->session->set_flashdata('error', '备份数据库'.$file.'成功!');
				redirect('admin/db_admin/backup');
			}
			
		}
		$data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['csrf_token'] = $this->security->get_csrf_hash();
		$this->load->view('db_admin', $data);
	}

	public function restore($sqlfile='')
	{
		$data['title'] = '数据库还原';
		$data['act']=$this->uri->segment(3);
		$data['sqlfiles'] = get_dir_file_info(FCPATH.'data/db', $top_level_only = TRUE);
		//echo var_dump($data['sqlfiles']);
		if($_POST){
			$sqlfiles=array_slice($this->input->post(), 0, -1);
			//echo var_export($sqlfiles);
			foreach($sqlfiles as $k=>$v){
				unlink(FCPATH.'data/db/'.$v);
			}
			$this->session->set_flashdata('error', '删除sql文件成功!');
			redirect('admin/db_admin/restore');
		}
		if($sqlfile){
			$sql  = file_get_contents(FCPATH.'data/db/'.$sqlfile);
			if($this->run_sql($sql)){
				$this->session->set_flashdata('error', '还原sql文件成功!');
				redirect('admin/db_admin/restore');
			}
		}
		$data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['csrf_token'] = $this->security->get_csrf_hash();
		$this->load->view('db_admin', $data);
	}

	

	public function sql()
	{
		# code...
	}


 	private function run_sql($sql) {
	    $sqls   = $this->sql_split($sql);
		$result = 0;
		if(is_array($sqls)) {
			foreach($sqls as $sql) {
				if(trim($sql) != '') {
					$this->db->query($sql);
					$result += mysql_affected_rows();
				}
			}
		} else {
			$this->db->query($sqls);
			$result += mysql_affected_rows();
		}
		return $result;
	}
	
 	private function sql_split($sql) {
		$sql = str_replace("\r", "\n", $sql);
		$ret = array();
		$num = 0;
		$queriesarray = explode(";\n", trim($sql));
		unset($sql);
		foreach($queriesarray as $query) {
			$ret[$num] = '';
			$queries = explode("\n", trim($query));
			$queries = array_filter($queries);
			foreach($queries as $query) {
				$str1 = substr($query, 0, 1);
				if($str1 != '#' && $str1 != '-') $ret[$num] .= $query;
			}
			$num++;
		}
		return($ret);
	}

	
}