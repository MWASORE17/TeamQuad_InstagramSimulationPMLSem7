<?php

class MTaskResolution extends CI_Model{
	
	private $table = TBL_TASKRESOLUTIONS;
	
	function __construct(){
		parent::__construct();
		
	}
	
	function GetAll(){
		$this->db->select();
		return $this->db->get($this->table);
	}
	
	function GetByID($id){
		$this->db->select();
		$this->db->where(COL_TASKRESOLUTIONID, $id);
		
		return $this->db->get($this->table);
	}
	
	function insert($data){
		$this->db->insert($this->table,$data);
		return TRUE;
	}
	
	function lastid(){
		$this->db->limit(1);
		$this->db->order_by(COL_TASKRESOLUTIONID,'desc');
		$a = $this->db->get($this->table)->row_array();
		if(empty($a)){
			return 0;
		}
		return $a[COL_TASKRESOLUTIONID];
	}
	
	function update($data,$id){
		$this->db->where(COL_TASKRESOLUTIONID,$id);
		$this->db->update($this->table,$data);
		return TRUE;
	}
		
	function delete($id){
		if($id == "admin"){
			return FALSE;
		}
		$this->db->where(COL_TASKRESOLUTIONID,$id);
		$this->db->delete($this->table);
		return TRUE;
	}
}	