<?php

class MTask extends CI_Model{
	
	private $table = TBL_TASKS;
	private $tablefavorite = TBL_TASKFAVORITE;
	
	function __construct(){
		parent::__construct();
		
	}
	
	// function GetAll(){
		// $this->db->select();
		// return $this->db->get($this->table);
	// }
	
	function GetAll($param='',$param2=''){
		if(!empty($param)){	
			$this->db->where($param);
		}
		if(!empty($param2)){
			$this->db->order_by($param2);
		}
		$this->db->order_by(COL_TASKID,'asc');
		return $this->db->get($this->table);
	}
	
	function GetByID($id){
		
		$this->db->where(COL_TASKID, $id);
		$this->db->join(TBL_TASKRESOLUTIONS,TBL_TASKRESOLUTIONS.'.'.COL_TASKRESOLUTIONID.' = '.TBL_TASKS.'.'.COL_TASKRESOLUTIONID,'left');
		$this->db->join(TBL_TASKSEVERITIES,TBL_TASKSEVERITIES.'.'.COL_TASKSEVERITYID.' = '.TBL_TASKS.'.'.COL_TASKSEVERITYID,'left');
		$this->db->join(TBL_TASKTYPES,TBL_TASKTYPES.'.'.COL_TASKTYPEID.' = '.TBL_TASKS.'.'.COL_TASKTYPEID,'left');
		$this->db->join(TBL_TASKSTATUS,TBL_TASKSTATUS.'.'.COL_TASKSTATUSID.' = '.TBL_TASKS.'.'.COL_TASKSTATUSID,'left');
		$this->db->join(TBL_TASKPRIORITIES,TBL_TASKPRIORITIES.'.'.COL_TASKPRIORITYID.' = '.TBL_TASKS.'.'.COL_TASKPRIORITYID,'left');
		$this->db->join(TBL_CATEGORIES,TBL_CATEGORIES.'.'.COL_CATEGORYID.' = '.TBL_TASKS.'.'.COL_CATEGORYID,'left');
		$this->db->join(TBL_ATTACHMENTS,TBL_ATTACHMENTS.'.'.COL_REFERENCEID.' = '.TBL_TASKS.'.'.COL_TASKID,'left');
		return $this->db->get($this->table);
	}
	
	function insert($data){
		$this->db->insert($this->table,$data);
		return TRUE;
	}
	
	function lastid(){
		$this->db->limit(1);
		$this->db->order_by(COL_TASKID,'desc');
		$a = $this->db->get($this->table)->row_array();
		if(empty($a)){
			return 0;
		}
		return $a[COL_TASKID];
	}
	
	function update($data,$id){
		$this->db->where(COL_TASKID,$id);
		$this->db->update($this->table,$data);
		return TRUE;
	}
		
	function delete($id){
		if($id == "admin"){
			return FALSE;
		}
		$this->db->where(COL_TASKID,$id);
		$this->db->delete($this->table);
		return TRUE;
	}
	function GetAssignString($id){
		$str= "";
		$data = $this->db->where(COL_TASKID, $id)->get(TBL_TASKASSIGNMENTS);
		foreach ($data->result_array() as $dt) {
			$str .= $dt[COL_USERNAME].",";
		}
		return substr($str, 0, -1);
	}
	function GetLastComment($id){
		return $this->db->select(array(COL_CREATEDON,COL_DESCRIPTION,COL_CREATEDBY))->where(COL_TASKID,$id)->order_by(COL_CREATEDON,'desc')->limit(1)->get(TBL_COMMENTS);
	}
	function favorite($data){
		$this->db->insert($this->tablefavorite,$data);
		return TRUE;
	}
	function getfavorite($data,$id){
		return $this->db->where(COL_TASKID, $id)->where(COL_USERNAME, $data)->get($this->tablefavorite);
	}
}	