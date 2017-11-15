<?php

class TaskType extends MY_Controller{
		
	
	function __construct(){
		parent::__construct();
		
		$this->load->model('mtasktype');
		$this->load->library('form_validation');
	}
	
	function index(){
		$data['title'] = 'Daftar Jenis Tugas';
		$data['c'] = $this->mtasktype->GetAll();
		// echo $this->db->last_query();
		$this->load->view('tasktype/data', $data);
	}
	
	function add(){
		$data['edit'] = FALSE;
		// $data['lastid'] = $this->mtasktype->lastid()+1;
		$data['title'] = 'Tambah Jenis Tugas';
		$data['c'] = $this->mtasktype->GetAll();
		// $data['parenttask'] = $this->mtasktype->GetAll();
		$rules = array(
			// array(
				// 'field'=>'TaskTypeID',
				// 'label'=>'Jenis Tugas',
				// 'rules'=>'required'
			// ),
			array(
				'field'=>'TaskTypeName',
				'label'=>'Nama Jenis Tugas',
				'rules'=>'required'
			)
		);
		
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()){
			$TaskTypeID = $this->mtasktype->lastid()+1;	
			$TaskTypeName = $this->input->post('TaskTypeName');
			$Order = $this->input->post('Order');
			
			$datatasktype = array(
					COL_TASKTYPEID => $TaskTypeID,
					COL_TASKTYPENAME => $TaskTypeName,
					COL_ORDER => $Order
			);
			
			$this->mtasktype->insert($datatasktype);
			
			redirect(site_url('tasktype/edit/'.$TaskTypeID)."?success=1");
		}else{
			$this->load->view('tasktype/form', $data);
		}
		
	}
	
	function edit($id){
		$data['edit'] = TRUE;
		$data['title'] = 'Edit Jenis Tugas';
		$data['result'] = $this->mtasktype->GetByID($id)->row_array();
		// $data['parenttask'] = $this->mtasktype->GetAll();
		
		$rules = array(
			// array(
				// 'field'=>'TaskTypeID',
				// 'label'=>'Jenis Tugas',
				// 'rules'=>'required'
			// ),
			array(
				'field'=>'TaskTypeName',
				'label'=>'Nama Jenis Tugas',
				'rules'=>'required'
			)
		);
		
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()){
			$TaskTypeID = $this->input->post('TaskTypeID');	
			$TaskTypeName = $this->input->post('TaskTypeName');
			$Order = $this->input->post('Order');
			
			$datatasktype = array(
					COL_TASKTYPEID => $TaskTypeID,
					COL_TASKTYPENAME => $TaskTypeName,
					COL_ORDER => $Order
			);
			
			$this->mtasktype->update($datatasktype,$TaskTypeID);
			
			
			redirect(site_url('tasktype/edit/'.$TaskTypeID)."?success=1");
		}else{
			$this->load->view('tasktype/form', $data);
		}
		
	}
	function delete(){
		// CheckLogin();
		$data = $this->input->post('cekbox');

		$deleted = 0;
		$deletedcontent = "";

		for ($i=0; $i < count($data); $i++) {
			$row = $this->mtasktype->GetByID($data[$i]);
			
			if (CheckRow(TBL_TASKS, COL_TASKTYPEID, $data[$i])){
				$this->mtasktype->delete($data[$i]);
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