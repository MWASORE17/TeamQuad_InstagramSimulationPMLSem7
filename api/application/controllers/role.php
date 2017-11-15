<?php

class Role extends MY_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->model('mrole');
		$this->load->model('mroleprivilege');
		$this->load->library('form_validation');
	}
	
	function index(){
		$data['title'] = 'Daftar Role';
		$data['c'] = $this->mrole->GetAll();
		
		$this->load->view('role/data', $data);
		
	}
	
	function add(){
		// $data['edit'] = FALSE;
		// $data['lastid'] = $this->mrole->lastid()+1;
		$data['title'] = 'Tambah Role';
		// $data['c'] = $this->mproject->GetAll();
		// $data['parentcategory'] = $this->mproject->GetAll();
		$rules = array(
			// array(
				// 'field'=>'RoleID',
				// 'rules'=>'required'
			// ),
			array(
				'field'=>'RoleName',
				'label'=>'Nama Role',
				'rules'=>'required'
			)
		);
		
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()){
			
			$RoleID =  $this->mrole->lastid()+1;
			$datarole = array(
					COL_ROLEID => $RoleID,
					COL_ROLENAME => $this->input->post('RoleName'),
					
			);
			
			$this->mrole->insert($datarole);
			
			redirect(site_url('role/edit/'.$RoleID)."?success=1");
		}else{
			$this->load->view(VIEW_ROLEADD, $data);
		}
		
	}

	function edit($id){
		$data['edit'] = TRUE;
		// $data['lastid'] = $this->mproject->lastid();
		$data['title'] = 'Edit Role';
		$data['result'] = $this->mrole->GetByID($id)->row_array();
		$data['modules'] = $this->db->order_by(COL_MODULENAME,'asc')->get(TBL_MODULES);
		$data['othermodules'] = $this->db->order_by(COL_OTHERMODULENAME,'asc')->get(TBL_OTHERMODULES);
		
		$rules = array(
			
			array(
				'field'=>'RoleName',
				'label'=>'Nama Role',
				'rules'=>'required'
			)
		);
		
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()){
			$insertdata = array(
				COL_ROLENAME=>$this->input->post('RoleName')
			);
			$this->mrole->update($insertdata,$id);
			
			$privileges = $this->input->post('modules');
			$this->db->delete(TBL_ROLEPRIVILEGES,array(COL_ROLEID=>$id));
			if(is_array($privileges)){
				foreach ($privileges as $privilege) {
					$dataprivilege = array(
						COL_ROLEID => $id,
						COL_MODULEID => $privilege,
						COL_INSERT => $this->input->post($privilege."-Buat"),
						COL_UPDATE => $this->input->post($privilege."-Ubah"),
						COL_DELETE => $this->input->post($privilege."-Hapus"),
						COL_VIEW => $this->input->post($privilege."-Lihat")
					);
					$this->db->insert(TBL_ROLEPRIVILEGES,$dataprivilege);
				}
			}
			
			$otherprivileges = $this->input->post('othermodules');
			$this->db->delete(TBL_ROLEOTHERMODULES,array(COL_ROLEID=>$id));
			if(is_array($otherprivileges)){
				foreach ($otherprivileges as $privilege) {
					$dataprivilege = array(
						COL_ROLEID => $id,
						COL_OTHERMODULEID => $privilege
					);
					$this->db->insert(TBL_ROLEOTHERMODULES,$dataprivilege);
				}
			}
			
			redirect(site_url('role/edit/'.$id)."?success=1");
		}else{
			$this->load->view(VIEW_ROLEEDIT, $data);
		}
		
	}

	function delete(){
		// CheckLogin();
		$data = $this->input->post('cekbox');

		$deleted = 0;
		$deletedcontent = "";

		for ($i=0; $i < count($data); $i++) {
			$row = $this->mproject->GetByID($data[$i]);
			
			$this->mproject->delete($data[$i]);
            $deleted++;
		}
		
		if($deleted){
			ShowJsonSuccess($deleted." data sudah dihapus");
			// redirect('category');
		}else{
			ShowJsonError($deleted." data belum dihapus");
		}
	}
}
