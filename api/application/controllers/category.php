<?php

class Category extends MY_Controller{
		
	
	function __construct(){
		parent::__construct();
		
		$this->load->model('mcategory');
		$this->load->library('form_validation');
	}
	
	function index(){
		$data['title'] = 'Daftar Kategori';
		$data['c'] = $this->mcategory->GetAll();
		// echo $this->db->last_query();
		$this->load->view('category/data', $data);
	}
	
	function add(){
		$data['edit'] = FALSE;
		// $data['lastid'] = $this->mcategory->lastid();
		$data['title'] = 'Tambah Kategori';
		$data['c'] = $this->mcategory->GetAll();
		$data['parentcategory'] = $this->mcategory->GetAll();
		$rules = array(
			array(
				'field'=>'CategoryName',
				'label'=>'Nama Kategori',
				'rules'=>'required'
			),
			array(
				'field'=>'ParentCategory',
				'label'=>'Parent Kategori',
				'rules'=>'required'
			),
		);
		
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()){
			$lastid = $this->mcategory->lastid()+1;
			// $idKategori = $this->input->post('CategoryID');	
			$namaKategori = $this->input->post('CategoryName');
			$parentKategori = $this->input->post('ParentCategory');
			
			$datakategori = array(
					COL_CATEGORYID => $lastid,
					COL_CATEGORYNAME => $namaKategori,
					COL_PARENTCATEGORYID => $parentKategori
			);
			
			$this->mcategory->insert($datakategori);
			
			redirect(site_url('category/edit/'.$lastid)."?success=1");
		}else{
			$this->load->view('category/addcategory', $data);
		}
		
	}
	
	function edit($id){
		$data['edit'] = TRUE;
		$data['title'] = 'Edit Kategori';
		$data['result'] = $this->mcategory->GetByID($id);
		$data['parentcategory'] = $this->mcategory->GetAll();
		// $data['result'] = $this->mpost->GetAllAuction(array('p.'.COL_POSTID=>$id))->row();
		$rules = array(
			array(
				'field'=>'CategoryName',
				'label'=>'Nama Kategori',
				'rules'=>'required'
			),
			array(
				'field'=>'ParentCategory',
				'label'=>'Parent Kategori',
				'rules'=>'required'
			),
		);
		
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()){
			$idKategori = $this->input->post('CategoryID');	
			$namaKategori = $this->input->post('CategoryName');
			$parentKategori = $this->input->post('ParentCategory');
			
			$datakategori = array(
					COL_CATEGORYID => $idKategori,
					COL_CATEGORYNAME => $namaKategori,
					COL_PARENTCATEGORYID => $parentKategori
			);
			
			$this->mcategory->update($datakategori,$idKategori);
			
			redirect(site_url('category/edit/'.$idKategori)."?success=1");
		}else{
			$this->load->view('category/addcategory', $data);
		}
		
	}
	function delete(){
		// CheckLogin();
		$data = $this->input->post('cekbox');

		$deleted = 0;
		$deletedcontent = "";

		for ($i=0; $i < count($data); $i++) {
			$row = $this->mcategory->GetByID($data[$i]);
			
			if (CheckRow(TBL_CATEGORIES, COL_PARENTCATEGORYID, $data[$i])){
				if (CheckRow(TBL_TASKS, COL_CATEGORYID, $data[$i])){
					$this->mcategory->delete($data[$i]);
					$deleted++;
				}
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