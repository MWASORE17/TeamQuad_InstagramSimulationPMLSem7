<?php

class News extends MY_Controller{
		
	
	function __construct(){
		parent::__construct();
		
		$this->load->model('mnews');
		$this->load->library('form_validation');
	}
	
	function index(){
		$data['title'] = 'Daftar Berita';
		$data['c'] = $this->mnews->GetAll();
		// echo $this->db->last_query();
		$this->load->view('news/data', $data);
	}
	
	function add(){
		$data['edit'] = FALSE;
		// $data['lastid'] = $this->mnews->lastid();
		$data['title'] = 'Tambah Berita';
		$data['c'] = $this->mnews->GetAll();
		// $data['parenttask'] = $this->mtasktype->GetAll();
		$rules = array(
			array(
				'field'=>'NewsTitle',
				'label'=>'Judul Berita',
				'rules'=>'required'
			),
			array(
				'field'=>'Description',
				'label'=>'Isi Berita',
				'rules'=>'required'
			)
		);
		
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()){
			$NewsID = $this->mnews->lastid()+1;	
			
			$datanews = array(
					COL_NEWSID => $NewsID,
					COL_NEWSTITLE => $this->input->post('NewsTitle'),
					COL_DESCRIPTION => $this->input->post('Description'),
					COL_STARTEDDATE => $this->input->post('StartedDate'),
					COL_EXPIREDDATE => $this->input->post('ExpiredDate'),
					COL_CREATEDBY => GetUserLogin("UserName"),
					COL_CREATEDON => date("Y-m-d")
			);
			
			$this->mnews->insert($datanews);
			
			redirect(site_url('news/edit/'.$NewsID)."?success=1");
		}else{
			$this->load->view('news/form', $data);
		}
		
	}
	
	function edit($id){
		$data['edit'] = TRUE;
		$data['title'] = 'Edit Berita';
		$data['result'] = $this->mnews->GetByID($id)->row_array();
		// $data['parenttask'] = $this->mtasktype->GetAll();
		
		$rules = array(
			array(
				'field'=>'NewsTitle',
				'label'=>'Judul Berita',
				'rules'=>'required'
			),
			array(
				'field'=>'Description',
				'label'=>'Isi Berita',
				'rules'=>'required'
			)
		);
		
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()){
			$NewsID = $this->input->post('NewsID');	
			$datanews = array(
					COL_NEWSID => $NewsID,
					COL_NEWSTITLE => $this->input->post('NewsTitle'),
					COL_DESCRIPTION => $this->input->post('Description'),
					COL_STARTEDDATE => $this->input->post('StartedDate'),
					COL_EXPIREDDATE => $this->input->post('ExpiredDate'),
					COL_UPDATEBY => GetUserLogin("UserName"),
					COL_UPDATEON => date("Y-m-d")
			);
			
			
			$this->mnews->update($datanews,$NewsID);
			
			
			redirect(site_url('news/edit/'.$NewsID)."?success=1");
		}else{
			$this->load->view('news/form', $data);
		}
		
	}
	function delete(){
		// CheckLogin();
		$data = $this->input->post('cekbox');

		$deleted = 0;
		$deletedcontent = "";

		for ($i=0; $i < count($data); $i++) {
			$row = $this->mnews->GetByID($data[$i]);
			
			$this->mnews->delete($data[$i]);
			$deleted++;
		}
		
		if($deleted){
			ShowJsonSuccess($deleted." data sudah dihapus");
			// redirect('task');
		}else{
			ShowJsonError($deleted." data belum dihapus");
		}
	}
	function view($id){
		$data['news'] = $this->mnews->GetByID($id)->row_array();
		
		$this->load->view('news/view', $data);
	}
	
}