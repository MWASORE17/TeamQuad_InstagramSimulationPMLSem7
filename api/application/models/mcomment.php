<?php

class MComment extends CI_Model{
	
	private $table = TBL_COMMENTS;
	
	function __construct(){
		parent::__construct();
		
	}
	
	function GetAll($param='',$param2=''){
		$this->db->select();
		if(!empty($param)){
			$this->db->where($param);
		}
		if(!empty($param2)){
			$this->db->order_by($param2);
		}
		$this->db->order_by(COL_CREATEDON,'asc');
		return $this->db->get($this->table);
	}
	
	
	function insert($data){
		$this->db->insert($this->table,$data);
		return TRUE;
	}
	
	function lastid(){
		$this->db->limit(1);
		$this->db->order_by(COL_COMMENTID,'desc');
		$a = $this->db->get($this->table)->row_array();
		if(empty($a)){
			return 0;
		}
		return $a[COL_COMMENTID];
	}
	
	function update($data,$id){
		$this->db->where(COL_COMMENTID,$id);
		$this->db->update($this->table,$data);
		return TRUE;
	}
		
	function delete($id){
		if($id == "admin"){
			return FALSE;
		}
		$this->db->where(COL_COMMENTID,$id);
		$this->db->delete($this->table);
		return TRUE;
	}
	function deleteByTask($taskid){
		$this->db->where(COL_TASKID,$taskid);
		$this->db->delete($this->table);
		return TRUE;
	}
	function GetByID($id){
		$this->db->select();
		$this->db->where(COL_COMMENTID, $id);
		return $this->db->get($this->table);
	}
}	
