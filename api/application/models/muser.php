<?php

class MUser extends CI_Model{
	
	private $table = TBL_USERS;
	private $role = TBL_ROLES;
	
	function __construct(){
		parent::__construct();
		
	}
	function insert($data){
		$this->db->insert($this->table,$data);
		return TRUE;
	}
	
	function update($data, $id){
		$this->db->where(COL_USERNAME,$id);
		$this->db->update($this->table,$data);
		return TRUE;		
	}
	
	function delete($id){
		$this->db->where(COL_USERNAME, $id);	
		$this->db->delete($this->table);
		return true;
	}
	
	function GetAllUser($param='',$param2=''){
		if(!empty($param)){
			$this->db->where($param);
		}
		if(!empty($param2)){
			$this->db->order_by($param);
		}
		
		$this->db->select();
		$this->db->join($this->role,$this->role.'.'.COL_ROLEID.' = '.$this->table.'.'.COL_ROLEID,'LEFT');
		return $this->db->get($this->table);
	}
	
	function GetAll($param='',$param2=''){
		if(!empty($param)){
			$this->db->where($param);
		}
		if(!empty($param2)){
			$this->db->order_by($param);
		}
		// $this->db->join($this->role.', '.$this->role.' .RoleNo = '.$this->table.'.RoleNo','LEFT');
		return $this->db->get($this->table);
	}
	
	function GetUserNotAdmin(){
		$query = 'select *from '.$this->table.' where '.COL_USERNAME.' != "admin" ';
		return $this->db->query($query);
		
	}
	function GetByID($id){
		$this->db->select();
		$this->db->where(COL_USERNAME, $id);
		return $this->db->get($this->table);
	}
	
	function IsUsernameExist($username){
		$cek = $this->db->where('username',$username)->get($this->table)->num_rows();
		if($cek < 1){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	function IsSuspend($username){
		$cek = $this->db->where('UserName',$username)->where('IsSuspend',1)->get($this->table)->num_rows();
		if($cek < 1){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	function CheckLogin($username,$password){
		$query = "SELECT * FROM ".$this->table." where UserName = '".$username."' AND Password = '".md5($password)."'";
		
		$cek = $this->db->query($query)->num_rows();
		$res = $this->db->query($query)->row();
		if($cek > 0){
			return $res->UserName;
		}else{
			return FALSE;
		}
	}
	
	function CheckUserName($username){
		$this->db->select();
		$this->db->where(COL_USERNAME, $username);
		$hasil = $this->db->get($this->table);
		if ($hasil->num_rows() > 0){
			return FALSE;
		}
		return TRUE;
	}
}
