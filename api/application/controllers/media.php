<?php
/**
 * 
 */
class Media extends MY_Controller {
	var $msesi;
	var $madmin;
	
	function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('mattachment');
		
		$this->setPath_img_upload_folder("assets/images/media/");
        $this->setDelete_img_url(base_url().'media/deleteImage/');
        $this->setPath_url_img_upload_folder(base_url() . "assets/images/media/");
	}
	
	function GetJsonDetail(){
		$id = $this->input->post('id');
		$media = GetMedia($id);
		if(empty($media)){
			return "no";
		}else{
			echo json_encode($media);
		}
	}
	
	function index(){
		CheckLogin();
		$data['r'] = $this->mattachment->GetAll();
		$data['title'] = "Data Media";
		$this->load->view(VIEW_MEDIADATA,$data);
	}
	
	function select(){
		// CheckLogin();
		$data['r'] = $this->mattachment->GetAll();
		$this->load->view(VIEW_MEDIASELECT,$data);
	}
	
	function multiselect(){
		// CheckLogin();
		$data['r'] = $this->mattachment->GetAll();
		$this->load->view(VIEW_MEDIAMULTISELECT,$data);
	}
	
	function selectbypost(){
		// CheckLogin();
		$id = $this->input->post('id');
		
		$this->db->where('pi.'.COL_POSTID,$id);
		$this->db->join(TBL_POSTIMAGES.' pi','pi.'.COL_MEDIAID.' = p.'.COL_MEDIAID,'left');
		$data['r'] = $this->db->get(TBL_MEDIA." p");
		$this->load->view(VIEW_MEDIASELECT,$data);
	}
	
	function add(){
		CheckLogin();
		$data['edit'] = FALSE;
		$data['title']="Media";
		
		$rules = array(
			array(				
				'field'=>'MediaName',
				'label'=>'Media Name',
				'rules'=>'required'
				
			),
			array(				
				'field'=>'userfile',
				'label'=>'Gambar',
				'rules'=>'required'
				
			)
		);
		
		$this->form_validation->set_rules($rules);
		
		if($this->form_validation->run() == TRUE){
			$config['upload_path'] = './assets/images/media';
			$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|docx|xls|xlsx|ppt|pptx|rar|zip';
			$config['max_size']	= 0;
			$config['max_width']  = 0;
			$config['max_height']  = 0;
			
			$this->load->library('upload',$config);
			
            $filename = $_FILES["userfile"]["name"];
            if(strpos($filename, ".php") !== FALSE){
                echo "Now Allowed File Type";
                return;
            }
            
			if(!$this->upload->do_upload()){
				echo $this->upload->display_errors();
				return;
			}
			
			$dataupload = $this->upload->data();
			
			$last = $this->mattachment->lastid() + 1;
			
			$data = array(
					COL_MEDIAID => $last,
                    COL_MEDIANAME => $this->input->post('MediaName'),
					COL_MEDIAPATH => $dataupload['file_name'],
					COL_DESCRIPTION => $this->input->post('Description'),
					COL_CREATEDBY=>GetAdminLogin('UserName'),
					COL_CREATEDON=>date('Y-m-d H:i:s')
            );
			
			$this->mattachment->insert($data);
			
			if(MEDIA_AUTOWATERMARK && 1==2){
				$filepath = $dataupload['full_path'];
				
				$this->load->library('image_lib');
				$config['wm_text'] = MEDIA_AUTOWATERMARKTEXT;
				$config['wm_type'] = 'text';
				$config['wm_opacity'] = 1;
				$config['wm_font_path'] = './assets/fonts/'.MEDIA_AUTOWATERMARKFONT;
				$config['wm_font_size'] = MEDIA_AUTOWATERMARKSIZE;
				$config['wm_font_color'] = MEDIA_AUTOWATERMARKCOLOR;
				$config['wm_vrt_alignment'] = MEDIA_AUTOWATERMARKVERTICALPOSITION;
				$config['wm_hor_alignment'] = MEDIA_AUTOWATERMARKHORIZONTALPOSITION;
				$config['wm_padding'] = '5';
				
				$config['source_image'] = $filepath;
				
				$this->image_lib->initialize($config);
				$this->image_lib->watermark();
				$this->image_lib->clear();
			}
			
			redirect('media/edit/'.$last."?success=1");
		}else{
			$this->load->view(VIEW_MEDIAEDIT,$data);
		}
	}
	
	function addbulk(){
		$data['title'] = "Bulk Upload";
		$this->load->view(VIEW_MEDIAOLD_ADDBULK);
	}
	
	function bulked(){
		$file = $this->input->post('filearray');
		$data['json'] = json_decode($file);
		
		$this->load->view(VIEW_MEDIAUPLOADIFY,$data);
	}
	
	function edit($id){
		CheckLogin();
		$data['edit'] = TRUE;
		$data['title']="Media";
		
		$data['result'] = $result = $this->mattachment->GetAll(array(COL_MEDIAID=>$id))->row();
		$rules = array(
				array('field'=>'MediaName','label'=>'Merchandise Name','rules'=>'required')
		);
		$this->form_validation->set_rules($rules);
		
		if($this->form_validation->run() == TRUE){
			if(FileExtension_Check($result->MediaPath, 'gambar')){
				
				$config['upload_path'] = './assets/images/media';
				$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|docx|xls|xlsx|ppt|pptx';
				$config['max_size']	= MAX_SIZE_UPLOAD;
				$config['max_width']  = MAX_WIDTH_UPLOAD;
				$config['max_height']  = MAX_HEIGHT_UPLOAD;
				
				$data = array(
	                    COL_MEDIANAME => $this->input->post('MediaName'),
						COL_DESCRIPTION => $this->input->post('Description'),
						COL_UPDATEBY=>GetAdminLogin('UserName'),
						COL_UPDATEON=>date('Y-m-d H:i:s')
	            );
				
				if($_FILES['userfile']['name'] != ""){
					#echo "masuk sini";
					$this->load->library('upload',$config);
					$result = $this->mattachment->GetAll(array(COL_MEDIAID=>$id))->row();
					#echo $result;
					if($this->upload->do_upload()){
						if(is_file('./assets/images/media/'.$result->MediaPath)){
							unlink('./assets/images/media/'.$result->MediaPath);
						}
					}else{
						echo $this->upload->display_errors();
						return;
					}
					
					$dataupload = $this->upload->data();
					$data['MediaPath'] = $dataupload['orig_name'];
				}
				$this->mattachment->update($data,$id);
			}else{
				$data = array(
	                    COL_MEDIANAME => $this->input->post('MediaName'),
						COL_DESCRIPTION => $this->input->post('Description'),
						COL_UPDATEBY=>GetAdminLogin('UserName'),
						COL_UPDATEON=>date('Y-m-d H:i:s')
	            );
				$this->mattachment->update($data,$id);
			}

			redirect('media/edit/'.$id."?success=1");
		}else{
			$this->load->view(VIEW_MEDIAEDIT,$data);
		}
	}

	public function watermark(){
		$this->load->helper('file');
		$data['fonts'] = $fonts = get_filenames('./assets/fonts');
		$ids = $this->input->get('ids');
		if(empty($ids)){
			show_error("Tak ada data");
		}
		
		$ids = explode(",", $ids);
		if(count($ids) == 1){
			$result = $data['result'] = $result = $this->mattachment->GetAll(array(COL_MEDIAID=>$ids[0]))->row();
			$data['images'] = '<img src="'.base_url().'assets/images/media/'.$result->MediaPath.'" width="200" />';
		}else{
			$data['images'] = "<div style='width:400px;' class='info'>".count($ids)." Images</div>";
		}
		
		$this->load->library('form_validation');
		$rules = array(
					array(
						'field'=>'WatermarkText',
						'label'=>'Watermark Text',
						'rules'=>'required'
					)
		);
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()){
			$this->load->library('image_lib');
			$config['wm_text'] = $this->input->post('WatermarkText');
			$config['wm_type'] = 'text';
			$config['wm_opacity'] = $this->input->post('WatermarkOpacity');
			$config['wm_font_path'] = './assets/fonts/'.$this->input->post('WatermarkFont');
			$config['wm_font_size'] = $this->input->post('WatermarkSize');
			$config['wm_font_color'] = $this->input->post('WatermarkColor');
			$config['wm_vrt_alignment'] = $this->input->post('VerticalPosition');
			$config['wm_hor_alignment'] = $this->input->post('HorizontalPosition');
			$config['wm_padding'] = '5';
				
			foreach ($ids as $imageid) {
				$result = $result = $this->mattachment->GetAll(array(COL_MEDIAID=>$imageid))->row();
				
				$config['source_image'] = './assets/images/media/'.$result->MediaPath;
				
				if($this->input->post('KeepOldImage')){
					$config['new_image'] = './assets/images/media/wmd-'.$result->MediaPath;
					
					$last = $this->mattachment->lastid() + 1;
					$data = array(
							COL_MEDIAID => $last,
		                    COL_MEDIANAME => 'wmd-'.$result->MediaPath,
							COL_MEDIAPATH => 'wmd-'.$result->MediaPath,
							COL_DESCRIPTION => "watermarked"
		            );
					$this->mattachment->insert($data);
				}
				$this->image_lib->initialize($config);
				$this->image_lib->watermark();
				$this->image_lib->clear();
			}
			redirect(site_url('media')."?success=1");
		}else{
			$this->load->view(VIEW_MEDIAWATERMARK,$data);
		}
	}

	public function rotasi(){
		$ids = $this->input->get('ids');
		if(empty($ids)){
			show_error("Tak ada data");
		}
		$ids = explode(",", $ids);
		if(count($ids) == 1){
			$result = $data['result'] = $this->mattachment->GetAll(array(COL_MEDIAID=>$ids[0]))->row();
			$data['images'] = '<img src="'.base_url().'assets/images/media/'.$result->MediaPath.'" width="200" />';
		}else{
			$data['images'] = "<div style='width:400px;' class='info'>".count($ids)." Images</div>";
		}
		
		$this->load->library('form_validation');
		$rules = array(
					array(
						'field'=>'RotationTo',
						'label'=>'Rotation To',
						'rules'=>'required'
					)
		);
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()){
			$this->load->library('image_lib');
			$config['rotation_angle'] = $this->input->post('RotationTo');
				
			foreach ($ids as $imageid) {
				$result = $result = $this->mattachment->GetAll(array(COL_MEDIAID=>$imageid))->row();
				
				$config['source_image'] = './assets/images/media/'.$result->MediaPath;
				
				if($this->input->post('KeepOldImage')){
					$config['new_image'] = './assets/images/media/rotated-'.$result->MediaPath;
					
					$last = $this->mattachment->lastid() + 1;
					$data = array(
							COL_MEDIAID => $last,
		                    COL_MEDIANAME => 'rotated-'.$result->MediaPath,
							COL_MEDIAPATH => 'rotated-'.$result->MediaPath,
							COL_DESCRIPTION => "rotated"
		            );
					$this->mattachment->insert($data);
				}

				$this->image_lib->initialize($config);
				$this->image_lib->rotate();
				$this->image_lib->clear();
			}
			redirect(site_url('media')."?success=1");
		}else{
			$this->load->view(VIEW_MEDIAROTASI,$data);
		}
		
	}

	function crop($id){
		$this->load->library('image_lib');
		$result = $data['result'] = $this->mattachment->GetAll(array(COL_MEDIAID=>$id))->row();
		$images = $data['images'] = '<img class="img-responsive" src="'.base_url().'assets/images/media/'.$result->MediaPath.'" id="cropbox" alt="cropbox" />';
		
		$file = './assets/images/media/'.$result->MediaPath;
		
		//set image size to width and height varable
		list($width, $height) =  getimagesize($file);
		$data['orig_w'] = $width;
		$data['orig_h'] = $height;
		$data['targ_w'] = 150;		//expected thumbnail
		$data['targ_h'] = 150;
		$data['path'] = $file;
		
		$this->load->helper('file');
		$sizefile = ACTIVETHEMEPATH.'/image_sizes.json';
		if(is_file($sizefile)){
			$string = read_file($sizefile);
			$data['sizes'] = json_decode($string);
		}
		
		
		
		if($this->input->post('Submit') != ""){
			ini_set('memory_limit', '128M');
			
			$ratio = $this->input->post('ratio');
			
			$config['source_image'] = $file;
			$config['maintain_ratio'] = FALSE;
			#$config['image_library'] = 'gd2';
			$config['x_axis'] = $this->input->post('x')*$ratio;
			$config['y_axis'] = $this->input->post('y')*$ratio;
			$config['width'] = $this->input->post('w')*$ratio;
			$config['height'] = $this->input->post('h')*$ratio;
			
			if($this->input->post('KeepOldImage')){
				$prefix = time();
				$config['new_image'] = './assets/images/media/'.$prefix.'cpd-'.$result->MediaPath;
				$last = $this->mattachment->lastid() + 1;
				
				$data = array(
						COL_MEDIAID => $last,
	                    COL_MEDIANAME => $prefix.'cpd-'.$result->MediaPath,
						COL_MEDIAPATH => $prefix.'cpd-'.$result->MediaPath,
						COL_DESCRIPTION => "cpd"
		           );
				$this->mattachment->insert($data);
			}
			
			$this->image_lib->initialize($config);
			$this->image_lib->crop();
			$this->image_lib->clear();
			
			redirect(site_url('media')."?success=1");
		}else{
			$data['title'] = "Crop";
			$this->load->view(VIEW_MEDIACROP,$data);
		}
	}

	function SetDefault($id){
		CheckLogin();
		$this->mbasic->SetTable('merchandiseimages');
		$this->mbasic->SetPK('MerchandiseImageID');
		$row = $this->mbasic->GetRowByPK($id);
		$this->mbasic->SetTable('merchandises');
		$this->mbasic->SetPK('MerchandiseID');
		$this->mbasic->update(array(COL_DEFAULTIMAGE=>$row->ImagePath),$row->MerchandiseID);
	}
	
	function delete(){
		CheckLogin();
		$data = $this->input->post('cekbox');
		$deleted = 0;
		foreach ($data as $id) {
			$cek1 = CountRow(TBL_POSTIMAGES, array(COL_MEDIAID => $id));
			$cek2 = CountRow(TBL_PRODUCTDETAILS, array(COL_PRODUCTMEDIAID => $id));
			$cek3 = CountRow(TBL_USERINFORMATION, array(COL_PROFILEPICTURE => $id));
			$cek4 = CountRow(TBL_CATEGORIES, array(COL_CATEGORYMEDIAID => $id));
			$cek5 = CountRow(TBL_POSTDETAILS, array(COL_MEDIAID => $id));
			$cek6 = CountRow(TBL_LAYERSLIDERS, array(COL_MEDIAID => $id));
			$cek7 = CountRow(TBL_LAYERSLIDERDETAILS, array(COL_MEDIAID => $id));
			//$cek8 = $this->db->where(COL_SETTINGNAME,)
			
			if($cek1 || $cek2 || $cek3 || $cek4 || $cek5 || $cek6 || $cek7){
				continue;
			}
			
			$result = $this->mattachment->GetAll(array(COL_MEDIAID=>$id))->row();
			$this->mattachment->delete($id);
			$file = MY_UPLOADPATH."/".$result->MediaPath;
			if(is_file($file)){
				//@unlink($file);
			}
			$deleted++;
		}
		if($deleted){
			ShowJsonSuccess($deleted." data sudah dihapus");
		}else{
			ShowJsonError($deleted." data sudah dihapus");
		}
	}
	
	function upload(){
			// if(!IsUserLogin() && !IsLogin()){
				// // return;
			// }
			#CheckLogin();
			$id = $this->input->post('idgambar'); 
			
			
			$config['upload_path'] = './assets/images/media';
			$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|pdf|doc|docx|xls|xlsx|ppt|pptx|txt|sql|rar|zip|xml';
			$config['max_size']	= MAX_SIZE_UPLOAD;
			$config['max_width']  = MAX_WIDTH_UPLOAD;
			$config['max_height']  = MAX_HEIGHT_UPLOAD;
			$config['overwrite'] = FALSE;
			
			$filename = $_FILES['userfile']['name'];
			if(strpos($filename, ".php") !== FALSE){
                echo json_encode(array('error'=>"Not Allowed File Type"));
                return;
            }
            
			$valid_ext = array('jpg','jpeg','png','gif','bmp');
			$valid_extp = array('rar','zip');
			$ext = strtolower(end(explode('.', $_FILES['userfile']['name'])));
			if(!in_array($ext, $valid_ext)){
				$type = FILETYPE_FILE;
			}else{
				$type = FILETYPE_IMAGE;
			}
			
			// if(in_array($ext, $valid_ext)){
				// $type = FILETYPE_IMAGE;
			// }else if(in_array($ext, $valid_extp)){
				// $type = FILETYPE_PACKAGE;
			// }else{
				// $type = FILETYPE_FILE;
			// }
			
			$this->load->library('upload',$config);
			
			if(!$this->upload->do_upload()){
				echo json_encode( array('error'=>$this->upload->display_errors()) );
				return;
			}
			
			$dataupload = $this->upload->data();
			
			// if(MEDIA_AUTOWATERMARK){
				// $filepath = $dataupload['full_path'];
// 				
				// $this->load->library('image_lib');
				// $config['wm_text'] = MEDIA_AUTOWATERMARKTEXT;
				// $config['wm_type'] = 'text';
				// $config['wm_opacity'] = 1;
				// $config['wm_font_path'] = './assets/fonts/'.MEDIA_AUTOWATERMARKFONT;
				// $config['wm_font_size'] = MEDIA_AUTOWATERMARKSIZE;
				// $config['wm_font_color'] = MEDIA_AUTOWATERMARKCOLOR;
				// $config['wm_vrt_alignment'] = MEDIA_AUTOWATERMARKVERTICALPOSITION;
				// $config['wm_hor_alignment'] = MEDIA_AUTOWATERMARKHORIZONTALPOSITION;
				// $config['wm_padding'] = '5';
// 				
				// $config['source_image'] = $filepath;
// 				
				// $this->image_lib->initialize($config);
				// $this->image_lib->watermark();
				// $this->image_lib->clear();
			// }
			// if (empty($id)){
				$last = $this->mattachment->lastid() + 1;
				
				$data = array(
						COL_ATTACHMENTID => $last,
	                    COL_FILENAME => $dataupload['file_name'],
	                    COL_FILETYPE => $dataupload['file_type'],
	                    COL_FILESIZE => $dataupload['file_size'],
	                    COL_REFERENCEID => 0,
						
						// COL_MEDIAPATH => $dataupload['file_name'],
						// COL_DESCRIPTION => "",
						COL_UPLOADBY=>GetUserLogin('UserName'),
						COL_UPLOADON=>date('Y-m-d H:i:s')
	            );
				
				$this->mattachment->insert($data);
				
				$resp = array(
							'mediaid'=>$last,
							'mediapath'=>$dataupload['file_name'],
							'fullmediapath'=>base_url()."assets/images/media/".$dataupload['file_name'],
							'isimage' => $dataupload['is_image'],
							'type' => $type,
				);
				
				echo json_encode($resp);
			// }else{
				// $data = array(
// 						
	                    // COL_FILENAME => $dataupload['file_name'],
	                    // COL_FILETYPE => $dataupload['file_type'],
	                    // COL_FILESIZE => $dataupload['file_size'],
// 	                    
// 						
						// // COL_MEDIAPATH => $dataupload['file_name'],
						// // COL_DESCRIPTION => "",
						// COL_UPLOADBY=>GetUserLogin('UserName'),
						// COL_UPLOADON=>date('Y-m-d H:i:s')
	            // );
// 				
				// $this->mattachment->update($data,$id);
// 				
				// $resp = array(
							// 'mediaid'=>$id,
							// 'mediapath'=>$dataupload['file_name'],
							// 'fullmediapath'=>base_url()."assets/images/media/".$dataupload['file_name'],
							// 'isimage' => $dataupload['is_image']
				// );
// 				
				// echo json_encode($resp);
			// }	
	}

	function ppupload(){
			#CheckLogin();
			//$config['upload_path'] = MY_UPLOADPATH;
			//$config['allowed_types'] = '*';
			#$config['max_size']	= MAX_SIZE_UPLOAD;
			#$config['max_width']  = MAX_WIDTH_UPLOAD;
			#$config['max_height']  = MAX_HEIGHT_UPLOAD;
			//$config['overwrite'] = FALSE;
			
			$uid = uniqid(md5(mt_rand(10,100)), true); // this is our unique ID 
			$img = $_POST['image'];
			$img = str_replace('data:image/jpeg;base64,', '', $img);
			$img = str_replace(' ', '+', $img);
			$data = base64_decode($img);
			$filename = $uid.'.jpg';
			$uploaded = MY_UPLOADPATH.$filename;
			
			$success = file_put_contents($uploaded, $data);
			
			$last = $this->mattachment->lastid() + 1;
			
			$data = array(
					COL_MEDIAID => $last,
                    COL_MEDIANAME => $filename,
					COL_MEDIAPATH => $filename,
					COL_DESCRIPTION => "",
					COL_CREATEDBY=>GetAdminLogin('UserName'),
					COL_CREATEDON=>date('Y-m-d H:i:s')
            );
			
			$this->mattachment->insert($data);
			
			$resp = array(
						'mediaid'=>$last,
						'mediapath'=>$filename,
						'fullmediapath'=>media_url()."/".$filename,
						'isimage' => TRUE
			);
			
			echo json_encode($resp);
	}

	function fileupload(){
			#CheckLogin();
			$config['upload_path'] = './assets/images/media';
			$config['allowed_types'] = 'gif|jpg|jpeg|png|doc|docx|pdf';
			$config['max_size']	= MAX_SIZE_UPLOAD;
			$config['max_width']  = MAX_WIDTH_UPLOAD;
			$config['max_height']  = MAX_HEIGHT_UPLOAD;
			
			$this->load->library('upload',$config);
			
			if(!$this->upload->do_upload()){
				echo json_encode( array('error'=>$this->upload->display_errors()) );
				return;
			}
			
			$dataupload = $this->upload->data();
			
			$last = $this->mattachment->lastid() + 1;
			
			$data = array(
					COL_MEDIAID => $last,
                    COL_MEDIANAME => $dataupload['orig_name'],
					COL_MEDIAPATH => $dataupload['orig_name'],
					COL_DESCRIPTION => "",
					COL_CREATEDBY=>GetAdminLogin('UserName'),
					COL_CREATEDON=>date('Y-m-d H:i:s')
            );
			
			$this->mattachment->insert($data);
			
			$resp = array(
						'mediaid'=>$last,
						'mediapath'=>$dataupload['orig_name'],
						'fullmediapath'=>base_url()."assets/images/media/".$dataupload['orig_name']
			);
			
			echo json_encode($resp);
	}
	
	public function upload_img() {
		if(!IsUserLogin() && !IsLogin()){
			return;
		}

        //Format the name
        $name = $_FILES['userfile']['name'];
        $name = strtr($name, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');

        // replace characters other than letters, numbers and . by _
        $name = preg_replace('/([^.a-z0-9]+)/i', '_', $name);

        //Your upload directory, see CI user guide
        $config['upload_path'] = $this->getPath_img_upload_folder();
  
        $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|docx|xls|xlsx|ppt|pptx';
        $config['max_size'] = GetSetting('MaxFileSize');

       //Load the upload library
        $this->load->library('upload', $config);

       if ($this->do_upload()) {
            
            // Codeigniter Upload class alters name automatically (e.g. periods are escaped with an
            //underscore) - so use the altered name for thumbnail
            $data = $this->upload->data();
            $name = $data['file_name'];

            //If you want to resize 
            /*
            $config['new_image'] = $this->getPath_img_upload_folder();
            $config['image_library'] = 'gd2';
            $config['source_image'] = $this->getPath_img_upload_folder() . $name;
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 193;
            $config['height'] = 94;

			 * 
			 */
			 
            #$this->load->library('image_lib', $config);

            #$this->image_lib->resize();

            //Get info 
            $info = new stdClass();
            
            $info->name = $name;
            $info->size = $data['file_size'];
            $info->type = $data['file_type'];
            $info->url = $this->getPath_img_upload_folder() . $name;
            #$info->thumbnail_url = $this->getPath_img_thumb_upload_folder() . $name; //I set this to original file since I did not create thumbs.  change to thumbnail directory if you do = $upload_path_url .'/thumbs' .$name
            $info->delete_url = $this->getDelete_img_url() . $name;
            $info->delete_type = 'DELETE';
			
			$last = $this->mattachment->lastid() + 1;
			
			$data = array(
					COL_MEDIAID => $last,
                    COL_MEDIANAME => $name,
					COL_MEDIAPATH => $name,
					COL_DESCRIPTION => "",
					COL_CREATEDBY=>GetAdminLogin('UserName'),
					COL_CREATEDON=>date('Y-m-d H:i:s')
            );
			
			$this->mattachment->insert($data);

           //Return JSON data
           if ($this->input->is_ajax_request()) {   //this is why we put this in the constants to pass only json data
                echo json_encode(array($info));
                //this has to be the only the only data returned or you will get an error.
                //if you don't give this a json array it will give you a Empty file upload result error
                //it you set this without the if(IS_AJAX)...else... you get ERROR:TRUE (my experience anyway)
            } else {   // so that this will still work if javascript is not enabled
                $file_data['upload_data'] = $this->upload->data();
                echo json_encode(array($info));
            }
        } else {

           // the display_errors() function wraps error messages in <p> by default and these html chars don't parse in
           // default view on the forum so either set them to blank, or decide how you want them to display.  null is passed.
            $error = array('error' => $this->upload->display_errors('',''));
            echo json_encode(array($error));
        }
       }
//Function for the upload : return true/false
  public function do_upload() {

        if (!$this->upload->do_upload()) {
            return false;
        } else {
            //$data = array('upload_data' => $this->upload->data());
            return true;
        }
     }


//Function Delete image
    public function deleteImage() {

        //Get the name in the url
        $file = $this->uri->segment(3);
        
        $success = unlink($this->getPath_img_upload_folder() . $file);
        #$success_th = unlink($this->getPath_img_thumb_upload_folder() . $file);

        //info to see if it is doing what it is supposed to	
        $info = new stdClass();
        $info->sucess = $success;
        $info->path = $this->getPath_url_img_upload_folder() . $file;
        $info->file = is_file($this->getPath_img_upload_folder() . $file);
        
		$this->db->delete(TBL_MEDIA,array(COL_MEDIAPATH=>$file));
		
        if ($this->input->is_ajax_request()) {//I don't think it matters if this is set but good for error checking in the console/firebug
            echo json_encode(array($info));
        } else {     //here you will need to decide what you want to show for a successful delete
            var_dump($file);
        }
    }


//Load the files
    public function get_files() {

        $this->get_scan_files();
    }

//Get info and Scan the directory
    public function get_scan_files() {

        $file_name = isset($_REQUEST['file']) ?
                basename(stripslashes($_REQUEST['file'])) : null;
        if ($file_name) {
            $info = $this->get_file_object($file_name);
        } else {
            $info = $this->get_file_objects();
        }
        header('Content-type: application/json');
        echo json_encode($info);
    }

    protected function get_file_object($file_name) {
        $file_path = $this->getPath_img_upload_folder() . $file_name;
        if (is_file($file_path) && $file_name[0] !== '.') {

            $file = new stdClass();
            $file->name = $file_name;
            $file->size = filesize($file_path);
            $file->url = $this->getPath_url_img_upload_folder() . rawurlencode($file->name);
            $file->thumbnail_url = $this->getPath_url_img_thumb_upload_folder() . rawurlencode($file->name);
            //File name in the url to delete 
            $file->delete_url = $this->getDelete_img_url() . rawurlencode($file->name);
            $file->delete_type = 'DELETE';
            
            return $file;
        }
        return null;
    }

//Scan
       protected function get_file_objects() {
        return array_values(array_filter(array_map(
             array($this, 'get_file_object'), scandir($this->getPath_img_upload_folder())
                   )));
    }



// GETTER & SETTER 


    public function getPath_img_upload_folder() {
        return $this->path_img_upload_folder;
    }

    public function setPath_img_upload_folder($path_img_upload_folder) {
        $this->path_img_upload_folder = $path_img_upload_folder;
    }

    public function getPath_img_thumb_upload_folder() {
        return $this->path_img_thumb_upload_folder;
    }

    public function setPath_img_thumb_upload_folder($path_img_thumb_upload_folder) {
        $this->path_img_thumb_upload_folder = $path_img_thumb_upload_folder;
    }

    public function getPath_url_img_upload_folder() {
        return $this->path_url_img_upload_folder;
    }

    public function setPath_url_img_upload_folder($path_url_img_upload_folder) {
        $this->path_url_img_upload_folder = $path_url_img_upload_folder;
    }

    public function getPath_url_img_thumb_upload_folder() {
        return $this->path_url_img_thumb_upload_folder;
    }

    public function setPath_url_img_thumb_upload_folder($path_url_img_thumb_upload_folder) {
        $this->path_url_img_thumb_upload_folder = $path_url_img_thumb_upload_folder;
    }

    public function getDelete_img_url() {
        return $this->delete_img_url;
    }

    public function setDelete_img_url($delete_img_url) {
        $this->delete_img_url = $delete_img_url;
    }
	
	
}
?>
