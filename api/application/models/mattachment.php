<?php
	/**
	 * 
	 */
	class MAttachment extends CI_Model {
		var $table = TBL_ATTACHMENTS;
		function __construct() {
			parent::__construct();
		}
		function insert($data){
			$this->db->insert($this->table,$data);
			return TRUE;
		}
		function lastid(){
			$this->db->limit(1);
			$this->db->order_by(COL_ATTACHMENTID,'desc');
			$a = $this->db->get($this->table)->row_array();
			if(empty($a)){
				return 0;
			}
			return $a[COL_ATTACHMENTID];
		}
		
		function GetAll($param='',$param2=''){
			if(!empty($param)){	
				$this->db->where($param);
			}
			if(!empty($param2)){
				$this->db->order_by($param);
			}
			$this->db->order_by(COL_ATTACHMENTID,'asc');
			return $this->db->get($this->table." p");
		}
		function GetOrder(){
			$this->db->order_by(COL_ORDER,'asc');
			return $this->db->get($this->table." p");
		}
		function update($data,$id){
			$this->db->update($this->table,$data,array(COL_ATTACHMENTID=>$id));
			return TRUE;
		}
		function deleteReference($param=''){
			$this->db->where($param);
			$this->db->delete($this->table);
			return true;
		}
		function delete($id){
			$this->db->delete($this->table,array(COL_ATTACHMENTID=>$id));
			return TRUE;
		}
		function clearfromtask($taskid,$delete=false){
			$dataupdate = array(
								COL_REFERENCEID => null
			);
			$this->db->update('attachments',$dataupdate,array(COL_REFERENCEID => $taskid,COL_MODULEID => MODULTASK));
		}
		function clearfromcomment($commentid){
			$dataupdate = array(
								COL_REFERENCEID => null
			);
			$this->db->update('attachments',$dataupdate,array(COL_REFERENCEID => $commentid,COL_MODULEID => MODULCOMMENT));
		}
	}
?>