<?php

class Version extends MY_Controller{
		
	
	function __construct(){
		parent::__construct();
		
		$this->load->model('mversions');
		$this->load->library('form_validation');
	}
	
	function index(){
		$data['title'] = 'Daftar Version';
		$data['c'] = $this->mversions->GetAll();
		// echo $this->db->last_query();
		$this->load->view('version/data', $data);
	}
	
	function add(){
		$data['edit'] = FALSE;
		// $data['lastid'] = $this->mversions->lastid();
		$data['title'] = 'Tambah Version';
		$data['c'] = $this->mversions->GetAll();
		// $data['parenttask'] = $this->mtasktype->GetAll();
		$rules = array(
			array(
				'field'=>'VersionName',
				'label'=>'Nama Version',
				'rules'=>'required'
			),
		);
		
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()){
			$VersionsID = $this->mversions->lastid()+1;	
			
			$dataver = array(
					COL_VERSIONID => $VersionsID,
					COL_VERSIONNAME => $this->input->post('VersionName'),
			);
			
			$this->mversions->insert($dataver);
			
			redirect(site_url('version/edit/'.$VersionsID)."?success=1");
		}else{
			$this->load->view('version/form', $data);
		}
		
	}
	
	function edit($id){
		$data['edit'] = TRUE;
		$data['title'] = 'Edit Version';
		$data['result'] = $this->mversions->GetByID($id)->row_array();
		// $data['parenttask'] = $this->mtasktype->GetAll();
		
		$rules = array(
			array(
				'field'=>'VersionName',
				'label'=>'Nama Version',
				'rules'=>'required'
			),
		);
		
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()){
			$VersionsID = $this->input->post('VersionID');	
			$dataver = array(
					// COL_VERSIONID => $VersionsID,
					COL_VERSIONNAME => $this->input->post('VersionName'),
			);
			
			
			$this->mversions->update($dataver,$VersionsID);
			
			
			redirect(site_url('version/edit/'.$VersionsID)."?success=1");
		}else{
			$this->load->view('version/form', $data);
		}
		
	}
	function delete(){
		// CheckLogin();
		$data = $this->input->post('cekbox');

		$deleted = 0;
		$deletedcontent = "";

		for ($i=0; $i < count($data); $i++) {
			$row = $this->mversions->GetByID($data[$i]);
			
			if (CheckRow(TBL_TASKS, COL_VERSIONID, $data[$i])){
				$this->mversions->delete($data[$i]);
				$deleted++;
			}
			
		}
		
		if($deleted){
			ShowJsonSuccess($deleted." data sudah dihapus");
			// redirect('task');
		}else{
			ShowJsonError($deleted." data belum dihapus");
		}
	}
	
}