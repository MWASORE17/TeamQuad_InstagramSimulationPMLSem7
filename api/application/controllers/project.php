<?php

class Project extends MY_Controller{
		
	
	function __construct(){
		parent::__construct();
		$this->load->model('mproject');
		$this->load->library('form_validation');
	}
	
	function index(){
		$data['title'] = 'Daftar Project';
		$data['c'] = $this->mproject->GetAll();
		// echo $this->db->last_query();
		
		$this->load->view('project/data', $data);
		
	}
	
	function add(){
		$data['edit'] = FALSE;
		
		$data['title'] = 'Tambah Project';
		// $data['c'] = $this->mproject->GetAll();
		// $data['parentcategory'] = $this->mproject->GetAll();
		$rules = array(
			
			array(
				'field'=>'ProjectName',
				'label'=>'Nama Project',
				'rules'=>'required'
			)
		);
		
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()){
			$ProjectNo = $this->mproject->lastid()+1;	
						
			$dataproject = array(
					COL_PROJECTID => $ProjectNo,
					COL_PROJECTNAME => $this->input->post('ProjectName'),
					COL_ISANYONECANVIEW => $this->input->post('IsAnyoneCanView'),
					COL_ISANYONECANADDTASK => $this->input->post('IsAnyoneCanAddTask'),
					COL_ISACTIVE => $this->input->post('IsActive'),
					COL_ISNOTIFONREPLY => $this->input->post('IsNotifOnReply'),
					COL_ISCOMMENTCLOSED => $this->input->post('IsCommentClosed'),
					COL_CREATEDON => date('Y-m-d H:i:s'),
					COL_CREATEDBY => GetUserLogin('UserName')
			);
			
			$this->mproject->insert($dataproject);
			
			redirect(site_url('project/edit/'.$ProjectNo)."?success=1");
		}else{
			$this->load->view('project/addproject', $data);
		}
		
	}

	function edit($id){
		$data['edit'] = TRUE;
		// $data['lastid'] = $this->mproject->lastid()+1;
		$data['title'] = 'Edit Project';
		$data['result'] = $this->mproject->GetByID($id)->row_array();
		
		$rules = array(
			array(
				'field'=>'ProjectNo',
				'label'=>'ID Project',
				'rules'=>'required'
			),
			array(
				'field'=>'ProjectName',
				'label'=>'Nama Project',
				'rules'=>'required'
			)
		);
		
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()){
			$ProjectNo = $this->input->post('ProjectNo');	
						
			$dataproject = array(
					COL_PROJECTID => $ProjectNo,
					COL_PROJECTNAME => $this->input->post('ProjectName'),
					COL_ISANYONECANVIEW => $this->input->post('IsAnyoneCanView'),
					COL_ISANYONECANADDTASK => $this->input->post('IsAnyoneCanAddTask'),
					COL_ISACTIVE => $this->input->post('IsActive'),
					COL_ISNOTIFONREPLY => $this->input->post('IsNotifOnReply'),
					COL_ISCOMMENTCLOSED => $this->input->post('IsCommentClosed'),
					COL_UPDATEON => date('Y-m-d'),
					COL_UPDATEBY => GetUserLogin('UserName')
			);
			
			$this->mproject->update($dataproject,$ProjectNo);
			
			redirect(site_url('project/edit/'.$ProjectNo)."?success=1");
		}else{
			$this->load->view('project/addproject', $data);
		}
		
	}

	function delete(){
		// CheckLogin();
		$data = $this->input->post('cekbox');

		$deleted = 0;
		$deletedcontent = "";

		for ($i=0; $i < count($data); $i++) {
			$row = $this->mproject->GetByID($data[$i]);
			
			if (CheckRow(TBL_TASKS, COL_PROJECTID, $data[$i])){
				$this->mproject->delete($data[$i]);
       			$deleted++;
			}
					
		}
		
		if($deleted){
			ShowJsonSuccess($deleted." data sudah dihapus");
			// redirect('category');
		}else{
			ShowJsonError($deleted." data belum dihapus");
		}
	}
	
}