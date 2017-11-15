<?php

class MCategory extends CI_Model{
	
	private $table = TBL_CATEGORIES;
	
	function __construct(){
		parent::__construct();
		
	}
	
	function GetAll(){
		$this->db->select();
		return $this->db->get($this->table);
	}
	
	function GetByID($id){
		$this->db->select();
		$this->db->where(COL_CATEGORYID, $id);
		
		return $this->db->get($this->table)->row();
	}
	
	function insert($data){
		$this->db->insert($this->table,$data);
		return TRUE;
	}
	
	function lastid(){
		$this->db->limit(1);
		$this->db->order_by(COL_CATEGORYID,'desc');
		$a = $this->db->get($this->table)->row();
		if(empty($a)){
			return 0;
		}
		return $a->CategoryID;
	}
	
	function update($data,$id){
		$this->db->where(COL_CATEGORYID,$id);
		$this->db->update($this->table,$data);
		return TRUE;
	}
		
	function delete($id){
		// if($id == "admin"){
			// return FALSE;
		// }
		$this->db->where(COL_CATEGORYID,$id);
		$this->db->delete($this->table);
		return TRUE;
	}
}	