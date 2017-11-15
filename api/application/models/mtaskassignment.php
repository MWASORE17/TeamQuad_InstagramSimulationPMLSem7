<?php

class MTaskAssignment extends CI_Model{
	
	private $table = TBL_TASKASSIGNMENTS;
	
	function __construct(){
		parent::__construct();
		
	}
	
	function GetAll(){
		$this->db->select();
		return $this->db->get($this->table);
	}
	
	function GetByID($id){
		$this->db->select();
		$this->db->where(COL_TASKASSIGNMENTID, $id);
		
		return $this->db->get($this->table);
	}
	function GetByTaskID($id){
		$this->db->select();
		$this->db->where(COL_TASKID, $id);
		return $this->db->get($this->table);
	}
	
	function insert($data){
		$this->db->insert($this->table,$data);
		return TRUE;
	}
	
	function lastid(){
		$this->db->limit(1);
		$this->db->order_by(COL_TASKASSIGNMENTID,'desc');
		$a = $this->db->get($this->table)->row_array();
		if(empty($a)){
			return 0;
		}
		return $a[COL_TASKASSIGNMENTID];
	}
	
	
	function update($data,$id){
		$this->db->where(COL_TASKASSIGNMENTID,$id);
		$this->db->update($this->table,$data);
		return TRUE;
	}
		
	function delete($id){
		if($id == "admin"){
			return FALSE;
		}
		$this->db->where(COL_TASKASSIGNMENTID,$id);
		$this->db->delete($this->table);
		return TRUE;
	}
	function DeleteAssign($taskid){
		$this->db->delete($this->table,array(COL_TASKID=>$taskid));
		return TRUE;
	}
}	